<?php
/**
 * Template Name: Front Page
 */

get_header(); ?>

<?php /* Check if site turned to boxed version */
      $boxed = ''; $boxed_element = ''; $row_class = '';
      if (get_option('site_layout')=='boxed') {$boxed = 'container'; $boxed_element = 'col-md-12 col-sm-12'; $row_class = 'row';}
?>

<?php /* Banners Section */
      if (get_option('front_page_shortcode_section')=='on') {
        if (function_exists('pt_front_shortcode_section')) {
          pt_front_shortcode_section();
        }
} ?>

<?php if (!$boxed || $boxed=='') : ?><div class="container"><?php endif; ?>
    <div class="row">
        <?php /* Adding extra classes based on layout mode */
        if ( pt_show_layout()=='layout-one-col' ) { $content_class = "col-xs-12 col-md-12 col-sm-12"; } 
          elseif ( pt_show_layout()=='layout-two-col-left' ) { $content_class = "col-xs-12 col-md-9 col-sm-8 col-md-push-3 col-sm-push-4"; }
          else { $content_class = "col-xs-12 col-md-9 col-sm-8"; } ?>

        <div id="content" class="site-content <?php echo esc_attr($content_class); ?>" role="main" itemscope="itemscope" itemprop="mainContentOfPage">

            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div><!-- .entry-content -->
                <?php endwhile; ?>
            <?php endif; ?>

        </div><!--.site-content-->
        <?php get_sidebar(); ?>

        <?php /* Special front page sidebar */
        if (get_option('front_page_special_sidebar')=='on') {
          if ( is_active_sidebar( 'front-special-sidebar' ) ) { ?>
            <div id="special-sidebar-front" class="widget-area col-xs-12 col-sm-12 col-md-12 sidebar" role="complementary">
              <div class="row">
                <?php dynamic_sidebar( 'front-special-sidebar' ); ?>
              </div>
            </div>
          <?php
          }
        } ?>
        
    </div>

<?php if (!$boxed || $boxed=='') : ?></div><?php endif; ?>
</div><!--.main -->

<?php get_footer(); ?>