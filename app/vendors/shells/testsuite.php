<?php

require_once CONSOLE_LIBS . 'testsuite.php';
App::import('Vendor', 'simpletest' . DS . 'reporter');


App::import(null, 'Controller', true, APP . 'libs/controller');

App::import('Core', 'Router');
require_once CONFIGS . 'routes.php';

App::import(null, 'WhiskCakeTestCase', false, TESTS . 'lib');
