<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Museum
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					if ( is_author() ) {
						printf( '<h1 class="page-title"><span class="author-image">%s</span><span class="vcard">%s</span></h1>', get_avatar( get_the_author_meta( 'ID' ), 128 ), get_the_author() );

						$bio = get_the_author_meta( 'description', get_the_author_meta( 'ID' ) );
						if ( ! empty( $bio ) ) {
							printf( '<div class="author-description">%s</div>', apply_filters( 'the_content', $bio ) );
						}
					} else {
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					}
				?>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php the_posts_navigation( array( 'next_text' => __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'museum' ), 'prev_text' => __( '<span class="meta-nav">&larr;</span> Older posts', 'museum' ) ) ); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>
