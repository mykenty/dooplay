<?php

function dbmovies_page() {
     add_menu_page(
        __d('Importer tool'),
        __d('dbmovies'),
        'manage_options',
        'dbmovies.org',
        'dbmovies_callback',
        'dashicons-networking'
    );
}
function dbmovies_callback() { ?>
<div id="dt_importer" class="dt_importer_wrap">
	<header class="dt_importer">
		<div class="box">
			<h1><a href="https://dbmovies.org" target="_blank"><img src="<?php echo DT_DIR_URI; ?>/assets/img/dbmovies.png"></a> <i>by doothemes</i></h1>
		</div>
	</header><!-- fin header.dt_importer -->
	<div class="dt_importer_contaiter">
		<div class="dt_imp_menu">
			<ul class="tabs">
				<li id="filter_year_li" class="tab-link current" data-tab="tab-1"><?php _d('Filter for year'); ?></li>
				<li id="filter_year_li" class="tab-link" data-tab="tab-0"><?php _d('Search title'); ?></li>
				<li id="single_url_li" class="tab-link" data-tab="tab-2"><?php _d('Import ID'); ?></li>
				<li class="tab-link" data-tab="tab-3"><?php _d('Status'); ?></li>
			</ul>
			<div id="add_data_post"></div>
		</div><!-- fin div.dt_imp_menu -->
		<div class="content">
			<div id="tab-0" class="tab-content">
				<h1 style="margin-top: 0;"><?php _d('Search content'); ?></h1>
				<form id="search_all" class="search_all">
					<div class="box">
						<input type="text" name="query" placeholder="<?php _d('Search a title..'); ?>">
						<button name="search_all_data" type="submit" class="button button-primary"><?php _d('Search'); ?></button>
					</div>
					<label for="page"><input type="number" name="page"></label>
					<label for="movie"><input type="radio" id="movie" name="type" value="movie" required checked> <?php _d('Movies'); ?></label>
					<label for="tvshows"><input type="radio" id="tvshows" name="type" value="tv" required> <?php _d('TV Shows'); ?></label>
					<?php wp_nonce_field('search-all','search-all-nonce') ?>
				</form>
			</div>
			<div id="tab-1" class="tab-content current">
				<section style="padding-left:0">
					<h1 style="margin-top: 0;"><?php _d('Movies'); ?></h1>
					<form id="search_imdb" class="form_importer_dt">
						<p>
						<input type="number" id="imdbyear" name="imdbyear" placeholder="<?php _d('Year'); ?>" min="1930" max="<?php echo date('Y'); ?>" required>
						<input style="margin-right: 0" type="number" id="imdbpage" name="imdbpage" placeholder="<?php _d('Page'); ?>" min="1" required>
						</p>
						<p><input type="submit" class="button button-primary" name="search_data_imdb" value="<?php _d('Get content'); ?>"></p>
						<?php wp_nonce_field('send-imdb','send-imdb-nonce') ?>
					</form>
				</section>
				<section class="right" style="padding-right:0">
					<h1 style="margin-top: 0;"><?php _d('TV Shows'); ?></h1>
					<form id="search_tmdb" class="form_importer_dt">
						<p>
						<input type="number" id="tmdbyear" name="tmdbyear" placeholder="<?php _d('Year'); ?>" min="1930" max="<?php echo date('Y'); ?>" required>
						<input style="margin-right: 0" type="number" id="tmdbpage" name="tmdbpage" placeholder="<?php _d('Page'); ?>" min="1" required>
						</p>
						<p><input type="submit" class="button button-primary" name="search_data_tmdb" value="<?php _d('Get content'); ?>"></p>
						<?php wp_nonce_field('send-tmdb','send-tmdb-nonce') ?>
					</form>
				</section>
				<p class="desc"><?php _d('Get data from Themoviedb.org'); ?></p>
			</div>
			<div id="tab-2" class="tab-content">
				<section>
					<h1 style="margin-top: 0;"><?php _d('Movies'); ?></h1>
					<form id="single_url_imdb" class="form_importer_dt">
						<p><input type="text" name="idmovie" placeholder="<?php _d('ID Movie'); ?>" required></p>
						<p><input type="submit" class="button button-primary" name="send_id_movie" value="<?php _d('Import'); ?>"></p>
						<?php wp_nonce_field('send-movies','send-movies-nonce') ?>
						<p class="desc"><?php _d('Example'); ?>: themoviedb.org/movie/<strong>14564</strong></p>
					</form>
				</section>

				<section class="right">
					<h1 style="margin-top: 0;"><?php _d('TV Shows'); ?></h1>
					<form id="single_url_tmdb" class="form_importer_dt">
						<p><input type="text" name="idtv" placeholder="<?php _d('ID TVShow'); ?>" required></p>
						<p><input type="submit" class="button button-primary" name="send_id_tv" value="<?php _d('Import'); ?>"></p>
						<?php wp_nonce_field('send-series','send-series-nonce') ?>
						<p class="desc"><?php _d('Example'); ?>: themoviedb.org/tv/<strong>1402</strong></p>
					</form>
				</section>
			</div>
			<div id="tab-3" class="tab-content">
				<h1 style="margin-top: 0;"><?php _d('Status of server processes'); ?></h1>
				<div id="result_server"></div>
				<form id="api_status" class="form_importer_dt">
					<?php wp_nonce_field('send-status','send-status-nonce') ?>
					<p><input type="submit" class="button button-primary" value="<?php _d('Check server status'); ?>"></p>
				</form>
			</div>

		</div><!-- fin div.content -->
		<div id="resultado"></div>
	</div><!-- fin div.dt_importer_contaiter -->
</div><!-- fin div.dt_importer_wrap -->
<?php
// FIN HTML
}

/* dbmovies Ajax
-------------------------------------------------------------------------------
*/
function dbmovies_assets() {
	if($_GET['page']=='dbmovies.org') {
		wp_enqueue_style('dt-importer-tool-styles', DT_DIR_URI .'/assets/css/importer.css', '', DT_VERSION, 'all');
		wp_enqueue_script('dt-importer-tool-scripts',  DT_DIR_URI .'/assets/js/importer.js', array('jquery'), DT_VERSION, false );
		wp_localize_script('dt-importer-tool-scripts', 'DTapi', array(
			// Importar
			'ajaxurl'			=>	admin_url('admin-ajax.php', 'relative'),
			// Mensajes
			'preresultado'		=> __d('Searching content, wait a moment...'),
			'preresultadolog'	=> __d('Searching and extracting data...'),
			'resultadolog'		=> __d('Data found, completed process!'),
			'resultadoerror'	=> __d('Error, no data...'),
			'agregandodatos'	=> __d('Adding data...'),
			'agregandodatoslog' => __d('Adding content to the database...'),
			'procesocompleto'	=> __d('Process completed!'),
			'postdataerror'		=> __d('Content could not be added!'),
			'queryserver'		=> __d('Server status query...'),
			'verificationsr'	=> __d('Verification completed!'),
			'loading'			=> __d('Loading...'),
			'getcontent'		=> __d('Get content'),
		) );
	}
}

/* Search All content
-------------------------------------------------------------------------------
*/
function dbm_search_all() {
	if ( current_user_can('manage_options')) {
		if( isset($_POST['search-all-nonce'] ) and wp_verify_nonce($_POST['search-all-nonce'], 'search-all') ) { 
			$apikey = tmdbkey;
			$apilang = tmdblang;
			$query = $_POST['query'];
			$page = $_POST['page'];
			$type = $_POST['type'];
			// Resolver json Search
			$api	= wp_remote_get( tmdburl. 'search/'.$type.'?api_key='.$apikey.'&language='.$apilang.'&query='.$query.'&page='.$page);
			$json	= wp_remote_retrieve_body($api);
			$data	= json_decode($json, TRUE);

			// resultados de la API
			$pagex = $data['page'];
			$total_results = $data['total_results'];
			$total_pages = $data['total_pages'];
			$results = $data['results'];
			$ct = array();
			$limit = count($results);
			$num = ($limit * $page - $limit + 1  );
			echo '<div class="dtlist">';
			echo '<h1>'. __d('Page').' <b>'.$pagex .'</b> '. __d('of').' <b>'.$total_pages.'</b> '.__d('there are').' <b>'.$total_results.'</b> '.__d('titles found').'</h1>';
			foreach($results as $ci) {
				$id		= $ct[] = $ci['id'];
				if($type == 'movie'){
					$title	= $ct[] = $ci['title'];
					$year	= $ct[] = substr($ci['release_date'], 0, 4);
					$class  = 'a_import_imdb';
					$meta	= 'idtmdb';
				} elseif($type == 'tv') { 
					$title	= $ct[] = $ci['name'];
					$year	= $ct[] = substr($ci['first_air_date'], 0, 4);
					$class  = 'a_import_tmdb';
					$meta	= 'ids';
				}
				$poster = $ct[] = $ci['poster_path'];
				// vericador
				global $wpdb;
				$consulta = "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '$meta' AND meta_value = '{$id}' ";
				$verificar = $wpdb->get_results( $consulta, OBJECT );

				echo '<article id="' . $id. '">';
				if($poster) {
					echo '<div class="img"><img src="https://image.tmdb.org/t/p/w45'.$poster.'"></div>';
				} else {
					echo '<div class="no_img"><span class="dashicons dashicons-no"></span></div>';
				}
				if ($verificar) {
					echo $num. ' <span class="imported">'.__d('imported').'</span> <strong><a href="http://themoviedb.org/'.$type.'/'. $id.'/" target="_blank">'.$title.'</a></strong> <i>('. $year .')</i>';
				} else {
					echo $num. ' <span><a class="'.$class.'" data-id="'. $id.'">'. __d('Import') .'</a></span> <strong><a href="http://themoviedb.org/'.$type.'/'. $id.'" target="_blank">'.$title.'</a></strong> <i>('.$year.')</i>';
				}
				echo '</article>';
				$num++;

			}
			echo '</div>';
			echo '<a id="load_more_search">'.__d('Next page').'</a>';
	
		}
	}
	die();
}

add_action('wp_ajax_dbm_search_all', 'dbm_search_all');
add_action('wp_ajax_nopriv_dbm_search_all', 'dbm_search_all');

/* Get Movies
-------------------------------------------------------------------------------
*/
function dbm_get_movies() {
	if ( current_user_can('manage_options')) {
		if( isset($_POST['send-imdb-nonce'] ) and wp_verify_nonce($_POST['send-imdb-nonce'], 'send-imdb') ) { 
			// Parametros
			$apiyear = $_POST['imdbyear'];
			$apipage = $_POST['imdbpage'];
			$apikey = tmdbkey;
			$apilang = tmdblang;
			// Resolver json discover
			$api	= wp_remote_get( tmdburl. 'discover/movie?api_key='.$apikey.'&language='.$apilang.'&sort_by=popularity.desc&page='.$apipage.'&primary_release_year='.$apiyear);
			$json	= wp_remote_retrieve_body($api);
			$data	= json_decode($json, TRUE);
			// resultados de la API
			$page = $data['page'];
			$total_results = $data['total_results'];
			$total_pages = $data['total_pages'];
			$results = $data['results'];
			$ct = array();
			$limit = count($results);
			$num = ($limit * $page - $limit + 1  );
			echo '<h1>'. __d('Page').' <b>'.$page .'</b> '. __d('of').' <b>'.$total_pages.'</b> '.__d('there are').' <b>'.$total_results.'</b> '.__d('titles found').'</h1>';
			echo '<div class="dtlist">';
			foreach($results as $ci) {
				$id		= $ct[] = $ci['id'];
				$title	= $ct[] = $ci['title'];
				$year	= $ct[] = substr($ci['release_date'], 0, 4);
				$poster = $ct[] = $ci['poster_path'];
				// vericador
				global $wpdb;
				$consulta = "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'idtmdb' AND meta_value = '{$id}' ";
				$verificar = $wpdb->get_results( $consulta, OBJECT );
				echo '<article id="' . $id. '">';
				if($poster) {
					echo '<div class="img"><img src="https://image.tmdb.org/t/p/w45'.$poster.'"></div>';
				} else {
					echo '<div class="no_img"><span class="dashicons dashicons-no"></span></div>';
				}
				if ($verificar) {
					echo $num. ' <span class="imported">'.__d('imported').'</span> <strong><a href="http://themoviedb.org/movie/'. $id.'/" target="_blank">'.$title.'</a></strong> <i>('. $year .')</i>';
				} else {
					echo $num. ' <span><a class="a_import_imdb" data-id="'. $id.'">'. __d('Import') .'</a></span> <strong><a href="http://themoviedb.org/movie/'. $id.'" target="_blank">'.$title.'</a></strong> <i>('.$year.')</i>';
				}
				echo '</article>';
				$num++;
			}
			echo '</div>';
			echo '<a id="load_more_imdb_link">'.__d('Next page').'</a>';
		}
	}
	die();
}

/* Get TV Shows
-------------------------------------------------------------------------------
*/
function dbm_get_tv() {
		if ( current_user_can('manage_options')) {
			if( isset($_POST['send-tmdb-nonce'] ) and wp_verify_nonce($_POST['send-tmdb-nonce'], 'send-tmdb') ) { 
				// Parametros
				$apiyear	= $_POST['tmdbyear'];
				$apipage	= $_POST['tmdbpage'];
				$apikey = tmdbkey;
				$apilang = tmdblang;
				// Resolver json Discover
				$api	= wp_remote_get( tmdburl. 'discover/tv?api_key='.$apikey.'&language='.$apilang.'&sort_by=popularity.desc&first_air_date_year='.$apiyear.'&page='.$apipage);
				$json	= wp_remote_retrieve_body($api);
				$data	= json_decode($json, TRUE);
				// resultados de la API
				$page = $data['page'];
				$total_results = $data['total_results'];
				$total_pages = $data['total_pages'];
				$results = $data['results'];
				$ct = array();
				echo '<h1>'. __d('Page').' <b>'.$page .'</b> '. __d('of').' <b>'.$total_pages.'</b> '.__d('there are').' <b>'.$total_results.'</b> '.__d('titles found').'</h1>';
				echo '<div class="dtlist">';
				$limit = count($results);
				$num = ($limit * $page - $limit + 1  );
				// Mostrar resultados
				foreach($results as $ci) {
					$id		= $ct[] = $ci['id'];
					$poster = $ct[] = $ci['poster_path'];
					$name	= $ct[] = $ci['name'];
					$year	= $ct[] = substr($ci['first_air_date'], 0, 4);

					// vericador
					global $wpdb;
					$consulta = "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'ids' AND meta_value = '{$id}' ";
					$verificar = $wpdb->get_results( $consulta, OBJECT );
					
					echo '<article id="' . $id. '">';
					if($poster) {
						echo '<div class="img"><img src="https://image.tmdb.org/t/p/w45'.$poster.'"></div>';
					} else {
						echo '<div class="no_img"><span class="dashicons dashicons-no"></span></div>';
					}
					if ($verificar) {
						echo $num. ' <span class="imported">'.__d('imported').'</span> <strong>'. $name .'</strong> <i>('. $year .')</i>';
					} else {
						echo $num. ' <span><a class="a_import_tmdb" data-id="'.$id.'">'.__d('Import').'</a></span> <strong><a href="http://themoviedb.org/tv/'.$id.'/" target="_blank">'.$name.'</a></strong> <i>('.$year.')</i>';
					}
					echo '</article>';
					$num++;
				}
				echo '</div>';
				echo '<a id="load_more_tmdb_link">'.__d('Next page').'</a>';
			}
		}
	die();
}

/* dbmovies.org status
-------------------------------------------------------------------------------
*/
function dbm_status() {
	if ( current_user_can('manage_options')) {
		if( isset($_POST['send-status-nonce'] ) and wp_verify_nonce($_POST['send-status-nonce'], 'send-status') ) { 
			// Resolver json Discover
			$api	= wp_remote_get( dbmurl. 'status/query');
			$json	= wp_remote_retrieve_body($api);
			$data	= json_decode($json, TRUE);
			// Resultados
			$status = $data['server'];
			$dbmovies = $data['dbmovies'];
			$imdb = $data['imdbscraper'];
			$tmdb = $data['themoviedb'];
			
			if($dbmovies >= '76') { $color = '#da3b3b'; }
			if($dbmovies <= '75') { $color = '#f68b1f'; }
			if($dbmovies < '50') { $color = '#9bca3e'; }
			if($imdb >= '76') { $color1 = '#da3b3b'; }
			if($imdb <= '75') { $color1 = '#f68b1f'; }
			if($imdb < '50') { $color1 = '#9bca3e'; }
			if($tmdb >= '76') { $color2 = '#da3b3b'; }
			if($tmdb <= '75') { $color2 = '#f68b1f'; }
			if($tmdb < '50') { $color2 = '#9bca3e'; }
			if($status == 'online') { 
			echo '
				<div class="skillbar clearfix" data-percent="'.$dbmovies.'%">
				<div class="skillbar-title"><span>dbmovies</span></div>
				<div class="skillbar-bar" style="background: '.$color.'"></div>
				<div class="skill-bar-percent">'.$dbmovies.'%</div>
				</div>

				<div class="skillbar clearfix" data-percent="'.$imdb.'%">
				<div class="skillbar-title"><span>imdbscraper</span></div>
				<div class="skillbar-bar" style="background: '.$color1.'"></div>
				<div class="skill-bar-percent">'.$imdb.'%</div>
				</div>

				<div class="skillbar clearfix" data-percent="'.$tmdb.'%">
				<div class="skillbar-title"><span>themoviedb</span></div>
				<div class="skillbar-bar" style="background: '.$color2.'"></div>
				<div class="skill-bar-percent">'.$tmdb.'%</div>
				</div>
				';
			}
		}
	}
	die();
}

/* Post Movies
-------------------------------------------------------------------------------
*/
function dbm_post_movie() {
	if( isset($_POST['send-movies-nonce'] ) and wp_verify_nonce($_POST['send-movies-nonce'], 'send-movies') ) { 
		if (current_user_can('manage_options')) {
			$key = tmdbkey;
			$lang = tmdblang;
			$idmovie = $_POST["idmovie"];
			if (($idmovie != NULL)) {
				$api_1 = wp_remote_get( tmdburl. "movie/" . $idmovie . "?append_to_response=images,trailers&language=" . $lang . "&include_image_language=" . $lang . ",null&api_key=" . $key . "");
				$json_1 = wp_remote_retrieve_body($api_1);
				$data = json_decode($json_1, TRUE);
				// ##########################################
				$imdb = $data['imdb_id'];
				$idtmdb = $data['id'];
				$api = wp_remote_get( imdbdata2 . $imdb );
				$jsonn = wp_remote_retrieve_body($api);
				$data1 = json_decode($jsonn, TRUE);
				// ##########################################
				$a4 = $data1['imdbRating'];
				$a5 = $data1['imdbVotes'];
				$a6 = $data1['Rated'];
				$a7 = $data1['Country'];
				// ##########################################
				$b1 = $data['runtime'];
				$b2 = $data['tagline'];
				$b3 = $data['title'];
				$b4 = $data['overview'];
				$b9 = $data['vote_count'];
				$b10 = $data['vote_average'];
				$b11 = $data['release_date'];
				$b12 = $data['original_title'];
				$a3 = substr($b11, 0, 4);
				$b13 = $data['poster_path'];
				if ($get_img = $data['poster_path'])
				{
					$upimg = 'https://image.tmdb.org/t/p/w396' . $get_img;
				}
				$b14 = $data['backdrop_path'];
				$b15 = $data['images']["backdrops"];
				$i = '0';
				foreach($b15 as $valor2) if ($i < 10) {
					$imgs.= $valor2['file_path'] . "\n";
					$i +=1;
				}
				$b16 = $data['genres'];
				$generos = array();
				foreach($b16 as $ci)
				{
					$generos[] = $ci['name'];
				}
				$b17 = 'mov'. DT_STRING_LINK. $data['id'];
				// ##########################################
				$api_2 = wp_remote_get( tmdburl. "movie/" . $idmovie . "/credits?append_to_response=images,trailers&language=" . $lang . "&include_image_language=" . $lang . ",null&api_key=" . $key . "");
				$json_2 = wp_remote_retrieve_body($api_2);
				$data2 = json_decode($json_2, TRUE);
				// ##########################################
				$c1 = $data2['cast'];
				$i = '0';
				foreach($c1 as $valor) if ($i < 10) {
					$actores.= $valor['name'] . ",";
					$i +=1;
				}
				$i = '0';
				foreach($c1 as $valor) if ($i < 10) {
					if ($valor['profile_path'] == NULL)
					{
						$valor['profile_path'] = "null";
					}
					$d_actores.= "[" . $valor['profile_path'] . ";" . $valor['name'] . "," . $valor['character'] . "]";
					$i +=1;
				}
				$c2 = $data2['crew'];
				foreach($c2 as $valorc)
				{
					$departamente = $valorc['department'];
					if ($valorc['profile_path'] == NULL)
					{
						$valorc['profile_path'] = "null";
					}
					if ($departamente == "Directing")
					{
						$d_dir.= "[" . $valorc['profile_path'] . ";" . $valorc['name'] . "]";
					}
					if ($departamente == "Directing")
					{
						$dir.= $valorc['name'] . ",";
					}
				}
				// ##########################################
				$api_3 = wp_remote_get( tmdburl. "movie/" . $idmovie . "/videos?append_to_response=images,trailers&language=" . $lang . "&include_image_language=" . $lang . ",null&api_key=" . $key);
				$json_3 = wp_remote_retrieve_body($api_3);
				$data3 = json_decode($json_3, TRUE);
				// ##########################################
				$d1 = $data3['results'];
				foreach($d1 as $yt)
				{
					$youtube.= "[" . $yt['key'] . "]";
					break;
				}
				// ##########################################

				$my_post = array(
					'post_title' => dt_clear($b3),
					'post_content' => dt_clear($b4),
					'post_date'     => $b11,
					'post_date_gmt' => $b11,
					'post_status' => 'publish',
					'post_type' => 'movies',
					'post_author' => 1
				);

				// vericador
				global $wpdb;
				$consulta = "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'ids' AND meta_value = '{$imdb}' ";
				$verificar = $wpdb->get_results( $consulta, OBJECT );
				if ($verificar) {
					echo '<strong>ERROR:</strong> '. __d('content already exists');
				} else {
					$post_id = wp_insert_post($my_post);
					echo '<span class="import_completed">'. __d('imported').'</span> <a href="'. esc_url( home_url() ) .'?p='. $post_id .'" target="_blank"><strong>'. $b3 .'</strong></a> ('. $a3 .')';
				}	
				wp_set_post_terms($post_id, $dir, 'dtdirector', false);
				wp_set_post_terms($post_id, $a3, 'dtyear', false);
				wp_set_post_terms($post_id, $actores, 'dtcast', false);
				wp_set_object_terms($post_id, $generos, 'genres', false);
				add_post_meta($post_id, "ids", ($imdb) , true);
				add_post_meta($post_id, "idtmdb", ($idtmdb) , true);
				add_post_meta($post_id, "dt_poster", ($b13) , true);
				add_post_meta($post_id, "dt_backdrop", ($b14) , true);
				add_post_meta($post_id, "imagenes", ($imgs) , true);
				add_post_meta($post_id, "youtube_id", ($youtube) , true);
				add_post_meta($post_id, "imdbRating", ($a4) , true);
				add_post_meta($post_id, "imdbVotes", ($a5) , true);
				add_post_meta($post_id, "Rated", ($a6) , true);
				add_post_meta($post_id, "Country", ($a7) , true);
				add_post_meta($post_id, "original_title", ($b12) , true);
				add_post_meta($post_id, "release_date", ($b11) , true);
				add_post_meta($post_id, "vote_average", ($b10) , true);
				add_post_meta($post_id, "vote_count", ($b9) , true);
				add_post_meta($post_id, "tagline", ($b2) , true);
				add_post_meta($post_id, "runtime", ($b1) , true);
				add_post_meta($post_id, "dt_string", ($b17) , true);
				add_post_meta($post_id, "dt_cast", ($d_actores) , true);
				add_post_meta($post_id, "dt_dir", ($d_dir) , true);
				dt_upload_image($upimg, $post_id);
			}	
		}
	} 
	die();
}

/* Post TV Shows
-------------------------------------------------------------------------------
*/
function dbm_post_tv() {
	if( isset($_POST['send-series-nonce'] ) and wp_verify_nonce($_POST['send-series-nonce'], 'send-series') ) { 
		if (current_user_can('manage_options')) {
			$key = tmdbkey;
			$lang = tmdblang;
			$slug = "/" . get_option('dt_tvshows_slug', 'tvshows');
			$ids = $_POST["idtv"];
			if (($ids != NULL)) {
				$urla = wp_remote_get( tmdburl. "tv/" . $ids . "?append_to_response=images,trailers&language=" . $lang . "&include_image_language=" . $lang . ",null&api_key=" . $key);
				$json2 = wp_remote_retrieve_body($urla);
				$data2 = json_decode($json2, TRUE);
				// ##########################################
				$name = $data2['name'];
				$tvid = $data2['id'];
				$episodes = $data2['number_of_episodes'];
				$seasons = $data2['number_of_seasons'];
				$year = substr($data2['first_air_date'], 0, 4);
				$date1 = $data2['first_air_date'];
				$date2 = $data2['last_air_date'];
				$overview = $data2['overview'];
				$popularidad = $data2['popularity'];
				$originalname = $data2['original_name'];
				$promedio = $data2['vote_average'];
				$votos = $data2['vote_count'];
				$tipo = $data2['type'];
				$web = $data2['homepage'];
				$status = $data2['status'];
				$poster = $data2['poster_path'];
				if ($get_img = $data2['poster_path']) {
					$upload_poster = 'https://image.tmdb.org/t/p/w396' . $get_img;
				}
				$backdrop = $data2['backdrop_path'];
				// Forech!
				$i = '0';
				$images = $data2['images']["backdrops"];
				foreach($images as $valor2) if ($i < 10) {
					$imgs.= $valor2['file_path'] . "\n";
					$i +=1;
				}

				$genres = $data2['genres'];
				$generos = array();
				foreach($genres as $ci) {
					$generos[] = $ci['name'];
				}
				$networks = $data2['networks'];
				foreach($networks as $co) {
					$redes.= $co['name'];
				}
				$studio = $data2['production_companies'];
				foreach($studio as $ht) {
					$estudios.= $ht['name'] . ",";
				}
				$creator = $data2['created_by'];
				foreach($creator as $cg) {
					$creador.= $cg['name'] . ",";
				}
				foreach($creator as $ag) {
					if ($ag['profile_path'] == NULL) {
						$ag['profile_path'] = "null";
					}
					$creador_d.= "[" . $ag['profile_path'] . ";" . $ag['name'] . "]";
				}
				$runtime = $data2['episode_run_time'];
				foreach($runtime as $tm) {
					$duracion.= $tm;
					break;
				}
				// ##########################################
				$urlb = wp_remote_get( tmdburl. "tv/" . $ids . "/credits?append_to_response=images,trailers&language=" . $lang . "&include_image_language=" . $lang . ",null&api_key=" . $key);
				$json3 = wp_remote_retrieve_body($urlb);
				$data3 = json_decode($json3, TRUE);
				// ##########################################
				$cast = $data3['cast'];
				$i = '0';
				foreach($cast as $valor) if ($i < 10) {
					$actores.= $valor['name'] . ",";
					$i +=1;
				}
				$i = '0';
				foreach($cast as $valor) if ($i < 10) {
					if ($valor['profile_path'] == NULL) {
						$valor['profile_path'] = "null";
					}
					$d_actores.= "[" . $valor['profile_path'] . ";" . $valor['name'] . "," . $valor['character'] . "]";
					$i +=1;
				}
				// ##########################################
				$urlc = wp_remote_get( tmdburl. "tv/" . $ids . "/videos?append_to_response=images,trailers&language=" . $lang . "&include_image_language=" . $lang . ",null&api_key=" . $key);
				$json4 = wp_remote_retrieve_body($urlc);
				$data4 = json_decode($json4, TRUE);
				// ##########################################
				$video = $data4['results'];
				foreach($video as $yt) {
					$youtube.= "[" . $yt['key'] . "]";
					break;
				}
				// ##########################################
				$my_post = array(
					'post_title' => dt_clear($name),
					'post_content' => dt_clear($overview),
					'post_status' => 'publish',
					'post_type' => 'tvshows',
					'post_date'     => $date1,
					'post_date_gmt' => $date1,
					'post_author' => 1
				);
				
				// vericador
				global $wpdb;
				$consulta = "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'ids' AND meta_value = '{$tvid}' ";
				$verificar = $wpdb->get_results( $consulta, OBJECT );
				if ($verificar) {
					echo '<strong>ERROR:</strong> '. __d('content already exists');
				} else {
					$post_id = wp_insert_post($my_post);
					echo '<span class="import_completed">'. __d('imported').'</span> <a href="'. esc_url( home_url() ) .'?p='. $post_id .'" target="_blank"><strong>'. $name .'</strong></a> ('. $year .')';
				}
				wp_set_post_terms($post_id, $year, 'dtyear', false);
				wp_set_object_terms($post_id, $generos, 'genres', false);
				wp_set_post_terms($post_id, $redes, 'dtnetworks', false);
				wp_set_post_terms($post_id, $estudios, 'dtstudio', false);
				wp_set_post_terms($post_id, $actores, 'dtcast', false);
				wp_set_post_terms($post_id, $creador, 'dtcreator', false);
				add_post_meta($post_id, "ids", ($tvid) , true);
				add_post_meta($post_id, "dt_poster", ($poster) , true);
				add_post_meta($post_id, "dt_backdrop", ($backdrop) , true);
				add_post_meta($post_id, "imagenes", ($imgs) , true);
				add_post_meta($post_id, "youtube_id", ($youtube) , true);
				add_post_meta($post_id, "first_air_date", ($date1) , true);
				add_post_meta($post_id, "last_air_date", ($date2) , true);
				add_post_meta($post_id, "number_of_episodes", ($episodes) , true);
				add_post_meta($post_id, "number_of_seasons", ($seasons) , true);
				add_post_meta($post_id, "original_name", ($originalname) , true);
				add_post_meta($post_id, "status", ($status) , true);
				add_post_meta($post_id, "imdbRating", ($promedio) , true);
				add_post_meta($post_id, "imdbVotes", ($votos) , true);
				add_post_meta($post_id, "episode_run_time", ($duracion) , true);
				add_post_meta($post_id, "dt_cast", ($d_actores) , true);
				add_post_meta($post_id, "dt_creator", ($creador_d) , true);
				dt_upload_image($upload_poster, $post_id);
			}
		}
	}
	die();
}

/* All actions
-------------------------------------------------------------------------------
*/
add_action('admin_menu', 'dbmovies_page');
add_action('admin_enqueue_scripts', 'dbmovies_assets');


/* Ajax actions
-------------------------------------------------------------------------------
*/
add_action('wp_ajax_dbm_status', 'dbm_status');
add_action('wp_ajax_dbm_get_movies', 'dbm_get_movies');
add_action('wp_ajax_dbm_get_tv', 'dbm_get_tv');
add_action('wp_ajax_dbm_post_movie', 'dbm_post_movie');
add_action('wp_ajax_dbm_post_tv', 'dbm_post_tv');

add_action('wp_ajax_nopriv_dbm_status', 'dbm_status');
add_action('wp_ajax_nopriv_dbm_get_movies', 'dbm_get_movies');
add_action('wp_ajax_nopriv_dbm_get_tv', 'dbm_get_tv');
add_action('wp_ajax_nopriv_dbm_post_movie', 'dbm_post_movie');
add_action('wp_ajax_nopriv_dbm_post_tv', 'dbm_post_tv');