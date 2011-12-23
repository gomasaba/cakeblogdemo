<?php
App::uses('AppModel', 'Model');
class PostsTag extends AppModel {

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
		'Tag' => array(
			'className' => 'Tag',
			'foreignKey' => 'tag_id',
			'conditions' => array('Post.is_publish'=>1),
			'fields' => '',
			'order' => ''
		),
	);
	
}
