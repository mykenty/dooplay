<?php


$dato = $_GET['tab'];
// Movies Meta data
$admin				= current_user_can('administrator');
$dt_date			= new DateTime(dt_get_meta('release_date'));
$dt_apid			= dt_get_meta('ids');
$dt_rating_imdb		= dt_get_meta('imdbRating');
$dt_votes_imdb		= dt_get_meta('imdbVotes');
$dt_rated			= dt_get_meta('Rated');
$dt_country			= dt_get_meta('Country');
$dt_title_original	= dt_get_meta('original_title');
$dt_rating_tmdb		= dt_get_meta('vote_average');
$dt_votes_tmdb		= dt_get_meta('vote_count');
$dt_tagline			= dt_get_meta('tagline');
$dt_runtime			= dt_get_meta('runtime');
$dt_trailer			= dt_get_meta('youtube_id');
$dt_images			= dt_get_meta('imagenes');
$dt_maindrop		= dt_get_meta('dt_backdrop');
$dt_reports         = dt_get_meta('numreport');
// Datos 
$dt_rating_dt		= dt_get_meta('_starstruck_avg');
$dt_votes_dt		= dt_get_meta('_starstruck_total');
$dt_player			= get_post_meta($post->ID, 'repeatable_fields', true);
//  Image
$thumb_id = get_post_thumbnail_id();
$thumb_url = wp_get_attachment_image_src($thumb_id,'dt_poster_a', true);
// Star Item post
if (have_posts()) :while (have_posts()) : the_post(); set_dt_views(get_the_ID()); ?>
<div id="single" class="dtsingle">
<div id="edit_link"></div>
<div class="content">
<?php  if($dt_player): get_template_part('inc/parts/single/player'); endif; ?>
<div class="sheader">
	<div class="poster">
		<img src="<?php if($thumb_id) { echo $thumb_url[0]; } else { dt_image('dt_poster', $post->ID, 'w185'); } ?>" alt="<?php the_title(); ?>">
	</div>
	<div class="data">
		<h1><?php the_title(); ?></h1>
		<div class="extra">
		<?php if($d = $dt_tagline) { echo '<span class="tagline">', $d, '</span>'; } ?>
		<?php if($d = $dt_date) { echo '<span class="date">', $d->format(DT_TIME), '</span>'; } ?> 
		<?php if($d = $dt_country) {   echo '<span class="country">', $d, '</span>';  } ?>
		<?php if($d = $dt_runtime) { echo '<span class="runtime">', $d, ' ', __d('Min.'), '</span>'; }; ?>
		<?php if($d = $dt_rated) { echo '<span class="C'. $d .' rated">', $d, '</span>'; } ?>	
		</div>
		<?php echo do_shortcode('[starstruck_shortcode]'); ?>
		<div class="sgeneros">
		<?php echo get_the_term_list($post->ID, 'genres', '', '', ''); ?>
		</div>
	</div>
</div>
<div class="single_tabs">
	<ul id="section" class="smenu idTabs">
	<li><a href="#info"><?php _d('Info'); ?></a></li>
	<li><a href="#cast"><?php _d('Cast'); ?></a></li>
	<?php if($dt_trailer) { ?><li><a href="#trailer"><?php _d('Trailer'); ?></a></li><?php } ?>
	<li><a href="#linksx"><?php _d('Links'); ?></a></li>
	</ul>
	<?php if ( is_user_logged_in() ) { echo get_simple_likes_button( get_the_ID() ); } ?>
</div>
<div id="trailer" class="sbox fixidtab">
<h2><?php _d('Video trailer'); ?></h2>
<div class="videobox">
<div class="embed">
<?php $trailers = get_post_meta($post->ID, "youtube_id", $single = true); mostrar_trailer_iframe($trailers) ?>
</div>
</div>
</div>
<div id="cast" class="sbox fixidtab">
<h2><?php _d('Director'); ?></h2>
<div class="persons">
	<?php  dt_director($post->ID, "img", true); ?>
</div>
<h2><?php _d('Cast'); ?></h2>
<div class="persons">
	<?php dt_cast_2($post->ID, "img", true); ?>
</div>
</div>

<div id="info" class="sbox fixidtab">
<!--<h2><?php //_d('Synopsis'); ?></h2>-->
<div itemprop="description" class="wp-content">
<?php the_content(); ?>

<?php if($dt_images) { ?>
<div id="dt_galery" class="galeria animation-2">
	<?php dt_get_images("w300", $post->ID); ?>
</div>
<?php } ?>
<?php if(get_option('ads_ss_1') =="true") { if($ads = get_option('ads_spot_single')) { echo '<div class="module_single_ads">'. stripslashes($ads). '</div>'; } } ?>
</div>
<?php if($d = $dt_title_original) { ?>
<div class="custom_fields">
<b class="variante"><?php _d('Original title'); ?></b>
<span class="valor"><?php echo $d; ?></span>
</div>
<?php } if($d = $dt_rating_imdb) { ?>
<div class="custom_fields">
	<b class="variante"><?php _d('IMDb Rating'); ?></b>
	<span class="valor">
		<b id="repimdb"><?php echo '<strong>', $d, '</strong> ', $dt_votes_imdb, ' ', __d('votes'); ?></b>
		<?php if($admin) { ?><a data-id="<?php echo get_the_id(); ?>" data-imdb="<?php echo $dt_apid; ?>" id="update_imdb_rating"><?php _d('Update Rating'); ?></a><?php } ?>
	</span>
</div>
<?php } if($d = $dt_rating_tmdb) { ?>
<div class="custom_fields">
<b class="variante"><?php _d('TMDb Rating'); ?></b>
<span class="valor"><?php echo '<strong>', $d, '</strong> ', $dt_votes_tmdb, ' ', __d('votes'); ?></span>
</div>
<?php } ?>
</div>
<?php get_template_part('inc/parts/single/links'); ?>
<div class="sbox">
	<?php links_social_single($post->ID); ?>
</div>
<?php get_template_part('inc/parts/single/relacionados'); ?>
<?php get_template_part('inc/parts/comments'); ?>
<?php // Eliminar reportes de error
if($_GET['report']=="ready") { 
	global $user_ID; if( $user_ID ) : if( current_user_can('level_10') ) : 
		delete_post_meta($post->ID, 'numreport');
	endif; endif;
} 
?>
<?php endwhile; endif; ?>
</div>
<div class="sidebar scrolling">
	<?php if($widgets = dynamic_sidebar('sidebar-movies')) { $widgets; } else { echo '<a href="'. esc_url( home_url() ) .'/wp-admin/widgets.php">'. __d('Add widgets') .'</a>'; } ?>
</div>
</div>
<?php  if(current_user_can('administrator')) { if($dt_reports >= 1 ) {  ?>
<div class="reports_notice_admin">
	<span class="num"><?php echo $dt_reports; ?></span>
	<span class="report"><?php _d('Reports'); ?></span>
	<span><a data-id="<?php echo get_the_id(); ?>" class="delete_notice"><?php _d('Delete notice'); ?></a></span>
</div>
<?php } } ?>
