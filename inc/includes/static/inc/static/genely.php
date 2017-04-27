<?php


class EDD_Theme_Updater {
	private $remote_api_url;
	private $request_data;
	private $response_key;
	private $theme_slug;
	private $license_key;
	private $version;
	private $author;
	protected $strings = null;
	function __construct( $args = array(), $strings = array() ) {
		$args = wp_parse_args( $args, array(
			'remote_api_url' => 'https://doothemes.com',
			'request_data' => array(),
			'theme_slug' => get_template(),
			'item_name' => '',
			'license' => '',
			'version' => '',
			'author' => ''
		) );
		extract( $args );
		$this->license = $license;
		$this->item_name = $item_name;
		$this->version = $version;
		$this->theme_slug = sanitize_key( $theme_slug );
		$this->author = $author;
		$this->remote_api_url = $remote_api_url;
		$this->response_key = $this->theme_slug . '-update-response';
		$this->strings = $strings;

		add_filter('site_transient_update_themes', array( &$this, 'theme_update_transient') );
		add_filter('delete_site_transient_update_themes', array( &$this, 'delete_theme_update_transient') );
		add_action('load-update-core.php', array( &$this, 'delete_theme_update_transient') );
		add_action('load-themes.php', array( &$this, 'delete_theme_update_transient') );
		add_action('load-themes.php', array( &$this, 'load_themes_screen') );
	}
	function load_themes_screen() {
		add_thickbox();
		add_action('admin_notices', array( &$this, 'update_nag') );
	}
	function update_nag() {
		$strings = $this->strings;
		$theme = wp_get_theme( $this->theme_slug );
		$api_response = get_transient( $this->response_key );
		if ( false === $api_response ) {
			return;
		}
		$update_url = wp_nonce_url('update.php?action=upgrade-theme&amp;theme=' . urlencode( $this->theme_slug ), 'upgrade-theme_' . $this->theme_slug );
		$update_onclick = ' onclick="if ( confirm(\'' . esc_js( $strings['update-notice'] ) . '\') ) {return true;}return false;"';
		if ( version_compare( $this->version, $api_response->new_version, '<') ) {
			echo '<div id="update-nag">';
			printf(
				$strings['update-available'],
				$theme->get('Name'),
				$api_response->new_version,
				'#TB_inline?width=640&amp;inlineId=' . $this->theme_slug . '_changelog',
				$theme->get('Name'),
				$update_url,
				$update_onclick
			);
			echo '</div>';
			echo '<div id="' . $this->theme_slug . '_' . 'changelog" style="display:none;">';
			echo wpautop( $api_response->sections['changelog'] );
			echo '</div>';
		}
	}
	function theme_update_transient( $value ) {
		$update_data = $this->check_for_update();
		if ( $update_data ) {
			$value->response[ $this->theme_slug ] = $update_data;
		}
		return $value;
	}
	function delete_theme_update_transient() {
		delete_transient( $this->response_key );
	}
	function check_for_update() {

			return false;
	}

}