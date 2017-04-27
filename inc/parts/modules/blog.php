<header>
<h2><?php echo get_option('dt_blo_title','Last entries'); ?></h2>
<span><?php if($url = get_option('dt_posts_page','blog')) { ?><a href="<?php echo  $url; ?>"><?php _d('See all'); ?></a><?php } ?></span>
</header>
<div class="list-items-blogs">
<?php query_posts( array('post_type' => array('post'), 'showposts' => get_option('dt_blo_number_items','5'), 'orderby' => '', 'order' => 'desc')); ?>
<?php if (have_posts()) : while ( have_posts() ) : the_post(); ?>
<div class="post-entry" id="entry-<?php the_id(); ?>">
	<div class="home-blog-post">
		<div class="entry-date">
			<div class="date"><?php dt_post_date('j'); ?></div>
			<div class="month"><?php dt_post_date('F'); ?></div>
		</div>
		<div class="entry-datails">
			<div class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
			<div class="entry-content"><?php dt_content('',TRUE,'', get_option('dt_blo_number_words','15')); ?></div>
		</div>
	</div>
</div>
<?php endwhile;  else: ?>
<div class="dt-no-post"><?php _d('No posts to show'); ?></div>
<?php endif;  wp_reset_query(); ?>
</div>
