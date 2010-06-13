<?php
class Comment extends AppModel {

	var $name = 'Comment';
	var $validate = array(
		'ticket_id' => array('notempty')
	);
	var $alias = 'Comment';

	var $belongsTo = array('Ticket');


}
