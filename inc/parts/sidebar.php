<div class="sidebar scrolling">
	<div class="fixed-sidebar-blank">
		<?php if($widgets = dynamic_sidebar('sidebar-home')) { $widgets; } else { echo '<a href="'. esc_url( home_url() ) .'/wp-admin/widgets.php">'. __d('Add widgets') .'</a>'; } ?>
	</div>
</div>