<?php

if ( ! class_exists( 'IG_Contact' ) ) :

class IG_Contact extends IG_Pb_Shortcode_Parent {

	public function __construct() {
		parent::__construct();
	}


	/**
	 * Configure shortcode.
	 *
	 * @return  void
	 */
	public function element_config() {
		$this->config['shortcode'] = strtolower( __CLASS__ );
		$this->config['name'] = __( 'PT Member Contact', 'plumtree' );
		$this->config['has_subshortcode'] = 'IG_Item_' . str_replace( 'IG_', '', __CLASS__ );
        $this->config['edit_using_ajax'] = true;
        $this->config['exception'] = array(
			'default_content'  => __( 'PT Member Contact',  'plumtree' ),
			'data-modal-title' => __( 'PT Member Contact',  'plumtree' ),
		);
	}

	/**
	 * Define shortcode settings.
	 *
	 * @return  void
	 */
	public function element_items() {
		$this->items = array(
			'content' => array(
				array(
					'name'    => __( 'Element Title', 'plumtree' ),
					'id'      => 'el_title',
					'type'    => 'text_field',
					'class'   => 'input-sm',
					'std'     => __( 'Team Contact', 'plumtree' ),
					'role'    => 'title',
					'tooltip' => __( 'Set title for current element for identifying easily', 'plumtree' )
				),
				array(
					'name'    => __( 'Image File', 'plumtree' ),
					'id'      => 'image_file',
					'type'    => 'select_media',
					'std'     => '',
					'class'   => 'jsn-input-large-fluid',
					'tooltip' => __( 'Choose image', 'plumtree' )
				),
				array(
					'name'    => __( 'Team Member Name', 'plumtree' ),
					'id'      => 'name',
					'type'    => 'text_field',
					'class'   => 'input-sm',
				),
				array(
					'name'    => __( 'Team Member Occupation', 'plumtree' ),
					'id'      => 'occupation',
					'type'    => 'text_field',
					'class'   => 'input-sm',
				),
				array(
					'name'    => __( 'Team Member Short Biography', 'plumtree' ),
					'id'      => 'biography',
					'type'    => 'text_field',
					'class'   => 'input-sm',
				),
				array(
					'name'          => __( 'Buttons', 'plumtree' ),
					'id'            => 'button_items',
					'type'          => 'group',
					'shortcode'     => ucfirst( __CLASS__ ),
					'sub_item_type' => $this->config['has_subshortcode'],
					'sub_items'     => array(
						array( 'std' => '' ),
					),
					'tooltip' 		=> __( 'Add social network to your contact', 'plumtree' )
				),

			),
			'styling' => array(
				array(
					'name'    => __( 'Image Position',  'plumtree' ),
					'id'      => 'img_pos',
					'type'    => 'radio',
					'std'     => 'left',
					'options' => array( 'left' => __( 'Left',  'plumtree' ), 'top' => __( 'Top',  'plumtree' ) ),
                    'tooltip' => __( 'Set image position relative to main container',  'plumtree' ),
				),			
			)
		);
	}

	/**
	 * Generate HTML code from shortcode content.
	 *
	 * @param   array   $atts     Shortcode attributes.
	 * @param   string  $content  Current content.
	 *
	 * @return  string
	 */
	public function element_shortcode_full( $atts = null, $content = null ) {
		$arr_params     = shortcode_atts( $this->config['params'], $atts );
		extract( $arr_params );
		$html_output = '';

		// Container Styles
		$container_class = 'pt-member-contact img-pos-'.$img_pos.' '.$css_suffix;
		$container_class = ( ! empty( $container_class ) ) ? ' class="' . $container_class . '"' : '';

		// Main Elements
		$image = '';
		if ( $image_file ) {
			$image = "<div class='contact-img-wrapper'><img src='{$image_file}' alt='{$name}' /></div>";
		}
		$heading = '';
		if ( $name ) {
			$heading = "<h3>{$name}</h3>";
		}
		$sub_heading = '';
		if ( $occupation ) {
			$sub_heading = "<span>{$occupation}</span>";
		}
		$short_bio = '';
		if ( $biography ) {
			$short_bio = "<p>{$biography}</p>";
		}

		$sub_shortcode  = IG_Pb_Helper_Shortcode::remove_autop( $content );
		$items          = explode( '<!--separate-->', $sub_shortcode );
		$items          = array_filter( $items );

		if ($items) {
			$buttons    = "" . implode( '', $items ) . '';
			$social_contacts =  "<div class='contact-btns'>".$buttons."</div>";
		}

		// Shortcode output
		$html_output .= "<div{$container_class}>";
		if ( $img_pos == 'top' ) { $html_output .= $image; }
		$html_output .= "<div class='text-wrapper'>";
		if ( $img_pos == 'left' ) { $html_output .= $image; }
		$html_output .= $heading.$sub_heading.$short_bio.$social_contacts;
		$html_output .= "</div></div>";

		return $this->element_wrapper( $html_output, $arr_params );
	}
}

endif;
