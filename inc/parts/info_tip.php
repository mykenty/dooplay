<div class="animation-1 dtinfo">
	<div class="title">
		<i class="dt-<?php echo get_post_type(); ?>"></i>
		<?php the_title(); ?>
	</div>
	<div class="texto"><?php dt_content('',TRUE,'',60); ?><div class="degradado"></div></div>
	<div class="rating">
	<?php $values = dt_get_meta( DT_MAIN_RATING ); ?> 
		<div class="datareviews">
			<div class="datarating">
				<span class="rating-stars-a">
					<i class="icon-star2"></i>
					<i class="icon-star2"></i>
					<i class="icon-star2"></i>
					<i class="icon-star2"></i>
					<i class="icon-star2"></i>
					<i class="icon-star2"></i>
					<i class="icon-star2"></i>
					<i class="icon-star2"></i>
					<i class="icon-star2"></i>
					<i class="icon-star2"></i>
				</span>
				<span class="rating-stars-b" style="width: <?php echo $values*10; ?>%;">
					<i class="icon-star2"></i>
					<i class="icon-star2"></i>
					<i class="icon-star2"></i>
					<i class="icon-star2"></i>
					<i class="icon-star2"></i>
					<i class="icon-star2"></i>
					<i class="icon-star2"></i>
					<i class="icon-star2"></i>
					<i class="icon-star2"></i>
					<i class="icon-star2"></i>
				</span>                        
			</div>
			<div class="rating_right">
			<span class="rating-value"><?php if($c = $values) { echo $c; } else { echo '0'; } ?></span>
			<b>/<?php if($votes = dt_get_meta( DT_MAIN_VOTOS )) { echo $votes; } else { echo '0'; } ?></b>
			</div>
		</div>
	</div>
</div>
