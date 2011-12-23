<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

/**
 * Post Model
 *
 */
class Post extends AppModel {



	public $actsAs = array('CakeSearch.Searchable');


	public $filterArgs = array(
		array('name' => 'subject', 'type' => 'like'),
		array('name' => 'tags', 'type' => 'subquery', 'method' => 'findByTags', 'field' => 'Post.id'),
	);

	public function findByTags($data = array()) {
		$this->Tag->Behaviors->attach('Containable', array('autoFields' => false));
		$this->Tag->Behaviors->attach('CakeSearch.Searchable');
		$query = $this->Tag->getQuery('all', array(
			'conditions' => array('Tag.name'  => $data['tags']),
			'fields' => array('id'),
			'contain' => array('Post')
		));
		return $query;
	}

	public function timeCondition($data) {
		$return = array();
		if(array_key_exists('time_from',$data)){
			if(!empty($data['time_from']['year'])){
				$startfunc = function($date){
					$year = $date['year'];
					$month = (empty($date['month'])) ? 1 : $date['month'];
					$day = (empty($date['day'])) ? 1 : $date['day'];
					$hour = $min = 0;
					return mktime($hour, $min, 0,$month,$day, $year);					
				};
				$start = $startfunc($data['time_from']);
			}
		}
		if(array_key_exists('time_to',$data)){
			if(!empty($data['time_to']['year'])){
				$endfunc = function($date){
					$year = $date['year'];
					$month = (empty($date['month'])) ? 12 : $date['month'];
					$day = (empty($date['day'])) ? 31 : $date['day'];
					$hour = 23;
					$min = 59;
					$s = 59;
					return mktime($hour, $min, $s,$month,$day, $year);
				};
				$end = $endfunc($data['time_to']);
			}
		}
		if(isset($start) && isset($end)){
			$return['Post.created BETWEEN ? AND ?'] = array($start,$end);
		}
		return $return;
	}




/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'subject' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => 'id,name',
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Category' => array(
			'className' => 'Category',
			'joinTable' => 'posts_categories',
			'foreignKey' => 'post_id',
			'associationForeignKey' => 'category_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => '',
			'counterCache'=>true,

		),
		'Tag' => array(
			'className' => 'Tag',
			'joinTable' => 'posts_tags',
			'foreignKey' => 'post_id',
			'associationForeignKey' => 'tag_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => '',
			'counterCache'=>true,
			
		)
	);


	public function beforeSave($options = array()) {
		if(!array_key_exists('user_id',$this->data[$this->alias]) || empty($this->data[$this->alias]['user_id'])){
			$user_id = AuthComponent::user('id');
			if(!$user_id){
				throw new CakeException('SaveFailed...');
			}
			$this->data[$this->alias]['user_id'] = AuthComponent::user('id');
		}
		if(array_key_exists('created',$this->data[$this->alias])){
			if(is_array($this->data[$this->alias]['created'])){
				$this->data[$this->alias]['created'] = $this->toUnix($this->data[$this->alias]['created']);
			}
		}
		return true;
	}

	public function beforeFind($queryData){
		$param = Router::getParams();
		if(!isset($param['prefix'])){
			$conditions = $queryData['conditions'];
			if (!is_array($conditions)) {
				if (!$conditions) {
					$conditions = array();
				}else{
					$conditions = array($conditions);
				}
			}
			if(!isset($conditions['is_publish']) && !isset($conditions[$this->alias . '.is_publish'])) {
				$queryData['conditions'][$this->alias . '.is_publish'] = 1;
			}
			return $queryData;		
		}
	}





}
