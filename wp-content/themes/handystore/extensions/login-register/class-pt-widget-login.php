<?php
/**
 * Plumtree AJAX Login/Register
 *
 * Login/Register widget with AJAX.
 *
 * @author StartBox Extended By TransparentIdeas
 * @package StartBox
 * @subpackage Widgets
 * @since 0.01
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'widgets_init', create_function( '', 'register_widget( "pt_login_widget");' ) );

class pt_login_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
	 		'pt_login_widget', // Base ID
			__('PT Login/Register', 'plumtree'), // Name
			array('description' => __( "Plum Tree special widget. An AJAX Login/Register form for your site.", 'plumtree' ), ) 
		);
	}

	public function form($instance) {
		$defaults = array(
			'title' => 'Log In',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title: ', 'plumtree' ) ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

	<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	public function widget($args, $instance) {
		extract($args);

		$title = apply_filters('widget_title', $instance['title'] );

		echo $before_widget;
		if ($title) { echo $before_title . $title . $after_title; }
	?>

	<?php if ( is_user_logged_in() ) { ?>
		<p class="logged-in-as">
			<?php $current_user = wp_get_current_user(); ?>
            <?php printf( __( 'Hello <strong>%1$s</strong>.', 'plumtree' ), 
                            $current_user->display_name); ?>
        </p>
        <a class="login_button" href="<?php echo wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ); ?>" title="<?php _e('Log out of this account', 'plumtree');?>"><?php _e('Log out', 'plumtree');?><i class="fa fa-angle-right"></i></a>
		<?php if ( class_exists('Woocommerce') ) : ?>
 			<a class="login_button" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','plumtree'); ?>"><?php _e('My Account','plumtree'); ?><i class="fa fa-angle-right"></i></a>
 		<?php endif; ?>
 	<?php } else { ?>

		<form id="login" class="ajax-auth" action="login" method="post">
		    <h3><?php _e('New to site? ', 'plumtree');?><a id="pop_signup" href=""><?php _e('Create an Account', 'plumtree');?></a></h3>
		    <h1><?php _e('Login', 'plumtree');?></h1>
		    <p class="status"></p>  
		    <?php wp_nonce_field('ajax-login-nonce', 'security'); ?>  
		    <label for="username"><?php _e('Username', 'plumtree');?><span class="required">*</span></label>
		    <input id="username" type="text" class="required" name="username">
		    <label for="password"><?php _e('Password', 'plumtree');?><span class="required">*</span></label>
		    <input id="password" type="password" class="required" name="password">
		    <a class="text-link" href="<?php echo wp_lostpassword_url(); ?>"><?php _e('Lost password?', 'plumtree');?></a>
		    <input class="submit_button" type="submit" value="LOGIN">
			<a class="close" href=""><?php _e('(close)', 'plumtree');?></a>    
		</form>

		<form id="register" class="ajax-auth"  action="register" method="post">
			<h3><?php _e('Already have an account? ', 'plumtree');?><a id="pop_login"  href=""><?php _e('Login', 'plumtree');?></a></h3>
		    <h1><?php _e('Signup', 'plumtree');?></h1>
		    <p class="status"></p>
		    <?php wp_nonce_field('ajax-register-nonce', 'signonsecurity'); ?>         
		    <label for="signonname"><?php _e('Username', 'plumtree');?><span class="required">*</span></label>
		    <input id="signonname" type="text" name="signonname" class="required">
		    <label for="email"><?php _e('Email', 'plumtree');?><span class="required">*</span></label>
		    <input id="email" type="text" class="required email" name="email">
		    <label for="signonpassword"><?php _e('Password', 'plumtree');?><span class="required">*</span></label>
		    <input id="signonpassword" type="password" class="required" name="signonpassword" >
		    <label for="password2"><?php _e('Confirm Password', 'plumtree');?><span class="required">*</span></label>
		    <input type="password" id="password2" class="required" name="password2">
		    <input class="submit_button" type="submit" value="SIGNUP">
		    <a class="close" href=""><?php _e('(close)', 'plumtree');?></a>    
		</form>

		<p class="welcome-msg">
            <?php _e( 'Welcome to our store!', 'plumtree' ); ?>
        </p>
        <a class="login_button" id="show_login" href=""><?php _e('Login', 'plumtree'); ?><i class="fa fa-angle-right"></i></a>
        <a class="login_button" id="show_signup" href=""><?php _e('Register', 'plumtree'); ?><i class="fa fa-angle-right"></i></a>
	<?php } ?>

	<?php
		echo $after_widget;
	}

}