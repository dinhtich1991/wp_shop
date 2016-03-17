<?php
/**
 * @version    $Id$
 * @package    IG Pagebuilder
 * @author     InnoGearsTeam <support@TI.com>
 * @copyright  Copyright (C) 2012 TI.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.TI.com
 * Technical Support:  Feedback - http://www.TI.com
 */
if ( ! class_exists( 'IG_Item_Carousel' ) ) {

	class IG_Item_Carousel extends IG_Pb_Shortcode_Child {

		public function __construct() {
			parent::__construct();
		}

		/**
		 * DEFINE configuration information of shortcode
		 */
		public function element_config() {
			$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['exception'] = array(
				'data-modal-title' => __( 'Carousel Item',  'plumtree' )
			);
		}

		/**
		 * DEFINE setting options of shortcode
		 */
		public function element_items() {
			$this->items = array(
				'Notab' => array(
					array(
						'name'    => __( 'Image File',  'plumtree' ),
						'id'      => 'image_file',
						'type'    => 'select_media',
						'std'     => '',
						'class'   => 'jsn-input-large-fluid',
						'tooltip' => __( 'Select background image for item',  'plumtree' )
					),
					array(
                        'name'    => __( 'Image Size',  'plumtree' ),
                        'id'      => 'image_size',
                        'type'    => 'select',
                        'std'     => 'medium',
                        'options' => array(
							'thumbnail' => 'Thumbnail',
							'carousel-medium' => 'Medium',
							'carousel-large' => 'Large',
						),
                    ),
					array(
						'name'  => __( 'Heading',  'plumtree' ),
						'id'    => 'heading',
						'type'  => 'text_field',
						'class' => 'jsn-input-xxlarge-fluid',
						'role'  => 'title',
                        'tooltip' => __( 'Enter heading text for item',  'plumtree' ),
					),
					array(
						'name'  => __( 'Short Description',  'plumtree' ),
						'id'    => 'description',
						'type'  => 'text_field',
						'class' => 'jsn-input-xxlarge-fluid',
                        'tooltip' => __( 'Enter description text for item',  'plumtree' ),
					),
					array(
						'name'       => __( 'URL for detailed view', 'plumtree' ),
						'id'         => 'url',
						'type'       => 'text_field',
						'class'      => 'input-sm',
						'std'        => 'http://',
						'tooltip'    => __( 'Url of link for detailed view', 'plumtree' ),
					),
					array(
						'name'       => __( 'Use as banners rotator?',  'plumtree' ),
						'id'         => 'rotator',
						'type'       => 'radio',
						'std'        => 'no',
						'options'    => array( 'yes' => __( 'Yes',  'plumtree' ), 'no' => __( 'No',  'plumtree' ) ),
                        'tooltip' => __( 'Whether to show carousel as banner rotator with buttons',  'plumtree' ),
					),
					array(
						'name'  => __( 'Button Text (shown with banner rotator)',  'plumtree' ),
						'id'    => 'btn_txt',
						'type'  => 'text_field',
						'class' => 'jsn-input-xxlarge-fluid',
                        'tooltip' => __( 'Enter text for button',  'plumtree' ),
					),
				)
			);
		}

		/**
		 * DEFINE shortcode content
		 *
		 * @param type $atts
		 * @param type $content
		 */
		public function element_shortcode_full( $atts = null, $content = null ) {
			extract( shortcode_atts( $this->config['params'], $atts ) );

			global $wpdb;

			$link = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $image_file);
			$id = $wpdb->get_var( $wpdb->prepare(
				"SELECT ID FROM $wpdb->posts WHERE BINARY guid = %s",
				$link
			) );

			$show_rotator = false;
			if ( $rotator == 'yes' )
				$show_rotator = true;

			$html_output = '';
			$img = ! empty( $image_file ) ? wp_get_attachment_image( $id, $image_size ) : '';
			$header = ! empty( $heading ) ? '<h3>'.$heading.'</h3>' : '';
			$text = ! empty( $description ) ? '<span>'.$description.'</span>' : '';
			$quick_view = '<a href="'.$image_file.'" title="'.__('Quick View', 'plumtree').'" rel="nofollow" data-magnific="link"><i class="fa fa-search"></i></a>';
			$button = ! empty( $url ) ? '<a href="'.$url.'" title="'.__('Learn More', 'plumtree').'" rel="bookmark"><i class="fa fa-link"></i></a>' : '';

			if ($show_rotator) {
				$html_output .= '<div class="item-wrapper rotator"><figure><figcaption>';
				$html_output .= $header.$text.'</figcaption>';
				$html_output .= $img;
				$html_output .= '<a href="'.$url.'" title="'.__('Learn More', 'plumtree').'" rel="bookmark">'.$btn_txt.'</a>';
				$html_output .= '</figure></div><!--separate-->';
			} else {
				$html_output .= '<div class="item-wrapper"><figure>';
				$html_output .= $img;
				$html_output .= '<figcaption>';
				$html_output .= '<div class="caption-wrapper">'.$header.$text.'<div class="btn-wrapper">'.$quick_view.$button.'</div></div>';
				$html_output .= '<div class="vertical-helper"></div></figcaption></figure></div><!--separate-->';
			}

			return $html_output;
		}

	}

}
