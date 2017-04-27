<?php 

$user_id = get_the_author_meta('id');
$id_post = get_the_id();
$idcontent = dt_get_meta('dt_postid');
$title = dt_get_meta('dt_postitle');
$url = dt_get_meta('links_url');
$type = dt_get_meta('links_type');
$views = dt_get_meta('dt_views_count');
$idioma = dt_get_meta('links_idioma');
$calidad = dt_get_meta('links_quality');
$status = get_post_status();
?>
<tr id="<?php echo $id_post; ?>">
	<td><?php echo $type; ?></td>
	<td><a href="<?php the_permalink(); ?>" target="_blank"><img src="<?php echo DT_DICO. saca_dominio($url); ?>"> <?php echo saca_dominio($url); ?></a></td>
	<td><a href="<?php echo home_url(). '?p='. $idcontent; ?>" target="_blank"><?php echo $title; ?></a></td>
	<td class="views"><?php if($views) { echo $views; } else { echo "-"; } ?></td>
	<td class="views"><?php if($calidad) { echo $calidad; } else { echo "-"; } ?></td>
	<td class="views"><?php if($idioma) { echo $idioma; } else { echo "-"; } ?></td>
	<td class="views"><?php echo human_time_diff(get_the_time('U',$id_post), current_time('timestamp',$id_post)); ?></td>
</tr>