<?php


function episodios_add_meta_box() {
	add_meta_box(
		'mt_metabox',
		__d('Episodes'),
		'episodios_html',
		'episodes',
		'normal',
		'high'
	);
}
add_action('add_meta_boxes', 'episodios_add_meta_box'); function episodios_html( $post) { wp_nonce_field('_episodios_nonce', 'episodios_nonce'); ?>
<table class="options-table-responsive dt-options-table">
	<tbody>
		<?php if(dttp == "valid") { ?>
		<tr id="ids_box">
			<td class="label">
				<label><?php _d('Generate data'); ?></label>
				<p class="description"><?php _d('Generate data from <strong>themoviedb.org</strong>'); ?></p>
			</td>
			<td style="background: #f7f7f7" class="field">
				<input class="extra-small-text" placeholder="1402" type="text" name="ids" id="ids" value="<?php echo dt_get_meta('ids'); ?>">
				<input class="extra-small-text" placeholder="1" type="text" name="temporada" id="temporada" value="<?php echo dt_get_meta('temporada'); ?>">
				<input class="extra-small-text" placeholder="2" type="text" name="episodio" id="episodio" value="<?php echo dt_get_meta('episodio'); ?>">
				<input type="button" class="button button-primary" name="generarepis" value="<?php if(dt_get_meta('ids')){ _d('Update data'); } else { _d('Generate'); } ?>">
				<p class="description"><?php _d('E.g. https://www.themoviedb.org/tv/<strong>1402</strong>-the-walking-dead/season/<strong>1</strong>/episode/<strong>2</strong>'); ?></p>
				<p id="verificador" style="display:none"><a class="button button-secundary" id="comprovate"><?php _d('Check duplicate content'); ?></a><p>
			</td>
		</tr>
		<?php } ?>
		<tr id="episode_name_box">
			<td class="label">
				<label><?php _d('Episode title'); ?></label>
			</td>
			<td class="field">
				<input class="regular-text" type="text" name="episode_name" id="episode_name" value="<?php echo dt_get_meta('episode_name'); ?>">
			</td>
		</tr>
		<tr id="serie_name_box">
			<td class="label">
				<label><?php _d('Serie name'); ?></label>
			</td>
			<td class="field">
				<input class="regular-text" type="text" name="serie" id="serie" value="<?php echo dt_get_meta('serie'); ?>">
			</td>
		</tr>
		<tr id="dt_poster_box">
			<td class="label">
				<label><?php _d('Poster'); ?></label>
				<p class="description"><?php _d('Add url image'); ?></p>
			</td>
			<td class="field">
				<input class="regular-text" type="text" name="dt_poster" id="dt_poster" value="<?php echo dt_get_meta('dt_poster'); ?>">
				<input class="up_images_poster button-secondary" type="button" value="<?php _d('Upload'); ?>" />
			</td>
		</tr>
		<tr id="dt_backdrop_box">
			<td class="label">
				<label><?php _d('Main Backdrop'); ?></label>
				<p class="description"><?php _d('Add url image'); ?></p>
			</td>
			<td class="field">
				<input class="regular-text" type="text" name="dt_backdrop" id="dt_backdrop" value="<?php echo dt_get_meta('dt_backdrop'); ?>">
				<input class="up_images_backdrop button-secondary" type="button" value="<?php _d('Upload'); ?>" />
			</td>
		</tr>
		<tr id="imagenes_box">
			<td class="label">
				<label><?php _d('Backdrops'); ?></label>
				<p class="description"><?php _d('Place each image url below another'); ?></p>
			</td>
			<td class="field">
				<textarea name="imagenes" id="imagenes" rows="5"><?php echo dt_get_meta('imagenes'); ?></textarea>
				<input class="up_images_images button-secondary" type="button" value="<?php _d('Upload'); ?>" />
			</td>
		</tr>
		<tr id="air_date_box">
			<td class="label">
				<label><?php _d('Air date'); ?></label>
			</td>
			<td class="field">
				<input class="small-text" type="date" name="air_date" id="air_date" value="<?php echo dt_get_meta('air_date'); ?>" required>
			</td>
		</tr>
	</tbody>
</table>
<?php if(dt_get_meta('dt_string')) { /* none */ } else { ?>
<input type="hidden" id="dt_string" name="dt_string" value="<?php echo dt_get_meta('dt_string'); ?>">
<?php } ?>

<?php if (has_post_thumbnail()): else: echo '<input type="hidden" id="url_image_upload" name="url_image_upload" value="">'; endif; ?>
<?php }
function episodios_save( $post_id ) {
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['episodios_nonce'] ) || ! wp_verify_nonce( $_POST['episodios_nonce'], '_episodios_nonce') ) return;
	if ( ! current_user_can('edit_post', $post_id ) ) return;
	if ( isset( $_POST['ids'] ) ) update_post_meta( $post_id, 'ids', esc_attr( $_POST['ids'] ) );
	if ( isset( $_POST['temporada'] ) ) update_post_meta( $post_id, 'temporada', esc_attr( $_POST['temporada'] ) );
	if ( isset( $_POST['episodio'] ) ) update_post_meta( $post_id, 'episodio', esc_attr( $_POST['episodio'] ) );
	if ( isset( $_POST['air_date'] ) ) update_post_meta( $post_id, 'air_date', esc_attr( $_POST['air_date'] ) );
	if ( isset( $_POST['episode_name'] ) ) update_post_meta( $post_id, 'episode_name', esc_attr( $_POST['episode_name'] ) );
	if ( isset( $_POST['dt_poster'] ) ) update_post_meta( $post_id, 'dt_poster', esc_attr( $_POST['dt_poster'] ) );
	if ( isset( $_POST['dt_backdrop'] ) ) update_post_meta( $post_id, 'dt_backdrop', esc_attr( $_POST['dt_backdrop'] ) );
	if ( isset( $_POST['imagenes'] ) ) update_post_meta( $post_id, 'imagenes', esc_attr( $_POST['imagenes'] ) );
	if ( isset( $_POST['serie'] ) ) update_post_meta( $post_id, 'serie', esc_attr( $_POST['serie'] ) );
	if ( isset( $_POST['dt_string'] ) ) update_post_meta( $post_id, 'dt_string', esc_attr( $_POST['dt_string'] ) );
	if (has_post_thumbnail()): else:  if($data = $_POST['url_image_upload']) {  dt_upload_image( $data,   $post_id ); } endif;
}
if(dttp == "valid") { 
	add_action('save_post', 'episodios_save');
}
function custom_admin_js3() { global $post_type; if( $post_type == 'episodes') { ?>
<script>
jQuery('input[name=generarepis]').click(function() {
    var input = jQuery('input[name=ids]').get(0).value;
    var temp =	jQuery('input[name=temporada]').get(0).value;
    var epis =	jQuery('input[name=episodio]').get(0).value;
    var imgplus = "?append_to_response=images";
    var adde = '/season/' + temp + '/episode/' + epis + imgplus;
    var dtms = '/season/' + temp;
    var url = "https://api.themoviedb.org/3/tv/";
    var idioma = "&language=<?php echo get_option('dt_api_language','en'); ?>&include_image_language=<?php echo get_option('dt_api_language','en'); ?>,null";
    var apikey = "&api_key=<?php echo get_option('dt_api_key'); ?>";
    // Send Request
    jQuery.getJSON(url + input + adde + idioma + apikey, function(tmdbdata) {
        var valPlo = "";
        var valImg = "";
        var valBac = "";
		var valupimg = "";
        jQuery.each(tmdbdata, function(key, val) {
            jQuery('input[name=' + key + ']').val(val);
			<?php if(dt_get_meta('ids')){ ?>
			jQuery('#message').remove();
            jQuery('#postbox-container-2').prepend('<div id=\"message\" class=\"notice rebskt updated \"><p><?php _d("The data have been updated, check please"); ?></p></div>');
			<?php } else { ?>
			jQuery('#message').remove();
            jQuery('#postbox-container-2').prepend('<div id=\"message\" class=\"notice rebskt updated \"><p><?php _d("Data were completed, check please"); ?></p></div>');
			<?php } ?>
			jQuery("#verificador").show();
            if (key == "vote_count") {
                jQuery('#serie_vote_count').val(val);
            }
            if (key == "id") {
                jQuery('#dt_string').val('tv' + '<?php echo DT_STRING_LINK; ?>' + val);
            }
			if (key == "name") {
                jQuery('#episode_name').val(val);
            }
            if (key == "vote_average") {
                jQuery('#serie_vote_average').val(val);
            }
            if (key == "overview") {
				// si es editor visual
                if (typeof tinymce != "undefined") {
					var editor = tinymce.get('content');
					if (editor && editor instanceof tinymce.Editor) {
						editor.setContent(val);
						editor.save({
							no_events: true
						});
					} else {
						// si no es editor visual
						jQuery('textarea#content').val(val);
					}
				}
            }
            if (key == "still_path") {
                valImg += val + "";
            }
			if(key == "still_path"){
				valupimg+= "https://image.tmdb.org/t/p/w396"+val+"";
				jQuery('#url_image_upload').val(valupimg);
				<?php if( get_option('dt_api_upload_poster') == 'true') { if (has_post_thumbnail()): else: ?>
				jQuery('#postimagediv p').html("<ul><li><img src='"+ valupimg +"'/> </li></ul>");
				<?php endif; } ?>
			}
            if (key == "images") {
                var imgt = "";
                jQuery.each(tmdbdata.images.stills, function(i, item) {
					if(i>9) return false;
                    imgt += item.file_path + "\n";
                });
                jQuery('textarea[name="imagenes"]').val(imgt);
            }
            jQuery.getJSON(url + input + "?" + idioma + apikey, function(tmdbdata) {
                jQuery.each(tmdbdata, function(key, item) {
                    if (key == "name") {
                        jQuery('#serie').val(item);
						jQuery('label#title-prompt-text').addClass('screen-reader-text');
						jQuery('input[name=post_title]').val(item + ": " + "<?php echo eseas; ?>" + temp + "<?php echo esepart; ?>" + "<?php echo eepisod; ?>" + epis);
                    }
                });
            });
            jQuery.getJSON(url + input + dtms + "?" + idioma + apikey, function(tmdbdata) {
                jQuery.each(tmdbdata, function(key, item) {

                    if (key == "poster_path") {
                        jQuery('#dt_poster').val(item);
                    }
                });
            });
        });
        jQuery('#dt_backdrop').val(valImg);
    });
});
</script>
<?php 
  } }
add_action('admin_footer', 'custom_admin_js3');