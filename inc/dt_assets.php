<?php


function dt_styles()  {
	$theme = get_option('dt_color_style','default');
	wp_enqueue_style('owl-carousel', DT_DIR_URI .'/assets/css/owl.carousel.css' , array(), DT_VERSION, 'all');
    wp_enqueue_style('fonts', 'https://fonts.googleapis.com/css?family='. DT_FONT .':300,400,500,700' , array(), DT_VERSION, 'all');
	wp_enqueue_style('icons', DT_DIR_URI .'/assets/css/icons.css' , array(), DT_VERSION, 'all');
	wp_enqueue_style('scrollbar', DT_DIR_URI .'/assets/css/scrollbar.css' , array(), DT_VERSION, 'all');
	wp_enqueue_style('theme', DT_DIR_URI .'/assets/css/main.css' , array(), DT_VERSION, 'all');
	wp_enqueue_style('color-scheme', DT_DIR_URI .'/assets/css/'.$theme.'.css' , array(), DT_VERSION, 'all');
	wp_enqueue_style('responsive', DT_DIR_URI .'/assets/css/responsive.css' , array(), DT_VERSION, 'all');
	#wp_enqueue_style('style', get_stylesheet_uri(), array(), DT_VERSION, true  );
}
add_action('wp_enqueue_scripts', 'dt_styles'); 
/* javascript */
function dt_scripts()  
{
	
	wp_enqueue_script('scrollbar',  DT_DIR_URI .'/assets/js/scrollbar.js' , array('jquery'), DT_VERSION, false );
	wp_enqueue_script('owl',  DT_DIR_URI .'/assets/js/owl.carousel.min.js' , array('jquery'), DT_VERSION, false  );
	if(is_single()) {  wp_enqueue_script('idTabs',  DT_DIR_URI .'/assets/js/idtabs.js' , array('jquery'), DT_VERSION, false  ); }
	if(is_page()) {  wp_enqueue_script('idTabs',  DT_DIR_URI .'/assets/js/idtabs.js' , array('jquery'), DT_VERSION, false  ); }
	if(is_author()) {  wp_enqueue_script('idTabs',  DT_DIR_URI .'/assets/js/idtabs.js' , array('jquery'), DT_VERSION, false  ); }
	if(is_single()) {  wp_enqueue_script('dtRepeat',  DT_DIR_URI .'/assets/js/jquery.repeater.js' , array('jquery'), DT_VERSION, false  ); }
	wp_enqueue_script('scripts',  DT_DIR_URI .'/assets/js/scripts.js' , array('jquery'), DT_VERSION, true  );
    if ( is_singular() && get_option('thread_comments') ) { 
		wp_enqueue_script('comment-reply');
		wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js', array(), DT_VERSION, false );
	}
}  
add_action('wp_enqueue_scripts', 'dt_scripts'); 

// Live Search
function live_search() {
	wp_enqueue_script('live_search', DT_DIR_URI .'/assets/js/live.search.js', array('jquery'), DT_VERSION, true );
	wp_localize_script( 
		'live_search', 
		'dtGonza', 
		array( 
			'api' => dooplay_url_search(),
			'nonce' => dooplay_create_nonce('dooplay-search-nonce'),
			'area' => ".live-search",
			'button' => ".search-button",
			'more' => __d('View all results'),
			) 
		);
}
add_action('wp_enqueue_scripts', 'live_search'); 


/* owl controls */
function owl_controls() { ?>
<script type="text/javascript">
<?php if(is_single()) { ?>
// Gallery 
jQuery(document).ready(function($) {
  $("#dt_galery").owlCarousel({
	autoPlay: 3000, //Set AutoPlay to 3 seconds
	items : 3,
	autoPlay: false,
	itemsDesktop : [1199,3],
    itemsDesktopSmall : [980,3],
    itemsTablet: [768,3],
    itemsTabletSmall: false,
    itemsMobile : [479,1],
  });
});
// Gallery episodes
jQuery(document).ready(function($) {
  $("#dt_galery_ep").owlCarousel({
	autoPlay: 3000, //Set AutoPlay to 3 seconds
	items : 2,
	autoPlay: false
  });
});
// OWL Movies
jQuery(document).ready(function($) {
  var owl = $("#single_relacionados");
	owl.owlCarousel({
	items : 6,
	autoPlay: 3000,
	stopOnHover : true,
	pagination : false,
	itemsDesktop : [1199,6],
    itemsDesktopSmall : [980,6],
    itemsTablet: [768,5],
    itemsTabletSmall: false,
    itemsMobile : [479,3],
  });
  // Custom Navigation Events
  $(".next3").click(function(){
    owl.trigger('owl.next');
  })
  $(".prev3").click(function(){
    owl.trigger('owl.prev');
  })
	  // end botons
});
<?php } else { ?>
// OWL Movies
<?php if(get_option('dt_mm_activate_slider') == 'true') { ?>
jQuery(document).ready(function($) {
  var owl = $("#dt-movies");
	owl.owlCarousel({
	<?php if(get_option('dt_mm_autoplay_slider') == 'true') { ?>
	autoPlay: 3500, 
	<?php } else { ?>
	autoPlay: false,
	<?php } ?>
	items : 5,
	stopOnHover : true,
	pagination : false,
	itemsDesktop : [1199,5],
    itemsDesktopSmall : [980,5],
    itemsTablet: [768,4],
    itemsTabletSmall: false,
    itemsMobile : [479,3],
  });
  // Custom Navigation Events
<?php if(get_option('dt_mm_autoplay_slider') == 'true') { } else { ?>
  $(".next3").click(function(){
    owl.trigger('owl.next');
  })
  $(".prev3").click(function(){
    owl.trigger('owl.prev');
  })
<?php } ?>
	  // end botons
});
<?php } ?>

// OWL TVshows
<?php if(get_option('dt_mt_activate_slider') == 'true') { ?>
jQuery(document).ready(function($) {
  var owl = $("#dt-tvshows");
	owl.owlCarousel({
	<?php if(get_option('dt_mt_autoplay_slider') == 'true') { ?>
	autoPlay: 3500, 
	<?php } else { ?>
	autoPlay: false,
	<?php } ?>
	items : 5,
	stopOnHover : true,
	pagination : false,
	itemsDesktop : [1199,5],
    itemsDesktopSmall : [980,5],
    itemsTablet: [768,4],
    itemsTabletSmall: false,
    itemsMobile : [479,3],
  });

	var owl2 = $("#dt-tvshows2");
	owl2.owlCarousel({
	<?php if(get_option('dt_mt_autoplay_slider') == 'true') { ?>
	autoPlay: 3500, 
	<?php } else { ?>
	autoPlay: false,
	<?php } ?>
	items : 5,
	stopOnHover : true,
	pagination : false,
	itemsDesktop : [1199,5],
    itemsDesktopSmall : [980,5],
    itemsTablet: [768,4],
    itemsTabletSmall: false,
    itemsMobile : [479,3],
  });

	var owl3 = $("#dt-tvshows3");
	owl3.owlCarousel({
	<?php if(get_option('dt_mt_autoplay_slider') == 'true') { ?>
	autoPlay: 3500, 
	<?php } else { ?>
	autoPlay: false,
	<?php } ?>
	items : 5,
	stopOnHover : true,
	pagination : false,
	itemsDesktop : [1199,5],
    itemsDesktopSmall : [980,5],
    itemsTablet: [768,4],
    itemsTabletSmall: false,
    itemsMobile : [479,3],
  });

	var owl4 = $("#dt-tvshows4");
	owl4.owlCarousel({
	<?php if(get_option('dt_mt_autoplay_slider') == 'true') { ?>
	autoPlay: 3500, 
	<?php } else { ?>
	autoPlay: false,
	<?php } ?>
	items : 5,
	stopOnHover : true,
	pagination : false,
	itemsDesktop : [1199,5],
    itemsDesktopSmall : [980,5],
    itemsTablet: [768,4],
    itemsTabletSmall: false,
    itemsMobile : [479,3],
  });

	var owl5 = $("#dt-tvshows5");
	owl5.owlCarousel({
	<?php if(get_option('dt_mt_autoplay_slider') == 'true') { ?>
	autoPlay: 3500, 
	<?php } else { ?>
	autoPlay: false,
	<?php } ?>
	items : 5,
	stopOnHover : true,
	pagination : false,
	itemsDesktop : [1199,5],
    itemsDesktopSmall : [980,5],
    itemsTablet: [768,4],
    itemsTabletSmall: false,
    itemsMobile : [479,3],
  });

  // Custom Navigation Events
<?php if(get_option('dt_mt_autoplay_slider') == 'true') { } else { ?>
  $(".next4").click(function(){
		console.log('owl.next');
		console.log(owl);
    owl.trigger('owl.next');
  })
  $(".prev4").click(function(){
		console.log(owl);
    owl.trigger('owl.prev');
  })

	$(".next5").click(function(){
		console.log(owl2);
    owl2.trigger('owl.next');
  })
  $(".prev5").click(function(){
		console.log(owl2);
    owl2.trigger('owl.prev');
  })

	$(".next6").click(function(){
    owl3.trigger('owl.next');
  })
  $(".prev6").click(function(){
    owl3.trigger('owl.prev');
  })

	$(".next7").click(function(){
    owl4.trigger('owl.next');
  })
  $(".prev7").click(function(){
    owl4.trigger('owl.prev');
  })

	$(".next8").click(function(){
    owl5.trigger('owl.next');
  })
  $(".prev8").click(function(){
    owl5.trigger('owl.prev');
  })
<?php } ?>
	  // end botons
});
<?php } ?>
// OWL Episodes
jQuery(document).ready(function($) {
  var owl = $("#dt-episodes");
  owl.owlCarousel({
	<?php if(get_option('dt_me_autoplay_slider') == 'true') { ?>
	autoPlay: 3500, 
	<?php } else { ?>
	autoPlay: false,
	<?php } ?>
	pagination : false,
	items : 3,
	stopOnHover : true,
	itemsDesktop : [900,3],
	itemsDesktopSmall : [750,3],
	itemsTablet: [500,2],
	itemsMobile : [320,1]
  });
  // Custom Navigation Events
<?php if(get_option('dt_me_autoplay_slider') == 'true') { } else { ?>
  $(".next").click(function(){
    owl.trigger('owl.next');
  })
  $(".prev").click(function(){
    owl.trigger('owl.prev');
  })
<?php } ?>
	  // end botons
});

// OWL Seasons
jQuery(document).ready(function($) {
  var owl = $("#dt-seasons");
	owl.owlCarousel({
	<?php if(get_option('dt_ms_autoplay_slider') == 'true') { ?>
	autoPlay: 3500, 
	<?php } else { ?>
	autoPlay: false,
	<?php } ?>
	items : 5,
	stopOnHover : true,
	pagination : false,
	itemsDesktop : [1199,5],
    itemsDesktopSmall : [980,5],
    itemsTablet: [768,4],
    itemsTabletSmall: false,
    itemsMobile : [479,3],
  });
  // Custom Navigation Events
<?php if(get_option('dt_ms_autoplay_slider') == 'true') { } else { ?>
  $(".next2").click(function(){
    owl.trigger('owl.next');
  })
  $(".prev2").click(function(){
    owl.trigger('owl.prev');
  })
<?php } ?>
	  // end botons
});

// OWL Movies Slider
jQuery(document).ready(function($) {
  var owl = $("#slider-movies");
  owl.owlCarousel({
	<?php if(get_option('dt_autoplay_s_movies') =='true') { ?>
	autoPlay: <?php echo get_option('dt_slider_speed','3000'); ?>,
	<?php } else { ?>
	autoPlay: false,
	<?php } ?>
	items : 2,
	stopOnHover : true,
	pagination : true,
	itemsDesktop : [1199,2],
    itemsDesktopSmall : [980,2],
    itemsTablet: [768,2],
    itemsTabletSmall: [600,1],
    itemsMobile : [479,1]
  });
  // Custom Navigation Events
});

// OWL TVShows Slider
jQuery(document).ready(function($) {
  var owl = $("#slider-tvshows");
  owl.owlCarousel({
	<?php if(get_option('dt_autoplay_s_tvshows') =='true') { ?>
	autoPlay: <?php echo get_option('dt_slider_speed','3000'); ?>,
		<?php } else { ?>
	autoPlay: false,
		<?php } ?>
	items : 2,
	stopOnHover : true,
	pagination : true,
	itemsDesktop : [1199,2],
    itemsDesktopSmall : [980,2],
    itemsTablet: [768,2],
    itemsTabletSmall: [600,1],
    itemsMobile : [479,1]
  });
  // Custom Navigation Events
});

// OWL Movies - TVShows Slider
jQuery(document).ready(function($) {
  var owl = $("#slider-movies-tvshows");
  owl.owlCarousel({
		<?php if(get_option('dt_autoplay_s') =='true') { ?>
		autoPlay: <?php echo get_option('dt_slider_speed','3000'); ?>,
			<?php } else { ?>
		autoPlay: false,
			<?php } ?>
		items : 2,
		stopOnHover : true,
		pagination : true,
		itemsDesktop : [1199,2],
		itemsDesktopSmall : [980,2],
		itemsTablet: [768,2],
		itemsTabletSmall: [600,1],
		itemsMobile : [479,1]
  });
  // Custom Navigation Events
});

 // Slider Master
jQuery(document).ready(function($) {
  var owl = $("#slider-master");
  owl.owlCarousel({
		<?php if(get_option('dt_main_slider_autoplay') =='true') { ?>
		autoPlay: <?php $speed = get_option('dt_main_slider_speed','3000'); echo $speed; ?>,
			<?php } else { ?>
		autoPlay: false,
			<?php } ?>
		items : 3,
		stopOnHover : true,
		pagination : true,
		itemsDesktop : [1199,3],
		itemsDesktopSmall : [980,2],
		itemsTablet: [768,2],
		itemsTabletSmall: [600,1],
		itemsMobile : [479,1]
  });
});
<?php } ?>

<?php if(1==1) { global $user_ID; if( $user_ID ) : if( current_user_can('level_10') ) : ?>
jQuery(document).ready(function($) {
    $(".dtload").click(function() {
        var o = $(this).attr("id");
        1 == o ? ($(".dtloadpage").hide(), $(this).attr("id", "0")) : ($(".dtloadpage").show(), $(this).attr("id", "1"))
    }), $(".dtloadpage").mouseup(function() {
        return !1
    }), $(".dtload").mouseup(function() {
        return !1
    }), $(document).mouseup(function() {
        $(".dtloadpage").hide(), $(".dtload").attr("id", "")
    })
})
<?php endif; endif; } ?>
</script>
<?php }
add_action('wp_footer', 'owl_controls');


/* facebook JS */
function dt_fb_js() { if(1==1) { if( get_option('dt_commets') == 'comtfb') { ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.9";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php	
		} 
	} 
} 
add_action('wp_head', 'dt_fb_js');
function dt_fb_js_page() { if(is_page()) { if( get_option('dt_commets') == 'comtfb') { ?>
<div id="fb-root"></div>
<script type="text/javascript">
	(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/<?php echo get_option('dt_app_language_facebook'); ?>/sdk.js#xfbml=1&version=v2.6&appId=<?php echo get_option('dt_app_id_facebook'); ?>";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
<?php	
		} 
	} 
} 
add_action('wp_head', 'dt_fb_js_page');
/* Custom JS */
function dt_analytics_js() { 
	if( $c = get_option('dt_google_analytics')) { ?>
<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', '<?php echo $c; ?>', 'auto');
  ga('send', 'pageview');
</script>
<?php	}

} add_action('wp_footer', 'dt_analytics_js');
