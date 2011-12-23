<?php

App::uses('Tag', 'Model');

/**
 * Tag Test Case
 *
 */
class TagTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.tag', 'app.post', 'app.user', 'app.media', 'app.category', 'app.category_post', 'app.posts_tag');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Tag = ClassRegistry::init('Tag');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Tag);

		parent::tearDown();
	}
/**
 * @test
 *
 * @return void
 */
	public function view() {
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

}
