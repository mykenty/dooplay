<?php 


get_header(); ?>
<div class="module">
	<div class="content">
	<?php if($_GET['letter']=='true') {
		get_template_part('pages/letter'); 
	} else {
		get_template_part('pages/search'); 
	} ?> 
	<?php if (function_exists("pagination")) { pagination($additional_loop->max_num_pages); } ?>
	</div>
	<?php get_template_part('inc/parts/sidebar'); ?>
</div>
<?php get_footer(); ?>