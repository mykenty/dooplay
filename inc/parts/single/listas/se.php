<div id="serie_contenido" style="padding-top:0">
<?php


$tmdb = get_post_meta($post->ID, "ids", $single = true);
$current_season = get_post_meta($post->ID, "temporada", $single = true);
$data = season_of($tmdb);
if(!empty($data)){ ?>
<div id="seasons">
<div class="se-c">
<div  class="se-a" style='display:block'>
<ul class="episodios">
<?php 
$temporada = $data['temporada']['all'];
$capitulos = $data['capitulo']['all'];
foreach($temporada as $key_t=>$value_t){
foreach($capitulos as $key_c=>$value_c){
	if($value_t['season'] == $value_c['season']){
	if($value_c['season'] == $current_season){
?>
<li class="mark-<?php echo data_of('episodio',$value_c['id']); ?>">
	<div class="imagen"><a href="<?php echo get_permalink( $value_c['id'] ); if(data_of('repeatable_fields', $value_c['id'])) { echo ''; } ?>"><img src="<?php if($thumb_id = get_post_thumbnail_id($value_c['id'])) { $thumb_url = wp_get_attachment_image_src($thumb_id,'dt_episode_a', true); echo $thumb_url[0]; } else { dt_image('dt_backdrop', $value_c['id'], 'w150'); } ?>"></a></div>
	<div class="episodiotitle">
	<a href="<?php echo get_permalink( $value_c['id'] ); if(data_of('repeatable_fields', $value_c['id'])) { echo ''; } ?>"><?php if(data_of('episode_name', $value_c['id']) != "N/A") { echo data_of('episode_name', $value_c['id']); } ?></a>
	</div>
</li>
<?php	
} 
} 
} 
}
echo '</ul></div></div></div>';
} 
?>
</div>