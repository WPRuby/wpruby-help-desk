<div id="my_tickets">

<?php if($my_tickets): ?>
	<?php do_action('ruby_helpdesk_before_my_tickets_table', $my_tickets);  ?>
    <table id="my_tickets_table">
      <thead>
          <tr>
            <th style="width:35%;"><?php _e('Subject', 'ruby-help-desk'); ?></th>
            <th><?php _e('Status', 'ruby-help-desk'); ?></th>
            <th><?php _e('Product', 'ruby-help-desk'); ?></th>
            <th><?php _e('Date', 'ruby-help-desk'); ?></th>
            <th><?php _e('Replies', 'ruby-help-desk'); ?></th>
          </tr>
      </thead>
      <tbody>
      <?php foreach ($my_tickets as $key => $ticket): ?>
        <tr>
          <td><a href="<?php echo get_permalink($ticket->ID); ?>"><?php echo $ticket->post_title; ?></a></td>
          <td><span class="ticket_status_label" style="background:<?php echo $ticket->status['color']; ?>;"><?php echo $ticket->status['name']; ?></span></td>
          <td><?php echo $ticket->product['name']; ?></td>
          <td><?php echo human_time_diff(strtotime($ticket->post_date), time()); ?></td>
          <td> <span class="dashicons dashicons-admin-comments" style="font-size:18pt;"></span> <?php echo $ticket->replies_count; ?> </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php do_action('ruby_helpdesk_after_my_tickets_table', $my_tickets);  ?>
<?php else: ?>
  <p> <?php _e('You do not have any tickets yet', 'ruby-help-desk'); ?>.</p>
<?php endif; ?>
</div>
