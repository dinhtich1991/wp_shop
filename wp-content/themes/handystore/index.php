<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Plumtree
 * @since Plumtree 1.0
 */

get_header(); ?>

<?php // Check if site turned to boxed version
	  $boxed = ''; $boxed_element = ''; $row_class = '';
	  if (get_option('site_layout')=='boxed') {$boxed = 'container'; $boxed_element = 'col-md-12 col-sm-12'; $row_class = 'row';}
?>

<div class="breadcrumbs-wrapper">
	<div class="container">
		<div class="row">
			<?php if ( is_home() && get_option( 'page_for_posts' ) ) echo '<div class="page-title">'.get_the_title( esc_attr(get_option( 'page_for_posts' )) ).'</div>'; ?>
			<?php if ( function_exists('pt_breadcrumbs') ) pt_breadcrumbs(); ?>
		</div>
	</div>
</div>

<?php if (!$boxed || $boxed=='') : ?><div class="container"><?php endif; ?>
	<div class="row">
		<?php 
		/* Custom class for custom layout options */
		if ( pt_show_layout()=='layout-one-col' ) { $content_class = "col-xs-12 col-md-12 col-sm-12"; } 
		elseif ( pt_show_layout()=='layout-two-col-left' ) { $content_class = "col-xs-12 col-md-9 col-sm-8 col-md-push-3 col-sm-push-4"; }
		else { $content_class = "col-xs-12 col-md-9 col-sm-8"; }
		/* Live preview */
		if( isset( $_GET['b_type'] ) ){ 
			$blog_type = esc_attr($_GET['b_type']);
			if ( $blog_type=='3cols' || $blog_type=='4cols' || $blog_type=='filters' ) {
				$content_class = "col-xs-12 col-md-12 col-sm-12";
			}
		} else { $blog_type = ''; }
		/* Advanced Blog layout */
		if (get_option('blog_frontend_layout')=='grid' || get_option('blog_frontend_layout')=='isotope' ) {
			$content_class .= ' grid-layout '.esc_attr(get_option('blog_grid_columns'));
		} 
		?>

		<div id="content" class="site-content <?php echo esc_html($content_class); ?>" role="main" itemscope="itemscope" itemprop="mainContentOfPage">

		<?php global $wp_query;

			// If isotope layout get & output all posts
			if (get_option('blog_frontend_layout')=='isotope' || isset( $_GET['b_type'] ) ) {
				global $query_string; query_posts( $query_string . '&posts_per_page=-1' );
			}

			if ( have_posts() ) {
				// Get isotope filters
				if (get_option('blog_frontend_layout')=='isotope' || $blog_type=='filters') {
					$filters = array();

					if ( get_option('blog_isotope_filters') == 'cats' ) : $filters = get_categories(); $prefix = 'category'; endif;
					if ( get_option('blog_isotope_filters') == 'tags' ) : $filters = get_tags(); $prefix = 'tag'; endif;
	                        
	    			if (!empty($filters)) {

				        $output_filters = '<div class="portfolio-filters-wrapper"><label for="pt-filters">'.__('Filter blog posts by:', 'plumtree').'</label>';
				        $output_filters .= '<select id="pt-filters" name="pt-filters" class="filters-group" data-isotope=filters data-filter-group="'.esc_attr($prefix).'"><option value="">'.__('All', 'plumtree').'</option>';
				        foreach($filters as $filter){
				            $output_filters .= '<option value="'.esc_attr($prefix).'-'.esc_attr($filter->slug).'">'.esc_html($filter->name).'</option>';
				        }
				        $output_filters .= '</select></div>';
				        echo $output_filters;

				    }

				}

				if ( get_option('blog_frontend_layout')=='grid' || get_option('blog_frontend_layout')=='isotope' || $blog_type ) {
					echo "<div class='blog-grid-wrapper' data-isotope=container data-isotope-layout=masonry data-isotope-elements=post>";
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

				// Close isotope container
				if ( get_option('blog_frontend_layout')=='grid' || get_option('blog_frontend_layout')=='isotope' || $blog_type ) { echo "</div>"; }

				// Post navigation.
				if (get_option('blog_frontend_layout')!=='isotope') {
					$blog_pagination = get_option('blog_pagination');
					if ( ($wp_query->max_num_pages > 1) && ($blog_pagination == 'infinite') ) {
						echo '<span class="pt-get-more-posts">'.__('Show More Posts', 'plumtree').'</span>';
					} else {
						if (function_exists('pt_content_nav')) {
							pt_content_nav();
						} else {
							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'plumtree' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
							) );
						}
					}
				}

			} else {
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );
			}
			
		?>

		</div><!-- #content -->

		<?php 
		if ( !$blog_type || $blog_type == '2cols' ) {
			get_sidebar(); 
		}
		?>

	</div>
<?php if (!$boxed || $boxed=='') : ?></div><?php endif; ?>
</div><!--.main -->
<?php get_footer(); ?>
