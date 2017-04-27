<?php


class DT_Widget_views extends WP_Widget {
	function DT_Widget_views() {
		$widget_ops = array('classname' => 'doothemes_widget', 'description' => __d('A widget to display Popular content') );
		$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'dtw_content_views');
		$this->WP_Widget('dtw_content_views', __d('DooPlay - Sidebar Popular content'), $widget_ops, $control_ops );
	}
	function widget( $args, $instance ) {
		extract( $args );
		//Our variables from the widget settings.

		$title = apply_filters('widget_title', $instance['title'] );
		$num = $instance['dt_nun'];
		$layout = $instance['dt_layout'];
		$keybox = $instance['dt_key'];
	

		echo $before_widget;
		// Display Widget title 
		if ( $title )
			echo $before_title . $title . $after_title;
		//Display Query posts

echo '<div class="dtw_content '.$keybox.'">';
query_posts( array('post_type' => array('movies','tvshows'), 'showposts' => $num, 'meta_key' => 'end_time','meta_compare' =>'>=','meta_value'=>time(),'meta_key' => $keybox,'orderby' => 'meta_value_num','order' => 'DESC')); 
while ( have_posts() ) : the_post();
get_template_part('inc/parts/item_widget_'. $layout .'');
endwhile; wp_reset_query(); 
echo '</div>';
		// End Query
		echo $after_widget;
	}
	//Update the widget 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//Strip tags from title and name to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['dt_nun'] = strip_tags( $new_instance['dt_nun'] );
		$instance['dt_layout'] = strip_tags( $new_instance['dt_layout'] );
		$instance['dt_key'] = strip_tags( $new_instance['dt_key'] );
		return $instance;
	}
	function form( $instance ) {
		//Set up some default widget settings.
		$defaults = array('title' => '', 'dt_nun' => '10',  'dt_layout' => 'wa', 'dt_key' => 'dt_views_count');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _d('Title:'); ?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('dt_key'); ?>"><?php _d('Popular content by'); ?></label>
			<select id="<?php echo $this->get_field_id('dt_key'); ?>" name="<?php echo $this->get_field_name('dt_key'); ?>" style="width:100%;">
				<option <?php if ('dt_views_count' == $instance['dt_key'] ) echo 'selected="selected"'; ?> value="dt_views_count"><?php _d('Visits'); ?></option>
				<option <?php if ('_user_liked' == $instance['dt_key'] ) echo 'selected="selected"'; ?> value="votes_count"><?php _d('Likes'); ?></option>
				<option <?php if ('_starstruck_avg' == $instance['dt_key'] ) echo 'selected="selected"'; ?> value="_starstruck_avg"><?php _d('Users rating'); ?></option>
				<option <?php if ('imdbRating' == $instance['dt_key'] ) echo 'selected="selected"'; ?> value="imdbRating"><?php _d('IMDb rating'); ?></option>
				<option <?php if ('vote_average' == $instance['dt_key'] ) echo 'selected="selected"'; ?> value="vote_average"><?php _d('TMDb rating'); ?></option>
            </select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('dt_layout'); ?>"><?php _d('Layout style'); ?></label>
			<select id="<?php echo $this->get_field_id('dt_layout'); ?>" name="<?php echo $this->get_field_name('dt_layout'); ?>" style="width:100%;">
				<option <?php if ('wa' == $instance['dt_layout'] ) echo 'selected="selected"'; ?> value="wa"><?php _d('Style 1 - image Backdrop'); ?></option>
				<option <?php if ('wb' == $instance['dt_layout'] ) echo 'selected="selected"'; ?> value="wb"><?php _d('Style 2 - image Poster'); ?></option>
				<option <?php if ('wc' == $instance['dt_layout'] ) echo 'selected="selected"'; ?> value="wc"><?php _d('Style 3 - no image'); ?></option>
            </select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('dt_nun'); ?>"><?php _d('Items number'); ?></label>
			<input type="number" id="<?php echo $this->get_field_id('dt_nun'); ?>" name="<?php echo $this->get_field_name('dt_nun'); ?>" value="<?php echo $instance['dt_nun']; ?>" min="2" max="20" style="width:100%;">
		</p>
	<?php
	}
}

?>