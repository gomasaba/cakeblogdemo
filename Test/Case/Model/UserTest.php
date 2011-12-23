<?php

App::uses('User', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * User Test Case
 *
 */
class UserTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.user', 'app.post', 'app.media', 'app.category', 'app.category_post', 'app.tag', 'app.posts_tag');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->User = ClassRegistry::init('User');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->User);

		parent::tearDown();
	}
/**
 * @test
 *
 * @return void
 */
	public function パスワードはハッシュして保存() {
		$save = array(
			'email'=>'test@test.com',
			'password'=>'himitsu',
			'name'=>'テストユーザー',
			'is_active'=>1,
		);
		$results = $this->User->save($save);
		$this->assertEqual(AuthComponent::password('himitsu'),$results['User']['password']);
	}

}
