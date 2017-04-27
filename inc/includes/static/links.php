<?php

if (is_admin()) {
	include_once DT_DIR . '/inc/includes/static/inc/dt_options.php';
	include_once DT_DIR . '/inc/includes/static/inc/dt_assets.php';
	include_once DT_DIR . '/inc/includes/static/inc/dt_image_upload.php';
	include_once DT_DIR . '/inc/includes/static/inc/dt_page_options.php';
	new acera_theme_options($options);
	add_action('admin_head', 'dt_upload_image_editor');
}
?>
