<?php
 /**
  * WordPress settings API class
  *
  * @link       https://wpruby.com
  * @since      1.0.0
  *
  * @package    WPRuby_Help_Desk_Settings
  * @subpackage WPRuby_Help_Desk_Settings/admin
  */

if ( !class_exists('WPRuby_Help_Desk_Settings' ) ):
class WPRuby_Help_Desk_Settings {

    private $settings_api;

    public function __construct() {
        $this->settings_api = new WPRuby_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    public function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    public function admin_menu() {
        add_submenu_page('edit.php?post_type=support_ticket',	__( 'Settings', 'wpruby-help-desk' ),	__( 'Settings', 'wpruby-help-desk' ),	'manage_options',	'wpruby-help-desk-settings',	array($this, 'plugin_page'));
    }

    public function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'wpruby_help_desk_general',
                'title' => __( 'General', 'wpruby-help-desk' )
            ),
            array(
                'id'    => 'wpruby_help_desk_attachments',
                'title' => __( 'Attachments', 'wpruby-help-desk' )
            )
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    public function get_settings_fields() {
        $agents = WPRuby_User::get_agents();
        $settings_fields = array(
            'wpruby_help_desk_general' => array(
              array(
                  'name'    => 'default_agent_assignee',
                  'label'   => __( 'Assign tickets by default to:', 'wpruby-help-desk' ),
                  'desc'    => __( 'When a ticket is created, it will be assigned to the selected agent.', 'wpruby-help-desk' ),
                  'type'    => 'select',
                  'options' => $agents
              ),
              array(
                  'name'  => 'enable_email_transcript',
                  'label' => __( 'Enable Ticket Email Transcript', 'wpruby-help-desk' ),
                  'desc'  => __( 'If this option is enabled, a transcript text file of the ticket will be sent to the client email when the ticket is closed.', 'wpruby-help-desk' ),
                  'type'  => 'checkbox'
              ),

            ),
            'wpruby_help_desk_attachments' => array(
              array(
                  'name'  => 'enable_attachments',
                  'label' => __( 'Enable Attachments', 'wpruby-help-desk' ),
                  'desc'  => __( 'Check this if you want to allow clients and agents to upload file attachments with the support tickets.', 'wpruby-help-desk' ),
                  'type'  => 'checkbox'
              ),
              array(
                  'name'              => 'max_size_attachments',
                  'label'             => __( 'Maximum file size', 'wpruby-help-desk' ),
                  'desc'              => __( 'Maximum file size for each file attachment (in MB)', 'wpruby-help-desk' ),
                  'placeholder'       => __( '2', 'wpruby-help-desk' ),
                  'min'               => 0,
                  'max'               => 1000,
                  'step'              => '1',
                  'type'              => 'number',
                  'default'           => '5',
                  'sanitize_callback' => 'floatval'
              ),
                array(
                    'name'        => 'allowed_extensions_attachments',
                    'label'       => __( 'Allowed File Extensions', 'wpruby-help-desk' ),
                    'desc'        => __( 'The allowed file extensions for support ticket attachments, separated by a comma (,).', 'wpruby-help-desk' ),
                    'placeholder' => __( 'pdf,jpg,png,zip', 'wpruby-help-desk' ),
                    'default'     => 'pdf,jpg,png,zip',
                    'type'        => 'textarea'
                ),


            )
        );

        return $settings_fields;
    }

    public function plugin_page() {
        echo '<div id="wpruby_help_desk_settings_page" class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    public function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }


    public function get_option($option = '', $section = ''){
      return $this->settings_api->get_option($option, $section );
    }

}
endif;
