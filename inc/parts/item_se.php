<?php 

$name = dt_get_meta("name");
$serie = dt_get_meta("serie");
$season = dt_get_meta("temporada");
$dates = dt_get_meta("air_date");
?>
<article class="item se <?php echo get_post_type(); ?>" id="post-<?php the_id(); ?>">
	<div class="poster">
		<img src="<?php if($thumb_id = get_post_thumbnail_id()) { $thumb_url = wp_get_attachment_image_src($thumb_id,'dt_poster_a', true); echo $thumb_url[0]; } else { dt_image('dt_poster', $post->ID, 'w185'); } ?>" alt="<?php the_title(); ?>">
		<?php if($values = dt_get_meta("temporada")) { ?>
		<div class="season_m animation-1">
			<a href="<?php the_permalink() ?>">
				<span class="a"><?php _d('season'); ?></span>
				<span class="b"><?php echo $values; ?></span>
				<span class="c"><?php echo dt_get_meta("serie"); ?></span>
			</a>
		</div>
		<?php } ?>
	</div>
	<div class="data">
		<h3><a href="<?php the_permalink() ?>"><?php _d('Season'); ?> <?php echo $season; ?></a></h3>
		<span><?php $date = new DateTime($dates); echo $date->format(DT_TIME); ?></span>
	</div>
</article>