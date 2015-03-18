<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Museum
 */

/**
 * Disable the wp_nav_menu() fallback menu.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function museum_nav_menu_args( $args ) {
	$args['fallback_cb'] = false;
	return $args;
}
add_filter( 'wp_nav_menu_args', 'museum_nav_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function museum_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'museum_body_classes' );

/**
 * Add some custom classes to the post container.
 *
 * @param array $classes Classes for the post container
 * @return array
 */
function museum_post_class( $classes, $class, $post_id ) {
	if ( ! is_singular() ) {
		if ( has_post_thumbnail( $post_id ) ) {
			$classes[] = 'with-image';
		} elseif ( ! has_post_thumbnail( $post_id ) ) {
			$classes[] = 'no-image';
		}

		if ( get_the_title( $post_id ) ) {
			$classes[] = 'with-title';
		} elseif ( ! get_the_title( $post_id ) ) {
			$classes[] = 'no-title';
		}
	}

	return $classes;
}
add_filter( 'post_class', 'museum_post_class', 10, 3 );

/**
 * Unset the website field
 */
function museum_comment_fields( $fields ){
	unset( $fields['url'] );
	return $fields;
}
add_filter( 'comment_form_default_fields', 'museum_comment_fields' );

/**
 * Remove info about allowed HTML.
 */
function museum_comment_form( $args ){
	$args['comment_notes_after'] = '';
	$args['comment_field']       = '<p class="comment-form-comment clearfix"><label for="comment">' . __( 'What is your message?', 'museum' ) . '</label><textarea id="comment" name="comment" cols="45" rows="5" aria-required="true"></textarea></p>';
	return $args;
}
add_filter( 'comment_form_defaults', 'museum_comment_form' );

function museum_password_form( $output ) {
	$output = str_replace( array( '</label>', ' <input name="post_password' ), array( '', '</label><input name="post_password' ), $output );
	return $output;
}
add_filter( 'the_password_form', 'museum_password_form' );


if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat `title` tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function museum_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'museum' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'museum_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function museum_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'museum_render_title' );
endif;
