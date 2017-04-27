<?php

class DT_Widget_mgenres extends WP_Widget {
	function DT_Widget_mgenres() {
		$widget_ops = array('classname' => 'doothemes_widget', 'description' => __d('Full list of genres') );
		$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'dtw_mgenres');
		$this->WP_Widget('dtw_mgenres', __d('DooPlay - Genres list'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );
		$scroll = $instance[ 'dt_scroll' ] ? 'scrolling' : 'falsescroll';
		// Widget
		echo '<div class="dt_mainmeta">';
		echo '<nav class="genres">';
		echo '<h2>'. $title .'</h2>';
		echo '<ul class="genres '.$scroll.'">';
		li_generos();
		echo '</ul>';
		echo '</nav>';
		echo '</div>';
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//Strip tags from title and name to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['dt_scroll'] = strip_tags( $new_instance['dt_scroll'] );
		return $instance;
	}

	function form( $instance ) {
		//Set up some default widget settings.
		$defaults = array('title' => __d('Genres'), 'dt_scroll' => 'scrolling');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _d('Title:'); ?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance[ 'dt_scroll' ], 'on'); ?> id="<?php echo $this->get_field_id('dt_scroll'); ?>" name="<?php echo $this->get_field_name('dt_scroll'); ?>" /> 
			<label for="<?php echo $this->get_field_id('dt_scroll'); ?>"> <?php _d('Enable scrolling'); ?></label>
		</p>
	<?php
	}

}