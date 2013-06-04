<?php

/**
 * @package DOMTemplateGoodies
 * @autho Philip Butkiewicz aka. bagnz0r <http://bagnohax.pl>
 */

class DOMTemplateAppPaths {

	/**
	 * Contains our DOMTemplate object.
	 * @var DOMTemplate
	 */
	private $template;

	/**
	 * Application path.
	 * @var string
	 */
	private $app_path;

	/**
	 * Class instance.
	 * @var $this
	 */
	protected static $instance;

	/**
	 * @param string $path
	 * @param string $app_path
	 * @throws Exception
	 */
	public function __construct($path, $app_path = '/', $is_html = false) 
        {
            if($is_html)
            {
                $this->template = new DOMTemplate($path);
                $this->app_path = $app_path;
            }
            else
            {
                if (!file_exists($path))
                {
                        throw new Exception('Template \'' . basename($path). '\' doesn\'t exist!');
                }
                $text = file_get_contents($path);
                $this->template = new DOMTemplate($text);
                $this->app_path = $app_path;
            }
	}

	/**
	 * @static
	 * @param $path
	 * @param string $app_path
	 * @return mixed
	 */
	public static function instance($path, $app_path = '/') {
		if (is_null(DOMTemplateAppPaths::$instance))
			DOMTemplateAppPaths::$instance = new DOMTemplateAppPaths($path, $app_path);

		return DOMTemplateAppPaths::$instance;
	}

	/**
	 * This method processes the template and fixes paths.
	 * @return $this
	 */
	public function process() {
		// Select all script tags (within <head> tag only) and process them.
		$nodes = $this->template->query('.//head/script/@src');
		$this->apply_path_to_nodes($nodes);

		// Select all style tags (within <head> tag only) and process them.
		$nodes = $this->template->query('.//head/link[@rel="stylesheet"]/@href');
		$this->apply_path_to_nodes($nodes);

		return $this;
	}

	/**
	 * Template getter.
	 * @return DOMTemplate
	 */
	public function template() {
		return $this->template;
	}

	/**
	 * Apply app path to nodes.
	 * @param DOMNodeList $nodes
	 */
	private function apply_path_to_nodes(&$nodes) {
		foreach ($nodes as $node) {
			if (!preg_match('/http|https\:\/\/(.*)/', $node->nodeValue))
				$node->nodeValue = $this->app_path . '/' . $node->nodeValue;
		}
	}
}