<?php

/**
 * Display information about the ticket owner.
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    Ruby_Help_Desk
 * @subpackage Ruby_Help_Desk/admin/partials
 */

?>
<div id="ticket_creator">
  <div id="creator_img">
    <img class="avatar" src="<?php echo $user->get_avatar(); ?>" alt="">
  </div>
  <div id="creator_info">
      <strong><?php _e('Name','ruby-help-desk'); ?> </strong> <?php echo $user->get_full_name(); ?>
       <strong><?php _e('Member since','ruby-help-desk'); ?> </strong> <?php echo date('d/m/Y \a\t g:ia', strtotime($user->get_registerd_at())); ?>
      <strong><?php _e('Email','ruby-help-desk'); ?> </strong> <a href="mailto:<?php echo $user->get_email(); ?>"><?php echo $user->get_email(); ?></a>
      <strong><?php _e('Tickets','ruby-help-desk'); ?></strong> <br> <span><?php echo $ticket_stats['total']; ?></span> <a target="_blank" href="<?php echo admin_url('edit.php?post_type=support_ticket&author=' . $user->get_id());  ?>"><?php _e('Total','ruby-help-desk'); ?></a> <span class="open_ticket"><?php echo $ticket_stats['open']; ?></span> Open <span class="closed_ticket"><?php echo $ticket_stats['closed']; ?></span> <a target="_blank" href="<?php echo admin_url('edit.php?post_type=support_ticket&tickets_status=closed&author=' . $user->get_id());  ?>"><?php _e('Closed','ruby-help-desk'); ?></a>
  </div>
</div>

<div class="clear"></div>
