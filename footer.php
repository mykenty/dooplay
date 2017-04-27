</div>
<footer class="main">
	<div class="fbox">
		<?php wp_nav_menu( array(
			'theme_location'=>'footer',
			'container'=>'div',
			'container_id'=>'footer',
			'container_class'=>'fmenu',
			'menu_class'=>'dt_menu_footer',
			'menu_id'=>'footer_dt',
			'fallback_cb'=>false
		) ); ?>
		<div class="copy"><?php bloginfo('name'); ?> &copy; <?php echo date('Y'); ?></div>
	</div>
</footer>
</div>
<?php wp_footer(); ?><p></p>
	<?php $footer = get_option('dt_footer_code'); if($footer) { echo stripslashes( $footer ); } ?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			 $(".reset").click(function(event){
				if (!confirm("<?php _d('Really you want to restart all data??'); ?>"))
				   event.preventDefault();
			});
			$(".addcontent").click(function(event){
				if (!confirm("<?php _d('They sure have added content manually?'); ?>"))
				   event.preventDefault();
			});
		});
	</script>
	<div id="oscuridad"/></div>
	</body>
</html>