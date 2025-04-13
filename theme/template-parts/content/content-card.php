<?php
/**
 * Template part for displaying post card
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

<article id="post-<?php echo esc_attr($cfu_post_id); ?>" class="space-y-3.5">
	<figure class="overflow-hidden relative">
		<a href="<?php echo $cfu_permalink; ?>" aria-hidden="true" tabindex="-1" class="block w-full h-52 md:h-[237px] lg:h-48 xl:h-[234px] 2xl:h-[274px]">
			<?php if (has_post_thumbnail($cfu_post_id)) : ?>
				<?php the_post_thumbnail('cfu-blog-featured', array('class' => 'object-cover w-full h-full rounded')); ?>
			<?php else : ?>
				<img width="300" height="180" src="<?php echo $default_img;?>" alt="<?php echo $cfu_title; ?>" class="w-full h-full object-cover rounded">
			<?php endif; ?>
		</a>
	</figure>
	<div class="space-y-2">
		<h2 class="article-title min-lg:text-lg line-clamp-2 font-semibold">
      <a href="<?php echo $cfu_permalink; ?>" rel="bookmark">
        <?php echo $cfu_title; ?>
      </a>
    </h2>
		<p class="line-clamp-2 text-sm article-excerpt"><?php echo esc_html(cfu_get_meta_description($cfu_post_id)); ?></p>
		<div class="flex items-center text-xs mt-4">
			<time datetime="<?php echo esc_attr($is_updated ? $modified_date_time : $published_date_time); ?>">
				<?php echo esc_html($published_time_ago); ?>
			</time>
			<?php if($cfu_tags): ?>
				<span class="mx-2">•</span>
				<div class="flex items-center gap-1.5">
					<?php 
						$cfu_tags_to_display = array_slice($cfu_tags, 0, 2);
						foreach($cfu_tags_to_display as $tag): 
							$tag_icon = function_exists('get_field') ? get_field('icon', 'term_' . $tag->term_id) : '';
							
							if(is_array($tag_icon) && isset($tag_icon['url'])) {
								$tag_icon_url = $tag_icon['url'];
							} else {
								$tag_icon_url = empty($tag_icon) ? $default_icon : $tag_icon;
							}
					?>
						<a href="<?php echo get_tag_link($tag->term_id);?>" class="article-badge inline-flex items-center gap-x-1">
							<img src="<?php echo esc_url($tag_icon_url); ?>" alt="<?php echo esc_attr($tag->name); ?> icon" class="w-3.5 h-3.5 rounded-full">
							<?php echo $tag->name;?>
						</a>
					<?php endforeach;?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</article>
