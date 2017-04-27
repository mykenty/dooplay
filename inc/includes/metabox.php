<?php


function dt_post_add_meta_box() {
	add_meta_box(
		'mt_metabox',
		__d('Post meta'),
		'dt_post_html',
		'post',
		'normal',
		'high'
	);
}
add_action('add_meta_boxes', 'dt_post_add_meta_box');
function dt_post_html( $post) { wp_nonce_field('_dt_post_nonce', 'dt_post_nonce'); ?>
<table class="options-table-responsive dt-options-table">
	<tbody>
		<tr id="dt_desc_box">
			<td class="label">
				<label for="dt_post_desc"><?php _d('Short description'); ?></label>
			</td>
			<td class="field">
				<input type="text" name="dt_post_desc" id="dt_post_desc" value="<?php echo dt_get_meta('dt_post_desc'); ?>">
			</td>
		</tr>
		<tr id="dt_dviews_box">
			<td class="label">
				<label for="dt_views_count"><?php _d('Views'); ?></label>
			</td>
			<td class="field">
				<input class="extra-small-text" type="text" name="dt_views_count" id="dt_views_count" value="<?php echo dt_get_meta('dt_views_count'); ?>">
			</td>
		</tr>
	</tbody>
</table>

<?php }
function dt_post_save( $post_id ) {
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['dt_post_nonce'] ) || ! wp_verify_nonce( $_POST['dt_post_nonce'], '_dt_post_nonce') ) return;
	if ( ! current_user_can('edit_post', $post_id ) ) return;
/*  Guardar datos */
    if ( isset( $_POST['dt_views_count'] ) ) update_post_meta( $post_id, 'dt_views_count', esc_attr( $_POST['dt_views_count'] ) );
	if ( isset( $_POST['dt_post_desc'] ) ) update_post_meta( $post_id, 'dt_post_desc', esc_attr( $_POST['dt_post_desc'] ) );
}
add_action('save_post', 'dt_post_save'); 
