<?php
/**
 * Template part for displaying a message when posts are not found
 *
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;
?>

<section class="none-page">
	<?php if ( is_search() ) :?>
		<?php
			printf(
				/* translators: 1: search result title. 2: search term. */
				'<h1 class="page-title font-semibold max-md:text-2xl capitalize title-with-underline mb-10">%1$s <span>%2$s</span></h1>',
				esc_html__( 'Search results for:', 'coinfutura' ),
				get_search_query()
			);
			?>
	<?php else :?>
		<h1 class="page-title font-semibold max-md:text-2xl capitalize title-with-underline mb-10"><?php esc_html_e( 'Nothing Found', 'coinfutura' ); ?></h1>
	<?php endif; ?>

	<div <?php cfu_content_class( 'page-content' ); ?>>
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :
			?>

			<p>
				<?php esc_html_e( 'Your site is set to show the most recent posts on your homepage, but you haven&rsquo;t published any posts.', 'coinfutura' ); ?>
			</p>

			<p>
				<a href="<?php echo esc_url( admin_url( 'edit.php' ) ); ?>">
					<?php
					/* translators: 1: link to WP admin new post page. */
					esc_html_e( 'Add or publish posts', 'coinfutura' );
					?>
				</a>
			</p>

			<?php
		elseif ( is_search() ) :
			?>

			<p>
				<?php esc_html_e( 'Your search generated no results. Please try a different search.', 'coinfutura' ); ?>
			</p>

			<?php
			get_search_form();
		else :
			?>

			<p>
				<?php esc_html_e( 'No content matched your request.', 'coinfutura' ); ?>
			</p>

			<?php
			get_search_form();
		endif;
		?>
	</div>

</section>
