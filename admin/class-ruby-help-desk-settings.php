<?php
 /**
  * WordPress settings API class
  *
  * @link       https://wpruby.com
  * @since      1.0.0
  *
  * @package    RHD_Settings
  * @subpackage RHD_Settings/admin
  */

if ( !class_exists('RHD_Settings' ) ):
class RHD_Settings {

    private $settings_api;

    public function __construct() {
        $this->settings_api = new RHD_Settings_API;

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
        add_submenu_page('edit.php?post_type=support_ticket',	__( 'Settings', 'ruby-help-desk' ),	__( 'Settings', 'ruby-help-desk' ),	'manage_options',	'ruby-help-desk-settings',	array($this, 'plugin_page'));
    }

    public function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'rhd_general',
                'title' => __( 'General', 'ruby-help-desk' )
            ),
            array(
                'id'    => 'rhd_attachments',
                'title' => __( 'Attachments', 'ruby-help-desk' )
            ),
            array(
                'id'    => 'rhd_sync_products',
                'title' => __( 'Sync Products', 'ruby-help-desk' )
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
        $agents = RHD_User::get_agents();
        $settings_fields = array(
            'rhd_general' => array(
              array(
                  'name'    => 'default_agent_assignee',
                  'label'   => __( 'Assign tickets by default to:', 'ruby-help-desk' ),
                  'desc'    => __( 'When a ticket is created, it will be assigned to the selected agent.', 'ruby-help-desk' ),
                  'type'    => 'select',
                  'options' => $agents
              ),
              array(
                  'name'  => 'enable_email_transcript',
                  'label' => __( 'Enable Ticket Email Transcript', 'ruby-help-desk' ),
                  'desc'  => __( 'If this option is enabled, a transcript text file of the ticket will be sent to the client email when the ticket is closed.', 'ruby-help-desk' ),
                  'type'  => 'checkbox'
              ),

            ),
            'rhd_attachments' => array(
              array(
                  'name'  => 'enable_attachments',
                  'label' => __( 'Enable Attachments', 'ruby-help-desk' ),
                  'desc'  => __( 'Check this if you want to allow clients and agents to upload file attachments with the support tickets.', 'ruby-help-desk' ),
                  'type'  => 'checkbox'
              ),
              array(
                  'name'              => 'max_size_attachments',
                  'label'             => __( 'Maximum file size', 'ruby-help-desk' ),
                  'desc'              => __( 'Maximum file size for each file attachment (in MB)', 'ruby-help-desk' ),
                  'placeholder'       => __( '2', 'ruby-help-desk' ),
                  'min'               => 0,
                  'max'               => 1000,
                  'step'              => '1',
                  'type'              => 'number',
                  'default'           => '5',
                  'sanitize_callback' => 'floatval'
              ),
                array(
                    'name'        => 'allowed_extensions_attachments',
                    'label'       => __( 'Allowed File Extensions', 'ruby-help-desk' ),
                    'desc'        => __( 'The allowed file extensions for support ticket attachments, separated by a comma (,).', 'ruby-help-desk' ),
                    'placeholder' => __( 'pdf,jpg,png,zip', 'ruby-help-desk' ),
                    'default'     => 'pdf,jpg,png,zip',
                    'type'        => 'textarea'
                ),


            ),
            'rhd_sync_products' => array(
              array(
                  'name'        => 'sync_wc_products',
                  'label'       => __( 'Sync WooCommerce Products', 'ruby-help-desk' ),
                  'desc'        => __( "Click to import WooCommerce products as Ruby Help Desk products. If the same product's name exists, it will be ignored.", 'ruby-help-desk' ),
                  'type'        => 'button',
                  'placeholder' => __('Sync', 'ruby-help-desk'),
              ),
              array(
                  'name'        => 'sync_edd_products',
                  'label'       => __( 'Sync EDD Products', 'ruby-help-desk' ),
                  'desc'        => __( "Click to import Easy Digital Downloads products as Ruby Help Desk products. If the same product's name exists, it will be ignored.", 'ruby-help-desk' ),
                  'type'        => 'button',
                  'placeholder' => __('Sync', 'ruby-help-desk'),
              ),
            )
        );

        return $settings_fields;
    }

    public function plugin_page() {
        echo '<div id="rhd_settings_page" class="wrap">';

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
