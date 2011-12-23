<?php
/**
 * AllModelTest class
 *
 * This test group will run model class tests
 *
 * @package       Cake.Test.Case
 */
class AllModelTest extends PHPUnit_Framework_TestSuite {

/**
 * suite method, defines tests for this suite.
 *
 * @return void
 */
	public static function suite() {
		$suite = new CakeTestSuite('All Model related class tests');
		$suite->addTestDirectory(TESTS .'Case'.DS. 'Model');
		$suite->addTestDirectory(TESTS .'Case'.DS. 'Model/Behavior');
		return $suite;
	}
}