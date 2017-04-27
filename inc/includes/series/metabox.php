<?php 


function series_add_meta_box() { 
	add_meta_box('mt_metabox', __d('TVShows Info'),'series_html','tvshows','normal','high'); 
}
add_action('add_meta_boxes', 'series_add_meta_box'); function series_html( $post) { wp_nonce_field('_series_nonce', 'series_nonce'); ?>
<table class="options-table-responsive dt-options-table">
	<tbody>
		<?php if(dttp == "valid") { ?>
		<tr id="ids_box">
			<td class="label">
				<label for="ids"><?php _d('Generate data'); ?></label>
				<p class="description"><?php _d('Generate data from <strong>themoviedb.org</strong>'); ?></p>
			</td>
			<td style="background: #f7f7f7" class="field">
				<input class="regular-text" type="text" name="ids" placeholder="1402" id="ids" value="<?php echo dt_get_meta('ids'); ?>">
				<input type="button" class="button button-primary" name="generartv" value="<?php if(dt_get_meta('ids')){ _d('Update data'); } else { _d('Generate'); } ?>">
				<p class="description"><?php _d('E.g. https://www.themoviedb.org/tv/<strong>1402</strong>-the-walking-dead'); ?></p>
				<p id="verificador" style="display:none"><a class="button button-secundary" id="comprovate"><?php _d('Check duplicate content'); ?></a><p>
			</td>
		</tr>
		<tr id="dt_episodes_box">
			<td class="label">
				<label><?php _d('Seasons control'); ?></label>
			</td>
			<td class="field">
				<p><input type="checkbox" name="clgnrt" id="clgnrt" value="1" <?php echo ( dt_get_meta('clgnrt') === '1') ? 'checked' : ''; ?>> <?php _d('I have generated seasons or I will manually'); ?></p>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="2"><h3><?php _d('Images and trailer'); ?></h3></td>
		</tr>
		<tr id="dt_poster_box">
			<td class="label">
				<label for="dt_poster"><?php _d('Poster'); ?></label>
				<p class="description"><?php _d('Add url image'); ?></p>
			</td>
			<td class="field">
				<input class="regular-text" type="text" name="dt_poster" id="dt_poster" value="<?php echo dt_get_meta('dt_poster'); ?>">
				<input class="up_images_poster button-secondary" type="button" value="<?php _d('Upload'); ?>" />
			</td>
		</tr>
		<tr id="dt_backdrop_box">
			<td class="label">
				<label for="dt_backdrop"><?php _d('Main Backdrop'); ?></label>
				<p class="description"><?php _d('Add url image'); ?></p>
			</td>
			<td class="field">
				<input class="regular-text" type="text" name="dt_backdrop" id="dt_backdrop" value="<?php echo dt_get_meta('dt_backdrop'); ?>">
				<input class="up_images_backdrop button-secondary" type="button" value="<?php _d('Upload'); ?>" />
			</td>
		</tr>
		<tr id="imagenes_box">
			<td class="label">
				<label for="imagenes"><?php _d('Backdrops'); ?></label>
				<p class="description"><?php _d('Place each image url below another'); ?></p>
			</td>
			<td class="field">
				<textarea name="imagenes" id="imagenes" rows="5"><?php echo dt_get_meta('imagenes'); ?></textarea>
				<input class="up_images_images button-secondary" type="button" value="<?php _d('Upload'); ?>" />
			</td>
		</tr>
		<tr id="youtube_id_box">
			<td class="label">
				<label for="youtube_id"><?php _d('Video trailer'); ?></label>
				<p class="description"><?php _d('Add id Youtube video'); ?></p>
			</td>
			<td class="field">
				<input class="small-text" type="text" name="youtube_id" id="youtube_id" value="<?php echo dt_get_meta('youtube_id'); ?>">
				<p class="description"><?php _d('[id_video_youtube]'); ?></p>
			</td>
		</tr>
		<tr>
			<td colspan="2"><h3><?php _d('More data'); ?></h3></td>
		</tr>
		<tr id="original_name_box">
			<td class="label">
				<label for="original_name"><?php _d('Original Name'); ?></label>
			</td>
			<td class="field">
				<input class="regular-text" type="text" name="original_name" id="original_name" value="<?php echo dt_get_meta('original_name'); ?>">
			</td>
		</tr>
		<tr id="first_air_date_box">
			<td class="label">
				<label for="first_air_date"><?php _d('Firt air date'); ?></label>
			</td>
			<td class="field">
				<input class="small-text" type="date" name="first_air_date" id="first_air_date" value="<?php echo dt_get_meta('first_air_date'); ?>">
			</td>
		</tr>
		<tr id="last_air_date_box">
			<td class="label">
				<label for="last_air_date"><?php _d('Last air date'); ?></label>
			</td>
			<td class="field">
				<input class="small-text" type="date" name="last_air_date" id="last_air_date" value="<?php echo dt_get_meta('last_air_date'); ?>">
			</td>
		</tr>
		<tr id="elements_box">
			<td class="label">
				<label for="number_of_seasons"><?php _d('Content total posted'); ?></label>
				<p class="description"><?php _d('Seasons / Episodes'); ?></p>
			</td>
			<td class="field">
				<input class="extra-small-text" type="text" name="number_of_seasons" id="number_of_seasons" value="<?php echo dt_get_meta('number_of_seasons'); ?>"> - 
				<input class="extra-small-text" type="text" name="number_of_episodes" id="number_of_episodes" value="<?php echo dt_get_meta('number_of_episodes'); ?>">
			</td>
		</tr>
		<tr id="rating_box">
			<td class="label">
				<label for="imdbRating"><?php _d('Rating TMDb'); ?></label>
				<p class="description"><?php _d('Average / votes'); ?></p>
			</td>
			<td class="field">
				<input class="extra-small-text" type="text" name="imdbRating" id="imdbRating" value="<?php echo dt_get_meta('imdbRating'); ?>"> - 
				<input class="extra-small-text" type="text" name="imdbVotes" id="imdbVotes" value="<?php echo dt_get_meta('imdbVotes'); ?>">
			</td>
		</tr>
		<tr id="status_box">
			<td class="label">
				<label for="status"><?php _d('Status'); ?></label>
			</td>
			<td class="field">
				<input class="regular-text" type="text" name="status" id="status" value="<?php echo dt_get_meta('status'); ?>">
			</td>
		</tr>
		<tr id="runtime_box">
			<td class="label">
				<label for="episode_run_time"><?php _d('Episode runtime'); ?></label>
			</td>
			<td class="field">
				<input class="regular-text" type="text" name="episode_run_time" id="episode_run_time" value="<?php echo dt_get_meta('episode_run_time'); ?>">
			</td>
		</tr>
		<tr id="dt_cast_box">
			<td class="label">
				<label for="dt_cast"><?php _d('Cast'); ?></label>
			</td>
			<td class="field">
				<textarea rows="5" name="dt_cast" id="dt_cast"><?php echo dt_get_meta('dt_cast'); ?></textarea>
			</td>
		</tr>
		<tr id="dt_creator_box">
			<td class="label">
				<label for="dt_creator"><?php _d('Creator'); ?></label>
			</td>
			<td class="field">
				<input type="text" name="dt_creator" id="dt_creator" value="<?php echo dt_get_meta('dt_creator'); ?>">
			</td>
		</tr>
	</tbody>
</table>
<?php if (has_post_thumbnail()): else: echo '<input type="hidden" id="url_image_upload" name="url_image_upload" value="">'; endif; ?>
<?php  }
function series_save( $post_id ) {
if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
if ( ! isset( $_POST['series_nonce'] ) || ! wp_verify_nonce( $_POST['series_nonce'], '_series_nonce') ) return;
if ( ! current_user_can('edit_post', $post_id ) ) return;
if ( isset( $_POST['ids'] ) ) update_post_meta( $post_id, 'ids', esc_attr( $_POST['ids'] ) );
if ( isset( $_POST['dt_poster'] ) ) update_post_meta( $post_id, 'dt_poster', esc_attr( $_POST['dt_poster'] ) );
if ( isset( $_POST['dt_backdrop'] ) ) update_post_meta( $post_id, 'dt_backdrop', esc_attr( $_POST['dt_backdrop'] ) );
if ( isset( $_POST['imagenes'] ) ) update_post_meta( $post_id, 'imagenes', esc_attr( $_POST['imagenes'] ) );
if ( isset( $_POST['youtube_id'] ) ) update_post_meta( $post_id, 'youtube_id', esc_attr( $_POST['youtube_id'] ) );
if ( isset( $_POST['number_of_episodes'] ) ) update_post_meta( $post_id, 'number_of_episodes', esc_attr( $_POST['number_of_episodes'] ) );
if ( isset( $_POST['number_of_seasons'] ) ) update_post_meta( $post_id, 'number_of_seasons', esc_attr( $_POST['number_of_seasons'] ) );
if ( isset( $_POST['original_name'] ) ) update_post_meta( $post_id, 'original_name', esc_attr( $_POST['original_name'] ) );
if ( isset( $_POST['status'] ) ) update_post_meta( $post_id, 'status', esc_attr( $_POST['status'] ) );
if ( isset( $_POST['imdbRating'] ) ) update_post_meta( $post_id, 'imdbRating', esc_attr( $_POST['imdbRating'] ) );
if ( isset( $_POST['imdbVotes'] ) ) update_post_meta( $post_id, 'imdbVotes', esc_attr( $_POST['imdbVotes'] ) );
if ( isset( $_POST['episode_run_time'] ) ) update_post_meta( $post_id, 'episode_run_time', esc_attr( $_POST['episode_run_time'] ) );
if ( isset( $_POST['first_air_date'] ) ) update_post_meta( $post_id, 'first_air_date', esc_attr( $_POST['first_air_date'] ) );
if ( isset( $_POST['last_air_date'] ) ) update_post_meta( $post_id, 'last_air_date', esc_attr( $_POST['last_air_date'] ) );
if ( isset( $_POST['dt_cast'] ) ) update_post_meta( $post_id, 'dt_cast', esc_attr( $_POST['dt_cast'] ) );
if ( isset( $_POST['dt_creator'] ) ) update_post_meta( $post_id, 'dt_creator', esc_attr( $_POST['dt_creator'] ) );
if ( isset( $_POST['clgnrt'] ) ) update_post_meta( $post_id, 'clgnrt', esc_attr( $_POST['clgnrt'] ) ); else update_post_meta( $post_id, 'clgnrt', null );
if (has_post_thumbnail()): else:  if($data = $_POST['url_image_upload']) {  dt_upload_image( $data,   $post_id ); } endif;
}
if(dttp == "valid") { 
	add_action('save_post', 'series_save');
}
function custom_admin_js2() { 
global $post_type; if( $post_type == 'tvshows') {	?>
<script>
// Generar datos
jQuery('input[name=generartv]').click(function() {
    var input = jQuery('input[name=ids]').get(0).value;
    var url = "https://api.themoviedb.org/3/tv/";
    var agregar = "?append_to_response=images,trailers";
    var idioma = "&language=<?php echo get_option('dt_api_language','en'); ?>&include_image_language=<?php echo get_option('dt_api_language','en'); ?>,null";
    var apikey = "&api_key=<?php echo get_option('dt_api_key'); ?>";
    // Send Request
    jQuery.getJSON(url + input + agregar + idioma + apikey, function(tmdbdata) {
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
            if (key == "name") {
				jQuery('label#title-prompt-text').addClass('screen-reader-text');
				jQuery('input[name=post_title]').val(val);
            }
            if (key == "vote_count") {
                jQuery('#imdbVotes').val(val);
            }
            if (key == "vote_average") {
                jQuery('#imdbRating').val(val);
            }
            if (key == "overview") {
				if (typeof tinymce != "undefined") {
					var editor = tinymce.get('content');
					if (editor && editor instanceof tinymce.Editor) {
						editor.setContent(val);
						editor.save({
							no_events: true
						});
					} else {
						jQuery('textarea#content').val(val);
					}
				}
            }
            if (key == "poster_path") {
                valImg += val + "";
            }
            if (key == "backdrop_path") {
                valBac += val + "";
            }
			if(key == "poster_path"){
				valupimg+= "https://image.tmdb.org/t/p/w396"+val+"";
			}
            <?php $api = get_option('dt_api_genres'); if ($api == "true") { ?>
            if (key == "genres") {
                var genr = "";
                jQuery.each(tmdbdata.genres, function(i, item) {
                    genr += "" + item.name + ", ";
                    genr1 = item.name;
                    jQuery('input[name=newgenres]').val(genr1);
                    jQuery('#genres-add-submit').trigger('click');
                    jQuery('#genres-add-submit').prop("disabled", false);
                    jQuery('input[name=genres]').val("");
                });
                jQuery('input[name=' + key + ']').val(genr);
            }
            <?php } ?>
            if (key == "images") {
                var imgt = "";
                jQuery.each(tmdbdata.images.backdrops, function(i, item) {
					if(i>9) return false;
                    imgt += item.file_path + "\n";
                });
                jQuery('textarea[name="imagenes"]').val(imgt);
            }
            if (key == "first_air_date") {
                jQuery('#new-tag-dtyear').val(val.slice(0, 4));
            }
            if (key == "created_by") {
                var crea = "";
                var creai = "";
                jQuery.each(tmdbdata.created_by, function(i, item) {
                    crea += item.name + ",";
                    creai += "[" + item.profile_path + ";" + item.name + "]";
                });
                jQuery('#new-tag-dtcreator').val(crea);
                jQuery('#dt_creator').val(creai);
            }
            if (key == "production_companies") {
                var pro = "";
                jQuery.each(tmdbdata.production_companies, function(i, item) {
                    pro += item.name + ",";
                });
                jQuery('#new-tag-dtstudio').val(pro);
            }
            if (key == "networks") {
                var net = "";
                jQuery.each(tmdbdata.networks, function(i, item) {
                    net += item.name + ",";
                });
                jQuery('#new-tag-dtnetworks').val(net);
            }
            jQuery.getJSON(url + input + "/credits?" + apikey, function(tmdbdata) {
                jQuery.each(tmdbdata, function(key, val) {
                    if (key == "cast") {
                        var valCast = "";
                        var valdert = "";
                        jQuery.each(tmdbdata.cast, function(i, item) {
							if(i>9) return false;
                            valCast += "" + item.name + ", ";
                            valdert += "[" + item.profile_path + ";" + item.name + "," + item.character + "]";
                        });
                        jQuery('#new-tag-dtcast').val(valCast);
                        jQuery('#dt_cast').val(valdert);
                    }
                });

                jQuery.getJSON(url + input + "/videos?" + apikey, function(tmdbdata) {
                    jQuery.each(tmdbdata, function(key, val) {
                        var youtube = "";
                        jQuery.each(tmdbdata.results, function(i, item) {
							if(i>0) return false;
                            youtube += "[" + item.key + "]";
                        });
                        jQuery('input[name="youtube_id"]').val(youtube);
                    });
                });
            });
        });
        jQuery('input[name="dt_poster"]').val(valImg);
        jQuery('input[name="dt_backdrop"]').val(valBac);
		jQuery('#url_image_upload').val(valupimg);
		<?php if( get_option('dt_api_upload_poster') == 'true') { if (has_post_thumbnail()): else: ?>
		jQuery('#postimagediv p').html("<ul><li><img class='dt_poster_preview' src='"+ valupimg +"'/> </li></ul>");
		<?php endif; } ?>
    });
});
</script>
<script>
jQuery(document).ready(function() {
    jQuery(".dtload").click(function() {
        var o = jQuery(this).attr("id");
        1 == o ? (jQuery(".dtloadpage").hide(), jQuery(this).attr("id", "0")) : (jQuery(".dtloadpage").show(), jQuery(this).attr("id", "1"))
    }), jQuery(".dtloadpage").mouseup(function() {
        return !1
    }), jQuery(".dtload").mouseup(function() {
        return !1
    }), jQuery(document).mouseup(function() {
        jQuery(".dtloadpage").hide(), jQuery(".dtload").attr("id", "")
    })
})
</script>
<div class="dtloadpage">
	<div class="dtloadbox">
		<img src="<?php echo get_template_directory_uri().'/assets/img/'; ?>admin_load.gif">
		<span><?php _d('Generating seasons'); ?></span>
		<p><?php _d('not close this page to complete the upload'); ?></p>
	</div>
</div>

<?php 
  } }
add_action('admin_footer', 'custom_admin_js2');
function mostrar_trailer_tv($id) {
	if (!empty($id)) { 
		$val = str_replace(
			array("[","]",),
			array('<div class="youtube_id_tv"><'. $fix_frame .'iframe width="600" height="450" src="//www.youtube.com/embed/','" frameborder="0" allowfullscreen></iframe></div>',),$id);
		echo $val;
		} 
}
