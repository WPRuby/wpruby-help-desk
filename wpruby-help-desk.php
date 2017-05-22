<?php

/**
 *
 * @link              https://wpruby.com
 * @since             1.0.0
 * @package           Wpruby_Help_Desk
 *
 * @wordpress-plugin
 * Plugin Name:       Ruby Help Desk
 * Plugin URI:        https://wpruby.com/plugin/ruby-help-desk
 * Description:       A simple Help Desk to support your customers efficiently.
 * Version:           1.0.0
 * Author:            WPRuby
 * Author URI:        https://wpruby.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpruby-help-desk
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
define('RHD_VERSION', 					'1.0.0');
// define the plugin constants
define('WPRUBY_TICKET', 				'support_ticket');
define('WPRUBY_KNOWLEDGEBASE', 	'help_knowledgebase');
define('WPRUBY_TICKET_REPLY', 	'support_ticket_reply');
define('WPRUBY_TICKET_STATUS', 	'tickets_status');
define('WPRUBY_TICKET_PRODUCT', 'tickets_products');
//Help Desk roles
define('WPRUBY_AGENT', 					'ruby_desk_agent');
define('WPRUBY_CUSTOMER', 			'ruby_desk_customer');


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpruby-help-desk.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpruby-help-desk-activator.php
 */
function activate_wpruby_help_desk() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpruby-help-desk-activator.php';
	$plugin_name = 'wpruby-help-desk';
	$plugin_admin = new Wpruby_Help_Desk_Admin( $plugin_name, RHD_VERSION );
	$plugin_admin->register_post_types();
	$plugin_admin->register_taxonomies();
	$activator = new Wpruby_Help_Desk_Activator();
	$activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpruby-help-desk-deactivator.php
 */
function deactivate_wpruby_help_desk() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpruby-help-desk-deactivator.php';
	Wpruby_Help_Desk_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpruby_help_desk' );
register_deactivation_hook( __FILE__, 'deactivate_wpruby_help_desk' );



/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpruby_help_desk() {
	$plugin = new Wpruby_Help_Desk();
	$plugin->run();
}
run_wpruby_help_desk();
