<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    Wpruby_Help_Desk
 * @subpackage Wpruby_Help_Desk/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wpruby_Help_Desk
 * @subpackage Wpruby_Help_Desk/includes
 * @author     WPRuby <info@wpruby.com>
 */
class Wpruby_Help_Desk {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wpruby_Help_Desk_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;
	/**
	 * The plugin settings Object.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $settings;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'wpruby-help-desk';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->settings = new WPRuby_Help_Desk_Settings();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wpruby_Help_Desk_Loader. Orchestrates the hooks of the plugin.
	 * - Wpruby_Help_Desk_i18n. Defines internationalization functionality.
	 * - Wpruby_Help_Desk_Admin. Defines all hooks for the admin area.
	 * - Wpruby_Help_Desk_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpruby-help-desk-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpruby-help-desk-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpruby-help-desk-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wpruby-help-desk-public.php';


		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpruby-ticket.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpruby-user.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpruby-email.php';


		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpruby-settings-api.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpruby-settings.php';



		$this->loader = new Wpruby_Help_Desk_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wpruby_Help_Desk_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wpruby_Help_Desk_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wpruby_Help_Desk_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_admin, 'register_post_types' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_taxonomies' );

		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add_tickets_metaboxes' );

		// info: custom action publish_{$custom_post_type}
		$this->loader->add_action( 'save_post', $plugin_admin, 'save_ticket_details', 10, 3 );

		// info: custom action to add fields to the new taxonomy term page {taxonomy}_add_form_fields
		$this->loader->add_action( WPRUBY_TICKET_STATUS . '_add_form_fields', $plugin_admin, 'add_color_field_to_ticket_status' );
		$this->loader->add_action( WPRUBY_TICKET_STATUS . '_edit_form_fields', $plugin_admin, 'edit_color_field_to_ticket_status' );

		$this->loader->add_action( 'edited_' . WPRUBY_TICKET_STATUS, $plugin_admin, 'save_ticket_status_color_meta' );
		$this->loader->add_action( 'create_' . WPRUBY_TICKET_STATUS, $plugin_admin, 'save_ticket_status_color_meta' );

		//info: add opened tickets count notice in the admin menu.
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'tickets_count' );


		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );


		$this->loader->add_filter( 'manage_'. WPRUBY_TICKET .'_posts_columns', $plugin_admin, 'set_custom_edit_support_ticket_columns', 1, 2 );
		$this->loader->add_action( 'manage_'. WPRUBY_TICKET .'_posts_custom_column', $plugin_admin, 'custom_support_ticket_column', 1, 2 );

		$this->loader->add_filter( 'manage_edit-' .  WPRUBY_TICKET_STATUS . '_columns', $plugin_admin, 'set_custom_ticket_status_columns_heads', 1, 2 );
		$this->loader->add_filter( 'manage_'. WPRUBY_TICKET_STATUS .'_custom_column', $plugin_admin, 'set_custom_ticket_status_columns_data', 10, 3 );

		//info: add plugin links to the top admin menu
		$this->loader->add_action( 'admin_bar_menu', $plugin_admin, 'add_quicklinks_to_admin_topbar', 100);

		//info: add the helpdesk status dashboard widget
		$this->loader->add_action( 'wp_dashboard_setup', $plugin_admin, 'helpdesk_status_dashboard_widget');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wpruby_Help_Desk_Public( $this->get_plugin_name(), $this->get_version(), $this->settings );

		//adding shortcodes
		add_shortcode('submit_ticket', array($plugin_public, 'shortcode_submit_ticket'));
		add_shortcode('my_tickets', array($plugin_public, 'shortcode_my_tickets'));
		add_shortcode('ruby_help_desk_login', array($plugin_public, 'shortcode_login_form'));
		add_shortcode('ruby_help_desk_signup', array($plugin_public, 'shortcode_signup_form'));

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'process_ticket_submission' );
		$this->loader->add_action( 'init', $plugin_public, 'process_ticket_reply' );
		$this->loader->add_action( 'init', $plugin_public, 'process_signup' );
		//info: Replace the default content of the Ticket Post Type.
		$this->loader->add_filter( 'the_content', $plugin_public, 'display_single_ticket' );

		$this->loader->add_filter( 'wp_handle_upload_prefilter', $plugin_public, 'validate_attachment_file' );

		//info: restrict tickets on the author
		$this->loader->add_action( 'wp', $plugin_public, 'restrict_tickets_pages' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wpruby_Help_Desk_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
