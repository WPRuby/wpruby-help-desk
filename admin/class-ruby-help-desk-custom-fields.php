<?php
/**
 * The Custom Fields helper class of the plugin.
 *
 *
 * @package    RHD_Custom_Fields
 * @subpackage RHD_Custom_Fields/admin
 * @author     WPRuby <info@wpruby.com>
 */
class RHD_Custom_Fields {


  /**
  * Setup default core components
  * @since 1.2.0
  */
  public function get_components()
  {
    $components = array(
      'rhd_text'  =>  array(
        'id'          => 'rhd_text',
        'core'        => true,
        'type'        => 'text',
        'label'       => __('Text', 'ruby-help-desk'),
        'description' => '',
        'required'    => 'no',
        'size'        => 'medium',
        'default'     => '',
      ),
      'rhd_select'  =>  array(
        'id'          => 'rhd_select',
        'core'        => true,
        'type'        => 'select',
        'label'       => __('Multiple Options', 'ruby-help-desk'),
        'description' => '',
        'required'    => 'no',
        'size'        => 'medium',
        'default'     => array(),
      ),
    );
    //@TODO add_filter
    return $components;
  }
  /**
  * Setup default fields
  * @since 1.2.0
  */
  public function get_fields()
  {
    $products = get_terms( RHD_TICKET_PRODUCT, array(	'hide_empty' => false		) );

    $core_fields = array(
      'rhd_ticket_subject'  =>  array(
        'id'          => 'rhd_ticket_subject',
        'core'        => true,
        'type'        => 'text',
        'label'       => __('Ticket Subject', 'ruby-help-desk'),
        'description' => '',
        'required'    => 'yes',
        'size'        => 'medium',
        'default'     => '',
      ),
      'rhd_products'  =>  array(
        'id'          => 'rhd_products',
        'core'        => true,
        'type'        => 'select',
        'label'       => __('Product', 'ruby-help-desk'),
        'description' => '',
        'required'    => 'yes',
        'size'        => 'medium',
        'default'     => array(),
      ),
      'rhd_ticket_description'  =>  array(
        'id'          => 'rhd_ticket_description',
        'core'        => true,
        'type'        => 'editor',
        'label'       => __('Ticket Description', 'ruby-help-desk'),
        'description' => '',
        'required'    => 'yes',
        'size'        => 'medium',
        'default'     => '',
      ),
      'rhd_attachments'  =>  array(
        'id'          => 'rhd_attachments',
        'core'        => true,
        'type'        => 'attachment',
        'label'       => __('Attachments', 'ruby-help-desk'),
        'description' => __('Allowed Extensions: pdf,jpg,png,zip', 'ruby-help-desk'),
        'required'    => 'yes',
        'size'        => 'medium',
        'default'     => null,
      ),
    );
    $fields = get_option('saved_cusom_fields', $core_fields);
    //@TODO add_filter
    return $fields;
  }
}
