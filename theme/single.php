<?php
/**
 * The template for displaying all single posts
 *
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>
	<main id="main-single" class="single-cfu mt-16 relative before:absolute before:top-0 before:h-px before:w-[200vw] before:bg-gray-950/5 dark:before:bg-white/10 before:-left-[100vw] after:absolute after:bottom-0 after:h-px after:w-[200vw] after:bg-gray-950/5 dark:after:bg-white/10 after:-left-[100vw] mb-24 md:mb-40">
		<div class="grid lg:grid-cols-12 gap-x-2 gap-y-6 w-full bg-gray-950/5 p-2 dark:bg-white/10">
			<div class="col-span-full lg:col-span-9 @container isolate flex flex-col gap-2 overflow-hidden rounded-lg bg-white p-2 outline outline-gray-950/5 dark:bg-gray-950 dark:outline-white/10">
				<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content/content', 'single' );
					endwhile;
				?>
			</div>
			<div class="cfu-sidebar col-span-full lg:col-span-3 @container isolate flex flex-col gap-2 rounded-lg bg-white p-2 outline outline-gray-950/5 dark:bg-gray-950 dark:outline-white/10">
				<aside class="sticky-sidebar lg:sticky lg:top-16 space-y-6">
					<?php 
						if ( is_active_sidebar( 'right-sidebar' ) ) {
							dynamic_sidebar( 'right-sidebar' );
						}
					?>
				</aside>
			</div>
			<?php get_template_part( 'template-parts/content/content', 'related_articles' ); ?>
		</div>
	</main>
<?php
get_footer();
