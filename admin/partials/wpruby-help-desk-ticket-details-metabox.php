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
<div id="ticket_creator">
  <h4><?php _e('Customer Information',  'wpruby-help-desk'); ?></h4>
  <div id="creator_img">
    <img class="avatar" src="<?php echo $user->get_avatar(); ?>" alt="">
  </div>
  <div id="creator_info">
    <ul>
      <li><strong><?php _e('Member since','wpruby-help-desk'); ?>: </strong> <?php echo date('d/m/Y \a\t g:ia', strtotime($user->get_registerd_at())); ?></li>
      <li><strong><?php _e('Name','wpruby-help-desk'); ?>: </strong> <?php echo $user->get_full_name(); ?></li>
      <li><strong><?php _e('Email','wpruby-help-desk'); ?>: </strong> <a href="mailto:<?php echo $user->get_email(); ?>"><?php echo $user->get_email(); ?></a></li>
      <li><strong><?php _e('Tickets','wpruby-help-desk'); ?>:</strong> <span><?php echo $ticket_stats['total']; ?></span> Total <span class="open_ticket"><?php echo $ticket_stats['open']; ?></span> Open <span class="closed_ticket"><?php echo $ticket_stats['closed']; ?></span> Closed</li>
    </ul>
  </div>
</div>

<div class="clear"></div>
