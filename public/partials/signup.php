<form name="loginform" id="loginform" class="helpdesk_signup_form" action="" method="post">
      <?php if(!empty($this->errors)): ?>
        <?php foreach ($this->errors as $error): ?>
            <div class="alert"><?php echo $error; ?></div>
        <?php endforeach; ?>
      <?php endif; ?>
			<p class="login-username">
				<label for="user_login"><?php _e('Username', 'ruby-help-desk'); ?></label>
				<input type="text" name="user_login" id="user_login" class="input" value="" size="20" autocomplete="off">
			</p>
			<p class="login-password">
				<label for="user_email"><?php _e('Email', 'ruby-help-desk'); ?></label>
				<input type="email" name="user_email" id="user_email" class="input" value="" size="20"  autocomplete="off">
			</p>
      <p class="login-password">
				<label for="user_pass"><?php _e('Password', 'ruby-help-desk'); ?></label>
				<input type="password" name="user_pass" id="user_pass" class="input" value="" size="20"  autocomplete="off">
			</p>
      <p class="login-password">
        <label for="user_pass"><?php _e('Repeat Password', 'ruby-help-desk'); ?></label>
        <input type="password" name="user_pass_repeated" id="user_pass_repeated" class="input" value="" size="20"  autocomplete="off">
      </p>
			<p class="login-submit">
        <input type="hidden" name="redirect_to" value="http://localhost:8888/wp/help-desk-2/my-tickets/">
        <input type="hidden" name="action" value="helpdesk_signup">
				<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary" value="<?php _e('Sign Up', 'ruby-help-desk'); ?>">
			</p>

</form>
