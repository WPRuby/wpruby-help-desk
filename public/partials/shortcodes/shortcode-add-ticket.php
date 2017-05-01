<form class="submit_ticket_form" action="" method="post">

    <p>
    <label for="ticket_subject"><?php _e('Ticket Subject', 'wpruby-help-desk'); ?></label>
    <input type="text" id="ticket_subject" name="ticket_subject" value="">
    </p>

    <p>
    <label for="ticket_product"><?php _e('Product', 'wpruby-help-desk'); ?>:</label>
    <select id="ticket_product" class="ticket_product" name="ticket_product">
      <?php foreach ($products as $key => $product) { ?>
        <option value="<?php echo $product->term_id; ?>"><?php echo $product->name; ?></option>
      <?php } ?>
    </select>
    </p>

    <p>

      <?php
    $editor_settings = array( 'media_buttons' => false, 'textarea_rows' => 7 );
       wp_editor('', 'ticket_reply', $editor_settings); ?>

    </p>
    <input type="hidden" name="action" value="add_ticket_form">

    <input type="submit" name="submit_ticket" value="<?php _e('Submit Ticket', 'wpruby-help-desk'); ?>">

</form>
