<?php
/**
 * Template part for displaying posts
 *
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;

$cfu_post_id = get_the_ID();
$cfu_tags = get_the_tags();
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
$default_icon = get_theme_file_uri( 'assets/images/cfu-icon.webp' );
?>

<article id="post-<?php echo esc_attr($cfu_post_id); ?>" class="flex items-center gap-x-3 md:gap-x-4 max-sm:px-1.5 p-3 bg-gray-950/5 dark:bg-white/10 rounded">
	<figure class="block flex-shrink-0">
		<a href="<?php echo $cfu_permalink; ?>" aria-hidden="true" tabindex="-1" class="block w-24 md:w-48 h-[90px] md:h-32 overflow-hidden">
			<?php if (has_post_thumbnail($cfu_post_id)) : ?>
				<?php the_post_thumbnail('cfu-blog-featured', array('class' => 'object-cover w-full h-full rounded')); ?>
			<?php else : ?>
				<img width="300" height="180" src="<?php echo $default_img;?>" alt="<?php echo esc_html($cfu_title); ?>" class="w-full h-full object-cover rounded">
			<?php endif; ?>
		</a>
	</figure>
	<div class="flex-1 space-y-2">
		<h3 class="article-title line-clamp-3 md:line-clamp-2 font-semibold max-sm:text-sm">
      <a href="<?php echo $cfu_permalink; ?>" rel="bookmark">
        <?php echo $cfu_title; ?>
      </a>
    </h3>
		<div class="flex items-center flex-wrap gap-2 text-xs mb-0 min-sm:mb-3">
			<time datetime="<?php echo esc_attr($is_updated ? $modified_date_time : $published_date_time); ?>" class="text-gray-500 font-medium">
				<?php echo esc_html($published_time_ago); ?>
			</time>
			<?php if($cfu_tags): ?>
				<span>•</span>
				<?php 
					$first_tag = reset($cfu_tags);
					if ($first_tag):
						$tag_icon = function_exists('get_field') ? get_field('icon', 'term_' . $first_tag->term_id) : '';
							
						if(is_array($tag_icon) && isset($tag_icon['url'])) {
							$tag_icon_url = $tag_icon['url'];
						} else {
							$tag_icon_url = empty($tag_icon) ? $default_icon : $tag_icon;
						}
				?>
					<a href="<?php echo get_tag_link($first_tag->term_id);?>" class="article-badge inline-flex items-center gap-x-1">
						<img src="<?php echo esc_url($tag_icon_url); ?>" alt="<?php echo esc_attr($first_tag->name); ?> icon" class="w-3.5 h-3.5 rounded-full">
						<?php echo $first_tag->name;?>
					</a>
				<?php endif;?>
			<?php endif; ?>
		</div>
    <p class="line-clamp-2 text-sm article-excerpt max-sm:hidden"><?php echo esc_html(cfu_get_meta_description($cfu_post_id)); ?></p>
	</div>
</article>
