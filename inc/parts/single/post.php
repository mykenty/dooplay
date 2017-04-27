<?php 

?>
<div id="single" class="dtsingle">
<?php if (have_posts()) :while (have_posts()) : the_post(); set_dt_views(get_the_ID()); ?>
	<div class="content">
		<div class="posts">
			<header class="pos">
				<h1 class="titl"><?php the_title(); ?></h1>
				<?php if($desc = dt_get_meta('dt_post_desc')) { echo '<h2 class="desc">'. $desc .'</h2>'; } ?>
			</header>
			<div class="meta">
				<span class="autor"><i class="icon-account_circle"></i> <?php the_author(); ?></span>
				<span class="date"><?php dt_post_date('F j, Y'); ?></span>
				<?php if($views = dt_get_meta('dt_views_count')) { echo '<span class="views">'. __d('Views') .' <strong>'. $views .'</strong></span>'; } ?>
			</div>
			<div class="wp-content">
				<?php the_content(); ?>
			</div>
			<div class="tax_post">
				<?php if(get_the_category()) { ?>
				<div class="tax_box">
					<div class="title"><?php _d('Categories'); ?></div>
					<div class="links"><?php the_category(' '); ?></div>
				</div>
				<?php } if(get_the_tags()) { ?>
				<div class="tax_box">
					<div class="title"><?php _d('Tags'); ?></div>
					<div class="links"><?php the_tags(' ', ' '); ?></div>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="sbox">
			<?php links_social_single($post->ID); ?>
		</div>
		<?php get_template_part('inc/parts/comments'); ?>
	</div>
<?php endwhile; endif; ?>
	<div class="sidebar scrolling">
		<?php if($widgets = dynamic_sidebar('sidebar-posts')) { $widgets; } else { echo '<a href="'. esc_url( home_url() ) .'/wp-admin/widgets.php">'. __d('Add widgets') .'</a>'; } ?>
	</div>
</div>