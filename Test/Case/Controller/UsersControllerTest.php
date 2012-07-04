<?php
App::uses('UsersController', 'Controller');
App::uses('User', 'Model');

/**
 * TestUsersController *
 */
class TestUsersController extends UsersController {

	public $name = 'Users';

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
 * UsersController Test Case
 *
 */
class UsersControllerTestCase extends CakeTestCase {
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
			'app.category_post',
			'app.tag',
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

		$this->Controller = new TestUsersController($request, $response);

		$this->Controller->constructClasses();
		Router::reload();
		require APP . 'Config' . DS . 'routes.php';

		$this->User = ClassRegistry::init('User');

	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		$this->Controller->Session->destroy();
		unset($this->Controller);
		unset($this->Users);

		parent::tearDown();
	}

/**
 * @test
 * @method add
 * @return void
 */
	public function ユーザー0件の場合はログインなしでアクセス可能() {
		//ユーザー0件の場合はログインなしでアクセス可能
		$db = $this->User->getDataSource();
		$db->truncate($this->User->table);
		$this->Controller->request->addParams(Router::parse('/admin/users/add'));
		Router::setRequestInfo($this->Controller->request);
		$this->Controller->startupProcess();
		$this->assertEqual(null,$this->Controller->redirectUrl);

		//ビューのテスト
		$renderer = $this->Controller->render('admin_add')->body();
		$this->assertRegExp("/data\[User\]\[email\]/", $renderer);
		$this->assertRegExp("/data\[User\]\[password\]/", $renderer);
		$this->assertRegExp("/data\[User\]\[name\]/", $renderer);
		$this->assertRegExp("/data\[User\]\[is_active\]/", $renderer);

	}
/**
 * @test
 * @method add
 * @return void
 */
	public function is_activeでないとログインできない() {
		$this->Controller->request->addParams(Router::parse('/admin/users/login'));
		Router::setRequestInfo($this->Controller->request);
		$this->Controller->startupProcess();
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->Controller->request->data = array(
			'User'=>array(
				'email'=>'test2@test.com',
				'password'=>'test'
			)
		);
		$this->Controller->admin_login();
		$this->assertEqual('Username or password is incorrect',CakeSession::read('Message.flash.message'));
	}
/**
 * test
 * @method add
 * @return void
 */
	public function ログイン() {
		$this->Controller->request->addParams(Router::parse('/admin/users/login'));
		Router::setRequestInfo($this->Controller->request);
		$this->Controller->startupProcess();
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->Controller->request->data = array(
			'User'=>array(
				'email'=>'test@test.com',
				'password'=>'test'
			)
		);
		$this->Controller->admin_login();
		$this->assertEqual('/',$this->Controller->redirectUrl);
	}

}
