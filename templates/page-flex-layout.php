<?php
/**
 * Template Name: Flex Layout
 */

get_header();
?>

<div class="page-wrapper page-flex-layout">

	<main id="main" class="page-flex-layout__main">

		<?php
		get_template_part( 'templates/parts/layout/header/page-header' );
		if ( have_rows( 'page_layout' ) ) {
			while ( have_rows( 'page_layout' ) ) {
				the_row();
				get_template_part( 'templates/parts/layout/blocks/section-' . str_replace( '_', '-', get_row_layout() ) );
			}
		}
		get_template_part( 'templates/parts/layout/section', 'sign-up' );
		?>

	</main>

</div><!-- .container -->

<?php get_footer(); ?>
