<?php
/**
 * The template for displaying search results pages
 *
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>
	<main id="main-search" class="search-cfu flex-1 w-full pt-9 md:pt-14 md:pb-40">
		<section class="grid grid-cols-1 lg:grid-cols-12 gap-x-8 gap-y-10 container-center">
			<div class="col-span-full lg:col-span-9">
				<?php if ( have_posts() ) :?>
					<?php
						printf(
							/* translators: 1: search result title. 2: search term. */
							'<h1 class="page-title font-semibold max-md:text-2xl capitalize title-with-underline mb-10">%1$s <span>%2$s</span></h1>',
							esc_html__( 'Search results for:', 'coinfutura' ),
							get_search_query()
						);
					?>
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
