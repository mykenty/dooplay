<?php


if ( !class_exists('EDD_Theme_Updater_Admin') ) {
	get_template_part('inc/includes/static/inc/static/droper');
}
$updater = new EDD_Theme_Updater_Admin(
	$config = array(
		'remote_api_url' => DT_SERVER, // Repositorio
		'item_name'		 => DT_THEME_NAME, 
		'theme_slug'	 => DT_THEME_SLUG, 
		'version'		 => DT_VERSION, // version actual 
		'author'		 => DT_AUTOR, 
		'download_id'	 => '', 
		'renew_url'		 => DT_RENOVAR 
	),
	$strings = array(
	'theme-license' => __d('Theme License'),
	'enter-key' => __d('Enter your theme license key.'),
	'license-key' => __d('License Key'),
	'license-action' => __d('License Action'),
	'deactivate-license' => __d('Deactivate License'),
	'activate-license' => __d('Activate License'),
	'status-unknown' => __d('License status is unknown.'),
	'renew' => __d('Renew?'),
	'unlimited' => __d('unlimited'),
	'license-key-is-active' => __d('License key is active.'),
	'expires%s' => __d('Expires %s.'),
	'%1$s/%2$-sites' => __d('You have %1$s / %2$s sites activated.'),
	'license-key-expired-%s' => __d('License key expired %s.'),
	'license-key-expired' => __d('License key has expired.'),
	'license-keys-do-not-match' => __d('License keys do not match.'),
	'license-is-inactive' => __d('License is inactive.'),
	'license-key-is-disabled' => __d('License key is disabled.'),
	'site-is-inactive' => __d('Site is inactive.'),
	'license-status-unknown' => __d('License status is unknown.'),
	'update-notice' => __d("Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update."),
	'update-available' => __d('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.')
	)
);