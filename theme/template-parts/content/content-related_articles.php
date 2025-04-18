<?php
/**
 * Template part for displaying related posts
 *
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;

$cfu_post_id = get_the_ID();

function cfu_get_related_articles($post_id, $limit = 8) {
	$categories = get_the_category($post_id);
	if (empty($categories)) {
		return [];
	}
	
	$category_ids = [];
	foreach ($categories as $category) {
		$category_ids[] = $category->term_id;
	}
	
	$args = [
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => $limit,
		'post__not_in'        => [$post_id],
		'category__in'        => $category_ids,
		'orderby'             => 'date',
		'order'               => 'DESC',
	];
	
	$related_query = new WP_Query($args);
	
	// If not enough related posts found by category, get recent posts instead
	if ($related_query->post_count < $limit) {
		$more_posts_needed = $limit - $related_query->post_count;
		$existing_ids = wp_list_pluck($related_query->posts, 'ID');
		$existing_ids[] = $post_id; // Add current post to excluded list
		
		$recent_args = [
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => $more_posts_needed,
			'post__not_in'        => $existing_ids,
			'orderby'             => 'date',
			'order'               => 'DESC',
		];
		
		$recent_query = new WP_Query($recent_args);
		return array_merge($related_query->posts, $recent_query->posts);
	}
	return $related_query->posts;
}

$related_articles = cfu_get_related_articles($cfu_post_id);
?>
<?php if (!empty($related_articles)) : ?>
	<div class="col-span-full lg:col-span-12 @container isolate flex flex-col gap-2 overflow-hidden rounded-lg bg-white p-2 outline outline-gray-950/5 dark:bg-gray-950 dark:outline-white/10">
		<h3 class="page-title font-semibold text-xl md:text-2xl capitalize title-with-underline mb-5"><?php esc_html_e('Related Articles', 'cryptofrontnews'); ?></h3>
		<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4">
			<?php
				foreach ($related_articles as $related_post) {
					// Set up postdata for each related post
					$post = $related_post;
					setup_postdata($post);
					
					// Now get_template_part will use the correct post data
					get_template_part('template-parts/content/content', 'box');
				}
				// Reset post data when done
				wp_reset_postdata();
			?>
		</div>
	</div>
<?php endif; ?>

