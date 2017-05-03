
<div id="ticket_message">


  <div id="ticket_content">


    <?php if(isset($ticket->post_content)): ?>
            <p><?php echo  $ticket->post_content; ?></p>
    <?php endif; ?>
  </div>


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
