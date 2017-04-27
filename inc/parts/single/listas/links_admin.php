<?php 

if(get_post_meta($post->ID, "dt_string", $single = true)) { ?>
<div id="links" class="sbox">
	<div class="links_table">
	<?php
	$idts = get_post_meta($post->ID, "dt_string", $single = true);
	$data = link_of($idts); if(!empty($data)){ ?>
	<div class="fix-table">
		<table class="dt_table_admin">
			<thead>
			<tr>
				<th><?php _d('Type'); ?></th>
				<th><?php _d('Server'); ?></th>
				<th><?php _d('Quality'); ?></th>
				<th><?php _d('Language'); ?></th>
				<th><?php _d('Size'); ?></th>
				<th><?php _d('Added'); ?></th>
				<?php if (current_user_can('edit_post', $value_t['id'])) { ?><th><?php _d('Manage'); ?></th><?php } ?>
			</tr>
			</thead>
			<tbody>
			<?php 
			$dato = $data['dt_string']['all'];
			foreach($dato as $key_t=>$value_t){
			if($value_t['dt_string'] == $value_c['dt_string']){ ?>
			<tr id="<?php echo data_of('dt_string',$value_t['id']); ?>">
				<td><a class="link_a" href="<?php echo data_of('links_url',$value_t['id']); ?>" target="_blank"><?php echo data_of('links_type',$value_t['id']); ?></a></td>
				<td><img src="https://plus.google.com/_/favicon?domain=<?php $link = data_of('links_url',$value_t['id']); echo saca_dominio($link); ?>"> <?php $link = data_of('links_url',$value_t['id']); echo saca_dominio($link); ?></td>
				<td><?php echo data_of('links_quality',$value_t['id']); ?></td>
				<td><?php echo data_of('links_idioma',$value_t['id']); ?></td>
				<td><?php echo data_of('dt_filesize',$value_t['id']); ?></td>
				<td><?php echo human_time_diff(get_the_time('U',$value_t['id']), current_time('timestamp',$value_t['id'])); ?> </td>
				<?php if (current_user_can('edit_post', $value_t['id'])) { ?>
				<td>
				<?php
				echo "<a href='" . esc_url( home_url() ) . "/wp-admin/post.php?post=".$value_t['id']."&action=edit' target='_blank'>". __d('Edit') ."</a> / ";
				echo "<a href='" . wp_nonce_url( esc_url( home_url() ) . "/wp-admin/post.php?action=delete&amp;post=".$value_t['id']."", 'delete-post_' . $value_t['id']) . "' target='_blank'>". __d('Delete') ."</a>";
				?>
				</td>
				<?php } ?>
			</tr>
			<?php }  } ?>
			<tbody>
		</table>
	</div>
	<?php } else { ?>
	<div class="dt_nodata"><?php _d('no data'); ?></div>
	<?php } ?>
	</div>
</div>
<?php } else { ?>
<div id="links" class="sbox">
	<div class="links_table">
		<div class="dt_nodata"><?php _d('no data'); ?></div>
	</div>
</div>
<?php } ?>
