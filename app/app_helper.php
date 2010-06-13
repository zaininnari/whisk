<?php

App::import('Core', 'Helper');

require_once 'HatenaSyntax.php';

class AppHelper extends Helper
{
/*	function url($url = null, $full = false)
	{
		return h(WhiskRouter::url($url, $full));
	}*/

	function wiki($text, $escape = false)
	{
		if (empty($text)) return $text;
		$text = HatenaSyntax::render($text);
		return $escape ? h($text) : $text;
	}

}
