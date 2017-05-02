<?php 

if(get_option('dt_mm_random_order') == 'true') {
	$rand = 'rand';
} else {
	$rand = '';	
} ?>
<header>
<h2>Tuyển tập ca khúc<?php //echo get_option('dt_mm_title','Movies'); ?></h2>
<?php if( get_option('dt_mm_activate_slider') == 'true') { if(get_option('dt_mm_autoplay_slider') == 'true') { } else { ?>
<div class="nav_items_module">
  <a class="btn prev3"><i class="icon-caret-left"></i></a>
  <a class="btn next3"><i class="icon-caret-right"></i></a>
</div>
<?php } } ?>
<span><?php echo total_peliculas(); ?> <?php if($url = get_option('dt_movies_slug','movies')) { ?><a href="<?php echo esc_url( home_url() ) .'/?post_type='. $url; ?>" class="see-all">Xem tất cả</a><?php } ?></span>
</header>
<div id="movload" class="load_modules"><?php _d('Loading..');?></div>
<div <?php if(get_option('dt_mm_activate_slider') == 'true') { echo 'id="dt-movies"'; } ?> class="items">
	<?php query_posts( array('post_type' => array('movies'), 'showposts' => get_option('dt_mm_number_items','10'), 'orderby' => $rand, 'order' => 'desc')); ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<?php get_template_part('inc/parts/item'); ?>
	<?php endwhile; wp_reset_query(); ?>
</div>
