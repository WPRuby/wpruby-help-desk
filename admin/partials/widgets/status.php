<ul class="wpruby_status_list">

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
