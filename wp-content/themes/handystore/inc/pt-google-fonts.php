<?php
/**
 *  Get Google Fonts
 */

if( !get_option('pt_google_fonts') || get_option('pt_google_fonts')=='' ) {

	$key = "AIzaSyBTzbIWD6HQe7L9ehZwuhADG1tgyKrLzhY";
	$sort= "alpha";
	$google_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=' . $key . '&sort=' . $sort;
	$response = wp_remote_retrieve_body( wp_remote_get($google_api_url, array('sslverify' => false )));
	if( !is_wp_error( $response ) ) {
		$font_list = array();
		$data = json_decode($response, true);
		$items = $data['items'];
		if (is_array($items) || is_object($items)) {
			foreach ($items as $item) {
				$font_option = str_replace(' ', '_', $item['family']);
				$font_name = $item['family'];
			    @$font_list[$font_option] = $font_name;
			}
			unset($item);
		}

		update_option( 'pt_google_fonts' , $font_list );
	}
}

/**
 *  Add used fonts to frontend
 */

function add_fonts_styles($font_string) {

	/* Get default fonts used in theme */
	$default_fonts = get_theme_support( 'plumtree-fonts' );

	$used_fonts = array();
	if (get_option('logo_font') && get_option('logo_font')!='') { $used_fonts[] = get_option('logo_font'); }
	if (get_option('button_font') && get_option('button_font')!='') { $used_fonts[] = get_option('button_font'); }
	if (get_option('main_font') && get_option('main_font')!='') { $used_fonts[] = get_option('main_font'); }
	if (get_option('heading_font') && get_option('heading_font')!='') { $used_fonts[] = get_option('heading_font'); }

	if ( $default_fonts && $default_fonts!='' ) {
		$default_fonts = $default_fonts[0];
		$merged_fonts = array_merge( $default_fonts, $used_fonts );
		$merged_fonts = array_unique($merged_fonts);
	} else {
		$merged_fonts = array_unique($used_fonts);
	}
	
	$font_var = '400,100,100italic,300,300italic,400italic,500,500italic,700,900,700italic,900italic';
	$font_string 	= "";
	foreach ( $merged_fonts as $font ) {
		$font_string .= '|' . $font . ':' . $font_var;
	}
	$font_string = substr($font_string, 1);
	$font_string = str_replace('_' , '+', $font_string );

	if( $font_string != "" ) {
		$http = (!empty($_SERVER['HTTPS'])) ? "https" : "http";
		$url = $http . "://fonts.googleapis.com/css?family=" . $font_string;
		wp_enqueue_style( 'plumtree-fonts-used' , esc_url($url) );
	}
}
add_action( 'wp_enqueue_scripts', 'add_fonts_styles' );
