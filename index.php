<?php
/**
 * The main template file.
 *
 * @package slim-chance
 */

get_header();
?>

<div class="container">

	<main id="main" class="page-index__main">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				get_template_part( 'parts/content', 'page' );
			endwhile;
		endif;
		?>
	</main>

	<aside id="sidebar" class="page-index__sidebar">
		<?php get_sidebar(); ?>
	</aside>

</div><!-- .container -->

<?php get_footer(); ?>
