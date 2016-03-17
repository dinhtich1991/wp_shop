<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/* WC Vendors page check */
$vendor_shop = null;
if (class_exists('WCV_Vendors')) {
	$vendor_shop = urldecode( get_query_var( 'vendor_shop' ) );
}

get_header( 'shop' ); ?>

		<?php if ( is_front_page() ) do_action( 'woocommerce_archive_description' ); ?>

		<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' ); ?>

		<?php if ( !is_front_page() && !$vendor_shop ) : ?>

			<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

		<?php endif; ?>

		<?php if ( !is_front_page() && !$vendor_shop ) do_action( 'woocommerce_archive_description' ); ?>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php /* Special Filters Sidebar */
			if ( get_option('filters_sidebar')=='on' && is_active_sidebar( 'filters-sidebar' ) ) : ?>
				<div id="filters-sidebar" class="widget-area">
					<span class="filter-head"><?php _e('Filters:', 'plumtree'); ?></span>
					<?php dynamic_sidebar('filters-sidebar'); ?>
				</div>
			<?php endif; ?>

			<?php // Overriding Product Loop Start for Isotope functionality
			//woocommerce_product_loop_start(); 
			echo '<ul class="products" data-isotope="container" data-isotope-layout="fitrows" data-isotope-elements="product">';
			?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); ?>
