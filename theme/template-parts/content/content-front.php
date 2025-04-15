<?php
/**
 * Template part for displaying post card
 * 
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;
$cfu_post_not_to_repeat = [];
?>

<!-- SECTION ZERO -->
<?php 
	$args = [
		'posts_per_page' => 9,
		'post_type' => 'post',
		'post_status' => 'publish',
		'category__in' => array(10, 11, 12, 13, 23, 24, 14),
		'no_found_rows' => true,
		'post__not_in'   => $cfu_post_not_to_repeat,
	]; 

	$section_zero = new WP_Query( $args );
	if ( $section_zero->have_posts() ) :
		// Split posts into sections
		$all_posts = $section_zero->posts;
		
		$middle_posts = array_slice($all_posts, 0, 1);
		$left_posts = array_slice($all_posts, 1, 2);
		$right_posts = array_slice($all_posts, 3);
		
?>
	<section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-4 gap-y-10 section-0 isolate overflow-hidden rounded outline outline-gray-950/5 dark:outline-white/5 bg-white dark:bg-white/5 shadow-sm py-4 px-1.5 mx-2 mb-12">
		<div class="col-span-full md:col-span-1 max-lg:order-2 space-y-4">
			<?php 
				foreach ($left_posts as $post) {
					setup_postdata($post); 
					get_template_part( 'template-parts/content/content', 'box' );
					$cfu_post_not_to_repeat[] = get_the_ID();
				}
				wp_reset_postdata(); 
			?>
		</div>
		<div class="col-span-full md:col-span-2">
			<?php 
				foreach ($middle_posts as $post) {
					setup_postdata($post); 
					get_template_part( 'template-parts/content/content', 'large-hero' );
					$cfu_post_not_to_repeat[] = get_the_ID();
				}
				wp_reset_postdata(); 
			?>
		</div>
		<div class="col-span-full md:col-span-1 lg:col-span-3 xl:col-span-1 max-lg:order-3">
			<ul class="divide-y divide-gray-950/5 dark:divide-white/10 border-s border-gray-950/5 dark:border-white/10 ms-1 ps-5"> 
				<?php 
					foreach ($right_posts as $post) {
						setup_postdata($post); 
						get_template_part( 'template-parts/content/content', 'title' );
						$cfu_post_not_to_repeat[] = get_the_ID();
					}
					wp_reset_postdata(); 
				?>
			</ul>
		</div>
	</section>
<?php endif; wp_reset_postdata(); ?>

<!-- SECTION ONE -->
<?php 
	$args = [
		'posts_per_page' => 4,
		'post_type' => 'post',
		'post_status' => 'publish',
		'category_name'  => 'hot-news',
		'no_found_rows' => true,
		'post__not_in'   => $cfu_post_not_to_repeat,
	]; 

	$section_one = new WP_Query( $args );

	if ( $section_one->have_posts() ) :
		$section_one_id = get_cat_ID( 'Hot News' );
		$section_one_link = get_category_link( $section_one_id );
?>
	<section class="section-1 bg-gray-950/5 dark:bg-white/10 p-2 mb-12">
		<div class="isolate overflow-hidden rounded-lg outline outline-gray-950/5 dark:outline-white/10 bg-white dark:bg-gray-950 p-4">
			<div class="flex justify-between items-center gap-1.5 title-with-underline mb-8">
				<h2 class="cfu-section-title">
					<?php echo esc_html_e( 'Hot News', 'coinfutura' ); ?>
				</h2>
				<a href="<?php echo esc_url( $section_one_link ); ?>" class="cfu-btn-more">
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

<!-- SECTION TWO -->
<?php 
	$args = [
		'posts_per_page' => 8,
		'post_type' => 'post',
		'post_status' => 'publish',
		'category_name'  => 'Market',
		'no_found_rows' => true,
		'post__not_in'   => $cfu_post_not_to_repeat,
	]; 

	$section_two = new WP_Query( $args );

	if ( $section_two->have_posts() ) :
		$section_two_id = get_cat_ID( 'Market' );
		$section_two_link = get_category_link( $section_two_id );
		$section_two_count = 0;
?>
	<section class="section-2 isolate overflow-hidden rounded-lg outline outline-gray-950/5 dark:outline-white/5 bg-white dark:bg-white/5 shadow-sm p-4 mx-2 mb-12">
		<div class="flex justify-between items-center gap-1.5 title-with-underline mb-8">
			<h2 class="cfu-section-title">
				<?php echo esc_html_e( 'Market', 'coinfutura' ); ?>
			</h2>
			<a href="<?php echo esc_url( $section_two_link ); ?>" class="cfu-btn-more">
				<?php echo esc_html_e( 'view more', 'coinfutura' ); ?>
				<svg class="h-3.5 self-center" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
					<path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"></path>
				</svg>
			</a>
		</div>
		<div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-x-4 lg:gap-x-6 gap-y-6">
			<?php 
				while ( $section_two->have_posts() ) {
					$section_two->the_post();
					if (++$section_two_count < 3) {
						get_template_part( 'template-parts/content/content', 'large_card' );	
					} else {
						get_template_part( 'template-parts/content/content', 'flexCard' );	
					}
					$cfu_post_not_to_repeat[] = get_the_ID();
				}
			?>
		</div>
	</section>
<?php endif; wp_reset_postdata(); ?>

<!-- SECTION THREE -->
<?php 
	$args = [
		'posts_per_page' => 7,
		'post_type' => 'post',
		'post_status' => 'publish',
		'category_name'  => 'price-analysis',
		'no_found_rows' => true,
		'post__not_in'   => $cfu_post_not_to_repeat,
	]; 

	$section_three = new WP_Query( $args );

	if ( $section_three->have_posts() ) :
		$section_three_id = get_cat_ID( 'Price Analysis' );
		$section_three_link = get_category_link( $section_three_id );
		$section_three_count = 0;
?>
	<section class="section-3 bg-gray-950/5 dark:bg-white/10 p-2 mb-12">
		<div class="isolate overflow-hidden rounded-lg outline outline-gray-950/5 dark:outline-white/10 bg-white dark:bg-gray-950 p-4">
			<div class="flex justify-between items-center gap-1.5 title-with-underline mb-8">
				<h2 class="cfu-section-title">
					<?php echo esc_html_e( 'Price Analysis', 'coinfutura' ); ?>
				</h2>
				<a href="<?php echo esc_url( $section_three_link ); ?>" class="cfu-btn-more">
					<?php echo esc_html_e( 'view more', 'coinfutura' ); ?>
					<svg class="h-3.5 self-center" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
						<path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"></path>
					</svg>
				</a>
			</div>
			<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-x-4 lg:gap-x-6 gap-y-6">
				<?php 
					while ( $section_three->have_posts() ) {
						$section_three->the_post();
						if (++$section_three_count < 4)  {
							get_template_part( 'template-parts/content/content', 'card' );
						} else {
							if ($section_three_count === 4) {
								echo '</div><div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-6 mt-7 md:mt-9">';
							}
							get_template_part( 'template-parts/content/content', 'box_home' );	
						}

						$cfu_post_not_to_repeat[] = get_the_ID();
					}
				?>
			</div>
		</div>
	</section>
<?php endif; wp_reset_postdata(); ?>
