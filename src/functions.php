<?php
/**
 * Museum functions and definitions
 *
 * @package Museum
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 920; /* pixels */
}

if ( ! function_exists( 'museum_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function museum_setup() {
	global $content_width;

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Museum, use a find and replace
	 * to change 'museum' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'museum', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts, pages, and audio/video attachments
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 * @link http://make.wordpress.org/core/2014/02/20/audio-video-2-0-update-playlists/
	 */
	add_post_type_support( 'attachment:audio', 'thumbnail' );
	add_post_type_support( 'attachment:video', 'thumbnail' );
	add_theme_support( 'post-thumbnails', array( 'post', 'page', 'attachment:audio', 'attachment:video' ) );
	add_image_size( 'single', $content_width * 2 );
	set_post_thumbnail_size( $content_width, $content_width, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'museum' ),
		'social'  => __( 'Social Links', 'museum' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'audio', 'quote', 'link' ) );

	// Use HTML5 elements for these features
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

	add_editor_style();

	// Remove default gallery styles
	add_filter( 'use_default_gallery_style', '__return_false' );
}
endif; // museum_setup
add_action( 'after_setup_theme', 'museum_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function museum_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Left Footer Area', 'museum' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Right Footer Area', 'museum' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'museum_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function museum_scripts() {
	wp_enqueue_style( 'museum-style', get_stylesheet_uri() );

	wp_enqueue_script( 'museum-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array( 'jquery' ), '20120206', true );

	wp_enqueue_script( 'museum-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'museum_scripts' );

/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Quattrocento Sans and Playfair Display by default is
 * localized. For languages that use characters not supported by either
 * font, the font can be disabled.
 *
 * @since Museum 1.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function museum_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Quattrocento Sans, translate this to 'off'. Do not
	 * translate into your own language.
	 */
	$quattrocento_sans = _x( 'on', 'Quattrocento Sans font: on or off', 'museum' );

	/* Translators: If there are characters in your language that are not
	 * supported by Playfair Display, translate this to 'off'. Do not
	 * translate into your own language.
	 */
	$playfair_display = _x( 'on', 'Playfair Display font: on or off', 'museum' );

	if ( 'off' !== $quattrocento_sans || 'off' !== $playfair_display ) {
		$font_families = array();

		if ( 'off' !== $quattrocento_sans )
			$font_families[] = 'Quattrocento+Sans:400,700';

		if ( 'off' !== $playfair_display )
			$font_families[] = 'Playfair+Display:400,400italic,700italic';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => implode( '|', $font_families ),
			'subset' => 'latin,latin-ext',
		);
		$fonts_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Loads our special font CSS file.
 *
 * To disable in a child theme, use wp_dequeue_style()
 * function mytheme_dequeue_fonts() {
 *     wp_dequeue_style( 'museum-fonts' );
 * }
 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
 *
 * @since Museum 1.0
 *
 * @return void
 */
function museum_fonts() {
	$fonts_url = museum_fonts_url();
	if ( ! empty( $fonts_url ) )
		wp_enqueue_style( 'museum-fonts', esc_url_raw( $fonts_url ), array(), null );
}
add_action( 'wp_enqueue_scripts', 'museum_fonts' );

/**
 * Adds additional stylesheets to the TinyMCE editor if needed.
 *
 * @uses museum_fonts_url() to get the Google Font stylesheet URL.
 *
 * @since Museum 1.0
 *
 * @param string $mce_css CSS path to load in TinyMCE.
 * @return string
 */
function museum_mce_css( $mce_css ) {
	$fonts_url = museum_fonts_url();

	if ( empty( $fonts_url ) )
		return $mce_css;

	if ( ! empty( $mce_css ) )
		$mce_css .= ',';

	$mce_css .= esc_url_raw( str_replace( ',', '%2C', $fonts_url ) );

	return $mce_css;
}
add_filter( 'mce_css', 'museum_mce_css' );


/**
 * Count the number of footer sidebars to enable dynamic classes for the footer.
 *
 * @since Museum 1.0
 */
function museum_footer_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-1' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-2' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one-column';
			break;
		case '2':
			$class = 'two-column';
			break;
	}

	if ( $class )
		echo $class;
}


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
