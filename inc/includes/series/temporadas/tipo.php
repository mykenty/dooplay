<?php


function seasons() {

	$labels = array(
		'name'                => _x('Seasons', 'Post Type General Name','mtms'),
		'singular_name'       => _x('Seasons', 'Post Type Singular Name','mtms'),
		'menu_name'           => __d('Seasons'),
		'name_admin_bar'      => __d('Seasons'),
	);
	$rewrite = array(
		'slug'                => get_option('dt_seasons_slug','seasons'),
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);
	$args = array(
		'label'               => __d('Seasons'),
		'description'         => __d('Seasons manage'),
		'labels'              => $labels,
		'supports'            => array('title', 'editor','comments','thumbnail'),
		'taxonomies'          => array( ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-welcome-view-site',
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
	register_post_type('seasons', $args );
}
add_action('init', 'seasons', 0 );
// Metadatos y taxonomias
get_template_part('inc/includes/series/temporadas/metabox');
add_filter('manage_seasons_posts_columns', 'seasons_table_head');
function seasons_table_head( $defaults ) {
	if(get_option( DT_KEY ) == "valid"):
	$defaults['generate']    = __d('Generate');
	endif;
	$defaults['serie']    = __d('TV Show');
    $defaults['idtmdb']    = __d('ID TMDb');
	$defaults['dtviews'] = __d('Views');
    return $defaults;
}
add_action('manage_seasons_posts_custom_column', 'seasons_table_content', 10, 2 );
function seasons_table_content( $column_name, $post_id ) {
	
	if ($column_name == 'generate') {
		if(get_option( DT_KEY ) == "valid"):
			if(get_post_meta( $post_id, 'clgnrt', true ) =='1') { _d('Ready'); } else {
	$addlink = wp_nonce_url( admin_url('admin-ajax.php?action=episodes_ajax','relative').'&se='.get_post_meta( $post_id, 'ids', true ).'&te='.get_post_meta( $post_id, 'temporada', true ).'&link='.$post_id, 'add_episodes', 'episodes_nonce');
    echo '<a href="'. $addlink .'" class="dtload button button-primary">'. __d('Generate Episodes') .'</a>';
		}
		endif;
    }
	if ($column_name == 'serie') {
		echo get_post_meta( $post_id, 'serie', true );
    }
    if ($column_name == 'idtmdb') {
		echo get_post_meta( $post_id, 'ids', true );
    }
	if ($column_name == 'dtviews') {
		if($views = get_post_meta( $post_id, 'dt_views_count', true )) {
			echo $views;
		} else {
			echo '0';
		}
	}
}


