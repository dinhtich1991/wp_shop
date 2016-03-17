<?php

/*-------Woocommerce modifications----------*/

/* Contents:
	1. Hide WC Vendors "Sold by"
	2. Add extra fields to vendors settings
	3. Related products by vendors
	4. Add media Upload script for WC Vendors
 */

if ( class_exists('WCV_Vendors') ) {

	// ----- 1. Hide WC Vendors "Sold by"
	function template_loop_sold_by($product_id) {
		$vendor_id     = WCV_Vendors::get_vendor_from_product( $product_id );
		$sold_by = WCV_Vendors::is_vendor( $vendor_id )
			? sprintf( '<a href="%s">%s</a>', WCV_Vendors::get_vendor_shop_page( $vendor_id ), WCV_Vendors::get_vendor_sold_by( $vendor_id ) )
			: get_bloginfo( 'name' );
		echo '<small class="plumtree_sold_by_in_loop">' . apply_filters('plumtree_sold_by_in_loop', __( 'Sold by:<br/>', 'plumtree' )). $sold_by . '</small>';
	}

	remove_action( 'woocommerce_after_shop_loop_item', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9 );

	// Uncomment the line below to show sold by message.
	//add_action( 'woocommerce_after_shop_loop_item_title', 'template_loop_sold_by', 15 );


	// ----- 2. Add extra fields to vendors settings
	// back-end
	add_action( 'wcvendors_settings_before_paypal', 'add_backend_fields' );
	function add_backend_fields() {
	?>
	  <tr>
	    <th><?php _e( 'Upload Logo Image', 'plumtree' ); ?></th>
	    <td>
	    <?php $user_id = get_current_user_id(); ?>		
	    	<input name="pv_logo_image" id="pv_logo_image" type="text" value="<?php echo get_user_meta( $user_id, 'pv_logo_image', true ); ?>" />
			<span id="pv_logo_image_button" class="button upload_image_button"><?php _e( 'Upload', 'plumtree' ); ?></span>
		</td>
	  </tr>

	  <tr>
	    <th><?php _e( 'Logo Position', 'plumtree' ); ?></th>
	    <td>
	    <?php $value = get_user_meta( $user_id,'pv_logo_position', true );
	    	  if ( $value == '' ) $value = 'left'; ?>	
	    	<p>
		    	<input type="radio" class="input-radio" name="pv_logo_position" id="logo_position_left" value="left" <?php checked( $value, 'left'); ?>/><label for="logo_position_left"><?php _e( ' Left', 'plumtree' ); ?></label><br />
			    <input type="radio" class="input-radio" name="pv_logo_position" id="logo_position_center" value="center" <?php checked( $value, 'center'); ?>/><label for="logo_position_center"><?php _e( ' Center', 'plumtree' ); ?></label><br />
			    <input type="radio" class="input-radio" name="pv_logo_position" id="logo_position_right" value="right" <?php checked( $value, 'right'); ?>/><label for="logo_position_right"><?php _e( ' Right', 'plumtree' ); ?></label>
			</p>
		</td>
	  </tr>

	  <tr>
	    <th><?php _e( 'Products Carousel', 'plumtree' ); ?></th>
	    <td>
	    <?php $value = get_user_meta( $user_id,'pv_featured_carousel', true ); ?>	
	    	<p>
	    		<input type="checkbox" name="pv_featured_carousel" id="pv_featured_carousel" <?php checked( (bool) $value ); ?> /><label for="pv_featured_carousel"><?php _e( 'Check if you want to add carousel with featured products to your shop page', 'plumtree' ) ?></label>
			</p>
		</td>
	  </tr>

	<?php
	}

	// front-end
	add_action( 'wcvendors_settings_before_paypal_frontend', 'add_frontend_fields' );
	function add_frontend_fields() {
	?>
	  <div class="pv_logo_image_container">
	    <p><strong><?php _e( 'Upload Logo Image', 'plumtree' ); ?></strong><br/><br/>
		    <?php $user_id = get_current_user_id(); ?>		
		    <input name="pv_logo_image" id="pv_logo_image" type="text" value="<?php echo get_user_meta( $user_id, 'pv_logo_image', true ); ?>" />
			<span id="pv_logo_image_button" class="button upload_image_button"><?php _e( 'Upload', 'plumtree' ); ?></span>
		</p>
	  </div>

	  <div class="pv_logo_position_container">
	    <p><strong><?php _e( 'Logo Position', 'plumtree' ); ?></strong></p>
	    <?php $value = get_user_meta( $user_id,'pv_logo_position', true );
	    	  if ( $value == '' ) $value = 'left'; ?>	
	    <p>
		    <input type="radio" class="input-radio" name="pv_logo_position" id="logo_position_left" value="left" <?php checked( $value, 'left'); ?>/><label for="logo_position_left"><?php _e( ' Left', 'plumtree' ); ?></label><br />
			<input type="radio" class="input-radio" name="pv_logo_position" id="logo_position_center" value="center" <?php checked( $value, 'center'); ?>/><label for="logo_position_center"><?php _e( ' Center', 'plumtree' ); ?></label><br />
			<input type="radio" class="input-radio" name="pv_logo_position" id="logo_position_right" value="right" <?php checked( $value, 'right'); ?>/><label for="logo_position_right"><?php _e( ' Right', 'plumtree' ); ?></label>
		</p>
	  </div>

	  <div class="pv_featured_carousel_container">
	    <p><strong><?php _e( 'Products Carousel', 'plumtree' ); ?></strong></p>
	    <?php $value = get_user_meta( $user_id,'pv_featured_carousel', true ); ?>	
	    <p>
	    	<input type="checkbox" class="input-checkbox" name="pv_featured_carousel" id="pv_featured_carousel" <?php checked( (bool) $value ); ?> /><label class="checkbox" for="pv_featured_carousel"><?php _e( 'Check if you want to add carousel with featured products to your shop page', 'plumtree' ) ?></label>
		</p>
	  </div>
	<?php
	}

	// Save data from new fields
	add_action( 'wcvendors_shop_settings_saved', 'save_new_fields' );
	add_action( 'wcvendors_shop_settings_admin_saved', 'save_new_fields' );
	function save_new_fields($vendor_id)
	{
	  if ( isset( $_POST['pv_logo_image'] ) ) {
	    update_user_meta( $vendor_id, 'pv_logo_image', $_POST['pv_logo_image'] );
	  }
	  if ( isset( $_POST['pv_logo_position'] ) ) {
	    update_user_meta( $vendor_id, 'pv_logo_position', $_POST['pv_logo_position'] );
	  }
	  if ( isset( $_POST['pv_featured_carousel'] ) ) {
	    update_user_meta( $vendor_id, 'pv_featured_carousel', $_POST['pv_featured_carousel'] );
	  } else {
	  	update_user_meta( $vendor_id, 'pv_featured_carousel', 0 );
	  }
	}


	// ----- 3. Related products by vendors
	if (get_option('show_wcv_related_products')=='on') {
		function output_vendors_related_products() {
			global $product, $woocommerce_loop;
			
			$vendor = get_the_author_meta('ID');
			$posts_per_page = (get_option('wcv_qty') != '') ? get_option('wcv_qty') : '3';
			$sold_by = WCV_Vendors::get_vendor_sold_by( $vendor );

			$args = apply_filters('woocommerce_related_products_args', array(
				'post_type'				=> 'product',
				'ignore_sticky_posts'	=> 1,
				'no_found_rows' 		=> 1,
				'posts_per_page' 		=> $posts_per_page,
				'orderby' 				=> 'name',
				'author' 				=> $vendor,
				'post__not_in'			=> array($product->id)
			) );

			$products = new WP_Query( $args );
			if ( $products->have_posts() ) : ?>

			<div class="wcv-related products">

				<h2><?php echo __( 'More Products by ', 'plumtree' ).$sold_by; ?></h2>

				<?php woocommerce_product_loop_start(); ?>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>

						<?php woocommerce_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>

			</div>

			<?php endif;
			wp_reset_postdata();
		}
		add_action('woocommerce_after_single_product_summary', 'output_vendors_related_products', 15);
	}

	// Disable mini header on single product page
	if (WC_Vendors::$pv_options->get_option( 'shop_headers_enabled' ) ) { 
		remove_action( 'woocommerce_before_single_product', array('WCV_Vendor_Shop', 'vendor_mini_header')); 
	}


	// ----- 4. Add media Upload script for WC Vendors
	function add_media_upload_scripts(){
		$mode = get_user_option( 'media_library_mode', get_current_user_id() ) ? get_user_option( 'media_library_mode', get_current_user_id() ) : 'grid';
        $modes = array( 'grid', 'list' );
        if ( isset( $_GET['mode'] ) && in_array( $_GET['mode'], $modes ) ) {
            $mode = $_GET['mode'];
            update_user_option( get_current_user_id(), 'media_library_mode', $mode );
        }
        if( ! empty ( $_SERVER['PHP_SELF'] ) && 'upload.php' === basename( $_SERVER['PHP_SELF'] ) && 'grid' !== $mode ) {
            wp_enqueue_script( 'media' );
        }
        if ( ! did_action( 'wp_enqueue_media' ) ) wp_enqueue_media();
    	wp_enqueue_script( 'upload_media_script', get_template_directory_uri() .'/js/upload-media.js', array('jquery'), true);
	}
    add_action( 'wp_enqueue_scripts', 'add_media_upload_scripts' );
    add_action( 'admin_enqueue_scripts', 'add_media_upload_scripts' );

} // end of file