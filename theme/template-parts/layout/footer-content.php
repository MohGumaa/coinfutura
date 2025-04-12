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

<div class="flex flex-col items-center gap-6 sm:flex-row sm:justify-between sm:gap-8 pt-10 pb-24 container-center w-full">
	<div class="min-sm:hidden relative z-0 inline-grid grid-cols-3 gap-0.5 rounded-full bg-gray-950/5 p-0.75 text-gray-950 dark:bg-white/10 dark:text-white" id="headlessui-radiogroup-:Rcaulb:" role="radiogroup">
		<span class="rounded-full p-1.5 *:size-7 data-checked:bg-white data-checked:ring data-checked:inset-ring data-checked:ring-gray-950/10 data-checked:inset-ring-white/10 sm:p-0 dark:data-checked:bg-gray-700 dark:data-checked:text-white dark:data-checked:ring-transparent" aria-label="System theme" id="headlessui-radio-:Rdcaulb:" role="radio" aria-checked="true" tabindex="0" data-headlessui-state="">
			<svg viewBox="0 0 28 28" fill="none">
				<path d="M7.5 8.5C7.5 7.94772 7.94772 7.5 8.5 7.5H19.5C20.0523 7.5 20.5 7.94772 20.5 8.5V16.5C20.5 17.0523 20.0523 17.5 19.5 17.5H8.5C7.94772 17.5 7.5 17.0523 7.5 16.5V8.5Z" stroke="currentColor"></path>
				<path d="M7.5 8.5C7.5 7.94772 7.94772 7.5 8.5 7.5H19.5C20.0523 7.5 20.5 7.94772 20.5 8.5V14.5C20.5 15.0523 20.0523 15.5 19.5 15.5H8.5C7.94772 15.5 7.5 15.0523 7.5 14.5V8.5Z" stroke="currentColor"></path>
				<path d="M16.5 20.5V17.5H11.5V20.5M16.5 20.5H11.5M16.5 20.5H17.5M11.5 20.5H10.5" stroke="currentColor" stroke-linecap="round"></path>
			</svg>
		</span>
		<span class="rounded-full p-1.5 *:size-7 data-checked:bg-white data-checked:ring data-checked:inset-ring data-checked:ring-gray-950/10 data-checked:inset-ring-white/10 sm:p-0 dark:data-checked:bg-gray-700 dark:data-checked:text-white dark:data-checked:ring-transparent" aria-label="Light theme" id="headlessui-radio-:Rlcaulb:" role="radio" aria-checked="false" tabindex="-1" data-headlessui-state="">
			<svg viewBox="0 0 28 28" fill="none">
				<circle cx="14" cy="14" r="3.5" stroke="currentColor"></circle>
				<path d="M14 8.5V6.5" stroke="currentColor" stroke-linecap="round"></path>
				<path d="M17.889 10.1115L19.3032 8.69727" stroke="currentColor" stroke-linecap="round"></path>
				<path d="M19.5 14L21.5 14" stroke="currentColor" stroke-linecap="round"></path>
				<path d="M17.889 17.8885L19.3032 19.3027" stroke="currentColor" stroke-linecap="round"></path>
				<path d="M14 21.5V19.5" stroke="currentColor" stroke-linecap="round"></path>
				<path d="M8.69663 19.3029L10.1108 17.8887" stroke="currentColor" stroke-linecap="round"></path>
				<path d="M6.5 14L8.5 14" stroke="currentColor" stroke-linecap="round"></path>
				<path d="M8.69663 8.69711L10.1108 10.1113" stroke="currentColor" stroke-linecap="round"></path>
			</svg>
		</span>
		<span class="rounded-full p-1.5 *:size-7 data-checked:bg-white data-checked:ring data-checked:inset-ring data-checked:ring-gray-950/10 data-checked:inset-ring-white/10 sm:p-0 dark:data-checked:bg-gray-700 dark:data-checked:text-white dark:data-checked:ring-transparent" aria-label="Dark theme" id="headlessui-radio-:Rtcaulb:" role="radio" aria-checked="false" tabindex="-1" data-headlessui-state="">
			<svg viewBox="0 0 28 28" fill="none">
				<path d="M10.5 9.99914C10.5 14.1413 13.8579 17.4991 18 17.4991C19.0332 17.4991 20.0176 17.2902 20.9132 16.9123C19.7761 19.6075 17.109 21.4991 14 21.4991C9.85786 21.4991 6.5 18.1413 6.5 13.9991C6.5 10.8902 8.39167 8.22304 11.0868 7.08594C10.7089 7.98159 10.5 8.96597 10.5 9.99914Z" stroke="currentColor" stroke-linejoin="round"></path>
				<path d="M16.3561 6.50754L16.5 5.5L16.6439 6.50754C16.7068 6.94752 17.0525 7.29321 17.4925 7.35607L18.5 7.5L17.4925 7.64393C17.0525 7.70679 16.7068 8.05248 16.6439 8.49246L16.5 9.5L16.3561 8.49246C16.2932 8.05248 15.9475 7.70679 15.5075 7.64393L14.5 7.5L15.5075 7.35607C15.9475 7.29321 16.2932 6.94752 16.3561 6.50754Z" fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
				<path d="M20.3561 11.5075L20.5 10.5L20.6439 11.5075C20.7068 11.9475 21.0525 12.2932 21.4925 12.3561L22.5 12.5L21.4925 12.6439C21.0525 12.7068 20.7068 13.0525 20.6439 13.4925L20.5 14.5L20.3561 13.4925C20.2932 13.0525 19.9475 12.7068 19.5075 12.6439L18.5 12.5L19.5075 12.3561C19.9475 12.2932 20.2932 11.9475 20.3561 11.5075Z" fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
			</svg>
		</span>
	</div>
	<p class="text-sm text-gray-600 dark:text-gray-400">&copy; <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>. <?php esc_html_e('All rights reserved.', 'coinfutura'); ?></p>
</div>
