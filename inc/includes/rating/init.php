<?php
/* 
* -------------------------------------------------------------------------------------
* @author: AppThemes
* @author URI: https://marketplace.appthemes.com/plugins/starstruck/
* @copyright: (c) 2017 AppThemes. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 1.2.0 
*
*/
define('STARSTRUCK_VERSION', '10.0.0.0');
define('STARSTRUCK_PATH', plugins_url('', __FILE__ ) );
define('STARSTRUCK_KEY', '_starstruck_data');
define('STARSTRUCK_AVG_KEY', '_starstruck_avg');
define('STARSTRUCK_TOTAL_KEY', '_starstruck_total');
define('STARSTRUCK_STARS', 10 );
$starstruck_options = array( 
	#'disable_anonymous' => '1',
	'enable_movies' => '1', 
	'enable_tvshows' => '1', 
	'enable_seasons' => '1', 
	'enable_episodes' => '1'
	);
get_template_part('inc/includes/rating/shortcodes');
### Hooks
add_action('init', 'starstruck_set_cookie');
add_action('plugins_loaded', 'starstruck_load_textdomain');
add_action('wp_enqueue_scripts', 'starstruck_load_scripts');
add_action('wp_enqueue_scripts', 'starstruck_dynamic_styles');
add_action('wp_ajax_starstruck_action', 'starstruck_action_callback');
add_action('wp_ajax_nopriv_starstruck_action', 'starstruck_action_callback');
add_action('wp_ajax_starstruck_delete_action', 'starstruck_delete_action_callback');
add_action('wp_ajax_nopriv_starstruck_delete_action', 'starstruck_delete_action_callback');
add_filter('plugin_action_links_' . plugin_basename( __FILE__ ), 'starstruck_action_links', 10, 2 );
add_filter('comment_text', 'starstruck_comment_display', 9999 );
// Classipress.
add_filter('cp_get_content_preview', 'starstruck_post_display', 15 );
// Vantage.
add_action('starstruck_microdata', 'starstruck_va_event_microdata');
### Callbacks & Helpers
function starstruck_plugin_activate() {
	if ( get_option('starstruck_plugin_activate') == true ) {
		return;
	}
	add_option('starstruck_plugin_activate', true );
	$starstruck_options = array(
		'enable_post' => '1',
		'star_color'  => '#ffe203',
	);
	update_option( STARSTRUCK_OPTIONS, $starstruck_options );
}
register_activation_hook( __FILE__, 'starstruck_plugin_activate');

function starstruck_wp_trim_words( $text, $num_words, $more, $original_text ) {
	$text = starstruck_strip_ss_markup( $text, $original_text  );
	remove_filter('wp_trim_words', 'starstruck_wp_trim_words', 10, 4 );
	$text = wp_trim_words( $text );

	return $text;
}
function starstruck_action_links( $links ) {
	$action_links = array(
		'settings' => '<a href="' . admin_url('options-general.php?page=stars-rating') . '" title="' . esc_attr( __d('View Starstruck Settings') ) . '">' . __d('Settings') . '</a>',
	);
	return array_merge( $action_links, $links );
}
function starstruck_set_cookie() {
	global $user_ID;
	if ( $user_ID > 0 ) {
		return;
	}
	if ( ! isset( $_COOKIE['starstruck_'.COOKIEHASH] ) ) {
		setcookie('starstruck_' . COOKIEHASH, md5( uniqid(mt_rand(), true) ), time() + 31536000, COOKIEPATH, COOKIE_DOMAIN ); // expires in one year
	}
}
function starstruck_load_scripts() {
	global $starstruck_options;
	if (is_singular()) {
		wp_enqueue_script('jquery-raty', get_template_directory_uri(). '/assets/js/raty.js', '', DT_VERSION );
		wp_enqueue_script('starstruck-js', get_template_directory_uri(). '/assets/js/ratings.js', array('jquery-raty'), DT_VERSION );
		wp_localize_script('starstruck-js', 'ss_l18n', starstruck_l18n() );
	}
}
function starstruck_l18n() {
	global $starstruck_options;

	$more_options = array(
		'require_login' => starstruck_require_user_login(),
		'nonce'         => wp_create_nonce('starstruck-nonce'),
		'url'           => admin_url('admin-ajax.php', 'relative'),
	);

	return array_merge( $starstruck_options, $more_options );
}
function starstruck_dynamic_styles() {
	global $starstruck_options;
	ob_start();
?>
<?php
	$output = ob_get_clean();
	wp_add_inline_style('starstruck', $output );
}
function starstruck_post_display( $content = '', $args = '') {
	global $post, $starstruck_options;

	if ( ! isset( $starstruck_options['enable_non_singular'] ) ) {
		if ( ! is_singular() || ! is_single() ) {
			return $content;
		}
	}
	if ( is_admin() || starstruck_is_author() ) {
		return $content;
	}

	if ( ! $args ) {
		$item = get_post_type();
	} else {
		if ( is_array( $args ) ) {
			$item = key( $args );
		} else {
			$item = $args;
		}
	}

	if ( empty( $starstruck_options["enable_$item"] ) ) {
		return $content;
	}
	add_filter('wp_trim_words', 'starstruck_wp_trim_words', 10, 4 );
	$data    = get_post_meta( $post->ID, STARSTRUCK_KEY, true );
	$content = starstruck_return_content( $data, $content, $post->ID, 'post');
	$content = apply_filters('starstruck_content', $content, $data );
	return $content;
}
function starstruck_comment_display( $content ) {
	global $comment, $starstruck_options;

	if ( ! isset( $starstruck_options['enable_comment'] ) ) {
		return $content;
	}

	if ( is_admin() ) {
		return $content;
	}

	$data    = get_comment_meta( $comment->comment_ID, STARSTRUCK_KEY, true );

	$content = starstruck_return_content( $data, $content, $comment->comment_ID, 'comment');

	return apply_filters('starstruck_comment', $content, $data );
}
function starstruck_is_author() {
	$conditional_tag = starstruck_get_theme_conditional_tag('author');
	if ( ! empty( $conditional_tag['callback'] ) && call_user_func( $conditional_tag['callback'], $conditional_tag['params'] ) ) {
		return true;
	}
	return is_author();
}
function starstruck_return_content( $data, $content, $id, $type ) {

	$your_rating = __d('0');

	if ( $data = maybe_unserialize( $data ) ) {
		$rating = $data['avg'];
		$votes  = $data['votes'];
		$user_info = starstruck_user_object();
		if ( array_key_exists( $user_info->ID, $data['users'] ) ) {
			$your_rating = $data['users'][$user_info->ID][0];
		}
	} else {
		$rating = 0;
		$votes = 0;
	}
	ob_start();
	$template = apply_filters('starstruck_template', 'content.php', 'content');
	include $template;
	$content .= ob_get_clean();
	return $content;
}
function starstruck_return_content_span( $id, $rating, $type, $class = 'starstruck-main') {
	return '<div class="starstruck ' . esc_attr( $class ) .' " data-id="' . esc_attr( $id ) . '" data-rating="' .esc_attr( $rating ) . '" data-type="' .esc_attr( $type ) . '"></div>';
}
function starstruck_update_db( $data, $id, $type, $score ) {
	global $starstruck_options;
	$user_info = starstruck_user_object();
	$date_time = current_time('mysql');
	if ( ! empty( $starstruck_options['enable_half_stars'] ) ) {
		$keys = array('0.5', '1', '1.5', '2', '2.5', '3', '3.5', '4', '4.5', '5');
		$stars = array_fill_keys( $keys, 0 );
	} else {
		$stars = array_fill( 1, STARSTRUCK_STARS, 0 );
	}
		if ( $data ) {
			$data = maybe_unserialize( $data );
			if ( array_key_exists( $user_info->ID, $data['users'] ) ) {
				$old_score = $data['users'][$user_info->ID][0];

				if ( ! empty( $data['stars']["$old_score"] ) ) {
					$data['stars']["$old_score"] -= 1;
				}

				$data['users'][$user_info->ID] = array( $score, $user_info->display_name, $date_time );
			} else {
				$data['users'][$user_info->ID] = array( $score, $user_info->display_name, $date_time );
				$data['votes'] += 1;
			}
		} else {
			$data = array(
				'votes' => 1,
				'avg'   => $score,
				'stars' => $stars,
				'users' => array(
					$user_info->ID => array(
						$score,
						$user_info->display_name,
						$date_time,
					)
				)
			);

		}
		foreach ( $stars as $key => $value ) {
			if ("$key" === "$score") {
				if ( ! empty( $data['stars'][$key] ) ) {
					$data['stars'][$key] += 1;
				} else {
					$data['stars'][$key] = 1;
				}
			}
	}
		$data['avg'] = round( starstruck_calc_avg_rating( $data ), 1 );
		$avg   = $data['avg'];
		$votes = $data['votes'];
		$data['last_updated'] = $date_time;
		$data = maybe_serialize( $data );
	if ( $type !== 'taxonomy') {

		if ('user' == $type ) {
			update_user_option( $id, STARSTRUCK_KEY, $data );
			update_user_option( $id, STARSTRUCK_AVG_KEY, $avg );
			update_user_option( $id, STARSTRUCK_TOTAL_KEY, $votes );
		} else {
			update_metadata( $type, $id, STARSTRUCK_KEY, $data );
			update_metadata( $type, $id, STARSTRUCK_AVG_KEY, $avg );
			update_metadata( $type, $id, STARSTRUCK_TOTAL_KEY, $votes );
		}

	} else {
		starstruck_update_option( STARSTRUCK_KEY . "-$id", $data );
		starstruck_update_option( STARSTRUCK_AVG_KEY . "-$id" , $avg );
		starstruck_update_option( STARSTRUCK_TOTAL_KEY . "-$id" , $votes );
	}
		return $data;
}
function starstruck_text( $data, $id ) {
	if ( ! $data ) {
		return;
	}
	$user_info = starstruck_user_object();
	$pre   = '<span>';
	$post  = '</span>';
	$text  = __d('Thanks for your vote!');
	$data  = maybe_unserialize( $data );
	$match = array_key_exists( $user_info->ID, $data['users'] ) ? true : false;
	$vote_text = _n('vote', 'votes', $data['votes'] );
	if ( $match == true ) {
		return $output = array(
			'text'      => $pre . $text . $post,
			'votes'     => $data['votes'],
			'avg'       => $data['avg'],
			'user_vote' => $data['users'][$user_info->ID][0],
			'vote_text' => $vote_text
		);
	}
}
function starstruck_action_callback() {
	if ( ! wp_verify_nonce( $_POST['nonce'], 'starstruck-nonce') ) {
		header( __d('HTTP/1.1 400 Nonce is empty and/or invalid') );
	}
	if ( ! isset( $_POST['id'] ) ) {
		header( __d('HTTP/1.1 400 ID is empty') );
	} else {
		$id = $_POST['id'];
	}
	if ( ! isset( $_POST['type'] ) ) {
		$type = 'post';
	} else {
		$type = $_POST['type'];
	}
	if ('taxonomy' != $type ) {

		if ('user' == $type ) {
			$data = get_user_option( STARSTRUCK_KEY, $id );
		} else {
			$data = get_metadata( $type, $id, STARSTRUCK_KEY, true );
		}
	} else {
		$data = get_option( STARSTRUCK_KEY . "-$id");
	}
	$score = round( (float) $_POST['score'] * 2 ) / 2;
	$data_updated = starstruck_update_db( $data, $id, $type, $score );
	$response = starstruck_text( $data_updated, $id );
	header('Content-Type: application/json');
	echo json_encode( $response );
	die();
}
function starstruck_delete_action_callback() {
	if ( ! wp_verify_nonce( $_POST['nonce'], 'starstruck-nonce') ) {
		die ( __d('Busted!') );
	}
	$type = sanitize_text_field( $_POST['type'] );
	$id = (int) $_POST['id'];
	$uid = (int) $_POST['uid'];
	if ('taxonomy' != $type ) {
		if ('user' == $type ) {
			$data = get_user_option( STARSTRUCK_KEY, $id );
		} else {
			$data = get_metadata( $type, $id, STARSTRUCK_KEY, true );
		}
	} else {
		$data = get_option( STARSTRUCK_KEY . "-$id");
	}
	$data_updated = starstruck_delete_from_db( $data, $id, $uid, $type );
	$response = array('text' => __d('User vote deleted') );
	header('Content-Type: application/json');
	echo json_encode( $response );
	die();
}
function starstruck_delete_from_db( $data, $id, $uid, $type ) {
	if ( ! $data ) {
		return;
	}
	$data = maybe_unserialize( $data );
	if ( array_key_exists( $uid, $data['users'] ) ) {
		$old_score = $data['users'][$uid][0];
	if ( ! empty( $data['stars'][$old_score] ) ) {
		$data['stars']["$old_score"] -= 1;
	}
		$data['votes'] -= 1;
		unset( $data['users'][$uid] );
	}
	$data['avg'] = starstruck_calc_avg_rating( $data );
	$data['last_updated'] = current_time('mysql');
	$data = maybe_serialize( $data );
	if ( $type !== 'taxonomy') {
		update_metadata( $type, $id, STARSTRUCK_KEY, $data );
	} else {
		starstruck_update_option( STARSTRUCK_KEY . "-$id", $data );
	}
	return $data;
}
function starstruck_return_data( $type = 'post', $id = '') {
	global $post, $comment;
	if ( $type == 'taxonomy') {
		if ( ! $id ) {
			$term = get_queried_object();
			$id = $term->term_id;
		}
		$data = get_option( STARSTRUCK_KEY . "-$id");
	} else {
		if ( ! $id ) {
			if ( $type == 'comment') {
				$id = $comment->comment_ID;
			} elseif( $type == 'user ') {
				$id = in_the_loop() ? get_the_author_meta('ID') : get_query_var('author');
			} else {
				$id = $post->ID;
			}
		}
		$data = get_metadata( $type, $id, STARSTRUCK_KEY, true );
	}
		if ( $data = maybe_unserialize( $data ) ) {
			return $data;
		} else {
			$data['votes']  = 0;
			$data['avg']    = 0;
		}
		return $data;
}
function starstruck_mini_ratings( $type = 'post', $id = '') {
	global $post, $comment;
	$data = starstruck_return_data( $type, $id );
	if ( $data = maybe_unserialize( $data ) ) {
		$rating = $data['avg'];
		$votes  = $data['votes'];
	} else {
		$rating = 0;
		$votes  = 0;
	}
	$output = '<div class="starstruck-wrap">';
	$output .= starstruck_return_content_span( $id, $rating, $type, 'starstruck-read-only');
	$output .= '<span class="starstruck-mini-count">(' . number_format( $votes ) . ')</span></div>';

	return apply_filters('starstruck_mini', $output, $data );
}
function starstruck_user_object() {
	global $user_ID;

	if ( $user_ID > 0 ) {
		$user_info = get_userdata( $user_ID );
	} else {
		$user_info = new stdClass();
		$user_info->ID = starstruck_cookie_check();
		$user_info->display_name = __d('Anonymous');
	}
	return $user_info;
}
function starstruck_calc_avg_rating( $data ) {
	$sum_of_stars = 0;
	foreach ( $data['stars'] as $star_weight => $star_count ) {
		$sum_of_stars += $star_weight * $star_count;
	}
	$average_rating = $sum_of_stars / $data['votes'];
	return round( $average_rating, 1 );
}
function starstruck_require_user_login() {
	global $starstruck_options;

	if ( isset( $starstruck_options['disable_anonymous'] ) && ! is_user_logged_in() ) {
		return true;
	}

	return false;
}
function starstruck_admin_check() {
	return current_user_can('manage_options');
}
function starstruck_cookie_check() {
	if ( isset( $_COOKIE['starstruck_'.COOKIEHASH] ) ) {
		return $_COOKIE['starstruck_'.COOKIEHASH];
	} else {
		return 0; // black hole catch-all for no cookies enabled
	}
}
function starstruck_update_option( $option_name, $new_value ) {
	if ( get_option( $option_name ) !== false ) {
		update_option( $option_name, $new_value );
	} else {
		add_option( $option_name, $new_value, '', $autoload = 'no');
	}

}
function starstruck_get_theme_selector( $type = '') {
	if ( defined('APP_TD') ) {
		$theme = APP_TD;
	} else {
		$theme = 'default';
	}
	$selector = array(
		'default' => array(
			'author'   => '.archive.author #main h1:first',
			'taxonomy' => '.archive #main h1:first',
		),
		'jobroller' => array(
			'author'   => '.archive.author #content h1:first',
			'taxonomy' => '.archive #content h1:first',
		),
		'ideas' => array(
			'author'   => '.archive.author #dashboard-side-nav .widget-content:first',
			'taxonomy' => '.archive #main h2:first',
		),
		'qualitycontrol' => array(
			'author'   => '.archive.author #current-user-links',
			'taxonomy' => '.archive #main .ticket-title',
		),
		'classipress' => array(
			'author'   => '.archive.author .author-info',
			'taxonomy' => '.archive .content h1:first',
		),
		'hirebee' => array(
			'author'   => '.user-profile .user-name',
			'taxonomy' => '.archive #main .article-title h3',
		),
		'vantage' => array(
			'author' => '.va-dashboard .user_meta',
		),
	);
	$selector = apply_filters('starstruck_theme_selector', $selector, $type );
	if ( $type && empty( $selector[ $theme ][ $type ] ) ) {
		return $selector['default'][ $type ];
	}
	if ( ! $type ) {
		return $selector[ $theme ];
	} else {
		return $selector[ $theme ][ $type ];
	}
}
function starstruck_get_theme_conditional_tag( $type = '') {
	if ( defined('APP_TD') ) {
		$theme = APP_TD;
	} else {
		$theme = 'default';
	}
	$selector = array(
		'default' => array(
			'author' => array(
				'callback'  => 'is_author',
				'params'    => array(),
				'query_var' => 'author',
				'pages'     => 'author.php',
			),
			'taxonomy' => array(
				'pages' => 'category.php OR category-{term}.php OR taxonomy.php OR taxonomy-{term}.php OR related sidebars'
			),
		),
		'vantage' => array(
			'author' => array(
				'callback'  => 'get_query_var',
				'params'    => 'dashboard_author',
				'query_var' => 'dashboard_author',
				'pages'     => 'dashboard-*.php OR related sidebars',
			),
			'taxonomy' => array(
				'pages' => 'archive-*.php OR loop-*.php OR related sidebars',
			),
		),
		'hirebee' => array(
			'author' => array(
				'callback'  => 'get_query_var',
				'params'    => 'profile_author',
				'query_var' => 'profile_author',
				'pages'     => 'profile.php',
			),
			'taxonomy' => array(
				'pages' => 'archive-*.php OR loop-*.php OR related sidebars',
			),
		),
	);
	$selector = apply_filters('starstruck_conditional_tag', $selector, $type );
	if ( $type && empty( $selector[ $theme ][ $type ] ) ) {
		return $selector['default'][ $type ];
	}
	if ( ! $type ) {
		return $selector[ $theme ];
	} else {
		return $selector[ $theme ][ $type ];
	}
}
function starstruck_get_posts_ratings( $args = array() ) {
	$defaults = array(
		'post_type'      => 'post',
		'status'         => 'publish',
		'posts_per_page' => 10,
		'meta_query'     => array(
			array(
				'key'     => STARSTRUCK_TOTAL_KEY,
				'value'   => 0,
				'compare' => '>',
			),
		),
	);
	$args = wp_parse_args( $args, $defaults );
	$results = new WP_Query( $args );
	$ratings = array();
	foreach( $results->posts as $post ) {
		$avg = get_post_meta( $post->ID, STARSTRUCK_AVG_KEY, true );
		$total = get_post_meta( $post->ID, STARSTRUCK_TOTAL_KEY, true );
		$weighted = $avg * $total;
		$data = array(
			'title'  => '<a href="'.get_permalink( $post->ID ).'">' . $post->post_title . '</a>',
			'rating' => $avg,
			'votes'  => $total,
		);
		$ratings[ "$weighted" ][ $post->ID ] = $data;
	}
	krsort( $ratings, SORT_NUMERIC );
	return $ratings;
}
function starstruck_get_top_ratings( $type = 'post', $post_type = 'post', $limit = 10 ) {
	if ('post' != $type ) {
		return;
	}
	$ratings = starstruck_get_posts_ratings(
		array(
			'post_type'      => $post_type,
			'posts_per_page' => $limit,
		)
	);
	$top = '';
	$index = 1;
	ob_start();
	if ( $ratings ) {
		echo '<ol>';
		foreach( $ratings as $weight => $posts ) {
			foreach( $posts as $id => $post ) {
				extract( $post );
		?>
				<li>
					<div class="starstruck-wrap">
						<?php echo $title; ?>
						<div class="starstruck-mini" data-rating="<?php echo $rating; ?>"></div>
						<div class="starstruck-rating"><?php _d('Rating:'); ?> <?php echo $rating; ?> - <?php echo number_format( $votes ); ?> <?php echo _n('vote', 'votes', $votes ); ?></div>
					</div><!-- .starstruck-wrap -->
				</li>
		<?php
			$index++;
			}
		}
		echo '</ol>';
	} else {
		echo '<p>' . __d('No results found.') . '</p>';
	}
	$top .= ob_get_clean();
	return $top;
}
if ( ! function_exists('html') ):
function html( $tag ) {
	static $SELF_CLOSING_TAGS = array('area', 'base', 'basefont', 'br', 'hr', 'input', 'img', 'link', 'meta');
	$args = func_get_args();
	$tag = array_shift( $args );
	if ( is_array( $args[0] ) ) {
		$closing = $tag;
		$attributes = array_shift( $args );
		foreach ( $attributes as $key => $value ) {
			if ( false === $value )
				continue;
			if ( true === $value )
				$value = $key;

			$tag .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}
	} else {
		list( $closing ) = explode(' ', $tag, 2 );
	}

	if ( in_array( $closing, $SELF_CLOSING_TAGS ) ) {
		return "<{$tag} />";
	}
	$content = implode('', $args );

	return "<{$tag}>{$content}</{$closing}>";
}
endif;
function starstruck_strip_ss_markup( $text, $original_text = '') {
	if ( ! $original_text ) {
		$original_text = $text;
	}
	$startrsuck_pos = strpos( $original_text, 'starstruck-wrap');
	if ( $startrsuck_pos === FALSE ) {
		return $text;
	}
	preg_match('~<div.*class="starstruck\-wrap".*>(.*)</div>~iUs', $original_text, $matches, PREG_OFFSET_CAPTURE );
	if ( ! empty( $matches[0][1] ) ) {
		return substr( $original_text, 0, $matches[0][1] );
	}
	return $text;
}
function starstruck_get_microdata_schema() {
	if ( defined('APP_TD') ) {
		$theme = APP_TD;
	} else {
		$theme = 'default';
	}
	$schema = 'Service';
	switch ( $theme ) {
		case 'classipress':
			if ( is_singular('ad_listing') ) {
	        	$schema = 'Product';
	        }
			break;
		case 'clipper':
			if ( is_singular('coupon') ) {
	        	$schema = 'Offer';
	        }
			break;
		case 'vantage':
			if ( is_singular('event') ) {
	        	$schema = 'Event';
	        } elseif ( is_singular('listing') ) {
	        	$schema = 'Place';
	        }
			break;
	}
    return apply_filters('starstruck_microdata_schema', $schema );
}
function starstruck_get_microdata_name() {
	global $post;
	$name = '';
    if ( is_tax() ) {
		$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy') );
        $name = $term->name;
    } elseif( is_author() ) {
		$conditional_tag = starstruck_get_theme_conditional_tag('author');
		$user_id = get_query_var( $conditional_tag['query_var'] );
        $user = get_user_by('id', $user_id );
        $name = $user->display_name;
    } elseif( is_singular() || is_single() ) {
    	$name = $post->post_title;
    }
    return $name;
}
function starstruck_va_event_microdata() {
	if ( ! defined('APP_TD') || 'vantage' !== APP_TD || ! is_singular('event') ) {
		return;
	}
	if ( ! ( $address = get_the_event_address() ) ) {
		return;
	}
	$days = va_get_the_event_days();
	$days = reset( $days );
	$date = $days->slug;
	?>
	<meta itemprop="startDate" content="<?php echo esc_attr( date('c', strtotime( $date ) ) ); ?>" />
	<div itemprop="location" itemscope itemtype="http://schema.org/Place">
		<meta itemprop="name" content="<?php echo esc_attr( starstruck_get_microdata_name() ); ?>">
		<meta itemprop="address" content="<?php echo esc_attr( $address ); ?>">
		<?php
		$coord = appthemes_get_coordinates( $post->ID );
		if ( 0 < $coord->lat ) : ?>
			<div itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
				<meta itemprop="latitude" content="<?php echo esc_attr( $coord->lat ); ?>" />
				<meta itemprop="longitude" content="<?php echo esc_attr( $coord->lng ); ?>" />
			</div>
		<?php endif; ?>
	</div>
<?php
}
function starstruck_bbp_post_display() {
	starstruck_post_display_echo();
}

function reset_rating_dt( $valor ) {
    global $wpdb;
    $valor = trim( $valor );
    if ( empty( $valor ) )
        return false;
    wp_protect_special_option( $valor );
    $row = $wpdb->get_row( $wpdb->prepare("SELECT autoload FROM $wpdb->options WHERE option_name = %s", $valor ) );
    if ( is_null( $row ) )
        return false;
    do_action('reset_rating_dt', $valor );
    $result = $wpdb->delete( $wpdb->options, array('option_name' => $valor ) );
    if ( ! wp_installing() ) {
        if ('yes' == $row->autoload ) {
            $resct = wp_load_alloptions();
            if ( is_array( $resct ) && isset( $resct[$valor] ) ) {
                unset( $resct[$valor] );
                wp_cache_set('alloptions', $resct, 'options');
            }
        } else {
            wp_cache_delete( $valor, 'options');
        }
    }
    if ( $result ) {
        do_action("delete_option_{$valor}", $valor );
        do_action('deleted_option', $valor );
        return true;
    }
    return false;
}