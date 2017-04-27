<?php


$option = get_option('dt_slider_radom');
if($option == 'true') {
	$rand = 'rand';
} else {
	$rand = '';	
} ?>
<div id="slider-movies-tvshows" class="animation-1 slider">
<?php query_posts( array('post_type' => array('tvshows','movies'), 'showposts' => get_option('dt_slider_items','10'), 'orderby' => $rand, 'order' => 'desc')); ?>
<?php while ( have_posts() ) : the_post(); get_template_part('inc/parts/item_b'); endwhile; wp_reset_query(); ?>
</div>