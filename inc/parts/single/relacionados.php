<?php

if(get_option('dt_similiar_titles')=='true') { ?>
<div class="sbox srelacionados">
<h2><?php _d('Similar titles'); ?></h2>
<div id="single_relacionados">
<?php global $post;
$tags = wp_get_post_terms($post->ID, 'genres');
if ($tags) {
$first_tag 	= $tags[0]->term_id;
$second_tag = $tags[1]->term_id;
$third_tag 	= $tags[2]->term_id;
$args = array('post_type' => get_post_type($post->ID),'posts_per_page' => 12,'post__not_in' =>array(get_the_ID()),'orderby' => 'rand','order' => 'asc','tax_query' => array('relation' => 'OR',
array('taxonomy' => 'genres','terms' => $second_tag,'field' => 'id','operator' => 'IN'),
array('taxonomy' => 'genres','terms' => $first_tag,'field' => 'id','operator' => 'IN'),
array('taxonomy' => 'genres','terms' => $third_tag,'field' => 'id','operator' => 'IN'))
);
$related = get_posts($args);
$i = 0;
if( $related ) {
global $post;
$temp_post = $post;
foreach($related as $post) : setup_postdata($post); ?> 
<article>
<a href="<?php the_permalink() ?>">
 <img src="<?php if($thumb_id = get_post_thumbnail_id()) { $thumb_url = wp_get_attachment_image_src($thumb_id,'dt_poster_a', true); echo $thumb_url[0]; } else { dt_image('dt_poster', $post->ID, 'w185'); } ?>" alt="<?php the_title(); ?>" />
</a>
</article>
<?php endforeach; $post = $temp_post; } } ?>
</div>
</div>
<?php } ?>