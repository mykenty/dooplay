<?php 
/*
Template Name: DT - Account page
*/
if (is_user_logged_in()):
	// pagina de mi cuenta
	if($_GET['action'] =='edit'):
		get_template_part('pages/sections/account_edit'); 
	else:
		get_template_part('pages/sections/account');
	endif;
else:
	get_template_part('pages/sections/dt_head'); 
	if($_GET['action'] =='sign-in'):
		get_template_part('pages/sections/register'); 
	else:
		get_template_part('pages/sections/login');
	endif;
	get_template_part('pages/sections/dt_foot'); 
endif;
?>



