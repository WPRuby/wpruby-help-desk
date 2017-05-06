<div id="single_ticket">
  <div id="ticket_message">
    <div id="ticket_info_bar">
      <span class="ticket_number"><?php _e('Ticket', 'wpruby-help-desk'); ?> #<?php echo $post->ID; ?></span>
      <span class="ticket_date"><?php _e('Created before', 'wpruby-help-desk'); ?> <?php echo human_time_diff(strtotime($post->post_date), time()); ?> <?php _e('on','wpruby-help-desk'); ?> <?php echo date('M d, Y', strtotime($post->post_date)); ?> </span>
      <span class="ticket_replies_count"><strong class="dashicons dashicons-admin-comments"></strong><?php echo $replies_count; ?></span>
      <span class="ticket_status_label status_single_ticket" style="background:<?php echo $status['color']; ?>;"><?php echo $status['name']; ?></span>
    </div>
    <div id="ticket_content">
      <p><?php echo $post->post_content; ?></p>

      <?php if ($attachments): ?>
        <hr>
        <h3><?php _e('Attachments', 'wpruby-help-desk'); ?></h3>

        <div class="ticket_attachments">
          <ol>
          <?php foreach ($attachments as $attachment): ?>
              <li><a target="_blank" href="<?php echo wp_get_attachment_url($attachment->ID) ?>"> <?php echo basename( wp_get_attachment_url($attachment->ID) ); ?></a></li>
          <?php endforeach; ?>
        </ol>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div id="ticket_replies">
    <?php foreach($replies as $key => $reply): ?>
      <div class="ticket_reply">
         <div class="reply_avatar">
           <img src="<?php echo $reply->user->get_avatar(); ?>" alt="">
           <span class="reply_username"><?php echo $reply->user->get_full_name(); ?></span>
           <span class="reply_time"><?php echo human_time_diff( time(), strtotime($reply->post_date)); ?></span>
         </div>
         <div class="reply_content">
           <p><?php echo $reply->post_content; ?></p>

           <?php if ($reply->attachments): ?>
             <hr>
             <h3><?php _e('Attachments', 'wpruby-help-desk'); ?></h3>

             <div class="ticket_attachments">
               <ol>
               <?php foreach ($reply->attachments as $attachment): ?>
                   <li><a target="_blank" href="<?php echo wp_get_attachment_url($attachment->ID) ?>"> <?php echo basename( wp_get_attachment_url($attachment->ID) ); ?></a></li>
               <?php endforeach; ?>
             </ol>
             </div>
           <?php endif; ?>

         </div>
         <div class="clear"></div>
      </div>
    <?php endforeach; ?>

  </div>

  <div id="reply_box">

    <form class="" action="" method="post" enctype="multipart/form-data">
      <h4><?php _e('Write a reply', 'wpruby-help-desk'); ?></h4>
      <?php wp_editor('', 'ticket_reply', $editor_settings); ?>
      <p>
        <input type="hidden" name="ticket_id" value="<?php echo $post->ID; ?>">
        <input type="hidden" name="action" value="submit_reply">
        <p>
          <label for="reply_attachment"><?php _e('Attachments', 'wpruby-help-desk'); ?></label><br>
              <input type="file" id="reply_attachment" name="reply_attachment" value="">
        </p>
        <input type="submit" name="submit_reply" value="<?php _e('Submit a reply', 'wpruby-help-desk'); ?>">
      </p>
    </form>

  </div>
</div>
