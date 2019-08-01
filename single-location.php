<?php
/**
 * Single location template.
 *
 * @package slim-chance
 */

use function ChanceDigital\SlimChance\Template\get_flex_content;

get_header();
?>

<div class="page-wrapper page-single-location">

	<main id="main" class="page-single-location__main">

		<?php get_template_part( 'templates/parts/layout/header/page-header' ); ?>

		<div class="page-single-location__content-wrapper">
					</div>

		<?php
		get_flex_content();
		get_template_part( 'templates/parts/layout/section', 'sign-up' );
		?>

	</main>

</div><!-- .container -->

<?php get_footer(); ?>
