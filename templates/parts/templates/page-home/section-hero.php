<?php

$page_header_background_image = get_field( 'page_header_background_image' );
$page_header_content          = get_field( 'page_header_content' );
$page_heading                 = $page_header_content['heading'];
$page_subheading              = $page_header_content['subheading'];
$button_label                 = $page_header_content['button_label'];
$button_type                  = $page_header_content['button_link_type'];
?>

<section class="home-hero">
	<div class="home-hero__wrapper">

		<?php if ( $page_header_background_image ) : ?>
			<div class="home-hero__image-wrapper">
				<img
					class="home-hero__image"
					src="<?php echo esc_url( $page_header_background_image['url'] ) ?>"
					alt="<?php echo esc_attr( $page_header_background_image['alt'] ) ?>"
				/>
			</div>
		<?php endif; ?>

		<?php if ( $page_header_content ) : ?>

			<div class="home-hero__content">
				<h1 class="home-hero__heading"><?php echo esc_html( $page_header_content['heading'] ) ?></h1>
				<p class="home-hero__subheading"><?php echo esc_html( $page_header_content['subheading'] ) ?></p>

				<?php
				if ( $button_label && $button_type ) :
					$href = $button_type === 'internal'
						? $page_header_content['button_link_internal']
						: $page_header_content['button_link_external'];

					$target = $button_type === 'internal'
						? '_self'
						: '_blank';

					$rel = $button_type === 'internal'
						? ''
						: 'noreferrer noopener';
					?>

					<a
						class="button home-hero__button"
						href="<?php echo esc_url( $href ) ?>"
						target="<?php echo esc_attr( $target ) ?>"
						rel="<?php echo esc_attr( $rel ) ?>"
					>
						<?php echo esc_html( $button_label ) ?>
					</a>
				<?php endif ?>
			</div>

		<?php endif; ?>

	</div>
</section>
