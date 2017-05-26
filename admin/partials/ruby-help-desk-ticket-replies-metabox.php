<?php

/**
 * Display the replies 
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    Ruby_Help_Desk
 * @subpackage Ruby_Help_Desk/admin/partials
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

      <?php if ($reply->attachments): ?>
        <hr>
        <h3><?php _e('Attachments', 'ruby-help-desk'); ?></h3>

        <div class="ticket_attachments">
          <ol>
          <?php foreach ($reply->attachments as $attachment): ?>
              <li><a target="_blank" href="<?php echo wp_get_attachment_url($attachment->ID) ?>"> <?php echo basename( wp_get_attachment_url($attachment->ID) ); ?></a></li>
          <?php endforeach; ?>
        </ol>
        </div>
      <?php endif; ?>

  </div>
 <?php endforeach; ?>
