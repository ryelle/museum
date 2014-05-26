<?php
/**
 * @package Museum
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<a href="<?php the_permalink(); ?>" rel="bookmark" class="post-link">
		<?php if ( ! is_search() ) : ?>
			<?php if ( has_post_thumbnail() ): ?>
			<div class="entry-image">
				<?php the_post_thumbnail(); ?>
			</div><!-- .entry-image -->
			<?php else: ?>
			<div class="entry-image">
				<div class="format-icon <?php echo get_post_format() ?>-icon"></div>
			</div><!-- .entry-image -->
			<?php endif; ?>
		<?php endif; ?>

		<header class="entry-header">
			<span class="read-more"><?php echo __( 'Read Post', 'museum' ); ?> &rsaquo;</span>
			<?php if ( get_the_title() ) : ?>
				<h2 class="entry-title"><?php the_title(); ?></h2>
				<div class="entry-excerpt"><?php the_excerpt(); ?></div>
			<?php else: ?>
				<div class="entry-excerpt no-title"><?php the_excerpt(); ?></div>
			<?php endif; ?>
		</header><!-- .entry-header -->
	</a>
</article><!-- #post-## -->
