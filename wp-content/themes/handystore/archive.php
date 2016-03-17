<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Fourteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
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
				<?php
					if ( is_day() ) :
						printf( __( 'Daily Archives: %s', 'plumtree' ), get_the_date() );
					elseif ( is_month() ) :
						printf( __( 'Monthly Archives: %s', 'plumtree' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'plumtree' ) ) );
					elseif ( is_year() ) :
						printf( __( 'Yearly Archives: %s', 'plumtree' ), get_the_date( _x( 'Y', 'yearly archives date format', 'plumtree' ) ) );
					else :
						_e( 'Archives', 'plumtree' );
					endif;
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

			<?php if ( have_posts() ) : ?>

			<?php 	if ( get_option('blog_frontend_layout')=='grid' && !is_woocommerce() ) {
						echo "<div class='blog-grid-wrapper' data-isotope=container data-isotope-layout=masonry data-isotope-elements=post>";
					} else {
						echo '<div class="arcive-pages-content">';
					}

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
