<?php

/**
 *
 * @link              https://wpruby.com
 * @since             1.0.0
 * @package           Ruby_Help_Desk
 *
 * @wordpress-plugin
 * Plugin Name:       Ruby Help Desk
 * Plugin URI:        https://wpruby.com/plugin/ruby-help-desk
 * Description:       A simple Help Desk to support your customers efficiently.
 * Version:           1.1.0
 * Author:            WPRuby
 * Author URI:        https://wpruby.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ruby-help-desk
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
define('RHD_VERSION', 					'1.2.0');
// define the plugin constants
define('RHD_TICKET', 					'support_ticket');
define('RHD_KNOWLEDGEBASE', 	'help_knowledgebase');
define('RHD_TICKET_REPLY', 		'support_ticket_reply');
define('RHD_TICKET_STATUS', 	'tickets_status');
define('RHD_TICKET_PRODUCT', 	'tickets_products');
//Help Desk roles
define('RHD_AGENT', 					'ruby_desk_agent');
define('RHD_CUSTOMER', 				'ruby_desk_customer');


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ruby-help-desk.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ruby-help-desk-activator.php
 */
function rhd_activate_help_desk() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ruby-help-desk-activator.php';
	$plugin_name = 'ruby-help-desk';
	$plugin_admin = new RHD_Admin( $plugin_name, RHD_VERSION );
	$plugin_admin->register_post_types();
	$plugin_admin->register_taxonomies();
	$activator = new RHD_Activator();
	$activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ruby-help-desk-deactivator.php
 */
function rhd_deactivate_help_desk() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ruby-help-desk-deactivator.php';
	RHD_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'rhd_activate_help_desk' );
register_deactivation_hook( __FILE__, 'rhd_deactivate_help_desk' );



/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function rhd_run_help_desk() {
	$plugin = new Ruby_Help_Desk();
	$plugin->run();
}
rhd_run_help_desk();
