<div id="rhd_custom_fields" class="wrap">
  <h1><?php _e('Custom Fields', 'ruby-help-desk'); ?></h1>
  <p class="description"><?php _e('You can customize the Submit Ticket page by adding custom fields from the right column, and you can drag the field to order them', 'ruby-help-desk'); ?></p>
  <?php if(isset($_POST['save_custom_fields'])): ?>
  <div class="notice notice-success is-dismissible">
    <p><?php _e( 'Custom Fields settings have been saved.', 'ruby-help-desk' ); ?></p>
  </div>
  <?php endif; ?>
<form class="" action="" method="post">

  <div id="active_custom_fields">
<?php foreach ($rhd_custom_fields->get_fields() as $key => $field): ?>
      <div class="group">
        <h3 class="form-element-<?php echo $field['type']; ?>"><?php echo $field['label']; ?><b></b><?php if(!isset($core_fields[$key])): ?><a href="javascript:void(0)" class="delete_custom_field"><span class="dashicons dashicons-trash"></span></a><?php endif; ?></h3>
        <div>
          <p>
            <label for="<?php echo $key . '-label'; ?>"><?php _e('Label', 'ruby-help-desk'); ?></label><br>
            <input id="<?php echo $key . '-label'; ?>" type="text" name="rhd_custom_fields[<?php echo $key . '][label]'; ?>" value="<?php echo esc_attr($field['label']); ?>">
          </p>
          <p>
            <label for="<?php echo $key . '-description'; ?>"><?php _e('Description', 'ruby-help-desk'); ?></label><br>
            <textarea id="<?php echo $key . '-description'; ?>" name="rhd_custom_fields[<?php echo $key . '][description]'; ?>" rows="4" cols="50"><?php echo $field['description']; ?></textarea>
          </p>
          <p>
            <label for="<?php echo $key . '-size'; ?>"><?php _e('Field size', 'ruby-help-desk'); ?></label><br>
            <select id="<?php echo $key . '-size'; ?>" name="rhd_custom_fields[<?php echo $key . '][size]'; ?>">
              <option value="small" <?php selected($field['size'], 'small') ?>><?php _e('Small', 'ruby-help-desk') ?></option>
              <option value="medium" <?php selected($field['size'], 'medium') ?>><?php _e('Medium', 'ruby-help-desk') ?></option>
              <option value="large" <?php selected($field['size'], 'large') ?>><?php _e('Large', 'ruby-help-desk') ?></option>
            </select>
          </p>
          <p>
            <label for="<?php echo $key . '-required'; ?>"><?php _e('Required', 'ruby-help-desk'); ?></label><br>
            <select id="<?php echo $key . '-required'; ?>" name="rhd_custom_fields[<?php echo $key . '][required]'; ?>">
              <option value="yes" <?php selected($field['required'], 'yes') ?>><?php _e('Yes', 'ruby-help-desk') ?></option>
              <option value="no" <?php selected($field['required'], 'no') ?>><?php _e('No', 'ruby-help-desk') ?></option>
            </select>
          </p>
          <?php if(isset($field['options']) && is_array($field['options'])): ?>
            <p>
            <p><label for="<?php echo $key . '-options'; ?>">Options</label><br>
            <ul class="field_options" id="<?php echo $key . '-options'; ?>">
              <?php foreach ($field['options'] as $option_key => $option): ?>
                <li><input name="rhd_custom_fields[<?php echo $key . '][options][]'; ?>" class="code" value="<?php echo esc_attr($option); ?>" type="text" /><span class="delete_option dashicons dashicons-trash"></span><span class="dashicons  dashicons-menu"></span></li>
              <?php endforeach; ?>
            </ul>
            <a class="add_option button-secondary" data-key="<?php echo $key; ?>" data-field="<?php echo $key . '-options'; ?>" href="javascript:void(0)"><span class="dashicons dashicons-plus-alt"></span><?php _e('Add Option', 'ruby-help-desk'); ?></a>
            </p>
          <?php endif; ?>
          <input type="hidden" name="rhd_custom_fields[<?php echo $key . '][core]'; ?>" value="<?php echo esc_attr($field['core']); ?>">
          <input type="hidden" name="rhd_custom_fields[<?php echo $key . '][type]'; ?>" value="<?php echo esc_attr($field['type']); ?>">
          <input type="hidden" name="rhd_custom_fields[<?php echo $key . '][id]'; ?>" value="<?php echo esc_attr($field['id']); ?>">
        </div>
      </div>
<?php endforeach; ?>
  </div>

  <div id="custom_fields_components">
    <ul>
      <li><strong><?php _e('Click on Custom Fields to add them to the Submit Ticket page', 'ruby-help-desk'); ?></strong></li>
      <?php foreach ($rhd_custom_fields->get_components() as $key => $component): ?>
        <li><a href="#" class="draggable-custom-field-item form-element-<?php echo $component['type']; ?>" data-core="no" data-default="" data-key="<?php echo $key; ?>" data-label="<?php echo $component['label']; ?>" data-type="<?php echo $component['type']; ?>"><b></b><?php echo $component['label']; ?></a></li>
      <?php endforeach; ?>
      </ul>
  </div>
  <div class="clearboth"></div> <br>
  <input class="button button-primary" type="submit" name="save_custom_fields" value="<?php _e('Save Changes', 'ruby-help-desk'); ?>">
  </form>

</div>
