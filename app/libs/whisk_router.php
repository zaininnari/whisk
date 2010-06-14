<?php

class WhiskRouter extends Router
{

	private static $_projectId;

	public static function setProjectBaseUrl($url = null)
	{
		$self = self::getInstance();

		if (is_string($url)) {
			$params = Router::parse($url);
			if ($params !== false
				&& isset($params['controller'], $params['action'])
				&& $params['controller'] === 'users'
				&& $params['action'] === 'login'
			) {
				$self->__paths[0]['base'] = '';
				return $url;
			}
		}

		if (isset($self->__paths[0])) {
			if (isset($self->__params[0]['project'])) {
				$self->__paths[0]['base'] = '/' . WHISK_PROJECT_URL . '/' . $self->__params[0]['project'];
			}
			if (is_array($url)) {
				if (isset($url['base'])) {
					$self->__paths[0]['base'] = $url['base'];
				} elseif (isset($url['__project'])) {
					$self->__paths[0]['base'] = '/' . WHISK_PROJECT_URL . '/' . $url['__project'];
					unset($url['__project']);
				}
			}
		}
		return $url;
	}


	/**
	 * Finds URL for specified action.
	 *
	 * @see cake/libs/router.php
	 *
	 */
	function url($url = null, $full = false) {
		$url = self::setProjectBaseUrl($url);
		return parent::url($url, $full);
	}

}
