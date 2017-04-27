<?php 
/*
Template Name: DT - Trending page
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
echo '<div class="module">';
	get_template_part('inc/parts/sidebar');
echo '<div class="content">'; ?>
<header>
	<h1><?php _d('Trending'); ?></h1>
	<span class="s_trending">
		<a href="<?php the_permalink() ?>" class="m_trending <?php echo $dt == '' ? 'active' : ''; ?>"><?php _d('See all'); ?></a>
		<a href="<?php the_permalink() ?>?get=movies" class="m_trending <?php echo $dt == 'movies' ? 'active' : ''; ?>"><?php _d('Movies'); ?></a>
		<a href="<?php the_permalink() ?>?get=tv" class="m_trending <?php echo $dt == 'tv' ? 'active' : ''; ?>"><?php _d('TV Show'); ?></a>
		<?php global $user_ID; if( $user_ID ) : if( current_user_can('level_10') ) : ?>
		<a href="<?php the_permalink() ?>?admin=reset" class="m_trending reset"><?php _d('Reset'); ?></a>
		<?php endif; endif; ?>
	</span>
</header>
<?php
// reset trending..
if($_GET['admin'] =='reset'):
	global $user_ID; if( $user_ID ) : 
		if( current_user_can('level_10') ) :
		reset_tv();
		reset_movies();
		endif;
	endif;
endif;
// Items
echo '<div class="items">';
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts(array(
	'post_type' => $setion,
	'meta_key' => 'end_time',
	'meta_compare' => '>=',
	'meta_value' => time() ,
	'meta_key' => 'dt_views_count',
	'orderby' => 'meta_value_num',
	'order' => 'DESC',
	'paged' => $paged
));
while (have_posts()): the_post();
	get_template_part('inc/parts/item');
endwhile;
echo '</div>';
	if (function_exists("pagination")) { pagination($additional_loop->max_num_pages); }
echo '</div></div>';
get_footer();
