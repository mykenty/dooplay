<?php 
/*
Template Name: DT - Contact page
*/
get_header();
// Captcha
$admin_mail = get_option('admin_email');
if($_GET['action'] == 'send') {
	if($_POST['send'] == 'true') {
		// revision Google Recaptcha
		get_template_part('inc/api/recaptchalib');
		$siteKey = GRC_PUBLIC;
		$secret = GRC_SECRET;
		$resp = null;
		$error = null;
		$reCaptcha = new ReCaptcha($secret);
		$recaptcha_response = $_POST["g-recaptcha-response"];
		$remote_addr = $_SERVER["REMOTE_ADDR"];
		$nonce = $_POST['send-contact-nonce'];
		if ($recaptcha_response) {
			$resp = $reCaptcha->verifyResponse( $remote_addr, $recaptcha_response );
		}
		if ($resp != null && $resp->success)  { 
			if( isset( $nonce ) and wp_verify_nonce($nonce, 'send-contact') ) { 
				// datos del formulario
				$asunto = $_POST['asunto'];
				$mensaje = $_POST['mensaje'];
				$email = $_POST['email'];
				$name = $_POST['dtname'];
				$link = $_POST['dtpermalink'];
				$headers = array('Content-Type: text/html; charset=UTF-8','From: '.$name.' <'.$email.'>');
				$body = '
					<strong>'.$name.'</strong> ['.$email.']<br><br>
					-----------------------------------<br><br>
					'.$mensaje.'<br><br>
					-----------------------------------<br><br>
					'.$link.'<br><br>
					'. __d('Contact form') .'
				';
				wp_mail( $admin_mail, $asunto , $body, $headers );
				$status = 'csend';
				$data_mensaje = __d('Message sent, at any time one of our operators will contact you.');
			} // end verify_nonce
		} else {
			$status = 'cerror';
			$data_mensaje = __d('Invalid code, please try again.');
		}// google rechapcha
	}  else {
		$data_mensaje = __d('no action');
	} // end post
}// end send
?>
<div class="contact">
	<div class="wrapper">
		<h1><?php _d('Contact Form'); ?></h1>
		<p class="descrip"><?php _d('Have something to notify our support team, please do not hesitate to use this form.'); ?></p>
	</div>
	<div class="wrapper">
	<?php if($_GET['action'] == 'send'): 
		echo '<div class="mensaje_ot '.$status.'">';
		echo $data_mensaje;
		echo '</div>';
	endif; ?>
		<form class="contactame" method="post" action="<?php echo get_option('dt_contact_page'); ?>?action=send">
			<fieldset class="nine">
				<label><?php _d('Name'); ?></label>
				<input type="text" name="dtname" required>
			</fieldset>
			<fieldset class="nine fix">
				<label><?php _d('Email'); ?></label>
				<input type="text" name="email" required>
			</fieldset>
			<fieldset>
				<label><?php _d('Subject'); ?></label>
				<p><?php _d('How can we help?'); ?></p>
				<input type="text" name="asunto" required>
			</fieldset>
			<fieldset>
				<label><?php _d('Your message'); ?></label>
				<p><?php _d('The more descriptive you can be the better we can help.'); ?></p>
				<textarea name="mensaje" rows="5" cols="" required></textarea>
			</fieldset>
			<fieldset>
				<label><?php _d('Link Reference (optional)'); ?></label>
				<input type="text" name="dtpermalink">
			</fieldset>
			<fieldset>
				<label><?php _d('Verification code'); ?></label>
				<p><?php _d("If you can't read the text, click on the image to redraw."); ?></p>
				<div class="g-recaptcha" data-sitekey="<?php echo GRC_PUBLIC; ?>"></div>
			</fieldset>
			<fieldset>
				<input type="submit" value="<?php _d('Send message'); ?>">
			</fieldset>
			<input type="hidden" name="send" value="true">
			<?php wp_nonce_field('send-contact', 'send-contact-nonce') ?>
		</form>
	</div>
</div>
<?php get_footer(); ?>