<?php
class DATABASE_CONFIG {

	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'demo',
		'password' => 'demo',
		'database' => 'demo',
		'prefix' => 'blog_',
	);

	public $test = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'demo',
		'password' => 'demo',
		'database' => 'test',
		'prefix' => 'blog_',
	);	
}
