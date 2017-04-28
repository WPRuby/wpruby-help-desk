<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wpruby.com
 * @since             1.0.0
 * @package           Wpruby_Help_Desk
 *
 * @wordpress-plugin
 * Plugin Name:       Ruby Help Desk
 * Plugin URI:        https://wpruby.com/plugin/help-desk
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
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

// define the plugin constants
define('WPRUBY_TICKET', 'support_ticket');
define('WPRUBY_TICKET_REPLY', 'support_ticket_reply');
define('WPRUBY_TICKET_STATUS', 'tickets_status');
define('WPRUBY_TICKET_PRODUCT', 'tickets_products');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpruby-help-desk-activator.php
 */
function activate_wpruby_help_desk() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpruby-help-desk-activator.php';
	Wpruby_Help_Desk_Activator::activate();
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
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpruby-help-desk.php';

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


add_filter( 'manage_support_ticket_posts_columns', 'set_custom_edit_support_ticket_columns' );
add_action( 'manage_support_ticket_posts_custom_column' , 'custom_support_ticket_column', 1, 2 );

function set_custom_edit_support_ticket_columns($columns) {
    unset( $columns['taxonomy-tickets_status'] );
    $columns['support_ticket_author'] = __( 'Status', 'wpruby-help-desk' );
    return $columns;
}

function custom_support_ticket_column( $column, $post_id ) {
    switch ( $column ) {

        case 'support_ticket_author' :
						$ticket = new WPRuby_Ticket(	$post_id	);
						$ticket_status = $ticket->get_status();
						if($ticket_status){
							echo '<span class="ticket_status_label" style="background:'.$ticket_status['color'].';">'. $ticket_status['name'] .'</span>';
						}else{
							_e( '-', 'wpruby-help-desk' );
						}
            break;



    }
}
