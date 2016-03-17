<?php
/**
 * The template for displaying posts in the Gallery post format
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

/* Add responsive bootstrap classes */
$classes = array();
if ( (get_option('blog_frontend_layout')=='grid' || get_option('blog_frontend_layout')=='isotope') && !is_single() && !is_search() ) {

	$blog_cols = esc_attr(get_option('blog_grid_columns'));
	$classes = array();

	switch ($blog_cols) {
		case 'cols-2':
			$classes[] = 'col-md-6 col-sm-12 col-xs-12';
		break;
		case 'cols-3':
			$classes[] = 'col-md-4 col-sm-6 col-xs-12';
		break;
		case 'cols-4':
			$classes[] = 'col-lg-3 col-md-4 col-sm-6 col-xs-12';
		break;
	}
}
/* Live preview */
if( isset( $_GET['b_type'] ) ){ 
	$classes = array();
	$blog_type = esc_attr($_GET['b_type']);
	switch ($blog_type) {
		case '2cols':
			$classes[] = 'col-md-6 col-sm-12 col-xs-12';
		break;
		case '3cols':
			$classes[] = 'col-md-4 col-sm-6 col-xs-12';
		break;
		case 'filters':
			$classes[] = 'col-md-4 col-sm-6 col-xs-12';
		break;
		case '4cols':
			$classes[] = 'col-lg-3 col-md-4 col-sm-6 col-xs-12';
		break;
	}
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?> itemscope="itemscope" itemtype="http://schema.org/Article">

	<?php // Carousel for Blog Page
	if ( get_option('show_gallery_carousel')=='on' && !is_single() && get_post_gallery()) : 

		//$images = get_post_gallery( get_the_ID(), false );
		$count = 0;
		$gallery_type = esc_attr((get_option('gallery_carousel_type') == '' ? 'paginated' : get_option('gallery_carousel_type')));
		$transition_type = esc_attr((get_option('gallery_carousel_effect') != '') ? get_option('gallery_carousel_effect') : 'fade');

		switch ($gallery_type) {
			case 'paginated':
				$extra_class = 'paginated';
				$extra_count = 5;
				$owl_type = 'simple';
			break;
			case 'with-thumbs':
				$extra_class = 'with-icons';
				$extra_count = 3;
				$owl_type = 'with-icons';
			break;
		}

		if ( get_post_gallery() ) {

			$gallery = get_post_gallery( get_the_ID(), false );
			$img_ids = isset($gallery['ids'])? $gallery['ids'] : 0;
			$img_ids_array = explode(",", $img_ids);?>

			<div class="entry-carousel">

			<div class="blog-gallery <?php echo esc_attr($extra_class); ?>"
						data-owl="container" 
						data-owl-slides="1" 
						data-owl-type="<?php echo esc_attr($owl_type); ?>"
						data-owl-navi="false" 
						data-owl-pagi="true" 
						data-owl-transition="<?php echo esc_attr($transition_type); ?>">

			<?php foreach( $img_ids_array as $img_id ) :
				if ($count > $extra_count) {
					continue;
				}?>
				<div class="slide">
					<?php echo wp_get_attachment_image( $img_id, 'blog-featured-image-thumb', false, array('itemprop' => 'thumbnail') ); ?>
				</div>
				<?php $count++;
			endforeach;?>

			</div></div>
		<?php }

	endif;
?>	
	<section class="content-wrapper" role="main">

		<header class="entry-header">
			<?php
				if ( is_single() ) :
					the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
				else :
					the_title( '<h1 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url">', '</a></h1>' );
				endif;
			?>
		</header><!-- .entry-header -->

		<div class="entry-meta">
			<?php pt_entry_author(); ?>
			<?php pt_entry_post_cats(); ?>
			<?php pt_entry_publication_time()?>
			<?php edit_post_link( __( 'Edit', 'plumtree' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->

		<div class="entry-content" itemprop="articleBody">
			<?php 
			if ( get_option('show_gallery_carousel')=='on' && !is_single() && get_post_gallery()) { 
				global $post;
				echo strip_shortcodes($post->post_content); 
			} else {
				the_content( apply_filters( 'pt_more', __('Continue Reading...', 'plumtree')) );
			} 
			?>
				
			<?php wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'plumtree' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
			) ); ?>
		</div><!-- .entry-content -->

		<?php if ( !is_single() ) : ?>
			<div class="entry-additional-meta">
				<?php if ( ! post_password_required() ) { pt_entry_comments_counter(); } ?>
				<?php if (function_exists('pt_get_likes_counter')) {
					echo pt_get_likes_counter(get_the_ID());
				} ?>
			</div>
		<?php endif; ?>
		
		<?php if ( is_single() ) : ?>
			<div class="entry-meta-bottom">
				<?php if ( function_exists( 'pt_entry_post_tags' ) ) { pt_entry_post_tags(); } ?>
				<?php if ( function_exists( 'pt_share_buttons_output' ) && get_option('blog_share_buttons')=='on' ) { pt_share_buttons_output(); } ?>
				<?php if ( function_exists( 'pt_entry_post_views' ) ) { pt_entry_post_views(); } ?>
				<?php if ( function_exists( 'pt_output_like_button' ) ) { pt_output_like_button( get_the_ID() ); } ?>
			</div>

			<?php if ( get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
				<?php get_template_part( 'author-bio' ); ?>
			<?php endif; ?>
		<?php endif; ?>

	</section>

</article><!-- #post-## -->
