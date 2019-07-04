<?php
$bg_image = get_sub_field( 'background_image' );
$heading  = get_sub_field( 'heading' );
$content  = get_sub_field( 'content' );
?>

<section class="section-app-download-bar" style="background-image: url(<?php echo esc_url( $bg_image['url'] ) ?>);">
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
			<?php get_template_part( 'templates/parts/components/app-dl-buttons' ); ?>
        </div>
	</div>
</div>
