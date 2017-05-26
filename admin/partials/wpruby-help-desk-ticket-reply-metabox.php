<?php

/**
 * Display the reply box
 *
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    Ruby_Help_Desk
 * @subpackage Ruby_Help_Desk/admin/partials
 */
?>
<?php wp_editor('', 'ticket_reply', $editor_settings); ?>

<?php if($ticket_status['slug'] != 'closed'): ?>
  <p>
  <input type="submit" name="reply"  class="button button-primary button-large" value="<?php _e('Reply', 'wpruby-help-desk'); ?>">
  <input type="submit" name="reply-close" class="button button-close button-large" value="<?php _e('Reply and Close', 'wpruby-help-desk'); ?>">
  </p>
<?php else: ?>
  <p>
  <input type="submit" name="reply-reopen" class="button button-primary button-large" value="<?php _e('Reply and re-open', 'wpruby-help-desk'); ?>">
  </p>
<?php endif; ?>
