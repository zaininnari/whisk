<?php
require_once VENDORS . 'dBug.php';

if (class_exists('dBug')) {
	function v($var) {
		new dBug($var);
	}
}

Cache::config('var', array(
	'engine' => 'Var', //[required]
	'duration'=> 3600, //[optional]
));


Configure::write('debug', 2);
Configure::write('Session.timeout', 60 * 60);
Configure::write('Security.salt', 'YhG93b0qyJfIxfs2guVoUubWwvniR2G0FgaC9mi');
Configure::write('Security.cipherSeed', '6859309657453542496749683645');
/**
 * The preferred session handling method. Valid values:
 *
 * 'php'	 		Uses settings defined in your php.ini.
 * 'cake'		Saves session files in CakePHP's /tmp directory.
 * 'database'	Uses CakePHP's database sessions.
 *
 * To define a custom session handler, save it at /app/config/<name>.php.
 * Set the value of 'Session.save' to <name> to utilize it in CakePHP.
 *
 * To use database sessions, run the app/config/schema/sessions.php schema using
 * the cake shell command: cake schema run create Sessions
 *
 */
	Configure::write('Session.save', 'database');

/**
 * The model name to be used for the session model.
 *
 * 'Session.save' must be set to 'database' in order to utilize this constant.
 *
 * The model name set here should *not* be used elsewhere in your application.
 */
	Configure::write('Session.model', 'Session');

/**
 * The name of the table used to store CakePHP database sessions.
 *
 * 'Session.save' must be set to 'database' in order to utilize this constant.
 *
 * The table name set here should *not* include any table prefix defined elsewhere.
 *
 * Please note that if you set a value for Session.model (above), any value set for
 * Session.table will be ignored.
 *
 * [Note: Session.table is deprecated as of CakePHP 1.3]
 */
	Configure::write('Session.table', 'cake_sessions');

/**
 * The DATABASE_CONFIG::$var to use for database session handling.
 *
 * 'Session.save' must be set to 'database' in order to utilize this constant.
 */
	Configure::write('Session.database', 'default');