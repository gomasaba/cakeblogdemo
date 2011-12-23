<?php

App::uses('Post', 'Model');
App::uses('AuthComponent', 'Controller/Component');
App::uses('CakeSession', 'Model/Datasource');


/**
 * Post Test Case
 *
 */
class PostTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.post', 'app.user', 'app.media', 'app.category', 'app.category_post', 'app.tag', 'app.posts_tag');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Post = ClassRegistry::init('Post');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		CakeSession::destroy();
		unset($this->Post);
		parent::tearDown();
	}
/**
 * @test
 *
 * @return void
 */
	public function user_idはAuthComponentから取得して保存() {
		CakeSession::write('Auth.User',array('id'=>1,'role'=>'admin'));
		$save = array(
			'subject'=> 'ブログ記事のタイトル',
			'body'=> 'ブログの内容',
			'is_publish'=> 1
		);
		$results = $this->Post->save($save);
		$this->assertEqual(1,$results['Post']['user_id']);
	}
/**
 * @test
 *
 * @return void
 */
	public function 保存のテスト() {
		CakeSession::write('Auth.User',array('id'=>1,'role'=>'admin'));
		$save = array(
			'subject'=> '記事の保存のテスト',
			'body'=> 'ブログの内容',
			'is_publish'=> 1,
			'created'=>array(
				'year'=>2011,
				'month'=>12,
				'day'=>24
			)
		);
		$results = $this->Post->save($save);
		$this->assertEqual(1,$results['Post']['user_id']);
	}
/**
 * @test
 * @expectedException CakeException
 */
	public function ユーザーIDが取得できなければException() {
		$save = array(
			'subject'=> '記事の保存のテスト',
			'body'=> 'ブログの内容',
			'is_publish'=> 1,
			'created'=>array(
				'year'=>2011,
				'month'=>12,
				'day'=>24
			)
		);
		$this->Post->save($save);
	}

/**
 * @test
 *
 * @return void
 */
	public function timeCondition() {
		$test = array(
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
		);
		$results = $this->Post->timeCondition($test);
		$expects = array(
			'Post.created BETWEEN ? AND ?'=>array('1293807600','1296572399')
		);
		$this->assertEqual($expects,$results);


		$test = array(
			'time_from'=>array(
					'year'=>2011,
					'month'=>null,
					'day'=>null,
			),
			'time_to'=>array(
					'year'=>2011,
					'month'=>null,
					'day'=>null,
			),
		);
		$results = $this->Post->timeCondition($test);
		$expects = array(
			'Post.created BETWEEN ? AND ?'=>array('1293807600','1325343599')
		);
		$this->assertEqual($expects,$results);


		$test = array(
			'time_from'=>array(
					'year'=>null,
					'month'=>null,
					'day'=>null,
			),
			'time_to'=>array(
					'year'=>null,
					'month'=>null,
					'day'=>null,
			),
		);
		$results = $this->Post->timeCondition($test);
		$expects = array();
		$this->assertEqual($expects,$results);

	}





}
