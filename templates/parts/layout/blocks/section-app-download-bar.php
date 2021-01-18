<?php

use function ChanceDigital\Slim_Chance\Template\get_template_part;

$bg_image        = get_sub_field( 'background_image' );
$heading         = get_sub_field( 'heading' );
$content         = get_sub_field( 'content' );
$show_app_screen = get_sub_field( 'show_app_screen' );
$app_screen      = get_sub_field( 'app_screen' );
$section_id      = esc_attr( get_sub_field( 'section_id' ) ?: 'section-app-download-bar' );

$classnames = [ 'section-app-download-bar' ];
if ( get_sub_field( 'dark_text' ) ) {
	$classnames[] = 'section-app-download-bar--dark-text';
}
if ( $show_app_screen && $app_screen ) {
	$classnames[] = 'section-app-download-bar--has-img';
}
?>

<section class="<?php echo esc_attr( implode( ' ', $classnames ) ) ?>" style="background-image: url(<?php echo esc_url( $bg_image['url'] ) ?>);" id="<?php echo $section_id // phpcs:ignore ?>">
	<div class="section-app-download-bar__wrapper">
		<div class="section-app-download-bar__content-wrapper">
			<?php if ( $heading ) : ?>
				<h2 class="section-app-download-bar__heading">
					<?php echo esc_html( $heading ) ?>
				</h2>
			<?php endif; ?>
			<?php if ( $content ) : ?>
				<div class="section-app-download-bar__content">
					<?php echo do_shortcode( wp_kses_post( $content ) ) ?>
				</div>
			<?php endif; ?>
			<?php get_template_part( 'components/app-dl-buttons' ); ?>
		</div>

		<?php if ( $show_app_screen && $app_screen ) : ?>

			<img class="section-app-download-bar__img" role="presentation" src="<?php echo esc_url( $app_screen['url'] ) ?>" alt="<?php echo esc_url( $app_screen['alt'] ) ?>" />

		<?php endif; ?>
	</div>
</div>
