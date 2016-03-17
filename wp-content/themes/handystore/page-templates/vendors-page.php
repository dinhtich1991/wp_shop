<?php
/**
 * Template Name: WC Vendors Page Template
 */
?>

<?php get_header(); ?>

<?php /* Check if site turned to boxed version */
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
        <?php /* Adding extra classes based on layout mode */
        if ( pt_show_layout()=='layout-one-col' ) { $content_class = "col-xs-12 col-md-12 col-sm-12"; } 
          elseif ( pt_show_layout()=='layout-two-col-left' ) { $content_class = "col-xs-12 col-md-9 col-sm-9 col-md-push-3"; }
          else { $content_class = "col-xs-12 col-md-9 col-sm-9"; } ?>

        <div id="content" class="site-content pt-vendors <?php echo esc_attr($content_class); ?>" role="main" itemscope="itemscope" itemprop="mainContentOfPage">

            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>

        </div><!--.site-content-->
        <?php get_sidebar(); ?>
    </div>

<?php if (!$boxed || $boxed=='') : ?></div><?php endif; ?>
</div><!--.main -->

<?php get_footer(); ?>
