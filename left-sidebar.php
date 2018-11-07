<?php
/**
 * The template for displaying left sidebars.
 *
 * Template Name: Left Sidebar
 *
 * @package storefront
 */

get_header(); ?>

<div class="left-sidebar">
	<?php
	do_action( 'storefront_sidebar' ); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post();

				do_action( 'storefront_page_before' );

				get_template_part( 'content', 'page' );

				/**
				 * Functions hooked in to storefront_page_after action
				 *
				 * @hooked storefront_display_comments - 10
				 */
				do_action( 'storefront_page_after' );

			endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .left-sidebar -->
<?php

get_footer();
