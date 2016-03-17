<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

		<h2 class="comments-title" itemprop="interactionCount">
			<?php
				printf( _n( 'There Is %1$s Comment', 'There Are %1$s Comments', get_comments_number(), 'plumtree' ),
					number_format_i18n( get_comments_number() ) );
			?>
		</h2>

		<section class="comments-list">
			<?php wp_list_comments( array('walker' => new pt_comments_walker() ) ); ?>
		</section>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<?php $comment_navi_type = (get_option('comments_pagination')) ? esc_html(get_option('comments_pagination')) : 'numeric';
				  pt_comments_nav( $comment_navi_type ); ?>
		<?php endif; // Check for comment navigation. ?>

		<?php if ( ! comments_open() ) : ?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'plumtree' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php if (function_exists('pt_comment_form')) { pt_comment_form(); } 
		  else { comment_form(); } ?>

</div><!-- #comments -->
