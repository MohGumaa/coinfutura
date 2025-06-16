<?php
/**
 * coinfutura functions and definitions
 *
 * @package coinfutura
 */

if ( ! defined( 'CFU_VERSION' ) ) {

	define( 'CFU_VERSION', '0.1.0' );
}

if ( ! defined( 'CFU_TYPOGRAPHY_CLASSES' ) ) {
	define(
		'CFU_TYPOGRAPHY_CLASSES',
		'prose prose-gray dark:prose-invert max-w-none prose-img:rounded-xl prose-a:font-semibold prose-a:no-underline prose-a:text-gray-950 prose-a:dark:text-white prose-a:border-b prose-a:border-cfu prose-a:hover:border-b-2 prose-figcaption:text-center prose-blockquote:bg-white prose-blockquote:dark:bg-white/5 prose-blockquote:rounded-md prose-blockquote:px-3 prose-blockquote:py-0.5 prose-blockquote:not-italic prose-blockquote:shadow-xs prose-blockquote:inset-ring prose-blockquote:inset-ring-gray-950/5 prose-blockquote:dark:inset-ring-white/5 prose-blockquote:border-cfu prose-ul:list-[disclosure-closed]'
	);
}

if ( ! function_exists( 'cfu_setup' ) ) :
	function cfu_setup() {
		load_theme_textdomain( 'coinfutura', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size('cfu-blog-featured', 376, 212, true);

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __( 'Primary Menu', 'coinfutura' ),
				'menu-2' => __( 'Footer Menu', 'coinfutura' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );
		add_editor_style( 'style-editor-extra.css' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Remove support for block templates.
		remove_theme_support( 'block-templates' );
	}
endif;
add_action( 'after_setup_theme', 'cfu_setup' );

/**
 * Register widget area.
 *
 */
function cfu_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'coinfutura' ),
			'id'            => 'right-sidebar',
			'description'   => __( 'Add widgets here to appear in your Sidebar.', 'coinfutura' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s cfu_sidebar-widget min-h-[250px] overflow-hidden rounded-lg bg-white dark:bg-white/5 inset-ring inset-ring-gray-950/5 dark:inset-ring-white/5 shadow-xs">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title cfu-widget-title cfu-widget-title-underline text-lg font-semibold capitalize py-2.5 px-3 mb-0">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Home Sidebar', 'coinfutura' ),
			'id'            => 'home-sidebar',
			'description'   => __( 'Add widgets here to appear in your home sidebar.', 'coinfutura' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s cfu_sidebar-widget cfu_sidebar-home min-h-[250px] lg:min-h-[316px] xl:min-h-[342px] 2xl:min-h-[376px] overflow-hidden rounded-lg bg-white dark:bg-white/5 inset-ring inset-ring-gray-950/5 dark:inset-ring-white/5 shadow-xs">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title cfu-widget-title cfu-widget-title-underline text-sm font-bold uppercase py-2.5 px-3 mb-0">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Banner - 728x90', 'coinfutura' ),
			'id'            => 'cfu-banner-728',
			'description'   => __( 'Add widgets banner here.', 'coinfutura' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s cfu_sidebar-widget cfu-banner min-h-12 md:min-h-[100px] overflow-hidden rounded-lg bg-white dark:bg-white/5">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title cfu-widget-title cfu-widget-title-underline text-sm font-bold uppercase py-2.5 px-3 mb-0">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer', 'coinfutura' ),
			'id'            => 'cfu-footer',
			'description'   => __( 'Add widgets here to appear in your footer.', 'coinfutura' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s border-x border-gray-950/5 py-10 pl-2 not-xl:border-y not-xl:first:border-t-0 not-xl:nth-2:border-t-0 max-sm:nth-2:border-t not-xl:nth-3:border-b-0 max-sm:nth-3:border-b not-xl:last:border-b-0 dark:border-white/10">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title cfu-widget-title-underline cfu-widget-title font-semibold text-lg capitalize mb-4">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'cfu_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function cfu_scripts() {
	wp_enqueue_style( 'coinfutura-style', get_stylesheet_uri(), array(), CFU_VERSION );
	wp_enqueue_script( 'coinfutura-script', get_template_directory_uri() . '/js/script.min.js', array(), CFU_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cfu_scripts' );

/**
 * Enqueue the block editor script.
 */
function cfu_enqueue_block_editor_script() {
	if ( is_admin() ) {
		wp_enqueue_script(
			'coinfutura-editor',
			get_template_directory_uri() . '/js/block-editor.min.js',
			array(
				'wp-blocks',
				'wp-edit-post',
			),
			CFU_VERSION,
			true
		);
		wp_add_inline_script( 'coinfutura-editor', "tailwindTypographyClasses = '" . esc_attr( CFU_TYPOGRAPHY_CLASSES ) . "'.split(' ');", 'before' );
	}
}
add_action( 'enqueue_block_assets', 'cfu_enqueue_block_editor_script' );

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function cfu_tinymce_add_class( $settings ) {
	$settings['body_class'] = CFU_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'cfu_tinymce_add_class' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/live-search.php';
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Functions which disabled block-edito WordPress.
 */
function cfu_theme_support() {
	remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'cfu_theme_support' );


/**
 * Customize content for the feed by limiting length to 70%, adding the post thumbnail, and including a URL at the end.
 *
 * @param string $content The complete post content.
 * @return string The customized content.
 */
function cfu_rss_feed_update($content) {
	global $post;

	// Check if the post has a featured image and append it to the content
	if (has_post_thumbnail($post->ID)) {
		$content = get_the_post_thumbnail($post->ID) . get_the_content();
	} else {
		$content = get_the_content();
	}

	// Check if the post belongs to the 'Press Releases' category
	if (has_category('press-release', $post->ID)) {
		$disclaimer = '<p><em><strong>Disclaimer</strong>: Any information written in this press release does not constitute investment advice. 
		Coin Futura does not, and will not endorse any information about any company or individual on this page. 
		Readers are encouraged to do their own research and base any actions on their own findings, not on any content written in this press release. 
		Coin Futura is and will not be responsible for any damage or loss caused directly or indirectly by the use of any content, product, or service mentioned in this press release. 
		For more details, visit our <a href="https://coinfutura.com/disclaimer/" target="_blank">disclaimer page</a>.</em></p>';
		
		// Append the disclaimer to the content
		$content .= $disclaimer;
	}

	// Add website name with link and read more text
	$post_url = get_permalink($post->ID);
	$post_title = get_the_title($post->ID);
	$site_link = sprintf('<p>The post <a href="%s" target="_blank">%s</a> appears on <a href="https://coinfutura.com" target="_blank">Coin Futura</a>. Visit our website to read more interesting articles about cryptocurrency, blockchain technology, and digital assets.</p>', 
		esc_url($post_url),
		esc_html($post_title)
	);
	$content .= $site_link;

	return $content;
}

// Apply the function to RSS feed excerpts and content
add_filter('the_excerpt_rss', 'cfu_rss_feed_update');
add_filter('the_content_feed', 'cfu_rss_feed_update');