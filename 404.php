<?php get_header(); ?>

<div class="container">

	<main id="main" class="page-404__main">
		<?php _e( 'This page cannot be found. Please try your search again or go back to the homepage.', 'cerium' ); // WPCS: XSS Ok. ?>
	</main>

	<aside id="sidebar" class="page-404__sidebar">
		<?php get_sidebar(); ?>
	</aside>

</div><!-- .container -->

<?php get_footer(); ?>
