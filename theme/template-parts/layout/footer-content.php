<?php
/**
 * Template part for displaying the footer content
 *
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;
?>

<?php if ( is_active_sidebar( 'cfu-footer' ) ) : ?>
	<footer id="colophon" class="cfu-footer grid md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-8 w-full relative before:absolute before:top-0 before:h-px before:w-[200vw] before:bg-gray-950/5 dark:before:bg-white/10 before:-left-[100vw] after:absolute after:bottom-0 after:h-px after:w-[200vw] after:bg-gray-950/5 dark:after:bg-white/10 after:-left-[100vw]" aria-label="<?php esc_attr_e( 'Footer', 'coinfutura' ); ?>">
		<?php dynamic_sidebar( 'cfu-footer' ); ?>
	</footer>
<?php endif; ?>

<div class="flex flex-col items-center gap-6 sm:flex-row justify-center sm:gap-8 py-10 container-center w-full">
	<p class="text-sm text-gray-600 dark:text-gray-400">&copy; <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>. <?php esc_html_e('All rights reserved.', 'coinfutura'); ?></p>
</div>
