<?php

/**
 * Override Post Types default publishing box
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    Ruby_Help_Desk
 * @subpackage Ruby_Help_Desk/admin/partials
 */

 ?>
 <div id="ticket_options">

<p>
  <label for="ticket_status"><?php _e('Ticket Status', 'ruby-help-desk'); ?>:</label>
  <select id="ticket_status" class="rhd_select" name="ticket_status">
    <option value="-1"><?php _e('No Status assigned', 'ruby-help-desk'); ?></option>
    <?php foreach ($statuses as $key => $status): ?>
      <option <?php selected($ticket_status['id'], $status->term_id); ?> value="<?php echo $status->term_id; ?>"><?php echo $status->name; ?></option>
    <?php endforeach; ?>
  </select>
</p>
<p>
  <label for="ticket_product"><?php _e('Ticket Product', 'ruby-help-desk'); ?>:</label>
  <select id="ticket_product" class="rhd_select" name="ticket_product">
    <option value="-1"><?php _e('No Product assigned', 'ruby-help-desk'); ?></option>
    <?php foreach ($products as $key => $product): ?>
      <option <?php selected($ticket_product, $product->term_id); ?> value="<?php echo $product->term_id; ?>"><?php echo $product->name; ?></option>
    <?php endforeach; ?>
  </select>
</p>
<p>
  <label for="ticket_agent"><?php _e('Assign to', 'ruby-help-desk'); ?>:</label>
  <select id="ticket_agent" class="rhd_select" name="ticket_agent">
    <option value="-1"><?php _e('No Agent assigned', 'ruby-help-desk'); ?></option>
    <?php foreach ($agents as $agent_id => $agent): ?>
      <option <?php selected($ticket_agent, $agent_id); ?> value="<?php echo $agent_id; ?>"><?php echo $agent; ?></option>
    <?php endforeach; ?>
  </select>
</p>
 <div id="publishing-action">
 <span class="spinner"></span>
 		<input type="submit" name="publish" id="publish" class="button button-primary button-large" value="<?php echo $publish_button_text; ?>"></div>
    <?php if(isset($_GET['post']) && isset($ticket_status['name'])){ ?>
        <span class="ticket_status_label" style="background:<?php echo $ticket_status['color']; ?>;"><?php echo $ticket_status['name']; ?></span>
    <?php } ?>

 <div class="clear"></div>
</div>
