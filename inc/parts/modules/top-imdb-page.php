<?php 


$items = get_option('dt_top_imdb_items','50');
$title = get_option('dt_imdbtop_title','Top IMDb');
// Movies and TV Top
if( get_option('dt_topimdb_layout') =='top_movies_tv') { ?>
<div class="top-imdb-list tleft">
<h3><?php _d('Movies'); ?></h3>
<?php query_posts( array(
	'post_type' => array('movies'), 
	'showposts' => $items, 
	'meta_key' => 'end_time',
	'meta_compare' => '>=',
	'meta_value' => time() ,
	'meta_key' => 'imdbRating',
	'orderby' => 'meta_value_num',
	'order' => 'desc')
); ?>
<?php $num = 1; { while ( have_posts() ) : the_post();
$thumb_id = get_post_thumbnail_id();
$thumb_url = wp_get_attachment_image_src($thumb_id,'dt_poster_b', true);
?>
<div class="top-imdb-item" id="top-<?php the_id(); ?>">
	<div class="image"><div class="poster"><a href="<?php the_permalink(); ?>"><img src="<?php if($thumb_id) { echo $thumb_url[0]; } else { dt_image('dt_poster', $post->ID, 'w90'); } ?>" /></a></div></div>
	<div class="puesto"><?php echo $num; ?></div>
	<div class="rating"><?php echo dt_get_meta('imdbRating'); ?></div>
	<div class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
</div>
<?php $num++; endwhile; } wp_reset_query(); ?>
</div>
<div class="top-imdb-list tright">
<h3><?php _d('TV Shows'); ?></h3>
<?php query_posts( array(
	'post_type' => array('tvshows'), 
	'showposts' => $items, 
	'meta_key' => 'end_time',
	'meta_compare' => '>=',
	'meta_value' => time() ,
	'meta_key' => 'imdbRating',
	'orderby' => 'meta_value_num',
	'order' => 'desc')
); ?>
<?php $num = 1; { while ( have_posts() ) : the_post(); 
$thumb_id = get_post_thumbnail_id();
$thumb_url = wp_get_attachment_image_src($thumb_id,'dt_poster_b', true);
?>
<div class="top-imdb-item" id="top-<?php the_id(); ?>">
	<div class="image"><div class="poster"><a href="<?php the_permalink(); ?>"><img src="<?php if($thumb_id) { echo $thumb_url[0]; } else { dt_image('dt_poster', $post->ID, 'w90'); } ?>" /></a></div></div>
	<div class="puesto"><?php echo $num; ?></div>
	<div class="rating"><?php echo dt_get_meta('imdbRating'); ?></div>
	<div class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
</div>
<?php $num++; endwhile; } wp_reset_query(); ?>
</div>
<?php } ?>



<?php
// Movies top
if( get_option('dt_topimdb_layout') =='top_movies') { ?>
<div class="top-imdb-list fix-layout-top">
<h3><?php _d('Movies'); ?></h3>
<?php query_posts( array(
	'post_type' => array('movies'), 
	'showposts' => $items, 
	'meta_key' => 'end_time',
	'meta_compare' => '>=',
	'meta_value' => time() ,
	'meta_key' => 'imdbRating',
	'orderby' => 'meta_value_num',
	'order' => 'desc')
); ?>
<?php $num = 1; { while ( have_posts() ) : the_post();
$thumb_id = get_post_thumbnail_id();
$thumb_url = wp_get_attachment_image_src($thumb_id,'dt_poster_b', true);
?>
<div class="top-imdb-item" id="top-<?php the_id(); ?>">
	<div class="image"><div class="poster"><a href="<?php the_permalink(); ?>"><img src="<?php if($thumb_id) { echo $thumb_url[0]; } else { dt_image('dt_poster', $post->ID, 'w90'); } ?>" /></a></div></div>
	<div class="puesto"><?php echo $num; ?></div>
	<div class="rating"><?php echo dt_get_meta('imdbRating'); ?></div>
	<div class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
</div>
<?php $num++; endwhile; } wp_reset_query(); ?>
</div>
<?php } ?>

<?php
// TV Top
if( get_option('dt_topimdb_layout') =='top_tv') { ?>
<div class="top-imdb-list fix-layout-top">
<h3><?php _d('TV Shows'); ?></h3>
<?php query_posts( array(
	'post_type' => array('tvshows'), 
	'showposts' => $items, 
	'meta_key' => 'end_time',
	'meta_compare' => '>=',
	'meta_value' => time() ,
	'meta_key' => 'imdbRating',
	'orderby' => 'meta_value_num',
	'order' => 'desc')
); ?>
<?php $num = 1; { while ( have_posts() ) : the_post(); 
$thumb_id = get_post_thumbnail_id();
$thumb_url = wp_get_attachment_image_src($thumb_id,'dt_poster_b', true);
?>
<div class="top-imdb-item" id="top-<?php the_id(); ?>">
	<div class="image"><div class="poster"><a href="<?php the_permalink(); ?>"><img src="<?php if($thumb_id) { echo $thumb_url[0]; } else { dt_image('dt_poster', $post->ID, 'w90'); } ?>" /></a></div></div>
	<div class="puesto"><?php echo $num; ?></div>
	<div class="rating"><?php echo dt_get_meta('imdbRating'); ?></div>
	<div class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
</div>
<?php $num++; endwhile; } wp_reset_query(); ?>
</div>
<?php } ?>