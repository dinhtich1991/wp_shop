<?php
/**
 * The template for displaying 404 pages (Not Found)
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
			<div class="page-title"><?php _e( 'Page 404', 'plumtree' ); ?></div>
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

			<header class="page-header">
				<h1 class="page-title"><?php _e( "Oops! That page can't be found.", 'plumtree' ); ?></h1>
			</header>

			<div class="page-content">
				<img src="<?php echo get_template_directory_uri() . '/images/404.jpg'; ?>" title="<?php _e( "Oops! That page can't be found.", 'plumtree' ); ?>" alt="404 page"/>
				<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'plumtree' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .page-content -->

		</div><!-- #content -->
		<?php get_sidebar();?>
	</div>
<?php if (!$boxed || $boxed=='') : ?></div><?php endif; ?>
</div><!--.main -->

<?php get_footer(); ?>
