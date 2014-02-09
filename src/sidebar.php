<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Museum
 */
?>
<div id="secondary" class="widget-area" role="complementary">
	<div class="secondary-content">

		<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div class="one-column">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
		<?php endif; // end sidebar widget area ?>

		<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
		<div class="one-column">
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		</div>
		<?php endif; // end sidebar widget area ?>

	</div>
</div><!-- #secondary -->
