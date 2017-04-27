<?php


class DT_Widget_genres extends WP_Widget {
	function DT_Widget_genres() {
		$widget_ops = array('classname' => 'doothemes_widget', 'description' => __d('Sort content by genres') );
		$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'dts_content_genres');
		$this->WP_Widget('dts_content_genres', __d('DooPlay - [widgetgenre] Genres'), $widget_ops, $control_ops );
	}
	function widget( $args, $instance ) {
		extract( $args );
		//Our variables from the widget settings.

		$title = apply_filters('widget_title', $instance['title'] );
		$num = $instance['dt_nun'];
		$tipo = $instance['dt_tipo'];
		$genre = $instance['dt_genre'];
		$speed = $instance['dt_speed'];
		$rand = $instance[ 'dt_rand' ] ? 'rand' : 'false';
		$autoplay = $instance[ 'dt_autoplay' ] ? 'true' : 'false';

		echo $before_widget;
		// Display Widget title 
		if (is_home()) {
		if ( $title )
		echo '<header>';
		echo $before_title . $title . $after_title;
		?>
		<div class="nav_items_module">
		  <a class="btn next_<?php echo $genre; ?>"><i class="icon-caret-left"></i></a>
		  <a class="btn prev_<?php echo $genre; ?>"><i class="icon-caret-right"></i></a>
		</div>
		<span><?php //echo dt_count_taxonomy( $genre ); ?> <a href="<?php echo esc_url( home_url() ) .'/'. DT_GENRE .'/'. $genre .'/'; ?>" class="see-all"><?php _d('See all'); ?></a></span>
		<?php
		echo '</header>';
		echo '<div class="genreload load_modules">'. __d('Loading..'). '</div>';
		//Display Query posts
		$dd = new WP_Query( array('genres' => $genre, 'post_type' => $tipo, 'showposts' => $num, 'orderby' => $rand ) ); ?>
		<div id="genre_<?php echo $genre; ?>" class="list_genres items">      
        <?php while ( $dd->have_posts() ) : $dd->the_post(); ?>
            <?php get_template_part('inc/parts/item'); ?>
        <?php endwhile; ?>
		</div>
		<script>
		jQuery(document).ready(function($) {
			var owl = $("#genre_<?php echo $genre; ?>");
			owl.owlCarousel({
				items : 5,
				<?php if($autoplay =='true') { echo 'autoPlay: '.$speed.','; } else { echo 'autoPlay: false,'; } ?>
				stopOnHover : true,
				pagination : false,
				itemsDesktop : [1199,5],
				itemsDesktopSmall : [980,5],
				itemsTablet: [768,4],
				itemsTabletSmall: false,
				itemsMobile : [479,3],
			});
			$(".next_<?php echo $genre; ?>").click(function(){
				owl.trigger('owl.prev');
			 })
			 $(".prev_<?php echo $genre; ?>").click(function(){
				owl.trigger('owl.next');
			 })
		});
		</script>
		<?php wp_reset_query(); ?>

		<?php
		} else { 
			echo '<div class="error_widget">';
			_d('Error: only homepage');
			echo '</div>';
		}
		// End Query
		echo $after_widget;
	}
	//Update the widget 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//Strip tags from title and name to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['dt_nun'] = strip_tags( $new_instance['dt_nun'] );
		$instance['dt_tipo'] = strip_tags( $new_instance['dt_tipo'] );
		$instance['dt_genre'] = strip_tags( $new_instance['dt_genre'] );
		$instance['dt_rand'] = strip_tags( $new_instance['dt_rand'] );
		$instance['dt_autoplay'] = strip_tags( $new_instance['dt_autoplay'] );
		$instance['dt_speed'] = strip_tags( $new_instance['dt_speed'] );
		return $instance;
	}
	function form( $instance ) {
		//Set up some default widget settings.
		$defaults = array('title' => '', 'dt_nun' => '10', 'dt_tipo' => '', 'dt_genre' => '', 'dt_rand' => 'false', 'dt_autoplay' => 'false', 'dt_speed' => '4000');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _d('Title'); ?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('dt_tipo'); ?>"><?php _d('Content type'); ?></label>
			<select id="<?php echo $this->get_field_id('dt_tipo'); ?>" name="<?php echo $this->get_field_name('dt_tipo'); ?>" style="width:100%;">
				<option <?php if ('' == $instance['dt_tipo'] ) echo 'selected="selected"'; ?> value=""><?php _d('All'); ?></option>
				<option <?php if ('movies' == $instance['dt_tipo'] ) echo 'selected="selected"'; ?> value="movies"><?php _d('Movies'); ?></option>
				<option <?php if ('tvshows' == $instance['dt_tipo'] ) echo 'selected="selected"'; ?> value="tvshows"><?php _d('TV Shows'); ?></option>
            </select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('dt_genre'); ?>"><?php _d('Genre'); ?></label>
			<select name="<?php echo $this->get_field_name('dt_genre'); ?>" id="<?php echo $this->get_field_name('dt_genre'); ?>" style="width:100%;">
			<?php $terms = get_terms('genres'); foreach ($terms as $term) { ?>
				<option <?php if ( $term->slug == $instance['dt_genre'] ) echo 'selected="selected"'; ?> value="<?php echo $term->slug; ?>"><?php echo $term->name; ?> (<?php echo $term->count; ?>)</option>
			<?php } ?>
			</select>
		</p>
		
		<h4 class="dth4w">Carousel control</h4>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance[ 'dt_autoplay' ], 'on'); ?> id="<?php echo $this->get_field_id('dt_autoplay'); ?>" name="<?php echo $this->get_field_name('dt_autoplay'); ?>" /> 
			<label for="<?php echo $this->get_field_id('dt_autoplay'); ?>"> <?php _d('Autoplay Carousel'); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('dt_speed'); ?>"><?php _d('Speed Carousel'); ?></label>
			<select id="<?php echo $this->get_field_id('dt_speed'); ?>" name="<?php echo $this->get_field_name('dt_speed'); ?>" style="width:100%;">
				<option <?php if ('1000' == $instance['dt_speed'] ) echo 'selected="selected"'; ?> value="1000">1 <?php _d('second'); ?></option>
				<option <?php if ('2000' == $instance['dt_speed'] ) echo 'selected="selected"'; ?> value="2000">2 <?php _d('seconds'); ?></option>
				<option <?php if ('3000' == $instance['dt_speed'] ) echo 'selected="selected"'; ?> value="3000">3 <?php _d('seconds'); ?></option>
				<option <?php if ('4000' == $instance['dt_speed'] ) echo 'selected="selected"'; ?> value="4000">4 <?php _d('seconds'); ?></option>
				<option <?php if ('5000' == $instance['dt_speed'] ) echo 'selected="selected"'; ?> value="5000">5 <?php _d('seconds'); ?></option>
            </select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('dt_nun'); ?>"><?php _d('Items number'); ?></label>
			<input type="number" id="<?php echo $this->get_field_id('dt_nun'); ?>" name="<?php echo $this->get_field_name('dt_nun'); ?>" value="<?php echo $instance['dt_nun']; ?>" min="2" max="50" style="width:100%;">
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance[ 'dt_rand' ], 'on'); ?> id="<?php echo $this->get_field_id('dt_rand'); ?>" name="<?php echo $this->get_field_name('dt_rand'); ?>" /> 
			<label for="<?php echo $this->get_field_id('dt_rand'); ?>"> <?php _d('Activate random order'); ?></label>
		</p>

	<?php
	}

}