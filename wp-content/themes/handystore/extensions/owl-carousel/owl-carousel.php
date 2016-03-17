<?php
if ( ! class_exists('PT_Owl_Carousel')) {
	class PT_Owl_Carousel{
		
		private static $instance;
		
		private function __construct(){
			$this->init();
		}
		
		static function getInstance(){
		
			if (self::$instance == null) { 
				self::$instance = new self();
			} 
		
			return self::$instance;
		}
		
		private function init(){
			add_action( 'wp_enqueue_scripts', array(&$this, 'print_scripts_styles'));
		}
		
		function print_scripts_styles(){
			
			wp_enqueue_script( 'owl-carousel', get_template_directory_uri() .''.str_replace(str_replace('\\', '/', get_template_directory()), '',str_replace('\\', '/', __DIR__)).'/js/owl.carousel.min.js', array('jquery'), '1.0', true);
			wp_enqueue_script( 'owl-init', get_template_directory_uri() .''.str_replace(str_replace('\\', '/', get_template_directory()), '',str_replace('\\', '/', __DIR__)).'/js/owl-init.js', array('jquery'), '1.0', true);
			wp_enqueue_style( 'owl-style', get_template_directory_uri() .''.str_replace(str_replace('\\', '/', get_template_directory()), '',str_replace('\\', '/', __DIR__)).'/css/owl.carousel.css' );
		
		}
	}

	$pt_owl_carousel = PT_Owl_Carousel::getInstance();
}

