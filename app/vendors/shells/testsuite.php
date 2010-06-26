<?php
Configure::write('debug', 0);
Configure::write('log', false);

require_once CONSOLE_LIBS . 'testsuite.php';
App::import('Vendor', 'simpletest' . DS . 'reporter');

App::import('Core', 'Router');
require_once CONFIGS . 'routes.php';

App::import(null, 'WhiskCakeTestCase', false, TESTS . 'lib');
