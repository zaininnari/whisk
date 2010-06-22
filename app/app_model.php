<?php
class AppModel extends Model {

	protected $defaultData = array();

	protected $_defaultDataKey = '_defaultData';

	function save($data = null, $validate = true, $fieldList = array(), $defaultData = array()) {
		if ($data !== null && isset($data[$this->alias])) {
			foreach (array('modified', 'updated') as $field) {
				if (array_key_exists($field, $this->_schema)) {
					$data[$this->alias][$field] = null;
				}
			}
		}
		if (!empty($defaultData)) $fieldList[$this->_defaultDataKey] = $defaultData;

		return parent::save($data, $validate, $fieldList);
	}

	public function setInitData(&$data, $options = array())
	{
		$ids = array(
			'project_id' => self::getProjectId(),
			'user_id' => self::getUserId(),
		);
		foreach (array_keys($ids) as $n => $v) {
			if (!array_key_exists($v, $this->_schema)) unset($ids[$v]);
		}
		$default = array_merge($ids, $options);
		$data[$this->alias] = array_merge($data[$this->alias], $default);
		return $data;
	}

	/**
	 * getter
	 * get `project`.`id`
	 *
	 */
	public static function getProjectId()
	{
		return Configure::read('projectId');
	}

	/**
	 * getter
	 *
	 */
	public static function getUserId()
	{
		return Set::extract($_SESSION, 'Auth.User.id');
	}

	/**
	 * Begin a transaction
	 *
	 * @return boolean
	 */
	function begin($isSerializable = false)
	{
		$db = $this->getInstanceDb();
		if ($isSerializable && stripos('mysql', $db->config['driver']) === false) {
			trigger_error(sprintf(__('support only mysql driver `transaction : SERIALIZABLE`', true)), E_USER_ERROR);
		} elseif($isSerializable) {
			$query = 'SET TRANSACTION ISOLATION LEVEL SERIALIZABLE';
			if (!$db->execute($query)) {
				return false;
			}
		}
		return $db->begin($this);
	}

	/**
	 * Commit a transaction
	 *
	 * @return boolean
	 */
	function commit()
	{
		$db = $this->getInstanceDb();
		return $db->commit($this);
	}

	/**
	 * Rollback a transaction
	 *
	 * @return boolean
	 */
	function rollback()
	{
		$db = $this->getInstanceDb();
		return $db->rollback($this);
	}

	/**
	 * get instance database
	 *
	 * @return object
	 */
	private function getInstanceDb(){
		return ConnectionManager::getDataSource($this->useDbConfig);
	}

}
