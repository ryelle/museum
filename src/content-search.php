<?php
/**
 * @package Museum
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<a href="<?php the_permalink(); ?>" rel="bookmark" class="post-link">
		<header class="entry-header">
			<span class="read-more"><?php echo __( 'Read Post', 'museum' ); ?> &rsaquo;</span>
			<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
			<div class="entry-excerpt"><?php the_excerpt(); ?></div>
		</header><!-- .entry-header -->
	</a>
</article><!-- #post-## -->
