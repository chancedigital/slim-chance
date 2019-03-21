<?php
/**
 * Template Name: Customer Feedback
 */

get_header();
?>

<div class="page-wrapper page-feedback">

	<main id="main" class="page-feedback__main">

		<?php get_template_part( 'templates/parts/layout/header/page-header' ); ?>

		<section class="page-feedback__content-wrapper">
			<div class="page-feedback__app-wrapper">
				<div class="page-feedback__app" id="js-feedback-app"></div>
			</div>
		</section>

		<?php get_template_part( 'templates/parts/layout/section', 'sign-up' ); ?>

	</main>

</div><!-- .container -->

<?php
get_footer();
