<?php

/**
 * @package DOMTemplateGoodies
 * @autho Philip Butkiewicz aka. bagnz0r <http://bagnohax.pl>
 */

spl_autoload_register(function($class) {
	switch ($class) {
		case 'DOMTemplateGoodies':
			require_once dirname(__FILE__). '/domtemplategoodies.class.php';
			break;
		case 'DOMTemplateAppPaths':
			require_once dirname(__FILE__). '/domtemplateapppaths.php';
			break;
	}
});