<?php
App::uses('MyFixture', 'Test');
/**
 * PostFixture
 *
 */
class PostFixture extends MyFixture {

	public $import = 'Post';


	public function __construct(){
		parent::__construct();
		foreach($this->records as $key=>$records){
			//日付の指定があればその日で
			if(isset($records['created'])){
				$this->records[$key]['created'] = strtotime($this->records[$key]['created']);
			}else{
				$this->records[$key]['created'] = strtotime('-1 day');
			}
		}
	}

}
