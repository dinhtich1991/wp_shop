<?php

if ( ! function_exists( 'pt_content_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 * Based on paging nav function from Twenty Fourteen
 */

function pt_content_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 3,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '<i class="fa fa-chevron-left"></i>', 'plumtree' ),
		'next_text' => __( '<i class="fa fa-chevron-right"></i>', 'plumtree' ),
		'type'      => 'plain',
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'plumtree' ); ?></h1>
			<?php echo $links; ?>
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;

if ( ! function_exists( 'pt_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function pt_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'plumtree' ); ?></h1>
		<div class="nav-links">
			<?php
			if ( is_attachment() ) :
				previous_post_link( '%link', __( '<span class="meta-nav">Published In</span>', 'plumtree' ) );
			else :
				previous_post_link( '%link', __( '<i class="fa fa-angle-left"></i>&nbsp;&nbsp;&nbsp;Previous Post', 'plumtree' ) );
				next_post_link( '%link', __( 'Next Post&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>', 'plumtree' ) );
			endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'pt_comments_nav' ) ) :
/**
 * Display comments navigation (2 styles available = numeric nav or newest/oldest nav).
 */
function pt_comments_nav($nav_type) {
	if ($nav_type == 'numeric') { ?>
        <nav class="navigation comment-numeric-navigation" role="navigation">
            <h1 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'plumtree' ); ?></h1>
            <span class="page-links-title"><?php _e('Comments Navigation:', 'plumtree'); ?></span>
            <?php paginate_comments_links( array(
				'prev_text' => __( '<i class="fa fa-chevron-left"></i>', 'plumtree' ),
				'next_text' => __( '<i class="fa fa-chevron-right"></i>', 'plumtree' ),
              	'type'      => 'plain',
              )); ?>  			
       	</nav>
	<?php } elseif ($nav_type == 'newold') { ?>
        <nav class="navigation comment-navigation" role="navigation">
            <h1 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'plumtree' ); ?></h1>
            <div class="prev"><?php previous_comments_link( __( '<i class="fa fa-angle-left"></i>Older Comments', 'plumtree' ) ); ?></div>
            <div class="next"><?php next_comments_link( __( 'Newer Comments<i class="fa fa-angle-right"></i>', 'plumtree' ) ); ?></div>
        </nav>
	<?php }
}
endif;