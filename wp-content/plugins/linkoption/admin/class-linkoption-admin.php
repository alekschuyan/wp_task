<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       -
 * @since      1.0.0
 *
 * @package    Linkoption
 * @subpackage Linkoption/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Linkoption
 * @subpackage Linkoption/admin
 * @author     Aleks Ch <aleksander.chuyan@gmail.com>
 */
class Linkoption_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->my_plugin_options = get_option($this->plugin_name);

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/linkoption-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/linkoption-admin.js', array( 'jquery' ), $this->version, false );

	}

    public function add_plugin_admin_menu() {

        add_options_page( 'Plugin options', 'Linkoption', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
        );
    }

    public function add_action_links( $links ) {
        
       $settings_link = array(
        '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
       );
       return array_merge(  $settings_link, $links );

    }

    public function display_plugin_setup_page() {
        
        include_once( 'partials/linkoption-admin-display.php' );
        
    }

   	public function validate($input) {
     	$valid = array();
     	return $valid;
   	}

   	public function options_update() {
        register_setting($this->plugin_name, $this->plugin_name, array());
    }

   	public function post_types_list() {

   		$args = array(
   			'public' => 1
   		);
        $post_types = get_post_types($args);

        if(isset($post_types['attachment']))
        	unset($post_types['attachment']);

        return $post_types;
    }

}
