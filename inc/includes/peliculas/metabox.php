<?php

function info_movie_add_meta_box() {
	add_meta_box(
		'mt_metabox',
		__d('Movie Info'),
		'info_movie_html',
		'movies',
		'normal',
		'high'
	);
}
add_action('add_meta_boxes', 'info_movie_add_meta_box');
function info_movie_html( $post) {
wp_nonce_field('_info_movie_nonce', 'info_movie_nonce'); ?>
<table class="options-table-responsive dt-options-table">
	<tbody>
	<?php if(dttp == "valid") { ?>
	<tr id="ids_box">
		<td class="label">
			<label for="ids"><?php _d('Generate data'); ?></label>
			<p class="description"><?php _d('Generate data from <strong>imdb.com</strong>'); ?></p>
		</td>
		<td style="background: #f7f7f7" class="field">
			<input class="regular-text" type="text" name="ids" id="ids" placeholder="tt2911666" value="<?php echo dt_get_meta('ids'); ?>">
			<input type="button" class="button button-primary" name="Checkbx" value="<?php if(dt_get_meta('ids')){ _d('Update data'); } else { _d('Generate'); } ?>">
			<p class="description"><?php _d('E.g. http://www.imdb.com/title/<strong>tt2911666</strong>/'); ?></p>
			<p id="verificador" style="display:none"><a class="button button-secundary" id="comprovate"><?php _d('Check duplicate content'); ?></a><p>
		</td>
	</tr>
	<tr>
		<td colspan="2"><h3><?php _d('Images and trailer'); ?></h3></td>
	</tr>
	<?php } ?>
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
		<td colspan="2"><h3><?php _d('IMDb.com data'); ?></h3></td>
	</tr>
	<tr id="rating_imdb_box">
		<td class="label">
			<label for="imdbRating"><?php _d('Rating IMDb'); ?></label>
			<p class="description"><?php _d('Average / votes'); ?></p>
		</td>
		<td class="field">
			<input class="extra-small-text" type="text" name="imdbRating" id="imdbRating" value="<?php echo dt_get_meta('imdbRating'); ?>"> - 
			<input class="extra-small-text" type="text" name="imdbVotes" id="imdbVotes" value="<?php echo dt_get_meta('imdbVotes'); ?>">
		</td>
	</tr>
	<tr id="Rated_box">
		<td class="label">
			<label for="Rated"><?php _d('Rated'); ?></label>
		</td>
		<td class="field">
			<input class="regular-text" type="text" name="Rated" id="Rated" value="<?php echo dt_get_meta('Rated'); ?>">
		</td>
	</tr>
	<tr id="Country_box">
		<td class="label">
			<label for="Country"><?php _d('Country'); ?></label>
		</td>
		<td class="field">
			<input class="dt_conuntry regular-text" type="text" name="Country" id="Country" value="<?php echo dt_get_meta('Country'); ?>">
		</td>
	</tr>
	<tr>
		<td colspan="2"><h3><?php _d('Themoviedb.org data'); ?></h3></td>
	</tr>
	<tr id="original_title_box">
		<td class="label">
			<label for="idtmdb"><?php _d('ID TMDb'); ?></label>
		</td>
		<td class="field">
			<input class="regular-text" type="text" name="idtmdb" id="idtmdb" value="<?php echo dt_get_meta('idtmdb'); ?>">
		</td>
	</tr>
	<tr id="original_title_box">
		<td class="label">
			<label for="original_title"><?php _d('Original title'); ?></label>
		</td>
		<td class="field">
			<input class="regular-text" type="text" name="original_title" id="original_title" value="<?php echo dt_get_meta('original_title'); ?>">
		</td>
	</tr>
	<tr id="tagline_box">
		<td class="label">
			<label for="tagline"><?php _d('Tag line'); ?></label>
		</td>
		<td class="field">
			<input class="regular-text" type="text" name="tagline" id="tagline" value="<?php echo dt_get_meta('tagline'); ?>">
		</td>
	</tr>
	<tr id="release_date_box">
		<td class="label">
			<label for="release_date"><?php _d('Release Date'); ?></label>
		</td>
		<td class="field">
			<input class="small-text" type="date" name="release_date" id="release_date" value="<?php echo dt_get_meta('release_date'); ?>">
		</td>
	</tr>
	<tr id="rating_tmdb_box">
		<td class="label">
			<label for="vote_average"><?php _d('Rating TMDb'); ?></label>
			<p class="description"><?php _d('Average / votes'); ?></p>
		</td>
		<td class="field">
			<input class="extra-small-text" type="text" name="vote_average" id="vote_average" value="<?php echo dt_get_meta('vote_average'); ?>"> - 
			<input class="extra-small-text" type="text" name="vote_count" id="vote_count" value="<?php echo dt_get_meta('vote_count'); ?>">
		</td>
	</tr>
	<tr id="runtime_box">
		<td class="label">
			<label for="runtime"><?php _d('Runtime'); ?></label>
		</td>
		<td class="field">
			<input class="small-text" type="text" name="runtime" id="runtime" value="<?php echo dt_get_meta('runtime'); ?>">
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
	<tr id="dt_dir_box">
		<td class="label">
			<label for="dt_dir"><?php _d('Director'); ?></label>
		</td>
		<td class="field">
			<input type="text" name="dt_dir" id="dt_dir" value="<?php echo dt_get_meta('dt_dir'); ?>">
		</td>
	</tr>
	</tbody>
</table>


<?php if(dt_get_meta('dt_string')) { /* none */ } else { ?>
<input type="hidden" id="dt_string" name="dt_string" value="<?php echo dt_get_meta('dt_string'); ?>">
<?php } ?>


<?php if (has_post_thumbnail()): else: echo '<input type="hidden" id="url_image_upload" name="url_image_upload" value="">'; endif; ?>
<?php }
function info_movie_save( $post_id ) {
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['info_movie_nonce'] ) || ! wp_verify_nonce( $_POST['info_movie_nonce'], '_info_movie_nonce') ) return;
	if ( ! current_user_can('edit_post', $post_id ) ) return;
/*  Guardar datos */
    if ( isset( $_POST['ids'] ) ) update_post_meta( $post_id, 'ids', esc_attr( $_POST['ids'] ) );
	if ( isset( $_POST['dt_poster'] ) ) update_post_meta( $post_id, 'dt_poster', esc_attr( $_POST['dt_poster'] ) );
	if ( isset( $_POST['dt_backdrop'] ) ) update_post_meta( $post_id, 'dt_backdrop', esc_attr( $_POST['dt_backdrop'] ) );
	if ( isset( $_POST['imagenes'] ) ) update_post_meta( $post_id, 'imagenes', esc_attr( $_POST['imagenes'] ) );
	if ( isset( $_POST['youtube_id'] ) ) update_post_meta( $post_id, 'youtube_id', esc_attr( $_POST['youtube_id'] ) );
	if ( isset( $_POST['imdbRating'] ) ) update_post_meta( $post_id, 'imdbRating', esc_attr( $_POST['imdbRating'] ) );
	if ( isset( $_POST['imdbVotes'] ) ) update_post_meta( $post_id, 'imdbVotes', esc_attr( $_POST['imdbVotes'] ) );
	if ( isset( $_POST['original_title'] ) ) update_post_meta( $post_id, 'original_title', esc_attr( $_POST['original_title'] ) );
	if ( isset( $_POST['Rated'] ) ) update_post_meta( $post_id, 'Rated', esc_attr( $_POST['Rated'] ) );
	if ( isset( $_POST['release_date'] ) ) update_post_meta( $post_id, 'release_date', esc_attr( $_POST['release_date'] ) );
	if ( isset( $_POST['runtime'] ) ) update_post_meta( $post_id, 'runtime', esc_attr( $_POST['runtime'] ) );
	if ( isset( $_POST['Country'] ) ) update_post_meta( $post_id, 'Country', esc_attr( $_POST['Country'] ) );
	if ( isset( $_POST['vote_average'] ) ) update_post_meta( $post_id, 'vote_average', esc_attr( $_POST['vote_average'] ) );
	if ( isset( $_POST['vote_count'] ) ) update_post_meta( $post_id, 'vote_count', esc_attr( $_POST['vote_count'] ) );
	if ( isset( $_POST['tagline'] ) ) update_post_meta( $post_id, 'tagline', esc_attr( $_POST['tagline'] ) );
	if ( isset( $_POST['dt_string'] ) ) update_post_meta( $post_id, 'dt_string', esc_attr( $_POST['dt_string'] ) );
	if ( isset( $_POST['dt_cast'] ) ) update_post_meta( $post_id, 'dt_cast', esc_attr( $_POST['dt_cast'] ) );
	if ( isset( $_POST['dt_dir'] ) ) update_post_meta( $post_id, 'dt_dir', esc_attr( $_POST['dt_dir'] ) );
	if ( isset( $_POST['idtmdb'] ) ) update_post_meta( $post_id, 'idtmdb', esc_attr( $_POST['idtmdb'] ) );
	if (has_post_thumbnail()): else:  if($data = $_POST['url_image_upload']) {  dt_upload_image( $data,   $post_id ); } endif;
}
if(dttp == "valid") { 
	add_action('save_post', 'info_movie_save'); 
}
function custom_admin_js() {  global $post_type; if( $post_type == 'movies') { ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	// Generar datos
	$('input[name=Checkbx]').click(function() {
		var input = $('input[name=ids]').get(0).value;
		var url = "https://api.themoviedb.org/3/movie/";
		var agregar = "?append_to_response=images,trailers";
		var idioma = "&language=<?php echo get_option('dt_api_language','en'); ?>&include_image_language=<?php echo get_option('dt_api_language','en'); ?>,null";
		var apikey = "&api_key=<?php echo get_option('dt_api_key'); ?>";
		// Send Request
		$.getJSON(url + input + agregar + idioma + apikey, function(tmdbdata) {
			var valTit = "";
			var valPlo = "";
			var valImg = "";
			var valBac = "";
			var valupimg = "";
			$.each(tmdbdata, function(key, val) {
				$('input[name=' + key + ']').val(val);
				$('#message').remove();
				$('#postbox-container-2').prepend('<div id=\"message\" class=\"notice rebskt updated \"><p><?php if(dt_get_meta('ids')){ _d("The data have been updated, check please"); } else { _d("Data were completed, check please"); } ?></p></div>');
				$("#verificador").show();
				if (key == "title") {
					$('label#title-prompt-text').addClass('screen-reader-text');
					$('input[name=post_title]').val(val);
				}
				if (key == "id") {
					$('#dt_string').val('mov' + '<?php echo DT_STRING_LINK; ?>' + val);
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
							$('textarea#content').val(val);
						}
					}
				}
				if (key == "poster_path") {
					$('input[name="dt_poster"]').val(val);
				}
				if (key == "backdrop_path") {
					$('input[name="dt_backdrop"]').val(val);
				}
				if (key == "id") {
					$('input[name="idtmdb"]').val(val);
				}
				if (key == "release_date") {
					$('#new-tag-dtyear').val(val.slice(0, 4));
				}

				if(key == "poster_path"){
					valupimg+= "https://image.tmdb.org/t/p/w396"+val+"";
					$('#url_image_upload').val(valupimg);
					<?php if( get_option('dt_api_upload_poster') == 'true') { if (has_post_thumbnail()): else: ?>
					$('#postimagediv p').html("<ul><li><img class='dt_poster_preview' src='"+ valupimg +"'/> </li></ul>");
					<?php endif; } ?>
				}

				if(key == "production_countries"){
					var country = "";
					$.each(tmdbdata.production_countries, function(i, item) {
						country +=  item.iso_3166_1 + ". ";
					});
					$('.dt_conuntry').val(country);
				
				}
				<?php $api = get_option('dt_api_genres'); if ($api == "true") { ?>
				if (key == "genres") {
					var genr = "";
					$.each(tmdbdata.genres, function(i, item) {
						genr += "" + item.name + ", ";
						genr1 = item.name;
						$('input[name=newgenres]').val(genr1);
						$('#genres-add-submit').trigger('click');
						$('#genres-add-submit').prop("disabled", false);
						$('input[name=genres]').val("");
					});
					$('input[name=' + key + ']').val(genr);
				}
				<?php } ?>
				if (key == "trailers") {
					var tral = "";
					$.each(tmdbdata.trailers.youtube, function(i, item) {
						if(i>0) return false;
						tral += "[" + item.source + "]";
					});
					$('input[name="youtube_id"]').val(tral);
				}
				if (key == "images") {
					var imgt = "";
					$.each(tmdbdata.images.backdrops, function(i, item) {
						if(i>9) return false;
						imgt += item.file_path + "\n";
					});
					$('textarea[name="imagenes"]').val(imgt);
				}
				$.getJSON(url + input + "/credits?" + apikey, function(tmdbdata) {
					$.each(tmdbdata, function(key, val) {
						if (key == "cast") {
							var cstm = cstml = "";
							$.each(tmdbdata.cast, function(i, item) {
								if(i>9) return false;
								cstm += "[" + item.profile_path + ";" + item.name + "," + item.character + "]";
								cstml += "" + item.name + ", "; //
							});
							$('textarea[name="dt_cast"]').val(cstm);
							var valCast = "";
							$.each(tmdbdata.cast, function(i, item) {
								if(i>9) return false;
								valCast += "" + item.name + ", "; //
							});
							$('#new-tag-dtcast').val(valCast);
						} else {
							var crew_d = crew_dl = "";
							var crew_w = crew_wl = "";
							$.each(tmdbdata.crew, function(i, item) {
								if (item.department == "Directing") {
									crew_d += "[" + item.profile_path + ";" + item.name + "]";
									crew_dl += "" + item.name + ", "; //
								}
							});
							$('input[name=dt_dir]').val(crew_d);
							$('#new-tag-dtdirector').val(crew_dl);
						}
					});
				});
			});
		});
	});
	// API Dbmovies.org
	$('input[name=Checkbx]').click(function() {
		var coc = $('input[name=ids]').get(0).value;
		// Send Request
		$.getJSON("<?php echo imdbdata; ?>" + coc , function(data) {
			$.each(data, function(key, val) {
				$('input[name=' + key + ']').val(val);
			});
		});
	});
});
</script>
<?php 
} }
add_action('admin_footer', 'custom_admin_js');
