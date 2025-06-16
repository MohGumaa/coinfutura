<?php
/**
 * Template part for displaying related posts by tags and categories
 * Excludes the current post
 *
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;

$cfu_post_id = get_the_ID();

// Initialize arguments array
$cfu_args = array(
  'post_type'             => 'post',
  'post_status'           => 'publish',
  'posts_per_page'        => 8,
  'post__not_in'          => array( $cfu_post_id ),
  'ignore_sticky_posts'   => true,
  'no_found_rows'         => true,
  'update_post_meta_cache' => false,
  'update_post_term_cache' => false,
);

// Try to get posts by tags first
$cfu_tags = wp_get_post_tags( $cfu_post_id, array( 'fields' => 'ids' ) );

if ( ! empty( $cfu_tags ) ) {
  $cfu_args['tag__in'] = $cfu_tags;
  $cfu_args['orderby'] = 'rand';
} else {
  // Fallback to categories if no tags
  $cfu_categories = wp_get_post_categories( $cfu_post_id, array( 'fields' => 'ids' ) );
  
  if ( ! empty( $cfu_categories ) ) {
    $cfu_args['category__in'] = $cfu_categories;
    $cfu_args['orderby'] = 'date';
    $cfu_args['order'] = 'DESC';
  } else {
    // If no tags or categories, get recent posts
    $cfu_args['orderby'] = 'date';
    $cfu_args['order'] = 'DESC';
  }
}

$cfu_related_post = new WP_Query( $cfu_args );

if ( $cfu_related_post->have_posts() ) :
?>
	<div class="col-span-full lg:col-span-12 @container isolate flex flex-col gap-2 overflow-hidden rounded-lg bg-white p-2 outline outline-gray-950/5 dark:bg-gray-950 dark:outline-white/10">
		<h3 class="page-title font-semibold text-xl md:text-2xl capitalize title-with-underline mb-5"><?php esc_html_e('Related Articles', 'coinfutura'); ?></h3>
		<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4">
			<?php
				while ( $cfu_related_post->have_posts() ) {
					$cfu_related_post->the_post();
					get_template_part('template-parts/content/content', 'box');
				}
			?>
		</div>
	</div>

<?php endif; wp_reset_postdata();?>