<?php

if ( ! class_exists('PT_Isotope')) {
	class PT_Isotope{
		
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
			
			wp_enqueue_script( 'isotope', get_template_directory_uri() .''.str_replace(str_replace('\\', '/', get_template_directory()), '',str_replace('\\', '/', __DIR__)).'/js/jquery.isotope.min.js', array('jquery'), '2.1.0', true);
			wp_enqueue_script( 'isotope-init', get_template_directory_uri() .''.str_replace(str_replace('\\', '/', get_template_directory()), '',str_replace('\\', '/', __DIR__)).'/js/isotope-init.js', array('jquery'), '1.0', true);
		
		}
	}

	$pt_isotope = PT_Isotope::getInstance();
}
