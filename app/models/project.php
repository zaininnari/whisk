<?php
class Project extends AppModel {

	var $name = 'Project';
	var $alias = 'Project';
	var $validate = array(
		'name' => array(
			'allowedChars' => array(
				'rule' => array('custom', '/^[_a-z0-9]{3,100}$/i'),
				'required' => true,
				'message' => 'Only chars "a-z" and "0-9" , "_" allowed (required 3 chars)',
			),
			'unique' => array(
				'rule' => 'isUnique',
				'required' => true,
				'message' => 'Required: Project must be unique'
			)
		),
		'type' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'required' => true,
				'message' => 'can not empty'
			)
		),
		'license' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'required' => true,
				'message' => 'can not empty'
			)
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Ticket' => array(
			'className' => 'Ticket',
			'foreignKey' => 'project_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'project_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function isProjectOwner($id)
	{
		$result = $this->read(null, $id);
		return Set::extract($this->alias . '.user_id', $result) == $id;
	}

}
