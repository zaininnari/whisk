<?php
class ProjectRoute extends CakeRoute
{

	private static $__projectId, $__projectName, $__userId;

	/**
	 * (non-PHPdoc)
	 *
	 * @param string $url The url to attempt to parse.
	 *
	 * @see cake/libs/CakeRoute#parse($url)
	 *
	 * @return mixed Boolean false on failure, otherwise an array or parameters
	 */
	function parse($url)
	{
		$params = parent::parse($url);
		if ($params === false) return false;
		$name = 'project';
		$modelName = Inflector::classify($name);
		$fieldId = $modelName . '.id';
		$fieldName = $modelName . '.name';

		$model = ClassRegistry::init($modelName);
		$result = $model->find('first', array(
			'conditions' => array($fieldName => $params[$name]),
			'fields' => array($fieldId, $fieldName),
			'recursive' => -1
		));
		if ($result === false || $result === null) { // false -> fail find(), null -> not found data
			return false;
		}
		$projectId = Set::extract($fieldId, $result);
		$projectName = Set::extract($fieldName, $result);
		if ($projectId !== null && $projectName !== null) {
			Configure::write('projectId', $projectId);
			Configure::write('projectName', $projectName);
			return $params;
		}
		return false;
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @param array $url An array of parameters to check matching with.
	 *
	 * @see cake/libs/CakeRoute#match($url)
	 *
	 * @return mixed Either a string url for the parameters if they match or false.
	 */
	function match($url)
	{
		$projectName = Configure::read('projectName');
		if ($projectName === null) return false;
		if (!isset($url['project'])) {
			$url['project'] = $projectName;
		}
		return parent::match($url);
	}



	/**
	 * getter
	 * get `project`.`id`
	 *
	 * @return string | null
	 */
	public static function getProjectId()
	{
		return self::$__projectId;
	}

	public static function getUserId()
	{
		$result = Set::extract('Auth.User.id', $_SESSION);
		if ($result === array()) return null;
		return $result;
	}
}
