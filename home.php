<?php

get_header();
get_template_part('inc/dt_slider'); 
// end header home
?>
<div class="module">
	<div class="content">
		<?php $codex = get_option('dt_shorcode_home'); if($codex):
			do_shortcode($codex); 
			else:
			 get_template_part('inc/parts/modules/slider');
			 get_template_part('inc/parts/modules/letter');
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
	<div class="sidebar scrolling">
		<div class="fixed-sidebar-blank">
			<?php $widgets = dynamic_sidebar('sidebar-home'); if($widgets) { $widgets; } else { echo '<a href="'. esc_url( home_url() ) .'/wp-admin/widgets.php">'. __d('Add widgets') .'</a>'; } ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>