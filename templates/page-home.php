<?php
/**
 * Template Name: Homepage
 */

get_header();
?>

<div class="page-wrapper page-home">

	<main id="main" class="page-home__main">

		<?php get_template_part( 'templates/parts/templates/page-home/section', 'hero' ); ?>
		<?php get_template_part( 'templates/parts/layout/blocks/section', 'image-blocks' ); ?>
		<?php get_template_part( 'templates/parts/layout/section', 'sign-up' ); ?>

	</main>

</div><!-- .container -->

<?php get_footer(); ?>
