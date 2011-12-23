<?php
App::uses('CategoriesController', 'Controller');
App::uses('Category', 'Model');

/**
 * TestCategories *
 */
class TestCategoriesController extends CategoriesController {


	public $name = 'Categories';

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
 * Categories Test Case
 *
 */
class CategoriesTestCase extends CakeTestCase {
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
		$this->Controller = new TestCategoriesController($request,$response);
		$this->Controller->constructClasses();
		$this->Controller->Components->init($this->Controller);
		Router::reload();
		require APP . 'Config' . DS . 'routes.php';

		$this->Category = ClassRegistry::init('Category');
	}
/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		$this->Controller->Session->destroy();
		unset($this->Controller);
		unset($this->Category);
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
