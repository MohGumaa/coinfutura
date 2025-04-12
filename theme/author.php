<?php
/**
 * The template for displaying author pages
 *
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;
$cfu_author = get_query_var('author_name') ? get_user_by('slug', get_query_var('author_name')) : get_userdata(intval($author));
$cfu_author_id = $cfu_author->ID;

// Author meta data
$author_meta = [
	'display_name' => $cfu_author->display_name,
	'highlight_title' => function_exists('get_field') ? get_field('highlight_title', 'user_' . $cfu_author_id) : null,
	'description'  => get_the_author_meta('description', $cfu_author_id),
	'social'       => [
		'twitter'    => get_the_author_meta('twitter', $cfu_author_id),
		'facebook'   => get_the_author_meta('facebook', $cfu_author_id),
		'linkedin'   => get_the_author_meta('linkedin', $cfu_author_id),
		'instagram'  => get_the_author_meta('instagram', $cfu_author_id)
	]
];

$social_icons = [
	'twitter' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
		<path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
	</svg>',
	'facebook' => '<svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="22px" height="22px" fill="currentColor" class="size-[22px]"><path d="M25,3C12.85,3,3,12.85,3,25c0,11.03,8.125,20.137,18.712,21.728V30.831h-5.443v-5.783h5.443v-3.848 c0-6.371,3.104-9.168,8.399-9.168c2.536,0,3.877,0.188,4.512,0.274v5.048h-3.612c-2.248,0-3.033,2.131-3.033,4.533v3.161h6.588 l-0.894,5.783h-5.694v15.944C38.716,45.318,47,36.137,47,25C47,12.85,37.15,3,25,3z"/></svg>',
	'linkedin' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-linkedin size-4" viewBox="0 0 16 16">
		<path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z"/>
	</svg>',
	'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram size-4" viewBox="0 0 16 16">
		<path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
	</svg>'
];

// Get author avatar
$alt_text = sprintf(__('Profile picture of %s', 'coinfutura'), $author_meta['display_name']);
$avatar_url = function_exists('get_field') ? get_field('profile_picture', 'user_' . $cfu_author_id) : null;
$avatar = $avatar_url 
	? sprintf('<img src="%s" alt="%s" class="w-full h-full object-cover wp-post-image">', 
		esc_url($avatar_url['sizes']['medium']), 
		esc_attr($alt_text))
	: get_avatar($cfu_author_id, 200, '', $alt_text, ['class' => 'w-full h-full object-cover wp-post-image']);


get_header();
?>

	<main id="main-author" class="author-cfu flex-1 w-full pt-12 pb-24 md:pb-40">
		<section class="p-2 min-h-[119px] bg-gray-950/5 dark:bg-white/10 mb-12">
			<div class="flex flex-col md:flex-row max-md:items-center max-md:text-center gap-x-6 gap-y-4 relative overflow-hidden bg-gray-950/[2.5%] after:pointer-events-none after:absolute after:inset-0 after:rounded-lg after:inset-ring after:inset-ring-gray-950/5 dark:after:inset-ring-white/10 bg-[image:radial-gradient(var(--pattern-fg)_1px,_transparent_0)] bg-[size:10px_10px] bg-fixed [--pattern-fg:var(--color-gray-950)]/5 dark:[--pattern-fg:var(--color-white)]/10 h-full rounded-lg p-3">
				<figure class="flex-shrink-0 size-28 md:size-44 rounded-full md:rounded-md overflow-hidden">
					<?= $avatar ?>
				</figure>
				<div class="flex flex-col flex-1 min-w-0 space-y-2 min-md:pt-1.5">
					<h1 class="text-2xl font-bold page-title capitalize">
						<?php echo esc_html($author_meta['display_name']); ?>
					</h1>
					<?php if ($author_meta['highlight_title']) : ?>
						<p class="italic text-gray-950 dark:text-white">
							<?php echo esc_html($author_meta['highlight_title']); ?>
						</p>
					<?php endif; ?>
					<?php if ($author_meta['description']) : ?>
						<p class="text-sm leading-6">
							<?php echo esc_html($author_meta['description']); ?>
						</p>
					<?php endif; ?>
					<?php if (!empty(array_filter($author_meta['social']))) : ?>
						<div class="flex justify-start items-center max-md:justify-center gap-4 pt-3">
							<?php foreach ($author_meta['social'] as $platform => $url) : ?>
								<?php if ($url && isset($social_icons[$platform])) : ?>
									<a href="<?php echo esc_url($url); ?>"
										class="cfu-social-icon group"
										target="_blank"
										rel="noopener noreferrer"
										aria-label="<?php echo sprintf(__('Follow on %s', 'coinbullet'), ucfirst($platform)); ?>">
											<?php echo $social_icons[$platform]; ?>
									</a>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<section class="grid grid-cols-1 lg:grid-cols-12 gap-x-8 gap-y-10 container-center">
			<div class="col-span-full lg:col-span-9">
				<h2 class="text-lg md:text-xl font-semibold mb-6 title-with-underline">
					<?php printf(esc_html__('Articles written by %s', 'coinfutura'), esc_html($author_meta['display_name'])); ?>
				</h2>
				<?php if ( have_posts() ) :?>
					<?php 
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content/content', 'excerpt' );
						endwhile;
					?>
					<div class="flexCenter flex-1 md:justify-between mt-12 md:mt-16 mb-5">
						<?php cfu_the_posts_navigation(); ?>
					</div>
				<?php else: ?>
					<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
				<?php endif;?>
			</div>
			<div class="col-span-full lg:col-span-3 cfu-sidebar flex flex-col">
				<aside class="sticky-sidebar lg:sticky lg:top-16 space-y-6">
					<?php 
						if ( is_active_sidebar( 'right-sidebar' ) ) {
							dynamic_sidebar( 'right-sidebar' );
						}
					?>
				</aside>
			</div>
		</section>
	</main>

<?php
get_footer();
