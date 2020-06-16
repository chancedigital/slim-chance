<?php
/**
 * Single job template.
 *
 * @package slim-chance
 */

use function ChanceDigital\Slim_Chance\Template\get_template_part;

get_header();
?>

<div class="page-wrapper page-single-job">

	<main id="main" class="page-single-job__main">

		<?php get_template_part( 'layout/header/page-header' ); ?>

		<div class="page-single-job__content-wrapper">
			<div class="page-single-job__content-inner">
				<div class="page-single-job__content">
					<?php echo wp_kses_post( get_field( 'description' ) ); ?>
				</div>
				<h2 lass="page-single-job__apply-heading">Apply Now</h2>
				<?php echo do_shortcode( '[contact-form-7 id="244" title="Job Application"]' ); ?>
			</div>
		</div>

		<?php get_template_part( 'layout/section-sign-up' ); ?>

	</main>

</div><!-- .container -->

<?php get_footer(); ?>
