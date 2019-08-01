<?php
/**
 * The main template file.
 *
 * @package slim-chance
 */

use function ChanceDigital\Slim_Chance\Template\get_template_part;

get_header();
?>

<div class="page-wrapper page-index">

	<main id="main" class="page-index__main">

		<?php get_template_part( 'layout/header/page-header' ); ?>

		<div class="page-index__content-wrapper">
			<div class="page-index__content-inner">
				<?php the_content(); ?>
			</div>
		</div>

		<?php get_template_part( 'layout/section-sign-up' ); ?>

	</main>

</div><!-- .container -->

<?php get_footer(); ?>
