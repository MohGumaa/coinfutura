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
<header id="masthead" class="sticky inset-x-0 top-0 z-50 bg-white dark:bg-gray-950 border-b border-black/5 dark:border-white/10 backdrop-blur">
	<div class="grid grid-cols-1 grid-rows-[1fr_1px_auto_1px_auto] justify-center [--gutter-width:2.5rem] lg:grid-cols-[var(--gutter-width)_minmax(0,var(--breakpoint-2xl))_var(--gutter-width)] max-md:overflow-x-hidden">
		<div class="col-start-1 row-span-full row-start-1 hidden lg:block"></div>
		<div class="flex h-14 items-center justify-between gap-8">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			<nav id="site-navigation" aria-label="<?php esc_attr_e( 'Main Navigation', 'coinfutura' ); ?>">
				<button aria-controls="primary-menu" aria-expanded="false" class="hidden"><?php esc_html_e( 'Primary Menu', 'coinfutura' ); ?></button>
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
		</div>
		<div class="row-span-full row-start-1 hidden lg:col-start-3 lg:block"></div>
	</div>
</header>
