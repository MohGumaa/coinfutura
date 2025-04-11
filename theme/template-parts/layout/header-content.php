<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package coinfutura
 */

?>

<header id="masthead" class="flex items-center gap-2">

	<div>
		<?php
		if ( is_front_page() ) :
			?>
			<h1><?php bloginfo( 'name' ); ?></h1>
			<?php
		else :
			?>
			<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
		endif;

		$cfu_description = get_bloginfo( 'description', 'display' );
		if ( $cfu_description || is_customize_preview() ) :
			?>
			<p><?php echo $cfu_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
		<?php endif; ?>
	</div>

	<nav id="site-navigation" aria-label="<?php esc_attr_e( 'Main Navigation', 'coinfutura' ); ?>">
		<button aria-controls="primary-menu" aria-expanded="false" class="hidden"><?php esc_html_e( 'Primary Menu', 'coinfutura' ); ?></button>

		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'flex flex-col gap-x-2 gap-y-5 min-lg:flex-row min-lg:items-center min-lg:items-center min-lg:h-full',
				'items_wrap'     => '<ul id="%1$s" class="%2$s" aria-label="submenu">%3$s</ul>',
			)
		);
		?>
	</nav><!-- #site-navigation -->

</header><!-- #masthead -->
