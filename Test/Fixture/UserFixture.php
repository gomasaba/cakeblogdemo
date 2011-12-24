<?php
App::uses('AuthComponent', 'Controller/Component');
App::uses('MyFixture', 'Test');
/**
 * UserFixture
 *
 */
class UserFixture extends MyFixture {

	public $import = 'User';

	public function __construct(){
		parent::__construct();
		foreach($this->records as $key=>$records){
			if(isset($records['password'])){
				$this->records[$key]['password'] = AuthComponent::password($this->records[$key]['password']);
			}
		}
	}

}
