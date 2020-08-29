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

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Linkoption_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Linkoption_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/linkoption-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Linkoption_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Linkoption_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/linkoption-public.js', array( 'jquery' ), $this->version, false );

	}

  	public function filter_link_options($content){

  		// check options rel_nofollow_attr & target_blank_attr
  		if((isset($this->my_plugin_options['rel_nofollow_attr']) && $this->my_plugin_options['rel_nofollow_attr']) || (isset($this->my_plugin_options['target_blank_attr']) && $this->my_plugin_options['target_blank_attr'])) {

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

		        if(isset($this->my_plugin_options['rel_nofollow_attr']) && $this->my_plugin_options['rel_nofollow_attr']) {

			        $nofollow_rel = 'nofollow';
			        $old_nofollow_attr = $anchor->attributes->getNamedItem('rel');

			        if ($old_nofollow_attr == NULL) {
			            $new_nofollow = $nofollow_rel;
			        } else {
			            $old_nofollow = $old_nofollow_attr->nodeValue;
			            $old_nofollow = explode(' ', $old_nofollow);
			            if (in_array($nofollow_rel, $old_nofollow)) {
			                continue;
			            }
			            $old_nofollow[] = $nofollow_rel;
			            $new_nofollow = implode(' ', $old_nofollow);
			        }

			        $new_nofollow_attr = $dom->createAttribute('rel');
			        $nofollow_node = $dom->createTextNode($new_nofollow);
			        $new_nofollow_attr->appendChild($nofollow_node);
			        $anchor->appendChild($new_nofollow_attr);
			    }

		        if(isset($this->my_plugin_options['target_blank_attr']) && $this->my_plugin_options['target_blank_attr']) {

			        $target_blank = '_blank';
			        $old_target_attr = $anchor->attributes->getNamedItem('target');

			        if ($old_target_attr == NULL) {
			            $new_target = $target_blank;
			        } else {
			            $old_target = $old_target_attr->nodeValue;
			            $old_target = explode(' ', $old_target);
			            if (in_array($target_blank, $old_target)) {
			                continue;
			            }
			            $old_target[] = $target_blank;
			            $new_target = implode(' ', $old_target);
			        }

			        $new_target_attr = $dom->createAttribute('target');
			        $target_blank_node = $dom->createTextNode($new_target);
			        $new_target_attr->appendChild($target_blank_node);
			        $anchor->appendChild($new_target_attr);
			    }

			}

			$content = $dom->saveHTML();
		}

		return $content;
	}

}
