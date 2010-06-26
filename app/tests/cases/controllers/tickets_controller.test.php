<?php
App::import('Controller', 'Tickets');

class TestTicketsController extends TicketsController {
	var $autoRender = false;
	public function redirect($url, $status = null, $exit = true)
	{
		$this->redirectUrl = $url;
	}
}

class TicketsControllerTestCase extends WhiskCakeTestCase {
	/**
	 * controller
	 *
	 * @var TicketsController
	 */
	var $Tickets;
	var $fixtures = array(
		'app.project', 'app.state', 'user', 'app.ticket', 'app.comment'
	);


	function startTest()
	{
		$this->_createControllerInstance($this);
	}

	function endTest()
	{
		parent::endTest();
	}


/*	function testIndex()
	{
		$this->_initControllerAction('index', 'users', true);
		$result = $this->Tickets->index();
		$output = $this->Tickets->render('index');
		$this->assertFalse(strpos($output, '<pre class="cake-debug">'));
	}*/
/*
	function testAdd()
	{
		$this->__userLogin();

		$data = array(
			'Ticket' => array(
				'title' => 'title',
				'body' => 'body',
			)
		);

		// check table empty
		$this->assertEqual(array() , $this->Tickets->Ticket->find('all'));

		$result = $this->testAction('/p/whisk/tickets/add', array(
			'data' => $data,
			'method' => 'post',
		));
		$this->assertEqual('index', Set::extract(json_decode($result, true), 'url.action'));

		$data = $this->Tickets->Ticket->find('all', array('conditions' => $this->Tickets->getProjectId()));
		$this->assertEqual(1, $this->Tickets->Ticket->find('count'));
		$this->assertEqual(1, $this->Tickets->Ticket->find('count', array('conditions' => $this->Tickets->getProjectId())));

		$expect = array(
			'title' => 'title',
			'body' => 'body',
			'user_id' => $this->Tickets->getUserId(),
			'project_id' => $this->Tickets->getProjectId()
		);
		$this->assertEqual(array_intersect_key($data[0]['Ticket'], $expect), $expect);
	}

	function testEdit()
	{
		$this->assertEqual(array() , $this->Tickets->Ticket->find('all'));
		$this->testAdd();
		$insertedData = $this->Tickets->Ticket->find('all', array('conditions' => $this->Tickets->getProjectId()));
		$ticketId = Set::extract('Ticket.id', $insertedData[0]);

		$expectTitle = 'changed title';
		$data = array('Ticket' => array(
			'id' => $ticketId,
			'title' => $expectTitle
		));
		$result = $this->testAction('/p/whisk/tickets/edit/' . $ticketId, array(
			'data' => $data,
			'method' => 'post',
		));

		$this->assertEqual(1, $this->Tickets->Ticket->find('count'));
		$this->assertEqual(1, $this->Tickets->Ticket->find('count', array('conditions' => $this->Tickets->getProjectId())));

		$insertedData = $this->Tickets->Ticket->find('all', array('conditions' => $this->Tickets->getProjectId()));
		$ticketTitle = Set::extract('Ticket.title', $insertedData[0]);
		$expect = array('title' => $expectTitle);
		$this->assertEqual(array_intersect_key($insertedData[0]['Ticket'], $expect), $expect);
	}

	function testDelete()
	{
		$this->assertEqual(array() , $this->Tickets->Ticket->find('all'));
		$this->testAdd();
		$insertedData = $this->Tickets->Ticket->find('all', array('conditions' => $this->Tickets->getProjectId()));
		$ticketId = Set::extract('Ticket.id', $insertedData[0]);

		$expectTitle = 'changed title';
		$result = $this->testAction('/p/whisk/tickets/delete/' . $ticketId);

		$this->assertEqual(0, $this->Tickets->Ticket->find('count'));
		$this->assertEqual(0, $this->Tickets->Ticket->find('count', array('conditions' => $this->Tickets->getProjectId())));
	}*/

}
