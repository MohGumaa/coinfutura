<?php
/**
 * The template for rank math
 *
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;

/**
 * Filter if XML sitemap transient cache is enabled.
 *
 * @param boolean $unsigned Enable cache or not, defaults to true
 */
add_filter( 'rank_math/sitemap/enable_caching', '__return_false');
