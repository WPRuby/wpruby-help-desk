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
    $fields = get_option('rhd_saved_cusom_fields', $core_fields);
    if(!is_array($fields)){
      return $core_fields;
    }
    //@TODO add_filter
    return $fields;
  }


  public function display($field){
    return call_user_func(array($this , 'display_' . $field['type'] ), $field);
  }


  public function display_text($field){
    ob_start();
    ?>
    <p>
    <label for="<?php echo $field['id']; ?>"><?php echo $field['label']; ?></label>
    <input type="text" id="<?php echo $field['id']; ?>" name="<?php echo $field['id']; ?>" value="">
    </p>
    <?php
    return ob_get_clean();
  }
  public function display_select($field){
    if($field['id'] == 'rhd_ticket_product'){
      $field['default'] = $this->get_products();
    }
    ob_start();
    ?>
    <label for="<?php echo $field['id']; ?>"><?php echo $field['label']; ?></label><br>
    <select id="<?php echo $field['id']; ?>" class="<?php echo $field['id']; ?>" name="<?php echo $field['id']; ?>">
      <?php if(isset($field['default']) && is_array($field['default'])){ ?>
        <?php foreach ($field['default'] as $key => $option) { ?>
          <option value="<?php echo $key; ?>"><?php echo $option; ?></option>
          <?php } ?>
      <?php } ?>
    </select>
    </p>
    <?php
    return ob_get_clean();
  }
  public function display_editor($field){
    $editor_settings = array( 'media_buttons' => false, 'textarea_rows' => 7 );
    ob_start();
    ?>
    <label for="<?php echo $field['id']; ?>"><?php echo $field['label']; ?></label>
    <?php wp_editor('', $field['id'], $editor_settings); ?> <br>
    <?php
    return ob_get_clean();
  }

  public function display_attachment($field){
    $attachments_settings = get_option('rhd_attachments');
    if($attachments_settings['enable_attachments'] === 'on'){
      ob_start(); ?>
      <p>
        <label for="<?php echo $field['id']; ?>"><?php echo $field['label']; ?></label><br>
        <input type="file" id="<?php echo $field['id']; ?>" name="<?php echo $field['id']; ?>" value="">
        <span class="file_extensions"><?php _e('Allowed Extensions', 'ruby-help-desk'); ?>: <?php echo $attachments_settings['allowed_extensions_attachments']; ?></span>
      </p>
    <?php  return ob_get_clean();
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
}
