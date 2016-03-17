<?php
/**
 *  Vendor Main Header - Hooked into archive-product page 
*
 *  THIS FILE WILL LOAD ON VENDORS STORE URLs (such as yourdomain.com/vendors/bobs-store/)
 *
 * @author WCVendors
 * @package WCVendors
 * @version 1.3.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

/* Get Variables */
$logo_src = $vendor->pv_logo_image;
$logo_pos = $vendor->pv_logo_position;
$featured_carousel = $vendor->pv_featured_carousel;

switch ($logo_pos) {
	case 'left':
		$logo_class = ' col-lg-4 col-md-4 col-sm-12';
		$heading_class = ' col-lg-8 col-md-8 col-sm-12';
	break;
	case 'center':
		$logo_class = ' col-lg-12 col-md-12 col-sm-12 center-pos';
		$heading_class = ' col-lg-12 col-md-12 col-sm-12 center-pos';
	break;
	case 'right':
		$logo_class = ' col-md-4 col-lg-4 col-sm-12 col-lg-push-8 col-md-push-8 right-pos';
		$heading_class = ' col-lg-8 col-md-8 col-sm-12 col-lg-pull-4 col-md-pull-4';
	break;
}

if ($logo_src == '') {
	$heading_class = ' col-lg-12 col-md-12 col-sm-12 center-pos';
}

if ( pt_show_layout() == 'layout-one-col' ) {
	$slides = 4;
} else {
	$slides = 3;
}
?>

<div class="vendors-shop-description">

	<div class="row">
		<?php if ( $logo_src && $logo_src!='') : ?>
			<div class="logo-wrap<?php echo esc_attr($logo_class);?>">
				<img src="<?php echo esc_url($logo_src); ?>" alt="<?php echo esc_attr($shop_name); ?>" />
			</div>
		<?php endif; ?>
		<div class="vendors-title-wrap<?php echo esc_attr($heading_class); ?>">
			<h1><?php echo esc_attr($shop_name); ?></h1>
		</div>
	</div>

	<div class="entry-vendor-content"><?php echo $shop_description; ?></div>

	<?php if ($featured_carousel == 'on') : ?>
		<div class="pt-woo-shortcode  with-slider"
			 data-owl="container"
			 data-owl-slides="<?php echo esc_attr($slides); ?>"
			 data-owl-type="woo_shortcode"
			 data-owl-navi="custom"
		>
			<div class="title-wrapper">
				<h3><?php _e('Special Offers', 'plumtree')?></h3>
				<div class="slider-navi">
					<span class="prev"></span>
					<span class="next"></span>
				</div>
			</div>
			<?php echo do_shortcode('[wcv_featured_products vendor="'.$vendor->user_nicename.'"]'); ?>
		</div>
	<?php endif; ?>

</div>
