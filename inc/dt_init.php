<?php


define	('DT_SERVER', 'http://nullrefer.com/?https://doothemes.com');
define	('DT_AUTOR', 'Doothemes');
define	('DT_RENOVAR', 'http://nullrefer.com/?https://doothemes.com/checkout/purchase-history/');
define	('DT_SUPPORT_FORUMS', 'http://nullrefer.com/?https://doothemes.com/forums/');
define	('DT_PAGE_THEME', 'http://nullrefer.com/?https://doothemes.com/dooplay/');
define	('DT_CHANGELOG', 'http://nullrefer.com/?https://doothemes.com/items/dooplay/?view=changelog');
define	('DT_DOC', 'http://nullrefer.com/?https://doothemes.com/forums/forum/17-dooplay/');
define	('DT_DICO', 'https://s2.googleusercontent.com/s2/favicons?domain=');
define	('dbmurl','https://api.dbmovies.org/');
define	('tmdburl','https://api.themoviedb.org/3/');
define	('imdbdata','https://api.dbmovies.org/dooplay/');
define	('imdbdata2','https://www.omdbapi.com/?i=');
define	('apigoorec','https://www.google.com/recaptcha/api/siteverify');
define	('tmdbkey', get_option('dt_api_key', '6b4357c41d9c606e4d7ebe2f4a8850ea'));
define	('tmdblang', get_option('dt_api_language', 'en-US'));


/* Echo translated text
-------------------------------------------------------------------------------
*/
function _d( $text ){
	echo translate($text , 'mtms');
}

/* Return Translated Text
-------------------------------------------------------------------------------
*/
function __d( $text ) {
    return translate($text, 'mtms');
}

/* Player flags
-------------------------------------------------------------------------------
*/
function dt_get_language() {
	$idiomas = array(
	__d('---------') => '',
	__d('Arabic') => 'ar',
	__d('Chinese') => 'cn',
	__d('Denmark') => 'dk',
	__d('Dutch') => 'nl',
	__d('English') => 'en',
	__d('English British') => 'gb',
	__d('Egypt') => 'egt',
	__d('French') => 'fr',
	__d('German') => 'de',
	__d('Indonesian') => 'id',
	__d('Hindi') => 'in',
	__d('Italian') => 'it',
	__d('Japanese') => 'jp',
	__d('Korean') => 'kr',
	__d('Philippines') => 'ph',
	__d('Portuguese Portugal') => 'pt',
	__d('Portuguese Brazil') => 'br',
	__d('Polish') => 'pl',
	__d('Romanian') => 'td',
	__d('Scotland') => 'sco',
	__d('Spanish Spain') => 'es',
	__d('Spanish Mexico') => 'mx',
	__d('Spanish Argentina') => 'ar',
	__d('Spanish Peru') => 'pe',
	__d('Spanish Chile') => 'pe',
	__d('Spanish Colombia') => 'co',
	__d('Sweden') => 'se',
	__d('Turkish') => 'tr',
	__d('Rusian') => 'ru',
	__d('Vietnam') => 'vn'
	);
	return $idiomas;
}

/* Search letter
-------------------------------------------------------------------------------
*/
add_filter('posts_search', 'search_title'); 
function search_title($search) { 
	preg_match('/title-([^%]+)/', $search, $m); 
	if (isset($m[1])) { 
		global $wpdb;
		if($m[1] == '09') return " AND $wpdb->posts.post_title REGEXP '^[0-9]' AND ($wpdb->posts.post_password = '') "; 
		return " AND $wpdb->posts.post_title LIKE '$m[1]%' AND ($wpdb->posts.post_password = '') "; 
	} else { 
		return $search; 
	} 
}


/* Register master categories
-------------------------------------------------------------------------------
*/
function genres_taxonomy() {
	register_taxonomy('genres', array('tvshows,movies',),
		array(
			'show_admin_column' => true, 
			'hierarchical'		=> true,
			'label'				=> __d('Genres'),
			'rewrite'			=> array ('slug' => get_option('dt_genre_slug','genre')),)
		);
}
add_action('init', 'genres_taxonomy', 0);
	function prefijo_mastercat() {
		flush_rewrite_rules();
	}
add_action('after_switch_theme', 'prefijo_mastercat');

function quality_taxonomy() {
	register_taxonomy('dtquality', array('episodes,movies'),
		array(
			'show_admin_column' => true, 
			'hierarchical'		=> true,
			'label'				=> __d('Quality'),
			'rewrite'			=> array ('slug' => get_option('dt_quality_slug','quality')),)
		);
}
add_action('init', 'quality_taxonomy', 0);

function dp_c() {
	flush_rewrite_rules();
}
add_action('after_switch_theme', 'dp_c');


/* Add admin css wp-login.php
-------------------------------------------------------------------------------
*/
add_action('admin_enqueue_scripts', 'load_admin_style');
      function load_admin_style() {
        wp_register_style('admin_css', DT_DIR_URI . '/assets/css/style-admin.css', false, DT_VERSION );
        wp_enqueue_style('admin_css', DT_DIR_URI . '/assets/css/style-admin.css', false, DT_VERSION );
       }
// logo admin
add_filter('login_headerurl', 'dt_url');
function dt_url($url) {
	return home_url();
}
function logo_admin() {  ?>
<style type="text/css">
h1 a {
background-image: url(<?php if($logo = get_option('dt_logo_admin')) { echo $logo; } else { echo DT_DIR_URI ."/assets/img/logo_dt.png"; } ?>) !important;
    background-size: 244px 52px !important;
    width: 301px !important;
    height: 52px !important;
    margin-bottom: 0!important;
}
body.login {
	background: #fff;
}
</style>
<?php  } 
add_action('login_head', 'logo_admin');



/* Count views
-------------------------------------------------------------------------------
*/
function set_dt_views($postID) {
	$count_key = 'dt_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '1');
	}else{
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}

/* Totals
-------------------------------------------------------------------------------
*/
function total_links_pendientes() {
	$s='';
	$totalj=wp_count_posts('dt_links')->pending;
	if($totalj!=1){
		$s='s';
	}
	return sprintf( __d("%s"),$totalj,$s);
}


function total_peliculas() {
	$s='';
	$totalj=wp_count_posts('movies')->publish;
	if($totalj!=1){
		$s='s';
	}
	return sprintf( __d("%s"),$totalj,$s);
}

function total_series() {
	$s='';
	$totalj=wp_count_posts('tvshows')->publish;
	if($totalj!=1){ 
		$s='s'; 
	}
	return sprintf( __d("%s"),$totalj,$s);
}

function total_episodios() {
	$s='';
	$totalj=wp_count_posts('episodes')->publish;
	if($totalj!=1){ 
		$s='s'; 
	}
	return sprintf( __d("%s"),$totalj,$s);
}

function total_temporadas() {
	$s='';
	$totalj=wp_count_posts('seasons')->publish;
	if($totalj!=1){ 
		$s='s'; 
	}
	return sprintf( __d("%s"),$totalj,$s);
}
define('dttp', get_option( DT_KEY ));


/* Get genres
-------------------------------------------------------------------------------
*/
function li_generos() {
	$taxonomy		= 'genres';
	$orderby		= 'DESC';
	$show_count		= 1;
	$hide_empty		= false;
	$pad_counts		= 0;
	$hierarchical	= 1;
	$exclude		= '55';
	$title			= '';
	$args = array(
	'post_type'		=> $post_type,
	'taxonomy'		=> $taxonomy,
	'orderby'		=> $orderby,
	'show_count'	=> $show_count,
	'hide_empty'	=> $hide_empty,
	'pad_counts'	=> $pad_counts,
	'hierarchical'	=> $hierarchical,
	'exclude'		=> $exclude,
	'title_li'		=> $title,
	'echo' => 0	
	);
$links = wp_list_categories($args);
$links = str_replace('</a> (', '</a> <i>', $links);
$links = str_replace(')', '</i>', $links);
echo $links; 
}

/* Get genres
-------------------------------------------------------------------------------
*/
function li_generos_h() {
	$taxonomy		= 'genres';
	$orderby		= 'DESC';
	$show_count		= 0;
	$hide_empty		= false;
	$pad_counts		= 0;
	$hierarchical	    = 1;
	$exclude			= '55';
	$title				= '';
	$args = array(
		'post_type'		=> $post_type,
		'taxonomy'		=> $taxonomy,
		'orderby'		=> $orderby,
		'show_count'	=> $show_count,
		'hide_empty'	=> $hide_empty,
		'pad_counts'	=> $pad_counts,
		'hierarchical'	=> $hierarchical,
		'exclude'		=> $exclude,
		'title_li'		=> $title,
		'echo' => 0	
	);
$links = wp_list_categories($args);
$links = str_replace('</a> (', '</a> <i>', $links);
$links = str_replace(')', '</i>', $links);
echo $links; 
}

/* Paginator
-------------------------------------------------------------------------------
*/
function pagination($pages = '', $range = 2) {  
     $showitems = ($range * 2)+1;  
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '') {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   
     if(1 != $pages)  {
         echo "<div class=\"pagination\"><span>". __d('Page') ." ".$paged." " . __d('of') . " ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "";
         if($paged > 1 && $showitems < $pages) echo "<a class='arrow_pag' href='".get_pagenum_link($paged - 1)."'><i class='icon-caret-left'></i></a>";
 
         for ($i=1; $i <= $pages; $i++) {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a class='arrow_pag' href=\"".get_pagenum_link($paged + 1)."\"><i class='icon-caret-right'></i></a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "";
         echo "</div>\n";
		 echo "<div class='resppages'>";
			previous_posts_link('<span class="icon-chevron-left"></span>');
			next_posts_link('<span class="icon-chevron-right"></span>');
		 echo "</div>";
     }
}

/* Create DT pages
-------------------------------------------------------------------------------
*/
if(is_admin() and current_user_can('administrator')){
	// Page trending
	$page_trending = get_option('dt_trending_page');
	if(empty($page_trending)){
		$post_id = wp_insert_post(array(		
		  'post_content'   => '',
		  'post_name'      => __d('Trending'),
		  'post_title'     => __d('Trending'),
		  'post_status'    => 'publish',
		  'post_type'      => 'page',
		  'ping_status'    => 'closed',
		  'post_date'      => date('Y-m-d H:i:s'),
		  'post_date_gmt'  => date('Y-m-d H:i:s'),
		  'comment_status' => 'closed',
		  'page_template'  => 'pages/trending.php'
		));
		$get_01 = get_option('siteurl').'/' . sanitize_title(__d('Trending')).'/';
		update_option('dt_trending_page', $get_01);
	}
	// Page Rating
	$page_rating = get_option('dt_rating_page');
	if(empty($page_rating)){
		$post_id = wp_insert_post(array(		
		  'post_content'   => '',
		  'post_name'      => __d('Ratings'),
		  'post_title'     => __d('Ratings'),
		  'post_status'    => 'publish',
		  'post_type'      => 'page',
		  'ping_status'    => 'closed',
		  'post_date'      => date('Y-m-d H:i:s'),
		  'post_date_gmt'  => date('Y-m-d H:i:s'),
		  'comment_status' => 'closed',
		  'page_template'  => 'pages/rating.php'
		));
		$get_02 = get_option('siteurl').'/' . sanitize_title(__d('Ratings')).'/';
		update_option('dt_rating_page', $get_02);
	}
	// Page Account
	$page_account = get_option('dt_account_page');
	if(empty($page_account)){
		$post_id = wp_insert_post(array(		
		  'post_content'   => __d('Edit page content.'),
		  'post_name'      => __d('My account'),
		  'post_title'     => __d('My account'),
		  'post_status'    => 'publish',
		  'post_type'      => 'page',
		  'ping_status'    => 'closed',
		  'post_date'      => date('Y-m-d H:i:s'),
		  'post_date_gmt'  => date('Y-m-d H:i:s'),
		  'comment_status' => 'closed',
		  'page_template'  => 'pages/account.php'
		));
		$get_03 = get_option('siteurl').'/' . sanitize_title(__d('My account')).'/';
		update_option('dt_account_page', $get_03);
	}
	// Page contact
	$page_contact = get_option('dt_contact_page');
	if(empty($page_contact)){
		$post_id = wp_insert_post(array(		
		  'post_content'   => '',
		  'post_name'      => __d('Contact'),
		  'post_title'     => __d('Contact'),
		  'post_status'    => 'publish',
		  'post_type'      => 'page',
		  'ping_status'    => 'closed',
		  'post_date'      => date('Y-m-d H:i:s'),
		  'post_date_gmt'  => date('Y-m-d H:i:s'),
		  'comment_status' => 'closed',
		  'page_template'  => 'pages/contact.php'
		));
		$get_05 = get_option('siteurl').'/' . sanitize_title(__d('Contact')).'/';
		update_option('dt_contact_page', $get_05);
	}

	// Posts page
	$page_posts = get_option('dt_posts_page');
	if(empty($page_posts)){
		$post_id = wp_insert_post(array(		
		  'post_content'   => '',
		  'post_name'      => __d('Blog'),
		  'post_title'     => __d('Blog'),
		  'post_status'    => 'publish',
		  'post_type'      => 'page',
		  'ping_status'    => 'closed',
		  'post_date'      => date('Y-m-d H:i:s'),
		  'post_date_gmt'  => date('Y-m-d H:i:s'),
		  'comment_status' => 'closed',
		  'page_template'  => 'pages/blog.php'
		));
		$get_posts_page = get_option('siteurl').'/' . sanitize_title(__d('Blog')).'/';
		update_option('dt_posts_page', $get_posts_page);
	}

	// TOP IMDb page
	$page_topimdb = get_option('dt_topimdb_page');
	if(empty($page_topimdb)){
		$post_id = wp_insert_post(array(		
		  'post_content'   => '',
		  'post_name'      => __d('TOP IMDb'),
		  'post_title'     => __d('TOP IMDb'),
		  'post_status'    => 'publish',
		  'post_type'      => 'page',
		  'ping_status'    => 'closed',
		  'post_date'      => date('Y-m-d H:i:s'),
		  'post_date_gmt'  => date('Y-m-d H:i:s'),
		  'comment_status' => 'closed',
		  'page_template'  => 'pages/topimdb.php'
		));
		$get_posts_page = get_option('siteurl').'/' . sanitize_title(__d('TOP IMDb')).'/';
		update_option('dt_topimdb_page', $get_posts_page);
	}

	// Generate Access Key
	function doothemes_key_access($length = 32) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	$doothemes_access = get_option('dbmovies_private_key');
	if(empty($doothemes_access)){
		update_option('dbmovies_private_key', doothemes_key_access());
	}
}


/* Text extract
-------------------------------------------------------------------------------
*/
function dt_content($more_link_text='(more...)', $stripteaser=0, $more_file='', $cut = 0, $encode_html = 0) {
	$content = get_the_content($more_link_text, $stripteaser, $more_file);
	$content = strip_shortcodes(apply_filters('the_content_rss', $content));
	if ( $cut && !$encode_html )
		$encode_html = 2;
	if ( 1== $encode_html ) {
		$content = esc_html($content);
		$cut = 0;
	} elseif ( 0 == $encode_html ) {
		$content = $content;
	} elseif ( 2 == $encode_html ) {
		$content = strip_tags($content);
	}
	if ( $cut ) {
		$blah = explode(' ', $content);
		if ( count($blah) > $cut ) {
			$k = $cut;
			$use_dotdotdot = 1;
		} else {
			$k = count($blah);
			$use_dotdotdot = 0;
		}
 for ( $i=0; $i<$k; $i++ )
			$excerpt .= $blah[$i].' ';
		$excerpt .= ($use_dotdotdot) ? '...' : '';
		$content = $excerpt;
	}
	$content = str_replace(']]>', ']]&gt;', $content);
	echo $content;
}

/* Generate release years
-------------------------------------------------------------------------------
*/
function dt_show_year() { 
	$args = array('order' => DESC ,'number' => 50); 
	$camel = 'dtyear'; 
	$tax_terms = get_terms($camel,$args); 
	foreach ($tax_terms as $tax_term) 
		{ echo '<li>' . '<a href="' . esc_attr(get_term_link($tax_term, $taxonomy)) . '">' . $tax_term->name.'</a></li>'; } 
	}


/* Active class
-------------------------------------------------------------------------------
*/
function dt_acpt($type) { 
	if(get_post_type() ==  $type) { echo 'class="active"'; }
}
function dt_acp($page) { 
	if(is_page($page)) { echo 'class="active"'; }
}

/* Get data
-------------------------------------------------------------------------------
*/
function data_of($name, $id, $acortado = false, $max = 150) {
    $val = get_post_meta($id, $name, $single = true);
    if ($val != NULL) {
        if ($acortado) {
            return substr($val, 0, $max) . '...';
        } else {
            return $val;
        }
    } else {
        if ($name == 'overview') {
            return "";
        } elseif ($name == 'temporada') {
            return "0";
        } else {
            return "--";
        }
    }
}

/* Get seasons
-------------------------------------------------------------------------------
*/
function season_of($meta) {
    global $wpdb;
    $results = $wpdb->get_results("select post_id, meta_key from $wpdb->postmeta where meta_value = '" . $meta . "'", ARRAY_A);
    $a_t     = array();
    $a_c     = array();
    foreach ($results as $i => $value) {
        if (get_post_type($results[$i]["post_id"]) == 'seasons' && get_post_status($results[$i]["post_id"]) == 'publish') {
            $a_t[] = array(
                'id' => $results[$i]["post_id"],
                'season' => get_post_meta($results[$i]["post_id"], "temporada", $single = true)
            );
        }
        if (get_post_type($results[$i]["post_id"]) == 'episodes' && get_post_status($results[$i]["post_id"]) == 'publish') {
            $a_c[] = array(
                'id' => $results[$i]["post_id"],
                'season' => get_post_meta($results[$i]["post_id"], "temporada", $single = true),
                'capitulo' => get_post_meta($results[$i]["post_id"], "episodio", $single = true)
            );
        }
    }
    if ((!empty($a_t)) && (!empty($a_c))) {
        foreach ($a_t as $key => $row) {
            $aux[$key] = $row['season'];
        }
        array_multisort($aux, SORT_ASC, $a_t);
        foreach ($a_c as $key => $row) {
            $aux1[$key] = $row['capitulo'];
        }
        array_multisort($aux1, SORT_ASC, $a_c);
        $counta   = 0;
        $finalcap = array();
        $maxt     = 0;
        foreach ($a_c as $key => $row) {
            $finalcap[] = array(
                'id' => $row['id'],
                'season' => $row['season'],
                'capitulo' => $row['capitulo']
            );
            if ($a_c[$key]["season"] >= $maxt) {
                $maxt = $a_c[$key]["season"];
            }
            $counta++;
        }
        $counti   = 0;
        $finalarr = array();
        foreach ($a_t as $key => $row) {
            $finalarr[] = array(
                'id' => $row['id'],
                'season' => $row['season']
            );
            $counti++;
        }
        $data = array(
            'temporada' => array(
                'l_temp' => array(
                    'id' => $finalarr[$counti - 1]['id'],
                    'numero' => $finalarr[$counti - 1]['season']
                ),
                'n_temp' => $counti,
                'all' => $finalarr,
                'd_temp' => $maxt
            ),
            'capitulo' => array(
                'n_cap' => $counta,
                'all' => $finalcap
            )
        );
        return $data;
    }
}

/* Get Links
-------------------------------------------------------------------------------
*/
function link_of($meta) {
    global $wpdb;
    $results = $wpdb->get_results("select post_id, meta_key from $wpdb->postmeta where meta_value = '" . $meta . "' ", ARRAY_A );
    $a_t     = array();
    $a_c     = array();
    foreach ($results as $i => $value ) {
        if (get_post_type($results[$i]["post_id"]) == 'dt_links' && get_post_status($results[$i]["post_id"]) == 'publish') {
            $a_t[] = array(
                'id' => $results[$i]["post_id"],
                'metalink' => get_post_meta($results[$i]["post_id"], "dt_string", $single = true)
            );
        }
        if (get_post_type($results[$i]["post_id"]) == 'episodes' && get_post_status($results[$i]["post_id"]) == 'publish') {
            $a_c[] = array(
                'id' => $results[$i]["post_id"],
                'metalink' => get_post_meta($results[$i]["post_id"], "dt_string", $single = true)
            );
        }
		if (get_post_type($results[$i]["post_id"]) == 'movies' && get_post_status($results[$i]["post_id"]) == 'publish') {
            $a_c[] = array(
                'id' => $results[$i]["post_id"],
                'metalink' => get_post_meta($results[$i]["post_id"], "dt_string", $single = true)
            );
        }
    }
    if ((!empty($a_t)) && (!empty($a_c))) {
        foreach ($a_t as $key => $row) {
            $aux[$key] = $row['metalink'];
        }
        array_multisort($aux, SORT_ASC, $a_t);

        $counta   = 0;
        $finalcap = array();
        $maxt     = 0;
        foreach ($a_c as $key => $row) {
            $finalcap[] = array(
                'id' => $row['id'],
                'metalink' => $row['metalink']
            );
            if ($a_c[$key]["metalink"] >= $maxt) {
                $maxt = $a_c[$key]["metalink"];
            }
            $counta++;
        }
        $counti   = 0;
        $finalarr = array();
        foreach ($a_t as $key => $row) {
            $finalarr[] = array(
                'id' => $row['id'],
                'metalink' => $row['metalink']
            );
            $counti++;
        }
        $data = array(
            'dt_string' => array(
                'l_temp' => array(
                    'id' => $finalarr[$counti - 1]['id'],
                    'numero' => $finalarr[$counti - 1]['season']
                ),
                'n_temp' => $counti,
                'all' => $finalarr,
                'd_temp' => $maxt
            )
           
        );
        return $data;
    }
}

/* Delete content
-------------------------------------------------------------------------------
*/
function wp_delete_post_link($link = 'Delete This', $before = '', $after = '') {
    global $post;
    if ( $post->post_type == 'page') {
    if ( !current_user_can('edit_page', $post->ID ) )
      return;
	} else {
	 if ( !current_user_can('edit_post', $post->ID ) )
     return;
  }
    $message = "Are you sure you want to delete ".get_the_title($post->ID)." ?";
    $delLink = wp_nonce_url( home_url() . "/wp-admin/post.php?action=delete&post=" . $post->ID, 'delete-post_' . $post->ID);
    $htmllink = "<a href='" . $delLink . "' onclick = \"if ( confirm('".$message."') ) { execute(); return true; } return false;\"/>".$link."</a>";
    echo $before . $htmllink . $after;
}

/* Key String
-------------------------------------------------------------------------------
*/
function key_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
define('DT_STRING',key_string());

/* Key String
-------------------------------------------------------------------------------
*/
function key_links_string($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
define('DT_STRING_LINK',key_links_string());

/* Get Domain
-------------------------------------------------------------------------------
*/
function saca_dominio($url){
    $protocolos = array('http://', 'https://', 'ftp://', 'www.');
    $url = explode('/', str_replace($protocolos, '', $url));
    return $url[0];
}

/* API domain validate
-------------------------------------------------------------------------------
*/
function dt_domain($url){
    $protocolos = array('http://', 'https://', 'ftp://', 'www.');
    $url = explode('/', str_replace($protocolos, '', $url));
	if($url[3]):
		return $url[0] .'/'. $url[1] .'/'. $url[2] .'/'. $url[3];
	elseif($url[2]):
		return $url[0] .'/'. $url[1] .'/'. $url[2];
	elseif($url[1]):
		return $url[0] .'/'. $url[1]; 
	else:
		return $url[0];
	endif;
}

/* Import data URL
-------------------------------------------------------------------------------
*/
function url_dt_import_data($url) {
    $protocolos = array('http://', 'https://', 'ftp://', 'www.');
    $url = explode('/', str_replace($protocolos, '', $url));
    return $url[2];
}

/* Get Images
-------------------------------------------------------------------------------
*/
function dt_image($name, $id, $size, $type = false, $return = false, $gtsml = false) {
    $img    = get_post_meta($id, $name, $single = true);
    $val    = explode("\n", $img);
    $mgsl = array();
    $count  = 0;
    foreach ($val as $valor) {
        if (!empty($valor)) {
            // if (substr($valor, 0, 1) == "/") {
            //     $mgsl[] = '/wp-content/' . $valor . '';
            // } else {
            //     $mgsl[] = $valor;
            // }
			$mgsl[] = $valor;
            $count++;
        } else {
            if ($name == "dt_poster" && $img == NULL) {
                $mgsl[] = esc_url( DT_DIR_URI ) . '/assets/img/no_poster.png';
            }
        }
    }

    if ($type) {
        $new = rand(0, $count);
        if ($mgsl[$new] != NULL) {
            if ($return) {
                return $mgsl[$new];
            } else {
                echo $mgsl[$new];
            }
        } else {
            if ($return) {
                return $mgsl[0];
            } else {
                echo $mgsl[0];
            }
        }
    } else {
        if ($return) {
            return $mgsl[0];
        } else {

			if($thumb_id = get_post_thumbnail_id()) { 
				$thumb_url = wp_get_attachment_image_src($thumb_id,'full', true); 
				echo $thumb_url[0]; 
			} else { 
				dt_image('dt_backdrop', $post->ID, 'original'); 
			}

			// if($mgsl[0] == NULL){
			// 	echo $mgsl[0];
			// }
			// else{
			// 	echo $mgsl[0];
			// }
        }
    }
}

/* Get Images search
-------------------------------------------------------------------------------
*/
function dt_image_search($name, $id, $size, $type = false, $return = false, $gtsml = false) {
    $img    = get_post_meta($id, $name, $single = true);
    $val    = explode("\n", $img);
    $mgsl = array();
    $count  = 0;
    foreach ($val as $valor) {
        if (!empty($valor)) {
            if (substr($valor, 0, 1) == "/") {
                $mgsl[] = 'https://image.tmdb.org/t/p/' . $size . '' . $valor . '';
            } else {
                $mgsl[] = $valor;
            }
            $count++;
        } else {
            if ($name == "dt_poster" && $img == NULL) {
                $mgsl[] = esc_url( DT_DIR_URI ) . '/assets/img/no_image_search.png';
            }
           
        }
    }
    if ($type) {
        $new = rand(0, $count);
        if ($mgsl[$new] != NULL) {
            if ($return) {
                return $mgsl[$new];
            } else {
                echo $mgsl[$new];
            }
        } else {
            if ($return) {
                return $mgsl[0];
            } else {
                echo $mgsl[0];
            }
        }
    } else {
        if ($return) {
            return $mgsl[0];
        } else {
            echo $mgsl[0];
        }
    }
}
define('DTGEMA','');

/* Get Cast
-------------------------------------------------------------------------------
*/
function dt_cast($id, $type, $limit = false) {
    $name = get_post_meta($id, "dt_cast", $single = true);
    if ($type == "img") {
        if ($limit) {
            $val    = explode("]", $name);
            $passer = $newvalor = array();
            foreach ($val as $valor) {
                if (!empty($valor)) {
                    $passer[] = substr($valor, 1);
                }
            }
            for ($h = 0; $h <= 4; $h++) {
                $newval     = explode(";", $passer[$h]);
                $fotoor     = $newval[0];
                $actorpapel = explode(",", $newval[1]);
                
                if (!empty($actorpapel[0])) {
                    
                    if ($newval[0] == "null") {
                        $fotoor = DT_DIR_URI . '/assets/img/no_foto_cast.png';
                    } else {
                        $fotoor = 'https://image.tmdb.org/t/p/w90' . $newval[0];
                    }
                    echo '<tr class="person">';
					echo '<td class="first_norole">';
                    echo '<div class="mask"><a href="'. home_url() .'/'. get_option('dt_cast_slug','cast') .'/' . sanitize_title($actorpapel[0]) . '/"><img alt="'. $actorpapel[0] .'" src="' . $fotoor . '" /></a></div>';
                    echo '<h3 class="name"><a href="'. home_url() .'/'. get_option('dt_cast_slug','cast') .'/' . sanitize_title($actorpapel[0]) . '/">' . $actorpapel[0] . '</a></h3>';
					echo '</td>';
					echo '<td class="last_norole">';
					echo '<h4 class="role">' . $actorpapel[1] . '</h4>';
					echo '</td>';
                    echo '</tr>';
                    
                }
            }
        } else {
            $val = str_replace(array(
                '[null',
                '[/',
                ';',
                ']',
                ","
            ), array(
                '<div class="castItem"><img src="' . DT_DIR_URI . '/assets/img/no_foto_cast.png',
                '<div class="castItem"><img src="https://image.tmdb.org/t/p/w90/',
                '" /><span>',
                '</span></div>',
                '</span><span class="typesp">'
            ), $name);
            echo $val;
        }
    } else {
        if (get_the_term_list($post->ID, 'dtcast', true)) {
            echo get_the_term_list($post->ID, 'dtcast', '', ', ', '');
        } else {
            echo "N/A";
        }
    }
}

/* Get Cast 2
-------------------------------------------------------------------------------
*/
function dt_cast_2($id, $type, $limit = false) {
    $name = get_post_meta($id, "dt_cast", $single = true);
    if ($type == "img") {
        if ($limit) {
            $val    = explode("]", $name);
            $passer = $newvalor = array();
            foreach ($val as $valor) {
                if (!empty($valor)) {
                    $passer[] = substr($valor, 1);
                }
            }
            for ($h = 0; $h <= 500; $h++) {
                $newval     = explode(";", $passer[$h]);
                $fotoor     = $newval[0];
                $actorpapel = explode(",", $newval[1]);
                
                if (!empty($actorpapel[0])) {
                    
                    if ($newval[0] == "null") {
                        $fotoor = DT_DIR_URI . '/assets/img/no_foto_cast.png';
                    } else {
                        $fotoor = 'https://image.tmdb.org/t/p/w90' . $newval[0];
                    }
                    echo '<div class="person">';
						echo '<div class="img"><a href="'. home_url() .'/'. get_option('dt_cast_slug','cast') .'/' . sanitize_title($actorpapel[0]) . '/"><img alt="'. $actorpapel[0] .' is'. $actorpapel[1] .'" src="' . $fotoor . '" /></a></div>';
						echo '<div class="data">';
							echo '<div class="name"><a href="'. home_url().'/'. get_option('dt_cast_slug','cast') .'/' . sanitize_title($actorpapel[0]) . '/">' . $actorpapel[0] . '</a></div>';
							echo '<div class="caracter">' . $actorpapel[1] . '</div>';
						echo '</div>';
                    echo '</div>';
                    
                }
            }
        } else {
            $val = str_replace(array(
                '[null',
                '[/',
                ';',
                ']',
                ","
            ), array(
                '<div class="castItem"><img src="' . DT_DIR_URI . '/assets/img/no_foto_cast.png',
                '<div class="castItem"><img src="https://image.tmdb.org/t/p/w90/',
                '" /><span>',
                '</span></div>',
                '</span><span class="typesp">'
            ), $name);
            echo $val;
        }
    } else {
        if (get_the_term_list($post->ID, 'dtcast', true)) {
            echo get_the_term_list($post->ID, 'dtcast', '', ', ', '');
        } else {
            echo "N/A";
        }
    }
}

/* Get director
-------------------------------------------------------------------------------
*/
function dt_director($id, $type, $limit = false) {
    $name = get_post_meta($id, "dt_dir", $single = true);
    if ($type == "img") {
        if ($limit) {
            $val    = explode("]", $name);
            $passer = $newvalor = array();
            foreach ($val as $valor) {
                if (!empty($valor)) {
                    $passer[] = substr($valor, 1);
                }
            }
            for ($h = 0; $h <= 0; $h++) {
                $newval = explode(";", $passer[$h]);
                $fotoor = $newval[0];
                if ($newval[0] == "null") {
                    $fotoor = DT_DIR_URI . '/assets/img/no_foto_cast.png';
                } else {
                    $fotoor = 'https://image.tmdb.org/t/p/w90' . $newval[0];
                }
					

					echo '<div class="person">';
						echo '<div class="img"><a href="'. home_url() .'/'. get_option('dt_director_slug','director') .'/' . sanitize_title($newval[1]) . '/"><img alt="'. $newval[1] .'" src="' . $fotoor . '" /></a></div>';
						echo '<div class="data">';
							echo '<div class="name"><a href="'. home_url() .'/'. get_option('dt_director_slug','director') .'/' . sanitize_title($newval[1]) . '/">' . $newval[1] . '</a></div>';
							echo '<div class="caracter">'.__d('Director').'</div>';
						echo '</div>';
					echo '</div>';

            }
        } 
    }
}

/* Get creator
-------------------------------------------------------------------------------
*/
function dt_creator($id, $type, $limit = false) {
    $name = get_post_meta($id, "dt_creator", $single = true);
    if ($type == "img") {
        if ($limit) {
            $val    = explode("]", $name);
            $passer = $newvalor = array();
            foreach ($val as $valor) {
                if (!empty($valor)) {
                    $passer[] = substr($valor, 1);
                }
            }
            for ($h = 0; $h <= 0; $h++) {
                $newval = explode(";", $passer[$h]);
                $fotoor = $newval[0];
                if ($newval[0] == "null") {
                    $fotoor = DT_DIR_URI . '/assets/img/no_foto_cast.png';
                } else {
                    $fotoor = 'https://image.tmdb.org/t/p/w90' . $newval[0];
                }
					
					echo '<div class="person">';
						echo '<div class="img"><a href="'. home_url() .'/'. get_option('dt_creator_slug','creator') .'/' . sanitize_title($newval[1]) . '/"><img alt="'. $newval[1] .'" src="' . $fotoor . '" /></a></div>';
						echo '<div class="data">';
							echo '<div class="name"><a href="'. home_url() .'/'. get_option('dt_creator_slug','creator') .'/' . sanitize_title($newval[1]) . '/">' . $newval[1] . '</a></div>';
							echo '<div class="caracter">'.__d('Creator').'</div>';
						echo '</div>';
					echo '</div>';
            } 
        } 
	} 
}

/* Module Shortcodes
-------------------------------------------------------------------------------
*/
include_once ( DT_DIR . '/inc/includes/static/links.php');
function module_slider() {  get_template_part('inc/parts/modules/slider'); } add_shortcode('module-slider', 'module_slider');
function module_slider_movies() {  get_template_part('inc/parts/modules/slider-movies'); } add_shortcode('module-slider-movies', 'module_slider_movies');
function module_slider_tvshows() {  get_template_part('inc/parts/modules/slider-tvshows'); } add_shortcode('module-slider-tvshows', 'module_slider_tvshows');
function module_movies() {  get_template_part('inc/parts/modules/movies'); } add_shortcode('module-movies', 'module_movies');
function module_tvshows() {  get_template_part('inc/parts/modules/tvshows'); } add_shortcode('module-tvshows', 'module_tvshows');
function module_seasons() {  get_template_part('inc/parts/modules/seasons'); } add_shortcode('module-seasons', 'module_seasons');
function module_episodes() {  get_template_part('inc/parts/modules/episodes'); } add_shortcode('module-episodes', 'module_episodes');
function module_ads_mt() {  get_template_part('inc/parts/modules/ads'); } add_shortcode('module-ads', 'module_ads_mt');
function module_blog() {  get_template_part('inc/parts/modules/blog'); } add_shortcode('module-list-entries-blog', 'module_blog');
function module_top_imdb() {  get_template_part('inc/parts/modules/top-imdb'); } add_shortcode('module-top-imdb', 'module_top_imdb');
function module_widget() {  get_template_part('inc/parts/modules/widgethome'); } add_shortcode('widgetgenre', 'module_widget');
function module_letter() {  get_template_part('inc/parts/modules/letter'); } add_shortcode('letter', 'module_letter');

/* WordPress Dashboard
-------------------------------------------------------------------------------
*/
add_action('dashboard_glance_items', 'cpad_at_glance_content_table_end');
function cpad_at_glance_content_table_end() {
    $args = array(
        'public' => true,
        '_builtin' => false
    );
    $output = 'object';
    $operator = 'and';
    $post_types = get_post_types( $args, $output, $operator );
    foreach ( $post_types as $post_type ) {
        $num_posts = wp_count_posts( $post_type->name );
        $num = number_format_i18n( $num_posts->publish );
        $text = _n( $post_type->labels->singular_name, $post_type->labels->name, intval( $num_posts->publish ) );
        if ( current_user_can('edit_posts') ) {
            $output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $num . ' ' . $text . '</a>';
            echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
        }
    }
}

/* API upload image
-------------------------------------------------------------------------------
*/
function dt_upload_image( $image_url, $post_id  ){
	$option = get_option('dt_api_upload_poster');
	global $wp_filesystem;
	if($option == 'true') {
		WP_Filesystem();
		$upload_dir		= wp_upload_dir();
		$imagex			= wp_remote_get($image_url);
		$image_data		= wp_remote_retrieve_body($imagex);
		$filename		= wp_basename($image_url);
		if(wp_mkdir_p($upload_dir['path']))    
			$file = $upload_dir['path'] . '/' . $filename;
		else                          
			$file = $upload_dir['basedir'] . '/' . $filename;
			$wp_filesystem->put_contents($file, $image_data, FS_CHMOD_FILE);
			$wp_filetype = wp_check_filetype($filename, null );
		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title' => sanitize_file_name($filename),
			'post_content' => '',
			'post_status' => 'inherit'
		);
		$attach_id = wp_insert_attachment($attachment, $file, $post_id);
		require_once( ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata($attach_id, $file);
		$res1= wp_update_attachment_metadata($attach_id, $attach_data );
		$res2= set_post_thumbnail($post_id, $attach_id);
	}
}

/* Images sizes
-------------------------------------------------------------------------------
*/
function imagenes_size() {
	add_theme_support('post-thumbnails');
	add_image_size('dt_poster_a', 185, 278, true);
	add_image_size('dt_poster_b', 90, 135, true);
	add_image_size('dt_episode_a', 300, 170, true);
}
add_action('after_setup_theme', 'imagenes_size'); 

/* Trailer / iframe
-------------------------------------------------------------------------------
*/
function mostrar_trailer_iframe($id) {
	if (!empty($id)) { 
		if(strpos($id, '[') !== false) {
			$val = str_replace(
					array("[","]",),
					array('<'. 'iframe' .' width="760" height="429" class="rptss" src="https://www.youtube.com/embed/','?rel=0&amp;controls=1&amp;showinfo=0&autoplay=1" frameborder="0" allowfullscreen></iframe>',),$id);
					echo $val;
		}
		elseif(strpos($id, 'sibeol.com') !== false){
			echo html_entity_decode($id);
		}
		else{
			//echo do_shortcode('[videoapi link="https://drive.google.com/open?id='.$id.'"]');
			//echo ('[videoapi link="https://drive.google.com/open?id='.$id.'"]');
		}
	
	}
}

/* Trailer / custom player
-------------------------------------------------------------------------------
*/
function mostrar_youtube($id) {
	if (!empty($id)) { 
	$val = str_replace(
		array("[","]",),
		array('<div class="dt_player_video" data-type="youtube" data-video-id="','"></div>',),$id);
		echo $val;
	} 
}

/* Get images
-------------------------------------------------------------------------------
*/
function dt_get_images($size, $id) {
    $img = get_post_meta($id, "imagenes", $single = true);
    $val    = explode("\n", $img);
    $passer = array();
    $cmw  = 0;
    foreach ($val as $valor) {
        if (!empty($valor)) {
            echo '<div class="g-item">';
            if (substr($valor, 0, 1) == "/") {
                echo '<img src="https://image.tmdb.org/t/p/'.$size.''.$valor.'" />';
            } else {
                echo '<img src="' . $valor . '" />';
            }
            echo '</div>';
            $cmw++;
            if ($cmw == 10) {
                break;
            }
        }
    }
}

function dt_get_youtubeimage($youtube) {
    echo '<div class="g-item">';
	echo '<img src="http://i3.ytimg.com/vi/'.$youtube.'/hqdefault.jpg" style="top:103px" />';
	echo '</div>';
}

/* Register menu navigation
-------------------------------------------------------------------------------
*/
function dt_menus() {
	$locations = array(
		'footer' => __d('Menu footer'),
		'header' => __d('Menu main header'),
	);
	register_nav_menus( $locations );
}
add_action('init', 'dt_menus');

/* Get user data
-------------------------------------------------------------------------------
*/
function username_show() { global $current_user; if ( isset($current_user) ) { echo $current_user->display_name; } }
function username_login() { global $current_user; if ( isset($current_user) ) { echo $current_user->user_login; } }
function email_show() { global $current_user; if ( isset($current_user) ) { echo $current_user->user_email; } }
function name1_show() { global $current_user; if ( isset($current_user) ) { echo $current_user->first_name; } }
function name2_show() { global $current_user; if ( isset($current_user) ) { echo $current_user->last_name; } }
function email_avatar_header() { global $current_user; if ( isset($current_user) ) { echo get_avatar( $current_user->user_email, 35 ); } }
function email_avatar_perfil() { global $current_user; if ( isset($current_user) ) { echo get_avatar( $current_user->user_email, 50 ); } }
function email_avatar_perfil_form() { global $current_user; if ( isset($current_user) ) { echo get_avatar( $current_user->user_email, 60 ); } }
function email_avatar_account() { global $current_user; if ( isset($current_user) ) { echo get_avatar( $current_user->user_email, 90 ); } }
function email_avatar_profile($user_id) { global $user_id; if ( isset($user_id) ) { echo get_avatar( $user_id->user_email, 90 ); } }

/* Additional fields
-------------------------------------------------------------------------------
*/
function social_networks_profile($profile_fields) {
	// Add new fields
	$profile_fields['dt_twitter']	= __d('Twitter URL');
	$profile_fields['dt_facebook']	= __d('Facebook URL');
	$profile_fields['dt_gplus']		= __d('Google+ URL');

	return $profile_fields;
}
add_filter('user_contactmethods', 'social_networks_profile');

/* desactivar emoji
-------------------------------------------------------------------------------
*/
if( get_option('dt_emoji_disable') == 'true') {
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
}

/* desactivar user toolbar
-------------------------------------------------------------------------------
*/
if( get_option('dt_toolbar_disable') == 'true') {
	add_filter('show_admin_bar', '__return_false');
}

/* Get post meta
-------------------------------------------------------------------------------
*/
function dt_get_meta( $value ) {
	global $post;
	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

/* Reset trending movies
-------------------------------------------------------------------------------
*/
function reset_movies() {
	global $wpdb;
	$query = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_parent = %d AND post_type = 'movies'", $parent_id);
	$children_ids = $wpdb->get_col($query);
	if (count($children_ids)) $wpdb->query($wpdb->prepare("UPDATE $wpdb->postmeta SET meta_value = %d WHERE meta_key = 'dt_views_count' AND post_id IN(" . implode(',', $children_ids) . ")", $example_integer));
}

/* Reset trending tvshows
-------------------------------------------------------------------------------
*/
function reset_tv() {
	global $wpdb;
	$query = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_parent = %d AND post_type = 'tvshows'", $parent_id);
	$children_ids = $wpdb->get_col($query);
	if (count($children_ids)) $wpdb->query($wpdb->prepare("UPDATE $wpdb->postmeta SET meta_value = %d WHERE meta_key = 'dt_views_count' AND post_id IN(" . implode(',', $children_ids) . ")", $example_integer));
}

/* Reset Rating
-------------------------------------------------------------------------------
*/
function reset_rating_avg() {
	global $wpdb;
	$query = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_parent = %d", $parent_id);
	$children_ids = $wpdb->get_col($query);
	if (count($children_ids)) $wpdb->query($wpdb->prepare("UPDATE $wpdb->postmeta SET meta_value = %d WHERE meta_key = '_starstruck_avg' AND post_id IN(" . implode(',', $children_ids) . ")", $example_integer));
}

/* Reset total rating
-------------------------------------------------------------------------------
*/
function reset_rating_total() {
	global $wpdb;
	$query = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_parent = %d", $parent_id);
	$children_ids = $wpdb->get_col($query);
	if (count($children_ids)) $wpdb->query($wpdb->prepare("UPDATE $wpdb->postmeta SET meta_value = %d WHERE meta_key = '_starstruck_total' AND post_id IN(" . implode(',', $children_ids) . ")", $example_integer));
}

/* Reset rating
-------------------------------------------------------------------------------
*/
function reset_rating_data() {
	global $wpdb;
	$query = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_parent = %d", $parent_id);
	$children_ids = $wpdb->get_col($query);
	if (count($children_ids)) $wpdb->query($wpdb->prepare("UPDATE $wpdb->postmeta SET meta_value = %d WHERE meta_key = '_starstruck_data' AND post_id IN(" . implode(',', $children_ids) . ")", $example_integer));
}


/* Register new user (complete function)
-------------------------------------------------------------------------------
*/
function dt_register_process()  {
	$noce = $_POST['add-nonce'];
	$adduser = $_POST['adduser'];
	if (isset($adduser) && isset($noce) && wp_verify_nonce($noce, 'add-user')) {
		// Error total en el nonce
		if (!wp_verify_nonce($noce, 'add-user')) {
			wp_die(__d('Sorry! That was secure, guess you\'re cheatin huh!'));
		} else {
			// revision Google Recaptcha
			get_template_part('inc/api/recaptchalib');
			$siteKey = GRC_PUBLIC;
			$secret = GRC_SECRET;
			$resp = null;
			$error = null;
			$reCaptcha = new ReCaptcha($secret);
			$recaptcha_response = $_POST["g-recaptcha-response"];
			$remote_addr = $_SERVER["REMOTE_ADDR"];
			if ($recaptcha_response ) {
				$resp = $reCaptcha->verifyResponse($remote_addr, $recaptcha_response );
			}
			if ($resp != null && $resp->success) {
				// Registrando datos de usuario
				$userdata = array(
					'user_pass' => $_POST['dt_password'],
					'user_login' => esc_attr($_POST['user_name']) ,
					'user_email' => esc_attr($_POST['email']) ,
					'role' => 'subscriber',
					'first_name' => $_POST['dt_name'],
					'last_name' => $_POST['dt_last_name'],
				);
				// setup some error checks
				if (!$userdata['user_login']) $error = __d('A username is required for registration.');
				elseif (username_exists($userdata['user_login'])) $error = __d('Sorry, that username already exists!');
				elseif (!is_email($userdata['user_email'], true)) $error = __d('You must enter a valid email address.');
				elseif (email_exists($userdata['user_email'])) $error = __d('Sorry, that email address is already used!');
				// setup new users and send notification
				else
				{
					$new_user = wp_insert_user($userdata);
					wp_new_user_notification($new_user, $user_pass);
					// etiquetas para el email.
					function dt_mail_tags($message) {
						$message = str_replace('{sitename}', get_bloginfo('name'), $message );
						$message = str_replace('{siteurl}', get_bloginfo('siteurl'), $message );
						$message = str_replace('{username}', $_POST['user_name'] , $message );
						$message = str_replace('{password}', $_POST['dt_password'] , $message );
						$message = str_replace('{email}', $_POST['email'] , $message );
						$message = str_replace('{first_name}', $_POST['dt_name'] , $message );
						$message = str_replace('{last_name}', $_POST['dt_last_name'] , $message );
						$message = apply_filters('dt_mail_tags', $message );
						return $message;
					}
					// componer mensaje
					$asunto = dt_mail_tags(__d('Welcome to {sitename}'));
					$message = dt_mail_tags(get_option('dt_welcome_mail_user'));
					wp_mail( $_POST['email'], $asunto , $message );
				}
			} else {
				$error = __d('Invalid code, please try again.');
			} // end recaptcha
		}
	}
	if ($new_user): ?>
	<div class="notice alert">
		<?php $user = get_user_by('id',$new_user); _d('Thank you for registering'); echo ' '. $user->user_login; ?>
	</div>
	<?php get_template_part('pages/sections/login-form'); else : ?>
		<?php if ( $error ) : ?>
			<div class="notice error"><?php echo $error; ?></div>
		<?php get_template_part('pages/sections/register-form'); endif; ?>
	<?php endif;
}
add_action('dt_register_form', 'dt_register_process');

/* Admin bar menu
-------------------------------------------------------------------------------
*/
add_action('admin_bar_menu', 'dooplay_admin_bar_menu', 99);
function dooplay_admin_bar_menu() {
   global $wp_admin_bar;
   $menus[] = array(
      'id' => 'dooplay',
      'title' => 'DooPlay',
      'href' => 'http://nullrefer.com/?https://doothemes.com/dooplay/',
      'meta' => array(
         'target' => 'blank',
		 'class' => 'dt_dooplay_menu'
      )
   );
	$menus[] = array(
      'id' => 'options',
      'parent' => 'dooplay',
      'title' => __d('Theme options'),
      'href' => get_admin_url().'themes.php?page=dooplay'
   
   );
	$menus[] = array(
      'id' => 'license',
      'parent' => 'dooplay',
      'title' => __d('License'),
      'href' => get_admin_url().'themes.php?page=dooplay-license'
   
   );
   $menus[] = array(
      'id' => 'support',
      'parent' => 'dooplay',
      'title' => __d('Support'),
      'href' => 'http://nullrefer.com/?https://doothemes.com/forums/',
      'meta' => array(
         'target' => 'blank'
      )
   );
   $menus[] = array(
      'id' => 'changelog',
      'parent' => 'dooplay',
      'title' => __d('Changelog'),
      'href' => DT_CHANGELOG,
      'meta' => array(
         'target' => 'blank'
      )
   );
   foreach ( apply_filters('render_webmaster_menu', $menus ) as $menu )
       $wp_admin_bar->add_menu( $menu );
}
 
/* Share links in single
-------------------------------------------------------------------------------
*/
function links_social_single($id) { $count = get_post_meta( $id, 'dt_social_count', true); ?>
<div class="dt_social_single">
	<span><?php _d('Shared'); ?> <b id="social_count"><?php if($count >= 1 ) { echo comvert_number($count); } else { echo '0'; } ?></b></span>
	<a data-id="<?php echo $id; ?>" href="javascript: void(0);" onclick="window.open ('https://facebook.com/sharer.php?u=<?php the_permalink() ?>', 'Facebook', 'toolbar=0, status=0, width=650, height=450');" class="facebook dt_social">
		<i class="icon-facebook"></i> <b><?php _d('Facebook'); ?></b>
	</a>

	<a data-id="<?php echo $id; ?>" href="javascript: void(0);" onclick="window.open ('https://twitter.com/intent/tweet?text=<?php the_title(); ?>&amp;url=<?php the_permalink() ?>', 'Twitter', 'toolbar=0, status=0, width=650, height=450');" data-rurl="<?php the_permalink() ?>" class="twitter dt_social">
		<i class="icon-twitter"></i> <b><?php _d('Twitter'); ?></b>
	</a>

	<a data-id="<?php echo $id; ?>" href="javascript: void(0);" onclick="window.open ('https://plus.google.com/share?url=<?php the_permalink() ?>', 'Google', 'toolbar=0, status=0, width=650, height=450');" class="google dt_social">
		<i class="icon-google-plus2"></i>
	</a>

	<a data-id="<?php echo $id; ?>" href="javascript: void(0);" onclick="window.open ('https://pinterest.com/pin/create/button/?url=<?php the_permalink() ?>&amp;media=<?php dt_image('dt_backdrop', $id, 'w600'); ?>&amp;description=<?php the_title(); ?>', 'Pinterest', 'toolbar=0, status=0, width=650, height=450');" class="pinterest dt_social">
		<i class="icon-pinterest-p"></i>
	</a>

	<a data-id="<?php echo $id; ?>" href="whatsapp://send?text=<?php the_title(); ?>%20-%20<?php the_permalink() ?>" class="whatsapp dt_social">
		<i class="icon-whatsapp"></i>
	</a>
</div>
<?php } 

/* FB Images
-------------------------------------------------------------------------------
*/
function fbimage($size, $id) {
    $img = get_post_meta($id, "imagenes", $single = true);
    $val    = explode("\n", $img);
    $passer = array();
    $cmw  = 0;
    foreach ($val as $valor) {
        if (!empty($valor)) {
            if (substr($valor, 0, 1) == "/") {
                echo "	<meta property='og:image' content='https://image.tmdb.org/t/p/".$size."".$valor."' />\n";
            } else {
                echo "	<meta property='og:image' content='" . $valor . "' />\n";
            }
            $cmw++;
            if ($cmw == 10) {
                break;
            }
        }
    }
}

/* Date post
-------------------------------------------------------------------------------
*/
function dt_post_date($format = false, $echo = true) {
	if( ! is_string( $format ) || empty($format) ) {
		$format = 'F j, Y';
	}
	$date = sprintf( __d('%1$s') , get_the_time($format) );
	if( $echo ){
		echo $date;
	} else {
		return $date;
	}
}

/* Youtube  video Shortcode
-------------------------------------------------------------------------------
*/
function youtube_embed($atts, $content = null) {
   extract(shortcode_atts(array('id' => 'idyoutube'), $atts));
	return '<div class="video"><'. $bxc .'iframe width="560" height="315" src="https://www.youtube.com/embed/'. $id . '" frameborder="0" allowfullscreen></iframe></div>';
}

/* Vimeo video Shortcode
-------------------------------------------------------------------------------
*/
function vimeo_embed($atts, $content = null) {
   extract(shortcode_atts(array('id' => 'idyoutube'), $atts));
	return '<div class="video"><'. $bxc .'iframe width="560" height="315" src="https://player.vimeo.com/video/'. $id . '" frameborder="0" allowfullscreen></iframe></div>';
}

/* Imdb video Shortcode
-------------------------------------------------------------------------------
*/
function imdb_embed($atts, $content = null) {
   extract(shortcode_atts(array('id' => 'idyoutube'), $atts));
	return '<div class="video"><'. $bxc .'iframe width="640" height="360" src="http://www.imdb.com/video/imdb/'. $id . '/imdb/embed?autoplay=false&width=640" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true" frameborder="no" scrolling="no"></iframe></div>';
}

/*  Register video Shortcodes
-------------------------------------------------------------------------------
*/
add_shortcode('youtube', 'youtube_embed');
add_shortcode('vimeo', 'vimeo_embed');
add_shortcode('imdb', 'imdb_embed');

/* Get IP
-------------------------------------------------------------------------------
*/
 function get_client_ip() {
      $ipaddress = '';
      if (getenv('HTTP_CLIENT_IP'))
          $ipaddress = getenv('HTTP_CLIENT_IP');
      else if(getenv('HTTP_X_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
      else if(getenv('HTTP_X_FORWARDED'))
          $ipaddress = getenv('HTTP_X_FORWARDED');
      else if(getenv('HTTP_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_FORWARDED_FOR');
      else if(getenv('HTTP_FORWARDED'))
          $ipaddress = getenv('HTTP_FORWARDED');
      else if(getenv('REMOTE_ADDR'))
          $ipaddress = getenv('REMOTE_ADDR');
      else
          $ipaddress = 'UNKNOWN';
      return $ipaddress;
 }
 function gm_mtps() {

	update_option('dt_noti', 'true');
}

/* Verify content duplicate
-------------------------------------------------------------------------------
*/
function dt_duplicate_scripts( $hook ) {
    if( !in_array( $hook, array('post.php', 'post-new.php' , 'edit.php'))) return;
    wp_enqueue_script('duptitles',
    wp_enqueue_script('duptitles',DT_DIR_URI.'/assets/js/dt_duplicate.js',
    array('jquery')), array('jquery')  );
}
add_action('admin_enqueue_scripts', 'dt_duplicate_scripts', 2000 );
add_action('wp_ajax_dt_duplicate', 'dt_duplicate_callback');

/* callback ajax  duplicate content
-------------------------------------------------------------------------------
*/
function dt_duplicate_callback() {
	function dt_results_checks() {
		global $wpdb;
		$title = $_POST['post_title'];
		$post_id = $_POST['post_id'];
		$titles = "SELECT post_title FROM $wpdb->posts WHERE post_status = 'publish' AND post_title = '{$title}' AND ID != {$post_id} ";
		$results = $wpdb->get_results($titles);
		if($results) {
			return '<div class="error"><p><span style="color:#dc3232;" class="dashicons dashicons-warning"></span> '. __d('This content already exists, we recommend not to publish.'  ) .' </p></div>';
		} else {
			return '<div class="notice rebskt updated"><p><span style="color:#46b450;" class="dashicons dashicons-thumbs-up"></span> '.__d('Excellent! this content is unique.').'</p></div>';
		}  
	}		
	echo dt_results_checks();
	die();
}

/* Disable auto save
-------------------------------------------------------------------------------
*/
function dt_disable_autosave() {
	wp_deregister_script('autosave') ;
}
add_action('wp_print_scripts', 'dt_disable_autosave') ;

/* Clear text
-------------------------------------------------------------------------------
*/
function dt_clear($text) {
	return wp_strip_all_tags(html_entity_decode($text));
}

/* Verify nonce
-------------------------------------------------------------------------------
*/
function dooplay_verify_nonce( $id, $value ) {
    $nonce = get_option( $id );
    if( $nonce == $value )
        return true;
    return false;
}

/* Create nonce
-------------------------------------------------------------------------------
*/
function dooplay_create_nonce( $id ) {
    if( ! get_option( $id ) ) {
        $nonce = wp_create_nonce( $id );
        update_option( $id, $nonce );
    }
    return get_option( $id );
}

/* Search API URL
-------------------------------------------------------------------------------
*/
function dooplay_url_search() {
	return rest_url('/dooplay/search/');
}

/* Search Register API
-------------------------------------------------------------------------------
*/
function wpc_register_wp_api_search() {
	register_rest_route('dooplay', '/search/', array(
        'methods' => 'GET',
        'callback' => 'dooplay_live_search',
    ));
}
add_action('rest_api_init', 'wpc_register_wp_api_search');

/* Search exclude
-------------------------------------------------------------------------------
*/
add_filter('register_post_type_args',function($args, $post_type) { if(!is_admin() && $post_type=='page') { $args['exclude_from_search']=true; } return $args; }, 10, 2);
add_filter('register_post_type_args',function($args, $post_type) { if(!is_admin() && $post_type=='post') { $args['exclude_from_search']=true; } return $args; }, 10, 2);

/* Short numbers
-------------------------------------------------------------------------------
*/
function comvert_number($input){
    $input = number_format($input);
    $input_count = substr_count($input, ',');
    if($input_count != '0'){
        if($input_count == '1'){
            return substr($input, 0, -4).'K';
        } else if($input_count == '2'){
            return substr($input, 0, -8).'MIL';
        } else if($input_count == '3'){
            return substr($input, 0,  -12).'BIL';
        } else {
            return;
        }
    } else {
        return $input;
    }
}

/* Collections items
-------------------------------------------------------------------------------
*/
function dt_list_items($user_id, $type, $count) {
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array(
	  'paged' => $paged,
	  'numberposts' => -1,
	  'orderby' => 'date',
	  'order'   => 'DESC',
	  'post_type' => $type,
	  'posts_per_page' => $count,
	  'meta_query' => array (
		array (
		  'key' => '_user_liked',
		  'value' => $user_id,
		  'compare' => 'LIKE'
		)
	  ) );		
	$sep = '';
	$list_query = new WP_Query( $args );
	if ( $list_query->have_posts() ) : while ( $list_query->have_posts() ) : $list_query->the_post();
		 get_template_part('inc/parts/simple_item');  
	endwhile;
	else :
	echo '<div class="no_fav">'. __d('No content available on your list.'). '</div>';
	endif; wp_reset_postdata(); 
}

/* Links Account
-------------------------------------------------------------------------------
*/
function dt_links_account($user_id, $count) {
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array(
	  'paged' => $paged,
	  'orderby' => 'date',
	  'order'   => 'DESC',
	  'post_type' => 'dt_links',
	  'posts_per_page' => $count,
	  'post_status' => array('pending', 'publish', 'trash'),
	  'author' => $user_id,
	  );		
	$list_query = new WP_Query( $args );
	if ( $list_query->have_posts() ) : while ( $list_query->have_posts() ) : $list_query->the_post();
		 get_template_part('inc/parts/item_links'); 
	endwhile;
	else :
	echo '<tr><td>-</td><td>-</td><td class="views">-</td><td class="status">-</td><td>-</td></tr>';
	endif; wp_reset_postdata();
}

/* Links profile
-------------------------------------------------------------------------------
*/
function dt_links_profile($user_id, $count) {
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array(
	  'paged' => $paged,
	  'orderby' => 'date',
	  'order'   => 'DESC',
	  'post_type' => 'dt_links',
	  'posts_per_page' => $count,
	  'post_status' => array('pending', 'publish', 'trash'),
	  'author' => $user_id,
	  );		
	$list_query = new WP_Query( $args );
	if ( $list_query->have_posts() ) : while ( $list_query->have_posts() ) : $list_query->the_post();
		 get_template_part('inc/parts/item_links_profile'); 
	endwhile;
	else :
	echo '<tr><td>-</td><td>-</td><td class="views">-</td><td class="status">-</td><td>-</td><td>-</td><td>-</td></tr>';
	endif; wp_reset_postdata();
}

/* Pending Links Account
-------------------------------------------------------------------------------
*/
function dt_links_pending($count) {
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array(
	  'paged' => $paged,
	  'orderby' => 'date',
	  'order'   => 'DESC',
	  'post_type' => 'dt_links',
	  'posts_per_page' => $count,
	  'post_status' => array('pending'),
	  );		
	$list_query = new WP_Query( $args );
	if ( $list_query->have_posts() ) : while ( $list_query->have_posts() ) : $list_query->the_post();
		 get_template_part('inc/parts/item_links_admin'); 
	endwhile;
	else :
	echo '<tr><td>-</td><td>-</td><td>-</td><td class="views">-</td><td class="status">-</td><td>-</td></tr>';
	endif; wp_reset_postdata();
}


/* Jetpack compatibilidad
-------------------------------------------------------------------------------
*/
function compatibilidad_publicize() {
    add_post_type_support('movies', 'publicize');
    add_post_type_support('tvshows', 'publicize');
    add_post_type_support('seasons', 'publicize');
    add_post_type_support('episodes', 'publicize');
}
add_action('init', 'compatibilidad_publicize');

/* Definir Slug Author
-------------------------------------------------------------------------------
*/
function dt_author_base() {
	$userlink = get_option('dt_author_slug');
    global $wp_rewrite;  
    $author_slug = $userlink;
    $wp_rewrite->author_base = $author_slug;  
}  
add_action('init', 'dt_author_base');


/* Form login
-------------------------------------------------------------------------------
*/
function dt_login_form( $args = array() ) {
	$echo = true;
	$redirect = ( is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$register = get_option('dt_account_page'). '?action=sign-in';
	$action = esc_url( site_url('wp-login.php', 'login_post') );
	$lostpassword = esc_url( site_url('wp-login.php?action=lostpassword', 'login_post') );
    $form = '
	<div class="login_box">	
		<div class="box">
			<a id="c_loginbox"><i class="icon-close2"></i></a>
			<h3>'. __d('Login to your account').'</h3>
			<form method="post" action="' . $action . '">
				<fieldset class="user"><input type="text" name="log" placeholder="'. __d('Username').'"></fieldset>
				<fieldset class="password"><input type="password" name="pwd" placeholder="'. __d('Password'). '"></fieldset>
				<label><input name="rememberme" type="checkbox" id="rememberme" value="forever">  '.__d('Remember Me').'</label>
				<fieldset class="submit"><input type="submit" value="'. __d('Log in'). '"></fieldset>
				<a class="register" href="'.$register.'">'. __d('Register a new account') .'</a>
				<label><a class="pteks" href="'.$lostpassword.'">'.__d('Lost your password?').'</a></label>
				<input type="hidden" name="redirect_to" value="'. $redirect .'">
			</form>
		</div>
	</div>
	';
	if ( $echo )
        echo $form;
    else
		return $form;
}

/* Taxnomy count
-------------------------------------------------------------------------------
*/
function dt_count_taxonomy($id) {
    $args = array(
      'post_type' => array('tvshows','movies'), 
      'post_status' => 'publish', 
      'posts_per_page' => -1, 
      'tax_query' => array('relation' => 'AND', array('taxonomy' => 'genres','field' => 'slug','terms' => array( $id )))
    );
    $query = new WP_Query( $args);
    return (int)$query->post_count;
}
