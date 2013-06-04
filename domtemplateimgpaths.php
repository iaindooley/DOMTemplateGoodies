<?php

/**
 * @package DOMTemplateGoodies
 * @autho Philip Butkiewicz aka. bagnz0r <http://bagnohax.pl>
 */
class DOMTemplateImgPaths
{

    /**
     * Contains our DOMTemplate object.
     * @var DOMTemplate
     */
    private $template;

    /**
     * Image path.
     * @var string
     */
    private $img_path;

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
    public function __construct( $template, $img_path = '/' )
    {
        $this->template = $template;
        $this->img_path = $img_path;
    }

    /**
     * @static
     * @param $path
     * @param string $app_path
     * @return mixed
     */
    public static function instance( $template, $app_path = '/' )
    {
        if ( is_null( DOMTemplateAppPaths::$instance ) ) DOMTemplateAppPaths::$instance = new DOMTemplateAppPaths( $template, $app_path );

        return DOMTemplateAppPaths::$instance;
    }

    /**
     * This method processes the template and fixes paths.
     * @return $this
     */
    public function process()
    {
        // Select all script tags (within <body> tag only) and process them.
        $nodes = $this->template->query( 'img@src' );
        $this->apply_path_to_nodes( $nodes );

        return $this;
    }

    /**
     * Template getter.
     * @return DOMTemplate
     */
    public function template()
    {
        return $this->template;
    }

    /**
     * Apply app path to nodes.
     * @param DOMNodeList $nodes
     */
    private function apply_path_to_nodes( &$nodes )
    {
        foreach ( $nodes as $node )
        {
            if ( !preg_match( '/http|https\:\/\/(.*)/', $node->nodeValue ) )
            {
                $node->nodeValue = $this->img_path . '/' . $node->nodeValue;
            }
        }
    }

}

?>