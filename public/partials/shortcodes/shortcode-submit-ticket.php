<div id="submit_ticket">
    <?php if(!empty($this->errors)): ?>
      <?php foreach($this->errors as $e): ?>
        <div class="alert"><?php echo $e; ?></div>
      <?php endforeach; ?>
    <?php endif; ?>
    <form class="submit_ticket_form" action="" method="post"  enctype="multipart/form-data">

      <?php foreach ($custom_fields->get_fields() as $key => $field): ?>
        <?php echo $custom_fields->display($field); ?>
      <?php endforeach; ?>
        <br>
        <input type="hidden" name="action" value="submit_ticket">
        <input type="submit" name="submit_ticket" value="<?php _e('Submit Ticket', 'ruby-help-desk'); ?>">

    </form>

</div>
