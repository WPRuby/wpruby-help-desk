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
<?php if($replies_templates): ?>
<br>
<div id="rhd_reply_templates">
    <h3><?php _e('Templates', 'wpruby-help-desk'); ?></h3>
    <ul class="rhd_template_units">
		<?php foreach ($replies_templates as $template): ?>
            <li><a class="rhd_template_unit" href="#" data-content="<?php echo $template['content']; ?>" data-value="<?php echo sprintf('{%s}',$template['title']); ?>"><?php echo sprintf('%s', $template['title']); ?></a></li>
		<?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<?php if($ticket_status['slug'] != 'closed'): ?>
  <p>
  <input type="submit" name="reply"  class="button button-primary button-large" value="<?php _e('Reply', 'ruby-help-desk'); ?>">
  <input type="submit" name="reply-close" class="button button-close button-large" value="<?php _e('Reply and Close', 'ruby-help-desk'); ?>">
  </p>
<?php else: ?>
  <p>
  <input type="submit" name="reply-reopen" class="button button-primary button-large" value="<?php _e('Reply and re-open', 'ruby-help-desk'); ?>">
  </p>
<?php endif; ?>
