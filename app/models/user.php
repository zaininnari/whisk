<?php
class User extends AppModel {

	var $name = 'User';

	var $hasMany = array('ticket', 'comment');

	var $validate = array(
		'username' => array(
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'message' => 'Only alphabets and numbers allowed',
				),
			'between' => array(
				'rule' => array('between', 4, 16),
				//'required' => true,
				'message' => 'Between 4 to 16 characters'
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				//'required' => true,
				'message' => 'Required: User must be unique'
			)
		),
		'password' => array(
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				//'required' => true,
				'message' => 'Alphabets and numbers only'
			),
			'between' => array(
				'rule' => array('between', 4, 64),
				'message' => 'Between 4 to 64 characters'
			)
		)
	);

	function hashPasswords($data)
	{
		return $data;
	}
}
