<?php
/**
 * Template part for displaying single posts
 *
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;

// Fetch post data once
$cfu_post_id = get_the_ID();
$cfu_author_id = get_the_author_meta('ID');
$cfu_author_name = esc_html(get_the_author());
$cfu_is_press_release = has_category('press-releases');
$cfu_category = cfu_get_primary_category($cfu_post_id);
$cfu_author_url = esc_url(get_author_posts_url($cfu_author_id));

// Extract time data array once
$cfu_time_data = cfu_post_time($cfu_post_id);
[
	$is_updated,
	$modified_time, 
	$published_time, 
	$modified_date_time, 
	$published_time_ago,	
	$published_date_time,
] = $cfu_time_data;

// Get author avatar - optimize conditional logic
$cfu_alt_text = sprintf(__('Profile picture of %s', 'coinfutura'), $cfu_author_name);
$cfu_avatar_img = '';

if (function_exists('get_field')) {
	$cfu_avatar_url = get_field('profile_picture', 'user_' . $cfu_author_id);
	if ($cfu_avatar_url) {
		$cfu_avatar_img = sprintf(
			'<img src="%s" alt="%s" class="flex-shrink-0 w-10 h-10 rounded-full object-cover wp-post-image">',
			esc_url($cfu_avatar_url['sizes']['large']),
			esc_attr($cfu_alt_text)
		);
	}
}

if (empty($cfu_avatar_img)) {
	$cfu_avatar_img = get_avatar(
		$cfu_author_id, 
		40, 
		'', 
		$cfu_alt_text, 
		['class' => 'flex-shrink-0 w-10 h-10 rounded-full object-cover wp-post-image']
	);
}


function cfu_get_share_urls($cfu_post_id) {
	$post_url = urlencode(get_permalink($cfu_post_id));
	$post_title = htmlspecialchars(urlencode(html_entity_decode(get_the_title($cfu_post_id), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');;
    
	return [
		'twitter' => sprintf(
			'https://twitter.com/intent/tweet?url=%s&text=%s&via=CryptoFront_CFN',
			$post_url,
			$post_title
		),
		'facebook' => sprintf(
			'https://www.facebook.com/sharer/sharer.php?u=%s',
			$post_url
		),
		'linkedin' => sprintf(
			'https://www.linkedin.com/shareArticle?mini=true&url=%s&title=%s',
			$post_url,
			$post_title
		),
		'whatsapp' => sprintf(
			'https://api.whatsapp.com/send?text=%s%%20%s',
			$post_title,
			$post_url
		),
		'telegram' => sprintf(
			'https://t.me/share/url?url=%s&text=%s',
			$post_url,
			$post_title
		),
		'reddit' => sprintf(
			'https://www.reddit.com/submit?url=%s&title=%s',
			$post_url,
			$post_title
		)
	];
}

// Social icons array remains the same
$social_icons = [
	'facebook' => '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="shares-list-item_facebook text-blue-500 hover:text-blue-600 w-full rounded"><rect width="40" height="40" rx="4" fill="currentColor"></rect><path d="M6.667 19.998a13.34 13.34 0 0011.248 13.171v-9.318h-3.382v-3.853h3.386v-2.934a4.704 4.704 0 015.03-5.2c1.002.017 2 .106 2.987.267v3.279h-1.685a1.928 1.928 0 00-2.17 2.084v2.504h3.694l-.59 3.854H22.08v9.317c7.005-1.107 11.918-7.505 11.179-14.56-.74-7.053-6.872-12.294-13.955-11.924-7.083.37-12.637 6.22-12.639 13.313z" fill="#fff"></path></svg>',
	'twitter' => '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="shares-list-item_twitter text-neutral-950 hover:text-neutral-800 w-full rounded border border-gray-950/5 dark:border-white/10"><rect width="40" height="40" rx="4" fill="currentColor"></rect><path d="M27.318 9h3.68l-8.04 9.319L32.417 31H25.01l-5.801-7.69L12.573 31H8.89l8.6-9.968L8.417 9h7.593l5.244 7.03L27.318 9zm-1.292 19.766h2.04l-13.164-17.65h-2.188l13.312 17.65z" fill="#fff"></path></svg>',
	'linkedin' => '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="shares-list-item_linkedin text-blue-600 hover:text-blue-700 w-full rounded"><rect width="40" height="40" rx="4" fill="currentColor"></rect><path fill-rule="evenodd" clip-rule="evenodd" d="M17.667 28h4.444v-7.5a2.017 2.017 0 011.948-2.16 2.517 2.517 0 012.496 2.16V28H31v-8.056a5 5 0 00-4.972-5.014 5.131 5.131 0 00-3.917 1.959v-2.222h-4.444V28zM11 14.667V28h4.444V14.667H11zm0-4.445a2.222 2.222 0 104.444 0 2.222 2.222 0 00-4.444 0z" fill="#fff"></path></svg>',
	'whatsapp' => '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="shares-list-item_whatsapp text-green-500 hover:text-green-600 w-full rounded"><rect width="40" height="40" rx="4" fill="currentColor"></rect><path fill-rule="evenodd" clip-rule="evenodd" d="M28.503 11.485A11.903 11.903 0 0020.05 8C13.463 8 8.103 13.33 8.1 19.883c0 2.095.55 4.14 1.595 5.94L8 31.984l6.335-1.653a11.986 11.986 0 005.71 1.446h.005c6.586 0 11.948-5.331 11.95-11.883a11.78 11.78 0 00-3.497-8.408zM20.05 29.769h-.004a9.96 9.96 0 01-5.055-1.376l-.363-.215-3.76.981 1.004-3.645-.236-.374a9.812 9.812 0 01-1.518-5.256c.002-5.446 4.458-9.877 9.937-9.877a9.892 9.892 0 017.021 2.897 9.788 9.788 0 012.907 6.988c-.003 5.446-4.458 9.877-9.933 9.877zm5.448-7.397c-.298-.149-1.766-.867-2.04-.966-.274-.1-.473-.149-.672.149-.198.297-.77.966-.945 1.164-.174.198-.348.223-.647.074-.298-.149-1.26-.462-2.401-1.473-.888-.788-1.487-1.76-1.661-2.058-.175-.297-.019-.458.13-.605.134-.134.299-.347.448-.52.15-.174.2-.298.299-.496.1-.198.05-.371-.025-.52-.074-.149-.671-1.61-.92-2.205-.243-.579-.49-.5-.672-.51-.174-.008-.373-.01-.572-.01-.2 0-.523.074-.797.372-.274.297-1.045 1.016-1.045 2.477 0 1.46 1.07 2.873 1.22 3.072.149.198 2.105 3.197 5.1 4.483.712.306 1.269.49 1.702.626.715.226 1.366.195 1.88.118.574-.085 1.767-.718 2.016-1.412.249-.693.249-1.288.174-1.412-.074-.124-.274-.198-.572-.347v-.001z" fill="#fff"></path></svg>',
	'telegram' => '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="shares-list-telegram opacity-100 hover:opacity-90 w-full rounded"> <g clip-path="url(#clip0_715_9)"> <rect width="40" height="40" fill="url(#paint0_linear_715_9)"/> <path d="M20 40C31.0457 40 40 31.0457 40 20C40 8.95431 31.0457 0 20 0C8.95431 0 0 8.95431 0 20C0 31.0457 8.95431 40 20 40Z" fill="url(#paint1_linear_715_9)"/> <path d="M12.7578 21.0961L15.3499 28.2707C15.3499 28.2707 15.674 28.942 16.021 28.942C16.368 28.942 21.5295 23.5724 21.5295 23.5724L27.2692 12.4863L12.8503 19.2441L12.7578 21.0961Z" fill="#C8DAEA"/> <path d="M16.1948 22.9361L15.6972 28.2245C15.6972 28.2245 15.4889 29.8449 17.1089 28.2245C18.729 26.604 20.2797 25.3545 20.2797 25.3545" fill="#A9C6D8"/> <path d="M12.8048 21.3521L7.47276 19.6148C7.47276 19.6148 6.83552 19.3563 7.04071 18.77C7.08295 18.6491 7.16816 18.5462 7.42305 18.3695C8.60449 17.546 29.2906 10.1108 29.2906 10.1108C29.2906 10.1108 29.8746 9.91402 30.2191 10.0449C30.3043 10.0713 30.381 10.1199 30.4413 10.1856C30.5016 10.2513 30.5434 10.3319 30.5623 10.4191C30.5995 10.573 30.6151 10.7315 30.6085 10.8897C30.6069 11.0266 30.5903 11.1535 30.5778 11.3525C30.4518 13.3853 26.6815 28.5567 26.6815 28.5567C26.6815 28.5567 26.4559 29.4445 25.6477 29.4749C25.4491 29.4813 25.2512 29.4477 25.0659 29.376C24.8806 29.3043 24.7116 29.196 24.569 29.0576C22.983 27.6934 17.5013 24.0094 16.29 23.1992C16.2626 23.1806 16.2396 23.1563 16.2225 23.128C16.2053 23.0998 16.1944 23.0682 16.1906 23.0353C16.1736 22.9499 16.2665 22.8442 16.2665 22.8442C16.2665 22.8442 25.8116 14.3598 26.0656 13.4691C26.0852 13.4001 26.011 13.366 25.9112 13.3963C25.2772 13.6295 14.2872 20.5698 13.0743 21.3357C12.987 21.3621 12.8947 21.3677 12.8048 21.3521Z" fill="white"/> </g> <defs> <linearGradient id="paint0_linear_715_9" x1="20" y1="40" x2="20" y2="0" gradientUnits="userSpaceOnUse"> <stop stop-color="#1D93D2"/> <stop offset="1" stop-color="#38B0E3"/> </linearGradient> <linearGradient id="paint1_linear_715_9" x1="20" y1="40" x2="20" y2="0" gradientUnits="userSpaceOnUse"> <stop stop-color="#1D93D2"/> <stop offset="1" stop-color="#38B0E3"/> </linearGradient> <clipPath id="clip0_715_9"> <rect width="40" height="40" fill="white"/> </clipPath> </defs> </svg>',
	'reddit'   => '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="shares-list-item_reddit text-orange-500 hover:text-orange-600 w-full rounded"><rect width="40" height="40" rx="4" fill="currentColor"></rect><path d="M32 19.5a3.5 3.5 0 00-3.5-3.5c-.891 0-1.726.35-2.35.944a15.106 15.106 0 00-6.876-2.216l1.531-4.815 4.082.878a2.5 2.5 0 002.49 2.709 2.5 2.5 0 000-5 2.45 2.45 0 00-2.049 1.122l-4.65-1A.625.625 0 0020.052 9l-1.75 5.5a15.154 15.154 0 00-7.1 2.273 3.497 3.497 0 00-4.703 5.18c.05.07.104.141.161.209a5.16 5.16 0 00-.16 1.338c0 4.97 5.373 9 12 9s12-4.03 12-9c0-.41-.044-.82-.132-1.22A3.5 3.5 0 0032 19.5zM13 21.5a2 2 0 114 0 2 2 0 01-4 0zm12.756 6.5c-1.541 1.541-4.324 1.657-5.157 1.657-.83 0-3.618-.116-5.155-1.655a.625.625 0 01.883-.884c1.104 1.103 3.28 1.286 4.272 1.286.991 0 3.17-.183 4.274-1.286a.625.625 0 11.883.884zM25 23.5a2 2 0 01-2-2 2 2 0 114 0 2 2 0 01-2 2z" fill="#fff"/></svg>'
];

// Get share URLs for current post
$share_urls = cfu_get_share_urls($cfu_post_id);
?>

<article id="post-<?php echo esc_attr($cfu_post_id); ?>" <?php post_class(); ?>>
	<div class="article-entry-meta text-sm font-medium mb-8">
		<?php the_title('<h1 class="inline-block tracking-tight text-pretty font-bold text-2xl md:text-3xl lg:text-[2.5rem]/10 lg:leading-12 text-gray-950 dark:text-gray-200 mb-4">', '</h1>'); ?>
		<p class="article-excerpt mb-3"><?php echo esc_html(cfu_get_meta_description($cfu_post_id)); ?></p>

		<div class="flex flex-col md:flex-row md:items-center gap-1.5 text-gray-800 dark:text-gray-300 font-semibold timestamp mb-3.5">
			<time datetime="<?php echo esc_attr($published_date_time); ?>">
				<?php 
					esc_html_e('Published on', 'coinfutura');
					echo ' ' . esc_html($published_time) . ' ';
					esc_html_e('GST', 'coinfutura');
				?>
			</time>
			<?php if (!$cfu_is_press_release && $is_updated) :?>
				<time datetime="<?php echo esc_attr($modified_date_time); ?>" class="md:border-s md:ps-1.5">
					<?php 
						esc_html_e('Updated on', 'coinfutura');
						echo ' ' . esc_html($modified_time) . ' ';
						esc_html_e('GST', 'coinfutura');
					?>
				</time>
			<?php endif;?>
		</div>

		<a class="flex items-center gap-2 mb-5 hover:text-sky-400 url fn n" href="<?php echo $cfu_author_url; ?>">
			<?php echo $cfu_avatar_img; ?>
			<span>
				<span class="sr-only"><?php esc_html_e('Posted by', 'coinfutura'); ?></span>
				<?php echo $cfu_author_name; ?>
			</span>
		</a>

		<figure class="rounded-lg lg:rounded-xl overflow-hidden w-full relative">
			<?php the_post_thumbnail(); ?>
			<?php if (!empty($cfu_category)) : ?>
				<a href="<?php echo esc_url($cfu_category['category_link']); ?>" class="article-primary_category float-primary_category">
					<?php echo esc_html($cfu_category['category_display']); ?>
				</a>
			<?php endif; ?>
		</figure>

		<div class="flex items-center gap-x-1 relative bg-gray-950/[2.5%] after:pointer-events-none after:absolute after:inset-0 after:rounded-lg after:inset-ring after:inset-ring-gray-950/5 dark:after:inset-ring-white/10 bg-[image:radial-gradient(var(--pattern-fg)_1px,_transparent_0)] bg-[size:10px_10px] bg-fixed [--pattern-fg:var(--color-gray-950)]/5 dark:[--pattern-fg:var(--color-white)]/10 rounded-md overflow-hidden px-3 py-3.5 mt-5">
			<strong class="text-base"><?php esc_html_e( 'Follow us:', 'coinfutura' ); ?></strong>
			<div class="flex flex-nowrap items-center flex-1 gap-x-4 overflow-x-auto scrollbar-hide py-0.5 px-4">
				<a href="https://coinmarketcap.com/community/profile/coinfutura/" class="flexCenter gap-x-1.5 capitalize whitespace-nowrap bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:dark:bg-gray-700 text-gray-800 dark:text-white ring-1 ring-gray-200 dark:ring-gray-700 rounded-sm transition-colors duration-200 shadow-sm py-1.5 px-2 lg:px-3.5 max-sm:text-xs" role="menuitem" target="_blank">
					<div class="w-5 h-5 md:h-6 md:w-6 shrink-0 rounded flexCenter bg-cmc p-1">
						<svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="Coinmarketcap--Streamline-Simple-Icons.svg" height="24" width="24"><desc>Coinmarketcap Streamline Icon: https://streamlinehq.com</desc><title>CoinMarketCap</title><path d="M20.738 14.341c-0.419 0.265 -0.912 0.298 -1.286 0.087 -0.476 -0.27 -0.738 -0.898 -0.738 -1.774v-2.618c0 -1.264 -0.5 -2.164 -1.336 -2.407 -1.416 -0.413 -2.482 1.32 -2.882 1.972l-2.498 4.05v-4.95c-0.028 -1.14 -0.398 -1.821 -1.1 -2.027 -0.466 -0.135 -1.161 -0.081 -1.837 0.953l-5.597 8.987A9.875 9.875 0 0 1 2.326 12c0 -5.414 4.339 -9.818 9.672 -9.818 5.332 0 9.67 4.404 9.67 9.818 0.004 0.018 0.002 0.034 0.003 0.053 0.05 1.049 -0.29 1.883 -0.933 2.29zm3.08 -2.34 -0.001 -0.055C23.787 5.353 18.497 0 11.997 0 5.48 0 0.177 5.383 0.177 12c0 6.616 5.303 12 11.82 12 2.991 0 5.846 -1.137 8.037 -3.2 0.435 -0.41 0.46 -1.1 0.057 -1.541a1.064 1.064 0 0 0 -1.519 -0.059 9.56 9.56 0 0 1 -6.574 2.618c-2.856 0 -5.425 -1.263 -7.197 -3.268l5.048 -8.105v3.737c0 1.794 0.696 2.374 1.28 2.544 0.584 0.17 1.476 0.054 2.413 -1.468 0.998 -1.614 2.025 -3.297 3.023 -4.88v2.276c0 1.678 0.672 3.02 1.843 3.68 1.056 0.597 2.384 0.543 3.465 -0.14 1.312 -0.828 2.018 -2.354 1.944 -4.193z" fill="#ffffff" stroke-width="1"></path></svg>
					</div>
					<span><?php esc_html_e( 'coinmarketcap', 'coinfutura' ); ?></span>
				</a>
				<a href="https://www.binance.com/en/square/profile/coinfutura" class="flexCenter gap-x-1.5 capitalize whitespace-nowrap bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:dark:bg-gray-700 text-gray-800 dark:text-white ring-1 ring-gray-200 dark:ring-gray-700 rounded-sm transition-colors duration-200 shadow-sm py-1.5 px-2 lg:px-3.5 max-sm:text-xs" role="menuitem" target="_blank">
					<div class="w-5 h-5 md:h-6 md:w-6 shrink-0 rounded flexCenter twitter-bg p-1">
						<svg viewBox="0 0 126.61 126.61" width="16" height="16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><g fill="#f3ba2f"><path d="m38.73 53.2 24.59-24.58 24.6 24.6 14.3-14.31-38.9-38.91-38.9 38.9z"/><path d="m0 63.31 14.3-14.31 14.31 14.31-14.31 14.3z"/><path d="m38.73 73.41 24.59 24.59 24.6-24.6 14.31 14.29-38.9 38.91-38.91-38.88z"/><path d="m98 63.31 14.3-14.31 14.31 14.3-14.31 14.32z"/><path d="m77.83 63.3-14.51-14.52-10.73 10.73-1.24 1.23-2.54 2.54 14.51 14.5 14.51-14.47z"/></g></svg>
					</div>
					<span><?php esc_html_e( 'binance', 'coinfutura' ); ?></span>
				</a>
				<a href="#" class="flexCenter gap-x-1.5 capitalize whitespace-nowrap bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:dark:bg-gray-700 text-gray-800 dark:text-white ring-1 ring-gray-200 dark:ring-gray-700 rounded-sm transition-colors duration-200 shadow-sm py-1.5 px-2 lg:px-3.5 max-sm:text-xs" role="menuitem" target="_blank">
					<div class="w-5 h-5 md:h-6 md:w-6 shrink-0">
						<img src="<?php echo get_template_directory_uri() . '/assets/images/google-news.webp'; ?>" alt="Google News" class="h-full w-full shrink-0" />
					</div>
					<span><?php esc_html_e( 'Google News', 'coinfutura' ); ?></span>
				</a>
				<a href="https://t.me/coinfutura" class="flexCenter gap-x-1.5 capitalize whitespace-nowrap bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:dark:bg-gray-700 text-gray-800 dark:text-white ring-1 ring-gray-200 dark:ring-gray-700 rounded-sm transition-colors duration-200 shadow-sm py-1.5 px-2 lg:px-3.5 max-sm:text-xs" role="menuitem" target="_blank">
					<div class="w-5 h-5 md:h-6 md:w-6 shrink-0 rounded flexCenter telegram-bg p-1">
						<svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="currentColor"> <path fill-rule="evenodd" clip-rule="evenodd" d="M23.1117 4.49449C23.4296 2.94472 21.9074 1.65683 20.4317 2.227L2.3425 9.21601C0.694517 9.85273 0.621087 12.1572 2.22518 12.8975L6.1645 14.7157L8.03849 21.2746C8.13583 21.6153 8.40618 21.8791 8.74917 21.968C9.09216 22.0568 9.45658 21.9576 9.70712 21.707L12.5938 18.8203L16.6375 21.8531C17.8113 22.7334 19.5019 22.0922 19.7967 20.6549L23.1117 4.49449ZM3.0633 11.0816L21.1525 4.0926L17.8375 20.2531L13.1 16.6999C12.7019 16.4013 12.1448 16.4409 11.7929 16.7928L10.5565 18.0292L10.928 15.9861L18.2071 8.70703C18.5614 8.35278 18.5988 7.79106 18.2947 7.39293C17.9906 6.99479 17.4389 6.88312 17.0039 7.13168L6.95124 12.876L3.0633 11.0816ZM8.17695 14.4791L8.78333 16.6015L9.01614 15.321C9.05253 15.1209 9.14908 14.9366 9.29291 14.7928L11.5128 12.573L8.17695 14.4791Z" fill="#ffffff"/> </svg>
					</div>
					<span><?php esc_html_e( 'telegram', 'coinfutura' ); ?></span>
				</a>
				<a href="https://x.com/CryptoFront_CFN" class="flexCenter gap-x-1.5 capitalize whitespace-nowrap bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:dark:bg-gray-700 text-gray-800 dark:text-white ring-1 ring-gray-200 dark:ring-gray-700 rounded-sm transition-colors duration-200 shadow-sm py-1.5 px-2 lg:px-3.5 max-sm:text-xs" role="menuitem" target="_blank">
					<div class="w-5 h-5 md:h-6 md:w-6 shrink-0 rounded flexCenter twitter-bg p-1">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x text-white" viewBox="0 0 16 16"> <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/> </svg>
					</div>
					<span><?php esc_html_e( 'twitter', 'coinfutura' ); ?></span>
				</a>
			</div>
		</div>

		<?php if ( $cfu_is_press_release ): ?>
			<div class="bg-gray-950/5 dark:bg-white/10 inset-ring inset-ring-gray-950/5 dark:inset-ring-white/10 leading-6 rounded-md overflow-hidden p-3 mt-5">
				<span class="cfu-title font-semibold">
					<?php esc_html_e( 'Disclaimer: ', 'coinfutura' ); ?>
				</span>
				<span><?php esc_html_e( 'The information presented in this article is part of a sponsored/press release/paid content, intended solely for promotional purposes. Readers are advised to exercise caution and conduct their own research before taking any action related to the content on this page or the company. coinfutura is not responsible for any losses or damages incurred as a result of or in connection with the utilization of content, products, or services mentioned.', 'coinfutura' ); ?></span>
			</div>
		<?php endif; ?>
	</div>

	<div <?php cfu_content_class('entry-content md:text-[17px]'); ?>>
		<?php the_content();?>
	</div>

	<div class="flex flex-col sm:flex-row justify-between items-center gap-4 my-12">
		<span><?php esc_html_e('Share this article', 'coinfutura'); ?></span>
		<div class="flex items-center gap-3 shares-list__list">
			<?php foreach ($share_urls as $platform => $url) : ?>
				<a href="<?php echo esc_url($url); ?>" 
					target="_blank" 
					rel="noopener noreferrer" 
					class="shares-list__item"
					aria-label="<?php printf(esc_attr__('Share on %s', 'coinfutura'), ucfirst($platform)); ?>">
					<?php echo $social_icons[$platform]; ?>
				</a>
			<?php endforeach; ?>
		</div>
	</div>

	<footer class="flex flex-wrap items-center gap-2.5 text-xs entry-footer">
		<?php cfu_entry_footer(); ?>
	</footer>
</article>