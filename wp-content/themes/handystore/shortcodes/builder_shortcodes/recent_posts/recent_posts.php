<?php


if ( ! class_exists( 'IG_Recent_Posts' ) ) {

	class IG_Recent_Posts extends IG_Pb_Shortcode_Parent {

		public function __construct() {
			parent::__construct();
		}

		public function element_config() {
			//$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['name']      = __( 'PT Recent Posts',  'plumtree' );
			$this->config['exception'] = array(
				'default_content'  => __( 'Recent Posts',  'plumtree' ),
				'data-modal-title' => __( 'Recent Posts',  'plumtree' ),
			);
            $this->config['edit_using_ajax'] = true;
		}

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
					),
					array(
						'name'       => __( 'Posts per row',  'plumtree' ),
						'id'         => 'per_row',
						'type'       => 'select',
						'std'        => '3',
						'options'    => array('3' => '3 Posts', '4' => '4 Posts'),
					),
					array(
						'name'       => __( 'Total number of Posts to show',  'plumtree' ),
						'id'         => 'posts_qty',
						'type'       => 'text_append',
						'type_input' => 'number',
						'std'        => '',
					),
					array(
                        'name'    => __( 'Orderby Parameter',  'plumtree' ),
                        'id'      => 'orderby',
                        'type'    => 'select',
                        'std'     => 'date',
                        'options' => array(
                            'date' => 'Date',
                            'rand' => 'Random',
                            'author' => 'Author',
                            'comment_count' => 'Comments Quantity',
                        ),
                    ),
					array(
                        'name'    => __( 'Order Parameter',  'plumtree' ),
                        'id'      => 'order',
                        'type'    => 'select',
                        'std'     => 'ASC',
                        'options' => array(
                            'ASC' => 'Ascending',
                            'DESC' => 'Descending',
                        ),
                    ),
					array(
						'name'    => __( 'Posts by Category slug',  'plumtree' ),
						'id'      => 'category',
						'type'    => 'text_field',
						'class'   => 'jsn-input-xxlarge-fluid',
						'std'     => '',
						'tooltip' => __( 'Enter specific category if needed', 'plumtree' ),
					),
				),

				'styling' => array(
					array(
						'name' => __( 'Use Owl Carousel?', 'plumtree' ),
						'id' => 'use_slider',
						'type' => 'radio',
						'std' => 'no',
						'options' => array( 'yes' => __( 'Yes', 'plumtree' ), 'no' => __( 'No', 'plumtree' ) ),
						'tooltip' => __( 'Show or not linked button above banner', 'plumtree' ),
						'has_depend' => '1',
					),
					array(
						'name'    => __( 'Elements',  'plumtree' ),
						'id'      => 'elements',
						'type'    => 'items_list',
						'std'     => 'post_thumb__#__title__#__excerpt__#__buttons',
						'options' => array(
							'post_thumb' => __( 'Featured Image',  'plumtree' ),
							'title'   => __( 'Title with Meta Data',  'plumtree' ),
							'excerpt' => __( 'Post Excerpt',  'plumtree' ),
							'buttons'  => __( 'Buttons',  'plumtree' )
						),
						'options_type'    => 'checkbox',
						'popover_items'   => array( 'title', 'button' ),
						'tooltip'         => __( 'Select elements which you want to display',  'plumtree' ),
						'style'           => array( 'height' => '200px' ),
						'container_class' => 'unsortable',
					),
				)
			);
		}

		public function element_shortcode_full( $atts = null, $content = null ) {
			$html_output = '';
			$arr_params     = shortcode_atts( $this->config['params'], $atts );
			extract( $arr_params );

			$elements = explode( '__#__', $elements );
			$use_slider = $arr_params['use_slider'];
			
			$container_class = 'pt-posts-shortcode '.$css_suffix;
			if ( $use_slider == 'yes' ) { 
				$container_class = $container_class.' with-slider';
				$container_id = uniqid('owl',false);
			}
			$container_class = ( ! empty( $container_class ) ) ? ' class="' . $container_class . '"' : '';

			$html_output = "<div{$container_class} id='{$container_id}'>";
			$html_output .= "<div class='title-wrapper'><h3>{$el_title}</h3>";
			if ( $use_slider == 'yes' ) { $html_output .= "<div class='slider-navi'><span class='prev'></span><span class='next'></span></div>"; }
			$html_output .= "</div>";

			// Atts for post query
			if ( in_array( 'post_thumb', $elements ) ) { $show_thumb = true; } else { $show_thumb = false; }
			if ( in_array( 'title', $elements ) ) { $show_title = true; } else { $show_title = false; }
			if ( in_array( 'excerpt', $elements ) ) { $show_excerpt = true; } else { $show_excerpt = false; }
			if ( in_array( 'buttons', $elements ) ) { $show_buttons = true; } else { $show_buttons = false; }

			$html_output .= "[pt-posts per_row='".$per_row."' posts_qty='".$posts_qty."' order='".$order."' orderby='".$orderby."' category_name='".$category."' show_thumb='".$show_thumb."' show_title='".$show_title."' show_excerpt='".$show_excerpt."' show_buttons='".$show_buttons."']";

	        $html_output .= '</div>';

	        if ( $use_slider == 'yes' ) {
				$html_output.='
				<script type="text/javascript">
					(function($) {
						$(document).ready(function() {
							var owl = $("#'.$container_id.' ul.post-list");
 
							owl.owlCarousel({
							items : '.$per_row.',        				  // items above 1000px browser width
							itemsDesktop : '.$per_row.', 				  // items between 1000px and 901px
							itemsDesktopSmall : [900,'.($per_row-1).'],  // betweem 900px and 601px
							itemsTablet: [600,'.($per_row-2).'], 		  // items between 600 and 0
							itemsMobile : [479,1], 						  // 1 item on Mobile dwvices
							pagination: false,
							navigation : false,
							rewindNav : false,
							scrollPerPage : false,
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
			}

			return $this->element_wrapper( $html_output, $arr_params );
		}
		
	}	

}