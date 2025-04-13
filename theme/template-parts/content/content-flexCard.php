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

$default_img = get_theme_file_uri( 'assets/images/cfu-banner.jpg' );
$default_icon = get_theme_file_uri( 'assets/images/cfu-icon.webp' );
?>
<article id="post-<?php echo $cfu_post_id; ?>" class="grid grid-cols-12 gap-4 article-card rounded-md overflow-hidden bg-white/10 dark:bg-white/5 border border-gray-950/5 dark:border-white/5 shadow-sm p-2 max-xl:col-span-full flexCard">
	<figure class="col-span-3">
		<a href="<?php echo $cfu_permalink; ?>" class="block w-full h-20 sm:h-24 md:h-32 lg:h-[132px] rounded overflow-hidden post_thumbnail">
			<?php if (has_post_thumbnail($cfu_post_id)) : ?>
				<?php the_post_thumbnail('thumbnail', array('class' => 'w-full h-full object-cover')); ?>
			<?php else : ?>
				<img width="150" height="150" src="<?php echo $default_img;?>" alt="<?php echo $cfu_title; ?>" class="w-full h-full object-cover">
			<?php endif; ?>
		</a>
	</figure>
	<div class="col-span-9 space-y-2">
		<h3 class="article-title text-sm min-lg:text-base font-semibold">
      <a href="<?php echo $cfu_permalink; ?>" rel="bookmark">
        <?php echo $cfu_title; ?>
      </a>
    </h3>
		<div class="flex items-center text-xs min-md:mb-3 article-meta">
			<time datetime="<?php echo esc_attr($is_updated ? $modified_date_time : $published_date_time); ?>">
				<?php echo esc_html($published_time_ago); ?>
			</time>
			<?php if($cfu_tags): ?>
				<span class="mx-2">•</span>
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