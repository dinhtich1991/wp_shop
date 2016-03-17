<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
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
			<?php echo '<div class="page-title">'.get_the_title().'</div>'; ?>
			<?php if ( function_exists('pt_breadcrumbs') ) { pt_breadcrumbs(); } ?>
		</div>
	</div>
</div>

<?php if (!$boxed || $boxed=='') : ?><div class="container"><?php endif; ?>
	<div class="row">
		<?php if ( pt_show_layout()=='layout-one-col' ) { $content_class = "col-xs-12 col-md-12 col-sm-12"; } 
			  elseif ( pt_show_layout()=='layout-two-col-left' ) { $content_class = "col-xs-12 col-md-9 col-sm-6 col-md-push-3 col-sm-push-6"; }
			  else { $content_class = "col-xs-12 col-md-9 col-sm-6"; } ?>

		<div id="content" class="site-content <?php echo esc_attr($content_class); ?>" role="main" itemscope="itemscope" itemprop="mainContentOfPage">

			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
			?>

		</div><!-- #content -->

		<?php get_sidebar(); ?>

	</div>
<?php if (!$boxed || $boxed=='') : ?></div><?php endif; ?>
</div><!--.main -->
<?php get_footer(); ?>
