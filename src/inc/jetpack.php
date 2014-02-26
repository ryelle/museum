<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Museum
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function museum_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'type'      => 'click',
		'wrapper'   => false,
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'museum_jetpack_setup' );
