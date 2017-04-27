<?php


if(get_option('dt_mt_random_order') == 'true') {
	$rand = 'rand';
} else {
	$rand = '';	
} ?>
<header>
<h2><?php echo get_option('dt_mt_title','Album  nhạc'); ?></h2>
<?php if(get_option('dt_mt_activate_slider') == 'true') { if(get_option('dt_mt_autoplay_slider') == 'true') { } else { ?>
<div class="nav_items_module">
  <a class="btn prev4"><i class="icon-caret-left"></i></a>
  <a class="btn next4"><i class="icon-caret-right"></i></a>
</div>
<?php } } ?>
<span><?php echo total_series(); ?> <?php if($url = get_option('dt_tvshows_slug','tvshows')) { ?><a href="<?php echo esc_url( home_url() ) .'/'. $url .'/'; ?>" class="see-all"><?php _d('Xem tất cả'); ?></a><?php } ?></span>
</header>
<div id="tvload" class="load_modules"><?php _d('Loading..');?></div>
<div <?php if(get_option('dt_mt_activate_slider') == 'true') { echo 'id="dt-tvshows"'; } ?> class="items">
	<?php query_posts( array('post_type' => array('tvshows'), 'dtnetworks' => array('Asia'), 'showposts' => get_option('dt_mt_number_items','10'), 'orderby' => $rand, 'order' => 'desc')); ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<?php get_template_part('inc/parts/item'); ?>
	<?php endwhile; wp_reset_query(); ?>
</div>

<!-------- LIVESHOW --------------->
<header>
<h2><?php echo get_option('dt_mt_title','Liveshow'); ?></h2>
<?php if(get_option('dt_mt_activate_slider') == 'true') { if(get_option('dt_mt_autoplay_slider') == 'true') { } else { ?>
<div class="nav_items_module">
  <a class="btn prev4"><i class="icon-caret-left"></i></a>
  <a class="btn next4"><i class="icon-caret-right"></i></a>
</div>
<?php } } ?>
<span><?php echo total_series(); ?> <?php if($url = get_option('dt_tvshows_slug','tvshows')) { ?><a href="<?php echo esc_url( home_url() ) .'/'. $url .'/'; ?>" class="see-all"><?php _d('Xem tất cả'); ?></a><?php } ?></span>
</header>
<div id="tvload2" class="load_modules"><?php _d('Loading..');?></div>
<div <?php if(get_option('dt_mt_activate_slider') == 'true') { echo 'id="dt-tvshows2"'; } ?> class="items">
	<?php query_posts( array('post_type' => array('tvshows'), 'dtnetworks' => array('Liveshow'), 'showposts' => get_option('dt_mt_number_items','10'), 'orderby' => $rand, 'order' => 'desc')); ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<?php get_template_part('inc/parts/item'); ?>
	<?php endwhile; wp_reset_query(); ?>
</div>