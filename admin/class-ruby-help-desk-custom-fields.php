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

  private $in_metabox;
  private $ticket_id;
  private $multivalue_fields;

  public function __construct($in_metabox = false){
    $this->in_metabox = $in_metabox;
    if($this->in_metabox == true && isset($_GET['post'])){
      $this->ticket_id = intval($_GET['post']);
    }
    $this->multivalue_fields = array( 'checkbox' );
  }
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
        'label'       => __('Select List', 'ruby-help-desk'),
        'description' => '',
        'required'    => 'no',
        'size'        => 'medium',
        'default'     => '',
      ),
      'rhd_checkbox'  =>  array(
        'id'          => 'rhd_checkbox',
        'core'        => true,
        'type'        => 'checkbox',
        'label'       => __('Checkboxes', 'ruby-help-desk'),
        'description' => '',
        'required'    => 'no',
        'size'        => 'medium',
        'default'     => '',
      ),
      'rhd_radio'  =>  array(
        'id'          => 'rhd_radio',
        'core'        => true,
        'type'        => 'radio',
        'label'       => __('Radio Buttons', 'ruby-help-desk'),
        'description' => '',
        'required'    => 'no',
        'size'        => 'medium',
        'default'     => '',
      ),

      'rhd_textarea'  =>  array(
          'id'          => 'rhd_textarea',
          'core'        => true,
          'type'        => 'textarea',
          'label'       => __('Text Box', 'ruby-help-desk'),
          'description' => '',
          'required'    => 'no',
          'size'        => 'medium',
          'default'     => '',
      ),
      'rhd_date'  =>  array(
          'id'          => 'rhd_date',
          'core'        => true,
          'type'        => 'date',
          'label'       => __('Date', 'ruby-help-desk'),
          'description' => '',
          'required'    => 'no',
          'size'        => 'medium',
          'default'     => '',
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
    $core_fields = $this->get_core_fields();
    $fields = get_option('rhd_saved_cusom_fields', $core_fields);
    if(!is_array($fields)){
      return $this->populate_fields($core_fields);
    }
    //@TODO add_filter
    return $this->populate_fields($fields);
  }

  /**
  * Get the keys of the added custom fields
  * @since 1.2.0
  */
  public function get_custom_fields_keys(){
    return array_diff(array_keys($this->get_fields()), array_keys($this->get_core_fields()));
  }
  /**
  * Get Custom Fields
  * @since 1.2.0
  */
  public function get_custom_fields(){
    $fields = array_intersect_key( $this->get_fields(), array_flip($this->get_custom_fields_keys()));
    $fields = $this->populate_fields($fields);
    return $fields;
  }

  public function populate_fields($fields){
      foreach($fields as $key => $field){
        $field_value = get_post_meta($this->ticket_id, $key, true);
        $empty_value = (in_array($field['type'], $this->multivalue_fields))?array():'';
        $fields[$key]['value'] = ($field_value)? $field_value: $empty_value;
      }
    return $fields;
  }

  public function get_core_fields(){
    return array(
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
      'rhd_ticket_product'  =>  array(
        'id'          => 'rhd_ticket_product',
        'core'        => true,
        'type'        => 'select',
        'label'       => __('Product', 'ruby-help-desk'),
        'description' => '',
        'required'    => 'yes',
        'size'        => 'medium',
        'default'     => '',
      ),
      'rhd_ticket_reply'  =>  array(
        'id'          => 'rhd_ticket_reply',
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
        'default'     => '',
      ),
    );
  }




  public function display($field){
    return call_user_func(array($this , 'display_' . $field['type'] ), $field);
  }





  public function the_field_description($field){
    if($this->in_metabox == true) return;
    echo sprintf('<span class="rhd_description">%s</span>', $field['description']);
  }




  public function the_field_label($field){
    echo sprintf('<label class="rhd_label" for="%s">%s</label>', $field['id'], $field['label']);
  }




  public function display_text($field){
    ob_start();
    echo '<p>';
    $this->the_field_label($field);
    echo sprintf('<input type="text" id="%s" name="%s" class="rhd_%s_field" value="%s">', $field['id'], $field['id'], $field['size'], $field['value']);
    $this->the_field_description($field);
    echo '</p>';
    return ob_get_clean();
  }



  public function display_date($field){
    ob_start();
    echo '<p>';
    $this->the_field_label($field);echo '<br>';
    echo sprintf('<input type="date" id="%s" name="%s" class="rhd_%s_field" value="%s">', $field['id'], $field['id'], $field['size'], $field['value']);
    $this->the_field_description($field);
    echo '</p>';
    return ob_get_clean();
  }

  public function display_textarea($field){
    ob_start();
    echo '<p>';
    $this->the_field_label($field); echo '<br>';
    echo sprintf('<textarea id="%s" name="%s" class="rhd_%s_field">%s</textarea>', $field['id'], $field['id'], $field['size'], $field['value']);
    $this->the_field_description($field);
    echo '</p>';
    return ob_get_clean();
  }
  public function display_select($field){
    if($field['id'] == 'rhd_ticket_product'){
      $field['options'] = $this->get_products();
    }
    ob_start();
    echo '<p>';
    $this->the_field_label($field);
    echo sprintf('<select id="%s" class="rhd_%s_field" name="%s">', $field['id'], $field['size'], $field['id'] );
    if(isset($field['options']) && is_array($field['options'])){
      foreach ($field['options'] as $key => $option) {
        echo sprintf('<option %s value="%s">%s</option>', selected($key, $field['value']), $key, $option);
      }
    }
    echo '</select>';
    $this->the_field_description($field);
    echo '</p>';
    return ob_get_clean();
  }

  public function display_radio($field){
    ob_start();
    echo '<p>';
    $this->the_field_label($field);
    if(isset($field['options']) && is_array($field['options'])){
      foreach ($field['options'] as $key => $option) {
        echo sprintf('<br><input %s type="radio" name="%s" value="%s">%s ',checked($key, $field['value'], false), $field['id'], $key, $option);
      }
    }
     $this->the_field_description($field);echo '</p>';
    return ob_get_clean();
  }
  public function display_checkbox($field){
    ob_start();
    echo '<p>';

    $this->the_field_label($field);
    if(isset($field['options']) && is_array($field['options'])){
      foreach ($field['options'] as $key => $option) {
        echo sprintf('<br><input %s type="checkbox" name="%s[]" value="%s">%s ',checked(true, in_array($key, $field['value']), false), $field['id'], $key, $option);
      }
    }
     $this->the_field_description($field);
     echo '</p>';
    return ob_get_clean();
  }


  public function display_editor($field){
    $editor_settings = array( 'media_buttons' => false, 'textarea_rows' => 7 );
    ob_start();
    $this->the_field_label($field);
    wp_editor($field['value'], $field['id'], $editor_settings); $this->the_field_description($field);
    echo '<br>';
    return ob_get_clean();
  }




  public function display_attachment($field){
    $attachments_settings = get_option('rhd_attachments');
    if($attachments_settings['enable_attachments'] === 'on'){
      ob_start();
      echo '<p>';
        $this->the_field_label($field);
        echo sprintf('<input type="file" id="%s" name="%s" value=""><span class="file_extensions">%s: %s</span>',$field['id'], $field['id'], __('Allowed Extensions', 'ruby-help-desk'), $attachments_settings['allowed_extensions_attachments']);
        $this->the_field_description($field);
      echo '</p>';
      return ob_get_clean();
    }
    return '';
  }




  private function get_products(){
    $products = get_terms( RHD_TICKET_PRODUCT, array(	'hide_empty' => false		) );
    $result = array();
    foreach ($products as $key => $product) {
      $result[$product->term_id] = $product->name;
    }
    return $result;
  }

  public function sanitize($key,  $value){
    $fields = $this->get_fields();
    switch ($fields[$key]['type']){
      case 'text':
        $value  =  sanitize_text_field($value);
        break;
    }
    return $value;
  }

  public function validate_post(){
    $errors = array();
    foreach ($this->get_custom_fields() as $key => $field){
        if($field['required'] == 'yes'){
          if(isset($_POST[$key])){
            $value = is_array($_POST[$key])?$_POST[$key]:trim($_POST[$key]);
            if(empty($value)){
              $errors[] = sprintf(__('%s is required', 'ruby-help-desk'), $field['label']);
            }
          }else{
            $errors[] = sprintf(__('%s is required', 'ruby-help-desk'), $field['label']);
          }
        }
      }
      return (empty($errors))?false:$errors;
    }
}
