<?php

function episodios() {
	$labels = array(
		'name'                => _x('Episodes', 'Post Type General Name','mtms'),
		'singular_name'       => _x('Episodes', 'Post Type Singular Name','mtms'),
		'menu_name'           => __d('Episodes'),
		'name_admin_bar'      => __d('Episodes'),
	);
	$rewrite = array(
		'slug'                => get_option('dt_episodes_slug','episodes'),
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);
	$args = array(
		'label'               => __d('Episodes'),
		'description'         => __d('Episodes manage'),
		'labels'              => $labels,
		'supports'            => array('title', 'editor','comments','thumbnail'),
		'taxonomies'          => array('dtquality'),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-controls-play',
		'show_in_menu'       => 'edit.php?post_type=tvshows',
		'menu_position'      => 20,
		'show_in_nav_menus'   => false,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'page',
	);
	register_post_type('episodes', $args );
}
add_action('init', 'episodios', 0 );
get_template_part('inc/includes/series/episodios/metabox');
add_filter('manage_episodes_posts_columns', 'episodio_table_head');
function episodio_table_head( $defaults ) {
    $defaults['dtitle']  = __d('Title Episode');
    $defaults['idtmdb']    = __d('ID TMDb');
	$defaults['report']  = __d('Report');
	$defaults['dtviews'] = __d('Views');
    return $defaults;
}
add_action('manage_episodes_posts_custom_column', 'episodio_table_content', 10, 2 );
function episodio_table_content( $column_name, $post_id ) {
	
    if ($column_name == 'dtitle') {
		echo get_post_meta( $post_id, 'episode_name', true );
    }
    if ($column_name == 'idtmdb') {
		echo get_post_meta( $post_id, 'ids', true );
    }
	if ($column_name == 'report') {
		if($minutes = get_post_meta( $post_id, 'numreport', true )) {
			echo '<span class="dt_report_video">'. $minutes .'</div>';
		} else {
			echo "0";
		}
    }
	if ($column_name == 'dtviews') {
		if($views = get_post_meta( $post_id, 'dt_views_count', true )) {
			echo $views;
		} else {
			echo '0';
		}
	}
}