<?php
/**
 * @package Museum
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ): ?>
	<div class="entry-image">
		<a href="<?php the_permalink(); ?>" rel="bookmark">
			<?php the_post_thumbnail(); ?>
		</a>
	</div><!-- .entry-image -->
	<?php endif; ?>

	<header class="entry-header">
		<a href="<?php the_permalink(); ?>" class="read-more"><?php echo __( 'Read Post', 'museum' ); ?> &rsaquo;</a>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<div class="entry-excerpt"><?php the_excerpt(); ?></div>
	</header><!-- .entry-header -->
</article><!-- #post-## -->
