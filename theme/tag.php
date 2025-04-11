<?php
/**
 * The template for displaying tag pages
 *
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

	<main id="main-tag" class="tag-cfu flex-1 w-full pt-12 pb-24 md:pb-40">

		<section class="p-2 bg-gray-950/5 dark:bg-white/10 mb-10">
			<div class="relative overflow-hidden bg-gray-950/[2.5%] after:pointer-events-none after:absolute after:inset-0 after:rounded-lg after:inset-ring after:inset-ring-gray-950/5 dark:after:inset-ring-white/10 bg-[image:radial-gradient(var(--pattern-fg)_1px,_transparent_0)] bg-[size:10px_10px] bg-fixed [--pattern-fg:var(--color-gray-950)]/5 dark:[--pattern-fg:var(--color-white)]/10 rounded-lg p-3">
				<h1 class="text-2xl lg:text-3xl text-balance font-bold title-with-underline capitalize page-title"><?php echo single_term_title('', false); ?></h1>
			</div>
		</section>
		
		<section class="grid grid-cols-1 lg:grid-cols-12 gap-x-8 gap-y-10 container-center">
			<div class="col-span-full lg:col-span-9">
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
