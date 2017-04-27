<form method="POST" id="adduser" class="register_form" action="<?php echo get_option('dt_account_page') .'?action=sign-in&form=send'; ?>">
	<fieldset>
		<label for="user_name"><?php _d('Username'); ?></label>
		<input type="text" placeholder="JohnDoe" id="user_name" name="user_name" value="<?php echo $_POST['user_name']; ?>" required />
	</fieldset>

	<fieldset>
		<label for="email"><?php _d('E-mail address'); ?></label>
		<input type="text" placeholder="johndoe@email.com" id="email" name="email" value="<?php echo $_POST['email']; ?>" required />
	</fieldset>

	<fieldset>
		<label for="dt_password"><?php _d('Password'); ?></label>
		<input type="password" id="dt_password" name="dt_password" required />
		<div class="passwordbox"><div id="passwordStrengthDiv" class="is0"></div></div>
	</fieldset>
	
	<fieldset class="min fix">
		<label for="dt_name"><?php _d('Name'); ?></label>
		<input type="text" placeholder="John" id="dt_name" name="dt_name" value="<?php echo $_POST['dt_name']; ?>" required />
	</fieldset>

	<fieldset class="min">
		<label for="dt_last_name"><?php _d('Last name'); ?></label>
		<input type="text" placeholder="Doe" id="dt_last_name" name="dt_last_name" value="<?php echo $_POST['dt_last_name']; ?>" required />
	</fieldset>
	<fieldset>
		<label form="reCAPTCHA"><?php _d('Security check'); ?></label>
		<div class="g-recaptcha" data-sitekey="<?php echo GRC_PUBLIC; ?>"></div>
		<p><?php _d('please do not skip this step, it is important.'); ?></p>
	</fieldset>
	<fieldset>
		<input name="adduser" type="submit" id="addusersub" class="submit button" value="<?php _d('Sign up'); ?>" />
		<span><?php _d('Do you already have an account?'); ?> <a href="<?php echo get_option('dt_account_page'); ?>?action=log-in"><?php _d('Login here'); ?></a></span>
	</fieldset>
	<?php wp_nonce_field('add-user', 'add-nonce') ?>
	<input name="action" type="hidden" id="action" value="adduser" />
</form>