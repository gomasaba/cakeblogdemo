<?php

class MyFixture extends CakeTestFixture{


	public function __construct(){
		$yaml = APP.'Test'.DS.'Fixture'.DS.'yaml'.DS.get_class($this).'.yml';
		$this->records = yaml_parse_file($yaml);
		parent::__construct();
	}

	public function create($db) {
	    $this->fields['tableParameters']['engine'] = 'InnoDB';
	    return parent::create($db);

	}



}