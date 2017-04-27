<?php


function box_links() {
	add_meta_box('links_box_meta', __d('Links'),'links_box','movies','normal','default');
	add_meta_box('links_box_meta', __d('Links'),'links_box','episodes','normal','default');
}
add_action('add_meta_boxes', 'box_links');
function links_box( $post) { ?>

<div class="box_links">
<?php get_template_part('inc/parts/single/listas/links_admin'); ?>
</div>
<?php }
