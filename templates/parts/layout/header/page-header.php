<?php
$bg_img = get_field( 'header_background_image' );
if ( ! $bg_img && is_single() ) {
	$bg_img = get_the_post_thumbnail_url();
}
?>

<div class="page-header">
	<div class="page-header__wrapper">
		<?php if ( is_singular( 'location' ) ) : ?>
			<?php get_template_part( 'templates/parts/templates/single-location/location-hours' ) ?>
		<?php endif; ?>

		<div class="page-header__content-wrapper">
			<h1 class="page-header__heading">
				<?php
				echo is_archive()
					? get_the_archive_title()
					: get_field( 'alternate_page_title' )
						?: get_the_title();
				?>
			</h1>
			<div class="page-header__body">

				<?php if ( is_singular( 'job' ) ) : ?>
					<?php echo wp_kses_post( get_field( 'excerpt' ) ) ?>
				<?php endif; ?>

				<?php echo wp_kses_post( get_field( 'header_paragraph' ) ) ?>

				<?php if ( is_singular( 'location' ) ) : ?>
					<?php get_template_part( 'templates/parts/templates/single-location/location-contact' ) ?>
				<?php endif; ?>

				<?php if ( is_singular( 'post' ) ) : ?>
					<span class="page-header__meta">
						<?php printf( __( 'Published on %s', 'slim-chance' ), get_the_date( 'F j, Y' ) ); ?>
					</span>
				<?php endif; ?>

			</div>
		</div>

		<?php if ( get_page_template_slug() === 'templates/page-feedback.php' ) : ?>
			<?php get_template_part( 'templates/parts/templates/page-feedback/question-blocks' ) ?>
		<?php endif; ?>

	</div>
</div>

<?php if ( $bg_img ) : ?>

	<style type="text/css">
	.page-header {
		background-image: url(<?php echo esc_url( is_array( $bg_img ) ? $bg_img['url'] : $bg_img ); ?>);
	}
	</style>

<?php endif; ?>
