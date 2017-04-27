<?php


if( $dato = get_option('dt_admin_facebook') ) { ?>
	<meta property="fb:admins" content="<?php echo $dato; ?>"/>
<?php } if( $dato = get_option('dt_app_id_facebook') ) { ?>
	<meta property="fb:app_id" content="<?php echo $dato; ?>"/>
<?php } ?>
<?php if(get_option('dt_site_titles') == "true") {
if( $dato = get_option('dt_veri_google') ) { ?>
	<meta name="google-site-verification" content="<?php echo $dato; ?>" />
<?php } if( $dato = get_option('dt_veri_alexa') ) { ?>
	<meta name="alexaVerifyID" content="<?php echo $dato; ?>" />
<?php } if( $dato = get_option('dt_veri_bing') ) { ?>
	<meta name="msvalidate.01" content="<?php echo $dato; ?>" />
<?php } if( $dato = get_option('dt_veri_yandex') ) { ?>
	<meta name='yandex-verification' content="<?php echo $dato; ?>" />
<?php } ?>
<?php if (is_home()) { ?>
<?php if($data = get_option('dt_metadescription')) { ?>
	<meta name="description" content="<?php echo $data; ?>"/>
<?php } ?>
<?php if($data = get_option('dt_main_keywords')) { ?>
	<meta name="keywords" content="<?php echo $data; ?>"/>
<?php } } ?> 
<?php if(is_single()) { ?>
	<meta property="og:type" content="article" />
	<meta property="og:title" content="<?php the_title(); ?>" />
	<meta property="og:url" content="<?php the_permalink() ?>" />
	<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
<?php } ?>
<?php } ?>