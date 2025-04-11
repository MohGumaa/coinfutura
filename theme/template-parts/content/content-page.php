<?php
/**
 * Template part for displaying pages
 * 
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div <?php cfu_content_class( 'entry-content' ); ?>>
		<?php the_title( '<h1 class="text-3xl md:text-[2.5rem]/10 text-balance font-bold page-title mb-4">', '</h1>' ); ?>
		<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div>' . __( 'Pages:', 'coinfutura' ),
					'after'  => '</div>',
				)
			);
		?>
	</div>
</article>
