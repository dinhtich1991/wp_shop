<?php

if ( ! class_exists( 'IG_Carousel' ) ) {

	class IG_Carousel extends IG_Pb_Shortcode_Parent {

		public function __construct() {
			parent::__construct();
		}

		/**
		 * DEFINE configuration information of shortcode
		 */
		public function element_config() {
			$this->config['shortcode']        = strtolower( __CLASS__ );
			$this->config['name']             = __( 'PT Carousel',  'plumtree' );
			$this->config['has_subshortcode'] = 'IG_Item_' . str_replace( 'IG_', '', __CLASS__ );
            $this->config['edit_using_ajax'] = true;
            $this->config['exception'] = array(
				'default_content'  => __( 'PT Carousel',  'plumtree' ),
				'data-modal-title' => __( 'PT Carousel',  'plumtree' ),
			
				'admin_assets' => array(
					// Shortcode initialization
					'row.js',
					'ig-colorpicker.js',
				),
			);

		}

		/**
		 * DEFINE setting options of shortcode
		 */
		public function element_items() {
			$this->items = array(
				'content' => array(
					array(
						'name'    => __( 'Element Title',  'plumtree' ),
						'id'      => 'el_title',
						'type'    => 'text_field',
						'class'   => 'jsn-input-xxlarge-fluid',
						'std'     => '',
						'role'    => 'title',
						'tooltip' => __( 'Set title for current element for identifying easily',  'plumtree' )
					),
					array(
						'id'            => 'carousel_items',
						'type'          => 'group',
						'shortcode'     => ucfirst( __CLASS__ ),
						'sub_item_type' => $this->config['has_subshortcode'],
						'sub_items'     => array(
							array('std' => ''),
							array('std' => ''),
						),
					),
				),
				'styling' => array(
					array(
                        'name'    => __( 'Items per Slide',  'plumtree' ),
                        'id'      => 'per_slide',
                        'type'    => 'select',
                        'std'     => '3',
                        'options' => array(
							'1' => '1 item in row',
							'2' => '2 items in row',
							'3' => '3 items in row',
							'6' => '6 items in 2 rows',                        
						),
                    ),
					array(
						'name'                 => __( 'Dimension',  'plumtree' ),
						'container_class'      => 'combo-group',
						'id'                   => 'dimension',
						'type'                 => 'dimension',
						'extended_ids'         => array( 'dimension_width', 'dimension_height', 'dimension_width_unit' ),
						'dimension_width'      => array( 'std' => '' ),
						'dimension_height'     => array( 'std' => '' ),
						'dimension_width_unit' => array(
							'options' => array( 'px' => 'px', '%' => '%' ),
							'std'     => 'px',
						),
                        'tooltip' => __( 'Set width and height of element',  'plumtree' ),
					),
					array(
                        'name'    => __( 'Transition Type',  'plumtree' ),
                        'id'      => 'transition_type',
                        'type'    => 'select',
                        'std'     => 'fade',
                        'options' => array(
							'fade' => 'Fade',
							'backSlide' => 'Back Slide',
							'goDown' => 'Go Down',
							'fadeUp' => 'Fade Up',                        
						),
                    ),
					array(
						'name'    => __( 'Show Page Navigation',  'plumtree' ),
						'id'      => 'show_indicator',
						'type'    => 'radio',
						'std'     => 'yes',
						'options' => array( 'yes' => __( 'Yes',  'plumtree' ), 'no' => __( 'No',  'plumtree' ) ),
                        'tooltip' => __( 'Show/hide navigation buttons under your carousel',  'plumtree' ),
					),
					array(
						'name'    => __( 'Show Arrows',  'plumtree' ),
						'id'      => 'show_arrows',
						'type'    => 'radio',
						'std'     => 'yes',
						'options' => array( 'yes' => __( 'Yes',  'plumtree' ), 'no' => __( 'No',  'plumtree' ) ),
                        'tooltip' => __( 'Show/hide arrow buttons',  'plumtree' ),
					),
					array(
						'name'       => __( 'Autoplay',  'plumtree' ),
						'id'         => 'autoplay',
						'type'       => 'radio',
						'std'        => 'no',
						'options'    => array( 'yes' => __( 'Yes',  'plumtree' ), 'no' => __( 'No',  'plumtree' ) ),
                        'tooltip' => __( 'Whether to running your carousel automatically or not',  'plumtree' ),
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
			$arr_params    = shortcode_atts( $this->config['params'], $atts );
			extract( $arr_params );
			$html_output = '';

			// Container Styles
			$container_class = 'pt-carousel '.$css_suffix;
			$container_id = uniqid('owl',false);
			$container_class = ( ! empty( $container_class ) ) ? ' class="' . $container_class . '"' : '';

			$styles        = array();
			if ( ! empty( $dimension_width ) )
				$styles[] = "width : {$dimension_width}{$dimension_width_unit};";
			if ( ! empty( $dimension_height ) )
				$styles[] = "height : {$dimension_height}px;";
			$styles = trim( implode( ' ', $styles ) );
			$styles = ! empty( $styles ) ? "style='$styles'" : '';

			// Carousel Parameters
			$owlAutoPlay = 'false';
			if ( $autoplay == 'yes' )
				$owlAutoPlay = 'true';
			$owlPagination = 'false';
			if ( $show_indicator == 'yes' )
				$owlPagination = 'true';
			$owlTransition = $transition_type;

			// Get Carousel Items
			$sub_shortcode = IG_Pb_Helper_Shortcode::remove_autop( $content );
			$items = explode( '<!--separate-->', $sub_shortcode );
			array_pop($items);
			$total = count($items);
			$new_items = '';
			$test = '';

			if ( $total<(int)$per_slide || (int)$per_slide==1 ) {
				foreach ($items as $position => $item) {
					$new_items .= '<div class="carousel-item">'.$item.'</div>';
				}
			} else {
				foreach ($items as $position => $item) {
					$current_position = $position + 1;
					if ( ($current_position == 1) || ($current_position % (int)$per_slide == 1) ) {
						$new_items .= '<div class="carousel-item">'.$item;
						if ($current_position == $total) {
							$new_items .= '</div>';
						}
					} elseif ( $current_position == $total ) {
						$new_items .= $item.'</div>';
					} elseif ( $current_position % (int)$per_slide == 0 ) {
						$new_items .= $item.'</div>';
					} else {
						$new_items .= $item;
					}
				}
			}

			$carousel_content = $new_items;

			// Output Carousel
			$html_output .= "<div{$container_class} id='{$container_id}'>";
			if ( $el_title && $el_title !='' ) { $html_output .= "<div class='title-wrapper'><h3>{$el_title}</h3>"; }
			if ( $show_arrows == 'yes' ) { $html_output .= "<span class='prev'></span><span class='next'></span>"; }
			if ( $el_title && $el_title !='' ) { $html_output .= "</div>"; }
			$html_output .= "<div class='carousel-container per-slide-{$per_slide}' {$styles}>";
			$html_output .= $carousel_content;
			$html_output .= "</div></div>";

			$html_output.='
				<script type="text/javascript">
					(function($) {
						$(document).ready(function() {
							var owl = $("#'.$container_id.' .carousel-container");
 
							owl.owlCarousel({
								navigation : false,
								pagination : '.$owlPagination.',
								autoPlay   : '.$owlAutoPlay.',
								slideSpeed : 300,
								paginationSpeed : 400,
								singleItem : true,
								transitionStyle : "'.$owlTransition.'",
							});

							// Custom Navigation Events
							$("#'.$container_id.'").find(".next").click(function(){
								owl.trigger("owl.next");
							})
							$("#'.$container_id.'").find(".prev").click(function(){
								owl.trigger("owl.prev");
							})
						});
					})(jQuery);
				</script>';

			return $this->element_wrapper( $html_output, $arr_params );
		}

	}

} 