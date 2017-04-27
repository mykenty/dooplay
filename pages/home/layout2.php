<div class="module layout2">
<?php get_template_part('inc/parts/sidebar'); ?>
	<div class="content">
		<?php if($codex = get_option('dt_shorcode_home')):
			do_shortcode($codex); 
			else:
			 get_template_part('inc/parts/modules/slider');
			 get_template_part('inc/parts/modules/movies');
			 get_template_part('inc/parts/modules/ads');
			 get_template_part('inc/parts/modules/tvshows');
			 get_template_part('inc/parts/modules/seasons');
			 get_template_part('inc/parts/modules/episodes');
			 get_template_part('inc/parts/modules/top-imdb');
			 get_template_part('inc/parts/modules/blog');
			endif;
		?>
	</div>
</div>