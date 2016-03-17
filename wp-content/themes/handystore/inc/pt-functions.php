<?php /*-------Plumtree Theme Functions----------*/

/* Contents:
	1. Replaces the excerpt "more" text
	2. Plumtree custom media fields function
	3. Plumtree Meta output functions
	4. Plumtree Views counter function
	5. Plumtree Fix captions width function
	6. Plumtree Adding inline CSS styles
	7. Theme url functions
	8. Plumtree get attached images
	9. Frontpage Shortcode section
	10. Adding new social links to user profile
	11. Custom comments walker
	12. Custom comment form
	13. Maintenance Mode function
	14. Add favicon function
	15. Add Google Analytics function
	16. Scroll to top button
	17. Shema Mark-up
	18. WC Vendors functions
 */


// ----- Replaces the excerpt "more" text
if ( ! function_exists( 'pt_excerpt_more' ) ) {
	function pt_excerpt_more() {
		if ( !get_option('blog_read_more_text')=='') {
			return get_option('blog_read_more_text');
		} else { return __('Read More', 'plumtree'); }
	}
}
add_filter('pt_more', 'pt_excerpt_more');


// ----- Plumtree custom media fields function
if ( ! function_exists( 'pt_custom_media_fields' ) ) {
	function pt_custom_media_fields( $form_fields, $post ) {

		$form_fields['portfolio_filter'] = array(
			'label' => 'Portfolio Filters',
			'input' => 'text',
			'value' => get_post_meta( $post->ID, 'portfolio_filter', true ),
			'helps' => __('Used only for Portfolio and Gallery Pages Isotope filtering', 'plumtree'),
		);

		return $form_fields;
	}
}
add_filter( 'attachment_fields_to_edit', 'pt_custom_media_fields', 10, 2 );

if ( ! function_exists( 'pt_custom_media_fields_save' ) ) {
	function pt_custom_media_fields_save( $post, $attachment ) {

		if( isset( $attachment['portfolio_filter'] ) )
			update_post_meta( $post['ID'], 'portfolio_filter', $attachment['portfolio_filter'] );

		if( isset( $attachment['hover_style'] ) )
			update_post_meta( $post['ID'], 'hover_style', $attachment['hover_style'] );

		return $post;
	}
}
add_filter( 'attachment_fields_to_save', 'pt_custom_media_fields_save', 10, 2 );


// ----- Plumtree Meta output functions
if ( ! function_exists( 'pt_entry_publication_time' ) ) {
	function pt_entry_publication_time() {
	    $date = sprintf( '<time class="entry-date" datetime="%1$s" itemprop="datePublished">%2$s&nbsp;%3$s,&nbsp;%4$s</time>',
	      esc_attr( get_the_date('c') ),
	      esc_html( get_the_date('M') ),
	      esc_html( get_the_date('j') ),
	      esc_html( get_the_date('Y') )
	    );
	    echo '<div class="time-wrapper">'.__('Posted ', 'plumtree').$date.'</div>';
	}
}

if ( ! function_exists( 'pt_entry_comments_counter' ) ) {
	function pt_entry_comments_counter() {
	    echo '<div class="post-comments" itemprop="interactionCount"><i class="fa fa-comments"></i>(';
	    comments_popup_link( '0', '1', '%', 'comments-link', __('Commenting: OFF', 'plumtree'));
	    echo ')</div>';
	}
}

if ( ! function_exists( 'pt_entry_post_cats' ) ) {
	function pt_entry_post_cats() {
	    $categories_list = get_the_category_list( __( ', ', 'plumtree' ) );
	    if ( $categories_list ) { echo '<div class="post-cats" itemprop="articleSection">'.__('In ', 'plumtree').$categories_list.'</div>'; }
	}
}

if ( ! function_exists( 'pt_entry_post_tags' ) ) {
	function pt_entry_post_tags() {
	    $tag_list = get_the_tag_list( '', __( ', ', 'plumtree' ) );
	    if ( $tag_list ) { echo '<div class="post-tags">'.__('Tagged with ', 'plumtree').$tag_list.'</div>'; }
	}
}

if ( ! function_exists( 'pt_entry_author' ) ) {
	function pt_entry_author() {
	    printf( '<div class="post-author" itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person">By <a href="%1$s" title="%2$s" rel="author" itemprop="url"><span itemprop="name">%3$s</span></a></div>',
	      esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
	      esc_attr( sprintf( __( 'View all posts by %s', 'plumtree' ), get_the_author() ) ),
	      get_the_author()
	    );
	}
}

if ( ! function_exists( 'pt_entry_post_views' ) ) {
	function pt_entry_post_views() {
	    global $post;
	    $views = get_post_meta ($post->ID,'views',true);
	    if ($views) {
	        echo '<div class="post-views"><span>'.__('Views: ', 'plumtree').'</span><i class="fa fa-eye"></i>('.$views.')</div>';
	    } else { echo '<div class="post-views"><span>'.__('Views: ', 'plumtree').'</span><i class="fa fa-eye"></i>(0)</div>'; }
	}
}

// ----- Plumtree Views counter function
if ( ! function_exists( 'pt_postviews' ) ) {
    function pt_postviews() {

    /* ------------ Settings -------------- */
    $meta_key       = 'views';  	// The meta key field, which will record the number of views.
    $who_count      = 0;            // Whose visit to count? 0 - All of them. 1 - Only the guests. 2 - Only registred users.
    $exclude_bots   = 1;            // Exclude bots, robots, spiders, and other mischief? 0 - no. 1 - yes.

    global $user_ID, $post;
        if(is_singular()) {
            $id = (int)$post->ID;
            static $post_views = false;
            if($post_views) return true;
            $post_views = (int)get_post_meta($id,$meta_key, true);
            $should_count = false;
            switch( (int)$who_count ) {
                case 0: $should_count = true;
                    break;
                case 1:
                    if( (int)$user_ID == 0 )
                        $should_count = true;
                    break;
                case 2:
                    if( (int)$user_ID > 0 )
                        $should_count = true;
                    break;
            }
            if( (int)$exclude_bots==1 && $should_count ){
                $useragent = $_SERVER['HTTP_USER_AGENT'];
                $notbot = "Mozilla|Opera"; //Chrome|Safari|Firefox|Netscape - all equals Mozilla
                $bot = "Bot/|robot|Slurp/|yahoo";
                if ( !preg_match("/$notbot/i", $useragent) || preg_match("!$bot!i", $useragent) )
                    $should_count = false;
            }
            if($should_count)
                if( !update_post_meta($id, $meta_key, ($post_views+1)) ) add_post_meta($id, $meta_key, 1, true);
        }
        return true;
    }
}
add_action('wp_head', 'pt_postviews');


// ----- Plumtree Fix captions width function
if ( ! function_exists( 'pt_fixed_caption_width' ) ) {
	function pt_fixed_caption_width($attr, $content = null) {
		// New-style shortcode with the caption inside the shortcode with the link and image tags.
		if ( ! isset( $attr['caption'] ) ) {
			if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
				$content = $matches[1];
				$attr['caption'] = trim( $matches[2] );
			}
		}
		// Allow plugins/themes to override the default caption template.
		$output = apply_filters('img_caption_shortcode', '', $attr, $content);
		if ( $output != '' )
			return $output;

		extract(shortcode_atts(array(
			'id'	=> '',
			'align'	=> 'alignnone',
			'width'	=> '',
			'caption' => ''
		), $attr));

		if ( 1 > (int) $width || empty($caption) )
			return $content;

		if ( $id ) $id = 'id="' . esc_attr($id) . '" ';

		return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: ' . esc_attr($width) . 'px">'
		. do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
	}
}
add_shortcode('wp_caption', 'pt_fixed_caption_width');
add_shortcode('caption', 'pt_fixed_caption_width');


// ----- Plumtree Adding inline CSS styles
if ( !function_exists( 'pt_add_inline_styles' ) && get_option('site_custom_colors') == 'on' ) {

	function pt_add_inline_styles() {

		/* Variables */
		$main_font_color = esc_attr(get_option('main_color'));
		$footer_font_color = esc_attr(get_option('footer_color'));
		$content_headings_color = esc_attr(get_option('headings_content'));
		$sidebar_headings_color = esc_attr(get_option('headings_sidebar'));
		$footer_headings_color = esc_attr(get_option('headings_footer'));
		$link_color = esc_attr(get_option('link_color'));
		$link_hover_color = esc_attr(get_option('link_color_hover'));
		$button_color = esc_attr(get_option('button_color'));
		$button_hover_color = esc_attr(get_option('button_color_hover'));
		$button_text_color = esc_attr(get_option('button_color_text'));
		$button_font = esc_attr(get_option('button_font'));
		$button_font = str_replace('_' , ' ', $button_font );
		$main_font = esc_attr(get_option('main_font'));
		$main_font = str_replace('_' , ' ', $main_font );
		$heading_font = esc_attr(get_option('heading_font'));
		$heading_font = str_replace('_' , ' ', $heading_font );

		$out = '<style type="text/css">
				body {
					color: '.$main_font_color.';
					font-family: "'.$main_font.'", sans-serif;
				}
				.widget {
					color: '.$main_font_color.';
				}
				.site-content a,
				.sidebar a {
					color: '.$link_color.' !important;
				}
				.site-content a:hover,
				.site-content a:focus,
				.site-content a:active,
				.sidebar a:hover,
				.sidebar a:focus,
				.sidebar a:active,
				.site-footer a:hover,
				.site-footer a:focus,
				.site-footer a:active {
					color: '.$link_hover_color.' !important;
				}
				.entry-content h1,
				.entry-content h2,
				.entry-content h3,
				.entry-content h4,
				.entry-content h5,
				.entry-content h6 {
					color: '.$content_headings_color.' !important;
					font-family: "'.$heading_font.'", sans-serif !important;
				}
				.sidebar h1,
				.sidebar h2,
				.sidebar h3,
				.sidebar h4,
				.sidebar h5,
				.sidebar h6 {
					color: '.$sidebar_headings_color.' !important;
					font-family: "'.$heading_font.'", sans-serif !important;
				}
				.site-footer {
					color: '.$footer_font_color.';
				}
				.site-footer a {
					color: '.$footer_font_color.' !important;
				}
				.site-footer h1,
				.site-footer h2,
				.site-footer h3,
				.site-footer h4,
				.site-footer h5,
				.site-footer h6 {
					color: '.$footer_headings_color.' !important;
					font-family: "'.$heading_font.'", sans-serif !important;
				}
				.btn-default,
				button,
				input[type="button"],
				input[type="reset"],
				input[type="submit"],
				.button,
				a.button {
					background: '.$button_color.' !important;
					color: '.$button_text_color.' !important;
					font-family: "'.$button_font.'", sans-serif !important;
				}
				.btn-default:hover,
				button:hover,
				input[type="button"]:hover,
				input[type="reset"]:hover,
				input[type="submit"]:hover,
				.button:hover,
				a.button:hover {
					background: '.$button_hover_color.' !important;
					color: '.$button_text_color.' !important;
				}
				</style>';
		echo $out;
	}
}

if ( get_option('site_custom_colors') == 'on' ) {
	add_action ( 'wp_head', 'pt_add_inline_styles' );
}


// ----- Theme url functions
if ( ! function_exists( 'themes_url' ) ) {
	function themes_url($path = '', $plugin = '') {

	    $mu_plugin_dir = get_stylesheet_directory_uri();
	    foreach ( array('path', 'plugin', 'mu_plugin_dir') as $var ) {
	        $$var = str_replace('\\' ,'/', $$var); // sanitize for Win32 installs
	        $$var = preg_replace('|/+|', '/', $$var);
	    }

	    if ( !empty($plugin) && 0 === strpos($plugin, $mu_plugin_dir) )
	        $url = get_stylesheet_directory_uri();
	    else
	        $url = get_stylesheet_directory_uri();


	    $url = set_url_scheme( $url );

	    if ( !empty($plugin) && is_string($plugin) ) {
	        $folder = dirname(theme_basename($plugin));

	        if ( '.' != $folder )
	            $url .= '/' . ltrim($folder, '/');
	    }

	    if ( $path && is_string( $path ) )
	        $url .= '/' . ltrim($path, '/');

	    return apply_filters( 'plugins_url', $url, $path, $plugin );
	}
}

if ( ! function_exists( 'theme_basename' ) ) {
	function theme_basename( $file ) {
	    global $wp_plugin_paths;

	    foreach ( $wp_plugin_paths as $dir => $realdir ) {
	        if ( strpos( $file, $realdir ) === 0 ) {
	            $file = $dir . substr( $file, strlen( $realdir ) );
	        }
	    }

	    $file = wp_normalize_path( $file );
	    $plugin_dir = wp_normalize_path( get_template_directory() );
	    $mu_plugin_dir = wp_normalize_path( get_template_directory() );

	    $file = preg_replace('#^' . preg_quote($plugin_dir, '#') . '/|^' . preg_quote($mu_plugin_dir, '#') . '/#','',$file); // get relative path from plugins dir

	    $file = trim($file, '/');
	    return $file;
	}
}

if ( ! function_exists( 'theme_dir_url' ) ) {
	function theme_dir_url( $file ) {
	    return trailingslashit( themes_url( '', $file ) );
	}
}


// ----- Plumtree get attached images
if ( ! function_exists( 'pt_attached_image' ) ) {
	function pt_attached_image() {
		$post                = get_post();
		$attachment_size     = apply_filters( 'twentyfourteen_attachment_size', array( 810, 810 ) );
		$next_attachment_url = wp_get_attachment_url();

		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => -1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID',
		) );

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {
			foreach ( $attachment_ids as $attachment_id ) {
				if ( $attachment_id == $post->ID ) {
					$next_id = current( $attachment_ids );
					break;
				}
			}

			// get the URL of the next image attachment...
			if ( $next_id ) {
				$next_attachment_url = get_attachment_link( $next_id );
			}

			// or get the URL of the first image attachment.
			else {
				$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
			}
		}

		printf( '<a href="%1$s" rel="attachment">%2$s</a>',
			esc_url( $next_attachment_url ),
			wp_get_attachment_image( $post->ID, $attachment_size, false, array('itemprop' => 'thumbnail') )
		);
	}
}


// ----- Frontpage Shortcode section
if ( ! function_exists( 'pt_front_shortcode_section' ) ) {
	function pt_front_shortcode_section() {
		// Check if site turned to boxed version
		$boxed = ''; $boxed_element = ''; $row_class = '';
		if (get_option('site_layout')=='boxed') {$boxed = 'container'; $boxed_element = 'col-md-12 col-sm-12'; $row_class = 'row';}
		// Variables
		$shortcode = get_option('front_page_shortcode_section_shortcode');
		?>

		<div class="front-page-shortcode">
			<?php echo do_shortcode( $shortcode ) ?>
		</div>
	<?php }
}


// ----- Footer Shortcode section
if ( ! function_exists( 'pt_shortcode_section' ) ) {
	function pt_shortcode_section() {
		// Check if site turned to boxed version
		$boxed = ''; $boxed_element = ''; $row_class = '';
		if (get_option('site_layout')=='boxed') {$boxed = 'container'; $boxed_element = 'col-md-12 col-sm-12'; $row_class = 'row';}
		// Variables
		$shortcode = get_option('shortcode_section_shortcode');
		$background = 'style="background-repeat: repeat;';
		if ( get_option('shortcode_section_bg_image') && get_option('shortcode_section_bg_image')!='' ) {
			$background .= ' background-image: url('.get_option('shortcode_section_bg_image').');';
		}
		if ( get_option('shortcode_section_bg_color') && get_option('shortcode_section_bg_color')!='' ) {
			$background .= ' background-color: '.get_option('shortcode_section_bg_color').';';
		}
		$background .= '"';
		?>

		<div class="footer-shortcode" <?php echo $background;?>>
			<?php if (!$boxed || $boxed=='') : ?><div class="container"><?php endif; ?>
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<?php echo do_shortcode( $shortcode ) ?>
					</div>
				</div>
		<?php if (!$boxed || $boxed=='') : ?></div><?php endif; ?>
		</div>

	<?php }
}


// ----- Adding new social links to user profile
if ( ! function_exists( 'pt_new_author_contacts' ) ) {
	function pt_new_author_contacts( $contactmethods ) {
	  // Add Twitter
	  if ( !isset( $contactmethods['twitter'] ) )
	    $contactmethods['twitter'] = 'Twitter';

	  // Add Google Plus
	  if ( !isset( $contactmethods['googleplus'] ) )
	    $contactmethods['googleplus'] = 'Google Plus';

	  // Add Facebook
	  if ( !isset( $contactmethods['facebook'] ) )
	    $contactmethods['facebook'] = 'Facebook';

	  return $contactmethods;
	}
}
add_filter( 'user_contactmethods', 'pt_new_author_contacts', 10, 1 );

if ( ! function_exists( 'pt_output_author_contacts' ) ) {
	function pt_output_author_contacts() {
	    global $post;
	    $twitter = get_the_author_meta( 'twitter', $post->post_author );
	    $facebook = get_the_author_meta( 'facebook', $post->post_author );
	    $googleplus = get_the_author_meta( 'googleplus', $post->post_author );

	    if (isset($facebook) || isset($twitter) || isset($googleplus)) { ?>
	       <div class="author-contacts">
	    <?php }

	    if (isset($twitter)) echo '<a href="'.esc_url($twitter).'" rel="author" target="_blank"><i class="fa fa-twitter-square"></i></a>';
	    if (isset($facebook)) echo '<a href="'.esc_url($facebook).'" rel="author" target="_blank"><i class="fa fa-facebook-square"></i></a>';
	    if (isset($googleplus)) echo '<a href="'.esc_url($googleplus).'" rel="author" target="_blank"><i class="fa fa-google-plus-square"></i></a>';

	    if (isset($facebook) || isset($twitter) || isset($googleplus)) { ?>
	       </div>
	    <?php }
	}
}


// ----- Custom comments walker
if ( ! class_exists('pt_comments_walker')) {
	class pt_comments_walker extends Walker_Comment {
	    var $tree_type = 'comment';
	    var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

	    // wrapper for child comments list
	    function start_lvl( &$output, $depth = 0, $args = array() ) {
	        $GLOBALS['comment_depth'] = $depth + 1; ?>
	        <section class="child-comments comments-list">
	    <?php }

	    // closing wrapper for child comments list
	    function end_lvl( &$output, $depth = 0, $args = array() ) {
	        $GLOBALS['comment_depth'] = $depth + 1; ?>
	        </section>
	    <?php }

	    // HTML for comment template
	    function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
	        $depth++;
	        $GLOBALS['comment_depth'] = $depth;
	        $GLOBALS['comment'] = $comment;
	        $parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' );
	        if ( 'article' == $args['style'] ) {
	            $add_below = 'comment';
	        } else {
	            $add_below = 'comment';
	        } ?>

	    <article <?php comment_class(empty( $args['has_children'] ) ? '' :'parent') ?> id="comment-<?php comment_ID() ?>" itemprop="comment" itemscope="itemscope" itemtype="http://schema.org/UserComments">
	        <figure class="gravatar"><?php echo get_avatar( $comment, 70, '', "Author's gravatar" ); ?></figure>

	        <div class="comment-meta" role="complementary">
	            <h2 class="comment-author" itemprop="creator" itemscope="itemscope" itemtype="http://schema.org/Person">
	                <?php _e('Posted by ', 'plumtree'); ?>
	                <?php if (get_comment_author_url() != '') { ?>
	                    <a class="comment-author-link" href="<?php esc_url(comment_author_url()); ?>" itemprop="url"><span itemprop="name"><?php comment_author(); ?></span></a>
	                <?php } else { ?>
	                    <span class="author" itemprop="name"><?php comment_author(); ?></span>
	                <?php } ?>
	            </h2>
	            <?php _e(' on ', 'plumtree'); ?>
	            <time class="comment-meta-time" datetime="<?php comment_date() ?>T<?php comment_time() ?>" itemprop="commentTime"><?php comment_date() ?><?php _e(', at ', 'plumtree');?><a href="#comment-<?php comment_ID() ?>" itemprop="url"><?php comment_time() ?></a></time>
	            <?php edit_comment_link('Edit','',''); ?>
	            <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	        </div>

	        <?php if ($comment->comment_approved == '0') : ?>
	            <p class="comment-meta-item"><?php _e("Your comment is awaiting moderation.", "plumtree") ?></php></p>
	        <?php endif; ?>

	        <div class="comment-content post-content" itemprop="commentText">
	            <?php comment_text() ?>
	        </div>

	    <?php }
	    // end_el – closing HTML for comment template
	    function end_el( &$output, $comment, $depth = 0, $args = array() ) { ?>
	        </article>
	    <?php }
	}
}


// ----- Custom comment form
if ( ! function_exists( 'pt_comment_form' ) ) {
	function pt_comment_form() {

	    $commenter = wp_get_current_commenter();
	    $req = get_option( 'require_name_email' );
	    $aria_req = ( $req ? " aria-required='true'" : '' );
	    $user = wp_get_current_user();
	    $user_identity = $user->exists() ? $user->display_name : '';

	    $custom_args = array(
	        'id_form'           => 'commentform',
	        'id_submit'         => 'submit',
	        'title_reply'       => __( 'Leave Your Comment', 'plumtree' ),
	        'title_reply_to'    => __( 'Leave Your Comment to %s', 'plumtree' ),
	        'cancel_reply_link' => __( 'Cancel Reply', 'plumtree' ),
	        'label_submit'      => __( 'Submit Comment', 'plumtree' ),

	        'comment_field' =>  '<p class="comment-form-comment">
	                             <label for="comment">'._x( 'Comment', 'plumtree' ).'</label>
	                             <textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" aria-describedby="form-allowed-tags" placeholder="'.__('Comment:', 'plumtree').'"></textarea>
	                             </p>',

	        'must_log_in' => '<p class="must-log-in">'.
	                          sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'plumtree' ), wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ).
	                         '</p>',

	        'logged_in_as' => '<p class="logged-in-as">'.
	                           sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'plumtree' ),
	                            admin_url( 'profile.php' ),
	                            $user_identity,
	                            wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ).
	                          '</p>',

	        'comment_notes_before' => false,

	        'comment_notes_after' => false,

	        'fields' => apply_filters( 'comment_form_default_fields', array(
	            'author' =>
	                        '<p class="comment-form-author">
	                        <label for="author">'. __( 'Name', 'plumtree' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label>
	                        <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" aria-required="true" placeholder="' . ( $req ? __( 'Name (required):', 'plumtree' ) : __( 'Name:', 'plumtree' ) ) . '" />
	                        </p>',

	            'email' =>
	                        '<p class="comment-form-email">
	                        <label for="email">'. __( 'E-mail', 'plumtree' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label>
	                        <input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" aria-required="true" aria-describedby="email-notes" placeholder="' . ( $req ? __( 'E-mail (will not be published, required):', 'plumtree' ) : __( 'E-mail (will not be published):', 'plumtree' ) ) . '" />
	                        </p>',

	            'url' =>
	                        '<p class="comment-form-url">
	                        <label for="url">'. __( 'Website', 'plumtree' ) . '</label>
	                        <input id="url" name="url" type="text" value="' . esc_url( $commenter['comment_author_url'] ) . '" placeholder="' . __( 'Website:', 'plumtree' ) . '" />
	                        </p>',
	        )),
	    );
	    comment_form( $custom_args );
	}
}


// ----- Maintenance Mode function
$maintenance_mode = (get_option('site_maintenance_mode') != '') ? get_option('site_maintenance_mode') : 'off';
if ( $maintenance_mode=='on' || ( isset($_GET['MAINTENANCE'] ) && $_GET['MAINTENANCE'] == 'true' ) ) {
	define('PT_IN_MAINTENANCE', true);
} else {
	define('PT_IN_MAINTENANCE', false);
}

if ( ! function_exists( 'pt_maintenance' ) ) {
	function pt_maintenance(){
	    global $pagenow;
	    if(
	       defined('PT_IN_MAINTENANCE')
	       && PT_IN_MAINTENANCE
	       && $pagenow !== 'wp-login.php'
	       && ! is_user_logged_in() ) {
	       		$protocol = "HTTP/1.0";
				if ( "HTTP/1.1" == $_SERVER["SERVER_PROTOCOL"] ) {
					$protocol = "HTTP/1.1";
				}
			    header( "$protocol 503 Service Unavailable", true, 503 );
			    header( "Retry-After: 3600" );
			    header( "Content-Type: text/html; charset=utf-8" );

		    	require_once('pt-maintenance.php');
		    	die();
	    }
	    return false;
	}
}
add_action('wp_loaded', 'pt_maintenance');


// ----- Add favicon function
if (get_option('site_favicon') && get_option('site_favicon')!='') {
	if ( ! function_exists( 'pt_favicon' ) ) {
		function pt_favicon() { ?>
			<link rel="shortcut icon" href="<?php echo esc_url( get_option('site_favicon') );?>" >
		<?php }
	}
	add_action('wp_head', 'pt_favicon');
}


// ----- Add Google Analytics function
if (get_option('google_code') && get_option('google_code')!='') {
	if ( ! function_exists( 'pt_add_google_analytics' ) ) {
		function pt_add_google_analytics() { 
			echo get_option('google_code');
		}
	}
	add_action('wp_footer', 'pt_add_google_analytics');
}


// ----- Scroll to top button
if (get_option('totop_button') == 'on') {
	if ( ! function_exists( 'pt_add_totop_button' ) ) {
		function pt_add_totop_button() { 
			echo '<a href="#0" class="to-top" title="'.__('Back To Top', 'plumtree').'"><i class="fa fa-chevron-up"></i></a>';
		}
	}
	add_action('wp_footer', 'pt_add_totop_button');
}


// ----- Shema mark-up
// Shema mark-up for post thumbnail
if ( ! function_exists( 'pt_post_thumbnail_html' ) ) {
	function pt_post_thumbnail_html($html, $post_id, $post_thumbnail_id, $size, $attr) {
	    $src = wp_get_attachment_image_src(get_post_thumbnail_id(), $size);
	    $alt_text = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
	    if( !count($alt_text) ) { $alt_text = ''; }
	    if ( get_post_type($post_id) != 'product') {
	    	$html = '<img itemprop="image" alt="'.esc_attr($alt_text).'" src="' . esc_url($src['0']) . '" class="attachment-post-thumbnail wp-post-image" />';
	    }
	    return $html;
	}
	add_filter('post_thumbnail_html', 'pt_post_thumbnail_html', 99, 5);
}

// Adding itemprop to all nav menus
if (!function_exists('pt_add_itemprop')) {
	function pt_add_itemprop( $atts, $item, $args ) {
	    $atts['itemprop'] = 'url';
	    return $atts;
	}
	add_filter('nav_menu_link_attributes', 'pt_add_itemprop', 10, 3);
}

