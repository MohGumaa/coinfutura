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

<article id="post-<?php echo esc_attr($cfu_post_id); ?>" class="article-card group rounded-lg overflow-hidden bg-white/10 dark:bg-white/5 shadow-sm border border-white/10 dark:border-white/5 hover:shadow-md transition-shadow duration-200">
	<figure class="block">
		<a href="<?php echo $cfu_permalink; ?>" aria-hidden="true" tabindex="-1" class="block w-full aspect-video overflow-hidden">
			<?php if (has_post_thumbnail($cfu_post_id)) : ?>
				<?php the_post_thumbnail('large', array('class' => 'object-cover w-full h-full rounded')); ?>
			<?php else : ?>
				<img width="673" height="378" src="<?php echo $default_img;?>" alt="<?php echo $cfu_title; ?>" class="w-full h-full object-cover rounded">
			<?php endif; ?>
		</a>
	</figure>
	<div class="p-4">
		<h2 class="font-medium text-base md:text-lg mb-2">
      <a href="<?php echo $cfu_permalink; ?>" rel="bookmark" class="line-clamp-2 article-title">
        <?php echo $cfu_title; ?>
      </a>
    </h2>
		<p class="line-clamp-2 text-sm article-excerpt mb-4"><?php echo esc_html(cfu_get_meta_description($cfu_post_id)); ?></p>
		<div class="flex items-center text-xs text-gray-500 font-medium">
			<time datetime="<?php echo esc_attr($is_updated ? $modified_date_time : $published_date_time); ?>">
				<?php echo esc_html($published_time_ago); ?>
			</time>
		</div>
	</div>
</article>
