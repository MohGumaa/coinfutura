<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the `#content` element and all content thereafter.
 *
 * @package coinfutura
 */
defined( 'ABSPATH' ) || exit;
?>
			<?php get_template_part( 'template-parts/layout/footer', 'content' ); ?>
			</div>
		<div class="row-span-full row-start-1 hidden border-x border-x-(--pattern-fg) bg-[image:repeating-linear-gradient(315deg,_var(--pattern-fg)_0,_var(--pattern-fg)_1px,_transparent_0,_transparent_50%)] bg-[size:10px_10px] bg-fixed [--pattern-fg:var(--color-black)]/5 lg:col-start-3 lg:block dark:[--pattern-fg:var(--color-white)]/10"></div>
	</div>
</div>

<?php wp_footer(); ?>
<script src="https://widgets.coingecko.com/gecko-coin-price-marquee-widget.js"></script>

</body>
</html>
