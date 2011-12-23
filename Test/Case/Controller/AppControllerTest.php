<?php
App::uses('AppController', 'Controller');

/**
 * TestAppController
 *
 */
class TestAppController extends AppController {
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
 * ArticleGroupsController Test Case
 *
 */
class AppControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
			// 'app.article',
			// 'app.article_group',
			// 'app.user',
			// 'app.user_group',
			// 'app.user_section',
			// 'app.section',
			// 'app.article_media'
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

		$this->Controller = new TestAppController($request, $response);

		$this->Controller->constructClasses();
		Router::reload();
		require APP . 'Config' . DS . 'routes.php';
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Controller);
		Router::reload();
		ClassRegistry::flush();

		parent::tearDown();
	}
/**
 * @test
 *
 * @return void
 */
	public function test() {
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

}
