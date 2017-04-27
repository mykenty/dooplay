<?php

get_header(); ?>
<div id="page">
	<div class="single-page">
	<?php while ( have_posts() ) : the_post(); ?>
		<h1 class="head"><?php the_title(); ?></h1>
		<div class="wp-content">
			<?php the_content(); ?>
		</div>
		<?php if(get_option('comments_on_page') =='true') { get_template_part('inc/parts/comments'); } ?>
	<?php endwhile; ?>
	</div>
	
</div>
<?php get_footer(); ?>