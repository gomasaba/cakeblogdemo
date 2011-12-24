<?php
App::uses('AppController', 'Controller');
App::uses('AuthComponent', 'Controller/Component');

/**
 * Install Controller
 *
 * @property User $User
 */
class InstallController extends AppController {

	public $pageTitle = '初期データ挿入';

	public $autoRender = false;

	public $uses = array('User','Category','Tag','Post');

	public function beforeFilter() {
		$this->Auth->allow('*');
		parent::beforeFilter();
	}

	public function index(){
		$this->render();
	}


	public function run(){
		App::import('Core', 'File');
		App::import('Model', 'CakeSchema', false);
		App::import('Model', 'ConnectionManager');

		$db = ConnectionManager::getDataSource('default');
		if(!$db->isConnected()) {
			$this->Session->setFlash(__('Could not connect to database.', true), 'default', array('class' => 'error'));
		} else {
			foreach($this->uses as $modelClass){
				$this->loadModel($modelClass);
				$data = yaml_parse_file(APP.'Test/Fixture/yaml/'.$modelClass.'Fixture.yml');
				foreach($data as $key=>$row){
					if(array_key_exists('created',$row)){
						unset($row['created']);
					}
					if(array_key_exists('modified',$row)){
						unset($row['modified']);
					}
					$this->{$modelClass}->create();
					$this->{$modelClass}->cacheQueries = false;
					$this->{$modelClass}->contain();
					$this->{$modelClass}->set($row);
					$this->{$modelClass}->Behaviors->disable('Tree');
					$this->{$modelClass}->save($row,false);
				}
				if(array_key_exists('Tree',$this->{$modelClass}->actsAs)){
					$this->{$modelClass}->order = '';
					$this->{$modelClass}->Behaviors->enabled('Tree');
					$this->{$modelClass}->recover();
				}
			}
			$this->render('success');
		}
	}

}
