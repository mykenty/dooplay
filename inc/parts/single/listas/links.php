<?php

$register = get_option('dt_register_user');
$idts = get_post_meta($post->ID, "dt_string", $single = true);
$data = link_of($idts); if(!empty($data)) { ?>
<div class="linktabs">
	<h2><?php _d('Links'); ?></h2>
	<ul class="idTabs">
		<li><a href="#downloads"><?php _d('Download'); ?></a></li>
		<li><a href="#views"><?php _d('Watch online'); ?></a></li>
	</ul>
</div>
<div id="downloads" class="sbox">
	<div class="links_table">
		<div class="fix-table">
			<table>
				<thead>
					<tr>
						<th><strong><?php _d('Download'); ?></strong></th>
						<th><?php _d('Server'); ?></th>
						<th><?php _d('Quality'); ?></th>
						<th><?php _d('Language'); ?></th>
						<th><?php _d('Size'); ?></th>
						<th><?php _d('Added'); ?></th>
						<th><?php _d('User'); ?></th>
						<?php if (current_user_can('administrator')) { ?><th><?php _d('Manage'); ?></th><?php } ?>
					</tr>
				</thead>
				<tbody>
				<?php $dato = $data['dt_string']['all'];
					foreach($dato as $key_t=>$value_t){
					if($value_t['dt_string'] == $value_c['dt_string']){  if (data_of('links_type',$value_t['id']) == __d('Download')) {
						// Get Author
						$post_info = get_post( $value_t['id'] );
						$authorid = $post_info->post_author;
						$author = get_the_author_meta('nickname',  $authorid);
						$author_link = get_author_posts_url( $authorid );
					?>

					<tr id="<?php echo data_of('dt_string',$value_t['id']); ?>">
						<td class="cal"><a class="link_a download" href="<?php echo get_permalink( $value_t['id'] ); ?>" target="_blank"><i class="icon-download2"></i> <?php echo data_of('links_type',$value_t['id']); ?></a></td>
						<td><img src="<?php $link = data_of('links_url',$value_t['id']); echo DT_DICO. saca_dominio($link); ?>"> <?php $link = data_of('links_url',$value_t['id']); echo saca_dominio($link); ?></td>
						<td><?php echo data_of('links_quality',$value_t['id']); ?></td>
						<td><?php echo data_of('links_idioma',$value_t['id']); ?></td>
						<td><?php echo data_of('dt_filesize',$value_t['id']); ?></td>
						<td><?php echo human_time_diff(get_the_time('U',$value_t['id']), current_time('timestamp',$value_t['id'])); ?></td>
						<td><a href="<?php echo $author_link; ?>"><?php echo $author ?></a></td>
						<?php if (current_user_can('administrator')) { ?>
						<td>
						<?php
						// Editar / Eliminar
						echo "<a class='edit_link'  data-id='".$value_t['id']."'>". __d('Edit') ."</a>";
						echo " / <a href='" . wp_nonce_url( esc_url( home_url() ) . "/wp-admin/post.php?action=delete&amp;post=".$value_t['id']."", 'delete-post_' . $value_t['id']) . "'>". __d('Delete') ."</a>";
						?>
						</td>
						<?php } ?>
					</tr>
				<?php } } }?>
				<tbody>
			</table>
		</div>
	</div>
</div>
<?php } 
$idts = get_post_meta($post->ID, "dt_string", $single = true);
$data = link_of($idts); if(!empty($data)) { ?>
<div id="views" class="sbox">
	<div class="links_table">
		<div class="fix-table">
			<table>
				<thead>
					<tr>
						<th><strong><?php _d('Watch online'); ?></strong></th>
						<th><?php _d('Server'); ?></th>
						<th><?php _d('Quality'); ?></th>
						<th><?php _d('Language'); ?></th>
						<th><?php _d('Added'); ?></th>
						<th><?php _d('User'); ?></th>
						<?php if (current_user_can('administrator')) { ?><th><?php _d('Manage'); ?></th><?php } ?>
					</tr>
				</thead>
				<tbody>
				<?php $dato = $data['dt_string']['all'];
					foreach($dato as $key_t => $value_t) {
					if($value_t['dt_string'] == $value_c['dt_string']){  if (data_of('links_type',$value_t['id']) == __d('Watch online')) { 
						// Get Author
						$post_info = get_post( $value_t['id'] );
						$authorid = $post_info->post_author;
						$author = get_the_author_meta('nickname',  $authorid);
						$author_link = get_author_posts_url( $authorid );
					?>
					<tr id="<?php echo data_of('dt_string',$value_t['id']); ?>">
						<td class="cal"><a class="link_a video_online" href="<?php echo get_permalink( $value_t['id'] ); ?>" target="_blank"><i class="icon-play3"></i> <?php echo data_of('links_type',$value_t['id']); ?></a></td>
						<td><img src="<?php $link = data_of('links_url',$value_t['id']); echo DT_DICO. saca_dominio($link); ?>"> <?php $link = data_of('links_url',$value_t['id']); echo saca_dominio($link); ?></td>
						<td><?php echo data_of('links_quality',$value_t['id']); ?></td>
						<td><?php echo data_of('links_idioma',$value_t['id']); ?></td>
						<td><?php echo human_time_diff(get_the_time('U',$value_t['id']), current_time('timestamp',$value_t['id'])); ?></td>
						<td><a href="<?php echo $author_link; ?>"><?php echo $author ?></a></td>
						<?php if (current_user_can('administrator')) { ?>
						<td>
						<?php
						// Editar / Eliminar
						echo "<a class='edit_link'  data-id='".$value_t['id']."'>". __d('Edit') ."</a>";
						echo " / <a href='" . wp_nonce_url( esc_url( home_url() ) . "/wp-admin/post.php?action=delete&amp;post=".$value_t['id']."", 'delete-post_' . $value_t['id']) . "'>". __d('Delete') ."</a>";
						?>
						
						</td>
						<?php } ?>
					</tr>
				<?php } } } ?>
				<tbody>
			</table>
		</div>
	</div>
</div>
<?php } ?>
<?php if( is_user_logged_in() ) {  ?>
<div id="form" class="sbox">
	<div class="links_table">
		<?php get_template_part('inc/parts/form_links'); ?>
	</div>
</div>
<?php } elseif($register == 'true') { ?>
<div id="form" class="sbox">
	<div id="resultado_link_form">
		<div class="msg"><i class="icon-notification"></i><a class="clicklogin"><?php _d('Log in'); ?></a> <?php _d('to post links'); ?></div>
	</div>
</div>
<?php } ?>



