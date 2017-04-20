<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    Wpruby_Help_Desk
 * @subpackage Wpruby_Help_Desk/admin/partials
 */
wp_editor('', 'ticket_reply', $editor_settings);
?>
<p>
<input type="submit" name="reply"  class="button button-primary button-large" value="<?php _e('Reply', 'wpruby-help-desk'); ?>">
<input type="submit" name="reply-close" class="button button-large" value="<?php _e('Reply and Close', 'wpruby-help-desk'); ?>">
</p>
