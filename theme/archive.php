<?php
/**
 * The template for displaying archive pages
 *
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
	<main id="main-archive" class="archive-cfn flex-1 container-center w-full pt-9 md:pt-12 pb-24 md:pb-40">
		<?php if ( have_posts() ) :?>
			<h1 class="text-balance max-md:text-2xl page-title mb-5"><?php echo single_term_title('', false); ?></h1>

			<div class="grid grid-cols-1 lg:grid-cols-12 gap-x-6 gap-y-10 mb-12">
				<div class="col-span-full lg:col-span-7">
					<?php 
						$cfu_post_counter  = 0;
						while ( have_posts() ) : the_post(); $cfu_post_counter++;
						if ( $cfu_post_counter === 1 ) :
							get_template_part( 'template-parts/content/content', 'large' );
							echo '</div><div class="col-span-full lg:col-span-5 space-y-4">';
						elseif ( $cfu_post_counter <= 5 ) :
							get_template_part( 'template-parts/content/content' );
						else:
							if ( $cfu_post_counter === 6 ) :
								echo '</div><div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 col-span-full lg:col-span-12 gap-x-6 gap-y-10">';
							endif;
							get_template_part( 'template-parts/content/content', 'card' );
						endif;
						endwhile;
					?>
				</div>
			</div>

			<!-- Pagination -->
			<div class="flexCenter flex-1 md:justify-between my-12 md:my-16">
				<?php cfu_the_posts_navigation(); ?>
			</div>

			<div <?php cfu_content_class( 'entry-content' ); ?>>
				<?php the_archive_description(); ?>
			</div>
		<?php 
			else :
				get_template_part( 'template-parts/content/content', 'none' );
			endif;
		?>
	</main>
<?php
get_footer();
