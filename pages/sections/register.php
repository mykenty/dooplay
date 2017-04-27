<div class="form_dt_user">
	<header>
		<h1><?php  _d("Sign up, it's free.."); ?></h1>
	</header>
	<?php do_action ('dt_register_form'); ?>
	<?php if($_GET['form'] == 'send') { /* none */ } else { get_template_part('pages/sections/register-form'); } ?>
</div>