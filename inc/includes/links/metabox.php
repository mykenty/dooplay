<?php

function links_add_meta_box() {
	add_meta_box(
		'mt_metabox',
		__d('Links'),
		'links_html',
		'dt_links',
		'normal',
		'default'
	);
}
add_action('add_meta_boxes', 'links_add_meta_box');
function links_html( $post) { wp_nonce_field('_links_nonce', 'links_nonce'); ?>
<table class="options-table-responsive dt-options-table">
	<tbody>
		<tr id="links_type_box">
			<td class="label">
				<label><?php _d('Type'); ?></label>
			</td>
			<td class="field">
				<select name="links_type" id="links_type">
				<?php $tipo = array( __d('Download') , __d('Watch online') );
				foreach( $tipo as $val ) { ?>
					<option <?php echo (dt_get_meta('links_type') === $val ) ? 'selected' : '' ?>><?php echo $val; ?></option>
				<?php } ?>
				</select>
			</td>
		</tr>
		<tr id="links_url_box">
			<td class="label">
				<label><?php _d('URL Link'); ?></label>
			</td>
			<td class="field">
				<input class="regular-text" type="text" name="links_url" id="links_url" value="<?php echo dt_get_meta('links_url'); ?>">
			</td>
		</tr>
		<tr id="dt_postitle_box">
			<td class="label">
				<label><?php _d('Item title'); ?></label>
			</td>
			<td class="field">
				<input class="regular-text" type="text" name="dt_postitle" id="dt_postitle" value="<?php echo dt_get_meta('dt_postitle'); ?>">
			</td>
		</tr>
		<tr id="dt_string_box">
			<td class="label">
				<label><?php _d('Only Key'); ?></label>
			</td>
			<td class="field">
				<input class="regular-text" type="text" name="dt_string" id="dt_string" value="<?php echo dt_get_meta('dt_string'); ?>" disabled>
			</td>
		</tr>
		<tr id="dt_filesize_box">
			<td class="label">
				<label><?php _d('File size'); ?></label>
			</td>
			<td class="field">
				<input class="regular-text" type="text" name="dt_filesize" id="dt_filesize" value="<?php echo dt_get_meta('dt_filesize'); ?>">
			</td>
		</tr>
		<tr id="links_idioma_box">
			<td class="label">
				<label><?php _d('Language'); ?></label>
			</td>
			<td class="field">
				<select name="links_idioma" id="links_idioma">
				<?php
				$links_lang = get_option('dt_languages_post_link');
				if(!empty($links_lang)){ $val = explode(",", $links_lang); foreach( $val as $valor ){ ?>
					<option <?php  echo (dt_get_meta('links_idioma') === $valor ) ? 'selected' : '' ?>><?php echo $valor; ?></option>
				<?php }  } else { 
				$quality = array('Spanish','English','Portuguese','Italian','French','Turkish');
				foreach( $quality as $val ) { ?>
					<option <?php echo (dt_get_meta('links_idioma') === $val ) ? 'selected' : '' ?>><?php echo $val; ?></option>
				<?php }  } ?>
				</select>
			</td>
		</tr>
		<tr id="links_quality_box">
			<td class="label">
				<label><?php _d('Quality'); ?></label>
			</td>
			<td class="field">
				<select name="links_quality" id="links_quality">
				<?php
				$links_quality = get_option('dt_quality_post_link');
				if(!empty($links_quality)){ $val = explode(",", $links_quality); foreach( $val as $valor ){ ?>
					<option <?php  echo (dt_get_meta('links_quality') === $valor ) ? 'selected' : '' ?>><?php echo $valor; ?></option>
				<?php }  } else { 
				$quality = array('SD','HD','480p','720p','1080p');
				foreach( $quality as $val ) { ?>
					<option <?php echo (dt_get_meta('links_quality') === $val ) ? 'selected' : '' ?>><?php echo $val; ?></option>
				<?php }  } ?>
				</select>				
			</td>
		</tr>
	</tbody>
</table>
<?php }
function links_save( $post_id ) {
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['links_nonce'] ) || ! wp_verify_nonce( $_POST['links_nonce'], '_links_nonce') ) return;
	if ( ! current_user_can('edit_post', $post_id ) ) return;
	if ( isset( $_POST['dt_string'] ) )	update_post_meta( $post_id, 'dt_string',		esc_attr( $_POST['dt_string'] ) );
	if ( isset( $_POST['dt_postitle'] ) ) update_post_meta( $post_id, 'dt_postitle',	esc_attr( $_POST['dt_postitle'] ) );
	if ( isset( $_POST['dt_filesize'] ) ) update_post_meta( $post_id, 'dt_filesize',	esc_attr( $_POST['dt_filesize'] ) );
	if ( isset( $_POST['links_type'] ) )	update_post_meta( $post_id, 'links_type',		esc_attr( $_POST['links_type'] ) );
	if ( isset( $_POST['links_url'] ) )		update_post_meta( $post_id, 'links_url',		esc_attr( $_POST['links_url'] ) );
	if ( isset( $_POST['links_idioma'] ) )	update_post_meta( $post_id, 'links_idioma',		esc_attr( $_POST['links_idioma'] ) );
	if ( isset( $_POST['links_quality'] ) ) update_post_meta( $post_id, 'links_quality',	esc_attr( $_POST['links_quality'] ) );
}
add_action('save_post', 'links_save');
