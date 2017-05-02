<?php


if(get_option('dt_mt_random_order') == 'true') {
	$rand = 'rand';
} else {
	$rand = '';	
} ?>
<header>
<h2>Trung tâm Asia</h2>
<?php if(get_option('dt_mt_activate_slider') == 'true') { if(get_option('dt_mt_autoplay_slider') == 'true') { } else { ?>
<div class="nav_items_module">
  <a class="btn prev4"><i class="icon-caret-left"></i></a>
  <a class="btn next4"><i class="icon-caret-right"></i></a>
</div>
<?php } } ?>
<span><?php //echo total_series(); ?> <?php if($url = get_option('dt_tvshows_slug','tvshows')) { ?><a href="<?php echo esc_url( home_url() ) .'/?dtnetworks=asia' ?>" class="see-all"><?php _d('Xem tất cả'); ?></a><?php } ?></span>
</header>
<div id="tvload" class="load_modules"><?php _d('Loading..');?></div>
<div <?php if(get_option('dt_mt_activate_slider') == 'true') { echo 'id="dt-tvshows"'; } ?> class="items" style="border-bottom:none">
	<?php query_posts( array('post_type' => array('tvshows'), 'dtnetworks' => array('Asia'), 'showposts' => get_option('dt_mt_number_items','10'), 'orderby' => $rand, 'order' => 'desc')); ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<?php get_template_part('inc/parts/item'); ?>
	<?php endwhile; wp_reset_query(); ?>
</div>

<!-- THUY NGA PARIS  -->
<!-- AlbumVang --><ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-0896031801409434"
     data-ad-slot="9653309427"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

<header style="margin-top:80px">
<h2>Thúy Nga Paris</h2>
<?php if(get_option('dt_mt_activate_slider') == 'true') { if(get_option('dt_mt_autoplay_slider') == 'true') { } else { ?>
<div class="nav_items_module">
  <a class="btn prev5"><i class="icon-caret-left"></i></a>
  <a class="btn next5"><i class="icon-caret-right"></i></a>
</div>
<?php } } ?>
<span><?php //echo total_series(); ?> <?php if($url = get_option('dt_tvshows_slug','tvshows')) { ?><a href="<?php echo esc_url( home_url() ) .'/?dtnetworks=thuyngaparis'; ?>" class="see-all"><?php _d('Xem tất cả'); ?></a><?php } ?></span>
</header>
<div id="tvload2" class="load_modules"><?php _d('Loading..');?></div>
<div <?php if(get_option('dt_mt_activate_slider') == 'true') { echo 'id="dt-tvshows2"'; } ?> class="items">
	<?php query_posts( array('post_type' => array('tvshows'), 'dtnetworks' => array('ThuyNgaParis'), 'showposts' => get_option('dt_mt_number_items','10'), 'orderby' => $rand, 'order' => 'desc')); ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<?php get_template_part('inc/parts/item'); ?>
	<?php endwhile; wp_reset_query(); ?>
</div>

<!-- THUY NGA PARIS  -->
<header>
<h2>Trung tâm Vân Sơn</h2>
<?php if(get_option('dt_mt_activate_slider') == 'true') { if(get_option('dt_mt_autoplay_slider') == 'true') { } else { ?>
<div class="nav_items_module">
  <a class="btn prev6"><i class="icon-caret-left"></i></a>
  <a class="btn next6"><i class="icon-caret-right"></i></a>
</div>
<?php } } ?>
<span><?php //echo total_series(); ?> <?php if($url = get_option('dt_tvshows_slug','tvshows')) { ?><a href="<?php echo esc_url( home_url() ) .'/?dtnetworks=vanson'; ?>" class="see-all"><?php _d('Xem tất cả'); ?></a><?php } ?></span>
</header>
<div id="tvload3" class="load_modules"><?php _d('Loading..');?></div>
<div <?php if(get_option('dt_mt_activate_slider') == 'true') { echo 'id="dt-tvshows3"'; } ?> class="items">
	<?php query_posts( array('post_type' => array('tvshows'), 'dtnetworks' => array('VanSon'), 'showposts' => get_option('dt_mt_number_items','10'), 'orderby' => $rand, 'order' => 'desc')); ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<?php get_template_part('inc/parts/item'); ?>
	<?php endwhile; wp_reset_query(); ?>
</div>

<!-- LIVESHOW  -->
<header>
<h2>Liveshow</h2>
<?php if(get_option('dt_mt_activate_slider') == 'true') { if(get_option('dt_mt_autoplay_slider') == 'true') { } else { ?>
<div class="nav_items_module">
  <a class="btn prev7"><i class="icon-caret-left"></i></a>
  <a class="btn next7"><i class="icon-caret-right"></i></a>
</div>
<?php } } ?>
<span><?php //echo total_series(); ?> <?php if($url = get_option('dt_tvshows_slug','tvshows')) { ?><a href="<?php echo esc_url( home_url() ) .'/?dtnetworks=liveshow'; ?>" class="see-all"><?php _d('Xem tất cả'); ?></a><?php } ?></span>
</header>
<div id="tvload4" class="load_modules"><?php _d('Loading..');?></div>
<div <?php if(get_option('dt_mt_activate_slider') == 'true') { echo 'id="dt-tvshows4"'; } ?> class="items" style="border-bottom:none">
	<?php query_posts( array('post_type' => array('tvshows'), 'dtnetworks' => array('Liveshow'), 'showposts' => get_option('dt_mt_number_items','10'), 'orderby' => $rand, 'order' => 'desc')); ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<?php get_template_part('inc/parts/item'); ?>
	<?php endwhile; wp_reset_query(); ?>
</div>

<!-- KHAC  -->
<!-- AlbumVang --><ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-0896031801409434"
     data-ad-slot="9653309427"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

<header style="margin-top:80px">
<h2>Khác</h2>
<?php if(get_option('dt_mt_activate_slider') == 'true') { if(get_option('dt_mt_autoplay_slider') == 'true') { } else { ?>
<div class="nav_items_module">
  <a class="btn prev8"><i class="icon-caret-left"></i></a>
  <a class="btn next8"><i class="icon-caret-right"></i></a>
</div>
<?php } } ?>
<span><?php //echo total_series(); ?> <?php if($url = get_option('dt_tvshows_slug','tvshows')) { ?><a href="<?php echo esc_url( home_url() ) .'/?dtnetworks=new'; ?>" class="see-all"><?php _d('Xem tất cả'); ?></a><?php } ?></span>
</header>
<div id="tvload5" class="load_modules"><?php _d('Loading..');?></div>
<div <?php if(get_option('dt_mt_activate_slider') == 'true') { echo 'id="dt-tvshows5"'; } ?> class="items">
	<?php query_posts( array('post_type' => array('tvshows'), 'dtnetworks' => array('New'), 'showposts' => get_option('dt_mt_number_items','10'), 'orderby' => $rand, 'order' => 'desc')); ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<?php get_template_part('inc/parts/item'); ?>
	<?php endwhile; wp_reset_query(); ?>
</div>