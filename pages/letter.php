
<div id="archive-content" class="animation-2 items">
<?php get_template_part('inc/parts/modules/letter'); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); get_template_part('inc/parts/item'); endwhile; else: ?>
<div class="no-result animation-2">
	<h2><?php _d('No results to show with'); ?> <span><?php echo wp_strip_all_tags($_GET['s']); ?></span></h2>
	<strong><?php _d('Suggestions'); ?>:</strong>
	<ul>
		<li><?php _d('Make sure all words are spelled correctly.'); ?></li>
		<li><?php _d('Try different keywords.'); ?></li>
		<li><?php _d('Try more general keywords.'); ?></li>
	</ul>
</div>
<?php endif; ?>
</div>