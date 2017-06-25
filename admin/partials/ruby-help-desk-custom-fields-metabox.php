<?php

/**
 * Display Custom Fields information
 * @link       https://wpruby.com
 * @since      1.2.0
 *
 * @package    Ruby_Help_Desk
 * @subpackage Ruby_Help_Desk/admin/partials
 */

?>

<?php foreach ($rhd_custom_fields->get_custom_fields() as $key => $field): ?>
  <?php echo $rhd_custom_fields->display($field); ?>
<?php endforeach; ?>
<div class="clear"></div>
