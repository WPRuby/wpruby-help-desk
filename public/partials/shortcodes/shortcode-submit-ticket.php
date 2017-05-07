<div id="submit_ticket">

    <form class="submit_ticket_form" action="" method="post"  enctype="multipart/form-data">

        <p>
        <label for="ticket_subject"><?php _e('Ticket Subject', 'wpruby-help-desk'); ?></label>
        <input type="text" id="ticket_subject" name="ticket_subject" value="">
        </p>

        <p>
        <label for="ticket_product"><?php _e('Product', 'wpruby-help-desk'); ?></label><br>
        <select id="ticket_product" class="ticket_product" name="ticket_product">
          <?php foreach ($products as $key => $product) { ?>
            <option value="<?php echo $product->term_id; ?>"><?php echo $product->name; ?></option>
          <?php } ?>
        </select>
        </p>

          <label for="ticket_reply"><?php _e('Ticket Description', 'wpruby-help-desk'); ?></label>
          <?php
        $editor_settings = array( 'media_buttons' => false, 'textarea_rows' => 7 );
           wp_editor('', 'ticket_reply', $editor_settings); ?>

        <input type="hidden" name="action" value="submit_ticket">
        <?php if($attachments_settings['enable_attachments'] === 'on'): ?>
          <p>
            <label for="ticket_attachment"><?php _e('Attachments', 'wpruby-help-desk'); ?></label><br>
                <input type="file" id="ticket_attachment" name="ticket_attachment" value="">
                <span class="file_extensions"><?php _e('Allowed Extensions', 'wpruby-help-desk'); ?>: <?php echo $attachments_settings['allowed_extensions_attachments']; ?></span>

          </p>
        <?php endif; ?>
        <br>
        <input type="submit" name="submit_ticket" value="<?php _e('Submit Ticket', 'wpruby-help-desk'); ?>">

    </form>

</div>
