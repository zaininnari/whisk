<?php

class VarEngine extends CacheEngine
{

	protected static $__varCache = array();

/**
 * Initialize the Cache Engine
 *
 * Called automatically by the cache frontend
 * To reinitialize the settings call Cache::engine('EngineName', [optional] settings = array());
 *
 * @param array $setting array of setting for the engine
 * @return boolean True if the engine has been successfully initialized, false if not
 * @access public
 */
	function init($settings = array())
	{
		return parent::init(array_merge(array('engine' => 'Var'), $settings));
	}

/**
 * Garbage collection. Permanently remove all expired and deleted data
 *
 * @return boolean True if garbage collection was succesful, false on failure
 * @access public
 */
	function gc()
	{
		return true;
	}

/**
 * Write data for key into cache
 *
 * @param string $key Identifier for the data
 * @param mixed $data Data to be cached
 * @param mixed $duration How long to cache the data, in seconds
 * @return boolean True if the data was succesfully cached, false on failure
 * @access public
 */
	function write($key, &$data, $duration)
	{
		self::$__varCache[$key] = $data;
		return true;
	}

/**
 * Read a key from the cache
 *
 * @param string $key Identifier for the data
 * @return mixed The cached data, or false if the data doesn't exist, has expired, or if there was an error fetching it
 * @access public
 */
	function read($key)
	{
		$data = self::$__varCache[$key];
		return empty($data) ? false : $data;
	}

/**
 * Delete a key from the cache
 *
 * @param string $key Identifier for the data
 * @return boolean True if the value was successfully deleted, false if it didn't exist or couldn't be removed
 * @access public
 */
	function delete($key) {
		if (!isset(self::$__varCache[$key])) return false;
		unset(self::$__varCache[$key]);
		return true;
	}

/**
 * Delete all values from the cache
 *
 * @param boolean $check Optional - only delete expired cache items
 * @return boolean True if the cache was succesfully cleared, false otherwise
 * @access public
 */
	function clear($check) {
		unset(self::$__varCache);
		return true;
	}



}
