<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>

 *
 * @package Museum
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * @uses museum_header_style()
 * @uses museum_admin_header_style()
 * @uses museum_admin_header_image()
 *
 * @package Museum
 */
function museum_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'museum_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 200,
		'height'                 => 75,
		'flex-height'            => true,
		'flex-width'             => true,
		'wp-head-callback'       => 'museum_header_style',
		'admin-head-callback'    => 'museum_admin_header_style',
		'admin-preview-callback' => 'museum_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'museum_custom_header_setup' );

function museum_custom_header_options() {
	$header_position = get_theme_mod( 'header_position', 'right' );
?>
<table class="form-table">
<tr class="displaying-header-text">
	<th scope="row"><?php _e( 'Text Position', 'museum' ); ?></th>
	<td>
		<select name="header_position">
			<option value="right" <?php selected( $header_position, 'right' ); ?>><?php _e( 'Right of image', 'museum' ); ?></option>
			<option value="below" <?php selected( $header_position, 'below' ); ?>><?php _e( 'Below image', 'museum' ); ?></option>
		</select>
	</td>
</tr>
</table>
<?php
}
add_action( 'custom_header_options', 'museum_custom_header_options' );

if ( ! function_exists( 'museum_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see museum_custom_header_setup().
 */
function museum_header_style() {
	$header_text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo $header_text_color; ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // museum_header_style

if ( ! function_exists( 'museum_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Also saves the header position. 
 * @todo do via JS/ajax to remove unrelated functionality here, and auto-update preview
 *
 * @see museum_custom_header_setup().
 */
function museum_admin_header_style() {
	$positions = array( 'right', 'below' );
	if ( isset( $_POST['header_position'] ) && in_array( $_POST['header_position'], $positions ) ){
		set_theme_mod( 'header_position', $_POST['header_position'] );
	}
	$header_position = get_theme_mod( 'header_position', 'right' );
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg { border: none; }
		#headimg {
			clear: both;
			margin: 0 0 60px;
			text-align: center;
		}
		#headimg img {
			vertical-align: middle;
		}
		#headimg h1 {
			margin: 0;
			font-family: 'Playfair Display';
			font-size: 36px;
			line-height: 1;
			font-weight: normal;
			letter-spacing: 1px;
			text-transform: uppercase;
		}
		#headimg h1 a {
			text-decoration: none;
		}
		#headimg.text-right .site-logo,
		#headimg.text-right .site-title {
			display: inline-block;
		}
	</style>
<?php
}
endif; // museum_admin_header_style

if ( ! function_exists( 'museum_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see museum_custom_header_setup().
 */
function museum_admin_header_image() {
	$style = sprintf( ' style="color:#%s;"', get_header_textcolor() );
	$header_position = get_theme_mod( 'header_position', 'right' );
?>
	<div id="headimg" class="site-branding text-<?php echo $header_position; ?>">

		<?php if ( get_header_image() ) : ?>
		<div class="site-logo">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>">
		</div>
		<?php endif; // End header image check. ?>

		<h1 class="site-title displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>

	</div>
<?php
}
endif; // museum_admin_header_image
