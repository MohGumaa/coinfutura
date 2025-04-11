<?php
/**
 * Template part for displaying related posts
 *
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;

$cfu_post_id = get_the_ID();

function cfu_get_related_articles($post_id, $limit = 4) {
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
		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
			<?php foreach ($related_articles as $related_post) : 
				$post_id = $related_post->ID;
				$cfu_title = esc_html(get_the_title());
				$cfu_permalink = esc_url(get_permalink());
				$cfu_category = cfu_get_primary_category($post_id);

				$cfu_time_data = cfu_post_time($post_id);
				[
					$is_updated,
					$modified_time, 
					$published_time, 
					$modified_date_time, 
					$published_time_ago,	
					$published_date_time,
				] = $cfu_time_data;
				$default_img = get_theme_file_uri( 'assets/images/cfu-banner.jpg' );
			?>
				<div class="article-card rounded-lg overflow-hidden bg-white/10 dark:bg-white/5 shadow-sm border border-white/10 dark:border-white/5 hover:shadow-md transition-shadow duration-200">
					<a href="<?php echo $cfu_permalink; ?>" class="block">
						<figure class="relative aspect-video overflow-hidden">
							<?php if (has_post_thumbnail($post_id)) : ?>
								<img src="<?php echo esc_url(get_the_post_thumbnail_url($post_id, 'cfu-blog-featured')); ?>" alt="<?php echo esc_html($cfu_title); ?>" class="w-full h-full object-cover">
							<?php else : ?>
								<img width="300" height="180" src="<?php echo $default_img;?>" alt="<?php echo esc_html($cfu_title); ?>" class="w-full h-full object-cover">
							<?php endif; ?>
							
							<?php if (!empty($cfu_category)) : ?>
								<span class="article-primary_category float-primary_category float-primary_category-top">
									<?php echo esc_html($cfu_category['category_display']); ?>
								</span>
							<?php endif; ?>
						</figure>
						
						<div class="p-3">
							<h4 class="font-medium text-base line-clamp-2 mb-2 article-title">
								<?php echo esc_html($cfu_title);?>
							</h4>
							<div class="flex items-center text-xs text-gray-600 dark:text-gray-400">
								<time datetime="<?php echo esc_attr($is_updated ? $modified_date_time : $published_date_time); ?>">
									<?php echo esc_html($published_time_ago); ?>
								</time>
							</div>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>

