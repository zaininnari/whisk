<?php
class CommentsController extends AppController {

	var $name = 'Comments';

	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('view'); // not auth action
		if (!$this->isProjectRoute()) {
			$this->Session->setFlash(__('Invalid id for Project', true));
			$this->redirect('/');
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Comment', true));
			$this->redirect(array('controller' => 'tickets'));
		}
		$this->set('comment', $this->Comment->read(null, $id));
	}

	function add($ticket_id = null) {
		if (!$ticket_id) {
			$this->Session->setFlash(__('Invalid ticket_id', true));
			$this->redirect(array('controller' => 'tickets'));
		}
		if (!empty($this->data)) {
			$this->Comment->create();
			$this->Comment->Ticket->create();
			$this->Comment->Ticket->State->recursive = -1;
			$statId = isset($this->data['Ticket']['state_id']) ? $this->data['Ticket']['state_id'] : null;
			$this->Comment->setInitData($this->data, array('ticket_id' => $ticket_id));
			$this->Comment->Ticket->id = $ticket_id;
			$this->Comment->begin(true);
			if ($this->Comment->Ticket->findById($ticket_id) !== false
				&& $statId !== null
				&& $this->Comment->Ticket->State->findById($statId) !== false
			) {
				$saveTicket = $this->Comment->Ticket->saveField('state_id', $statId);
				$saveComment = $this->Comment->save($this->data);
				if ($saveComment !== false && $saveTicket !== false) {
					$this->Comment->commit();
					$this->Session->setFlash(__('The Comment has been saved', true));
					$this->redirect(array('controller' => 'tickets', 'action' => 'view', 'id' => $ticket_id));
				} else {
					$this->Comment->rollback();
				}
			} else {
				$this->Comment->rollback();
			}
			$this->Session->setFlash(__('The Comment could not be saved. Please, try again.', true));
		}
		$this->set('comment', $this->Comment->Ticket->read(null, $ticket_id));
		$this->set('state', $this->Comment->Ticket->getStateList());
		$this->set('ticket_id', $ticket_id);
	}

	function edit($id = null) {
		$this->Session->renew();
		if (!$id) {
			$this->Session->setFlash(__('Invalid Comment', true));
			$this->redirect(array('controller' => 'tickets'));
		}

		if (!empty($this->data)) {
			if ($this->isOwner($id)
				&& $this->Comment->save($this->data, true, array('body'))
			) {
				$this->Session->setFlash(__('The Comment has been saved', true));
				$this->redirect(array(
					'controller' => 'tickets',
					'action' => 'view',
					'id' => isset($this->data['Comment']['ticket_id']) ? $this->data['Comment']['ticket_id'] : 0
				));
			} else {
				$this->Session->setFlash(__('The Comment could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Comment->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Comment', true));
			$this->redirect(array('controller' => 'tickets'));
		}
		if ($this->isOwner($id)
			&& $this->Comment->delete($id)
		) {
			$this->Session->setFlash(__('Comment deleted', true));
			$this->redirect(array('controller' => 'tickets'));
		}
		$this->Session->setFlash(__('The Comment could not be deleted. Please, try again.', true));
		$this->redirect(array('controller' => 'tickets'));
	}

}
