<?php

require_once CONSOLE_LIBS . 'testsuite.php';
App::import('Vendor', 'simpletest' . DS . 'reporter');


App::import(null, 'Controller', true, APP . 'libs/controller');



App::import(null, 'WhiskCakeTestCase', false, TESTS . 'lib');
