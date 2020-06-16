<?php
/**
 * Template Name: Homepage
 */

use function ChanceDigital\Slim_Chance\Template\get_template_part;

get_header();
?>

<div class="page-wrapper page-home">

	<main id="main" class="page-home__main">

		<?php get_template_part( 'templates/page-home/section-hero' ); ?>
		<?php get_template_part( 'layout/blocks/section-image-blocks' ); ?>
		<?php get_template_part( 'layout/section-sign-up' ); ?>

	</main>

</div><!-- .container -->

<?php get_footer(); ?>
