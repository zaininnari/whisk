<?php

$construct = '
if (defined("TEST_CAKE_CORE_INCLUDE_PATH")) {
	$index = array_search("DebugKit.Toolbar", $this->components);
	if ($index !== false) {
		unset($this->components[$index]);
		$this->components = array_merge(array_diff($this->components, array()));
	}
}
';

$cakeError = '
function cakeError($method, $messages = array())
{
	if (defined("TEST_CAKE_CORE_INCLUDE_PATH")) {
		$return = array(
			"function" => "cakeError",
			"method" => $method,
			"messages" => $messages,
			"session" => $this->Session->read()
		);
		$this->set("return", $return);
		$this->render(null, null, TESTS . "views" . DS . "redirect.ctp");
		return true;
	}
	return parent::cakeError($method, $messages);
}
';

$redirect = '
if (defined("TEST_CAKE_CORE_INCLUDE_PATH")) {
	$return = array(
		"function" => "redirect",
		"url" => $url,
		"status" => $status,
		"exit" => $exit,
		"session" => $this->Session->read()
	);
	$_return = json_decode($this->output, true);
	if ($_return) {
		$return = $_return;
	}
	$this->viewVars = array();
	$this->output = null;
	$this->set("return", $return);
	$this->render(null, null, TESTS .  "views" . DS . "redirect.ctp");
	return true;
}
';

$unsetDebugKit = 'unset($this->components["DebugKit.Toolbar"]);';

$source = file_get_contents(LIBS . 'controller/controller.php');
$source = preg_replace('/^<\?php/', '', $source);
$source = preg_replace('/\?>$/', '', $source);
$source = preg_replace('/(function __construct\(.*\n)/', $cakeError . PHP_EOL . '$1' . $construct, $source);
$source = preg_replace('/(function redirect\(.*\n)/', '$1' . $redirect, $source);
$source = preg_replace('/(\$this->__mergeVars\(\);)/', '$1' . $unsetDebugKit, $source);

eval($source);
