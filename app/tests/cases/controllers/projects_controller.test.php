<?php
/* Projects Test cases generated on: 2010-06-14 21:06:08 : 1276519688*/
require_once APP . '/tests/lib/whisk_cake_test_case.php';
App::import('Controller', 'Projects');

class TestProjectsController extends ProjectsController {
	public $autoRender = false;
	public $redirectUrl = false;

	function redirect($url, $status = null, $exit = true) {
		return $this->redirectUrl = $url;
	}
}

class ProjectsControllerTestCase extends WhiskCakeTestCase {
	var $fixtures = array('app.project', 'app.user', 'app.ticket', 'app.state', 'app.comment');

	/**
	 * controller
	 *
	 * @var TestProjectsController
	 */
	var $Projects;

	function startTest() {
		$this->_createControllerInstance($this);
	}

	function endTest() {
		parent::endTest();
	}

	function testNologin()
	{
		$this->_initControllerAction('index', 'projects', false);
		$this->assertFalse($this->Projects->redirectUrl);

		$this->Projects->redirectUrl = false;
		$this->_initControllerAction('add', 'projects/add', false);
		$this->assertEqual($this->Projects->redirectUrl, '/users/login');

		$this->Projects->redirectUrl = false;
		$this->_initControllerAction('edit', 'projects/edit/1', false);
		$this->assertEqual($this->Projects->redirectUrl, '/users/login');

		$this->Projects->redirectUrl = false;
		$this->_initControllerAction('view', 'projects/view/1', false);
		$this->assertFalse($this->Projects->redirectUrl);

		$this->Projects->redirectUrl = false;
		$this->_initControllerAction('delete', 'projects/delete/1', false);
		$this->assertEqual($this->Projects->redirectUrl, '/users/login');
	}

	function testIndex() {
		$this->_initControllerAction('index', 'projects/index', true);
		$this->assertFalse($this->Projects->redirectUrl);
		$this->Projects->index();
		$output = $this->Projects->render('index');
		$this->assertFalse(strpos($output, '<pre class="cake-debug">'));
	}

	function testView() {
		$this->_initControllerAction('index', 'projects/view/1', true);
		$this->assertFalse($this->Projects->redirectUrl);
		$this->Projects->view(1);
		$output = $this->Projects->render('view');
		$this->assertFalse(strpos($output, '<pre class="cake-debug">'));
	}

	function testAdd() {
		$this->_initControllerAction('add', 'projects/add', true);
		$_expect = $this->Projects->data = array('Project' => array(
			'name' => 'name',
			'description' => 'description',
			'type' => 'type',
			'license' => 'license',
		));
		$this->Projects->add();
		$this->assertEqual($this->Projects->redirectUrl, array('action' => 'index'));

		$projectId = $this->Projects->Project->getInsertID();
		$project = $this->Projects->Project->findById($projectId);
		$expect = array_merge($_expect['Project'], array('user_id' => $this->Projects->getUserId()));
		$this->assertEqual(array_intersect_key($project['Project'], $expect), $expect);

		$stateData = array();
		$this->Projects->Project->State->setDefaultData($stateData);
		$this->assertEqual(count($stateData['State']), count($project['State']));
		foreach ($project['State'] as $n => $v) {
			$expect = array_merge($stateData['State'][$n], array('project_id' => $projectId));
			$this->assertEqual(array_intersect_key($project['State'][$n], $expect), $expect);
		}
	}

	function testEdit() {
		$projectId = 1;
		$this->_initControllerAction('add', 'projects/edit/' . $projectId, true);
		$_expect = $this->Projects->data = array('Project' => array(
			'id' => $projectId,
			'name' => 'changedname',
			'description' => 'changed description',
			'type' => 'changed type',
			'license' => 'changed license',
		));
		$this->Projects->edit($projectId);
		$this->assertEqual($this->Projects->redirectUrl, array('action' => 'index'));

		$project = $this->Projects->Project->findById($projectId);
		$expect = array_merge($_expect['Project'], array('user_id' => $this->Projects->getUserId()));
		$this->assertEqual(array_intersect_key($project['Project'], $expect), $expect);
	}

	function testDelete() {
		$projectId = 1;
		$this->_initControllerAction('add', 'projects/delete/' . $projectId, true);
		$this->Projects->delete($projectId);
		$this->assertEqual($this->Projects->redirectUrl, array('action' => 'index'));

		$project = $this->Projects->Project->findById($projectId);
		$this->assertFalse($project);
	}

}
