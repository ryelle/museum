<?php
/**
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
		<h1 class="entry-title"><?php the_title(); ?></h1>
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

	<footer class="entry-meta clear">
		<div class="entry-author"><?php museum_posted_on(); ?></div>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-taxes"><?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( ', ' );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', ', ' );

			if ( ! museum_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( '<span class="entry-tags"><div class="genericon genericon-tag"></div> %2$s</span>', 'museum' );
				} else {
					$meta_text = '';
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( '<span class="entry-categories"><div class="genericon genericon-category"></div> %1$s</span> <span class="entry-tags"><div class="genericon genericon-tag"></div> %2$s</span>', 'museum' );
				} else {
					$meta_text = __( '<span class="entry-categories"><div class="genericon genericon-category"></div> %1$s</span>', 'museum' );
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list
			);
		?></div>
		<?php endif; ?>

	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
