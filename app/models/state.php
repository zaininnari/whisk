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

	public function setDefaultData(&$data)
	{
		$stateData = array(
			array('name' => 'new', 'hex' => 'ff1177', 'position' => '0', 'type' => '0'),
			array('name' => 'open', 'hex' => 'aaaaaa', 'position' => '1', 'type' => '0'),
			array('name' => 'hold', 'hex' => 'EEBB00', 'position' => '2', 'type' => '0'),
			array('name' => 'resolved', 'hex' => '66AA00', 'position' => '3', 'type' => '1'),
			array('name' => 'duplicate', 'hex' => 'AA3300', 'position' => '4', 'type' => '1'),
			array('name' => 'wont-fix', 'hex' => 'AA3300', 'position' => '5', 'type' => '1'),
			array('name' => 'invalid', 'hex' => 'AA3300', 'position' => '6', 'type' => '1'),
		);
		$data['State'] = $stateData;
		return $data;
	}

}
