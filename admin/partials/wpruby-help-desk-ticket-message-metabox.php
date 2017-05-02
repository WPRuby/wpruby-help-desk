<?php if(isset($ticket->post_content)): ?>
        <p><?php echo  $ticket->post_content; ?></p>
<?php endif; ?>


<h4><?php _e('Attachments', 'wpruby-help-desk'); ?></h4>


<?php if ($attachments): ?>
<div class="ticket_attachments">
  <ul>
  <?php foreach ($attachments as $attachment): ?>
      <li><a target="_blank" href="<?php echo wp_get_attachment_url($attachment->ID) ?>"> <?php echo basename( wp_get_attachment_url($attachment->ID) ); ?></a></li>
  <?php endforeach; ?>
  </ul>
</div>
<?php endif; ?>
