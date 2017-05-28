<?php 

$dt_player	= get_post_meta($post->ID, 'repeatable_fields', true); 
$reports	= get_post_meta($post->ID, 'numreport', true);
$views		= dt_get_meta('dt_views_count');
$light		= get_option('dt_player_luces','true');
$report		= get_option('dt_player_report','true');
$ads		= get_option('dt_player_ads','not');
$qual		= get_option('dt_player_quality','true');
$viewsc		= get_option('dt_player_views','true');
$clic		= get_option('dt_player_ads_hide_clic','true');
$time		= get_option('dt_player_ads_time','20');
$ads_300	= get_option('dt_player_ads_300');
// Player
?>
<div id="playex" class="player_sist">
	<?php get_template_part('inc/parts/single/report-video'); ?>
	<?php  if ( $dt_player ) : ?>
	<div class="playex">
		<?php  if ($ads =='true') : ?>
		<div id="playerads" class="ads_player">
			<div class="ads_box">
				<div class="ads">
					<?php if($ads_300) : echo '<div class="code">'. stripslashes($ads_300). '</div>'; endif; ?>
					<?php if ($clic =='true'): ?><span class="notice"><?php _d('click on ad to close'); ?></span><?php endif; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<?php $numerado = 1; { foreach ( $dt_player as $field ) { ?>
		<?php if($field['select'] == 'iframe') {  ?>
			<div id="option-<?php echo $numerado; ?>" class="play-box-iframe fixidtab">
				<<?php echo 'iframe'; ?> class="metaframe rptss" src="<?php echo $field['url']; ?>" frameborder="0" allowfullscreen></iframe>
			</div>
		<?php } if($field['select'] == 'youtube') {  ?>
			<div id="option-<?php echo $numerado; ?>" class="play-box-iframe fixidtab">
				<<?php echo 'iframe'; ?> class="metaframe rptss" src="https://www.youtube.com/embed/<?php echo $field['url']; ?>?autoplay=1&amp;rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
			</div>
		<?php } if($field['select'] == 'videoapi') {  ?>
			<div id="option-<?php echo $numerado; ?>" class="play-box-iframe fixidtab">
				<?php //echo do_shortcode('[videoapi link="https://drive.google.com/open?id='.$field['url'].'"]'); ?>
			</div>
		<?php } if($field['select'] == 'sibeol') {  ?>
			<div id="option-<?php echo $numerado; ?>" class="play-box-iframe fixidtab">
				<?php echo html_entity_decode($field['url']); ?>
			</div>
		<?php } if($field['select'] == 'mp4') {  ?>
			<div id="option-<?php echo $numerado; ?>" class="play-box-mp4 fixidtab">
				<?php //echo do_shortcode('[video src="' . $field['url'] .'" width="779px" autoplay="false"]'); ?>

				<?php dt_video( $post->ID , $field['url']); ?>
			</div>
		<?php } if($field['select'] == 'dtshcode') {  ?>
			<div id="option-<?php echo $numerado; ?>" class="play-box-shortcode fixidtab">
				<?php echo do_shortcode($field['url']); ?>
			</div>
		<?php } $numerado++; } } ?> 
	</div>
	<?php endif; ?>
	<div class="control">
		<nav class="player">
			<ul class="options">
				<li>
					<a class="sources"><i class="icon-menu listsormenu"></i> <b><?php _d('Options'); ?></b></a>
					<?php  if ( $dt_player ) : ?>
						<ul class="idTabs sourceslist scrolling">
						<?php $numerado = 1; { foreach ( $dt_player as $field ) { ?>
							<li><a class="options" href="#option-<?php echo $numerado; ?>">
							<b class="icon-play_arrow"></b> <?php echo $field['name']; ?> 
							<?php if($field['idioma']) { ?><span class="dt_flag"><img src="<?php echo DT_DIR_URI, '/assets/img/flags/',$field['idioma'],'.png'; ?>"></span><?php } ?>
							</a></li>
						<?php $numerado++; } } ?> 
						</ul>
					<?php endif; ?>
				</li>
			</ul>
		</nav>
		<?php if ($qual =='true') : if($quali = $terms = strip_tags( $terms = get_the_term_list( $post->ID, 'dtquality'))) {  ?>
			<?php if($mostrar = $terms = strip_tags( $terms = get_the_term_list( $post->ID, 'dtquality'))) {  ?><span class="qualityx"><?php echo $mostrar; ?></span><?php } ?>
		<?php } endif; ?>
		<?php if ($viewsc =='true') : if($views) { echo '<span class="views"><strong>'. comvert_number($views) .'</strong> '. __d('Views') .'</span>'; } endif; ?>
		<nav class="controles">
			<ul class="list">
				<?php  if ($ads =='true') : ?><li id="count" class="contadorads"><?php _d('Ad'); ?> <i id="contador"><?php echo $time; ?></i></li><?php endif; ?>
				<?php  if ($light =='true') : ?><li><a class="lightSwitcher" href="javascript:void(0);"><i class="icon-wb_sunny"></i></a></li><?php endif; ?>
				<?php  if ($report =='true') : if($reports=='10') { /* none*/ } else { ?><li><a class="report-video"><i class="icon-notification"></i> <span><?php _d('report'); ?></span></a></li><?php } endif; ?>
				<li><a class="wide"><i class="icons-enlarge2"></i></a></li>
			</ul>
		</nav>
	</div>
</div>
<script type='text/javascript'>
	jQuery(document).ready(function($){
	$("#oscuridad").css("height", $(document).height()).hide();
	$(".lightSwitcher").click(function(){
	$("#oscuridad").toggle();
	if ($("#oscuridad").is(":hidden"))
	$(this).html("<i class='icon-wb_sunny'></i>").removeClass("turnedOff");
		else
	$(this).html("<i class='icon-wb_sunny'></i>").addClass("turnedOff");
		});
<?php  if ($ads =='true') : ?>
	var segundos = <?php echo $time; ?>; 
	function ads_time(){  
		var t = setTimeout( ads_time, 1000); 
		document.getElementById('contador').innerHTML = '' +segundos--+'';  
		if (segundos==0){
			$('#playerads').fadeOut('slow');
			$('#count').fadeOut('slow');
			clearInterval(setTimeout);
		}  
	}
	ads_time();
<?php endif; ?>
<?php if ($clic =='true'): ?>
		$(".code").click(function() {
		  $("#playerads").fadeOut("slow");
		  $("#count").fadeOut("slow");
		});
		$(".notice").click(function() {
		  $("#playerads").fadeOut("slow");
		  $("#count").fadeOut("slow");
		});
<?php endif; ?>
	$(".options").click(function() {
	  $('.rptss').attr('src', function ( i, val ) { return val; });
	});
	});
</script>