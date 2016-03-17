<?php
/**
 * The template for displaying Author archive pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<?php // Check if site turned to boxed version
	  $boxed = ''; $boxed_element = ''; $row_class = '';
	  if (get_option('site_layout')=='boxed') {$boxed = 'container'; $boxed_element = 'col-md-12 col-sm-12'; $row_class = 'row';}
?>

<div class="breadcrumbs-wrapper">
	<div class="container">
		<div class="row">
			<div class="page-title">
				<?php the_post();
					  printf( __( 'All posts by %s', 'plumtree' ), get_the_author() );
				?>
			</div>
			<?php if ( function_exists('pt_breadcrumbs') ) { pt_breadcrumbs(); } ?>
		</div>
	</div>
</div>

<?php if (!$boxed || $boxed=='') : ?><div class="container"><?php endif; ?>
	<div class="row">
		<?php if ( pt_show_layout()=='layout-one-col' ) { $content_class = "col-xs-12 col-md-12 col-sm-12"; } 
			  elseif ( pt_show_layout()=='layout-two-col-left' ) { $content_class = "col-xs-12 col-md-9 col-sm-9 col-md-push-3"; }
			  else { $content_class = "col-xs-12 col-md-9 col-sm-9"; } 
			  /* Advanced Blog layout */
			  if (get_option('blog_frontend_layout')=='grid' || get_option('blog_frontend_layout')=='isotope' ) {
				  $content_class .= ' grid-layout '.esc_html(get_option('blog_grid_columns'));
			  }?>

		<div id="content" class="site-content <?php echo esc_attr($content_class); ?>" role="main" itemscope="itemscope" itemprop="mainContentOfPage">

			<?php if ( get_the_author_meta( 'description' ) ) : ?>
				<div class="author-description"><?php the_author_meta( 'description' ); ?></div>
			<?php endif; ?>

			<?php if ( have_posts() ) : ?>

			<div class="arcive-pages-content">

			<?php
					/*
					 * Since we called the_post() above, we need to rewind
					 * the loop back to the beginning that way we can run
					 * the loop properly, in full.
					 */
					rewind_posts();

					// Start the Loop.
					while ( have_posts() ) : the_post();

						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );

					endwhile;

					echo "</div>";
					
					// Previous/next page navigation.
					$blog_pagination = esc_html(get_option('blog_pagination'));
					if ( ($wp_query->max_num_pages > 1) && ($blog_pagination == 'infinite') ) : ?>
						<span class="pt-get-more-posts"><?php _e('Show More Posts', 'plumtree'); ?></span>
					<?php else : ?>
						<?php pt_content_nav(); ?>
					<?php endif;

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;
			?>

		</div><!-- #content -->

		<?php get_sidebar(); ?>
	</div>
<?php if (!$boxed || $boxed=='') : ?></div><?php endif; ?>
</div><!--.main -->
<?php get_footer(); ?>
