<?php
/**
 * Template part for displaying post card
 * 
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;
$cfu_post_not_to_repeat = [];

$default_img = get_theme_file_uri( 'assets/images/cfu-banner.jpg' );
$default_icon = get_theme_file_uri( 'assets/images/cfu-icon.webp' );
?>

<!-- SECTION ONE -->
<?php 
	$args = [
		'posts_per_page' => 4,
		'post_type' => 'post',
		'post_status' => 'publish',
		'category_name'  => 'press-release',
		'no_found_rows' => true,
		'post__not_in'   => $cfu_post_not_to_repeat,
	]; 

	$section_one = new WP_Query( $args );

	if ( $section_one->have_posts() ) :
		$section_one_id = get_cat_ID( 'Press Releases' );
		$section_one_link = get_category_link( $section_one_id );
?>
	<section class="section-1 bg-gray-950/5 dark:bg-white/10 p-2 mb-12">
		<div class="isolate overflow-hidden rounded-lg outline outline-gray-950/5 dark:outline-white/10 bg-white dark:bg-gray-950 p-4">
			<div class="flex justify-between items-center gap-1.5 title-with-underline mb-8">
				<h2 class="cfn-section-title">
					<?php echo esc_html_e( 'Press Releases', 'coinfutura' ); ?>
				</h2>
				<a href="<?php echo esc_url( $section_one_link ); ?>" class="cfn-btn-more">
					<?php echo esc_html_e( 'view more', 'coinfutura' ); ?>
					<svg class="h-3.5 self-center" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
						<path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"></path>
					</svg>
				</a>
			</div>
			<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4">
				<?php 
					while ( $section_one->have_posts() ) {
						$section_one->the_post();
						get_template_part( 'template-parts/content/content', 'box' );
						$cfu_post_not_to_repeat[] = get_the_ID();
					}
				?>
			</div>
		</div>
	</section>
<?php endif; wp_reset_postdata(); ?>
