<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

<?php // Check if site turned to boxed version
	  $boxed = ''; $boxed_element = ''; $row_class = '';
	  if (get_option('site_layout')=='boxed') {$boxed = 'container'; $boxed_element = 'col-md-12 col-sm-12'; $row_class = 'row';}
?>
				
		<?php if ($boxed && $boxed!='') {
			echo "</div>";
			echo "<div class='row'>";
		}?>

		<?php /* Shortcode section */
		      if (get_option('footer_shortcode_section')=='on') {
		        if ( is_front_page() || 
		        	is_home() || 
		        	( class_exists('Woocommerce') && is_shop() ) || 
		        	( class_exists('Woocommerce') && is_product() ) || 
		        	is_page_template( 'page-templates/front-page.php' ) ) {
		          		pt_shortcode_section();
		        }
		} ?>

		<footer id="colophon" class="site-footer <?php echo esc_attr($boxed_element);?>" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter">

			<div class="top-footer-widget <?php echo esc_attr($row_class);?>">
				<?php if (!$boxed || $boxed=='') : ?><div class="container">
					<div class="row"><?php endif; ?>

						<div class="col-xs-12 col-sm-12 col-md-12">
							<?php if ( is_active_sidebar( 'top-footer-sidebar' ) ) : ?>
                            	<?php dynamic_sidebar( 'top-footer-sidebar' ); ?>
                        	<?php endif; ?>
                    	</div>

				<?php if (!$boxed || $boxed=='') : ?></div>
				</div><?php endif; ?>
			</div>

			<div class="footer-widgets <?php echo esc_attr($row_class);?>">
				<?php if (!$boxed || $boxed=='') : ?><div class="container">
					<div class="row"><?php endif; ?>
				
					<div class="col-xs-12 col-sm-6 col-md-3">
                        <?php if ( is_active_sidebar( 'footer-sidebar-1' ) ) : ?>
                            <?php dynamic_sidebar( 'footer-sidebar-1' ); ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?php if ( is_active_sidebar( 'footer-sidebar-2' ) ) : ?>
                            <?php dynamic_sidebar( 'footer-sidebar-2' ); ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?php if ( is_active_sidebar( 'footer-sidebar-3' ) ) : ?>
                            <?php dynamic_sidebar( 'footer-sidebar-3' ); ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?php if ( is_active_sidebar( 'footer-sidebar-4' ) ) : ?>
                            <?php dynamic_sidebar( 'footer-sidebar-4' ); ?>
                        <?php endif; ?>
                    </div>
				
					<?php if (!$boxed || $boxed=='') : ?></div>
				</div><?php endif; ?>
			</div>

			<div class="footer-bottom <?php echo esc_attr($row_class);?>">
				<?php if (!$boxed || $boxed=='') : ?><div class="container">
					<div class="row"><?php endif; ?>

						<div class="site-info col-xs-12 col-sm-12 col-md-12">
							<?php /* Get content from admin panel */
							if ( get_option('site_copyright') && get_option('site_copyright')!='' ) { ?>
								<span itemprop="copyrightHolder"><?php echo get_option('site_copyright');?></span>
							<?php } else { 
								echo '<span itemprop="copyrightYear">2015</span>&nbsp;<span itemprop="copyrightHolder">&copy; Handy Store by <a href="http://themes.zone" itemprop="url">Themes Zone</a></span>';
							} ?>
						</div>

					</div>
				<?php if (!$boxed || $boxed=='') : ?></div>
			</div><?php endif; ?>

		</footer> <!-- #colophon -->
		<?php if ($boxed && $boxed!='') { echo "</div>"; } ?>
	</div> <!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>