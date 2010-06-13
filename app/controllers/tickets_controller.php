<?php
class TicketsController extends AppController {

	var $name = 'Tickets';


	function beforeFilter()
	{
		parent::beforeFilter();
		if (!$this->isProjectRoute()) {
			$this->Session->setFlash(__('Invalid id for Project', true));
			$this->redirect('/');
		}
	}

	function index()
	{
		$this->set('tickets', $this->paginate(array('Ticket.project_id' => $this->getProjectId())));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Ticket', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('ticket', $this->Ticket->read(null, $id));
		$this->set('state', $this->Ticket->getStateList());
		$this->set(compact('id'));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Ticket->create();
			$this->Ticket->setInitData($this->data);

			if ($this->Ticket->save($this->data)) {
				$this->Session->setFlash(__('The Ticket has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Ticket could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Ticket', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Ticket->save($this->data, true, array('title'))) {
				$this->Session->setFlash(__('The Ticket has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				return $this->Session->setFlash(__('The Ticket could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->set('state', $this->Ticket->getStateList());
			$this->data = $this->Ticket->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Ticket', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Ticket->delete($id)) {
			$this->Session->setFlash(__('Ticket deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The Ticket could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
