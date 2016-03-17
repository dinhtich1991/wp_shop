<?php 
/*  Loading the admin Panel  */
$panel = new PTPanel();
$panel->panelName = 'Handy Store Theme Settings';

$pt_global = new PanelSectionFactory('pt-global', 'Site Settings', array(3, 1), 'Set global site options in this panel');
$pt_store = new PanelSectionFactory('pt-store', 'Store Settings', array(1, 1), 'Modify sites Store output');
$pt_typography = new PanelSectionFactory('pt-typography', 'Fonts & Colors Settings', array(2, 0), 'Modify Color scheme & fonts for main elements');
$pt_layout = new PanelSectionFactory('pt-layout', 'Layout Settings', array(1, 0), 'Set global layout options for pages in this panel');
$pt_blog = new PanelSectionFactory('pt-blog', 'Blog Settings', array(3, 2), 'Modify sites Blog output');

$panel->addSection($pt_global);
$panel->addSection($pt_layout);
$panel->addSection($pt_typography);
$panel->addSection($pt_blog);
$panel->addSection($pt_store);

/*  Adding Google fonts  */
$fonts = get_option('pt_google_fonts');

/*  Hover Effects  */
$hover_effects = array(
	'lily' => 'Hover Effect Lily',
    'sadie' => 'Hover Effect Sadie',
    'roxy' => 'Hover Effect Roxy',
    'bubba' => 'Hover Effect Bubba',
    'romeo' => 'Hover Effect Romeo',
    'oscar' => 'Hover Effect Oscar',
    'ruby' => 'Hover Effect Ruby',
    'milo' => 'Hover Effect Milo',
    'dexter' => 'Hover Effect Dexter',
    'sarah' => 'Hover Effect Sarah',
    'chico' => 'Hover Effect Chico',
);

/*  Site Settings Forms  */
$site_layout_option = OptionFactory::create('site_layout_id',
	'site_layout',
	FieldType::$RADIOBUTTON,
	'pt-global',
	'Select layout for site',
	array(
		'description' => '',
		'required' => false,
		'default' => 'wide',
		'options' => array(
			'wide'  => 'Wide',
			'boxed' => 'Boxed',
		)
), false);

$site_maintenance_mode_option = OptionFactory::create('site_maintenance_mode_id',
	'site_maintenance_mode',
	FieldType::$ONOFF,
	'pt-global',
	'Enable "Maintenance Mode" for site?',
		array(
		'default' => 'off',
		'description' => ''
	),
false);

$maintenance_countdown_option = OptionFactory::create('maintenance_countdown_id', 
	'maintenance_countdown', 
	FieldType::$TEXT, 
	'pt-global', 
	'Enter the date when "Maintenance Mode" expired', 
	array('description' => 'Set date in following format (YYYY-MM-DD). If you leave this field blank, countdown clock won&rsquo;t be shown'), 
false);

$header_top_panel_option = OptionFactory::create('header_top_panel_id',
	'header_top_panel',
	FieldType::$ONOFF,
	'pt-global',
	'Header top panel view switcher',
		array(
		'default' => 'on',
		'description' => 'Switch to "Off" if you don&rsquo;t want to use header top panel'
	),
false);

$logo_upload_option = OptionFactory::create('site_logo_id',
	'site_logo',
	FieldType::$MEDIAUPLOAD,
	'pt-global',
	'Choose logo image',
	array('required' => false), 
false);

$logo_position_option = OptionFactory::create('site_logo_position_id',
	'site_logo_position',
	FieldType::$RADIOBUTTON,
	'pt-global',
	'Select logo position',
	array(
		'description' => 'You have to set Logo position in header',
		'required' => false,
		'default' => 'center',
		'options' => array(
			'left'  => 'Left',
			'right' => 'Right',
			'center' => 'Center'
		)
), false);

$favicon_upload_option = OptionFactory::create('site_favicon_id',
	'site_favicon',
	FieldType::$MEDIAUPLOAD,
	'pt-global',
	'Choose favicon image',
	array('required' => false, 'description' => 'Must be in .ico, .png, .gif & 16x16(32x32)px. Use www.favicongenerator.com to create your own favicon.'), 
false);

$top_panel_info_option = OptionFactory::create('top_panel_info_id', 
	'top_panel_info', 
	FieldType::$TEXTAREA, 
	'pt-global', 
	'Enter info contents', 
	array('description' => 'Info appears at center of headers top panel'), 
false);

$top_panel_bg_color_option = OptionFactory::create('top_panel_bg_color_id',
	'top_panel_bg_color',
	FieldType::$COLORPICKER,
	'pt-global',
	'Set background color of header top panel',
	array('required' => false,
		  'description' => 'Default: #F5F5F5' ), 

false);

$site_copyright_option = OptionFactory::create('site_copyright_id', 
	'site_copyright', 
	FieldType::$TEXTAREA, 
	'pt-global', 
	'Enter sites copyright', 
	array('description' => 'Enter copyright (appears at the bottom of site)'), 
false);

$site_breadcrumbs_option = OptionFactory::create('site_breadcrumbs_id',
	'site_breadcrumbs',
	FieldType::$ONOFF,
	'pt-global',
	'Site breadcrumbs switcher',
		array(
		'default' => 'on',
		'description' => 'Switch to "Off" if you don&rsquo;t want to use breadcrumbs'
	),
false);

$front_page_shortcode_section_option = OptionFactory::create('front_page_shortcode_section_id',
	'front_page_shortcode_section',
	FieldType::$ONOFF,
	'pt-global',
	'Front Page shortcode section switcher',
		array(
		'default' => 'on',
		'description' => 'Switch to "Off" if you don&rsquo;t want to use front page shortcode section located at the Top of Front Page'
	),
false);

$front_page_shortcode_section_shortcode = OptionFactory::create('front_page_shortcode_section_shortcode_id', 
	'front_page_shortcode_section_shortcode', 
	FieldType::$TEXTAREA, 
	'pt-global', 
	'Enter shortcode for Front page shortcode section', 
	array('description' => ''), 
false);

$site_post_likes_option = OptionFactory::create('site_post_likes_id',
	'site_post_likes',
	FieldType::$ONOFF,
	'pt-global',
	'Post like system switcher',
		array(
		'default' => 'on',
		'description' => 'Anabling post like functionality on your site + Extra Widgets (Popular Posts, User Likes)'
	),
false);

$footer_shortcode_section_option = OptionFactory::create('footer_shortcode_section_id',
	'footer_shortcode_section',
	FieldType::$ONOFF,
	'pt-global',
	'Footer shortcode section switcher',
		array(
		'default' => 'on',
		'description' => 'Switch to "Off" if you don&rsquo;t want to use footer shortcode section located at the bottom of page'
	),
false);

$shortcode_section_bg_image_option = OptionFactory::create('shortcode_section_bg_image_id',
	'shortcode_section_bg_image',
	FieldType::$MEDIAUPLOAD,
	'pt-global',
	'Choose background image for shortcode section',
	array('required' => false), 
false);

$shortcode_section_bg_color_option = OptionFactory::create('shortcode_section_bg_color_id',
	'shortcode_section_bg_color',
	FieldType::$COLORPICKER,
	'pt-global',
	'Choose background color for shortcode section',
	array('required' => false,
		'description' => 'Default: #F5F5F5'), 
false);

$shortcode_section_shortcode = OptionFactory::create('shortcode_section_shortcode_id', 
	'shortcode_section_shortcode', 
	FieldType::$TEXTAREA, 
	'pt-global', 
	'Enter shortcode', 
	array('description' => ''), 
false);

$header_bg_image_option = OptionFactory::create('header_bg_image_id',
	'header_bg_image',
	FieldType::$MEDIAUPLOAD,
	'pt-global',
	'Choose background image for header',
	array('required' => false), 
false);

$header_bg_color_option = OptionFactory::create('header_bg_color_id',
	'header_bg_color',
	FieldType::$COLORPICKER,
	'pt-global',
	'Choose background color for header',
	array('required' => false), 
false);

$top_panel_bg_option = OptionFactory::create('top_panel_bg_id',
	'top_panel_bg',
	FieldType::$RADIOBUTTON,
	'pt-global',
	'Choose bg type for header top section',
	array(
		'required' => false,
		'default' => 'transparent',
		'options' => array(
			'transparent'  => 'Transparent',
			'solid' => 'Solid Color',
		)
), false);

$google_code_option = OptionFactory::create('google_code_id', 
	'google_code', 
	FieldType::$TEXTAREA, 
	'pt-global', 
	'Google Analytics', 
	array('description' => 'Paste in your Google Analytics tracking code here'), 
false);

$totop_button_option = OptionFactory::create('totop_button_id',
	'totop_button',
	FieldType::$ONOFF,
	'pt-global',
	'Enable "Scroll to Top" button?',
		array(
		'default' => 'off',
		'description' => 'If "ON" appears in bottom right corner of site'
	),
false);

$front_page_special_sidebar = OptionFactory::create('front_page_special_sidebar_id', 
	'front_page_special_sidebar', 
	FieldType::$ONOFF, 
	'pt-global', 
	'Front Page special sidebar switcher', 
		array(
		'default' => 'on',
		'description' => 'Switch to "Off" if you don&rsquo;t want to use front page special sidebar located at the bottom of Front Page Template'
	),
false);

/*  Site Settings Output  */
$global_content = '<div class="wrapper container-fluid"><div class="row-fluid">'
.'<div class="span6">'
.'<h1 class="options-block">Global Theme Options</h1>'
.'<div class="options-block">'
.$site_layout_option
.$site_breadcrumbs_option
.$site_post_likes_option
.$site_maintenance_mode_option
.$maintenance_countdown_option
.'</div>'
.'<br />'
.'<h1 class="options-block">Header Options</h1>'
.'<div class="options-block">'
.$header_bg_image_option
.$header_bg_color_option
.'<h2>Top Panel Options</h2>'
.$header_top_panel_option
.$top_panel_bg_option
.$top_panel_bg_color_option
.$top_panel_info_option
.'<h2>Logo Options</h2>'
.$logo_upload_option
.$logo_position_option
.'</div>'
.'</div>'
.'<div class="span6">'
.'<h1 class="options-block">Front Page Options</h1>'
.'<div class="options-block">'
.'<p>Modify these options only when special front page template is being used</p>'
.$front_page_shortcode_section_option
.$front_page_shortcode_section_shortcode
.$front_page_special_sidebar
.'</div>'
.'<br />'
.'<h1 class="options-block">Footer Options</h1>'
.'<div class="options-block">'
.$footer_shortcode_section_option
.$shortcode_section_bg_image_option
.$shortcode_section_bg_color_option
.$shortcode_section_shortcode
.$site_copyright_option
.'</div>'
.'<br />'
.'<h1 class="options-block">Extra Features</h1>'
.'<div class="options-block">'
.$totop_button_option
.$favicon_upload_option
.$google_code_option
.'</div>'
.'</div>'
.'</div></div>';

/*  Typography Settings Forms  */
$main_color_option = OptionFactory::create('main_color_id',
	'main_color',
	FieldType::$COLORPICKER,
	'pt-typography',
	'Set global text color',
	array('required' => false,
		  'description' => 'Default: #6A6A6A' ), 
false);

$footer_color_option = OptionFactory::create('footer_color_id',
	'footer_color',
	FieldType::$COLORPICKER,
	'pt-typography',
	'Set text color for footer',
	array('required' => false,
		  'description' => 'Default: #AEB4BC' ), 
false);

$headings_content_option = OptionFactory::create('headings_content_id',
	'headings_content',
	FieldType::$COLORPICKER,
	'pt-typography',
	'Set color for headings in content zone',
	array('required' => false,
		  'description' => 'Default: #484747'), 
false);

$headings_sidebar_option = OptionFactory::create('headings_sidebar_id',
	'headings_sidebar',
	FieldType::$COLORPICKER,
	'pt-typography',
	'Set color for headings in sidebar zone',
	array('required' => false,
		  'description' => 'Default: #484747'), 
false);

$headings_footer_option = OptionFactory::create('headings_footer_id',
	'headings_footer',
	FieldType::$COLORPICKER,
	'pt-typography',
	'Set color for headings in footer zone',
	array('required' => false,
		  'description' => 'Default: #FFF'), 
false);

$link_color_option = OptionFactory::create('link_color_id',
	'link_color',
	FieldType::$COLORPICKER,
	'pt-typography',
	'Set color for links',
	array('required' => false,
		'description' => 'Default: #000'), 
false);

$link_color_hover_option = OptionFactory::create('link_color_hover_id',
	'link_color_hover',
	FieldType::$COLORPICKER,
	'pt-typography',
	'Set link color on hover',
	array('required' => false,
		'description' => 'Default: #C2D44E'), 
false);

$button_color_option = OptionFactory::create('button_color_id',
	'button_color',
	FieldType::$COLORPICKER,
	'pt-typography',
	'Set bg color for buttons',
	array('required' => false,
		'description' => 'Default: #C2D44E'), 
false);

$button_color_hover_option = OptionFactory::create('button_color_hover_id',
	'button_color_hover',
	FieldType::$COLORPICKER,
	'pt-typography',
	'Set button bg color on hover',
	array('required' => false,
		'description' => 'Default: #B5C648'), 
false);

$button_color_text_option = OptionFactory::create('button_color_text_id',
	'button_color_text',
	FieldType::$COLORPICKER,
	'pt-typography',
	'Set button text color',
	array('required' => false,
		'description' => 'Default: #FFF'), 
false);

$button_font_option = OptionFactory::create('button_font_id',
	'button_font', 
	FieldType::$SELECT, 
	'pt-typography', 
	'Select button text font', array(
		'requiered' => false,
		'description' => 'Default for buttons is "Roboto"',
		'options' => $fonts,
		'class' => 'google-fonts-select',
), false);

$main_font_option = OptionFactory::create('main_font_id', 
	'main_font', 
	FieldType::$SELECT, 
	'pt-typography', 
	'Select global theme font', array(
		'requiered' => false,
		'description' => 'Default for theme is "Open Sans"',
		'options' => $fonts,
		'class' => 'google-fonts-select',
), false);

$heading_font_option = OptionFactory::create('heading_font_id',
	'heading_font', 
	FieldType::$SELECT, 
	'pt-typography', 
	'Select font for headings in theme', array(
		'requiered' => false,
		'description' => 'Default for headings is "Roboto"',
		'options' => $fonts,
		'class' => 'google-fonts-select',
), false);

$site_custom_colors_option = OptionFactory::create('site_custom_colors_id',
	'site_custom_colors',
	FieldType::$ONOFF,
	'pt-typography',
	'Enable custom colors and fonts?',
		array(
		'default' => 'off',
		'description' => ''
	),
false);

/*  Typography Settings Output  */
$typography_content = '<div class="wrapper container-fluid"><div class="row-fluid">'
.'<div class="span6">'
.'<h1 class="options-block">Advanced Color Options</h1>'
.'<div class="options-block">'
.$site_custom_colors_option
.'<h2>Global Font Options</h2>'
.$main_color_option
.$main_font_option
.$footer_color_option
.'<h2>Headings Font Options</h2>'
.$headings_content_option
.$headings_sidebar_option
.$headings_footer_option
.$heading_font_option
.'</div>'
.'</div>'
.'<div class="span6">'
.'<h1 class="options-block">Links and Buttons</h1>'
.'<div class="options-block">'
.'<h2>Link Font Options</h2>'
.$link_color_option
.$link_color_hover_option
.'<h2>Buttons Font Options</h2>'
.$button_color_option
.$button_color_hover_option
.$button_color_text_option
.$button_font_option
.'</div>'
.'</div>'
.'</div></div>';


/*  Layout Settings Forms  */
$frontpage_layout_option = OptionFactory::create('home_layout_id',
	'front_layout',
	FieldType::$COLLECTION,
	'pt-layout',
	'Set Front page layout',
	array(
		'required' => false,
		'description' => 'Specify the location of sidebars about the content on the front page',
		'default' => 'two-col-left',
		'options'   => array(
			array('value' => 'one-col', 'label' => '1 Column (no sidebars)', 'icon' => get_template_directory_uri().'/assets/one-col.png'),
			array('value' => 'two-col-left', 'label' => '2 Columns, sidebar on left', 'icon' => get_template_directory_uri().'/assets/two-col-left.png'),
			array('value' => 'two-col-right', 'label' => '2 Columns, sidebar on right', 'icon' => get_template_directory_uri().'/assets/two-col-right.png') )
), false);

$page_layout_option = OptionFactory::create('page_layout_id',
	'page_layout',
	FieldType::$COLLECTION,
	'pt-layout',
	'Set global layout for Pages',
	array(
		'required' => false,
		'description' => 'Specify the location of sidebars about the content on the Pages of your site',
		'default' => 'two-col-left',
		'options'   => array(
			array('value' => 'one-col', 'label' => '1 Column (no sidebars)', 'icon' => get_template_directory_uri().'/assets/one-col.png'),
			array('value' => 'two-col-left', 'label' => '2 Columns, sidebar on left', 'icon' => get_template_directory_uri().'/assets/two-col-left.png'),
			array('value' => 'two-col-right', 'label' => '2 Columns, sidebar on right', 'icon' => get_template_directory_uri().'/assets/two-col-right.png') )
), false);

$blog_layout_option = OptionFactory::create('blog_layout_id',
	'blog_layout',
	FieldType::$COLLECTION,
	'pt-layout',
	'Set Blog page layout',
	array(
		'required' => false,
		'description' => 'Specify the location of sidebars about the content on the Blog page',
		'default' => 'two-col-left',
		'options'   => array(
			array('value' => 'one-col', 'label' => '1 Column (no sidebars)', 'icon' => get_template_directory_uri().'/assets/one-col.png'),
			array('value' => 'two-col-left', 'label' => '2 Columns, sidebar on left', 'icon' => get_template_directory_uri().'/assets/two-col-left.png'),
			array('value' => 'two-col-right', 'label' => '2 Columns, sidebar on right', 'icon' => get_template_directory_uri().'/assets/two-col-right.png') )
), false);

$single_layout_option = OptionFactory::create('single_layout_id',
	'single_layout',
	FieldType::$COLLECTION,
	'pt-layout',
	'Set Single post view layout',
	array(
		'required' => false,
		'description' => 'Specify the location of sidebars about the content on the single posts',
		'default' => 'two-col-left',
		'options'   => array(
			array('value' => 'one-col', 'label' => '1 Column (no sidebars)', 'icon' => get_template_directory_uri().'/assets/one-col.png'),
			array('value' => 'two-col-left', 'label' => '2 Columns, sidebar on left', 'icon' => get_template_directory_uri().'/assets/two-col-left.png'),
			array('value' => 'two-col-right', 'label' => '2 Columns, sidebar on right', 'icon' => get_template_directory_uri().'/assets/two-col-right.png') )
), false);

$shop_layout_option = OptionFactory::create('shop_layout_id',
	'shop_layout',
	FieldType::$COLLECTION,
	'pt-layout',
	'Set Products page (Shop page) layout',
	array(
		'required' => false,
		'default' => 'two-col-left',
		'description' => 'Specify the location of sidebars about the content on the products page',
		'options'   => array(
			array('value' => 'one-col', 'label' => '1 Column (no sidebars)', 'icon' => get_template_directory_uri().'/assets/one-col.png'),
			array('value' => 'two-col-left', 'label' => '2 Columns, sidebar on left', 'icon' => get_template_directory_uri().'/assets/two-col-left.png'),
			array('value' => 'two-col-right', 'label' => '2 Columns, sidebar on right', 'icon' => get_template_directory_uri().'/assets/two-col-right.png') )
), false);

$product_layout_option = OptionFactory::create('product_layout_id',
	'product_layout',
	FieldType::$COLLECTION,
	'pt-layout',
	'Set Single Product pages layout',
	array(
		'required' => false,
		'default' => 'two-col-left',
		'description' => 'Specify the location of sidebars about the content on the single product pages',
		'options'   => array(
			array('value' => 'one-col', 'label' => '1 Column (no sidebars)', 'icon' => get_template_directory_uri().'/assets/one-col.png'),
			array('value' => 'two-col-left', 'label' => '2 Columns, sidebar on left', 'icon' => get_template_directory_uri().'/assets/two-col-left.png'),
			array('value' => 'two-col-right', 'label' => '2 Columns, sidebar on right', 'icon' => get_template_directory_uri().'/assets/two-col-right.png') )
), false);

/*  Layout Settings Output  */
$layout_content = '<div class="wrapper container-fluid"><div class="row-fluid">'
.'<div class="span6">'
.'<h1 class="options-block">Blog Layout Options</h1>'
.'<div class="options-block">'
.$frontpage_layout_option
.$page_layout_option
.$blog_layout_option
.$single_layout_option
.'</div>'
.'</div>'
.'<div class="span6">'
.'<h1 class="options-block">Store Layout Options</h1>'
.'<div class="options-block">'
.$shop_layout_option
.$product_layout_option
.'</div>'
.'</div>'
.'</div></div>';


/*  Blog Settings  */
$blog_pagination_option = OptionFactory::create('blog_pagination_id',
	'blog_pagination',
	FieldType::$RADIOBUTTON,
	'pt-blog',
	'Select pagination view for blog page',
	array(
		'description' => '',
		'required' => false,
		'default' => 'numeric',
		'options' => array(
			'infinite'  => 'Infinite blog',
			'numeric' => 'Numeric pagination',
		)
), false);

$post_pagination_option = OptionFactory::create('post_pagination_id',
	'post_pagination',
	FieldType::$ONOFF,
	'pt-blog',
	'Single post Prev/Next navigation output switcher',
		array(
		'default' => 'on',
		'description' => 'Switch to "Off" if you don&rsquo;t want to use single post navigation'
	),
false);

$post_breadcrumbs_option = OptionFactory::create('post_breadcrumbs_id',
	'post_breadcrumbs',
	FieldType::$ONOFF,
	'pt-blog',
	'Single post breadcrumbs switcher',
		array(
		'default' => 'on',
		'description' => 'Switch to "Off" if you don&rsquo;t want to use breadcrumbs on Single post view'
	),
false);

$blog_share_buttons_option = OptionFactory::create('blog_share_buttons_id',
	'blog_share_buttons',
	FieldType::$ONOFF,
	'pt-blog',
	'Single post share buttons output switcher',
		array(
		'default' => 'on',
		'description' => 'Switch to "Off" if you don&rsquo;t want to use share buttons'
	),
false);

$blog_read_more_text_option = OptionFactory::create('blog_read_more_text_id', 
	'blog_read_more_text', 
	FieldType::$TEXTAREA, 
	'pt-blog', 
	'Enter text for "Read More" button', 
	array('description' => ''), 
false);

$post_show_related_option = OptionFactory::create('post_show_related_id',
	'post_show_related',
	FieldType::$ONOFF,
	'pt-blog',
	'Single post Related Posts output switcher',
		array(
		'default' => 'on',
		'description' => 'Switch to "Off" if you don&rsquo;t want to show related posts'
	),
false);

$show_gallery_carousel_option = OptionFactory::create('show_gallery_carousel_id',
	'show_gallery_carousel',
	FieldType::$ONOFF,
	'pt-blog',
	'Carousel for Gallery posts on blog page',
		array(
		'default' => 'on',
		'description' => 'Switch to "Off" if you don&rsquo;t want to show carousel for gallery posts'
	),
false);

$gallery_carousel_type_option = OptionFactory::create('gallery_carousel_type_id',
	'gallery_carousel_type',
	FieldType::$RADIOBUTTON,
	'pt-blog',
	'Select carousel type for Gallery post Carousel',
	array(
		'description' => '',
		'required' => false,
		'default' => 'numeric',
		'options' => array(
			'paginated'  => 'Pagination navi',
			'with-thumbs' => 'Thumbnails navi',
		)
), false);

$gallery_carousel_effect_option = OptionFactory::create('gallery_carousel_effect_id', 
	'gallery_carousel_effect', 
	FieldType::$SELECT, 
	'pt-blog', 
	'Select transition effect for Gallery post Carousel', array(
		'requiered' => false,
		'description' => '',
		'options' => array(
			'fade' => 'Fade',
			'backSlide' => 'Back Slide',
			'goDown' => 'Go Down',
			'fadeUp' => 'Fade Up',
	)
), false);

$comments_pagination_option = OptionFactory::create('comments_pagination_id',
	'comments_pagination',
	FieldType::$RADIOBUTTON,
	'pt-blog',
	'Select pagination type for comments',
	array(
		'description' => '',
		'required' => false,
		'default' => 'numeric',
		'options' => array(
			'newold'  => 'Newer/Older pagination',
			'numeric' => 'Numeric pagination',
		)
), false);

$blog_layout_option = OptionFactory::create('blog_frontend_layout_id',
	'blog_frontend_layout',
	FieldType::$RADIOBUTTON,
	'pt-blog',
	'Select layout for blog',
	array(
		'description' => '',
		'required' => false,
		'default' => 'list',
		'options' => array(
			'list'  => 'List',
			'grid' => 'Grid',
			'isotope' => 'Isotope with filters'
		)
), false);

$blog_grid_columns_option = OptionFactory::create('blog_grid_columns_id',
	'blog_grid_columns',
	FieldType::$RADIOBUTTON,
	'pt-blog',
	'Select number of columns for Blog "grid layout" or "isotope layout"',
	array(
		'description' => '',
		'required' => false,
		'default' => 'cols-3',
		'options' => array(
			'cols-2'  => '2 Columns',
			'cols-3' => '3 Columns',
			'cols-4' => '4 Columns',
		)
), false);

$blog_isotope_filters_option = OptionFactory::create('blog_isotope_filters_id',
	'blog_isotope_filters',
	FieldType::$RADIOBUTTON,
	'pt-blog',
	'Select what taxonomy will be used for blog filters',
	array(
		'description' => 'Required if blog layout set to &rsquo;Isotope with filters&rsquo;',
		'required' => false,
		'default' => 'cats',
		'options' => array(
			'cats'  => 'Categories',
			'tags' => 'Tags',
		)
), false);

/*  Blog Settings Output  */
$blog_content = '<div class="wrapper container-fluid"><div class="row-fluid">'
.'<div class="span6">'
.'<h1 class="options-block">Blog Page Features</h1>'
.'<div class="options-block">'
.$blog_read_more_text_option
.'<h2>Blog Layout</h2>'
.$blog_layout_option
.$blog_grid_columns_option
.$blog_isotope_filters_option
.$blog_pagination_option
.'<h2>Post type Gallery Options</h2>'
.$show_gallery_carousel_option
.$gallery_carousel_type_option
.$gallery_carousel_effect_option
.'</div>'
.'</div>'
.'<div class="span6">'
.'<h1 class="options-block">Single Post Features</h1>'
.'<div class="options-block">'
.$post_pagination_option
.$blog_share_buttons_option
.$post_breadcrumbs_option
.$post_show_related_option
.$comments_pagination_option
.'</div>'
.'</div>'
.'</div></div>';


/*  Store Settings  */
$cart_count = OptionFactory::create('cart_count_id',
    'cart_count',
    FieldType::$ONOFF,
    'pt-store',
    'Show number of products in the cart ON/OFF',
    array(
        'default' => 'off',
        'description' => 'Switch to "ON" if you want to show a a number of products currently in the cart'
    ),
    false
);

$store_per_page_option = OptionFactory::create('store_per_page_id', 
	'store_per_page', 
	FieldType::$NUMBER, 
	'pt-store', 
	'Enter number of products to show on Store page', 
		array('description' => ''), 
false);

$store_columns_option = OptionFactory::create('store_columns_id',
	'store_columns',
	FieldType::$RADIOBUTTON,
	'pt-store',
	'Select product quantity per row on Store page',
	array(
		'required' => false,
		'default' => '3',
		'options' => array(
			'3'  => '3 Products',
			'4' => '4 Products',
		)
), false);

$store_breadcrumbs_option = OptionFactory::create('store_breadcrumbs_id',
		'store_breadcrumbs',
		FieldType::$ONOFF,
		'pt-store',
		'Store Breadcrumbs view switcher',
			array(
			'default' => 'on',
			'description' => 'Switch to "Off" if you don&rsquo;t want to use breadcrumbs on store page'
		),
false);

$product_pagination_option = OptionFactory::create('product_pagination_id',
		'product_pagination',
		FieldType::$ONOFF,
		'pt-store',
		'Single Product pagination (prev/next product) view switcher',
			array(
			'default' => 'on',
			'description' => 'Switch to "Off" if you don&rsquo;t want to use single pagination on product page'
		),
false);

$use_pt_images_slider_option = OptionFactory::create('use_pt_images_slider_id',
    'use_pt_images_slider',
    FieldType::$ONOFF,
    'pt-store',
    'Use custom images output on Single product page',
    array(
        'default' => 'on',
        'description' => 'Turning on custom image carousel on single product page'
    ),
    false
);

$product_slider_type_option = OptionFactory::create('product_slider_type_id',
	'product_slider_type',
	FieldType::$RADIOBUTTON,
	'pt-store',
	'Choose slider type for images on Single product page',
	array(
		'required' => false,
		'default' => 'simple-slider',
		'options' => array(
			'simple-slider'  => 'Slider',
			'slider-with-popup' => 'Slider with pop-up gallery',
			'slider-with-thumbs'  => 'Slider with thumbnails',
		)
), false);

$product_slider_effect_option = OptionFactory::create('product_slider_effect_id', 
	'product_slider_effect', 
	FieldType::$SELECT, 
	'pt-store', 
	'Select transition effect for Product Images Carousel', array(
		'requiered' => false,
		'description' => '',
		'options' => array(
			'fade' => 'Fade',
			'backSlide' => 'Back Slide',
			'goDown' => 'Go Down',
			'fadeUp' => 'Fade Up',
	)
), false);

$use_pt_shares_for_product_option = OptionFactory::create('use_pt_shares_for_product_id',
    'use_pt_shares_for_product',
    FieldType::$ONOFF,
    'pt-store',
    'Single product share buttons output switcher',
    array(
        'default' => 'on',
        'description' => ''
    ),
    false
);

$show_upsells_option = OptionFactory::create('show_upsells_id',
    'show_upsells',
    FieldType::$ONOFF,
    'pt-store',
    'Single product up-sells output switcher',
    array(
        'default' => 'on',
        'description' => ''
    ),
    false
);

$upsells_qty_option = OptionFactory::create('upsells_qty_id', 
	'upsells_qty', 
	FieldType::$SELECT, 
	'pt-store', 
	'Select how many Up-Sell Products to show on Single product page', array(
		'requiered' => false,
		'description' => '',
		'options' => array(
			'2' => '2 products',
			'3' => '3 products',
			'4' => '4 products',
			'5' => '5 products',
	)
), false);

$show_related_products_option = OptionFactory::create('show_related_products_id',
    'show_related_products',
    FieldType::$ONOFF,
    'pt-store',
    'Single product related products output switcher',
    array(
        'default' => 'on',
        'description' => ''
    ),
    false
);

$related_products_qty_option = OptionFactory::create('related_products_qty_id', 
	'related_products_qty', 
	FieldType::$SELECT, 
	'pt-store', 
	'Select how many Related Products to show on Single product page', array(
		'requiered' => false,
		'description' => '',
		'options' => array(
			'2' => '2 products',
			'3' => '3 products',
			'4' => '4 products',
			'5' => '5 products',
	)
), false);

$list_grid_switcher_option = OptionFactory::create('list_grid_switcher_id',
	'list_grid_switcher',
	FieldType::$ONOFF,
	'pt-store',
	'List/Grid products switcher',
		array(
		'default' => 'on',
		'description' => 'Switch to "Off" if you don&rsquo;t want to use switcher on products page'
	),
false);

$catalog_mode_option = OptionFactory::create('catalog_mode_id',
	'catalog_mode',
	FieldType::$ONOFF,
	'pt-store',
	'Catalog Mode switcher',
		array(
		'default' => 'off',
		'description' => 'Switch to "ON" if you want to switch your shop into a catalog mode (no prices, no "add to cart")'
	),
false);

$default_list_type_option = OptionFactory::create('default_list_type_id',
	'default_list_type',
	FieldType::$RADIOBUTTON,
	'pt-store',
	'Set default view for products (list or grid)',
	array(
		'required' => false,
		'default' => 'grid',
		'options' => array(
			'grid'  => 'Grid',
			'list' => 'List',
		)
), false);

$products_hover_animation_option = OptionFactory::create('products_hover_animation_id',
	'products_hover_animation',
	FieldType::$RADIOBUTTON,
	'pt-store',
	'Select animation for product on hover',
	array(
		'required' => false,
		'default' => 'fade-hover',
		'options' => array(
			'fade-hover'  => 'Fading',
			'slide-hover' => 'Sliding (works only on store page)',
		)
), false);

$filters_sidebar_option = OptionFactory::create('filters_sidebar_id',
	'filters_sidebar',
	FieldType::$ONOFF,
	'pt-store',
	'Add special sidebar for filters on Store page?',
		array(
		'default' => 'on',
		'description' => 'Switch to "Off" if you don&rsquo;t want to use special sidebar on products page'
	),
false);

$front_page_shop_option = OptionFactory::create('front_page_shop_id',
	'front_page_shop',
	FieldType::$ONOFF,
	'pt-store',
	'Store as Front page?',
		array(
		'default' => 'off',
		'description' => 'Switch to "On" if you want to display Store page on Front page. Don&rsquo;t forget to specify Products Page as static front page in WordPress "Reading Settings".'
	),
false);

$wcv_qty_option = OptionFactory::create('wcv_qty_id', 
	'wcv_qty', 
	FieldType::$SELECT, 
	'pt-store', 
	'Select how many Vendor Related Products to show on Single product page', array(
		'requiered' => false,
		'description' => '',
		'options' => array(
			'2' => '2 products',
			'3' => '3 products',
			'4' => '4 products',
			'5' => '5 products',
	)
), false);

$show_wcv_related_products_option = OptionFactory::create('show_wcv_related_products_id',
    'show_wcv_related_products',
    FieldType::$ONOFF,
    'pt-store',
    'Single product vendors related products output switcher',
    array(
        'default' => 'on',
        'description' => ''
    ),
    false
);

/*  Store Settings Output  */
$store_content = '<div class="wrapper container-fluid"><div class="row-fluid">'
.'<div class="span6">'
.'<h1 class="options-block">Shop parameters</h1>'
.'<div class="options-block">'
.$catalog_mode_option
.$cart_count
.$store_breadcrumbs_option
.$products_hover_animation_option
.$filters_sidebar_option
.$front_page_shop_option
.'<h2>Shop Page template options</h2>'
.$store_per_page_option
.$store_columns_option
.$list_grid_switcher_option
.$default_list_type_option
.'</div>'
.'</div>'
.'<div class="span6">'
.'<h1 class="options-block">Single Product template options</h1>'
.'<div class="options-block">'
.$use_pt_shares_for_product_option
.$product_pagination_option
.'<h2>Product Images Slider</h2>'
.$use_pt_images_slider_option
.$product_slider_type_option
.$product_slider_effect_option
.'<h2>Up-Sells & Related Products</h2>'
.$show_upsells_option
.$upsells_qty_option
.$show_related_products_option
.$related_products_qty_option
.'<h2>WC Vendor Related Products</h2>'
.$show_wcv_related_products_option
.$wcv_qty_option
.'</div>'
.'</div>'
.'</div></div>';


$pt_global->setContent($global_content);
$pt_layout->setContent($layout_content);
$pt_typography->setContent($typography_content);
$pt_blog->setContent($blog_content);
$pt_store->setContent($store_content);

