<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Museum
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'museum' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				<?php get_search_form(); ?>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'search' ); ?>

			<?php endwhile; ?>

			<?php the_posts_navigation( array( 'next_text' => __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'museum' ), 'prev_text' => __( '<span class="meta-nav">&larr;</span> Older posts', 'museum' ) ) ); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>
