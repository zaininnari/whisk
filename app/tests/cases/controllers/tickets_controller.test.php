<?php
App::import('Controller', 'Tickets');

class TestTickets extends TicketsController {
	var $autoRender = false;
}

class TicketsControllerTest extends CakeTestCase {
	var $Tickets = null;
	var $fixtures = array(
		'app.state', 'app.project', 'app.user', 'app.ticket', 'app.comment'
	);


	function startTest()
	{
		$this->Tickets = new TicketsController();
		$this->Tickets->constructClasses();
	}

	function endTest()
	{
		$this->__userLogout();
		unset($this->Tickets);
		ClassRegistry::flush();
	}

	function testTicketsControllerInstance()
	{
		$this->assertTrue(is_a($this->Tickets, 'TicketsController'));
	}

	function testRedirect()
	{
		$result = $this->testAction('/users/view/1');

		$josn = json_decode($result, true);
		$function = $josn !== null ? Set::extract('function', $josn) : null;
		if ($function === 'cakeError') {
			$result = Set::extract('method', $josn);
		} elseif ($function === 'redirect') {
			$result = Set::extract('url', $josn);
		}
		$this->assertEqual($result , '/users/login');
	}

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
	}

	protected function __userLogin()
	{
		$data = array('User' => array(
			'username' => 'aaaa',
			'password' => 'aaaa',
		));

		$this->assertEqual($this->Tickets->Auth->isAuthorized() , false);
		$result = $this->testAction('/users/login', array(
			'data' => $data,
			'method' => 'post',
		));
		$this->assertEqual($this->Tickets->Auth->isAuthorized() , true);
	}

	protected function __userLogout()
	{
		$result = $this->testAction('/users/logout');
		$this->assertEqual($this->Tickets->Auth->isAuthorized() , false);
	}

}
