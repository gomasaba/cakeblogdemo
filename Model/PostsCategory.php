<?php
App::uses('AppModel', 'Model');
class PostsCategory extends AppModel {

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Post' => array(
			'className' => 'Post',
			'foreignKey' => 'post_id',
			'order' => ''
		),
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => array('Post.is_publish'=>1),
			'fields' => '',
			'order' => ''
		),
	);	
}
