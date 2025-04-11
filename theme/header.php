<?php
/**
 * The header for our theme
 *
 * This is the template that displays the `head` element and everything up
 * until the `#content` element.
 *
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#030712">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<!-- Add inline script in the head to prevent FOUC (Flash of Unstyled Content) -->
	<script>
  // On page load or when changing themes, add dark class to HTML if needed
		(function() {
			const hasStoredTheme = 'theme' in localStorage;
			const isDarkTheme = 
				hasStoredTheme 
					? localStorage.theme === 'dark' 
					: window.matchMedia('(prefers-color-scheme: dark)').matches;
			
			document.documentElement.classList.toggle('dark', isDarkTheme);
		})();
	</script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div id="page" class="max-w-screen">
	<a href="#content" class="sr-only"><?php esc_html_e( 'Skip to content', 'coinfutura' ); ?></a>

	<?php get_template_part( 'template-parts/layout/header', 'content' ); ?>

	<div id="content" class="grid grid-cols-1 grid-rows-[1fr_1px_auto_1px_auto] justify-center [--gutter-width:2.5rem] lg:grid-cols-[var(--gutter-width)_minmax(0,var(--breakpoint-2xl))_var(--gutter-width)] min-h-dvh max-md:overflow-x-hidden">
		<div class="col-start-1 row-span-full row-start-1 hidden border-x border-x-(--pattern-fg) bg-[image:repeating-linear-gradient(315deg,_var(--pattern-fg)_0,_var(--pattern-fg)_1px,_transparent_0,_transparent_50%)] bg-[size:10px_10px] bg-fixed [--pattern-fg:var(--color-black)]/5 lg:block dark:[--pattern-fg:var(--color-white)]/10"></div>
		<div id="content-body" class="flex flex-col justify-between w-full h-full">
