<?php

$register		= get_option('dt_register_user');
$accountpage	= get_option('dt_account_page');
$touchicon		= get_option('dt_touch_icon');
$favicon		= get_option('dt_favicon');
$headercode		= get_option('dt_header_code');
$logo			= get_option('dt_logo');
$logged			= is_user_logged_in();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<?php if($touchicon) { ?>
<link rel="apple-touch-icon" href="<?php echo $touchicon; ?>" />
<?php } ?>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="mobile-web-app-capable" content="yes">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<?php if($favicon) { ?>
<link rel="shortcut icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
<?php } ?>
<?php get_template_part('inc/dt_seo'); ?>
<?php if(is_single()) { fbimage("w780", $post->ID); } ?>
<?php wp_head(); ?>
<?php echo stripslashes($headercode); ?>
</head>
<body <?php body_class(); ?>>
<?php if(is_single()) { global $user_ID; if( $user_ID ) : if( current_user_can('administrator') ) : ?>
<div class="dtloadpage">
	<div class="dtloadbox">
		<span><i class="icons-spinner9 animate-loader"></i> <?php _d('Generating data..'); ?></span>
		<p><?php _d('Please wait, not close this page to complete the upload'); ?></p>
	</div>
</div>
<?php endif; endif; } ?>
<div id="dt_contenedor">
<header id="header" class="main">
	<div class="hbox">
		<div class="logo">
			<a href="<?php echo esc_url( home_url() ); ?>/">
				<?php if($logo) { ?>
					<img src="<?php echo $logo;  ?>" alt="<?php bloginfo('name'); ?>">
				<?php } else { ?>
					<h1 class="text"><?php bloginfo('name'); ?></h1>
				<?php } ?>
			</a>
		</div>
		<div class="head-main-nav">
			<?php wp_nav_menu(array('theme_location'=>'header','menu_class'=>'main-header','menu_id'=>'main_header','fallback_cb'=>false)); ?>
		</div>

		<div class="headitems <?php if($register == 'true') { echo 'register_active'; } elseif($logged) { echo 'register_active'; } ?>">
			<div id="advc-menu" class="search">
				<form method="get" id="searchform" action="<?php echo esc_url( home_url() ); ?>">
					<input type="text" placeholder="<?php _d('Search...'); ?>" name="s" id="s" value="<?php echo dt_clear($_GET['s']); ?>" autocomplete="off">
					<button class="search-button" type="submit"><span class="icon-search2"></span></button>
				</form>
			</div>
			<!-- end search -->
			<?php if ($logged) { ?>
			<div class="dtuser">
				<div class="gravatar">
					<a href="<?php echo $accountpage; ?>"><?php email_avatar_header(); ?></a>
					<?php if (current_user_can('administrator')) { $total = total_links_pendientes(); if($total >= 1) { ?><span><?php echo $total; ?></span><?php } } ?>
				</div>
			</div>
			<?php } else { if($register == 'true') { ?>
			<div class="dtuser">
				<a class="clicklogin">
					<i class="icon-account_circle"></i>
				</a>
			</div>
			<?php } } ?>
			<!-- end dt_user -->
			<div class="live-search"></div>
		</div>


	</div>
</header>
<div class="fixheadresp">
	<header class="responsive">
		<div class="nav"><a class="aresp nav-resp"></a></div>
		<div class="search"><a class="aresp search-resp"></a></div>
		<div class="logo"><a href="<?php echo esc_url( home_url() ); ?>/">
			<?php if($logo) { ?>
				<img src="<?php echo $logo;  ?>" alt="<?php bloginfo('name'); ?>">
			<?php } else { ?>
				<h1 class="text"><?php bloginfo('name'); ?></h1>
			<?php } ?>
		</a></div>
	</header>
	<div class="search_responsive">
		<form method="get" id="form-search-resp" class="form-resp-ab" action="<?php echo esc_url( home_url() ); ?>">
			<input type="text" placeholder="<?php _d('Search...'); ?>" name="s" id="s" value="<?php echo dt_clear($_GET['s']); ?>" autocomplete="off">
			<button type="submit" class="search-button"><span class="icon-search3"></span></button>
		</form>
		<div class="live-search"></div>
	</div>
	<div id="arch-menu" class="menuresp">
		<div class="menu">
			<?php if ($logged) { ?>
			<div class="user">
				<div class="gravatar">
					<a href="<?php echo $accountpage; ?>">
					<?php email_avatar_header(); ?>
					<span><?php _d('My account'); ?></span>
					</a>
				</div>
				<div class="logout">
					<a href="<?php echo wp_logout_url(home_url()); ?>"><?php _d('Sign out'); ?></a>
				</div>
			</div>
			<?php } elseif($register == 'true') { ?>
			<div class="user">
				<a class="ctgs clicklogin"><?php _d('Login'); ?></a>
				<a class="ctgs" href="<?php echo $accountpage .'?action=sign-in'; ?>"><?php _d('Sign Up'); ?></a>
			</div>
			<?php } ?>
			<?php wp_nav_menu(array('theme_location'=>'header','menu_class'=>'resp','menu_id'=>'main_header','fallback_cb'=>false)); ?>
		</div>
	</div>
</div>
<div id="contenedor">
<?php if($logged) { /* none */ } else { dt_login_form(); } ?>