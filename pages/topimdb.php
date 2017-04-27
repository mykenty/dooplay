<?php 
/*
Template Name: DT - TOP IMDb
*/
get_header(); ?>

<div class="module">
<?php get_template_part('inc/parts/sidebar'); ?>
	<div class="content fix_posts_templante">
		<header>
			<h1 class="top-imdb-h1"><?php the_title(); ?> <?php echo get_option('dt_top_imdb_items','50'); ?></h1>
		</header>
		<?php get_template_part('inc/parts/modules/top-imdb-page'); ?>
	</div>
</div>
<?php get_footer(); ?>
