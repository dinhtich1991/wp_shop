<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
?>
<?php 
// Related products extra class
$new_class = '';
if ( is_product() ) {
	$upsells_qty = (get_option('upsells_qty') != '') ? get_option('upsells_qty') : '2';
	$related_qty = (get_option('related_products_qty') != '') ? get_option('related_products_qty') : '4';
	$new_class = ' related-cols-'.$related_qty.' upsells-cols-'.$upsells_qty;
	if (class_exists('WCV_Vendors')) {
		$wcv_related_qty = (get_option('wcv_qty') != '') ? get_option('wcv_qty') : '4';
		$new_class .= ' wcv-cols-'.$wcv_related_qty;
	}
}
?>
<ul class="products<?php echo esc_attr($new_class); ?>">