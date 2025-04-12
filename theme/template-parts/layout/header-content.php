<?php
/**
 * Template part for displaying the header content
 *
 *
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;

/**
 * Custom Walker class for responsive navigation
 * Implements dropdown with transition effects on hover
 */
class Coinfutura_Walker_Nav_Menu extends Walker_Nav_Menu {
	/**
	 * Starts the element output.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'group max-lg:flex max-lg:flex-col max-lg:gap-y-2'; // Add group class to enable group-hover functionality
			
		// Add custom classes based on whether the item has children and depth
		if ( in_array( 'menu-item-has-children', $classes ) ) {
			$classes[] = 'min-lg:relative'; // Position relative for parent items
			$classes[] = 'min-lg:flex';
			$classes[] = 'min-lg:items-center';
		}
			
		/**
		 * Filters the arguments for a single nav menu item.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
			
		// Join class names
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
			
		/**
		 * Filters the ID applied to a menu item's list item element.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
			
		$output .= $indent . '<li' . $id . $class_names . '>';
		
		// Link attributes
		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';
			
		// Add classes to the anchor based on depth
		if ( $depth === 0 ) {
			$atts['class'] = 'menu-item-type-taxonomy-link font-medium text-gray-950 dark:text-white max-lg:text-xl min-lg:mx-2 min-lg:mx-2.5 min-lg:flex min-lg:items-center group-hover:border-b border-gray-950 dark:border-white group-hover:text-blue-600 dark:group-hover:text-blue-400';
		} else {
			$atts['class'] = 'block text-sm transition duration-150 ease-in-out max-lg:text-gray-600 max-lg:dark:text-gray-300 max-lg:underline min-lg:text-base min-lg:text-gray-800 min-lg:dark:text-gray-200 min-lg:hover:bg-gray-100 min-lg:dark:hover:bg-gray-700 min-lg:dark:hover:text-white min-lg:py-2 min-lg:px-4';
		}
			
		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
		
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
			
		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );
			
		/**
		 * Filters a menu item's title.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
		
		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . $title . $args->link_after;
		
		// Add dropdown arrow for items with children, but only on first level
		if ( in_array( 'menu-item-has-children', $classes ) && $depth === 0 ) {
			$item_output .= ' <svg class="ml-1 w-4 h-4 hidden min-lg:inline-block transition-transform duration-200 group-hover:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
				<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
			</svg>';
		}
			
		$item_output .= '</a>';
		$item_output .= $args->after;
		
		/**
		 * Filters a menu item's starting output.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	
	/**
	 * Starts the list before the elements are added.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$indent = str_repeat( "\t", $depth );
		
		// For first level sub-menu
		if ( $depth === 0 ) {
			// Add dropdown with transition effects like the example
			$output .= '<div class="min-lg:absolute min-lg:left-0 min-lg:top-full min-lg:mt-6 min-lg:z-50 min-lg:w-48 min-lg:origin-top-right min-lg:rounded-md min-lg:bg-white min-lg:dark:bg-gray-800 min-lg:shadow-lg min-lg:inset-ring min-lg:inset-ring-black/5 min-lg:dark:inset-ring-white/10 focus:outline-none min-lg:opacity-0 min-lg:scale-95 min-lg:invisible min-lg:transition-all min-lg:duration-300 group-hover:visible group-hover:opacity-100 group-hover:scale-100">' . "\n";
			$output .= "{$indent}<ul class=\"sub-menu flex flex-col max-lg:gap-y-4 min-lg:py-1\">\n";
		} else {
			// For deeper levels (2nd level +)
			$output .= "{$indent}<ul class=\"sub-menu pl-4\">\n";
		}
	}
	
	/**
	 * Ends the list of after the elements are added.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ($depth === 0) {
			$output .= "</ul>\n"; // Close the submenu
			$output .= "</div>\n"; // Close the dropdown container
		} else {
			$indent = str_repeat( "\t", $depth );
			$output .= "$indent</ul>\n";
		}
	}
}
?>

<div class="min-h-11">
	<gecko-coin-price-marquee-widget locale="en" dark-mode="true" outlined="true" coin-ids="pancakeswap-token,pi-network,bitcoin,binancecoin,solana,ethereum,jupiter-exchange-solana,the-open-network,hyperliquid,berachain-bera,dogecoin,bubblemaps" initial-currency="usd"></gecko-coin-price-marquee-widget>
</div>
<header id="masthead" class="sticky inset-x-0 top-0 z-50 bg-white dark:bg-gray-950 border-y border-black/5 dark:border-white/10 shadow-xs backdrop-blur">
	<div class="grid grid-cols-1 grid-rows-[1fr_1px_auto_1px_auto] justify-center [--gutter-width:2.5rem] lg:grid-cols-[var(--gutter-width)_minmax(0,var(--breakpoint-2xl))_var(--gutter-width)] max-md:overflow-x-hidden">
		<div class="col-start-1 row-span-full row-start-1 hidden lg:block"></div>
		<div id="header-nav" class="flex items-center justify-between gap-8 px-1.5 lg:px-0 h-14">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="flex items-center gap-1.5 min-lg:me-2">
				<span class="sr-only"><?php esc_html_e( 'Coinfutura home page', 'coinfutura' ); ?></span>
				<svg class="min-md:w-8 min-md:h-[42.47px]" viewBox="0 0 58 77" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" clip-rule="evenodd" d="M29.2801 0.0400085H35.6801L35.8401 5.80002C35.8401 5.80002 49.4401 6.12002 57.6001 17.32L42.8801 32.5201C30.4001 16.2 10.5601 39.5601 28.9601 48.5201C28.9601 48.5201 37.2801 51.8801 42.2401 43.5601L57.6001 58.9201C57.6001 58.9201 49.6001 69.9601 36.1601 70.4401L36.0001 76.0401H29.1201L29.2801 70.4401C-3.83995 67.8801 -14.4 15.56 29.1201 5.64002L29.2801 0.0400085ZM47.6801 17.64L42.7201 22.76C24.3201 10.6 2.88006 36.0401 21.2801 52.2001C21.2801 52.2001 30.4001 60.6801 42.2401 53.0001L47.5201 58.4401C47.5201 58.4401 35.3601 67.7201 20.1601 59.5601C-0.639947 49.1601 5.28006 13.32 32.3201 12.68C32.3201 12.68 40.3201 12.2 47.6801 17.64Z" fill="url(#paint0_linear_735_20)"/>
					<defs>
					<linearGradient id="paint0_linear_735_20" x1="54.8581" y1="52.4247" x2="3.1158" y2="23.5487" gradientUnits="userSpaceOnUse">
					<stop stop-color="#03FA6F"/>
					<stop offset="0.580392" stop-color="#03DEB5"/>
					<stop offset="1" stop-color="#04C2FC"/>
					</linearGradient>
					</defs>
				</svg>
				<span class="font-bold text-lg xl:text-xl tracking-wide uppercase cfu-title"><?php bloginfo( 'name' ); ?></span>
			</a>

			<div id="navigation-container" class="flex-1 flex justify-between gap-x-2 gap-y-9 min-lg:flex-row min-lg:items-center min-lg:h-full max-lg:focus:outline-none max-lg:flex-col max-lg:bg-white dark:max-lg:bg-gray-950 max-lg:border-t border-black/5 dark:border-white/10 max-lg:fixed max-lg:left-0 max-lg:top-14 max-lg:z-40 max-lg:w-full max-lg:overflow-y-auto max-lg:whitespace-nowrap max-lg:scroll-smooth max-lg:h-[calc(100dvh-56px)] max-lg:translate-x-[-100%] max-lg:transition-all max-lg:duration-700 max-lg:ease-in-out max-lg:px-3 max-lg:pt-4 max-lg:pb-20">
				<nav id="site-navigation" aria-label="<?php esc_attr_e( 'Main Navigation', 'coinfutura' ); ?>" class="min-lg:w-full">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'container'      => false,
								'menu_id'        => 'primary-menu',
								'menu_class'     => 'flex flex-col gap-x-2 gap-y-5 min-lg:flex-row min-lg:items-center min-lg:items-center min-lg:h-full',
								'items_wrap'     => '<ul id="%1$s" class="%2$s" aria-label="submenu">%3$s</ul>',
								'walker'         => new Coinfutura_Walker_Nav_Menu(),
							)
						);
					?>
				</nav>
				<div class="flex-shrink-0 min-lg:w-24 max-lg:w-full max-lg:text-sm min-sm:h-11 min-lg:h-auto relative z-0 inline-grid grid-cols-3 gap-0.5 rounded-lg min-lg:rounded-full bg-gray-950/5 p-1 min-lg:p-0.75 text-gray-950 dark:bg-white/10 dark:text-white" role="radiogroup">
					<span class="max-lg:flex max-lg:items-center max-lg:gap-x-1 capitalize rounded-md min-lg:rounded-full p-1.5 min-lg:*:size-7 data-checked:bg-white data-checked:ring data-checked:inset-ring data-checked:ring-gray-950/10 data-checked:inset-ring-white/10 sm:p-0 dark:data-checked:bg-gray-700 dark:data-checked:text-white dark:data-checked:ring-transparent" aria-label="System theme" id="headlessui-radio-:Rdcaulb:" role="radio" aria-checked="true" tabindex="0" data-headlessui-state="">
						<svg viewBox="0 0 28 28" fill="none" class="max-lg:w-6 max-lg:h-6">
							<path d="M7.5 8.5C7.5 7.94772 7.94772 7.5 8.5 7.5H19.5C20.0523 7.5 20.5 7.94772 20.5 8.5V16.5C20.5 17.0523 20.0523 17.5 19.5 17.5H8.5C7.94772 17.5 7.5 17.0523 7.5 16.5V8.5Z" stroke="currentColor"></path>
							<path d="M7.5 8.5C7.5 7.94772 7.94772 7.5 8.5 7.5H19.5C20.0523 7.5 20.5 7.94772 20.5 8.5V14.5C20.5 15.0523 20.0523 15.5 19.5 15.5H8.5C7.94772 15.5 7.5 15.0523 7.5 14.5V8.5Z" stroke="currentColor"></path>
							<path d="M16.5 20.5V17.5H11.5V20.5M16.5 20.5H11.5M16.5 20.5H17.5M11.5 20.5H10.5" stroke="currentColor" stroke-linecap="round"></path>
						</svg>
						<span class="min-lg:hidden"><?php esc_html_e( 'system', 'coinfutura' ); ?></span>
					</span>
					<span class="max-lg:flex max-lg:items-center max-lg:gap-x-1 capitalize rounded-md min-lg:rounded-full p-1.5 min-lg:*:size-7 data-checked:bg-white data-checked:ring data-checked:inset-ring data-checked:ring-gray-950/10 data-checked:inset-ring-white/10 sm:p-0 dark:data-checked:bg-gray-700 dark:data-checked:text-white dark:data-checked:ring-transparent" aria-label="Light theme" id="headlessui-radio-:Rlcaulb:" role="radio" aria-checked="false" tabindex="-1" data-headlessui-state="">
						<svg viewBox="0 0 28 28" fill="none" class="max-lg:w-6 max-lg:h-6">
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
						<span class="min-lg:hidden"><?php esc_html_e( 'light', 'coinfutura' ); ?></span>
					</span>
					<span class="max-lg:flex max-lg:items-center max-lg:gap-x-1 capitalize rounded-md min-lg:rounded-full p-1.5 min-lg:*:size-7 data-checked:bg-white data-checked:ring data-checked:inset-ring data-checked:ring-gray-950/10 data-checked:inset-ring-white/10 sm:p-0 dark:data-checked:bg-gray-700 dark:data-checked:text-white dark:data-checked:ring-transparent" aria-label="Dark theme" id="headlessui-radio-:Rtcaulb:" role="radio" aria-checked="false" tabindex="-1" data-headlessui-state="">
						<svg viewBox="0 0 28 28" fill="none" class="max-lg:w-6 max-lg:h-6">
							<path d="M10.5 9.99914C10.5 14.1413 13.8579 17.4991 18 17.4991C19.0332 17.4991 20.0176 17.2902 20.9132 16.9123C19.7761 19.6075 17.109 21.4991 14 21.4991C9.85786 21.4991 6.5 18.1413 6.5 13.9991C6.5 10.8902 8.39167 8.22304 11.0868 7.08594C10.7089 7.98159 10.5 8.96597 10.5 9.99914Z" stroke="currentColor" stroke-linejoin="round"></path>
							<path d="M16.3561 6.50754L16.5 5.5L16.6439 6.50754C16.7068 6.94752 17.0525 7.29321 17.4925 7.35607L18.5 7.5L17.4925 7.64393C17.0525 7.70679 16.7068 8.05248 16.6439 8.49246L16.5 9.5L16.3561 8.49246C16.2932 8.05248 15.9475 7.70679 15.5075 7.64393L14.5 7.5L15.5075 7.35607C15.9475 7.29321 16.2932 6.94752 16.3561 6.50754Z" fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
							<path d="M20.3561 11.5075L20.5 10.5L20.6439 11.5075C20.7068 11.9475 21.0525 12.2932 21.4925 12.3561L22.5 12.5L21.4925 12.6439C21.0525 12.7068 20.7068 13.0525 20.6439 13.4925L20.5 14.5L20.3561 13.4925C20.2932 13.0525 19.9475 12.7068 19.5075 12.6439L18.5 12.5L19.5075 12.3561C19.9475 12.2932 20.2932 11.9475 20.3561 11.5075Z" fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
						</svg>
						<span class="min-lg:hidden"><?php esc_html_e( 'dark', 'coinfutura' ); ?></span>
					</span>
				</div>
			</div>

			<div class="flex items-center gap-2 min-lg:hidden">
				<button aria-controls="primary-menu" aria-expanded="false" type="button" id="primary-menu-btn" class="relative w-7 border-none outline-none flexCenter cursor-pointer navbar-toggler">
					<span class="cfu-bar-icon"></span>
				</button>
			</div>
		</div>
		<div class="row-span-full row-start-1 hidden lg:col-start-3 lg:block"></div>
	</div>
</header>
