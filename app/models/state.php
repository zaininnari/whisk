<?php
class State extends AppModel {

	var $name = 'State';
	var $validate = array(
		'name' => array(
			'WithInChars' => array(
				'rule' => array('between', 1, 20),
				'required' => true,
				'message' => 'Within 20 characters',
			),
		),
		'hex' => array(
			'hex' => array(
				'rule' => array('custom', '/^([a-f0-9]{3}|[a-f0-9]{6})$/i'),
				'required' => true,
				'message' => 'Only chars "a-z" and "0-9".required 3 or 6 chars.',
			)
		),
		'type' => array(
			'WithInChars' => array(
				'rule' => array('custom', '/^(0|1)$/i'),
				'required' => true,
				'message' => 'Only chars 0 or 1.',
			),
		),
	);

	var $order = array('State.position', 'State.type', 'State.id');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'project_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
