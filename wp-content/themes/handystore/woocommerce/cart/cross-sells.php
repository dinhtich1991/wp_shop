<?php
/**
 * Cross-sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$crosssells = WC()->cart->get_cross_sells();

if ( sizeof( $crosssells ) == 0 ) return;

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => apply_filters( 'woocommerce_cross_sells_total', $posts_per_page ),
	'orderby'             => $orderby,
	'post__in'            => $crosssells,
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = apply_filters( 'woocommerce_cross_sells_columns', $columns );

/* Adding Slider */
$container_id = uniqid('owl',false);

if ( $products->have_posts() ) : ?>

	<div class="cross-sells" id="<?php echo esc_attr($container_id); ?>">

		<div class="title-wrapper">
			<h2><?php _e( 'You may be interested in&hellip;', 'plumtree' ) ?></h2>
			<div class='slider-navi'><span class='prev'></span><span class='next'></span></div>
		</div>

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>

	<script type="text/javascript">
		(function($) {
			$(document).ready(function() {
				var owl = $("#<?php echo esc_attr($container_id); ?> ul.products");
 
				owl.owlCarousel({
					navigation : false,
					pagination : false,
					autoPlay   : false,
					slideSpeed : 300,
					paginationSpeed : 400,
					singleItem : true,
					transitionStyle : "fade",
				}); 

				// Custom Navigation Events
				$("#<?php echo esc_attr($container_id); ?>").find(".next").click(function(){
					owl.trigger("owl.next");
				})
				$("#<?php echo esc_attr($container_id); ?>").find(".prev").click(function(){
					owl.trigger("owl.prev");
				})

			});
		})(jQuery);
	</script>

<?php endif;

wp_reset_query();
