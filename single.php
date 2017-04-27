<?php


get_header(); 
// Separando tipos de entrada
    if(get_post_type( get_the_ID() ) ==  'tvshows') {
		// resolviendo series
		get_template_part('inc/parts/single/series');
    } elseif(get_post_type( get_the_ID() ) ==  'seasons') {
		// resolviendo temporadas
		get_template_part('inc/parts/single/temporadas');
    } elseif(get_post_type( get_the_ID() ) ==  'episodes') {
		// resolviendo episodios
		get_template_part('inc/parts/single/episodios');
    } elseif(get_post_type( get_the_ID() ) ==  'movies') {
		// resolviendo peliculas
		if ($_GET['edit'] == "true") { 
			get_template_part('inc/parts/single/editar/peliculas');
		} else {
			get_template_part('inc/parts/single/peliculas');
		}
    } else {
		// entradas por defecto
		get_template_part('inc/parts/single/post');
    }
get_footer(); ?>

<?php 
 // reset Liked
/*
delete_post_meta($post->ID, '_user_liked'); 
delete_post_meta($post->ID, '_user_IP');
delete_post_meta($post->ID, '_post_like_count'); 
*/
?>