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
				<svg class="hidden dark:inline-block w-32 h-[45.5px]" viewBox="0 0 146 52" fill="none" xmlns="http://www.w3.org/2000/svg">
					<g clip-path="url(#clip0_746_66)">
					<path fill-rule="evenodd" clip-rule="evenodd" d="M19.6067 0.00192261H23.9439L24.0333 3.89196C24.0333 3.89196 33.2442 4.11552 38.7663 11.6944L28.8176 21.9784C20.3669 10.9343 6.93059 26.7627 19.3832 32.8213C19.3832 32.8213 25.017 35.1016 28.3705 29.4678L38.7663 39.8636C38.7663 39.8636 33.356 47.3307 24.2569 47.666L24.1451 51.4443H19.4949L19.6067 47.666C-2.81685 45.9222 -9.97094 10.5095 19.4949 3.80253L19.6067 0.00192261ZM32.0593 11.9179L28.7058 15.3832C16.2533 7.15601 1.72152 24.3705 14.1965 35.3029C14.1965 35.3029 20.3669 41.0485 28.3705 35.8394L31.9475 39.5282C31.9475 39.5282 23.7203 45.8104 13.4363 40.2884C-0.648271 33.2461 3.35354 8.98924 21.6635 8.56447C21.6635 8.56447 27.0738 8.22912 32.0593 11.9179Z" fill="url(#paint0_linear_746_66)"/>
					<path d="M41.1585 35.437C39.8395 35.437 38.6769 35.1464 37.6262 34.5651C36.5754 33.9838 35.7482 33.179 35.167 32.1059C34.5633 31.0551 34.2727 29.8255 34.2727 28.4394C34.2727 27.0533 34.5633 25.8237 35.1893 24.7506C35.7929 23.6998 36.6425 22.8726 37.6933 22.2914C38.7664 21.7101 39.9513 21.4195 41.2479 21.4195C42.567 21.4195 43.7519 21.7101 44.8026 22.2914C45.8757 22.8726 46.7029 23.6998 47.3289 24.7506C47.9325 25.8237 48.2455 27.0533 48.2455 28.4394C48.2455 29.8255 47.9325 31.0551 47.2842 32.1059C46.6582 33.179 45.8087 33.9838 44.7356 34.5651C43.6848 35.1464 42.4775 35.437 41.1585 35.437ZM41.1585 32.4636C41.7845 32.4636 42.3658 32.3071 42.9023 31.9941C43.4612 31.7035 43.886 31.234 44.2214 30.6303C44.5343 30.0267 44.7132 29.289 44.7132 28.4394C44.7132 27.1427 44.3778 26.159 43.6848 25.4436C43.0141 24.7506 42.1869 24.4152 41.2032 24.4152C40.2195 24.4152 39.3923 24.7506 38.744 25.4436C38.0733 26.159 37.738 27.1427 37.738 28.4394C37.738 29.7137 38.0733 30.7198 38.7217 31.4128C39.37 32.1059 40.1748 32.4636 41.1585 32.4636Z" fill="white"/>
					<path d="M51.7777 20.0334C51.1741 20.0334 50.6599 19.8321 50.2574 19.4521C49.855 19.072 49.6538 18.5802 49.6538 18.0213C49.6538 17.44 49.855 16.9705 50.2574 16.5905C50.6599 16.188 51.1741 16.0092 51.7777 16.0092C52.3813 16.0092 52.8731 16.188 53.2756 16.5905C53.678 16.9705 53.8792 17.44 53.8792 18.0213C53.8792 18.5802 53.678 19.072 53.2756 19.4521C52.8731 19.8321 52.3813 20.0334 51.7777 20.0334ZM53.4544 21.643V35.2134H50.0339V21.643H53.4544Z" fill="white"/>
					<path d="M63.6268 21.4418C65.2588 21.4418 66.5555 21.956 67.5615 22.9844C68.5452 23.9905 69.0594 25.4213 69.0594 27.2545V35.2134H65.6165V27.724C65.6165 26.6509 65.3482 25.8237 64.8117 25.2424C64.2751 24.6612 63.5374 24.3705 62.5984 24.3705C61.6594 24.3705 60.8993 24.6612 60.3627 25.2424C59.8038 25.8237 59.5355 26.6509 59.5355 27.724V35.2134H56.115V21.643H59.5355V23.3421C60.005 22.7385 60.5863 22.2914 61.3017 21.956C61.9948 21.6207 62.7772 21.4418 63.6268 21.4418Z" fill="white"/>
					<path d="M82.138 18.1107V20.8829H75.0062V25.2648H80.4836V27.9923H75.0062V35.2134H71.5857V18.1107H82.138Z" fill="white"/>
					<path d="M96.6473 21.643V35.2134H93.2044V33.5143C92.7573 34.0956 92.176 34.5651 91.4606 34.9004C90.7675 35.2358 89.9851 35.3923 89.1579 35.3923C88.0848 35.3923 87.1458 35.1687 86.3409 34.7216C85.5138 34.2745 84.8654 33.6038 84.4183 32.7319C83.9488 31.86 83.7029 30.8092 83.7029 29.6019V21.643H87.1458V29.1101C87.1458 30.2056 87.4141 31.0328 87.9506 31.614C88.4872 32.1953 89.2249 32.4859 90.1639 32.4859C91.1029 32.4859 91.8407 32.1953 92.3996 31.614C92.9361 31.0328 93.2044 30.2056 93.2044 29.1101V21.643H96.6473Z" fill="white"/>
					<path d="M103.31 24.4599V31.0328C103.31 31.4799 103.421 31.8152 103.623 32.0165C103.846 32.2177 104.226 32.3294 104.74 32.3294H106.35V35.2134H104.181C101.297 35.2134 99.8443 33.8273 99.8443 31.0104V24.4599H98.2346V21.643H99.8443V18.2896H103.31V21.643H106.35V24.4599H103.31Z" fill="white"/>
					<path d="M120.904 21.643V35.2134H117.439V33.5143C117.014 34.0956 116.433 34.5651 115.717 34.9004C115.002 35.2358 114.242 35.3923 113.392 35.3923C112.342 35.3923 111.403 35.1687 110.575 34.7216C109.771 34.2745 109.122 33.6038 108.653 32.7319C108.183 31.86 107.96 30.8092 107.96 29.6019V21.643H111.38V29.1101C111.38 30.2056 111.671 31.0328 112.207 31.614C112.744 32.1953 113.482 32.4859 114.398 32.4859C115.36 32.4859 116.097 32.1953 116.634 31.614C117.171 31.0328 117.439 30.2056 117.439 29.1101V21.643H120.904Z" fill="white"/>
					<path d="M126.985 23.7445C127.432 23.0291 127.991 22.4702 128.707 22.0678C129.422 21.643 130.227 21.4418 131.143 21.4418V25.0412H130.249C129.154 25.0412 128.349 25.3095 127.812 25.8013C127.253 26.3155 126.985 27.2098 126.985 28.4618V35.2134H123.542V21.643H126.985V23.7445Z" fill="white"/>
					<path d="M131.836 28.3947C131.836 27.0086 132.105 25.8013 132.664 24.7282C133.2 23.6775 133.938 22.8503 134.877 22.269C135.838 21.7101 136.867 21.4195 138.029 21.4195C139.058 21.4195 139.929 21.6207 140.69 22.0454C141.45 22.4479 142.076 22.9621 142.523 23.588V21.643H145.988V35.2134H142.523V33.2461C142.076 33.872 141.472 34.4086 140.69 34.811C139.929 35.2358 139.035 35.437 138.007 35.437C136.867 35.437 135.838 35.1464 134.877 34.5651C133.938 33.9838 133.2 33.1343 132.664 32.0835C132.105 31.0104 131.836 29.7808 131.836 28.3947ZM142.523 28.4394C142.523 27.5899 142.366 26.8745 142.031 26.2932C141.718 25.6896 141.271 25.2424 140.712 24.9071C140.153 24.5941 139.549 24.4376 138.923 24.4376C138.275 24.4376 137.694 24.5941 137.157 24.9071C136.621 25.2201 136.174 25.6672 135.838 26.2708C135.503 26.8521 135.346 27.5675 135.346 28.3947C135.346 29.1995 135.503 29.9149 135.838 30.5186C136.174 31.1445 136.621 31.614 137.157 31.927C137.716 32.2624 138.297 32.4189 138.923 32.4189C139.549 32.4189 140.153 32.2624 140.712 31.9494C141.271 31.6364 141.718 31.1669 142.031 30.5856C142.366 29.982 142.523 29.2666 142.523 28.4394Z" fill="white"/>
					</g>
					<defs>
					<linearGradient id="paint0_linear_746_66" x1="38.4204" y1="36.3903" x2="0.351166" y2="15.0573" gradientUnits="userSpaceOnUse">
					<stop stop-color="#03FA6F"/>
					<stop offset="0.580392" stop-color="#03DEB5"/>
					<stop offset="1" stop-color="#04C2FC"/>
					</linearGradient>
					<clipPath id="clip0_746_66">
					<rect width="145.988" height="51.4462" fill="white"/>
					</clipPath>
					</defs>
				</svg>
				<svg class="inline-block dark:hidden w-32 h-[45.5px]" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="38.626mm" height="13.6118mm" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
					viewBox="0 0 6530 2301"
					xmlns:xlink="http://www.w3.org/1999/xlink">
					<defs>
						<style type="text/css">
						<![CDATA[
							.fil1 {fill:black;fill-rule:nonzero}
							.fil0 {fill:url(#id0)}
						]]>
						</style>
						<linearGradient id="id0" gradientUnits="userSpaceOnUse" x1="1718.53" y1="1627.64" x2="15.7046" y2="673.423">
						<stop offset="0" style="stop-opacity:1; stop-color:#03FA6F"/>
						<stop offset="0.580392" style="stop-opacity:1; stop-color:#03DEB5"/>
						<stop offset="1" style="stop-opacity:1; stop-color:#04C2FC"/>
						</linearGradient>
					</defs>
					<g id="Layer_x0020_1">
						<metadata id="CorelCorpID_0Corel-Layer"/>
						<g id="_1971169678512">
						<path class="fil0" d="M877 0l194 0 4 174c0,0 412,10 659,349l-445 460c-378,-494 -979,214 -422,485 0,0 252,102 402,-150l465 465c0,0 -242,334 -649,349l-5 169 -208 0 5 -169c-1003,-78 -1323,-1662 -5,-1962l5 -170 0 0zm557 533l-150 155c-557,-368 -1207,402 -649,891 0,0 276,257 634,24l160 165c0,0 -368,281 -828,34 -630,-315 -451,-1400 368,-1419 0,0 242,-15 465,150l0 0z"/>
						<path class="fil1" d="M1841 1585c-59,0 -111,-13 -158,-39 -47,-26 -84,-62 -110,-110 -27,-47 -40,-102 -40,-164 0,-62 13,-117 41,-165 27,-47 65,-84 112,-110 48,-26 101,-39 159,-39 59,0 112,13 159,39 48,26 85,63 113,110 27,48 41,103 41,165 0,62 -14,117 -43,164 -28,48 -66,84 -114,110 -47,26 -101,39 -160,39zm0 -133c28,0 54,-7 78,-21 25,-13 44,-34 59,-61 14,-27 22,-60 22,-98 0,-58 -15,-102 -46,-134 -30,-31 -67,-46 -111,-46 -44,0 -81,15 -110,46 -30,32 -45,76 -45,134 0,57 15,102 44,133 29,31 65,47 109,47z"/>
						<path id="1" class="fil1" d="M2316 896c-27,0 -50,-9 -68,-26 -18,-17 -27,-39 -27,-64 0,-26 9,-47 27,-64 18,-18 41,-26 68,-26 27,0 49,8 67,26 18,17 27,38 27,64 0,25 -9,47 -27,64 -18,17 -40,26 -67,26zm75 72l0 607 -153 0 0 -607 153 0z"/>
						<path id="2" class="fil1" d="M2846 959c73,0 131,23 176,69 44,45 67,109 67,191l0 356 -154 0 0 -335c0,-48 -12,-85 -36,-111 -24,-26 -57,-39 -99,-39 -42,0 -76,13 -100,39 -25,26 -37,63 -37,111l0 335 -153 0 0 -607 153 0 0 76c21,-27 47,-47 79,-62 31,-15 66,-23 104,-23z"/>
						<polygon id="3" class="fil1" points="3674,810 3674,934 3355,934 3355,1130 3600,1130 3600,1252 3355,1252 3355,1575 3202,1575 3202,810 "/>
						<path id="4" class="fil1" d="M4323 968l0 607 -154 0 0 -76c-20,26 -46,47 -78,62 -31,15 -66,22 -103,22 -48,0 -90,-10 -126,-30 -37,-20 -66,-50 -86,-89 -21,-39 -32,-86 -32,-140l0 -356 154 0 0 334c0,49 12,86 36,112 24,26 57,39 99,39 42,0 75,-13 100,-39 24,-26 36,-63 36,-112l0 -334 154 0z"/>
						<path id="5" class="fil1" d="M4621 1094l0 294c0,20 5,35 14,44 10,9 27,14 50,14l72 0 0 129 -97 0c-129,0 -194,-62 -194,-188l0 -293 -72 0 0 -126 72 0 0 -150 155 0 0 150 136 0 0 126 -136 0z"/>
						<path id="6" class="fil1" d="M5408 968l0 607 -155 0 0 -76c-19,26 -45,47 -77,62 -32,15 -66,22 -104,22 -47,0 -89,-10 -126,-30 -36,-20 -65,-50 -86,-89 -21,-39 -31,-86 -31,-140l0 -356 153 0 0 334c0,49 13,86 37,112 24,26 57,39 98,39 43,0 76,-13 100,-39 24,-26 36,-63 36,-112l0 -334 155 0z"/>
						<path id="7" class="fil1" d="M5680 1062c20,-32 45,-57 77,-75 32,-19 68,-28 109,-28l0 161 -40 0c-49,0 -85,12 -109,34 -25,23 -37,63 -37,119l0 302 -154 0 0 -607 154 0 0 94z"/>
						<path id="8" class="fil1" d="M5897 1270c0,-62 12,-116 37,-164 24,-47 57,-84 99,-110 43,-25 89,-38 141,-38 46,0 85,9 119,28 34,18 62,41 82,69l0 -87 155 0 0 607 -155 0 0 -88c-20,28 -47,52 -82,70 -34,19 -74,28 -120,28 -51,0 -97,-13 -140,-39 -42,-26 -75,-64 -99,-111 -25,-48 -37,-103 -37,-165zm478 2c0,-38 -7,-70 -22,-96 -14,-27 -34,-47 -59,-62 -25,-14 -52,-21 -80,-21 -29,0 -55,7 -79,21 -24,14 -44,34 -59,61 -15,26 -22,58 -22,95 0,36 7,68 22,95 15,28 35,49 59,63 25,15 51,22 79,22 28,0 55,-7 80,-21 25,-14 45,-35 59,-61 15,-27 22,-59 22,-96z"/>
						</g>
					</g>
				</svg>
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
