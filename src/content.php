<?php
/**
 * @package Museum
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( ! is_search() ) : ?>
		<?php if ( has_post_thumbnail() ): ?>
		<div class="entry-image">
			<a href="<?php the_permalink(); ?>" rel="bookmark">
				<?php the_post_thumbnail(); ?>
			</a>
		</div><!-- .entry-image -->
		<?php else: ?>
		<div class="entry-image">
			<a href="<?php the_permalink(); ?>" rel="bookmark">
				<div class="format-icon <?php echo get_post_format() ?>-icon"></div>
			</a>
		</div><!-- .entry-image -->
		<?php endif; ?>
	<?php endif; ?>

	<header class="entry-header">
		<a href="<?php the_permalink(); ?>" class="read-more"><?php echo __( 'Read Post', 'museum' ); ?> &rsaquo;</a>
		<?php if ( get_the_title() ) : ?>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<div class="entry-excerpt"><?php the_excerpt(); ?></div>
		<?php else: ?>
			<div class="entry-excerpt no-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_excerpt(); ?></a></div>
		<?php endif; ?>
	</header><!-- .entry-header -->
</article><!-- #post-## -->
