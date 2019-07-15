<?php
/**
 * Template Name: Flex Layout
 */

use function ChanceDigital\SlimChance\Template\get_flex_content;

get_header();
?>

<div class="page-wrapper page-flex-layout">

	<main id="main" class="page-flex-layout__main">

		<?php
		get_template_part( 'templates/parts/layout/header/page-header' );
		get_flex_content();
		get_template_part( 'templates/parts/layout/section', 'sign-up' );
		?>

	</main>

</div><!-- .container -->

<?php get_footer(); ?>
