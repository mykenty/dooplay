<?php


// Home
function sidebar_home()
{
	register_sidebar(array(
		'name' => __d('Sidebar home page') ,
		'id' => 'sidebar-home',
		'description' => __d('Add widgets here to appear in your sidebar.') ,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
}
add_action('widgets_init', 'sidebar_home');

// Movies
function sidebar_movies()
{
	register_sidebar(array(
		'name' => __d('Sidebar Movies single') ,
		'id' => 'sidebar-movies',
		'description' => __d('Add widgets here to appear in your sidebar.') ,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
}
add_action('widgets_init', 'sidebar_movies');
// TVShows
function sidebar_tvshows()
{
	register_sidebar(array(
		'name' => __d('Sidebar TVShows single') ,
		'id' => 'sidebar-tvshows',
		'description' => __d('Add widgets here to appear in your sidebar.') ,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
}
add_action('widgets_init', 'sidebar_tvshows');
// Seasons
function sidebar_seasons()
{
	register_sidebar(array(
		'name' => __d('Sidebar Seasons single') ,
		'id' => 'sidebar-seasons',
		'description' => __d('Add widgets here to appear in your sidebar.') ,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
}
add_action('widgets_init', 'sidebar_seasons');

// Posts
function sidebar_posts()
{
	register_sidebar(array(
		'name' => __d('Sidebar Posts single') ,
		'id' => 'sidebar-posts',
		'description' => __d('Add widgets here to appear in your sidebar.') ,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
}
add_action('widgets_init', 'sidebar_posts');


// Home
function widgets_home()
{
	register_sidebar(array(
		'name' => __d('[widgetgenre] Genres') ,
		'id' => 'widgets-home',
		'description' => __d('Only widgets for the genres in home modules.') ,
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
}
add_action('widgets_init', 'widgets_home');




// Registrar Widgets
function dt_widgets()
{
	register_widget('DT_Widget');
	register_widget('DT_Widget_views');
	register_widget('DT_Widget_social');
	register_widget('DT_Widget_related');
	register_widget('DT_Widget_genres');
	register_widget('DT_Widget_mgenres');
	register_widget('DT_Widget_mreleases');
}
add_action('widgets_init', 'dt_widgets');

get_template_part ('inc/widgets/content_widget');
get_template_part ('inc/widgets/content_related_widget');
get_template_part ('inc/widgets/content_widget_views');
get_template_part ('inc/widgets/content_widget_social');
get_template_part ('inc/widgets/content_widget_home');
get_template_part ('inc/widgets/content_widget_meta_genres');
get_template_part ('inc/widgets/content_widget_meta_releases');