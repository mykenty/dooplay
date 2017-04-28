<?php

$se = dt_get_meta("temporada");
$ep = dt_get_meta("episodio");
$name = dt_get_meta("episode_name");
$serie = dt_get_meta("serie");
$dates = dt_get_meta("air_date");
$dt_player	= get_post_meta($post->ID, 'repeatable_fields', true); 
$thumb = "";

foreach ( $dt_player as $field ) {
	if($field['select'] == 'youtube') {
		$thumb = 'http://i3.ytimg.com/vi/'.$field['url'].'/hqdefault.jpg';
		break;
	}
} 

?>
<article class="item se <?php echo get_post_type(); ?>" id="post-<?php the_id(); ?>">
	<a href="<?php the_permalink() ?>">
	<div class="poster">
		
		<img src="<?php 
		if($thumb == "")
		{
			if($thumb_id = get_post_thumbnail_id()) { 
				$thumb_url = wp_get_attachment_image_src($thumb_id,'dt_episode_a', true); 
				echo $thumb_url[0]; 
			} else { 
				dt_image('dt_backdrop', $post->ID, 'w300'); 
			}
		}
		else {
			echo $thumb;
		}
		 ?>" 
		alt="<?php the_title(); ?>">
		<div class="season_m animation-1">
			
				<!--span class="b"><?php echo $se; ?>x<?php echo $ep; ?></span-->
				<!--span class="a"><?php _d('season x episode'); ?></span-->
				<span class="c"><?php echo $serie; ?></span>
		</div>
		<?php wp_delete_post_link('<span class="icon-times-circle"></span>', '<i class="delete">', '</i>'); ?>
		<?php if($mostrar = $terms = strip_tags( $terms = get_the_term_list( $post->ID, 'dtquality'))) {  ?><span class="quality"><?php echo $mostrar; ?></span><?php } ?>
		<span class="serie"><?php echo $serie; ?></span>
	</div>
	<div class="data">
		<h3>
		<?php $i=0; if ( $dt_player ) : foreach ( $dt_player as $field ) { if($i==2) break; ?>
		<div class="flag" style="background-image: url(<?php echo DT_DIR_URI, '/assets/img/flags/',$field['idioma'],'.png'; ?>)"></div>
		<?php $i++; } endif; ?>
		<?php echo $name; ?>
		</h3>
		<!--span><?php $date = new DateTime($dates); echo $date->format(DT_TIME); ?></span-->
	</div>
	</a>
</article>