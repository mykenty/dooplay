<div itemscope itemtype="http://schema.org/<?php echo esc_attr( starstruck_get_microdata_schema() ); ?>">
	<meta itemprop="name" content="<?php echo esc_attr( starstruck_get_microdata_name() ); ?>">
	<?php do_action('starstruck_microdata'); ?>
	<div itemscope class="starstruck-wrap" itemprop="aggregateRating" itemtype="http://schema.org/AggregateRating">
		<meta itemprop="bestRating" content="10"/>
		<meta itemprop="worstRating" content="1"/>
		<div class="dt_rating_data">
			<?php echo starstruck_return_content_span( $id, $rating, $type ); ?>
			<section class="nope starstruck-rating-wrap">
				<?php if ( starstruck_require_user_login() ) : ?>
				<?php echo apply_filters('starstruck_read_only_sidebar_notice', __d('Log in to vote') ); ?>
				<?php else: ?>
				<?php _d('Your rating:'); ?> <span class="rating-yours"><?php echo $your_rating; ?></span>
				<?php endif; ?>
			</section>
			<div class="starstruck-rating">
				<span class="dt_rating_vgs" itemprop="ratingValue"><?php echo $rating; ?></span>
				<i class="icon-account_circle"></i> <span class="rating-count" itemprop="ratingCount"><?php echo number_format( $votes ); ?></span> <span class="rating-text"><?php echo _n('vote', 'votes', $votes ); ?></span>
			</div>
		</div>
	</div>
</div>
