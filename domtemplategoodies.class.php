<?php

/**
 * @package DOMTemplateGoodies
 * @autho Philip Butkiewicz aka. bagnz0r <http://bagnohax.pl>
 */

class DOMTemplateGoodies implements rocketsled\Runnable {

	public function run() {
		$goodie = new DOMTemplateAppPaths(PACKAGES_DIR . '/MagnumSubscriptionsHtml/dashboard.html', '/test/');
		$goodie->process();
		echo $goodie->template()->html();
	}

}