<?php


if( get_option('dt_commets') == 'comtwp') { comments_template('', true); } ?>
<?php if( get_option('dt_commets') == 'comtfb') { ?> 
<div id="comments" class="extcom">
	<div class="fb-comments" data-href="<?php the_permalink() ?>" data-numposts="<?php echo get_option('dt_number_comments_facebook','10'); ?>" data-width="100%" data-colorscheme="<?php echo get_option('dt_scheme_color_facebook','light'); ?>"></div>
</div>
<?php } if( get_option('dt_commets') == 'comtdi') { ?>
<div id="comments" class="extcom">
<?php if ( $dato = get_option('dt_shortname_disqus')) { ?>
	<div id="disqus_thread"></div>
	<script type="text/javascript">
			var disqus_shortname = '<?php echo $dato; ?>';
			(function() {
				var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
				dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
				(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
			})();
	</script>
<?php } else { ?>
<?php _d("<strong>Disqus:</strong> add shortname your comunity, <a href=\"https://help.disqus.com/customer/portal/articles/466208-what-s-a-shortname-\" target=\"_blank\">more info</a>"); ?>
<?php } ?>
</div>
<?php } ?>
