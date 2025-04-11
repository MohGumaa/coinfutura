<?php
/**
 * Template part for displaying post content large
 *
 * @package coinfutura
 */
 defined( 'ABSPATH' ) || exit;

$cfu_post_id = get_the_ID();
$cfu_tags = get_the_tags();
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
		<?php the_title( sprintf( '<h2 class="text-xl md:text-2xl lg:text-3xl font-bold mb-3"><a href="%s" class="article-title line-clamp-3" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php if($cfu_tags): ?>
				<div class="flex items-center text-sm gap-1.5 mb-3">
					<?php 
						$cfu_tags_to_display = array_slice($cfu_tags, 0, 2);
						foreach($cfu_tags_to_display as $cfu_tag): 
							$tag_icon = function_exists('get_field') ? get_field('icon', 'term_' . $cfu_tag->term_id) : '';
							if(is_array($tag_icon) && isset($tag_icon['url'])) {
								$tag_icon_url = $tag_icon['url'];
							} else {
								$tag_icon_url = empty($tag_icon) ? $default_icon : $tag_icon;
							}
					?>
						<a href="<?php echo get_tag_link($cfu_tag->term_id);?>" class="article-badge inline-flex items-center gap-x-1">
							<img src="<?php echo esc_url($tag_icon_url); ?>" alt="<?php echo esc_attr($cfu_tag->name); ?> icon" class="w-3.5 h-3.5 rounded-full">
							<?php echo $cfu_tag->name;?>
						</a>
					<?php endforeach;?>
				</div>
			<?php endif; ?>
			<p class="line-clamp-3 max-sm:text-sm article-excerpt"><?php echo esc_html(cfu_get_meta_description($cfu_post_id)); ?></p>
	</div>
</article>
