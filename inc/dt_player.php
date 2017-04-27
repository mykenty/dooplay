<?php

function dt_get_sample_options() {
	$options = array(
		__d('Youtube') => 'youtube',
		__d('URL Iframe') => 'iframe',
		__d('URL MP4 file') => 'mp4',
		__d('Shortcode') => 'dtshcode',
	);
	return $options;
}
add_action('admin_init', 'dt_add_meta_boxes', 1);
function dt_add_meta_boxes()
{
	add_meta_box('repeatable-fields', __d('Video Player') , 'dt_repeatable_meta_box_display', 'movies', 'normal', 'default');
	add_meta_box('repeatable-fields', __d('Video Player') , 'dt_repeatable_meta_box_display', 'episodes', 'normal', 'default');
}
function dt_repeatable_meta_box_display()
{
	global $post;
	$repeatable_fields = get_post_meta($post->ID, 'repeatable_fields', true);
	$options = dt_get_sample_options();
	$idiomas = dt_get_language();
	wp_nonce_field('dt_repeatable_meta_box_nonce', 'dt_repeatable_meta_box_nonce');
?>
	<script type="text/javascript">
	jQuery(document).ready(function( $ ){
		$('#add-row').on('click', function() {
			var row = $('.empty-row.screen-reader-text').clone(true);
			row.removeClass('empty-row screen-reader-text');
			row.insertBefore('#repeatable-fieldset-one tbody>tr:last');
			return false;
		});
		$('.remove-row').on('click', function() {
			$(this).parents('tr').remove();
			return false;
		});

		$('.dt_table_admin').sortable( {
			items: '.tritem',
			opacity: 0.8,
			cursor: 'move',
		} );
	});
	</script>
	<table id="repeatable-fieldset-one" width="100%" class="dt_table_admin">
	<thead>
		<tr>
			<th>#</th>
			<th><?php _d('Title'); ?></th>
			<th><?php _d('Type'); ?></th>
			<th><?php _d('URL source or Shortcode'); ?></th>
			<th><?php _d('Flag Language'); ?></th>
			<th><?php _d('Control'); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php if ( $repeatable_fields ) : foreach ( $repeatable_fields as $field ) { ?>
	<tr class="tritem">
		<td class="draggable"><span class="dashicons dashicons-move"></td>
		<td class="text_player"><input type="text" class="widefat" name="name[]" value="<?php if($field['name'] != '') echo esc_attr( $field['name'] ); ?>" required/></td>
		<td>
			<select name="select[]" style="width: 100%;">
			<?php foreach ( $options as $label => $value ) : ?>
			<option value="<?php echo $value; ?>"<?php selected( $field['select'], $value ); ?>><?php echo $label; ?></option>
			<?php endforeach; ?>
			</select>
		</td>
		<td><input type="text" class="widefat" name="url[]" placeholder="" value="<?php if ($field['url'] != '') echo esc_attr( $field['url'] ); else echo ''; ?>" /></td>
		<td>
			<select name="idioma[]" style="width: 100%;">
			<?php foreach ( $idiomas as $label => $value ) : ?>
			<option value="<?php echo $value; ?>"<?php selected( $field['idioma'], $value ); ?>><?php echo $label; ?></option>
			<?php endforeach; ?>
			</select>
		</td>
		<td><a class="button remove-row" href="#"><?php _d('Remove'); ?></a></td>
	</tr>
	<?php } else : ?>
	<tr class="tritem">
		<td class="draggable"><span class="dashicons dashicons-move"></td>
		<td class="text_player"><input type="text" class="widefat" name="name[]" /></td>
		<td>
			<select name="select[]" style="width: 100%;">
			<?php foreach ( $options as $label => $value ) : ?>
			<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
			<?php endforeach; ?>
			</select>
		</td>
		<td><input type="text" class="widefat" name="url[]" placeholder="" /></td>
		<td>
			<select name="idioma[]" style="width: 100%;">
			<?php foreach ( $idiomas as $label => $value ) : ?>
			<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
			<?php endforeach; ?>
			</select>
		</td>
		<td><a class="button remove-row" href="#"><?php _d('Remove'); ?></a></td>
	</tr>
	<?php endif; ?>
	<tr class="empty-row screen-reader-text tritem">
		<td class="draggable"><span class="dashicons dashicons-move"></td>
		<td class="text_player"><input type="text" class="widefat" name="name[]" /></td>
		<td>
			<select name="select[]" style="width: 100%;">
			<?php foreach ( $options as $label => $value ) : ?>
			<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
			<?php endforeach; ?>
			</select>
		</td>
		<td><input type="text" class="widefat" name="url[]" placeholder="" /></td>
		<td>
			<select name="idioma[]" style="width: 100%;">
			<?php foreach ( $idiomas as $label => $value ) : ?>
			<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
			<?php endforeach; ?>
			</select>
		</td>
		<td><a class="button remove-row" href="#"><?php _d('Remove'); ?></a></td>
	</tr>
	</tbody>
	</table>
	<p class="repeater"><a id="add-row" class="add_row" href="#"><?php _d('Add new row'); ?></a></p>
<?php
}
add_action('save_post', 'dt_repeatable_meta_box_save');
function dt_repeatable_meta_box_save($post_id)
{
	if (!isset($_POST['dt_repeatable_meta_box_nonce']) || !wp_verify_nonce($_POST['dt_repeatable_meta_box_nonce'], 'dt_repeatable_meta_box_nonce')) return;
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
	if (!current_user_can('edit_post', $post_id)) return;
	$antiguo = get_post_meta($post_id, 'repeatable_fields', true);
	$nuevo = array();
	$options = dt_get_sample_options();
	$names = $_POST['name'];
	$selects = $_POST['select'];
	$idiomas = $_POST['idioma'];
	$urls = $_POST['url'];
	$count = count($names);
	for ($i = 0; $i < $count; $i++) {
		if ($names[$i] != ''):
			$nuevo[$i]['name'] = stripslashes(strip_tags($names[$i]));
			if (in_array($selects[$i], $options)) $nuevo[$i]['select'] = $selects[$i];
			else $nuevo[$i]['select'] = '';
			if (in_array($idiomas[$i], $idiomas)) $nuevo[$i]['idioma'] = $idiomas[$i];
			else $nuevo[$i]['idioma'] = '';
			if ($urls[$i] == 'http://') $nuevo[$i]['url'] = '';
			else $nuevo[$i]['url'] = stripslashes($urls[$i]);
		endif;
	}
	if (!empty($nuevo) && $nuevo != $antiguo) update_post_meta($post_id, 'repeatable_fields', $nuevo);
	elseif (empty($nuevo) && $antiguo) delete_post_meta($post_id, 'repeatable_fields', $antiguo);
}
