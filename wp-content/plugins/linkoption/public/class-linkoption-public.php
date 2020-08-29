<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       -
 * @since      1.0.0
 *
 * @package    Linkoption
 * @subpackage Linkoption/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Linkoption
 * @subpackage Linkoption/public
 * @author     Aleks Ch <aleksander.chuyan@gmail.com>
 */
class Linkoption_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->my_plugin_options = get_option($this->plugin_name);

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/linkoption-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/linkoption-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Checks and applies settings for link attributes.
	 *
	 * @since    1.0.0
	 */

  	public function filter_link_options($content){

  		$post_type = get_post_type();
  		// var_dump($post_type); exit;

  		if(isset($post_type) && isset($this->my_plugin_options[$post_type])) {

  			// check post type
	  		$post_type_options_enabled = $this->my_plugin_options[$post_type];

	  		if(isset($post_type_options_enabled) && $post_type_options_enabled) {

		  		// check options rel_nofollow_attr & target_blank_attr
		  		$rel_nofollow_attr = $this->my_plugin_options['rel_nofollow_attr'];
		  		$target_blank_attr = $this->my_plugin_options['target_blank_attr'];

		  		if((isset($rel_nofollow_attr) && $rel_nofollow_attr) || (isset($target_blank_attr) && $target_blank_attr)) {

					$dom = new DOMDocument();
					libxml_use_internal_errors(true);

					$dom->preserveWhitespace = FALSE;

					$dom->loadHTML($content);

					// get all links
					$a = $dom->getElementsByTagName('a');

					$host = strtok($_SERVER['HTTP_HOST'], ':');

					foreach($a as $anchor) {

				        $href = $anchor->attributes->getNamedItem('href')->nodeValue;

				        // check internal/external domain
				        $internal = preg_match('/^https?:\/\/' . preg_quote($host, '/') . '/', $href);

						$href_parts = explode('/', $href);
						if(isset($href_parts[0]) && $href_parts[0] == '') { $internal2 = true; }
						else $internal2 = false;

						$href_parts = explode('?', $href);
						if(isset($href_parts[0]) && $href_parts[0] == '') { $internal3 = true; }
						else $internal3 = false;

				        if ($internal || $internal2 || $internal3) {
				           	continue;
				        }

				        if(isset($rel_nofollow_attr) && $rel_nofollow_attr) {
				        	$this->set_link_option($dom, $anchor, 'rel', 'nofollow');
					    }

				        if(isset($target_blank_attr) && $target_blank_attr) {
				        	$this->set_link_option($dom, $anchor, 'target', '_blank');
					    }

					}

					$content = $dom->saveHTML();
				}
			}
		}

		return $content;
	}

	/**
	 * Checks and sets specific values of link attributes
	 *
	 * @since    1.0.0
	 */

	private function set_link_option($dom = NULL, $anchor = NULL, $attr = '', $attr_value = ''){

		if(!isset($dom) || $dom == NULL || !isset($anchor) || $anchor == NULL)
			return;

        $old_attr = $anchor->attributes->getNamedItem($attr);

        if ($old_attr == NULL) {
            $new_attr = $attr_value;
        } else {
            $old_attr_value = $old_attr->nodeValue;
            $old_attr_value = explode(' ', $old_attr_value);
            if (in_array($attr_value, $old_attr_value)) {
                return;
            }
            $old_attr_value[] = $attr_value;
            $new_attr = implode(' ', $old_attr_value);
        }

        $new_attr_el = $dom->createAttribute($attr);
        $attr_node = $dom->createTextNode($new_attr);
        $new_attr_el->appendChild($attr_node);
        $anchor->appendChild($new_attr_el);
	}

}
