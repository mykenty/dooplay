 <article class="item" id="post-<?php the_id(); ?>">
	<div class="image">
		<a href="<?php the_permalink() ?>"><img src="<?php dt_image('dt_backdrop', $post->ID, 'w600'); ?>" alt="<?php the_title(); ?>" /></a>
		<a href="<?php the_permalink() ?>">
		<div class="data">
			<h3 class="title"><?php the_title(); ?></h3>
			<?php if($mostrar = $terms = strip_tags( $terms = get_the_term_list( $post->ID, 'dtyear'))) {  ?><span><?php echo $mostrar; ?></span><?php } else { ?>
			<?php if($data = new DateTime(dt_get_meta('air_date'))) { ?><span><?php echo $data->format(DT_TIME); ?></span><?php } } ?>
		</div>
		</a>
		<span class="item_type"><?php if($d = get_post_type() == 'movies') { _d('Movie'); } if($d = get_post_type() == 'tvshows') { _d('TV'); } ?><span>
	</div>
</article>