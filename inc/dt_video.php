<?php


/* Video Assets
-------------------------------------------------------------------------------
*/
function dt_assets_video() {
	if(is_single()) {
		wp_enqueue_style('dt_player_style', DT_DIR_URI .'/assets/player/dist/plyr.css' , array(), DT_VERSION, 'all');
		wp_enqueue_script('dt_player_main_script',  DT_DIR_URI .'/assets/player/dist/plyr.js' , array(), DT_VERSION, true  );
		wp_enqueue_script('dt_player_script',  DT_DIR_URI .'/assets/player/setup.js' , array(), DT_VERSION, true  );
	}
}
add_action('wp_enqueue_scripts', 'dt_assets_video'); 

/* Video functions
-------------------------------------------------------------------------------
*/
function dt_video( $id, $url ) {
	$image = dt_image('dt_backdrop', $id, 'original', false, true);
	echo '<section class="dt_player_video">';
	echo '<video class="dt_player" poster="'.$image.'" controls crossorigin>';
	echo '<source src="'.$url.'" type="video/mp4">';
	echo '<a href="'.$url.'">download></a>';
	echo '</video>';
	echo '</section>';
}