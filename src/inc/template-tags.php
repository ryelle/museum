<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Museum
 */

if ( ! function_exists( 'museum_footer_class' ) ) :
/**
 * Count the number of footer sidebars to enable dynamic classes for the footer.
 */
function museum_footer_class() {
	$class = 'one-column';

	if ( is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ) {
		$class = 'two-column';
	}

	echo esc_attr( $class );
}
endif;

if ( ! function_exists( 'museum_menu_class' ) ) :
/**
 * Add dynamic class to nav wrapper contingent on social nav menu being active.
 */
function museum_menu_class() {
	$class = '';

	if ( has_nav_menu( 'social' ) ) {
		$class = 'has-social-menu';
	}

	echo esc_attr( $class );
}
endif;

if ( ! function_exists( 'museum_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @return void
 */
function museum_paging_nav() {
	$class = '';

	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	if ( get_next_posts_link() && get_previous_posts_link() ){
		$class = 'both-links';
	}
	?>
	<nav class="navigation paging-navigation <?php echo $class; ?>" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'museum' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'museum' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'museum' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'museum_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @return void
 */
function museum_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'museum' ); ?></h1>
		<div class="nav-links">

			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&laquo;</span> %title', 'Previous post link', 'museum' ) ); ?>
			<?php next_post_link(     '%link', _x( '%title <span class="meta-nav">&raquo;</span>', 'Next post link',     'museum' ) ); ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'museum_attachment_media' ) ) :
/**
 * Display attachment media
 */
function museum_attachment_media() {
	$caption = get_the_excerpt();
	if ( $caption ) echo '<div class="wp-caption">';

	if ( wp_attachment_is_image() ) {
		echo wp_get_attachment_link( 0, 'post-thumbnail', false );
	} elseif ( 0 === strpos( $post->post_mime_type, 'video' ) ) {
		$meta = wp_get_attachment_metadata( get_the_ID() );
		$atts = array( 'src' => wp_get_attachment_url() );
		if ( ! empty( $meta['width'] ) && ! empty( $meta['height'] ) ) {
			$atts['width'] = ( int ) $meta['width'];
			$atts['height'] = ( int ) $meta['height'];
		}
		echo wp_video_shortcode( $atts );
	} elseif ( 0 === strpos( $post->post_mime_type, 'audio' ) ) {
		echo wp_audio_shortcode( array( 'src' => wp_get_attachment_url() ) );
	}

	if ( $caption ) {
		printf( '<p class="wp-caption-text">%s</p>', $caption );
		echo '</div>';
	}
}
endif;

if ( ! function_exists( 'museum_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function museum_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( '<span class="byline">' . __( 'by %1$s', 'museum' ) . '</span><span class="posted-on">' . __( ' on %2$s', 'museum' ) . '</span>',
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		),
		sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
			esc_url( get_permalink() ),
			$time_string
		)
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 */
function museum_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so museum_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so museum_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in museum_categorized_blog.
 */
function museum_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'museum_category_transient_flusher' );
add_action( 'save_post',     'museum_category_transient_flusher' );
