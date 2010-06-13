<?php

class PagesController extends AppController {

	var $name = 'Pages';
	var $uses = array();

	function __construct()
	{
		$this->helpers[] = 'Javascript';
		parent::__construct();
	}

	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('library'); // not auth action
	}

	function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			//$this->redirect('/');
		}
		$page = $subpage = $title = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title'));
		$this->render(implode('/', $path));
	}

	function library()
	{
	}
}

