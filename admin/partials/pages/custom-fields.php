<div id="rhd_custom_fields" class="wrap">
  <h1><?php _e('Custom Fields', 'ruby-help-desk'); ?></h1>
  <p class="description"><?php _e('You can create a customizable ticket submission page blah blah ...', 'ruby-help-desk'); ?></p>

<form class="" action="" method="post">

  <div id="active_custom_fields">
<?php foreach ($rhd_custom_fields->get_core_fields() as $key => $field): ?>
      <div class="group">
        <h3 class="form-element-<?php echo $field['type']; ?>"><?php echo $field['label']; ?><b></b></h3>
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
              <option value="yes" <?php selected($field['size'], 'yes') ?>><?php _e('Yes', 'ruby-help-desk') ?></option>
              <option value="no" <?php selected($field['size'], 'no') ?>><?php _e('No', 'ruby-help-desk') ?></option>
            </select>
          </p>
          <input type="hidden" name="rhd_custom_fields[<?php echo $key . '][core]'; ?>" value="<?php echo esc_attr($field['core']); ?>">
          <input type="hidden" name="rhd_custom_fields[<?php echo $key . '][type]'; ?>" value="<?php echo esc_attr($field['type']); ?>">
          <input type="hidden" name="rhd_custom_fields[<?php echo $key . '][default]'; ?>" value="<?php echo esc_attr($field['default']); ?>">
        </div>
      </div>
<?php endforeach; ?>
  </div>

  <div id="custom_fields_components">
    <ul>
      <?php foreach ($rhd_custom_fields->get_components() as $key => $component): ?>
        <li><a href="#" class="draggable-custom-field-item form-element-<?php echo $component['type']; ?>" data-key="<?php echo $key; ?>" data-label="<?php echo $component['label']; ?>" data-type="<?php echo $component['type']; ?>"><b></b><?php echo $component['label']; ?></a></li>
      <?php endforeach; ?>
      </ul>
  </div>
  <div class="clearboth"></div> <br>
  <input class="button button-primary" type="submit" name="save_custom_fields" value="<?php _e('Save Changes', 'ruby-help-desk'); ?>">
  </form>

</div>