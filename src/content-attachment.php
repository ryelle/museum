<?php
/**
 * @package Museum
 */
?>

<?php if ( has_post_thumbnail() ): ?>
<div class="entry-image">
	<?php the_post_thumbnail(); ?>
</div><!-- .entry-image -->
<?php endif; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			$caption = get_the_excerpt();
			if ( $caption ) echo '<div class="wp-caption">';

			if ( wp_attachment_is_image() ) {
				echo wp_get_attachment_link( 0, 'post-thumbnail', false );
			} elseif ( 0 === strpos( $post->post_mime_type, 'video' ) ) {
				$meta = wp_get_attachment_metadata( get_the_ID() );
				$atts = array( 'src' => wp_get_attachment_url() );
				if ( ! empty( $meta['width'] ) && ! empty( $meta['height'] ) ) {
					$atts['width'] = (int) $meta['width'];
					$atts['height'] = (int) $meta['height'];
				}
				echo wp_video_shortcode( $atts );
			} elseif ( 0 === strpos( $post->post_mime_type, 'audio' ) ) {
				echo wp_audio_shortcode( array( 'src' => wp_get_attachment_url() ) );
			}

			if ( $caption ) {
				printf( '<p class="wp-caption-text">%s</p>', $caption );
				echo '</div>';
			}

		?>

		<?php the_content(); ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'museum' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<div class="entry-author"><?php museum_posted_on(); ?></div>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
