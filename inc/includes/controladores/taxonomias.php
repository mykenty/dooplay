<?php


function dtdirector() {
	$labels = array(
		'name'                       => __d('Director'),
		'singular_name'              => __d('Director'),
		'menu_name'                  => __d('Director'),
	);
	$rewrite = array(
		'slug'                       => get_option('dt_director_slug','director'),
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy('dtdirector', array('movies'), $args );
}
add_action('init', 'dtdirector', 0 );

// Creator
function dtcreator() {
	$labels = array(
		'name'                       => __d('Creator'),
		'singular_name'              => __d('Creator'),
		'menu_name'                  => __d('Creator'),
	);
	$rewrite = array(
		'slug'                       => get_option('dt_creator_slug','creator'),
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy('dtcreator', array('tvshows'), $args );
}
add_action('init', 'dtcreator', 0 );

// cast
function dtcast() {
	$labels = array(
		'name'                       => __d('Cast'),
		'singular_name'              => __d('Cast'),
		'menu_name'                  => __d('Cast'),
	);
	$rewrite = array(
		'slug'                       => get_option('dt_cast_slug','cast'),
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy('dtcast', array('tvshows','movies'), $args );
}
add_action('init', 'dtcast', 0 );

// Studio
function dtstudio() {
	$labels = array(
		'name'                       => __d('Studio'),
		'singular_name'              => __d('Studio'),
		'menu_name'                  => __d('Studio'),
	);
	$rewrite = array(
		'slug'                       => get_option('dt_studio_slug','studio'),
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy('dtstudio', array('tvshows'), $args );
}
add_action('init', 'dtstudio', 0 );


// Neworks
function dtnetworks() {
	$labels = array(
		'name'                       => __d('Networks'),
		'singular_name'              => __d('Networks'),
		'menu_name'                  => __d('Networks'),
	);
	$rewrite = array(
		'slug'                       => get_option('dt_network_slug','network'),
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy('dtnetworks', array('tvshows'), $args );
}
add_action('init', 'dtnetworks', 0 );


// Year Serie
function dtyear() {
	$labels = array(
		'name'                       => __d('Year'),
		'singular_name'              => __d('Year'),
		'menu_name'                  => __d('Year'),
	);
	$rewrite = array(
		'slug'                       => get_option('dt_release_slug','release'),
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy('dtyear', array('tvshows','movies'), $args );
}
add_action('init', 'dtyear', 0 );


