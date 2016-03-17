<?php
/**
 * PlumTree functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 */

/* Set up the content width value based on the theme's design. */
if (!isset( $content_width )) $content_width = 1200;

/* Set up php DIR variable */
if (!defined(__DIR__)) define ('__DIR__', dirname(__FILE__));

/**
 * Adding additional image sizes.
 */

if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'product-extra-gallery-thumb', 140, 140, true );
	add_image_size( 'blog-featured-image-thumb', 870, 450, true );
	add_image_size( 'carousel-medium', 500, 500, true);
	add_image_size( 'carousel-large', 760, 500, true);
	add_image_size( 'pt-portfolio-thumb', 720, 9999);
	add_image_size( 'pt-product-thumbs', 180, 180, true);
	add_image_size( 'pt-recent-posts-thumb', 530, 350, true);
}

if ( ! function_exists( 'plumtree_setup' ) ) :
/**
 * Plumtree setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 */
	function plumtree_setup() {

		// Translation availability
		load_theme_textdomain( 'plumtree', get_template_directory() . '/languages' );

		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );
		
		add_theme_support( "title-tag" );

		add_theme_support( "custom-header");

		// Enable support for Post Thumbnails.
		add_theme_support( 'post-thumbnails' );
		
		set_post_thumbnail_size( 870, 450, true );

		// Nav menus.
		register_nav_menus( array(
			'header-top-nav'   => __( 'Top Menu', 'plumtree' ),
			'primary-nav'      => __( 'Primary Menu (Under Logo)', 'plumtree' ),
		) );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		// Enable support for Post Formats.
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
		) );

		// This theme allows users to set a custom background.
		add_theme_support( 'custom-background', array(
			'default-color' => 'FFFFFF',
		) );

		// Enable woocommerce support
		add_theme_support( 'woocommerce' );

		// Enable layouts support
		$pt_layouts = array(
				array('value' => 'one-col', 'label' => '1 Column (no sidebars)', 'icon' => get_template_directory_uri().'/assets/one-col.png'),
				array('value' => 'two-col-left', 'label' => '2 Columns, sidebar on left', 'icon' => get_template_directory_uri().'/assets/two-col-left.png'),
				array('value' => 'two-col-right', 'label' => '2 Columns, sidebar on right', 'icon' => get_template_directory_uri().'/assets/two-col-right.png'),
		);
		add_theme_support( 'plumtree-layouts', apply_filters('pt_default_layouts', $pt_layouts) ); 

		// Enable fonts support
		$pt_default_fonts = array('Open_Sans', 'Roboto', 'Lato');
		add_theme_support( 'plumtree-fonts', apply_filters('pt_default_fonts', $pt_default_fonts) ); 

	}
endif; // plumtree_setup

add_action( 'after_setup_theme', 'plumtree_setup' );


/**
 * Enqueue scripts and styles for the front end.
 */
function plumtree_scripts() {

	//----Base CSS Styles-----------
	wp_enqueue_style( 'plumtree-basic', get_stylesheet_uri() );
	wp_enqueue_style( 'plumtree-grid-and-effects', get_template_directory_uri().'/css/grid-and-effects.css' );
	wp_enqueue_style( 'plumtree-icon-fonts', get_template_directory_uri() . '/css/icon-fonts.min.css' );

	//----Base JS libraries
	wp_enqueue_script( 'hoverIntent', array('jquery') );
	wp_enqueue_script( 'plumtree-easings', get_template_directory_uri() . '/js/jquery.easing.1.3.min.js', array('jquery'), '1.3', true );	
	wp_enqueue_script( 'plumtree-lazy-load', get_template_directory_uri() . '/js/lazyload.min.js', array('jquery'), '1.9.3', true );
	wp_enqueue_script( 'plumtree-images-loaded', get_template_directory_uri() . '/js/imagesloaded.min.js', array('jquery'), '3.1.8', true );
	wp_enqueue_script( 'plumtree-basic-js', get_template_directory_uri() . '/js/helper.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'plumtree-countdown', get_template_directory_uri() . '/js/jquery.countdown.min.js', array('jquery'), '2.0.2', true );
	wp_enqueue_script( 'plumtree-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), '3.1.1', true);

	//----Comments script-----------
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	//----Products page animation script-----------
	if ( class_exists('Woocommerce') ) {
		if ( is_shop() || is_product_category() ) {
			wp_enqueue_script( 'plumtree-store-js', get_template_directory_uri() . '/js/store-helper.js', array('jquery'), '1.0', true );
		}
	}

}
add_action( 'wp_enqueue_scripts', 'plumtree_scripts' );

/**
 * Plumtree Init Sidebars.
 */
if (!function_exists('plumtree_widgets_init')){
	function plumtree_widgets_init() {
		// Default Sidebars
		register_sidebar( array(
			'name' => __( 'Blog Sidebar', 'plumtree' ),
			'id' => 'sidebar-blog',
			'description' => __( 'Appears on single blog posts and on Blog Page', 'plumtree' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title" itemprop="name">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Header Top Panel Sidebar', 'plumtree' ),
			'id' => 'top-sidebar',
			'description' => __( 'Located at the top of site', 'plumtree' ),
			'before_widget' => '<aside id="%1$s" class="%2$s right-aligned">',
			'after_widget' => '</aside>',
			'before_title' => '<!--',
			'after_title' => '-->',
		) );
		register_sidebar( array(
			'name' => __( 'Header (Logo group) sidebar', 'plumtree' ),
			'id' => 'hgroup-sidebar',
			'description' => __( 'Located to the right from header', 'plumtree' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '',
			'after_title' => '',
		) );
		register_sidebar( array(
			'name' => __( 'Front Page Sidebar', 'plumtree' ),
			'id' => 'sidebar-front',
			'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'plumtree' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title itemprop="name"">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Pages Sidebar', 'plumtree' ),
			'id' => 'sidebar-pages',
			'description' => __( 'Appears on Pages', 'plumtree' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title itemprop="name"">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Shop Page Sidebar', 'plumtree' ),
			'id' => 'sidebar-shop',
			'description' => __( 'Appears on Products page', 'plumtree' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title itemprop="name"">',
			'after_title' => '</h3>',
		) );
		
		register_sidebar( array(
			'name' => __( 'Single Product Page Sidebar', 'plumtree' ),
			'id' => 'sidebar-product',
			'description' => __( 'Appears on Single Products page', 'plumtree' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title itemprop="name"">',
			'after_title' => '</h3>',
		) );
		if ( class_exists('WCV_Vendors') ) {
			register_sidebar( array(
				'name' => __( 'Vendor Shop Page Sidebar', 'plumtree' ),
				'id' => 'sidebar-vendor',
				'description' => __( 'Appears on Vendors Shop Page', 'plumtree' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title itemprop="name"">',
				'after_title' => '</h3>',
			) );
		}
	    // Footer Sidebars
	    register_sidebar( array(
	        'name' => __( 'Footer Sidebar Col#1', 'plumtree' ),
	        'id' => 'footer-sidebar-1',
	        'description' => __( 'Located in the footer of the site', 'plumtree' ),
	        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	        'after_widget' => '</aside>',
	        'before_title' => '<h3 class="widget-title itemprop="name"">',
	        'after_title' => '</h3>',
	    ) );
	    register_sidebar( array(
	        'name' => __( 'Footer Sidebar Col#2', 'plumtree' ),
	        'id' => 'footer-sidebar-2',
	        'description' => __( 'Located in the footer of the site', 'plumtree' ),
	        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	        'after_widget' => '</aside>',
	        'before_title' => '<h3 class="widget-title itemprop="name"">',
	        'after_title' => '</h3>',
	    ) );
	    register_sidebar( array(
	        'name' => __( 'Footer Sidebar Col#3', 'plumtree' ),
	        'id' => 'footer-sidebar-3',
	        'description' => __( 'Located in the footer of the site', 'plumtree' ),
	        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	        'after_widget' => '</aside>',
	        'before_title' => '<h3 class="widget-title itemprop="name"">',
	        'after_title' => '</h3>',
	    ) );
	    register_sidebar( array(
	        'name' => __( 'Footer Sidebar Col#4', 'plumtree' ),
	        'id' => 'footer-sidebar-4',
	        'description' => __( 'Located in the footer of the site', 'plumtree' ),
	        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	        'after_widget' => '</aside>',
	        'before_title' => '<h3 class="widget-title itemprop="name"">',
	        'after_title' => '</h3>',
	    ) );
	    // Custom Sidebars
	    register_sidebar( array(
	        'name' => __( 'Top Footer Sidebar', 'plumtree' ),
	        'id' => 'top-footer-sidebar',
	        'description' => __( 'Located in the footer of the site', 'plumtree' ),
	        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	        'after_widget' => '</aside>',
	        'before_title' => '<h3 class="widget-title itemprop="name"">',
	        'after_title' => '</h3>',
	    ) );
	    if ( get_option('filters_sidebar')=='on' ) {		
		// Register sidebar
			register_sidebar( array(
			    'name' => __( 'Special Filters Sidebar', 'plumtree' ),
		        'id' => 'filters-sidebar',
		        'description' => __( 'Located at the top of the products page', 'plumtree' ),
		        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		        'after_widget' => '</aside>',
		        'before_title' => '<h3 class="dropdown-filters-title">',
		        'after_title' => '</h3>',
		    ) );
		}
		if ( get_option('front_page_special_sidebar')=='on' ) {		
		// Register sidebar
			register_sidebar( array(
			    'name' => __( 'Special Front Page Sidebar', 'plumtree' ),
		        'id' => 'front-special-sidebar',
		        'description' => __( 'Located at the bottom of the page (appears only when using Front Page Template)', 'plumtree' ),
		        'before_widget' => '<aside id="%1$s" class="widget %2$s col-xs-12 col-sm-6 col-md-3">',
		        'after_widget' => '</aside>',
		        'before_title' => '<h3 class="widget-title" itemprop="name">',
		        'after_title' => '</h3>',
		    ) );
		}
	}
	add_action( 'widgets_init', 'plumtree_widgets_init' );
}

/**
 * Adding features
 */

// Widgets
require_once('widgets/contacts/class-pt-widget-contacts.php');
require_once('widgets/social-networks/class-pt-widget-socials.php');
require_once('widgets/class-pt-widget-search.php');
require_once('widgets/class-pt-widget-most-viewed-posts.php');
require_once('widgets/class-pt-widget-recent-posts.php');
require_once('widgets/class-pt-widget-categories.php');
require_once('widgets/pay-icons/class-pt-widget-pay-icons.php');
if ( class_exists('Woocommerce') ) {
	require_once('widgets/class-pt-widget-cart.php');
	require_once('widgets/class-pt-widget-shop-filters.php');
}
if ( class_exists('Woocommerce') && class_exists('WCV_Vendors') ) {
	require_once('widgets/class-pt-widget-vendors-products.php');
}

// Required functions
require_once('inc/pt-theme-layouts.php');
require_once('inc/pt-functions.php');
require_once('inc/pt-google-fonts.php');
require_once('inc/pt-lib.php');
require_once('ptpanel/ptpanel.php');
require_once('inc/pt-admin.php');
if ( class_exists('Woocommerce') ) {
	require_once('inc/pt-woo-modification.php');
}
if ( class_exists('WCV_Vendors') ) {
	require_once('inc/pt-vendors-modification.php');
}
require_once('inc/pt-self-install.php');

// Shortcodes
require_once('shortcodes/pt-contacts.php');
require_once('shortcodes/pt-posts.php');

// Additional functions
require_once('extensions/gmaps/gmaps.php');
require_once('extensions/magnific/magnific.php');
require_once('extensions/pagination/pagination.php');
require_once('extensions/owl-carousel/owl-carousel.php');
require_once('extensions/login-register/login-register.php');
require_once('extensions/select2/select2.php');
if ( !is_single() ) {
	require_once('extensions/isotope/isotope.php');
} 
if ( get_option('blog_pagination')=='infinite' ) {
	require_once('extensions/infinite-blog/infinite-blog.php');
} 
if ( get_option('blog_share_buttons')=='on' || get_option('use_pt_shares_for_product')=='on' ) {
	require_once('extensions/share-buttons/pt-share-buttons.php');
}
if ( get_option('site_breadcrumbs')=='on' && get_option('post_breadcrumbs')=='on' ) {
	require_once('extensions/breadcrumbs/breadcrumbs.php');
}
if ( get_option('post_show_related')=='on' ) {
	require_once('extensions/related-posts/related-posts.php');
}
if ( get_option('site_post_likes')=='on' ) {
	require_once('extensions/post-likes/post-like.php');
}
if ( class_exists('Woocommerce') ) {
	if ( get_option('use_pt_images_slider')=='on' ) {
		require_once('inc/pt-product-images.php');
	}
}

/**
 * Adding pagebuilders custom shortcodes
 */
if (class_exists('IG_Pb_Init')) {
    require_once('shortcodes/add_to_contentbuilder.php');
}

/**
 * Add do_shortcode filter.
 */
add_filter('widget_text', 'do_shortcode');

/* Live preview */
if( isset( $_GET['rtl_demo'] ) && $_GET['rtl_demo']=='true' ){ 
	function add_rtl_css() {
		wp_enqueue_style( 'plumtree-rtl', get_template_directory_uri().'/rtl.css' );
	}
	add_action( 'wp_enqueue_scripts', 'add_rtl_css' );
} 

