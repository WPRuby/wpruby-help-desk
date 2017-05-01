<div id="my_tickets">


<table>
  <thead>
    <th><?php _e('Subject', 'wpruby-help-desk'); ?></th>
    <th><?php _e('Status', 'wpruby-help-desk'); ?></th>
    <th><?php _e('Product', 'wpruby-help-desk'); ?></th>
    <th><?php _e('Date', 'wpruby-help-desk'); ?></th>
    <th><?php _e('Replies', 'wpruby-help-desk'); ?></th>
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




</div>
