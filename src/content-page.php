<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Museum
 */
?>

<?php if ( has_post_thumbnail() ): ?>
<div class="entry-image">
	<?php the_post_thumbnail( 'single' ); ?>
</div><!-- .entry-image -->
<?php endif; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'museum' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
