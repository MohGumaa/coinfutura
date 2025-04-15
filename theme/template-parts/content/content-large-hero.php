<?php
/**
 * Template part for displaying post content large
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

$default_icon = get_theme_file_uri( 'assets/images/cfu-icon.webp' );
?>
<article id="post-<?php echo esc_attr($cfu_post_id);?>" class="flex flex-col gap-y-4">
	<?php cfu_post_thumbnail(); ?>
	<div>
		<div class="flex items-center text-xs font-medium mb-2">
			<time datetime="<?php echo esc_attr($is_updated ? $modified_date_time : $published_date_time); ?>" class="text-gray-500">
				<?php echo esc_html($published_time_ago); ?>
			</time>
			<?php if (!empty($cfu_category)) : ?>
				<span class="mx-2">•</span>
				<a href="<?php echo esc_url($cfu_category['category_link']); ?>" class="article-primary_category">
					<?php echo esc_html($cfu_category['category_display']); ?>
				</a>
			<?php endif; ?>
		</div>
		<h1 class="text-xl md:text-2xl font-bold mb-3">
			<a href="<?php echo $cfu_permalink; ?>" rel="bookmark" class="article-title line-clamp-3">
			<?php echo $cfu_title; ?>
		</a>
		</h1>
		<p class="line-clamp-2 max-sm:text-sm article-excerpt min-md:leading-7"><?php echo esc_html(cfu_get_meta_description($cfu_post_id)); ?></p>
		<a href="<?php echo $cfu_permalink; ?>" class="mt-1.5 capitalize inline-block text-sm font-semibold text-sky-500 hover:text-sky-600 dark:text-sky-400"><?php esc_html_e( 'Continue Reading', 'coinfutura' ); ?></a>
	</div>
</article>
