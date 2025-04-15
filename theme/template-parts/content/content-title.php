<?php
/**
 * Template part for displaying posts
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
?>

<li id="post-<?php echo esc_attr($cfu_post_id); ?>" class="py-3 first:pt-0 last:pb-0 penci-feed">
	<time 
    datetime="<?php echo esc_attr($is_updated ? $modified_date_time : $published_date_time); ?>"  
    class="whitespace-nowrap text-xs font-medium tracking-widest text-gray-500"
  >
    <span class="sr-only"><?php esc_html_e( 'Date', 'cryptofrontnews' ); ?></span>  
    <?php echo esc_html($published_time_ago); ?>
  </time>
	<h4 class="font-semibold article-title line-clamp-2 min-xl:text-sm pt-2">
		<a href="<?php echo $cfu_permalink; ?>" rel="bookmark">
			<?php echo $cfu_title; ?>
		</a>
	</h4>	
</li>
