<?php

function dt_main_ajax() {
	if ( is_singular() ) {
		wp_enqueue_script('dt_main_ajax',  DT_DIR_URI .'/assets/js/ajax.js', array('jquery'), DT_VERSION, false );
		wp_localize_script('dt_main_ajax', 'dtAjax', array(
			'url'		=>	admin_url('admin-ajax.php', 'relative'),
			'send'		=> __d('Data send..'),
			'updating'	=> __d('Updating data..'),
			'error'		=> __d('Error'),
			'pending'	=> __d('Pending review'),
			'ltipe'		=> __d('Download'),
			'sending'	=> __d('Sending data'),
			'enabled'	=> __d('Enable'),
			'disabled'	=> __d('Disable'),
			'trash'		=> __d('Delete'),
			'lshared'	=> __d('Links Shared'),
			'ladmin'	=> __d('Manage pending links'),
			'sendingrep'=> __d('Please wait, sending data..')
		));
	}
	if ( is_author() ) {
		wp_enqueue_script('dt_main_ajax',  DT_DIR_URI .'/assets/js/ajax.js', array('jquery'), DT_VERSION, false );
		wp_localize_script('dt_main_ajax', 'dtAjax', array(
			'url'		=>	admin_url('admin-ajax.php', 'relative'),
		));
	}
}
add_action('wp_enqueue_scripts', 'dt_main_ajax');

/* POST Links function
-------------------------------------------------------------------------------
*/
function dt_post_links() {
	$nonce = $_POST['send-links-nonce'];
	if( isset( $nonce ) and wp_verify_nonce($nonce, 'send-links') ) {
		if(is_user_logged_in()) {
			// User levels
			if(current_user_can('administrator')) {
				$status = 'publish'; // Admin's
			}
			elseif(current_user_can('editor')) {
				$status = 'publish'; // Editor's
			}
			elseif(current_user_can('author')) {
				$status = 'publish'; // Author's
			}
			elseif(current_user_can('contributor')) {
				$status = 'publish'; // Contributor's
			}
			elseif(current_user_can('subscriber')) {
				$status = 'pending'; // Regular user's
			}
			else {
				$status = 'pending'; // No role
			}
			// _POST Form..
			$data	 = $_POST['data'];
			$title	 = dt_clear($_POST['titlepost']);
			$postid	 = dt_clear($_POST['idpost']);
			$string	 = dt_clear($_POST['dt_string']);
			$count	 = count($data);
			$userid  = get_current_user_id();
			for ( $n = 0; $n < $count; $n++ ) {
				// Serialized data..
				$tipo		= dt_clear($data[$n]['tipo']);
				$url		= dt_clear($data[$n]['url']);
				$idioma		= dt_clear($data[$n]['idioma']);
				$calidad	= dt_clear($data[$n]['calidad']);
				$size		= dt_clear($data[$n]['size']);
				if( $url) {
					// insertar enlace
					$dt_link = array(
						'post_title'	=> dt_clear($string),
						'post_status'	=> $status,
						'post_type'		=> 'dt_links',
						'post_date'     => date('Y-m-d H:i:s'),
						'post_date_gmt' => date('Y-m-d H:i:s'),
						'post_author'	=> get_current_user_id(),
					);
					$post_id = wp_insert_post($dt_link);
					// Insert meta data..
					add_post_meta( $post_id, "links_type", ($tipo) , true);
					add_post_meta( $post_id, "links_url", ($url) , true);
					add_post_meta( $post_id, "dt_string", ($string) , true);
					add_post_meta( $post_id, "links_idioma", ($idioma) , true);
					add_post_meta( $post_id, "links_quality", ($calidad) , true);
					add_post_meta( $post_id, "dt_postid", ($postid) , true);
					add_post_meta( $post_id, "dt_postitle", ($title) , true);
					add_post_meta( $post_id, "dt_filesize", ($size) , true);
					// fin de proceso!
				}
			}
			if($status == 'pending') {
				$to = get_option('admin_email');
				$subject = __d('New link added'). ' ('. $title .')';
				$message = '
					<p>'. __d('There are new link(s) added to:'). '</p> 
					<p>[ <a href="'. get_permalink( $postid ) .'" target="_blank"><strong>'. $title .'</strong></a> ]</p>
					<p>'. __d('<strong>PENDING:</strong> requires moderation'). ', <a href="'.get_option('dt_account_page').'">'. __d('click here'). '</a></p>
					<p>--------------------------</p>
					<p><strong>User:</strong> '. get_user_meta($userid, 'nickname', true) .'</p>
					<p><strong>IP adress:</strong> '. get_client_ip() .'</p>
					<p>--------------------------</p>
				';
				$headers[] = 'From: '. get_option('blogname') .' <'. $to .'>';
				$headers[] = 'Content-Type: text/html; charset=UTF-8';
				wp_mail( $to, $subject, $message, $headers );
				echo '<div class="msg"><i class="icon-check-circle"></i>'. __d('Content submitted, pending moderation ..').'</div>';
			} else {
				echo '<div class="msg"><i class="icon-check-circle"></i>'. __d('Content published correctly..').'</div>';
			}
		} else {
			echo __d('Login');
		}
	}
	die();
}
add_action('wp_ajax_dt_post_links', 'dt_post_links');
add_action('wp_ajax_nopriv_dt_post_links', 'dt_post_links');

/* POST Reports AJAX
-------------------------------------------------------------------------------
*/
function dt_post_reports_ajax() {
	if($_POST['send_report'] == 'true')  {
		// revision Google Recaptcha
		get_template_part('inc/api/recaptchalib');
		$siteKey = GRC_PUBLIC;
		$secret = GRC_SECRET;
		$resp = null;
		$error = null;
		$reCaptcha = new ReCaptcha($secret);
		$recaptcha_response = $_POST["g-recaptcha-response"];
		$remote_addr = $_SERVER["REMOTE_ADDR"];
		$nonce = $_POST['send-report-nonce'];
		if ($recaptcha_response) {
			$resp = $reCaptcha->verifyResponse($remote_addr, $recaptcha_response);
		}
		if ($resp != null && $resp->success)  {
			if( isset( $nonce ) and wp_verify_nonce( $nonce, 'send-report') ) {
				$idpost		= $_POST['idpost'];
				$val_report = get_post_meta($idpost, 'numreport', true) +1;
				$mensaje	= $_POST['mensaje'];
				$permalink	= $_POST['permalink'];
				$title		= $_POST['title'];
				$ip			= $_POST['ip'];
				$name		= get_option('blogname');
				$asunto		= __d('BUG REPORT').": ". $title;
				$to			= get_option('admin_email');
				$repy		= $_POST['reportmail'];
				$url		= get_option('siteurl');
				$message	= "
				<strong>". $title ."</strong>
				<br>
				-------------------------------------<br>
				<br>
				<strong>". __d('Message') .":</strong><br>
				<br>
				". dt_clear($mensaje) ."<br>
				<br>
				-------------------------------------<br>
				<br>
				<strong>". __d('Permalink') .":</strong> ". $permalink ."<br>
				<strong>". __d('Edit post') .":</strong> ". $url ."/wp-admin/post.php?post=".$idpost."&action=edit<br>
				<br>
				-------------------------------------<br>
				<br>
				<strong>". __d('IP') .":</strong> ". $ip ."<br>
				";
				$headers[]	= 'Content-Type: text/html; charset=UTF-8';
				$headers[]	= 'From: '. $name .'  <'. $to .'>';
				$headers[]	= 'Reply-To: '. $repy;
				wp_mail( $to, $asunto , $message,  $headers );
				update_post_meta( $idpost, $key = 'numreport', $val_report );
				echo "<i class='icon-check_circle send'></i>\n";
				echo "<p>". __d('Thank you! Your report was submitted..'). "</p>\n";
			}
		} else {
			 echo __d('Invalid code, please try again.');
		}
	}
	die();
}
add_action('wp_ajax_reports_ajax', 'dt_post_reports_ajax');
add_action('wp_ajax_nopriv_reports_ajax', 'dt_post_reports_ajax');

/* POST Episodes ( wp-admin ) AJAX
-------------------------------------------------------------------------------
*/
function dt_post_episodes_ajax() {
	if( isset( $_GET['episodes_nonce'] ) and wp_verify_nonce($_GET['episodes_nonce'], 'add_episodes') ) {
		if (current_user_can('manage_options')) {
			if (dttp == "valid") {
				if (($_GET["se"] != NULL) && ($_GET["te"] != NULL)) {
					$dtemporada = $_GET["te"];
					$ids = $_GET["se"];
					if (($ids != NULL) && ($dtemporada != NULL)) {
						$urltname = wp_remote_get(tmdburl."tv/".$ids."?&language=".tmdblang."&include_image_language=".tmdblang.",null&api_key=".tmdbkey);
						$json2 = wp_remote_retrieve_body($urltname);
						$data2 = json_decode($json2, TRUE);
						$tituloserie = $data2['name'];
						$urltoc = wp_remote_get(tmdburl."tv/".$ids."/season/".$dtemporada."?append_to_response=images,trailers&language=".tmdblang."&include_image_language=".tmdblang.",null&api_key=".tmdbkey);
						$json1 = wp_remote_retrieve_body($urltoc);
						$data1 = json_decode($json1, TRUE);
						$sdasd = count($data1['episodes']);
						$poster_serie = $data1['poster_path'];
						for ($cont = 1; $cont <= $sdasd; $cont++) {
							$url = wp_remote_get(tmdburl.'tv/'.$ids.'/season/'.$dtemporada.'/episode/'.$cont.'?append_to_response=images&language='.tmdblang.'&include_image_language='.tmdblang.',null&api_key='.tmdbkey);
							$json = wp_remote_retrieve_body($url);
							$data = json_decode($json, TRUE);
							$season = $data['season_number'];
							$episode = $data['episode_number'];
							$name = $data['name'];
							$dmtid = 'tv'.DT_STRING_LINK.$data['id'];
							$overview = $data['overview'];
							if($metadate = $data['air_date'] ) {
								$air_date = $metadate;
							} else {
								$air_date = date('Y-m-d');
							}
							$still_path = $data['still_path'];
							if ($get_img = $data['still_path']) {
								$upload_img = 'https://image.tmdb.org/t/p/w500' . $get_img;
							}
							$crew = $data['crew'];
							$guest_stars = $data['guest_stars'];
							$images = $data['images']["stills"];
							$castor = $img = $cast = $director = $writer = "";
							foreach($crew as $valor) {
								$departamente = $valor['department'];
								if ($valor['profile_path'] == NULL) {
									$valor['profile_path'] = "null";
								}
								if ($departamente == "Directing") {
									$director.= $valor['name'] . ",";
								}
								if ($departamente == "Writing") {
									$writer.= $valor['name'] . ",";
								}
							}
							$i = '0';
							foreach($guest_stars as $valor1) if ($i < 3) {
								if ($valor1['profile_path'] == NULL) {
									$valor1['profile_path'] = "null";
								}
								$castor.= $valor1['name'] . ",";
								$i +=1;
							}
							$i = '0';
							foreach($images as $valor2) if ($i < 10) {
								$img.= $valor2['file_path'] . "\n";
								$i +=1;
							}
							$dt_episodes = array(
								'post_title' => dt_clear($tituloserie. ": ".eseas.$season.esepart.eepisod. $episode),
								'post_content' => dt_clear($overview),
								'post_status' => 'publish',
								'post_type' => 'episodes',
								'post_author' => 1
							);
							$post_id = wp_insert_post($dt_episodes);
							add_post_meta($post_id, "ids", ($ids) , true);
							add_post_meta($post_id, "temporada", ($season) , true);
							add_post_meta($post_id, "episodio", ($episode) , true);
							add_post_meta($post_id, "serie", ($tituloserie) , true);
							add_post_meta($post_id, "episode_name", ($name) , true);
							add_post_meta($post_id, "air_date", ($air_date) , true);
							add_post_meta($post_id, "imagenes", ($img) , true);
							add_post_meta($post_id, "dt_backdrop", ($still_path) , true);
							add_post_meta($post_id, "dt_poster", ($poster_serie) , true);
							add_post_meta($post_id, "dt_string", ($dmtid) , true);
							dt_upload_image($upload_img, $post_id);
						}
					}
					update_post_meta($_GET["link"], 'clgnrt', '1');
					wp_redirect( get_admin_url() . "edit.php?post_type=seasons");
					exit;
				}
				else {
					echo 'error';
					exit;
				}
			}
			else {
				echo 'invalid license';
				exit;
			}
		}
		else {
			echo 'login';
			exit;
		}
	}
	die();
}
add_action('wp_ajax_episodes_ajax', 'dt_post_episodes_ajax');
add_action('wp_ajax_nopriv_episodes_ajax', 'dt_post_episodes_ajax');

/* POST Episodes ( front-end ) AJAX
-------------------------------------------------------------------------------
*/
function dt_post_episodes_front_ajax() {
	if( isset($_GET['episodes_nonce'] ) and wp_verify_nonce($_GET['episodes_nonce'], 'add_episodes') ) {
		if (current_user_can('manage_options')) {
			if (dttp == "valid") {
				if (($_GET["se"] != NULL) && ($_GET["te"] != NULL)) {
					$dtemporada = $_GET["te"];
					$ids = $_GET["se"];
					if (($ids != NULL) && ($dtemporada != NULL)) {
						$urltname = wp_remote_get(tmdburl."tv/".$ids."?&language=".tmdblang."&include_image_language=".tmdblang.",null&api_key=".tmdbkey);
						$json2 = wp_remote_retrieve_body($urltname);
						$data2 = json_decode($json2, TRUE);
						$tituloserie = $data2['name'];
						$urltoc = wp_remote_get(tmdburl."tv/".$ids."/season/".$dtemporada."?append_to_response=images,trailers&language=".tmdblang."&include_image_language=".tmdblang.",null&api_key=".tmdbkey);
						$json1 = wp_remote_retrieve_body($urltoc);
						$data1 = json_decode($json1, TRUE);
						$sdasd = count($data1['episodes']);
						$poster_serie = $data1['poster_path'];
						for ($cont = 1; $cont <= $sdasd; $cont++) {
							$url = wp_remote_get(tmdburl.'tv/'.$ids.'/season/'.$dtemporada.'/episode/'.$cont.'?append_to_response=images&language='.tmdblang.'&include_image_language='.tmdblang.',null&api_key='.tmdbkey);
							$json = wp_remote_retrieve_body($url);
							$data = json_decode($json, TRUE);
							$season = $data['season_number'];
							$episode = $data['episode_number'];
							$name = $data['name'];
							$dmtid = 'tv'.DT_STRING_LINK.$data['id'];
							$overview = $data['overview'];
							if($metadate = $data['air_date'] ) {
								$air_date = $metadate;
							} else {
								$air_date = date('Y-m-d');
							}
							$still_path = $data['still_path'];
							if ($get_img = $data['still_path']) {
								$upload_img = 'https://image.tmdb.org/t/p/w500' . $get_img;
							}
							$crew = $data['crew'];
							$guest_stars = $data['guest_stars'];
							$images = $data['images']["stills"];
							$castor = $img = $cast = $director = $writer = "";
							foreach($crew as $valor) {
								$departamente = $valor['department'];
								if ($valor['profile_path'] == NULL) {
									$valor['profile_path'] = "null";
								}
								if ($departamente == "Directing") {
									$director.= $valor['name'] . ",";
								}
								if ($departamente == "Writing") {
									$writer.= $valor['name'] . ",";
								}
							}
							$i = '0';
							foreach($guest_stars as $valor1) if ($i < 3) {
								if ($valor1['profile_path'] == NULL) {
									$valor1['profile_path'] = "null";
								}
								$castor.= $valor1['name'] . ",";
								$i +=1;
							}
							$i = '0';
							foreach($images as $valor2) if ($i < 10) {
								$img.= $valor2['file_path'] . "\n";
								$i +=1;
							}
							$dt_episodes = array(
								'post_title' => dt_clear($tituloserie. ": ".eseas.$season.esepart.eepisod. $episode),
								'post_content' => dt_clear($overview),
								'post_status' => 'publish',
								'post_type' => 'episodes',
								'post_author' => 1
							);
							$post_id = wp_insert_post($dt_episodes);
							add_post_meta($post_id, "ids", ($ids) , true);
							add_post_meta($post_id, "temporada", ($season) , true);
							add_post_meta($post_id, "episodio", ($episode) , true);
							add_post_meta($post_id, "serie", ($tituloserie) , true);
							add_post_meta($post_id, "episode_name", ($name) , true);
							add_post_meta($post_id, "air_date", ($air_date) , true);
							add_post_meta($post_id, "imagenes", ($img) , true);
							add_post_meta($post_id, "dt_backdrop", ($still_path) , true);
							add_post_meta($post_id, "dt_poster", ($poster_serie) , true);
							add_post_meta($post_id, "dt_string", ($dmtid) , true);
							dt_upload_image($upload_img, $post_id);
						}
					}
					update_post_meta($_GET["link"], 'clgnrt', '1');
					wp_redirect(get_permalink( $_GET["link"] ));
					exit;
				}  else {
					echo 'error';
					exit;
				}
			} else {
				echo 'invalid license';
				exit;
			}
		} else {
			echo 'login';
			exit;
		}
	}
	die();
}
add_action('wp_ajax_seasonsf_ajax', 'dt_post_episodes_front_ajax');
add_action('wp_ajax_nopriv_seasonsf_ajax', 'dt_post_episodes_front_ajax');

/* POST Seasons AJAX
-------------------------------------------------------------------------------
*/
function dt_post_seasons_ajax() {
	if( isset($_GET['seasons_nonce'] ) and wp_verify_nonce($_GET['seasons_nonce'], 'add_seasons') ) {
		if (current_user_can('manage_options'))
		{
			if (dttp == "valid")
			{
				if (($_GET["se"] != NULL))
				{
					$ids = $_GET["se"];
					if (($ids != NULL))
					{
						$urltname = wp_remote_get(tmdburl."tv/". $ids."?&language=".tmdblang."&include_image_language=".tmdblang.",null&api_key=".tmdbkey);
						$json2 = wp_remote_retrieve_body($urltname);
						$data2 = json_decode($json2, TRUE);
						$tituloserie = $data2['name'];
						$sdasd = $data2['number_of_seasons'];
						for ($cont = 1; $cont <= $sdasd; $cont++)
						{
							$url = wp_remote_get(tmdburl.'tv/'.$ids.'/season/'.$cont .'?append_to_response=images&language='.tmdblang.'&include_image_language='.tmdblang.',null&api_key='.tmdbkey);
							$json = wp_remote_retrieve_body($url);
							$data = json_decode($json, TRUE);
							$name = $data['name'];
							$poster_serie = $data['poster_path'];
							if ($get_img = $data['poster_path'])
							{
								$upload_poster = 'https://image.tmdb.org/t/p/w396' . $get_img;
							}
							$overview = $data['overview'];
							$year = substr($data['air_date'], 0, 4);
							$fecha = $data['air_date'];
							$season_number = $data['season_number'];
							$my_post = array(
								'post_title' => dt_clear($tituloserie . ": " . __d('Season') . " " . $cont),
								'post_content' => dt_clear($overview),
								'post_status' => 'publish',
								'post_type' => 'seasons',
								'post_author' => 1
							);
							$post_id = wp_insert_post($my_post);
							add_post_meta($post_id, "ids", ($ids) , true);
							add_post_meta($post_id, "temporada", ($season_number) , true);
							add_post_meta($post_id, "serie", ($tituloserie) , true);
							add_post_meta($post_id, "air_date", ($fecha) , true);
							add_post_meta($post_id, "dt_poster", ($poster_serie) , true);
							dt_upload_image($upload_poster, $post_id);
						}
					}
					update_post_meta($_GET["link"], 'clgnrt', '1');
					wp_redirect(get_admin_url() . "edit.php?post_type=seasons");
					exit;
				} else {
					echo 'error';
					exit;
				}
			} else {
				echo 'invalid license';
				exit;
			}
		} else {
			echo 'login';
			exit;
		}
	}
	die();
}
add_action('wp_ajax_seasons_ajax', 'dt_post_seasons_ajax');
add_action('wp_ajax_nopriv_seasons_ajax', 'dt_post_seasons_ajax');

/* Update user account page
-------------------------------------------------------------------------------
*/
function dt_update_user_page() {
	if( isset($_POST['update-user-nonce'] ) and wp_verify_nonce($_POST['update-user-nonce'], 'update-user') ) {
		$error = array();
		global $current_user, $wp_roles;
		wp_get_current_user();
		// update password
		if (!empty($_POST['pass1']) && !empty($_POST['pass2'])) {
			if ($_POST['pass1'] == $_POST['pass2']) {
				wp_update_user(array(
				'ID' => $current_user->ID,
				'user_pass' => esc_attr($_POST['pass1'])
			));
			} else {
				echo '<div class="error"><i class="icon-times-circle"></i> '. __d('The passwords you entered do not match.  Your password was not updated.'). '</div>';
				exit;
			}
		}
		if (!empty($_POST['url'])) wp_update_user(array('ID' => $current_user->ID,'user_url' => esc_attr($_POST['url'])));
		if (!empty($_POST['first-name'])) update_user_meta($current_user->ID, 'first_name', esc_attr($_POST['first-name']));
		if (!empty($_POST['last-name'])) update_user_meta($current_user->ID, 'last_name', esc_attr($_POST['last-name']));
		if (!empty($_POST['display_name'])) wp_update_user(array('ID' => $current_user->ID,'display_name' => esc_attr($_POST['display_name'])));
		update_user_meta($current_user->ID, 'display_name', esc_attr($_POST['display_name']));
		update_user_meta($current_user->ID, 'description', esc_attr($_POST['description']));
		update_user_meta($current_user->ID, 'dt_twitter', esc_attr($_POST['twitter']));
		update_user_meta($current_user->ID, 'dt_facebook', esc_attr($_POST['facebook']));
		update_user_meta($current_user->ID, 'dt_gplus', esc_attr($_POST['gplus']));
		if (count($error) == 0) {
			do_action('edit_user_profile_update', $current_user->ID);
			echo '<div class="sent"><i class="icon-check-circle"></i> '. __d('Your profile has been updated.'). '</div>';
			exit;
		}
	}
	die();
}
add_action('wp_ajax_dt_update_user', 'dt_update_user_page');
add_action('wp_ajax_nopriv_dt_update_user', 'dt_update_user_page');

/* Page list account / Movies and TVShows..
-------------------------------------------------------------------------------
*/
function next_page_list() {
	$paged	= $_POST["page"]+1;
	$type	= $_POST["typepost"];
	$user	= $_POST["user"];
	$args = array(
	  'paged' => $paged,
	  'numberposts' => -1,
	  'orderby' => 'date',
	  'order'   => 'DESC',
	  'post_type' => $type,
	  'posts_per_page' => 12,
	  'meta_query' => array (
		array (
		  'key' => '_user_liked',
		  'value' => $user,
		  'compare' => 'LIKE'
		)
	  ) );
	$sep = '';
	$list_query = new WP_Query( $args );
	if ( $list_query->have_posts() ) : while ( $list_query->have_posts() ) : $list_query->the_post();
		 get_template_part('inc/parts/simple_item');
	endwhile;
	else :
	echo '<div class="no_fav">'. __d('No more content to show.'). '</div>';
	endif; wp_reset_postdata();
	die();
}
add_action('wp_ajax_next_page_list', 'next_page_list');
add_action('wp_ajax_nopriv_next_page_list', 'next_page_list');


/* Page list links
-------------------------------------------------------------------------------
*/
function next_page_link() {
	$paged	= $_POST["page"]+1;
	$user	= $_POST["user"];
	$args = array(
	  'paged' => $paged,
	  'orderby' => 'date',
	  'order'   => 'DESC',
	  'post_type' => 'dt_links',
	  'posts_per_page' => 10,
	  'post_status' => array('pending', 'publish', 'trash'),
	  'author' => $user,
	  );
	$list_query = new WP_Query( $args );
	if ( $list_query->have_posts() ) : while ( $list_query->have_posts() ) : $list_query->the_post();
		 get_template_part('inc/parts/item_links');
	endwhile;
	else :
	echo '<tr><td>-</td><td>-</td><td class="views">-</td><td class="status">-</td><td>-</td></tr>';
	endif; wp_reset_postdata();
	die();
}
add_action('wp_ajax_next_page_link', 'next_page_link');
add_action('wp_ajax_nopriv_next_page_link', 'next_page_link');

/* Page list links profile
-------------------------------------------------------------------------------
*/
function next_page_link_profile() {
	$paged	= $_POST["page"]+1;
	$user	= $_POST["user"];
	$args = array(
	  'paged' => $paged,
	  'orderby' => 'date',
	  'order'   => 'DESC',
	  'post_type' => 'dt_links',
	  'posts_per_page' => 10,
	  'post_status' => array('pending', 'publish', 'trash'),
	  'author' => $user,
	  );
	$list_query = new WP_Query( $args );
	if ( $list_query->have_posts() ) : while ( $list_query->have_posts() ) : $list_query->the_post();
		 get_template_part('inc/parts/item_links_profile');
	endwhile;
	else :
	echo '<tr><td>-</td><td>-</td><td class="views">-</td><td class="views">-</td><td class="views">-</td><td class="views">-</td><td class="views">-</td></tr>';
	endif; wp_reset_postdata();
	die();
}
add_action('wp_ajax_next_page_link_profile', 'next_page_link_profile');
add_action('wp_ajax_nopriv_next_page_link_profile', 'next_page_link_profile');

/* Page list Admin links
-------------------------------------------------------------------------------
*/
function next_page_link_admin() {
	$paged	= $_POST["page"]+1;
	$args = array(
	  'paged' => $paged,
	  'orderby' => 'date',
	  'order'   => 'DESC',
	  'post_type' => 'dt_links',
	  'posts_per_page' => 10,
	  'post_status' => array('pending'),
	  );
	$list_query = new WP_Query( $args );
	if ( $list_query->have_posts() ) : while ( $list_query->have_posts() ) : $list_query->the_post();
		 get_template_part('inc/parts/item_links_admin');
	endwhile;
	else :
	echo '<tr><td>-</td><td>-</td><td>-</td><td class="views">-</td><td class="status">-</td><td>-</td></tr>';
	endif; wp_reset_postdata();
	die();
}
add_action('wp_ajax_next_page_link_admin', 'next_page_link_admin');
add_action('wp_ajax_nopriv_next_page_link_admin', 'next_page_link_admin');

/* Control post link
-------------------------------------------------------------------------------
*/
function control_link_user() {
	$post_id = $_POST['post_id'];
	$user_id = $_POST['user_id'];
	$status	= $_POST['status'];
	$auhor_id = get_current_user_id();
	if($auhor_id) {
	$args = array('ID' => $post_id,'post_status'=> $status);
		wp_update_post( $args );
		if($status == 'publish'){
			echo __d('Link enabled');
		}elseif($status == 'pending'){
			echo __d('Link disabled');
		}elseif($status == 'trash'){
			echo __d('Link moved to trash');
		}
	}
	die();
}
add_action('wp_ajax_control_link_user', 'control_link_user');
add_action('wp_ajax_nopriv_control_link_user', 'control_link_user');

/* Form Edit link
-------------------------------------------------------------------------------
*/
function edit_user_link() {
	if(is_user_logged_in()) {
		$post_id = $_POST['post_id'];
?>
<div class="form_edit">
	<div class="cerrar"><a id="cerrar_form_edit_link"><i class="icon-close"></i></a></div>
	<form id="editar_link">
		<fieldset>
			<h3><i class="icon-voice_chat"></i> <a href="<?php echo home_url(). '?p='. get_post_meta( $post_id, 'dt_postid', true ); ?>" target="_blank"><?php echo get_post_meta( $post_id, 'dt_postitle', true ); ?></a></h3>
		</fieldset>
		<fieldset>
			<select name="type" id="type">
			<?php $tipo = array( __d('Download') , __d('Watch online') );
			foreach( $tipo as $val ) { ?>
				<option <?php echo (get_post_meta( $post_id, 'links_type', true  ) === $val ) ? 'selected' : '' ?>><?php echo $val; ?></option>
			<?php } ?>
			</select>
		</fieldset>

		<fieldset>
			<input type="text" name="url" id="url" value="<?php echo get_post_meta( $post_id, 'links_url', true ); ?>">
		</fieldset>

		<fieldset>
			<select name="idioma" id="idioma">
			<?php $links_lang = get_option('dt_languages_post_link');
			if(!empty($links_lang)){ $val = explode(",", $links_lang); foreach( $val as $valor ){ ?>
				<option <?php  echo (get_post_meta( $post_id, 'links_idioma', true ) === $valor ) ? 'selected' : '' ?>><?php echo $valor; ?></option>
			<?php }  } else {
			$quality = array('Spanish','English','Portuguese','Italian','French','Turkish');
			foreach( $quality as $val ) { ?>
				<option <?php echo (get_post_meta( $post_id, 'links_idioma', true ) === $val ) ? 'selected' : '' ?>><?php echo $val; ?></option>
			<?php }  } ?>
			</select>
		</fieldset>
		<fieldset>
			<select name="quality" id="quality">
			<?php
			$links_quality = get_option('dt_quality_post_link');
			if(!empty($links_quality)){ $val = explode(",", $links_quality); foreach( $val as $valor ){ ?>
				<option <?php  echo (get_post_meta( $post_id, 'links_quality', true ) === $valor ) ? 'selected' : '' ?>><?php echo $valor; ?></option>
			<?php }  } else {
			$quality = array('SD','HD','480p','720p','1080p');
			foreach( $quality as $val ) { ?>
				<option <?php echo (get_post_meta( $post_id, 'links_quality', true ) === $val ) ? 'selected' : '' ?>><?php echo $val; ?></option>
			<?php }  } ?>
			</select>
		</fieldset>
		<fieldset>
			<input type="text" name="filesize" id="filesize" value="<?php echo get_post_meta( $post_id, 'dt_filesize', true ); ?>" placeholder="File size (optional)">
		</fieldset>
		<fieldset>
			<input type="submit" value="Save data">
		</fieldset>
		<input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id; ?>">
	</form>
</div>
<?php
	}
	die();
}
add_action('wp_ajax_edit_user_link', 'edit_user_link');
add_action('wp_ajax_nopriv_edit_user_link', 'edit_user_link');

/* save edit link
-------------------------------------------------------------------------------
*/
function save_user_link(){
	if(is_user_logged_in()) {
		// User levels
		if(current_user_can('administrator')) {
			$status = 'publish'; // Admin's
		}
		elseif(current_user_can('editor')) {
			$status = 'publish'; // Editor's
		}
		elseif(current_user_can('author')) {
			$status = 'publish'; // Author's
		}
		elseif(current_user_can('contributor')) {
			$status = 'publish'; // Contributor's
		}
		elseif(current_user_can('subscriber')) {
			$status = 'pending'; // Regular user's
		}
		else {
			$status = 'pending'; // No role
		}

		// Elements
		$post_id = dt_clear($_POST['post_id']);
		$link = dt_clear($_POST['link']);
		$tipo = dt_clear($_POST['tipo']);
		$size = dt_clear($_POST['size']);
		$calidad = dt_clear($_POST['calidad']);
		$idioma = dt_clear($_POST['idioma']);

		// Update data
		$post = array('ID'=> $post_id,'post_status' => $status);
		wp_update_post( $post );
		update_post_meta( $post_id, 'links_type', esc_attr( $tipo ) );
		update_post_meta( $post_id, 'links_url', esc_attr( $link ) );
		update_post_meta( $post_id, 'dt_filesize', esc_attr( $size ) );
		update_post_meta( $post_id, 'links_idioma', esc_attr( $idioma ) );
		update_post_meta( $post_id, 'links_quality', esc_attr( $calidad ) );
		echo '<div class="form_edit">';
		echo '<div class="cerrar"><a id="cerrar_form_edit_link"><i class="icon-close"></i></a></div>';
		echo '<div class="ready"><i class="icon-check-circle"></i>'.__d('Updated link').'</div>';
		echo '</div>';
	}
	die();
}
add_action('wp_ajax_save_user_link', 'save_user_link');
add_action('wp_ajax_nopriv_save_user_link', 'save_user_link');

/* Live Search
-------------------------------------------------------------------------------
*/
function dooplay_live_search( $request_data ) {
   	$parameters = $request_data->get_params();
    $keyword = dt_clear($parameters['keyword']);
    $nonce = dt_clear($parameters['nonce']);
	$types = array('movies','tvshows');
	if( !dooplay_verify_nonce('dooplay-search-nonce', $nonce ) ) return array('error' => 'no_verify_nonce', 'title' => __d('No data nonce') );
	if( !isset( $keyword ) || empty($keyword) ) return array('error' => 'no_parameter_given');
	if( strlen( $keyword ) <= 2 ) return array('error' => 'keyword_not_long_enough', 'title' => __d('') );

	$args = array(
		's' => $keyword,
		'post_type' => $types,
		'posts_per_page' => 5
	);
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) {
    	$data = array();
        while ( $query->have_posts() ) {
            $query->the_post();
            global $post;
            $data[$post->ID]['title'] = $post->post_title;
            $data[$post->ID]['url'] = get_the_permalink();
			if ( has_post_thumbnail() ) { 
				$data[$post->ID]['img'] = get_the_post_thumbnail_url($post->ID, 'dt_poster_b');
			} elseif ($dato = dt_get_meta('dt_poster')) {
				$data[$post->ID]['img'] = 'https://image.tmdb.org/t/p/w90'. $dato;
			}
			if($dato = dt_get_meta('release_date')) {
				$data[$post->ID]['extra']['date'] = substr($dato, 0, 4);
			}
			if($dato = dt_get_meta('first_air_date')) {
				$data[$post->ID]['extra']['date'] = substr($dato, 0, 4);
			}
			$data[$post->ID]['extra']['imdb'] = dt_get_meta('imdbRating');
        }
        return $data;
    } else {
    	return array('error' => 'no_posts', 'title' => __d('No results') );
    }
    wp_reset_postdata();
}

/* Updata IMDb Rating 
-------------------------------------------------------------------------------
*/
function update_imdb_rating() {
	$id = $_POST['id'];
	$imdb = $_POST['imdb'];
	if(current_user_can('administrator')){
		$api	= wp_remote_get(imdbdata. $imdb );
		$json	= wp_remote_retrieve_body($api);
		$data	= json_decode($json, TRUE);
		$rating = $data['imdbRating'];
		$votes	= $data['imdbVotes'];
		update_post_meta( $id, 'imdbRating', $rating );
		update_post_meta( $id, 'imdbVotes', $votes );
		echo '<strong>'. $rating. '</strong> '. $votes .' '. __d('votes');
	}
	die();
}
add_action('wp_ajax_update_imdb_rating', 'update_imdb_rating');
add_action('wp_ajax_nopriv_update_imdb_rating', 'update_imdb_rating');

/* Filter all content
-------------------------------------------------------------------------------
*/
function dt_social_count() {
	$idpost = $_POST['id'];
	$meta = get_post_meta( $idpost, 'dt_social_count', true);
	$total = $meta +1;
	update_post_meta( $idpost, 'dt_social_count', $total );
	echo comvert_number($total);
	die();
}
add_action('wp_ajax_dt_social_count', 'dt_social_count');
add_action('wp_ajax_nopriv_dt_social_count', 'dt_social_count');

/* Delete count report
-------------------------------------------------------------------------------
*/
function delete_notice_report() {
	$id = $_POST['id'];
	if(current_user_can('administrator')) {
		delete_post_meta($id, 'numreport' );
	}
	die();
}
add_action('wp_ajax_delete_notice_report', 'delete_notice_report');
add_action('wp_ajax_nopriv_delete_notice_report', 'delete_notice_report');