<?php
class SettingsController extends AppController {

	var $name = 'Settings';

	function index() {
		$this->set('setting', $this->Setting->read(null, $this->getProjectId()));
		$this->render('view');
	}

	function edit() {
		$id = $this->getProjectId();

		if (!empty($this->data)) {
			if ($this->Setting->save($this->data, true , array('name', 'description', 'type', 'license'))) {
				$this->Session->setFlash(__('The Setting has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Setting could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Setting->read(null, $id);
		}
	}

	function delete() {
		$id = $this->getProjectId();
		if ($this->Setting->delete($id)) {
			$this->Session->setFlash(__('Setting deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The Setting could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
