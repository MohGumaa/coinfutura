<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package coinfutura
 */

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function cfu_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'cfu_pingback_header' );

/**
 * Changes comment form default fields.
 *
 * @param array $defaults The default comment form arguments.
 *
 * @return array Returns the modified fields.
 */
function cfu_comment_form_defaults( $defaults ) {
	$comment_field = $defaults['comment_field'];

	// Adjust height of comment form.
	$defaults['comment_field'] = preg_replace( '/rows="\d+"/', 'rows="5"', $comment_field );

	return $defaults;
}
add_filter( 'comment_form_defaults', 'cfu_comment_form_defaults' );

/**
 * Filters the default archive titles.
 */
function cfu_get_the_archive_title() {
	if ( is_category() ) {
		$title = __( 'Category Archives: ', 'coinfutura' ) . '<span>' . single_term_title( '', false ) . '</span>';
	} elseif ( is_tag() ) {
		$title = __( 'Tag Archives: ', 'coinfutura' ) . '<span>' . single_term_title( '', false ) . '</span>';
	} elseif ( is_author() ) {
		$title = __( 'Author Archives: ', 'coinfutura' ) . '<span>' . get_the_author_meta( 'display_name' ) . '</span>';
	} elseif ( is_year() ) {
		$title = __( 'Yearly Archives: ', 'coinfutura' ) . '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'coinfutura' ) ) . '</span>';
	} elseif ( is_month() ) {
		$title = __( 'Monthly Archives: ', 'coinfutura' ) . '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'coinfutura' ) ) . '</span>';
	} elseif ( is_day() ) {
		$title = __( 'Daily Archives: ', 'coinfutura' ) . '<span>' . get_the_date() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$cpt   = get_post_type_object( get_queried_object()->name );
		$title = sprintf(
			/* translators: %s: Post type singular name */
			esc_html__( '%s Archives', 'coinfutura' ),
			$cpt->labels->singular_name
		);
	} elseif ( is_tax() ) {
		$tax   = get_taxonomy( get_queried_object()->taxonomy );
		$title = sprintf(
			/* translators: %s: Taxonomy singular name */
			esc_html__( '%s Archives', 'coinfutura' ),
			$tax->labels->singular_name
		);
	} else {
		$title = __( 'Archives:', 'coinfutura' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'cfu_get_the_archive_title' );

/**
 * Determines whether the post thumbnail can be displayed.
 */
function cfu_can_show_post_thumbnail() {
	return apply_filters( 'cfu_can_show_post_thumbnail', ! post_password_required() && ! is_attachment() && has_post_thumbnail() );
}

/**
 * Returns the size for avatars used in the theme.
 */
function cfu_get_avatar_size() {
	return 60;
}

/**
 * Create the continue reading link
 *
 * @param string $more_string The string shown within the more link.
 */
function cfu_continue_reading_link( $more_string ) {

	if ( ! is_admin() ) {
		$continue_reading = sprintf(
			/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s', 'coinfutura' ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="sr-only">"', '"</span>', false )
		);

		$more_string = '<a href="' . esc_url( get_permalink() ) . '">' . $continue_reading . '</a>';
	}

	return $more_string;
}

// Filter the excerpt more link.
add_filter( 'excerpt_more', 'cfu_continue_reading_link' );

// Filter the content more link.
add_filter( 'the_content_more_link', 'cfu_continue_reading_link' );

/**
 * Outputs a comment in the HTML5 format.
 *
 * This function overrides the default WordPress comment output in HTML5
 * format, adding the required class for Tailwind Typography. Based on the
 * `html5_comment()` function from WordPress core.
 *
 * @param WP_Comment $comment Comment to display.
 * @param array      $args    An array of arguments.
 * @param int        $depth   Depth of the current comment.
 */
function cfu_html5_comment( $comment, $args, $depth ) {
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

	$commenter          = wp_get_current_commenter();
	$show_pending_links = ! empty( $commenter['comment_author'] );

	if ( $commenter['comment_author_email'] ) {
		$moderation_note = __( 'Your comment is awaiting moderation.', 'coinfutura' );
	} else {
		$moderation_note = __( 'Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.', 'coinfutura' );
	}
	?>
	<<?php echo esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $comment->has_children ? 'parent' : '', $comment ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
					if ( 0 !== $args['avatar_size'] ) {
						echo get_avatar( $comment, $args['avatar_size'] );
					}
					?>
					<?php
					$comment_author = get_comment_author_link( $comment );

					if ( '0' === $comment->comment_approved && ! $show_pending_links ) {
						$comment_author = get_comment_author( $comment );
					}

					printf(
						/* translators: %s: Comment author link. */
						wp_kses_post( __( '%s <span class="says">says:</span>', 'coinfutura' ) ),
						sprintf( '<b class="fn">%s</b>', wp_kses_post( $comment_author ) )
					);
					?>
				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<?php
					printf(
						'<a href="%s"><time datetime="%s">%s</time></a>',
						esc_url( get_comment_link( $comment, $args ) ),
						esc_attr( get_comment_time( 'c' ) ),
						esc_html(
							sprintf(
							/* translators: 1: Comment date, 2: Comment time. */
								__( '%1$s at %2$s', 'coinfutura' ),
								get_comment_date( '', $comment ),
								get_comment_time()
							)
						)
					);

					edit_comment_link( __( 'Edit', 'coinfutura' ), ' <span class="edit-link">', '</span>' );
					?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' === $comment->comment_approved ) : ?>
				<em class="comment-awaiting-moderation"><?php echo esc_html( $moderation_note ); ?></em>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div <?php cfu_content_class( 'comment-content' ); ?>>
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<?php
			if ( '1' === $comment->comment_approved || $show_pending_links ) {
				comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<div class="reply">',
							'after'     => '</div>',
						)
					)
				);
			}
			?>
		</article><!-- .comment-body -->
	<?php
}

/**
 * Get formatted post time information
 * 
 * @param int $id Post ID
 * @return array Array containing display times and update status
 */
function cfu_post_time($id) {
	$post_time = get_the_time('U', $id);
	$current_time = current_time('timestamp');
	
	// Set display time based on post age
	if ($post_time >= strtotime('-1 day', $current_time)) {
		$published_time_ago = sprintf(
			esc_html__('%s ago', 'coinfutura'),
			human_time_diff($post_time, $current_time)
		);
	} else {
		$published_time_ago = get_the_date('', $id);
	}

	// Get the post published date and time
	$published_time = get_the_time('M j, Y \a\t h:i A', $id);
	$published_date_time = get_the_date('c', $id);

	// Get the post modified date and time
	$modified_time = get_the_modified_time('M j, Y \a\t h:i A', $id);
	$modified_date_time =  get_the_modified_date('c', $id);

	$is_updated = $modified_time !== $published_time;
		
	return [
		$is_updated,
		$modified_time, 
		$published_time, 
		$modified_date_time, 
		$published_time_ago,	
		$published_date_time,	
	];
}

/**
 * Get meta description from SEO or fallback to post content
 * 
 * @param int|null $post_id Post ID. If null, uses current post.
 * @return string Meta description or empty string if not found
 */
if (!function_exists('cfu_get_meta_description')) :
  function cfu_get_meta_description($post_id = null) {
    if (!$post_id) {
      $post_id = get_the_ID();
      if (!$post_id) {
        return '';
      }
    }

    $post = get_post($post_id);
    if (!$post) {
      return '';
    }

    $rank_math_meta_desc = get_post_meta($post_id, 'rank_math_description', true);
    
    if (!empty($rank_math_meta_desc)) {
      return wp_strip_all_tags($rank_math_meta_desc);
    }

    // Fallback to post content if no Rank Math meta description
    $content = $post->post_content;
    
    // Remove shortcodes and HTML
    $content = strip_shortcodes($content);
    $content = wp_strip_all_tags($content);
    
    // Clean up whitespace
    $content = preg_replace('/\s+/', ' ', $content);
    $content = trim($content);
    
    // Get first ~160 characters (roughly 30 words)
    $meta_desc = wp_trim_words($content, 30, '...');
    
    return $meta_desc;
  }
endif;

/**
 * Functions which get primary category
 * 
 */
if (!function_exists('cfu_get_primary_category')) :
	function cfu_get_primary_category($post_id = null, $classes = '') {
		if (!$post_id) {
			$post_id = get_the_ID();
		}

		// Initialize return array
		$category_data = array(
			'category_link' => '',
			'category_display' => ''
		);

		$categories = get_the_category($post_id);
			
		if ($categories) {
			if (class_exists('RankMath')) {
				// Get primary category from Rank Math
				$primary_cat_id = get_post_meta($post_id, 'rank_math_primary_category', true);
					
				if ($primary_cat_id) {
					$term = get_term($primary_cat_id, 'category');
					
					if (!is_wp_error($term)) {
						// Use Rank Math's primary category
						$category_data['category_display'] = $term->name;
						$category_data['category_link'] = get_category_link($term->term_id);
					} else {
						// Fallback to first category if there's an error
						$category_data['category_display'] = $categories[0]->name;
						$category_data['category_link'] = get_category_link($categories[0]->term_id);
					}
				} else {
					// No primary category set in Rank Math, fall back to first category
					$category_data['category_display'] = $categories[0]->name;
					$category_data['category_link'] = get_category_link($categories[0]->term_id);
				}
			} else {
				// Default to the first category if Rank Math isn't active
				$category_data['category_display'] = $categories[0]->name;
				$category_data['category_link'] = get_category_link($categories[0]->term_id);
			}
		}

			return $category_data;
	}
endif;