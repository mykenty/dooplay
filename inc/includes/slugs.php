<?php


class dt_slugs {
	public function __construct() {
		add_action('admin_init', array( $this, 'settingsInit'));
		add_action('admin_init', array( $this, 'settingsSave'));
	}

	/* Fields
	-------------------------------------------------------------------------------
	*/
	public function settingsInit() {
		$this->addField('', array($this, 'slug_title'), '');
		$this->addField('dt_author_slug', array( $this, 'author_slug'), __d('Username') );
		$this->addField('dt_movies_slug', array( $this, 'movies_slug'), __d('Movies') );
		$this->addField('dt_tvshows_slug', array( $this, 'tvshows_slug'), __d('TVShows') );
		$this->addField('dt_seasons_slug', array( $this, 'seasons_slug'), __d('Seasons') );
		$this->addField('dt_episodes_slug', array( $this, 'episodes_slug'), __d('Episodes') );
		$this->addField('dt_links_slug', array( $this, 'links_slug'), __d('Links') );
		$this->addField('dt_genre_slug', array( $this, 'genre_slug'), __d('Genre') );
		$this->addField('dt_release_slug', array( $this, 'release_slug'), __d('Release') );
		$this->addField('dt_network_slug', array( $this, 'network_slug'), __d('Network') );
		$this->addField('dt_studio_slug', array( $this, 'studio_slug'), __d('Studio') );
		$this->addField('dt_cast_slug', array( $this, 'cast_slug'), __d('Cast') );
		$this->addField('dt_creator_slug', array( $this, 'creator_slug'), __d('Creator') );
		$this->addField('dt_director_slug', array( $this, 'director_slug'), __d('Director') );
		$this->addField('dt_quality_slug', array( $this, 'quality_slug'), __d('Quality') );
	}

	/* Callbacks
	-------------------------------------------------------------------------------
	*/
	public function slug_title() {
		echo '<h3>'. __d('DooPlay: Permalink Settings') .'</h3>';
	}
	
	public function author_slug() {
		echo $this->input('dt_author_slug', 'author', '/nickname/');
	}

	public function movies_slug() {
		echo $this->input('dt_movies_slug', 'movies', '/titanic/');
	}

	public function tvshows_slug() {
		echo $this->input('dt_tvshows_slug', 'tvshows', '/the-walking-dead/');
	}

	public function seasons_slug() {
		echo $this->input('dt_seasons_slug', 'seasons', '/the-walking-dead-season-1/');
	}

	public function episodes_slug() {
		echo $this->input('dt_episodes_slug', 'episodes', '/the-walking-dead-1x1/');
	}

	public function genre_slug() {
		echo $this->input('dt_genre_slug', 'genre', '/action/');
	}

	public function release_slug() {
		echo $this->input('dt_release_slug', 'release', '/2016/');
	}

	public function network_slug() {
		echo $this->input('dt_network_slug', 'network', '/amc/');
	}

	public function studio_slug() {
		echo $this->input('dt_studio_slug', 'studio', '/amc-studios/');
	}

	public function cast_slug() {
		echo $this->input('dt_cast_slug', 'cast', '/andrew-lincoln/');
	}

	public function creator_slug() {
		echo $this->input('dt_creator_slug', 'creator', '/frank-darabont/');
	}

	public function director_slug() {
		echo $this->input('dt_director_slug', 'director', '/james-cameron/');
	}

	public function links_slug() {
		echo $this->input('dt_links_slug', 'links', '/1588/');
	}

	public function quality_slug() {
		echo $this->input('dt_quality_slug', 'quality', '/1080p/');
	}

	/* Save settings
	-------------------------------------------------------------------------------
	*/
	public function settingsSave() {
		if ( ! is_admin() ) return;
		$this->saveField('dt_author_slug');
		$this->saveField('dt_movies_slug');
		$this->saveField('dt_tvshows_slug');
		$this->saveField('dt_seasons_slug');
		$this->saveField('dt_episodes_slug');
		$this->saveField('dt_genre_slug');
		$this->saveField('dt_release_slug');
		$this->saveField('dt_network_slug');
		$this->saveField('dt_studio_slug');
		$this->saveField('dt_protagonist_slug');
		$this->saveField('dt_cast_slug');
		$this->saveField('dt_gueststar_slug');
		$this->saveField('dt_creator_slug');
		$this->saveField('dt_director_slug');
		$this->saveField('dt_links_slug');
		$this->saveField('dt_quality_slug');
	}

	/*Helpers
	-------------------------------------------------------------------------------
	*/
	public function input( $option_name, $placeholder = '', $type ) {
		$slug = get_option( $option_name );
		$value = ( isset( $slug ) ) ? esc_attr( $slug ) : ''; 
		return '<code>'. home_url() .'/</code><input class="dt_permaliks_input" name="'. $option_name .'" type="text" class="regular-text code" value="'. $slug .'" placeholder="'. $placeholder .'" /><code>'. $type .'</code>';
	}
	public function addField( $option_name, $callback, $title ){
		add_settings_field(
			$option_name, // id
			$title,       // setting title
			$callback,    // display callback
			'permalink',  // settings page
			'optional'    // settings section
		);
	}
	public function saveField( $option_name ){
		if ( isset( $_POST[$option_name] ) ) {
			$permalink_structure = sanitize_title( $_POST[$option_name] );
			$permalink_structure = untrailingslashit( $permalink_structure );
		
			update_option( $option_name, $permalink_structure );
		}
	}
}
new dt_slugs;


/* Defaul options
-------------------------------------------------------------------------------
*/
$dt_author_slug		= get_option('dt_author_slug');
$dt_movies_slug		= get_option('dt_movies_slug');
$dt_tvshows_slug	= get_option('dt_tvshows_slug');
$dt_seasons_slug	= get_option('dt_seasons_slug');
$dt_episodes_slug	= get_option('dt_episodes_slug');
$dt_links_slug		= get_option('dt_links_slug');
$dt_genre_slug		= get_option('dt_genre_slug');
$dt_release_slug	= get_option('dt_release_slug');
$dt_network_slug	= get_option('dt_network_slug');
$dt_studio_slug		= get_option('dt_studio_slug');
$dt_cast_slug		= get_option('dt_cast_slug');
$dt_director_slug	= get_option('dt_director_slug');
$dt_quality_slug	= get_option('dt_quality_slug');

/* Update default options
-------------------------------------------------------------------------------
*/
if(empty($dt_author_slug)) {
	update_option('dt_author_slug', 'profile');
}

if(empty($dt_movies_slug)){
	update_option('dt_movies_slug', 'movies');
}

if(empty($dt_tvshows_slug)){
	update_option('dt_tvshows_slug', 'tvshows');
}

if(empty($dt_seasons_slug)){
	update_option('dt_seasons_slug', 'seasons');
}

if(empty($dt_episodes_slug)){
	update_option('dt_episodes_slug', 'episodes');
}

if(empty($dt_links_slug)){
	update_option('dt_links_slug', 'links');
}

if(empty($dt_genre_slug)){
	update_option('dt_genre_slug', 'genre');
}

if(empty($dt_release_slug)){
	update_option('dt_release_slug', 'release');
}

if(empty($dt_network_slug)){
	update_option('dt_network_slug', 'network');
}

if(empty($dt_studio_slug)){
	update_option('dt_studio_slug', 'studio');
}

if(empty($dt_cast_slug)){
	update_option('dt_cast_slug', 'cast');
}

$dt_creator_slug = get_option('dt_creator_slug');
if(empty($dt_creator_slug)){
	update_option('dt_creator_slug', 'creator');
}

if(empty($dt_director_slug)){
	update_option('dt_director_slug', 'director');
}

if(empty($dt_quality_slug)){
	update_option('dt_quality_slug', 'quality');
}
