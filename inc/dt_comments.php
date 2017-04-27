<?php


function dt_comments_args( $args = array() ){
	$comments_args = array(
		'avatar_size' => 60,
		'style' => 'ul',
		'callback' => 'dt_theme_comment_template'
	);
	return wp_parse_args( $args, $comments_args );
}
function dt_theme_comment_template($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
	$tag =  ('div' == $args['style'] ) ? 'div' : 'li';
	$add_below = 'comment-inner';
?>
	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<div class="comment-avatar">
		<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	</div>
	<div class="scontent">
		<div id="comment-inner-<?php comment_ID() ?>">
			<div class="comment-header">
				<?php 
					if( $comment->user_id > 0 ){
						echo ''. get_user_option('display_name', $comment->user_id ) .'';
					}
					else{
						printf( __d('%s'), get_comment_author_link() );
					}
				?>
				<?php  ?>
				<span class="comment-time"><?php printf( __d('%1$s'), get_comment_date() ); ?></span>
				<?php 
					comment_reply_link( array_merge( $args, 
						array( 
							'add_below' => $add_below, 
							'depth' => $depth, 
							'max_depth' => $args['max_depth'] 
						) 
					) ); 
				?>
			</div>
			<?php if ( $comment->comment_approved == '0') { ?>
				<em class="text-red"><?php _d('Your comment is awaiting moderation.'); ?></em>
			<?php } ?>
			<?php comment_text(); ?>
		</div>
	</div>
<?php }
// Form comments
function dt_theme_comments_args(){
	$commenter = wp_get_current_commenter();
	$required =  ' <em class="text-red" title="'. __d('Required') .'">*</em>';
	$comments_args = array(
		'label_submit' => __d('Post comment'),
		'title_reply' => __d('Leave a comment'),
		'logged_in_as' => '',
		'comment_notes_after' => '',
		'comment_notes_before' => '',
		'comment_field' => '
			<div class="comment-form-comment">
				<textarea id="comment" name="comment" required="true" class="normal" placeholder="'. __d('Your comment..') .'"></textarea>
			</div>
			',
		'fields' => apply_filters('comment_form_default_fields', array(
			'author' => '
				<div class="grid-container">
					<div class="grid desk-8 alpha">
						<div class="form-label">'. __d('Name') .' '. $required .'</div>
						<div class="form-description">'. __d('Add a display name') .'</div>
						<input name="author" type="text" class="fullwidth" value="'. esc_attr( $commenter['comment_author'] ) .'" required="true"/>
					</div>
				</div>',
			'email' => '
				<div class="grid-container fix-grid">
					<div class="grid desk-8 alpha">
						<div class="form-label">'. __d('Email') .' '. $required .'</div>
						<div class="form-description">'. __d('Your email address will not be published') .'</div>
						<input name="email" type="text" class="fullwidth" value="'. esc_attr( $commenter['comment_author_email'] ) .'" required="true"/>
					</div>
				</div>',
			 'url' => '
				<div class="grid-container fixedform">
					<div class="grid desk-8 alpha">
						<div class="form-label">'. __d('Website') .'</div>
						<input name="url" type="text" placeholder="http://" class="fullwidth" value="'. esc_attr( $commenter['comment_author_url'] ) .'"/>
					</div>
				</div>', 
			)
		),
	);
	return $comments_args;
}
