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
		'category_name'  => 'press-release',
		'no_found_rows' => true,
		'post__not_in'   => $cfu_post_not_to_repeat,
	]; 
	$section_one = new WP_Query( $args );

	if ( $section_one->have_posts() ) :
		$section_one_id = get_cat_ID( 'Press Release' );
		$section_one_link = get_category_link( $section_one_id );
?>
	<section class="section-1 bg-gray-950/5 dark:bg-white/10 p-2 mb-12">
		<div class="isolate overflow-hidden rounded-lg outline outline-gray-950/5 dark:outline-white/10 bg-white dark:bg-gray-950 p-4">
			<div class="flex justify-between items-center gap-1.5 title-with-underline mb-8">
				<h2 class="cfu-section-title">
					<?php echo esc_html_e( 'Press Release', 'coinfutura' ); ?>
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
<section class="section-2 isolate overflow-hidden rounded-lg outline outline-gray-950/5 dark:outline-white/5 bg-white dark:bg-white/5 shadow-sm p-4 mx-2 mb-12">
	<div class="grid grid-cols-1 lg:grid-cols-12 gap-x-8 gap-y-10">
		<div class="col-span-full lg:col-span-9">
			<?php 
				$args = [
					'posts_per_page' => 3,
					'post_type' => 'post',
					'post_status' => 'publish',
					'category_name'  => 'Market',
					'no_found_rows' => true,
					'post__not_in'   => $cfu_post_not_to_repeat,
				]; 
				$section_two = new WP_Query( $args );

				if ( $section_two->have_posts() ) :
					$section_two_id = get_cat_ID( 'Hot News' );
					$section_two_link = get_category_link( $section_two_id );
			?>
				<div class="flex justify-between items-center gap-1.5 title-with-underline mb-8">
					<h2 class="cfu-section-title">
						<?php echo esc_html_e( 'Hot News', 'coinfutura' ); ?>
					</h2>
					<a href="<?php echo esc_url( $section_two_link ); ?>" class="cfu-btn-more">
						<?php echo esc_html_e( 'view more', 'coinfutura' ); ?>
						<svg class="h-3.5 self-center" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
							<path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"></path>
						</svg>
					</a>
				</div>
				<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
					<?php 
						while ( $section_two->have_posts() ) {
							$section_two->the_post();
							get_template_part( 'template-parts/content/content', 'box' );
							$cfu_post_not_to_repeat[] = get_the_ID();
						}
					?>
				</div>
			<?php endif; wp_reset_postdata(); ?>
		</div>
		<div class="col-span-full lg:col-span-3 cfu-sidebar flex flex-col">
			<aside class="sticky-sidebar lg:sticky lg:top-16 space-y-6">
				<?php 
					if ( is_active_sidebar( 'home-sidebar' ) ) {
						dynamic_sidebar( 'home-sidebar' );
					}
				?>
			</aside>
		</div>
	</div>
</section>

<!-- SECTION THREE -->
<?php 
	$args = [
		'posts_per_page' => 8,
		'post_type' => 'post',
		'post_status' => 'publish',
		'category_name'  => 'Market',
		'no_found_rows' => true,
		'post__not_in'   => $cfu_post_not_to_repeat,
	]; 

	$section_three = new WP_Query( $args );

	if ( $section_three->have_posts() ) :
		$section_three_id = get_cat_ID( 'Market' );
		$section_three_link = get_category_link( $section_three_id );
		$section_three_count = 0;
?>
	<section class="section-3 bg-gray-950/5 dark:bg-white/10 p-2 mb-12">
		<div class="isolate overflow-hidden rounded-lg outline outline-gray-950/5 dark:outline-white/10 bg-white dark:bg-gray-950 p-4">
			<div class="flex justify-between items-center gap-1.5 title-with-underline mb-8">
				<h2 class="cfu-section-title">
					<?php echo esc_html_e( 'Market', 'coinfutura' ); ?>
				</h2>
				<a href="<?php echo esc_url( $section_three_link ); ?>" class="cfu-btn-more">
					<?php echo esc_html_e( 'view more', 'coinfutura' ); ?>
					<svg class="h-3.5 self-center" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
						<path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"></path>
					</svg>
				</a>
			</div>
			<div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-x-4 lg:gap-x-6 gap-y-6">
				<?php 
					while ( $section_three->have_posts() ) {
						$section_three->the_post();
						if (++$section_three_count < 3) {
							get_template_part( 'template-parts/content/content', 'large_card' );	
						} else {
							get_template_part( 'template-parts/content/content', 'flexCard' );	
						}
						$cfu_post_not_to_repeat[] = get_the_ID();
					}
				?>
			</div>
		</div>
	</section>
<?php endif; wp_reset_postdata(); ?>

<!-- SECTION FOUR -->
<?php 
	$args = [
		'posts_per_page' => 7,
		'post_type' => 'post',
		'post_status' => 'publish',
		'category_name'  => 'price-analysis',
		'no_found_rows' => true,
		'post__not_in'   => $cfu_post_not_to_repeat,
	]; 

	$section_four = new WP_Query( $args );

	if ( $section_four->have_posts() ) :
		$section_four_id = get_cat_ID( 'Price Analysis' );
		$section_four_link = get_category_link( $section_four_id );
		$section_four_count = 0;
?>
	<section class="section-4 isolate overflow-hidden rounded-lg outline outline-gray-950/5 dark:outline-white/5 bg-white dark:bg-white/5 shadow-sm p-4 mx-2 mb-12">
		<div class="flex justify-between items-center gap-1.5 title-with-underline mb-8">
			<h2 class="cfu-section-title">
				<?php echo esc_html_e( 'Price Analysis', 'coinfutura' ); ?>
			</h2>
			<a href="<?php echo esc_url( $section_four_link ); ?>" class="cfu-btn-more">
				<?php echo esc_html_e( 'view more', 'coinfutura' ); ?>
				<svg class="h-3.5 self-center" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
					<path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"></path>
				</svg>
			</a>
		</div>
		<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-x-4 lg:gap-x-6 gap-y-6">
			<?php 
				while ( $section_four->have_posts() ) {
					$section_four->the_post();
					if (++$section_four_count < 4)  {
						get_template_part( 'template-parts/content/content', 'card' );
					} else {
						if ($section_four_count === 4) {
							echo '</div><div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-6 mt-7 md:mt-9">';
						}
						get_template_part( 'template-parts/content/content', 'box_home' );	
					}

					$cfu_post_not_to_repeat[] = get_the_ID();
				}
			?>
		</div>
	</section>
<?php endif; wp_reset_postdata(); ?>

<!-- SECTION FIVE -->
<section class="section-4 bg-gray-950/5 dark:bg-white/10 p-2">
	<div class="flex flex-col min-md:flex-row min-md:items-center gap-x-4 gap-y-5 isolate overflow-hidden rounded-lg outline outline-gray-950/5 dark:outline-white/10 bg-white dark:bg-gray-950 p-4 min-sm:py-5 min-sm:px-6">
		<div class="flex items-center flex-1 gap-x-4">
			<svg class="w-12 h-12 min-lg:w-16 min-lg:h-16" width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
				<g clip-path="url(#clip0_48_2)">
				<path d="M60 30C60 13.4315 46.5685 0 30 0C13.4315 0 0 13.4315 0 30C0 46.5685 13.4315 60 30 60C46.5685 60 60 46.5685 60 30Z" fill="#20BAB8" fill-opacity="0.1"/>
				<mask id="mask0_48_2" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="14" y="14" width="32" height="32">
				<path d="M46 14H14V46H46V14Z" fill="white"/>
				</mask>
				<g mask="url(#mask0_48_2)">
				<path d="M41 19H19C18.4696 19 17.9609 19.2107 17.5858 19.5858C17.2107 19.9609 17 20.4696 17 21V41C17.0001 41.1704 17.0437 41.338 17.1268 41.4869C17.2099 41.6357 17.3296 41.7608 17.4746 41.8503C17.6197 41.9399 17.7852 41.9909 17.9554 41.9985C18.1257 42.0061 18.2951 41.97 18.4475 41.8938L22 40.1175L25.5525 41.8938C25.6914 41.9633 25.8446 41.9995 26 41.9995C26.1554 41.9995 26.3086 41.9633 26.4475 41.8938L30 40.1175L33.5525 41.8938C33.6914 41.9633 33.8446 41.9995 34 41.9995C34.1554 41.9995 34.3086 41.9633 34.4475 41.8938L38 40.1175L41.5525 41.8938C41.7049 41.97 41.8743 42.0061 42.0446 41.9985C42.2148 41.9909 42.3803 41.9399 42.5254 41.8503C42.6704 41.7608 42.7901 41.6357 42.8732 41.4869C42.9563 41.338 42.9999 41.1704 43 41V21C43 20.4696 42.7893 19.9609 42.4142 19.5858C42.0391 19.2107 41.5304 19 41 19ZM41 39.3825L38.4475 38.105C38.3086 38.0355 38.1554 37.9993 38 37.9993C37.8446 37.9993 37.6914 38.0355 37.5525 38.105L34 39.8825L30.4475 38.105C30.3086 38.0355 30.1554 37.9993 30 37.9993C29.8446 37.9993 29.6914 38.0355 29.5525 38.105L26 39.8825L22.4475 38.105C22.3086 38.0355 22.1554 37.9993 22 37.9993C21.8446 37.9993 21.6914 38.0355 21.5525 38.105L19 39.3825V21H41V39.3825Z" fill="#20BAB8"/>
				<path d="M22.2929 27.2929C22.1054 27.4804 22 27.7348 22 28C22 28.2652 22.1054 28.5196 22.2929 28.7071C22.4804 28.8946 22.7348 29 23 29H29C29.2652 29 29.5196 28.8946 29.7071 28.7071C29.8946 28.5196 30 28.2652 30 28C30 27.7348 29.8946 27.4804 29.7071 27.2929C29.5196 27.1054 29.2652 27 29 27H23C22.7348 27 22.4804 27.1054 22.2929 27.2929Z" fill="#20BAB8"/>
				<path d="M22.2929 31.2929C22.1054 31.4804 22 31.7348 22 32C22 32.2652 22.1054 32.5196 22.2929 32.7071C22.4804 32.8946 22.7348 33 23 33H29C29.2652 33 29.5196 32.8946 29.7071 32.7071C29.8946 32.5196 30 32.2652 30 32C30 31.7348 29.8946 31.4804 29.7071 31.2929C29.5196 31.1054 29.2652 31 29 31H23C22.7348 31 22.4804 31.1054 22.2929 31.2929Z" fill="#20BAB8"/>
				<path d="M31.1016 21.7465C31.1025 20.7996 31.4791 19.8912 32.1487 19.2217C32.8182 18.5522 33.726 18.1756 34.6729 18.1746H37.2047C37.4657 18.1569 40.5141 17.8983 43.4211 15.4603C43.6432 15.2739 43.9138 15.1547 44.2012 15.1167C44.4888 15.0786 44.7812 15.1235 45.0442 15.2459C45.3071 15.3683 45.5297 15.5633 45.6857 15.8078C45.8417 16.0523 45.9247 16.3363 45.9249 16.6263V26.8662C45.9248 27.1563 45.842 27.4405 45.686 27.6851C45.5301 27.9298 45.3076 28.1249 45.0446 28.2474C44.7816 28.3699 44.4891 28.4149 44.2015 28.3769C43.9139 28.3389 43.6432 28.2197 43.4211 28.0332C41.4624 26.3903 39.44 25.7367 38.2453 25.4796V26.9084C38.2453 26.9083 38.2453 26.9086 38.2453 26.9084L37.7453 26.9091C37.7455 27.0778 37.704 27.244 37.6245 27.3928C37.545 27.5416 37.43 27.6685 37.2896 27.7621L31.1016 21.7465ZM31.1016 21.7465C31.1017 22.6132 31.4166 23.4503 31.9877 24.1023C32.4834 24.6682 33.1428 25.0611 33.8701 25.2297L34.5417 27.7606L31.1016 21.7465ZM36.2213 26.1933L35.989 25.3183H36.2213V26.1933ZM38.2453 20.0796C39.4572 19.8694 41.6459 19.2813 43.9009 17.6501V25.8395C41.6442 24.21 39.4555 23.6229 38.2453 23.4115V20.0796ZM36.2213 20.1985V23.2943H34.6734C34.2629 23.2943 33.8692 23.1313 33.5789 22.841C33.2886 22.5507 33.1255 22.157 33.1255 21.7464C33.1255 21.3359 33.2886 20.9422 33.5789 20.6519C33.8692 20.3616 34.2629 20.1985 34.6734 20.1985H36.2213Z" fill="black"/>
				<path d="M31.1016 21.7465C31.1025 20.7996 31.4791 19.8912 32.1487 19.2217C32.8182 18.5522 33.726 18.1756 34.6729 18.1746H37.2047C37.4657 18.1569 40.5141 17.8983 43.4211 15.4603C43.6432 15.2739 43.9138 15.1547 44.2012 15.1167C44.4888 15.0786 44.7812 15.1235 45.0442 15.2459C45.3071 15.3683 45.5297 15.5633 45.6857 15.8078C45.8417 16.0523 45.9247 16.3363 45.9249 16.6263V26.8662C45.9248 27.1563 45.842 27.4405 45.686 27.6851C45.5301 27.9298 45.3076 28.1249 45.0446 28.2474C44.7816 28.3699 44.4891 28.4149 44.2015 28.3769C43.9139 28.3389 43.6432 28.2197 43.4211 28.0332C41.4624 26.3903 39.44 25.7367 38.2453 25.4796V26.9084M31.1016 21.7465L37.2896 27.7621C37.43 27.6685 37.545 27.5416 37.6245 27.3928C37.704 27.244 37.7455 27.0778 37.7453 26.9091L38.2453 26.9084M31.1016 21.7465C31.1017 22.6132 31.4166 23.4503 31.9877 24.1023C32.4834 24.6682 33.1428 25.0611 33.8701 25.2297L34.5417 27.7606L31.1016 21.7465ZM38.2453 26.9084C38.2453 26.9086 38.2453 26.9083 38.2453 26.9084ZM36.2213 26.1933L35.989 25.3183H36.2213V26.1933ZM38.2453 20.0796C39.4572 19.8694 41.6459 19.2813 43.9009 17.6501V25.8395C41.6442 24.21 39.4555 23.6229 38.2453 23.4115V20.0796ZM36.2213 20.1985V23.2943H34.6734C34.2629 23.2943 33.8692 23.1313 33.5789 22.841C33.2886 22.5507 33.1255 22.157 33.1255 21.7464C33.1255 21.3359 33.2886 20.9422 33.5789 20.6519C33.8692 20.3616 34.2629 20.1985 34.6734 20.1985H36.2213Z" stroke="#F5EDFF"/>
				<path d="M44.4 18.8008H38V25.2008H44.4V18.8008Z" fill="#F5EDFF"/>
				<path d="M31.4517 21.7465C31.4526 20.8923 31.7923 20.0732 32.3963 19.4692C33.0002 18.8652 33.8192 18.5255 34.6734 18.5246H37.2161C37.4303 18.5114 40.6134 18.2719 43.646 15.7285C43.8171 15.5848 44.0257 15.4929 44.2472 15.4636C44.4687 15.4344 44.694 15.4689 44.8965 15.5632C45.0991 15.6575 45.2705 15.8077 45.3907 15.996C45.5109 16.1844 45.5748 16.4031 45.575 16.6266V26.8662C45.575 27.0897 45.5111 27.3085 45.391 27.497C45.2709 27.6855 45.0994 27.8358 44.8969 27.9301C44.6943 28.0245 44.469 28.0591 44.2474 28.0299C44.0258 28.0006 43.8172 27.9087 43.646 27.765C41.3793 25.8638 39.0294 25.2499 37.8954 25.0553V26.9089L37.7454 26.9091C37.7456 27.0778 37.7041 27.244 37.6246 27.3928C37.5451 27.5416 37.4301 27.6685 37.2897 27.7621L31.4517 21.7465ZM31.4517 21.7465C31.4518 22.5283 31.7359 23.2835 32.2511 23.8716C32.744 24.4344 33.4165 24.8076 34.1526 24.929L31.4517 21.7465ZM36.1102 27.1386L35.5341 24.9683H36.5714V26.8313L36.1102 27.1386ZM37.8954 19.7808C39.0641 19.6129 41.6635 19.0174 44.251 16.9436V26.5452C41.6616 24.4741 39.0625 23.8797 37.8954 23.7098V19.7808ZM36.5714 19.8485V23.6443H34.6735C34.1702 23.6443 33.6874 23.4444 33.3315 23.0885C32.9756 22.7325 32.7756 22.2498 32.7756 21.7464C32.7756 21.2431 32.9756 20.7603 33.3315 20.4044C33.6874 20.0485 34.1702 19.8485 34.6735 19.8485H36.5714Z" fill="#20BAB8"/>
				<path d="M31.4517 21.7465C31.4526 20.8923 31.7923 20.0732 32.3963 19.4692C33.0002 18.8652 33.8192 18.5255 34.6734 18.5246H37.2161C37.4303 18.5114 40.6134 18.2719 43.646 15.7285C43.8171 15.5848 44.0257 15.4929 44.2472 15.4636C44.4687 15.4344 44.694 15.4689 44.8965 15.5632C45.0991 15.6575 45.2705 15.8077 45.3907 15.996C45.5109 16.1844 45.5748 16.4031 45.575 16.6266V26.8662C45.575 27.0897 45.5111 27.3085 45.391 27.497C45.2709 27.6855 45.0994 27.8358 44.8969 27.9301C44.6943 28.0245 44.469 28.0591 44.2474 28.0299C44.0258 28.0006 43.8172 27.9087 43.646 27.765C41.3793 25.8638 39.0294 25.2499 37.8954 25.0553V26.9089L37.7454 26.9091C37.7456 27.0778 37.7041 27.244 37.6246 27.3928C37.5451 27.5416 37.4301 27.6685 37.2897 27.7621L31.4517 21.7465ZM31.4517 21.7465C31.4518 22.5283 31.7359 23.2835 32.2511 23.8716C32.744 24.4344 33.4165 24.8076 34.1526 24.929L31.4517 21.7465ZM36.1102 27.1386L35.5341 24.9683H36.5714V26.8313L36.1102 27.1386ZM37.8954 19.7808C39.0641 19.6129 41.6635 19.0174 44.251 16.9436V26.5452C41.6616 24.4741 39.0625 23.8797 37.8954 23.7098V19.7808ZM36.5714 19.8485V23.6443H34.6735C34.1702 23.6443 33.6874 23.4444 33.3315 23.0885C32.9756 22.7325 32.7756 22.2498 32.7756 21.7464C32.7756 21.2431 32.9756 20.7603 33.3315 20.4044C33.6874 20.0485 34.1702 19.8485 34.6735 19.8485H36.5714Z" stroke="#20BAB8" stroke-width="0.3"/>
				</g>
				</g>
				<defs>
				<clipPath id="clip0_48_2">
				<rect width="60" height="60" fill="white"/>
				</clipPath>
				</defs>
			</svg>
			<div class="flex-1">
				<h5 class="font-bold min-md:text-lg cfu-title"><?php esc_html_e( 'Submit your', 'coinfutura' ); ?> <span class="sub-title"><?php esc_html_e( 'Press Release', 'coinfutura' ); ?></span></h5>
				<p class="max-md:text-sm"><?php esc_html_e( 'Coinfutura manages crypto news, press releases, sponsored posts, and advertising.', 'coinfutura' ); ?></p>
			</div>
		</div>
		<a href="https://t.me/Vijay4dmcrypto" target="_blank" rel="noreferrer noopener" class="max-md:w-full cfu-btn text-black bg-radial-crypto py-3"><?php esc_html_e( 'View All Benefits', 'coinfutura' ); ?></a>
	</div>
</section>