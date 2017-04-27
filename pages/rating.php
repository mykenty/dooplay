<?php 
/*
Template Name: DT - Rating page
*/
get_header(); 
$dt = $_GET['get'];
if($dt == 'movies'):
	$setion = array('movies');
elseif($dt == 'tv'):
	$setion = array('tvshows');
else:
	$setion = array('movies','tvshows');
endif;
?>

<div class="module">
	<?php get_template_part('inc/parts/sidebar'); ?>
	<div class="content">
	<header>
		<h1><?php _d('Ratings'); ?></h1>
		<span class="s_trending">
			<a href="<?php the_permalink() ?>" class="m_trending <?php echo $dt == '' ? 'active' : ''; ?>"><?php _d('See all'); ?></a>
			<a href="<?php the_permalink() ?>?get=movies" class="m_trending <?php echo $dt == 'movies' ? 'active' : ''; ?>"><?php _d('Movies'); ?></a>
			<a href="<?php the_permalink() ?>?get=tv" class="m_trending <?php echo $dt == 'tv' ? 'active' : ''; ?>"><?php _d('TV Show'); ?></a>
			<?php global $user_ID; if( $user_ID ) : if( current_user_can('level_10') ) : ?>
			<a href="<?php the_permalink() ?>?admin=reset" class="m_trending reset"><?php _d('Reset'); ?></a>
			<?php endif; endif; ?>
		</span>
	</header>
		<div class="items">
		<?php
		// reset trending..
		if($_GET['admin'] =='reset'):
			global $user_ID; if( $user_ID ) : 
				if( current_user_can('level_10') ) :
				reset_rating_avg();
				reset_rating_total();
				reset_rating_data();
				endif;
			endif;
		endif;
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		query_posts(array(
			'post_type' => $setion,
			'meta_key' => 'end_time',
			'meta_compare' => '>=',
			'meta_value' => time() ,
			'meta_key' => DT_MAIN_RATING,
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'paged' => $paged
		));

		while (have_posts()):
			the_post(); ?>
		<?php get_template_part('inc/parts/item'); ?>
		<?php endwhile; ?>
		</div>
		<?php if (function_exists("pagination")) { pagination($additional_loop->max_num_pages); } ?>
	</div>
</div>
<?php get_footer();