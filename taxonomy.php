<?php


get_header(); ?>
<div class="module">
	<div class="content">
	<header>
		<h1><?php printf( __d('%s'), '' . single_tag_title('', false ) . ''); ?></h1>
		<span></span>
	</header>
	<div class="desc_category">
		<?php echo category_description(); ?>
	</div>
	<div class="<?php if(is_tax('dtquality')) { echo 'slider'; } else { echo 'items'; } ?>">
		<?php if (have_posts()) :while (have_posts()) : the_post(); ?>
			<?php  if(is_tax('dtquality')) { get_template_part('inc/parts/item_b'); } else { get_template_part('inc/parts/item'); } ?>
		<?php endwhile; endif; ?>
	</div>
	<?php if (function_exists("pagination")) { pagination($additional_loop->max_num_pages); } ?>
	</div>
	<?php get_template_part('inc/parts/sidebar'); ?>
</div>
<?php get_footer(); ?>