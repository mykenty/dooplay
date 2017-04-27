<?php

$activate	= get_option('dt_main_slider');
$option		= get_option('dt_main_slider_radom');
$auto		= get_option('dt_main_slider_autoplay');
$num		= get_option('dt_main_slider_items','10');
$order		= get_option('dt_main_slider_order','desc');

if($option == 'true') {
	$rand = 'rand';
} else {
	$rand = '';	
} ?>

<?php if($activate == 'true') { ?>
<div class="adv_slider">
	<div class="slider_box">
		<div id="slider-master" class="animation-1 slider">
		<?php query_posts( array(
			'post_type' => array('tvshows','movies'), 
			'showposts' => $num,
			'orderby' => $rand, 
			'order' => $order,
			// 'tax_query' => array( array('taxonomy' => 'genres','field' => 'id','terms' => array('15') ) )
			)
		); ?>
		<?php while ( have_posts() ) : the_post(); get_template_part('inc/parts/item_b'); endwhile; wp_reset_query(); ?>
		</div>
	</div>
</div>
<?php } ?>