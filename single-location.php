<?php
/**
 * Single location template.
 *
 * @package slim-chance
 */

use function ChanceDigital\Slim_Chance\Template\get_flex_content;
use function ChanceDigital\Slim_Chance\Template\get_template_part;

get_header();
?>

<div class="page-wrapper page-single-location">

	<main id="main" class="page-single-location__main">

		<?php get_template_part( 'layout/header/page-header' ); ?>

		<div class="page-single-location__content-wrapper">
					</div>

		<?php
		get_flex_content();
		get_template_part( 'layout/section-sign-up' );
		?>

	</main>

</div><!-- .container -->

<?php get_footer(); ?>
