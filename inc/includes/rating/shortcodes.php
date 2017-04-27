<?php
add_shortcode('starstruck_shortcode', 'starstruck_post_shortcode_handler');
add_shortcode('starstruck_taxonomy_shortcode', 'starstruck_taxonomy_shortcode_handler');
add_shortcode('starstruck_author_shortcode', 'starstruck_author_shortcode_handler');
add_action('wp_footer', 'starstruck_taxonomy_shortcode_handler');
add_shortcode('starstruck_shc', 'starstruck_post_shortcode_handler');
function starstruck_post_shortcode_handler() {
	return html('div', array('class' => 'starstruck-ptype', 'style' => ''), starstruck_post_display() );
}
function starstruck_author_shortcode_handler( $hidden = true ) {
	global $starstruck_options;
	if ( is_admin() || ! starstruck_is_author()  ) {
		return;
	}
	$conditional_tag = starstruck_get_theme_conditional_tag('author');
	$user_id = get_query_var( $conditional_tag['query_var'] );
	if ( is_a( $user_id, 'WP_User') ) {
		$user_id = $user_id->ID;
	} elseif ( ! intval( $user_id ) ) {
		$user = get_user_by('slug', $user_id );
		$user_id = $user->ID;
	}
	$data = get_user_option ( STARSTRUCK_KEY, $user_id );
	$content = starstruck_return_content( $data, '', $user_id, 'user');
	$content = html('div', array('class' => 'starstruck-author',  'style' => $hidden ? 'display: none;' : ''), apply_filters('starstruck_content', $content, $data ) );
	echo $content;
}
function starstruck_taxonomy_shortcode_handler( $hidden = true ) {
	global $starstruck_options;

	if ( is_admin() || ! is_main_query() || ( ! is_tax() && ! is_category() ) ) {
		return;
	}
	remove_action('wp_footer', 'starstruck_taxonomy_shortcode_handler');
	$term = get_queried_object();
	$taxonomy = $term->taxonomy;
	if ( ! empty( $starstruck_options["enable_tax_$taxonomy"] ) ) {
		$data = get_option( STARSTRUCK_KEY . "-" . $term->term_id );
		$content = starstruck_return_content( $data, '', $term->term_id, 'taxonomy');
		$content = html('div', array('class' => 'starstruck-tax ' . esc_attr( current_filter() ) , 'style' => $hidden ? 'display: none;' : ''), apply_filters('starstruck_content', $content, $data ) );
		echo $content;
	}
}
