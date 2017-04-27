<?php


get_header(); ?>
<div class="module">
<?php get_template_part('inc/parts/sidebar'); ?>
	<div class="content">
		<header>
			<h1><?php printf( __d('Tag Archives: %s'), single_tag_title('', false ) ); ?></h1>
		</header>
		<div class="blog-list-items">
		<?php if (have_posts()) : while ( have_posts() ) : the_post(); $thumb_id = get_post_thumbnail_id(); $thumb_url =  wp_get_attachment_image_src($thumb_id,'dt_episode_a', true);?>
			<div class="entry animation-2">
				<article class="post">
					<a href="<?php the_permalink();?>">
					<div class="images">
							<img src="<?php if($thumb_id) { echo $thumb_url[0]; } else { echo DT_DIR_URI. '/assets/img/no-image.png'; } ?>" alt="<?php the_title(); ?>" />
							<div class="background_over_image"></div>
					</div>
					</a>
					<div class="information">
						<h2><?php the_title(); ?></h2>
						<div class="meta">
							<span class="autor"><i class="icon-account_circle"></i> <?php the_author(); ?></span>
							<span class="date"><?php dt_post_date('F j, Y'); ?></span>
						</div>
						<p class="descr"><?php dt_content('',TRUE,'', '15'); ?></p>
					</div>
				</article>
			</div>		<?php endwhile;  else: ?>
			<div class="dt-no-post"><?php _d('No posts to show'); ?></div>
		<?php endif; ?>
		</div>
	<?php if (function_exists("pagination")) { pagination($additional_loop->max_num_pages); } ?>
	</div>
</div>
<?php get_footer(); ?>
