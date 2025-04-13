<?php
/**
 * Template part for displaying post card
 * 
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;

$cfu_post_id = get_the_ID();
$cfu_title = esc_html(get_the_title());
$cfu_permalink = esc_url(get_permalink());
$cfu_category = cfu_get_primary_category($cfu_post_id);

$cfu_time_data = cfu_post_time($cfu_post_id);
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

<article id="post-<?php echo $cfu_post_id; ?>" class="article-card rounded-lg overflow-hidden bg-white/10 dark:bg-white/5 shadow-sm border border-white/10 dark:border-white/5 hover:shadow-md transition-shadow duration-200">
	<a href="<?php echo $cfu_permalink; ?>" class="block">
		<figure class="relative aspect-video overflow-hidden">
			<?php if (has_post_thumbnail($cfu_post_id)) : ?>
				<img src="<?php echo esc_url(get_the_post_thumbnail_url($cfu_post_id, 'cfu-blog-featured')); ?>" alt="<?php echo $cfu_title; ?>" class="w-full h-full object-cover">
			<?php else : ?>
				<img width="300" height="180" src="<?php echo $default_img;?>" alt="<?php echo $cfu_title; ?>" class="w-full h-full object-cover">
			<?php endif; ?>
			
			<?php if (!empty($cfu_category)) : ?>
				<span class="article-primary_category float-primary_category float-primary_category-top">
					<?php echo esc_html($cfu_category['category_display']); ?>
				</span>
			<?php endif; ?>
		</figure>
		
		<div class="p-3">
			<h3 class="font-medium text-base line-clamp-2 mb-2 article-title">
				<?php echo $cfu_title;?>
			</h3>
			<div class="flex items-center text-xs text-gray-600 dark:text-gray-400">
				<time datetime="<?php echo esc_attr($is_updated ? $modified_date_time : $published_date_time); ?>">
					<?php echo esc_html($published_time_ago); ?>
				</time>
			</div>
		</div>
	</a>
</article>