<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    Wpruby_Help_Desk
 * @subpackage Wpruby_Help_Desk/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wpruby_Help_Desk
 * @subpackage Wpruby_Help_Desk/admin
 * @author     WPRuby <info@wpruby.com>
 */
class Wpruby_Help_Desk_Admin {

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

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpruby_Help_Desk_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpruby_Help_Desk_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpruby-help-desk-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpruby_Help_Desk_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpruby_Help_Desk_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpruby-help-desk-admin.js', array( 'jquery' ), $this->version, false );

	}
	/**
	 * The plugin use this method to register the main custom post type of the links.
	 *
	 * @since    1.0.0
	 */
	public function register_post_types(){
		$labels = array(
			'name'               => _x( 'Tickets', 'post type general name', 'wpruby-help-desk' ),
			'singular_name'      => _x( 'Create Ticket', 'post type singular name', 'wpruby-help-desk' ),
			'menu_name'          => _x( 'Ruby Desk', 'admin menu', 'wpruby-help-desk' ),
			'name_admin_bar'     => _x( 'Ticket', 'add new on admin bar', 'wpruby-help-desk' ),
			'add_new'            => _x( 'Create Ticket', 'book', 'wpruby-help-desk' ),
			'add_new_item'       => __( 'Create New Ticket', 'wpruby-help-desk' ),
			'new_item'           => __( 'Create New Ticket', 'wpruby-help-desk' ),
			'edit_item'          => __( 'Edit Ticket', 'wpruby-help-desk' ),
			'view_item'          => __( 'View Ticket', 'wpruby-help-desk' ),
			'all_items'          => __( 'All Tickets', 'wpruby-help-desk' ),
			'search_items'       => __( 'Search Tickets', 'wpruby-help-desk' ),
			'parent_item_colon'  => __( 'Parent Tickets:', 'wpruby-help-desk' ),
			'not_found'          => __( 'No tickets found.', 'wpruby-help-desk' ),
			'not_found_in_trash' => __( 'No tickets found in Trash.', 'wpruby-help-desk' )
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'support_ticket' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			//'supports'           => array(  'author' ),
			'menu_icon'			 => 'dashicons-editor-unlink',

		);

		register_post_type( 'support_ticket', $args );
	}

	/**
		 * The plugin use this method to register the custom taxonomies of the links.
		 * @since    1.0.0
		 */
		public function register_taxonomies(){
			$labels = array(
				'name'                       => _x( 'Ticket Statuses', 'taxonomy general name' ),
				'singular_name'              => _x( 'Ticket Status', 'taxonomy singular name' ),
				'search_items'               => __( 'Search Ticket Statuses', 'wpruby-help-desk' ),
				'popular_items'              => __( 'Popular Ticket Statuses', 'wpruby-help-desk' ),
				'all_items'                  => __( 'All Ticket Statuses','wpruby-help-desk' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __( 'Edit Ticket Status','wpruby-help-desk' ),
				'update_item'                => __( 'Update Ticket Status','wpruby-help-desk' ),
				'add_new_item'               => __( 'Add New Ticket Status','wpruby-help-desk' ),
				'new_item_name'              => __( 'New Ticket Status','wpruby-help-desk' ),
				'separate_items_with_commas' => __( 'Separate statuses with commas','wpruby-help-desk' ),
				'add_or_remove_items'        => __( 'Add or remove ticket status','wpruby-help-desk' ),
				'choose_from_most_used'      => __( 'Choose from the most used statuses','wpruby-help-desk' ),
				'not_found'                  => __( 'No Tickets Statuses found.','wpruby-help-desk' ),
				'menu_name'                  => __( 'Ticket Statuses','wpruby-help-desk' ),
			);

			$args = array(
				'hierarchical'          => true,
				'labels'                => $labels,
				'show_ui'               => true,
				'show_admin_column'     => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var'             => true,
				'rewrite'               => array( 'slug' => 'statuses' ),
			);

			register_taxonomy( 'tickets_status', 'support_ticket', $args );
		}


}
