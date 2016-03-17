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
if ( ! class_exists( 'IG_Item_Testimonials' ) ) {

	class IG_Item_Testimonials extends IG_Pb_Shortcode_Child {

		public function __construct() {
			parent::__construct();
		}

		/**
		 * DEFINE configuration information of shortcode
		 */
		public function element_config() {
			$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['exception'] = array(
				'data-modal-title' => __( 'Testimonials Item',  'plumtree' )
			);
            $this->config['edit_using_ajax'] = true;
		}

		/**
		 * DEFINE setting options of shortcode
		 */
		public function element_items() {
			$this->items = array(
				'Notab' => array(
					array(
						'name'  => __( 'Heading',  'plumtree' ),
						'id'    => 'heading',
						'type'  => 'text_field',
						'class' => 'jsn-input-xxlarge-fluid',
						'role'  => 'title',
						'std'   => __( IG_Pb_Utils_Placeholder::add_placeholder( 'Testimonials Item %s', 'index' ),  'plumtree' ),
                        'tooltip' => __( 'Set the text of your heading items',  'plumtree' ),
					),
                    array(
                        'name'    => __( 'Image File',  'plumtree' ),
                        'id'      => 'image_file',
                        'type'    => 'select_media',
                        'std'     => '',
                        'class'   => 'jsn-input-large-fluid',
                        'tooltip' => __( 'Select background image for item',  'plumtree' )
                    ),
                    array(
						'name'    => __( 'Name', 'plumtree' ),
						'id'      => 'name',
						'type'    => 'text_field',
						'class'   => 'input-sm',
					),
					array(
						'name'    => __( 'Occupation', 'plumtree' ),
						'id'      => 'occupation',
						'type'    => 'text_field',
						'class'   => 'input-sm',
					),
					array(
						'name' => __( 'Text',  'plumtree' ),
						'id'   => 'body',
						'role' => 'content',
						'type' => 'editor',
						'std'  => IG_Pb_Helper_Type::lorem_text(),
                        'tooltip' => __( 'Set content of element',  'plumtree' ),
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

			$html_output = '';

			// Main Elements
			$image = '';
			if ( $image_file ) {
				$image = "<img src='{$image_file}' alt='{$name}' />";
			}
			$heading = '';
			if ( $name ) {
				$heading = "<h3>{$name}</h3>";
			}
			$sub_heading = '';
			if ( $occupation ) {
				$sub_heading = "<span>{$occupation}</span>";
			}
			$inner_content = IG_Pb_Helper_Shortcode::remove_autop( $content );

			// Shortcode output
			$html_output .= '<div class="item-wrapper">';
			$html_output .= '<div class="img-wrapper">'.$image.'</div>';
			$html_output .= '<div class="text-wrapper">'.$heading.$sub_heading.'<p><q>'.$inner_content.'</q></p></div>';
			$html_output .= '</div><!--separate-->';

			return $html_output;

		}

	}

}
