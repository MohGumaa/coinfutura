<?php
/**
 * Template part for displaying post tag, author and search results
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

$default_icon = get_theme_file_uri( 'assets/images/cfu-icon.webp' );
?>
<article id="post-<?php echo $cfu_post_id; ?>" class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-6 pb-6 border-b border-gray-950/5 dark:border-white/10 last:border-b-0 last:mb-0 last:pb-0">
	<div class="col-span-full md:col-span-9 order-2 md:order-1 space-y-2">
		<h3 class="article-title min-lg:text-lg font-semibold">
      <a href="<?php echo $cfu_permalink; ?>" rel="bookmark">
        <?php echo $cfu_title; ?>
      </a>
    </h3>
		<div class="flex items-center text-xs">
			<time datetime="<?php echo esc_attr($is_updated ? $modified_date_time : $published_date_time); ?>">
				<?php echo esc_html($published_time_ago); ?>
			</time>
			<?php if($cfu_tags): ?>
				<span class="mx-2">•</span>
				<div class="flex items-center gap-1.5">
					<?php 
						$tags_to_display = array_slice($cfu_tags, 0, 2);
						foreach($tags_to_display as $tag): 
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
		<p class="line-clamp-2 text-sm article-excerpt"><?php echo esc_html(cfu_get_meta_description($cfu_post_id)); ?></p>
	</div>
	<figure class="col-span-full md:col-span-3 order-1 md:order-2">
		<a href="<?php echo $cfu_permalink; ?>" class="block w-full h-52 md:h-32 lg:h-28 xl:h-[114px] 2xl:h-[150px] rounded overflow-hidden">
			<?php the_post_thumbnail('cfu-blog-featured', array('class' => 'w-full h-full object-cover')); ?>
		</a>
	</figure>
</article>