<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default. Please note that
 * this is the WordPress construct of pages: specifically, posts with a post
 * type of `page`.
 *
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>
	<main id="main-page" class="page-cfu flex-1 w-full pt-10 pb-24">
		<div class="container container-center max-w-3xl px-4 sm:px-3">
			<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content/content', 'page' );
				endwhile;
			?>
		</div>
	</main>
<?php
get_footer();
