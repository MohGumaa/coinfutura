<?php
/**
 * Custom for live search functionality
 *
 * @package coinfutura
 */
defined('ABSPATH') || exit;

// Enqueue necessary scripts
function enqueue_live_search_scripts() {
  wp_enqueue_script(
    'live-search',
    get_template_directory_uri() . '/js/live-search.js',
    array('jquery'),
    '1.0',
    true
  );
  
  // Pass ajax_url to script
  wp_localize_script(
    'live-search',
    'liveSearch',
    array(
      'ajaxurl' => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce('live_search_nonce'),
      'searchurl' => home_url('/')
    )
  );
}
add_action('wp_enqueue_scripts', 'enqueue_live_search_scripts');

// Handle the AJAX search request
function handle_live_search() {
  // Verify nonce
  check_ajax_referer('live_search_nonce', 'nonce');
  
  // Get search term
  $search_term = sanitize_text_field($_POST['search_term']);
  
  if (empty($search_term)) {
    wp_send_json_error('Search term is required');
    return;
  }
  
  // Perform search
  $args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    's' => $search_term,
    'posts_per_page' => 5,
    'orderby' => 'relevance',
    'sentence' => true
  );
  
  $search_query = new WP_Query($args);
  $results = array();
  
  if ($search_query->have_posts()) {
    while ($search_query->have_posts()) {
      $search_query->the_post();
      $results[] = array(
        'title' => get_the_title(),
        'url' => get_permalink(),
        'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')
      );
    }
    wp_reset_postdata();
  }
  
  wp_send_json_success($results);
}

// Register AJAX handlers for both logged in and logged out users
add_action('wp_ajax_live_search', 'handle_live_search');
add_action('wp_ajax_nopriv_live_search', 'handle_live_search');