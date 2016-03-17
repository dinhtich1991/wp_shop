<?php
/**
 * The template for displaying image attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

// Retrieve attachment metadata.
$metadata = wp_get_attachment_metadata();

get_header();
?>

<?php // Check if site turned to boxed version
	  $boxed = ''; $boxed_element = ''; $row_class = '';
	  if (get_option('site_layout')=='boxed') {$boxed = 'container'; $boxed_element = 'col-md-12 col-sm-12'; $row_class = 'row';}
?>

<div class="breadcrumbs-wrapper">
	<div class="container">
		<div class="row">
			<?php if( get_option('post_pagination')=='on' ) { ?>
				<nav id="image-navigation" class="navigation image-navigation">
					<div class="nav-links">
						<?php previous_image_link( false, __( '<i class="fa fa-angle-left"></i>&nbsp;&nbsp;&nbsp;Previous Image', 'plumtree' ) ); ?>
						<?php next_image_link( false, __( 'Next Image&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>', 'plumtree' ) ); ?>
					</div><!-- .nav-links -->
				</nav><!-- #image-navigation -->
			<?php } ?>
			<?php if ( function_exists('pt_breadcrumbs') ) { pt_breadcrumbs(); } ?>
		</div>
	</div>
</div>

<?php if (!$boxed || $boxed=='') : ?><div class="container"><?php endif; ?>
	<div class="row">
		<?php if ( pt_show_layout()=='layout-one-col' ) { $content_class = "col-xs-12 col-md-12 col-sm-12"; } 
			  elseif ( pt_show_layout()=='layout-two-col-left' ) { $content_class = "col-xs-12 col-md-9 col-sm-9 col-md-push-3"; }
			  else { $content_class = "col-xs-12 col-md-9 col-sm-9"; } ?>

		<div id="content" class="site-content <?php echo esc_attr($content_class); ?>" role="main" itemscope="itemscope" itemprop="mainContentOfPage">

		<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();
		?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemprop="ImageObject">
				
				<div class="attachment">
					<?php pt_attached_image(); ?>
				</div>

				<div class="attachment-description">

					<header class="entry-header">
						<h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">

						<?php if ( has_excerpt() ) : ?>
						<div class="entry-caption" itemprop="caption">
							<?php the_excerpt(); ?>
						</div>
						<?php endif; ?>

						<?php if ( ! empty( $post->post_content ) ) : ?>
						<div class="entry-description">
							<?php echo $post->post_content; ?>
						</div><!-- .entry-description -->
						<?php endif; ?>

					</div><!-- .entry-content -->

					<div class="entry-meta">
						<div class="date"><strong><?php _e('Date:&nbsp;&nbsp;&nbsp;', 'plumtree'); ?></strong><?php pt_entry_publication_time();?></div>
						<?php if ( $post->portfolio_filter ) { ?>
						<div class="tags"><strong><?php _e('Tags:&nbsp;&nbsp;&nbsp;', 'plumtree'); ?></strong><?php echo esc_attr($post->portfolio_filter); ?></div>
						<?php }?>
						<div class="comments"><strong><?php _e('Comments:&nbsp;&nbsp;&nbsp;', 'plumtree'); ?></strong><?php pt_entry_comments_counter(); ?></div>
						<div class="source"><strong><?php _e('Source Image:&nbsp;&nbsp;&nbsp;', 'plumtree'); ?></strong><?php 
							$metadata = wp_get_attachment_metadata();
							printf( '<span class="attachment-meta full-size-link"><a href="%1$s" title="%2$s" itemprop="contentUrl">%3$s (%4$s &times; %5$s)</a></span>',
								esc_url( wp_get_attachment_url() ),
								esc_attr__( 'Link to full-size image', 'plumtree' ),
								__( 'Full resolution', 'plumtree' ),
								$metadata['width'],
								$metadata['height']
							);
						 ?></div>
					</div><!-- .entry-meta -->

				</div>

				<div class="entry-meta-bottom">
					<?php if ( function_exists( 'pt_share_buttons_output' ) ) { pt_share_buttons_output(); } ?>
					<?php if ( function_exists( 'pt_entry_post_views' ) ) { pt_entry_post_views(); } ?>
					<?php if ( function_exists( 'pt_output_like_button' ) ) { pt_output_like_button( get_the_ID() ); } ?>
				</div>

			</article><!-- #post-## -->

			<?php comments_template(); ?>

		<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
		<?php get_sidebar(); ?>
	</div>
<?php if (!$boxed || $boxed=='') : ?></div><?php endif; ?>
</div><!--.main -->
<?php get_footer(); ?>
