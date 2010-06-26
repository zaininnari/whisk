<?php
class StatesController extends AppController {

	var $name = 'States';
	/**
	 * @var State
	 */
	var $State;

	function __construct()
	{
		$this->helpers[] = 'Javascript';
		$this->components[] = 'RequestHandler';
		parent::__construct();
	}

	public function beforeFilter()
	{
		parent::beforeFilter();
		if (!$this->isProjectRoute()) {
			return $this->cakeError('error404');
		}
		$this->Auth->deny('index', 'view'); // deny all action
	}

	function index() {
		$this->State->recursive = 0;
		$this->set('states', $this->paginate(array('project_id' => $this->getProjectId())));
	}

	function add() {
		if (!empty($this->data)) {
			$this->State->create();
			$this->State->begin(true);
			$this->State->setInitData($this->data, array(
				'hex' => 'ff6600',
				'type' => 0,
				'position' => $this->State->find('count', array('conditions' => array('project_id' => $this->getProjectId())))
			));
			if ($this->State->save($this->data) && $this->State->commit()) {
				$this->Session->setFlash(__('The State has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->State->rollback();
				$this->Session->setFlash(__('The State could not be saved. Please, try again.', true));
			}
		}
	}

	function ajax_edit($id = null) {
		Configure::write('debug', 0);
		$this->layout = 'ajax';
		if (!$id || !$this->RequestHandler->isAjax()) {
			return $this->cakeError('error404');
		}

		if (empty($this->params['form'])) {
			return $this->set('state', array('error' => true, 'message' => __('The State could not be saved. Please, try again.', true)));
		}
		$data['State'] = $this->params['form'];
		$data['State']['id'] = $id;
		if (isset($data['State']['hex']) && strpos($data['State']['hex'], '#') === 0) {
			$data['State']['hex'] = substr($data['State']['hex'], 1);
		}
		if ($this->State->save($data, true, array('name', 'hex', 'type'))) {
			$this->set('state', array('error' => false, 'message' => __('The State has been saved', true)));
		} else {
			$this->set('state', array('error' => true, 'message' => __('The State could not be saved. Please, try again.', true)));
		}
	}

	function ajax_sort() {
		Configure::write('debug', 0);
		$this->layout = 'ajax';

		if (!$this->RequestHandler->isAjax()) {
			return $this->cakeError('error404');
		}

		if (empty($this->params['form']['sort'])) {
			$this->set('state', array('error' => true, 'message' => __('The State could not be saved. Please, try again.', true)));
			return $this->render('ajax_edit');
		}

		// TODO support paginate
		/*
		if (isset($this->params['named']['page'])) {
			$page = (int) $this->params['named']['page'];
			$page = $page > 0 ? $page : 0;
		} else {
			$page = 0;
		}
		$page = $page * $this->paginate['limit'];
		*/

		foreach (explode(',', $this->params['form']['sort']) as $n => $v) {
			if ($v)
			$data['State'] = array('id' => $v, 'position' => $n);
			$this->State->save($data, true, array('position'));
		}

		$this->set('state', array('error' => false, 'message' => __('The State has been saved', true)));
		$this->render('ajax_edit');
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for State', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->State->delete($id)) {
			$this->Session->setFlash(__('State deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The State could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
