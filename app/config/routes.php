<?php
require_once APP.'libs'.DS.'whisk_router.php';


App::import('Lib', 'routes/ProjectRoute');

if (!defined('WHISK_USER_URL')) {
	define('WHISK_USER_URL' , 'u');
}
if (!defined('WHISK_PROJECT_URL')) {
	define('WHISK_PROJECT_URL' , 'p');
}

Router::connect('/', array('controller' => 'projects', 'action' => 'index'));

/* Genral Routes */

Router::connect(
	'/:controller',
	array(),
	array('controller' => 'projects|users|pages')
);

Router::connect(
	'/:controller/:action/*',
	array(),
	array('controller' => 'projects|users|pages')
);

/* Project Routes */

Router::connect(
	'/' . WHISK_PROJECT_URL . '/:project',
	array(
		'controller' => 'tickets'
	),
	array(
		'project' => '[_a-z0-9]{3,}',
		'routeClass' => 'ProjectRoute'
	)
);

Router::connect(
	'/' . WHISK_PROJECT_URL . '/:project/:controller',
	array(),
	array(
		'project' => '[_a-z0-9]{3,}',
		'routeClass' => 'ProjectRoute',
		'controller' => 'tickets|comments|users|settings|states',
	)
);

Router::connect(
	'/' . WHISK_PROJECT_URL . '/:project/:controller/:action/*',
	array(),
	array(
		'project' => '[_a-zA-Z0-9]{3,}',
		'routeClass' => 'ProjectRoute',
		'controller' => 'tickets|comments|users|settings|states',
	)
);