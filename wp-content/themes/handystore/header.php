<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?><!DOCTYPE html>

<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">

<?php // Check if site turned to boxed version
	  $boxed = ''; $boxed_element = ''; $row_class = '';
	  if (get_option('site_layout')=='boxed') {$boxed = 'container'; $boxed_element = 'col-md-12 col-sm-12'; $row_class = 'row';}
?>

<div id="page" class="hfeed site <?php echo esc_attr($boxed);?>">

	<?php if ($boxed && $boxed!='') {
		echo "<div class='row'>";
	}
	/* Header bg options */
	if ( get_option( 'header_bg_image' ) != '' ) {
		$header_bg = ' style="background: url('.esc_url(get_option( 'header_bg_image' )).') repeat left top transparent;"';
	} else {
		$header_bg = '';
		if ( get_option( 'header_bg_color' ) != '' ) {
			$header_bg = ' style="background: '.esc_attr(get_option( 'header_bg_color' )).';"';
		}
	}
	?>
	<header id="masthead" class="site-header <?php echo esc_attr($boxed_element);?>" role="banner" <?php echo $header_bg;?> itemscope="itemscope" itemtype="http://schema.org/WPHeader">

		<?php if (get_option( 'header_top_panel' ) == 'on' && ( has_nav_menu( 'header-top-nav' ) || get_option('top_panel_info') || is_active_sidebar('top-sidebar') ) ) : ?>
		<?php  
		/* Top panel bg options */
		if ( get_option( 'top_panel_bg' ) == 'solid' && get_option( 'top_panel_bg_color' ) != '' ) {
			$top_panel_bg = ' style="background: '.esc_attr(get_option( 'top_panel_bg_color' )).';"';
		} else {
			$top_panel_bg = '';
		}

		?>
		<div class="header-top <?php echo esc_attr($row_class);?>"<?php echo $top_panel_bg; ?>><!-- Header top section -->
			<?php if (!$boxed || $boxed=='') : ?><div class="container">
				<div class="row"><?php endif; ?>
					<div class="top-nav-container col-md-4 col-sm-4 col-xs-12">
						<?php if (has_nav_menu( 'header-top-nav' )) : ?>
							<nav class="header-top-nav" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
								<a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to content', 'plumtree' ); ?></a>
								<?php wp_nav_menu( array('theme_location'  => 'header-top-nav', 'depth' => 1,) ); ?>
							</nav>
						<?php endif;?>
					</div>
					<div class="info-container col-md-4 col-sm-4 col-xs-12">
						<?php if ( get_option('top_panel_info') !='' ) echo ( get_option('top_panel_info') ); ?>
					</div>
					<div class="top-widgets col-md-4 col-sm-4 col-xs-12">
						<?php if ( is_active_sidebar('top-sidebar') ) dynamic_sidebar( 'top-sidebar' ); ?>
					</div>
				</div>
			<?php if (!$boxed || $boxed=='') : ?></div>
		</div><?php endif; ?><!-- end of Header top section -->
		<?php endif; ?>

		<div class="logo-wrapper <?php echo esc_attr($row_class);?>"><!-- Logo & hgroup -->
			<?php if (!$boxed || $boxed=='') : ?><div class="container">
				<div class="row"><?php endif; ?>

				<?php 
					$logo_position = esc_attr(get_option('site_logo_position'));
					switch ($logo_position) {
					case 'left':
						$logo_class = 'col-lg-3 col-md-3 col-sm-12';
						$sidebar_class = 'col-lg-9 col-md-12 col-sm-12';
					    break;
					case 'center':
						$logo_class = 'col-lg-4 col-md-4 col-sm-12 col-md-offset-4 col-lg-offset-4 center-pos';
						$sidebar_class = 'col-lg-12 col-md-12 col-sm-12 center-pos';
						break;
					case 'right':
						$logo_class = 'col-md-3 col-lg-3 col-sm-12 col-lg-push-9 col-md-push-9 right-pos';
						$sidebar_class = 'col-lg-9 col-md-12 col-sm-12 col-lg-pull-3 right-pos';
						break;
					default:
						$logo_class = 'col-md-3 col-sm-12';
						$sidebar_class = 'col-md-9 col-sm-12';					
					}
				?>

				<?php if (get_option('site_logo')): ?>
					<div class="site-logo <?php echo esc_attr($logo_class);?>" itemscope itemtype="http://schema.org/Organization">
						<?php if ( !is_front_page() ) : ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="<?php bloginfo( 'name' );?>" itemprop="url">
								<img src="<?php echo esc_url(get_option('site_logo')) ?>" alt="<?php esc_html(bloginfo( 'description' )); ?>" itemprop="logo" />
							</a>
						<?php else : ?>
							<img src="<?php echo esc_url(get_option('site_logo')) ?>" alt="<?php esc_html(bloginfo( 'description' )); ?>" title="<?php esc_html(bloginfo( 'name' )); ?>" itemprop="logo" />
							<a style="visibility: hidden;" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="<?php esc_attr( bloginfo( 'name' ) );?>" itemprop="url"></a>
						<?php endif; ?>
					</div>
				<?php else: ?>
					<div class="header-group <?php echo esc_attr($logo_class);?>">
						<h1 id="the-title" class="site-title" itemprop="headline">
							<?php if ( !is_front_page() ) : ?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" itemprop="url">
									<?php bloginfo( 'name' ); ?>
								</a>
							<?php else : bloginfo( 'name' ); endif; ?>
						</h1>
						<h2 class="site-description" itemprop="description"><?php esc_html(bloginfo( 'description' )); ?></h2>
					</div>
				<?php endif; ?>

                <?php if ( is_active_sidebar( 'hgroup-sidebar' ) ) : ?>
                    <div class="hgroup-sidebar <?php echo esc_attr($sidebar_class);?>">
                        <?php dynamic_sidebar( 'hgroup-sidebar' ); ?>
                    </div>
                <?php endif; ?>

            	</div>
			<?php if (!$boxed || $boxed=='') : ?></div>
		</div><?php endif; ?><!-- end of Logo & hgroup -->

		<?php if (has_nav_menu( 'primary-nav' )) : ?>
			<div class="header-primary-nav <?php echo esc_attr($row_class);?>"><!-- Primary nav -->
				<?php if (!$boxed || $boxed=='') : ?><div class="container">
					<div class="row"><?php endif; ?>
						<nav class="primary-nav col-md-12 col-sm-12" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
							<a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to content', 'plumtree' ); ?></a>
							<?php wp_nav_menu( array('theme_location'  => 'primary-nav') ); ?>
						</nav>
					</div>
				<?php if (!$boxed || $boxed=='') : ?></div>
			</div><?php endif; ?>
		<?php endif; ?><!-- end of Primary nav -->

	</header><!-- #masthead -->

	<?php if ($boxed && $boxed!='') {
		echo "</div>";
		echo "<div class='row'>";
	}?>

	<div id="main" class="site-main <?php echo esc_attr($boxed_element);?>">
