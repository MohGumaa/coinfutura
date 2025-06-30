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

/**
 * Allow editing the robots.txt & htaccess data.
 *
 * @param bool Can edit the robots & htacess data.
 */

 add_filter( 'rank_math/can_edit_file', '__return_true' );