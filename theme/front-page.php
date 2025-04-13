<?php
/**
 * The template for displaying front pages
 *
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>
	<main id="main-front" class="front-cfu flex-1 w-full pt-12 pb-24 md:pb-40">
		<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content/content', 'front' );
			endwhile;
		?>
	</main>
<?php
get_footer();
