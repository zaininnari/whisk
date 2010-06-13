<?php

App::import('Core', array('Router', 'Security'), false);


class ProjectComponent extends Object
{
	var $params = array();

	/**
	 * Initializes AuthComponent for use in the controller
	 *
	 * @param object $controller A reference to the instantiating controller object
	 * @return void
	 * @access public
	 */
	function initialize(&$controller, $settings = array())
	{
		$this->params = $controller->params;
	}

/*	function beforeRedirect(&$controller, $url, $status = null, $exit = true)
	{
		return array('url' => WhiskRouter::setProjectBaseUrl($url));
	}*/

	protected function isProjectRoute()
	{
		return isset($this->params['project']);
	}
}
