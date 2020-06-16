<?php
/**
 * Single post template.
 *
 * @package slim-chance
 */

use function ChanceDigital\Slim_Chance\Template\get_template_part;

get_header();
?>

<div class="page-wrapper page-single-post">

	<main id="main" class="page-single-post__main">

		<?php get_template_part( 'layout/header/page-header' ); ?>

		<div class="page-single-post__content-wrapper">
			<div class="page-single-post__content-inner">
				<?php the_content() ?>
			</div>
		</div>

		<?php get_template_part( 'layout/section-sign-up' ); ?>

	</main>

</div><!-- .container -->

<?php get_footer(); ?>
