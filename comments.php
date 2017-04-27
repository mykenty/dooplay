<?php

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
	<h2 class="comments-title">
	<i class="icon-account_circle"></i> 
		<?php
			printf( _n('(1) comment', '(%1$s) comments', get_comments_number() ),
				number_format_i18n( get_comments_number() ), get_the_title() );
		?>
	</h2>
		<?php echo '<ul class="post-comments">';
					$args = dt_comments_args();
					wp_list_comments( $args );
				echo '</ul>';
		?>
	<?php if ( get_comment_pages_count() > 1 && get_option('page_comments') ) : ?>
	<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
		<div class="nav-previous"><?php previous_comments_link( __d('&larr; Older Comments') ); ?></div>
		<div class="nav-next"><?php next_comments_link( __d('Newer Comments &rarr;') ); ?></div>
	</nav><!-- #comment-nav-below -->
	<?php endif; // Check for comment navigation. ?>
	<?php endif; // have_comments() ?>
	<?php if ( ! $comments_open ) { echo $comments_closed_notice; } $comments_args = dt_theme_comments_args(); comment_form( $comments_args ); ?>	
	<?php if ( ! comments_open() ) : ?>
	<div class="no-comments"><?php _d('Comments are closed.'); ?></div>
	<?php endif; ?>
</div><!-- #comments -->