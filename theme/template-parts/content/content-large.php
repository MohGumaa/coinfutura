<?php
/**
 * Template part for displaying post archives and search results
 *
 * @package coinfutura
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php
		if ( is_sticky() && is_home() && ! is_paged() ) {
			printf( '%s', esc_html_x( 'Featured', 'post', 'coinfutura' ) );
		}
		the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		?>
	</header><!-- .entry-header -->

	<?php cfu_post_thumbnail(); ?>

	<div <?php cfu_content_class( 'entry-content' ); ?>>
		<?php the_excerpt(); ?>
	</div>

</article>
