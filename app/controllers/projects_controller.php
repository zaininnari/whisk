<?php
class ProjectsController extends AppController {

	var $name = 'Projects';

	/**
	 * @var Project
	 */
	var $Project;

	function index() {
		$this->Project->recursive = 0;
		$this->set('projects', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Project', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('projects', $this->Project->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Project->create();
			$this->Project->setInitData($this->data);
			if ($this->Project->saveAll($this->data)) {
				$this->Session->setFlash(__('The Project has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Project could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Project->User->find('list');
		$this->set(compact('users'));
	}

	function edit($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Project', true));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {
			$this->Project->begin(true);
			if ($this->Project->isProjectOwner($id)
				&& $this->Project->save($this->data, true, array('name', 'description', 'type', 'license'))
			) {
				$this->Project->commit();
				$this->Session->setFlash(__('The Project has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Project->rollback();
				$this->Session->setFlash(__('The Project could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Project->read(null, $id);
		}
		$users = $this->Project->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Project', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Project->begin(true);
		if ($this->Project->isProjectOwner($id) && $this->Project->delete($id)) {
			$this->Project->commit();
			$this->Session->setFlash(__('Project deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Project->rollback();
		$this->Session->setFlash(__('The Project could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
