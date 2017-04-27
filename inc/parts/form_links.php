<div id="resultado_link_form"></div>
<div class="form_post_lik">
	<form id="dt_post_links" class="postio" enctype="application/json">
		<div class="table">
			<table data-repeater-list="data" class="post_table">
				<thead>
					<tr>
						<th><?php _d('Type'); ?></th>
						<th><?php _d('URL'); ?></th>
						<th><?php _d('Quality'); ?></th>
						<th><?php _d('Language'); ?></th>
						<th><?php _d('File size'); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody class="tbody">
					<tr data-repeater-item class="row first_tr">
						<td>
							<select name="tipo">
								<option><?php _d('Download'); ?></option>
								<option><?php _d('Watch online'); ?></option>
							</select>
						</td>
						<td>
							<input name="url" type="url" class="url" placeholder="http://">
						</td>
						<td>
							<select name="calidad">
							<?php $links_quality = get_option('dt_quality_post_link');
							if(!empty($links_quality)){ $val = explode(",", $links_quality); foreach( $val as $valor ){ 
							echo '<option value="'.$valor.'">'.$valor.'</option>'; 
							echo "\n";
							}  } else { 
							$quality = array('SD','HD','480p','720p','1080p');
							foreach( $quality as $val ) { ?>
							<option value="<?php echo $val; ?>"><?php echo $val; ?></option>
							<?php }  } ?>
							</select>
						</td>
						<td>
							<select name="idioma">
							<?php $links_lang = get_option('dt_languages_post_link');
							if(!empty($links_lang)){ $val = explode(",", $links_lang); foreach( $val as $valor ){
							echo '<option value="'.$valor.'">'.$valor.'</option>'; 
							echo "\n";
							}  } else { 
							$quality = array('Spanish','English','Portuguese','Italian','French','Turkish');
							foreach( $quality as $val ) { ?>
							<option value="<?php echo $val; ?>"><?php echo $val; ?></option>
							<?php }  } ?>
							</select>
						</td>
						<td>
							<input name="size" type="text" class="size">
						</td>
						<td>
							<a data-repeater-delete class="remove_row">X</a>
						</td>
					</tr>

				</tbody>
			</table>
		</div>
		<div class="control">
			<div class="left"><a data-repeater-create id="add_row" class="add_row">+ <?php _d('Add row'); ?></a></div>
			<div class="right"><input type="submit" value="<?php _d('Send link(s)'); ?>"></div>
		</div>
		<?php if($id = dt_get_meta('dt_string')) { ?>
		<input type="hidden" name="idpost" value="<?php the_id(); ?>">
		<input type="hidden" name="titlepost" value="<?php the_title(); ?>">
		<input type="hidden" name="dt_string" value="<?php echo $id; ?>">
		<?php } wp_nonce_field('send-links','send-links-nonce') ?>
	</form>
</div>
<script type='text/javascript'>
	jQuery(document).ready(function($) {
		// Repeat input
		'use strict';
		$('.postio').repeater({
			defaultValues: {
				'tipo': dtAjax.ltipe
			},
			show: function () {
				$(this).fadeIn("fast");
			},
			hide: function (deleteElement) {
				$(this).fadeOut("fast", function() {
					$(this).slideUp(deleteElement);
				})
			},
			ready: function (setIndexes) {
			}
		})
		// Send data
		$('#dt_post_links').submit(function(){
			$('#resultado_link_form').html('<div class="msg"><i class="icons-spinner9 animate-loader"></i>'+ dtAjax.sending + '</div>');
			$('.form_post_lik').hide('fast');
			$.ajax({
				type:'POST',
				url:dtAjax.url + '?action=dt_post_links',
				data:$(this).serialize()
			})
			.done(function(data){
				$('#resultado_link_form').html('<p>'+ data + '</p>')	
			})
			return false;
		})
	});
</script>