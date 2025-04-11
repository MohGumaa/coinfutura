<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some functionality here could be replaced by core features.
 *
 * @package coinfutura
 */

if ( ! function_exists( 'cfu_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function cfu_posted_on() {
		$time_string = '<time datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time datetime="%1$s">%2$s</time><time datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		printf(
			'<a href="%1$s" rel="bookmark">%2$s</a>',
			esc_url( get_permalink() ),
			$time_string // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}
endif;

if ( ! function_exists( 'cfu_posted_by' ) ) :
	/**
	 * Prints HTML with meta information about theme author.
	 */
	function cfu_posted_by() {
		printf(
		/* translators: 1: posted by label, only visible to screen readers. 2: author link. 3: post author. */
			'<span class="sr-only">%1$s</span><span class="author vcard"><a class="url fn n" href="%2$s">%3$s</a></span>',
			esc_html__( 'Posted by', 'coinfutura' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
	}
endif;

if ( ! function_exists( 'cfu_comment_count' ) ) :
	/**
	 * Prints HTML with the comment count for the current post.
	 */
	function cfu_comment_count() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			/* translators: %s: Name of current post. Only visible to screen readers. */
			comments_popup_link( sprintf( __( 'Leave a comment<span class="sr-only"> on %s</span>', 'coinfutura' ), get_the_title() ) );
		}
	}
endif;

if ( ! function_exists( 'cfu_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 * This template tag is used in the entry header.
	 */
	function cfu_entry_meta() {

		// Hide author, post date, category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			// Posted by.
			cfu_posted_by();

			// Posted on.
			cfu_posted_on();

			/* translators: used between list items, there is a space after the comma. */
			$categories_list = get_the_category_list( __( ', ', 'coinfutura' ) );
			if ( $categories_list ) {
				printf(
				/* translators: 1: posted in label, only visible to screen readers. 2: list of categories. */
					'<span class="sr-only">%1$s</span>%2$s',
					esc_html__( 'Posted in', 'coinfutura' ),
					$categories_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			}

			/* translators: used between list items, there is a space after the comma. */
			$tags_list = get_the_tag_list( '', __( ', ', 'coinfutura' ) );
			if ( $tags_list ) {
				printf(
				/* translators: 1: tags label, only visible to screen readers. 2: list of tags. */
					'<span class="sr-only">%1$s</span>%2$s',
					esc_html__( 'Tags:', 'coinfutura' ),
					$tags_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			}
		}

		// Comment count.
		if ( ! is_singular() ) {
			cfu_comment_count();
		}

		// Edit post link.
		edit_post_link(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers. */
					__( 'Edit <span class="sr-only">%s</span>', 'coinfutura' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
	}
endif;

if ( ! function_exists( 'cfu_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function cfu_entry_footer() {

		// Hide author, post date, category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			// Posted by.
			// cfu_posted_by();

			// Posted on.
			// cfu_posted_on();

			/* translators: used between list items, there is a space after the comma. */
			// $categories_list = get_the_category_list( __( ', ', 'coinfutura' ) );
			// if ( $categories_list ) {
			// 	printf(
			// 	/* translators: 1: posted in label, only visible to screen readers. 2: list of categories. */
			// 		'<span class="sr-only">%1$s</span>%2$s',
			// 		esc_html__( 'Posted in', 'coinfutura' ),
			// 		$categories_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			// 	);
			// }

			/* translators: used between list items, there is a space after the comma. */
			$tags_list = get_the_tag_list( '', __( ', ', 'coinfutura' ) );
			if ( $tags_list ) {
				printf(
				/* translators: 1: tags label, only visible to screen readers. 2: list of tags. */
					'<span class="sr-only">%1$s</span>%2$s',
					esc_html__( 'Tags:', 'coinfutura' ),
					$tags_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			}
		}

		// Comment count.
		// if ( ! is_singular() ) {
		// 	cfu_comment_count();
		// }

		// Edit post link.
		edit_post_link(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers. */
					__( 'Edit <span class="sr-only">%s</span>', 'coinfutura' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
	}
endif;

if ( ! function_exists( 'cfu_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail, wrapping the post thumbnail in an
	 * anchor element except when viewing a single post.
	 */
	function cfu_post_thumbnail() {
		if ( ! cfu_can_show_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<figure class="rounded overflow-hidden w-full">
				<?php the_post_thumbnail(); ?>
			</figure>

			<?php
		else :
			?>

			<figure>
				<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php the_post_thumbnail(); ?>
				</a>
			</figure>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'cfu_comment_avatar' ) ) :
	/**
	 * Returns the HTML markup to generate a user avatar.
	 *
	 * @param mixed $id_or_email The Gravatar to retrieve. Accepts a user_id, gravatar md5 hash,
	 *                           user email, WP_User object, WP_Post object, or WP_Comment object.
	 */
	function cfu_get_user_avatar_markup( $id_or_email = null ) {

		if ( ! isset( $id_or_email ) ) {
			$id_or_email = get_current_user_id();
		}

		return sprintf( '<div class="vcard">%s</div>', get_avatar( $id_or_email, cfu_get_avatar_size() ) );
	}
endif;

if ( ! function_exists( 'cfu_discussion_avatars_list' ) ) :
	/**
	 * Displays a list of avatars involved in a discussion for a given post.
	 *
	 * @param array $comment_authors Comment authors to list as avatars.
	 */
	function cfu_discussion_avatars_list( $comment_authors ) {
		if ( empty( $comment_authors ) ) {
			return;
		}
		echo '<ol>', "\n";
		foreach ( $comment_authors as $id_or_email ) {
			printf(
				"<li>%s</li>\n",
				cfu_get_user_avatar_markup( $id_or_email ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		}
		echo '</ol>', "\n";
	}
endif;

if ( ! function_exists( 'cfu_the_posts_navigation' ) ) :
	/**
	 * Wraps `the_posts_pagination` for use throughout the theme.
	 */
	function cfu_the_posts_navigation() {
		global $wp_query;

		$total_posts   = $wp_query->found_posts;
		$posts_per_page = intval( get_query_var( 'posts_per_page' ) );
		$current_page  = max( 1, get_query_var( 'paged' ) );
		$start_post    = ( $current_page - 1 ) * $posts_per_page + 1;
		$end_post      = min( $total_posts, $current_page * $posts_per_page );

		echo '<div class="hidden md:block post-range">';
		echo sprintf( '<p class="text-sm text-gray-600 dark:text-gray-400">Showing %d to %d of %d results</p>', $start_post, $end_post, $total_posts );
		echo '</div>';

		
		the_posts_pagination(
			array(
				'mid_size'  => 1,
				'prev_text' => 
					'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="h-5 w-5 inline-block" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
					</svg><span class="hidden md:block">' . __( 'previous', 'coinfutura' ). '</span>' ,
				'next_text' => 
					'<span class="hidden md:block">' . __( 'next', 'coinfutura' ) . '</span>' . 
					'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="h-5 w-5 inline-block" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/>
					</svg>',
			)
		);
	}
endif;

if ( ! function_exists( 'cfu_content_class' ) ) :
	/**
	 * Displays the class names for the post content wrapper.
	 *
	 * This allows us to add Tailwind Typography’s modifier classes throughout
	 * the theme without repeating them in multiple files. (They can be edited
	 * at the top of the `../functions.php` file via the
	 * CFU_TYPOGRAPHY_CLASSES constant.)
	 *
	 * Based on WordPress core’s `body_class` and `get_body_class` functions.
	 *
	 * @param string|string[] $classes Space-separated string or array of class
	 *                                 names to add to the class list.
	 */
	function cfu_content_class( $classes = '' ) {
		$all_classes = array( $classes, CFU_TYPOGRAPHY_CLASSES );

		foreach ( $all_classes as &$class_groups ) {
			if ( ! empty( $class_groups ) ) {
				if ( ! is_array( $class_groups ) ) {
					$class_groups = preg_split( '#\s+#', $class_groups );
				}
			} else {
				// Ensure that we always coerce class to being an array.
				$class_groups = array();
			}
		}

		$combined_classes = array_merge( $all_classes[0], $all_classes[1] );
		$combined_classes = array_map( 'esc_attr', $combined_classes );

		// Separates class names with a single space, preparing them for the
		// post content wrapper.
		echo 'class="' . esc_attr( implode( ' ', $combined_classes ) ) . '"';
	}
endif;
