<?php


class DT_Widget_social extends WP_Widget{
	public $sites = array(
		'facebook' => array(
			'title' => 'Facebook',
			'icon' => 'facebook',
		),
		'twitter' => array(
			'title' => 'Twitter',
			'icon' => 'twitter',
		),
		'googleplus' => array(
			'title' => 'Google+',
			'icon' => 'google-plus',
		),
		'linkedin' => array(
			'title' => 'Linkedin',
			'icon' => 'linkedin',
		),
		'youtube' => array(
			'title' => 'Youtube',
			'icon' => 'youtube',
		),
		'rss' => array(
			'title' => 'Rss',
			'icon' => 'rss',
		),
		'flickr' => array(
			'title' => 'Flickr',
			'icon' => 'flickr',
		),
		'vimeo' => array(
			'title' => 'Vimeo',
			'icon' => 'vimeo',
		),
		'pinterest' => array(
			'title' => 'Pinterest',
			'icon' => 'pinterest',
		),
		'dribbble' => array(
			'title' => 'Dribbble',
			'icon' => 'dribbble',
		),
		'tumblr' => array(
			'title' => 'Tumblr',
			'icon' => 'tumblr',
		),
		'instagram' => array(
			'title' => 'Instagram',
			'icon' => 'instagram',
		),
		'vine' => array(
			'title' => 'Vine',
			'icon' => 'vine',
		),
		'VK' => array(
			'title' => 'VK',
			'icon' => 'vk',
		)
    );

	function DT_Widget_social(){

		$this->WP_Widget('dtw_socialbox', __d('Dooplay - Socialbox'), array('classname' => 'dtw_socialbox clearfix', 'description' => __d('Displays links to social networks in a stylish manner')));
	}
 
	function form($instance){

		$instance = wp_parse_args((array)$instance, array('title' => ''));
		
		$title = empty($instance['title']) ? '' : $instance['title'];

		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _d('Title:','doothemes'); ?></label><br>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>">
		</p>
		<hr>
		<p><?php _d('Insert the URLs to your social networks'); ?></p><?php

		foreach ($this->sites as $key => $value) {
			echo '<p>';
				echo '<label for="'.esc_attr($this->get_field_id($key)).'">'.esc_attr($value['title']).'</label><br>';
				echo '<input class="widefat" type="text" id="'.esc_attr($this->get_field_id($key)).'" name="'.esc_attr($this->get_field_name($key)).'" value="'.(empty($instance[$key]) ? '' : esc_attr($instance[$key])).'">';
			echo '</p>';
		}
	}
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		foreach ($this->sites as $key => $value) {
			$instance[$key] = esc_url($new_instance[$key]);
		}
		return $instance;
	}
	function widget($args, $instance){
		extract($args, EXTR_SKIP);
		echo $before_widget; 
		echo !empty($instance['title']) ? $before_title.esc_attr($instance['title']).$after_title : '' ?>
		<div class="widget-social">
			<ul class="social-links">
			<?php foreach ($this->sites as $key => $value) {
					if(!empty($instance[$key])){ ?>
						<li class="dtl">
							<a class="<?php echo esc_attr($value['icon']); ?>-background icls" target="_blank" href="<?php echo esc_url($instance[$key]); ?>">
							<i class="dt-icon <?php echo esc_attr($value['icon']); ?>"></i> <?php echo esc_attr($value['title']); ?></a>
						</li><?php
					}
				} ?>
			</ul>
		</div><?php

		echo $after_widget;
	}
}
