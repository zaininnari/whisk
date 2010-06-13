<?php

App::import(null, 'Controller', true, array(APP . 'libs/controller'));

foreach (array(VENDORS . 'shells/testsuite.php', CONSOLE_LIBS . 'testsuite.php') as $path) {
	if (file_exists($path)) {
		require $path;
		break;
	}
}