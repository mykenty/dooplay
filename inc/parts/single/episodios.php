<?php 

$dt_date = new DateTime(dt_get_meta('air_date'));
$name	= dt_get_meta('episode_name');
$serie = dt_get_meta('serie');
$ids = dt_get_meta('ids');
$temp = dt_get_meta('temporada');
$epis = dt_get_meta('episodio');
$poster = dt_get_meta('dt_poster');
$backdrop = dt_get_meta('dt_backdrop');
$dt_images = dt_get_meta('imagenes');
$dt_reports         = dt_get_meta('numreport');
$dt_player = get_post_meta($post->ID, 'repeatable_fields', true);
?>
<?php if (have_posts()) :while (have_posts()) : the_post(); set_dt_views(get_the_ID());
	$thumb_id = get_post_thumbnail_id();
	$thumb_url = wp_get_attachment_image_src($thumb_id,'full', true); 
?>
<style>
#seasons .se-c .se-a ul.episodios li.mark-<?php echo $epis; ?> {background-color:#fff000;}
</style>
<div id="single" class="dtsingle">
	<div id="edit_link"></div>
	<div class="content">
		<?php  if($dt_player): get_template_part('inc/parts/single/player'); endif; ?>
		<?php get_template_part('inc/parts/single/listas/pag_episodes'); ?>
		<div id="info" class="sbox">
			<h1 class="epih1"><?php echo $name; ?></h1>
			<div itemprop="description">
				<h3 class="epih3"><?php echo $serie; ?></h3>
				<?php the_content(); ?>
				<?php if($dt_images) { ?>
				<div id="dt_galery" class="galeria animation-2">
					<?php dt_get_images("w300", $post->ID); ?>
				</div>
				<?php } ?>
			</div>
			<!--?php if($d = $dt_date) { echo '<span class="date">', $d->format(DT_TIME), '</span>'; } ?-->
		</div>
		<div class="sbox">
			<?php links_social_single($post->ID); ?>
		</div>
		<div class="sbox">
			<h2>Video nhạc cùng album</h2>
			<?php get_template_part('inc/parts/single/listas/se'); ?>
		</div>
		<div class="box_links">
			<?php get_template_part('inc/parts/single/listas/links'); ?>
		</div>
		<?php get_template_part('inc/parts/comments'); ?> 
	</div>
	<?php endwhile; endif; ?>
	<div class="sidebar scrolling">
		<?php if($widgets = dynamic_sidebar('sidebar-tvshows')) { $widgets; } else { echo '<a href="'. esc_url( home_url() ) .'/wp-admin/widgets.php" target="_blank">'. __d('Add widgets') .'</a>'; } ?>
	</div>
</div>
<?php  if(current_user_can('administrator')) { if($dt_reports >= 1 ) {  ?>
<div class="reports_notice_admin">
	<span class="num"><?php echo $dt_reports; ?></span>
	<span class="report"><?php _d('Reports'); ?></span>
	<span><a data-id="<?php echo get_the_id(); ?>" class="delete_notice"><?php _d('Delete notice'); ?></a></span>
</div>
<?php } } ?>