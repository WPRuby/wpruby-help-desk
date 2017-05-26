<div class="rhd_dashboard_widget">

  <ul class="rhd_status_list">

      <li class="new-tickets">
        <span class="dashicons dashicons-sos"></span>

  			<a href="<?php echo $tickets_object->get_status_tickets_link('new'); ?>">

             <strong><?php echo $tickets_stats['new']; ?> ticket</strong> awaiting response
        </a>
  		</li>

  		<li class="in-progress-tickets">
        <span class="dashicons dashicons-admin-tools"></span>

  			<a href="<?php echo $tickets_object->get_status_tickets_link('in-progress'); ?>">

  			<strong><?php echo $tickets_stats['in-progress']; ?> tickets</strong> in progress			</a>
  		</li>

  		<li class="closed-tickets">
        <span class="dashicons dashicons-welcome-comments"></span>
  			<a href="<?php echo $tickets_object->get_status_tickets_link('closed'); ?>">

  			<strong><?php echo $tickets_stats['closed']; ?> tickets</strong> closed			</a>
  		</li>

  		<li class="total-tickets">
        <span class="dashicons dashicons-tickets-alt"></span>

        <a href="<?php echo $tickets_object->get_status_tickets_link('total'); ?>">

        <strong><?php echo $tickets_stats['total']; ?> tickets</strong> in total			</a>
  		</li>

  </ul>
  <?php if(!empty($recent_tickets)): ?>
    <h4><?php _e('Recent Tickets', 'ruby-help-desk'); ?></h4>
    <ul class="rhd_recent_tickets">
      <?php foreach ($recent_tickets as $key => $ticket): $status = $tickets_object->get_status($ticket->ID); ?>
        <li> <a href="<?php echo get_edit_post_link($ticket->ID); ?>"><?php echo wp_trim_words( $ticket->post_title, 7, '... ' ); ?></a> <span class="ticket_status_label" style="background:<?php echo $status['color']; ?>;"><?php echo $status['name']; ?></span><span class="since"> <?php echo human_time_diff(strtotime($ticket->post_date)); ?></span></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

</div>
