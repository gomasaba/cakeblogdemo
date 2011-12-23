<?php
/**
 * AllControllersTest class
 *
 * This test group will run cache engine tests.
 *
 * @package       Cake.Test.Case
 */
class AllControllerTest extends PHPUnit_Framework_TestSuite {

/**
 * suite method, defines tests for this suite.
 *
 * @return void
 */
	public static function suite() {
		$suite = new CakeTestSuite('All Controller related class tests');
		$suite->addTestDirectory(TESTS .'Case'.DS. 'Controller');
		$suite->addTestDirectory(TESTS .'Case'.DS. 'Controller/Component');
		$suite->addTestDirectory(TESTS .'Case'.DS. 'View/Helper');
		return $suite;
	}
}