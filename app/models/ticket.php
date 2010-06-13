<?php
class Ticket extends AppModel {

	var $name = 'Ticket';
	var $alias = 'Ticket';
	var $actsAs = array(
		'History' => array('useModel' => 'History'),
	);
	var $validate = array(
		'title' => array(
			'WithInChars' => array(
				'rule' => array('between', 1, 100),
				'required' => true,
				'message' => 'Within 20 characters',
			),
		),
		'state_id' => array('numeric'),
		'user_id' => array('numeric'),
		'project_id' => array('numeric'),
	);
	var $belongsTo = array(
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Comment' => array(
			'className' => 'Comment',
			'conditions' => '',
			'order' => '',
			'foreignKey' => 'ticket_id',
			'dependent' => true,
			'exclusive' => false,
			'finderQuery' => ''
		),
	);

	public function getStateList()
	{
		$this->bindModelState(false);
		$result = $this->State->find(
			'list',
			array('conditions' => array('project_id' => self::getProjectId()))
		);
		$this->unbindModel(array('hasMany' => array('State')), false);
		return $result;
	}

	public function getLastInsertIDInProject()
	{
		$backupRecursive = $this->recursive;
		$this->recursive = -1;
		$list = $this->find('all', array(
			'conditions' => array('Ticket.project_id' => 5),
			//'fields' => array('Ticket.id_show'),
			'order' => array('Ticket.id_show DESC'),
			'limit' => 1
		));
		$lastInsertIDInProject = isset($list[0]['Ticket']['id_show']) ? $list[0]['Ticket']['id_show'] + 1 : 1;
		$this->recursive = $backupRecursive;
		return $lastInsertIDInProject;
	}

	public function setInitData(&$data, $options = array())
	{
		$this->bindModelState();
		$result = $this->State->find('list', array(
			'conditions' => array(
				'project_id' => self::getProjectId(),
				'type' => 0,
			),
			'limit' => 1
		));
		$state_id = ($result !== false && !empty($result)) ? key($result) : 0;
		$options = array_merge($options, array('state_id' => $state_id));
		$this->unbindModel(array('hasMany' => array('State')), false);

		return parent::setInitData($data, $options);
	}

	protected function bindModelState($reset = true)
	{
		$this->bindModel(array(
			'hasMany' => array(
				'State' => array(
					'className' => 'State',
					'conditions' => array('project_id' => self::getProjectId()),
					'order' => array('position', 'type', 'id'),
					'foreignKey' => '',
					'dependent' => false,
					'exclusive' => false,
					'finderQuery' => ''
				)
			)
		), $reset);
	}

}
