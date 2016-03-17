<?php 

/**
 * Woocommerce Image Zoom
 * By WPbean
 */


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


function wpb_aiz_single_image_filter(){
	global $post, $woocommerce, $product;

	if( has_post_thumbnail() ){

		$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
		$image_link  = wp_get_attachment_url( get_post_thumbnail_id() );
		$image       = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
			'title' 			=> $image_title,
			'data-zoom-image' 	=> $image_link,
			'id' 				=> 'wpb_wiz_img_id',
			) );

		$attachment_count = count( $product->get_gallery_attachment_ids() );

		if ( $attachment_count > 0 ) {
			$gallery = '[product-gallery]';
		} else {
			$gallery = '';
		}

		return sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_title, $image );
	
	} else {

		return sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce-image-zoom' ) );

	}
}

add_filter( 'woocommerce_single_product_image_html', 'wpb_aiz_single_image_filter' );