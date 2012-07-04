<?php
App::uses('PostsController', 'Controller');
App::uses('Post', 'Model');

class TestPost extends Post{

	public $name = 'Post';
	public $alias = 'Post';

	public $conditions = array();

	public function beforeFind($queryData) {
		$queryData = parent::beforeFind($queryData);
		$this->conditions = $queryData;
		return false;
	}

}

/**
 * TestPostsController
 */
class TestPostsController extends PostsController {

	public $name = 'Posts';
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * PostsController Test Case
 *
 */
class PostsControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
			'app.post',
			'app.user',
			'app.media',
			'app.category',
			'app.tag',
			'app.posts_category',
			'app.posts_tag'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$request = new CakeRequest(null, false);
		$response  = new CakeResponse();
		$this->Controller = new TestPostsController($request,$response);
		$this->Controller->constructClasses();
		$this->Controller->Components->init($this->Controller);
		Router::reload();
		require APP . 'Config' . DS . 'routes.php';

		$this->Post = ClassRegistry::init('Post');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		$this->Controller->Session->destroy();
		unset($this->Controller);
		unset($this->Post);
		ClassRegistry::flush();
		parent::tearDown();
	}

/**
 * @test
 *
 * @return void
 */
	public function prefixがない場合はis_activeコンディションを追加() {
		$TestPost= new TestPost();
		$this->Controller->Post = $TestPost;
		$this->Controller->request->addParams(Router::parse('/posts/index'));
		Router::setRequestInfo($this->Controller->request);
		$this->Controller->startupProcess();
		$this->Controller->index();

		$results = $this->Controller->Post->conditions['conditions'];

		$this->assertArrayHasKey('Post.is_publish',$results);

	}
/**
 * test
 *
 * @return void
 */
	public function indexのビューのテスト() {
		$this->Controller->request->addParams(Router::parse('/'));
		Router::setRequestInfo($this->Controller->request);
		$this->Controller->startupProcess();
		$this->Controller->index();

		//ビューのテスト
		$renderer = $this->Controller->render('index')->body();

		$this->assertRegExp("/<form action=\"\/blog\/posts\/search\"/", $renderer);
		$this->assertRegExp("/name=\"subject\"/", $renderer);
		$this->assertRegExp("/name=\"tags\"/", $renderer);
		$this->assertRegExp("/name=\"time_from\[year\]\"/", $renderer);
		$this->assertRegExp("/name=\"time_from\[month\]\"/", $renderer);
		$this->assertRegExp("/name=\"time_from\[day\]\"/", $renderer);
		$this->assertRegExp("/name=\"time_to\[year\]\"/", $renderer);
		$this->assertRegExp("/name=\"time_to\[month\]\"/", $renderer);
		$this->assertRegExp("/name=\"time_to\[day\]\"/", $renderer);

		$this->assertNotRegExp("/posts\/edit/", $renderer);
		$this->assertNotRegExp("/posts\/add/", $renderer);
		$this->assertNotRegExp("/posts\/delete/", $renderer);



		$this->assertArrayHasKey('category',$this->Controller->viewVars);
		$this->assertArrayHasKey('tag',$this->Controller->viewVars);


	}

/**
 * @test search method
 *
 * @return void
 */
	public function 検索コンディションのチェック() {
		$TestPost= new TestPost();
		$this->Controller->Post = $TestPost;

		$this->Controller->request->addParams(Router::parse('/posts/search'));

		$_SERVER['REQUEST_METHOD'] = 'GET';

		//Test1
		$this->Controller->request->query= array(
			'subject'=>'テスト検索',
			'time_from'=>array(
					'year'=>2011,
					'month'=>01,
					'day'=>01
			),
			'time_to'=>array(
					'year'=>2011,
					'month'=>02,
					'day'=>01
			),
			'tags'=>'php'
		);
		$this->Controller->startupProcess();
		$this->Controller->search();
		$expects = array(
		'Post.subject LIKE' => '%テスト検索%',
		0 => array(
			0 => 'Post.id in (SELECT `Tag`.`id` FROM `blog_tags` AS `Tag`   WHERE `Tag`.`name` = \'php\')',
		),
		'Post.is_publish' => 1,
		'Post.created BETWEEN ? AND ?' => array(
				0 => 1293807600,
				1 => 1296572399,
			),
		);
		$this->assertEqual($expects,$TestPost->conditions['conditions']);
	}
/**
 * @test search method
 *
 * @return void
 */
	public function 検索コンディションのサニタイズチェック() {
		$TestPost= new TestPost();
		$this->Controller->Post = $TestPost;

		$this->Controller->request->addParams(Router::parse('/posts/search'));

		$_SERVER['REQUEST_METHOD'] = 'GET';

		//Test1
		$this->Controller->request->query= array(
			'subject'=>'<h1>テスト検索</h1>',
			'time_from'=>array(
					'year'=>2011,
					'month'=>01,
					'day'=>01
			),
			'time_to'=>array(
					'year'=>2011,
					'month'=>02,
					'day'=>01
			),
			'tags'=>'php'
		);
		$this->Controller->startupProcess();
		$this->Controller->search();
		$expects = array(
		'Post.subject LIKE' => '%&lt;h1&gt;テスト検索&lt;/h1&gt;%',
		0 => array(
			0 => 'Post.id in (SELECT `Tag`.`id` FROM `blog_tags` AS `Tag`   WHERE `Tag`.`name` = \'php\')',
		),
		'Post.is_publish' => 1,
		'Post.created BETWEEN ? AND ?' => array(
				0 => 1293807600,
				1 => 1296572399,
			),
		);
		$this->assertEqual($expects,$TestPost->conditions['conditions']);
	}


/**
 * @test admin_index method
 *
 * @return void
 */
	public function admin_index() {
		//ログイン状態でないとリダイレクト
		$this->Controller->request->addParams(Router::parse('/admin/posts/index'));
		Router::setRequestInfo($this->Controller->request);
		$this->Controller->startupProcess();
		$this->Controller->admin_index();
		$expects = array(
			'controller'=>'users',
			'action'=>'admin_login'
		);
		$this->assertEqual('/admin/users/login',$this->Controller->redirectUrl);

	}

/**
 * 非公開記事のデータプロバイダー
 * @see PostFixture.yml
 */
	public static function unPublishPostsID() {
		return array(
				array('2'),
				array('3'),
			);
	}
/**
 * @test view method
 * @dataProvider unPublishPostsID 
 * @expectedException NotFoundException
 */
	public function 非公開の記事にアクセス($action) {
		$this->Controller->request->addParams(Router::parse('/posts/view/'.$action));
		$this->Controller->startupProcess();
		$this->Controller->view($action);
	}

/**
 * @test admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->Controller->Session->write('Auth.User',array('id'=>1,'name'=>'adminuser'));
		$this->Controller->request->addParams(Router::parse('/admin/posts/add'));
		Router::setRequestInfo($this->Controller->request);
		$this->Controller->startupProcess();
		$this->Controller->admin_add();

		//ビューのテスト
		$renderer = $this->Controller->render('admin_add')->body();

		$this->assertRegExp("/data\[Post\]\[subject\]/", $renderer);
		$this->assertRegExp("/data\[Post\]\[body\]/", $renderer);
		$this->assertRegExp("/data\[Post\]\[is_publish\]/", $renderer);
		$this->assertRegExp("/data\[Post\]\[created\]\[year\]/", $renderer);
		$this->assertRegExp("/data\[Post\]\[created\]\[month\]/", $renderer);
		$this->assertRegExp("/data\[Post\]\[created\]\[day\]/", $renderer);
		$this->assertRegExp("/data\[Category\]\[Category\]\[\]/", $renderer);
		$this->assertRegExp("/data\[Tag\]\[Tag\]\[\]/", $renderer);

	}
/**
 * @test admin_add method
 *
 * @return void
 */
	public function admin_add_新規保存() {
		$this->Controller->Session->write('Auth.User',array('id'=>1,'name'=>'adminuser'));
		$this->Controller->request->addParams(Router::parse('/admin/posts/add'));
		Router::setRequestInfo($this->Controller->request);
		$this->Controller->startupProcess();

		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->assertTrue($this->Controller->request->is('post'));

		$this->Controller->request->data = array(
			'Post' =>array(
				'subject'=>'記事のテスト',
				'body'=>'記事のテスト本文',
				'is_publish'=>1
			),
			'Category'=>array(
				'Category'=>array(1)
			),
			'Tag'=>array(
				'Tag'=>array(1)
			)
		);
		$this->Controller->admin_add();
		$this->assertFalse($this->Controller->validateErrors());
		$actual = $this->Controller->Post->read(null,$this->Controller->Post->getLastInsertID());
		unset($actual['Post']['created']);
		unset($actual['Post']['modified']);
		$expects  = array(
			'Post' => array(
				'id' => '4',
				'user_id' => '1',
				'subject' => '記事のテスト',
				'body' => '記事のテスト本文',
				'is_publish' => true,
			),
			'User' => array(
				'id' => '1',
				'name' => '管理者',
			),
			'Category' => array(
				array(
				'id' => '1',
				'parent_id' => NULL,
				'lft' => NULL,
				'rght' => NULL,
				'name' => 'PHP',
				'post_count' => '0',
				'PostsCategory' => array(
					'id' => '2',
					'post_id' => '4',
					'category_id' => '1',
					),
				),
			),
			'Tag' => array(
				array(
				'id' => '1',
				'name' => 'タグ1',
				'post_count' => '0',
				'PostsTag' => array(
					'id' => '2',
					'post_id' => '4',
					'tag_id' => '1',
					),
				),
			),
		);
		$this->assertEqual($expects,$actual);

	}

/**
 * @test
 *
 * @return void
 */
	public function admin_edit() {
		$this->Controller->Session->write('Auth.User',array('id'=>1,'name'=>'adminuser'));
		$this->Controller->request->addParams(Router::parse('/admin/posts/edit/1'));
		Router::setRequestInfo($this->Controller->request);
		$this->Controller->startupProcess();
		$this->Controller->admin_edit(1);

		$this->assertEqual($this->Post->read(null,1),$this->Controller->request->data);
		$this->assertArrayHasKey('users',$this->Controller->viewVars);
		$this->assertArrayHasKey('tags',$this->Controller->viewVars);
		$this->assertArrayHasKey('categories',$this->Controller->viewVars);

		//ビューのテスト
		$renderer = $this->Controller->render('admin_edit')->body();

		$this->assertRegExp("/data\[Post\]\[id\]/", $renderer);
		$this->assertRegExp("/data\[Post\]\[user_id\]/", $renderer);
		$this->assertRegExp("/data\[Post\]\[subject\]/", $renderer);
		$this->assertRegExp("/data\[Post\]\[body\]/", $renderer);
		$this->assertRegExp("/data\[Post\]\[is_publish\]/", $renderer);
		$this->assertRegExp("/data\[Category\]\[Category\]\[\]/", $renderer);
		$this->assertRegExp("/data\[Tag\]\[Tag\]\[\]/", $renderer);

	}


}
