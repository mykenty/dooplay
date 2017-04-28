<?php 

if( isset( $_GET[ 'tab' ] ) ) {  
	$tab = $_GET[ 'tab' ];  
		} else {
			$tab = '';
        }
$dato = $_GET['tab'];
// Movies Meta data
$dt_date1			= new DateTime(dt_get_meta('first_air_date'));
$dt_date2			= new DateTime(dt_get_meta('last_air_date'));
$dt_id_tvshow		= dt_get_meta('ids');
$dt_episodes		= dt_get_meta('number_of_episodes');
$dt_seasons			= dt_get_meta('number_of_seasons');
$dt_original_title	= dt_get_meta('original_name');
$dt_status			= dt_get_meta('status');
$dt_tmdb_rating		= dt_get_meta('imdbRating');
$dt_tmdb_votes		= dt_get_meta('imdbVotes');
$dt_runtime			= dt_get_meta('episode_run_time');
$dt_homepage		= dt_get_meta('homepage');
$dt_popularity		= dt_get_meta('popularity');
$dt_type			= dt_get_meta('type');
$dt_trailer			= dt_get_meta('youtube_id');
$dt_images			= dt_get_meta('imagenes');
$dt_cast			= dt_get_meta('dt_cast');
$dt_clgnrt			= dt_get_meta('clgnrt');
// Datos 
$dt_rating_dt		= dt_get_meta('_starstruck_avg');
$dt_votes_dt		= dt_get_meta('_starstruck_total');


if($_GET['manually']=='true') { 
	global $user_ID; if( $user_ID ) : if( current_user_can('level_10') ) : 
		update_post_meta($post->ID, 'clgnrt', '1'); 
	endif; endif; 
	} 
?>  



<div id="single" class="dtsingle">
<?php if (have_posts()) :while (have_posts()) : the_post(); set_dt_views(get_the_ID()); ?>
<div class="content">
<div class="sheader">
	<div class="poster">
	<img src="<?php if($thumb_id = get_post_thumbnail_id()) { $thumb_url = wp_get_attachment_image_src($thumb_id,'dt_poster_a', true); echo $thumb_url[0]; } else { dt_image('dt_poster', $post->ID, 'w185'); } ?>" alt="<?php the_title(); ?>">
	</div>
	<div class="data">
		<h1><?php the_title(); ?></h1>
		<div class="extra">
			<?php if($d = $dt_date1) { echo '<span class="date">', $d->format(DT_TIME), '</span>'; } ?> 
			<span><?php echo get_the_term_list($post->ID, 'dtnetworks', '', '', ''); ?></span>
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
	<?php if($dt_clgnrt =='1') { ?><li><a href="#episodes"><?php _d('Episodes'); ?></a></li><?php } ?>
	<?php if($dt_cast) { ?><li><a href="#cast"><?php _d('Cast'); ?></a></li><?php } ?>
	<!--<?php if($dt_trailer) { ?><li><a href="#trailer"><?php _d('Trailer'); ?></a></li><?php } ?>-->
	</ul>
	<?php if ( is_user_logged_in() ) { echo get_simple_likes_button( get_the_ID() ); } ?>
</div>




<div id="cast" class="sbox fixidtab">
	<h2><?php _d('Creator'); ?></h2>
	<div class="persons">
		<?php  dt_creator($post->ID, "img", true); ?>
	</div>
	<h2><?php _d('Cast'); ?></h2>
	<div class="persons">
		<?php dt_cast_2($post->ID, "img", true); ?>
	</div>
</div>



<!--div id="trailer" class="sbox fixidtab">
	<h2><?php _d('Video trailer'); ?></h2>
	<div class="videobox">
		<div class="embed">
			<?php $trailers = get_post_meta($post->ID, "youtube_id", $single = true); mostrar_trailer_iframe($trailers) ?>
		</div>
	</div>
</div-->


<div id="info" class="sbox fixidtab">
	<!--<h2><?php //_d('Synopsis'); ?></h2>-->
	<div class="wp-content" style="border-bottom:none;margin-bottom:0px;padding-bottom:0px">
		<div class="videobox">
			<div class="embed">
				<?php $trailers = get_post_meta($post->ID, "youtube_id", $single = true); mostrar_trailer_iframe($trailers) ?>
			</div>
		</div>
		<?php the_content(); ?>
		<div id="dt_galery" class="galeria">
			<?php dt_get_images("w300", $post->ID); ?>
		</div>
		<?php if(get_option('ads_ss_2') =="true") { if($ads = get_option('ads_spot_single')) { echo '<div class="module_single_ads">'. stripslashes($ads). '</div>'; } } ?>
	</div>

	<?php if($d = $dt_original_title) { ?>
	<div class="custom_fields">
		<b class="variante"><?php _d('Original title'); ?></b>
		<span class="valor"><?php echo $d; ?></span>
	</div>
	<?php } ?>

	<?php if($d = $dt_seasons) { ?>
	<div class="custom_fields">
		<b class="variante"><?php _d('Seasons'); ?></b>
		<span class="valor"><?php echo $d; ?></span>
	</div>
	<?php } ?>

	<?php if($d = $dt_episodes) { ?>
	<div class="custom_fields">
		<b class="variante"><?php _d('Episodes'); ?></b>
		<span class="valor"><?php echo $d; ?></span>
	</div>
	<?php } ?>

	<?php if($d = $dt_status) { ?>
	<div class="custom_fields">
		<b class="variante"><?php _d('Status'); ?></b>
		<span class="valor"><?php echo $d; ?></span>
	</div>
	<?php } ?>

<?php global $user_ID; if( $user_ID ) : if( current_user_can('level_10') ) : 
if($dt_clgnrt =='1') { /* none */ } else { ?>
<a href="<?php the_permalink() ?>?manually=true" class="addcontent button main"><?php _d('Manually adding content'); ?></a>
<?php } endif; endif; ?>
</div>
<?php get_template_part('inc/parts/single/listas/se_ep'); ?>
<div class="sbox">
	<?php links_social_single($post->ID); ?>
</div>
<?php get_template_part('inc/parts/single/relacionados'); ?>
<?php get_template_part('inc/parts/comments'); ?>
</div>
<?php endwhile; endif; ?>
<div class="sidebar scrolling">
	<?php if($widgets = dynamic_sidebar('sidebar-tvshows')) { $widgets; } else { echo '<a href="'. esc_url( home_url() ) .'/wp-admin/widgets.php" target="_blank">'. __d('Add widgets') .'</a>'; } ?>
</div>

</div>