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
	function url($url = null, $full = false) {return parent::url($url, $full);
		$url = self::setProjectBaseUrl($url);

		return parent::url($url, $full);

		$defaults = $params = array('plugin' => null, 'controller' => null, 'action' => 'index');

		if (is_bool($full)) {
			$escape = false;
		} else {
			extract($full + array('escape' => false, 'full' => false));
		}

		if (!empty($self->__params)) {
			if (isset($this) && !isset($this->params['requested'])) {
				$params = $self->__params[0];
			} else {
				$params = end($self->__params);
			}
		}
		$path = array('base' => null);

		if (!empty($self->__paths)) {
			if (isset($this) && !isset($this->params['requested'])) {
				$path = $self->__paths[0];var_dump(2);
			} else {
				$path = end($self->__paths);
			}
		}

		// {{{!add
		$__project = false;
		if ($path['base'] === null || $path['base'] === '') {
			if (isset($self->__params[0]['project'])) {
				$path['base'] = '/' . WHISK_PROJECT_URL . '/' . $self->__params[0]['project'];
				$__project = true;
			}
			if (is_array($url) && isset($url['__project'])) {
				$path['base'] = '/' . WHISK_PROJECT_URL . '/' . $url['__project'];
				unset($url['__project']);
				$__project = true;
			}
		}
		// }}}!add

		$base = $path['base'];
		$extension = $output = $mapped = $q = $frag = null;

		if (is_array($url)) {
			if (isset($url['base']) && $url['base'] === false) {
				$base = null;
				unset($url['base']);
			}
			if (isset($url['full_base']) && $url['full_base'] === true) {
				$full = true;
				unset($url['full_base']);
			}
			if (isset($url['?'])) {
				$q = $url['?'];
				unset($url['?']);
			}
			if (isset($url['#'])) {
				$frag = '#' . urlencode($url['#']);
				unset($url['#']);
			}
			if (empty($url['action'])) {
				if (empty($url['controller']) || $params['controller'] === $url['controller']) {
					$url['action'] = $params['action'];
				} else {
					$url['action'] = 'index';
				}
			}

			$prefixExists = (array_intersect_key($url, array_flip($self->__prefixes)));
			foreach ($self->__prefixes as $prefix) {
				if (!empty($params[$prefix]) && !$prefixExists) {
					$url[$prefix] = true;
				} elseif (isset($url[$prefix]) && !$url[$prefix]) {
					unset($url[$prefix]);
				}
				if (isset($url[$prefix]) && strpos($url['action'], $prefix) === 0) {
					$url['action'] = substr($url['action'], strlen($prefix) + 1);
				}
			}

			$url += array('controller' => $params['controller'], 'plugin' => $params['plugin']);

			if (isset($url['ext'])) {
				$extension = '.' . $url['ext'];
				unset($url['ext']);
			}
			$match = false;

			for ($i = 0, $len = count($self->routes); $i < $len; $i++) {
				$originalUrl = $url;

				if (isset($self->routes[$i]->options['persist'], $params)) {
					$url = $self->routes[$i]->persistParams($url, $params);
				}

				if ($match = $self->routes[$i]->match($url)) {
					$output = trim($match, '/');
					break;
				}
				$url = $originalUrl;
			}
			if ($match === false) {
				$output = $self->_handleNoRoute($url);
			}
			$output = str_replace('//', '/', $base . '/' . $output);
		} else {
			if (((strpos($url, '://')) || (strpos($url, 'javascript:') === 0) || (strpos($url, 'mailto:') === 0)) || (!strncmp($url, '#', 1))) {
				return $url;
			}
			if (empty($url)) {
				if (!isset($path['here'])) {
					$path['here'] = '/';
				}
				$output = $path['here'];
			} elseif (substr($url, 0, 1) === '/') {
				$output = $base . $url;
			} else {
				$output = $base . '/';
				foreach ($self->__prefixes as $prefix) {
					if (isset($params[$prefix])) {
						$output .= $prefix . '/';
						break;
					}
				}
				if (!empty($params['plugin']) && $params['plugin'] !== $params['controller']) {
					$output .= Inflector::underscore($params['plugin']) . '/';
				}
				$output .= Inflector::underscore($params['controller']) . '/' . $url;
			}
			$output = str_replace('//', '/', $output);
		}
		if ($full && defined('FULL_BASE_URL')) {
			$output = FULL_BASE_URL . $output;
		}
		if (!empty($extension) && substr($output, -1) === '/') {
			$output = substr($output, 0, -1);
		}
		// {{{!add
		if ($__project) $output = rtrim($output, '/');
		// }}}!add
		return $output . $extension . $self->queryString($q, array(), $escape) . $frag;
	}

}
