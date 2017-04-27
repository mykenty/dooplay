<?php


# Episodes slug structure
define ('eseas','');
define ('eepisod','');
define ('esepart','x');
$dt_theme_data = wp_get_theme();
define('DT_VERSION', '2.0.2');
define('DT_THEME_NAME', 'Dooplay');
define('DT_THEME_SLUG', 'dooplay');
define('FIX_MSG', '_transient_dooplay');
define('DT_KEY', DT_THEME_SLUG . '_license_key_status');
define('DT_MSG', FIX_MSG . '_license_message');
define('DT_KEY_S', DT_THEME_SLUG . '_license_key');
define('DT_TIME','M. d, Y');
define('DT_MAIN_RATING','_starstruck_avg');
define('DT_MAIN_VOTOS', '_starstruck_total');
define('DT_FONT', get_option('dt_font_style','Roboto'));

/* Google reCAPTCHA
-------------------------------------------------------------------------------
*/
define('GRC_PUBLIC', get_option('dt_grpublic_key'));
define('GRC_SECRET', get_option('dt_grprivate_key'));

/*Directorios
-------------------------------------------------------------------------------
*/
define('DT_DIR_URI', get_template_directory_uri());
define('DT_DIR', get_template_directory());
define('DT_IMGA', DT_DIR_URI . '/assets/img/admin/');
define('DT_GENRE', get_option('dt_genre_slug','genre'));

/* Theme supports
-------------------------------------------------------------------------------
*/
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('automatic-feed-links');

/*Idioma
-------------------------------------------------------------------------------
*/
load_theme_textdomain('mtms', DT_DIR . '/lang/');

/* Main requires
-------------------------------------------------------------------------------
*/
require_once( DT_DIR . '/inc/dt_init.php');
require_once( DT_DIR . '/inc/dt_assets.php');
require_once( DT_DIR . '/inc/dt_player.php');
require_once( DT_DIR . '/inc/dt_comments.php');
require_once( DT_DIR . '/inc/dt_collection.php');
require_once( DT_DIR . '/inc/dt_customizer.php');
require_once( DT_DIR . '/inc/dt_minify.php');
require_once( DT_DIR . '/inc/dt_ajax.php');
require_once( DT_DIR . '/inc/dt_video.php');

/* More functions
-------------------------------------------------------------------------------
*/
require_once( DT_DIR . '/inc/api/dbmovies.php');
require_once( DT_DIR . '/inc/includes/peliculas/tipo.php');
require_once( DT_DIR . '/inc/includes/rating/init.php');
require_once( DT_DIR . '/inc/includes/series/tipo.php');
require_once( DT_DIR . '/inc/includes/series/temporadas/tipo.php');
require_once( DT_DIR . '/inc/includes/series/episodios/tipo.php');
require_once( DT_DIR . '/inc/includes/links/tipo.php');
require_once( DT_DIR . '/inc/includes/controladores/taxonomias.php');
require_once( DT_DIR . '/inc/includes/metabox.php');
require_once( DT_DIR . '/inc/includes/slugs.php');
require_once( DT_DIR . '/inc/includes/box_links.php');
require_once( DT_DIR . '/inc/widgets/widgets.php');