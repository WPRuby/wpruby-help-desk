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

 ?>
 <?php foreach ($replies as $key => $reply): ?>
   <div class="ticket_reply">
      <div class="reply_avatar">
        <img src="<?php echo $reply->user->get_avatar(); ?>" alt="">
        <span class="reply_username"><?php echo $reply->user->get_full_name(); ?></span>
        <span class="reply_time"><?php echo human_time_diff( time(), strtotime($reply->post_date)); ?></span>
      </div>
      <div class="reply_content">
        <p><?php echo $reply->post_content; ?></p>
      </div>
      <div class="clear"></div>
  </div>
 <?php endforeach; ?>
