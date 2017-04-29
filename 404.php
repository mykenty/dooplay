<?php


get_header(); ?>
<div class="module">
	<?php get_template_part('inc/parts/sidebar'); ?>
	<div class="content">
		<header><h1><?php _d('Page not found'); ?></h1></header>
		<div class="search-page">
			<div class="no-result animation-2">
				<h2><?php //_d('ERROR'); ?>Link không đúng</h2>
				<div style="font-size:18px;color:Red;width:100%"><center><img src="/wp-content/uploads/404.jpg" alt="404" /><br /> Hãy cố gắng tìm chứ đừng rời bỏ em!!!</center></div>
				<strong><?php //_d('Suggestions'); ?>Nguyên nhân:</strong>
				<i class="icon-data_usage"></i>
				<ul>
					<li>Web vừa thay đổi nên 1 số link không còn đúng nữa, bạn vui lòng dùng chức năng tìm kiếm hoặc danh mục góc phải</li>
					<li>Trong trường hợp không tìm thấy vui lòng liên hệ Admin cakhuc@gmail.com</li>
					<!--<li><?php _d('Verify that the link is correct.'); ?></li>
					<li><?php _d('Use the search box on the page.'); ?></li>
					<li><?php _d('Contact support page.'); ?></li>-->
				</ul>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>