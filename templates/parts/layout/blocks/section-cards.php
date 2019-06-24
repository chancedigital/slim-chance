<section class="section-cards" id="<?php echo esc_attr( get_sub_field( 'section_id' ) ?: uniqid() ) ?>">
	<div class="section-cards__wrapper">
		<?php if ( get_sub_field( 'section_heading' ) ) : ?>
			<h2 class="section-cards__heading"><?php echo esc_html( get_sub_field( 'section_heading' ) ) ?></h2>
		<?php endif; ?>
		<?php
		if ( have_rows( 'cards' ) ) :
			while ( have_rows( 'cards' ) ) :
				the_row();
				$image         = get_sub_field( 'image' );
				$content       = get_sub_field( 'content' );
				$button_label  = get_sub_field( 'button_label' );
				$button_type   = get_sub_field( 'button_link_type' );
				?>
				<div class="section-cards__card card">
					<div class="card__image-wrapper">
						<img
							class="card__image"
							src="<?php echo esc_url( $image['url'] ) ?>"
							alt="<?php echo esc_html( $image['alt'] ) ?>"
						/>
					</div>
					<div class="card__content">
						<?php echo do_shortcode( wp_kses_post( $content ) ) ?>
						<?php if ( $button_label ) : ?>

							<?php if ( $button_type === 'onclick' ) : ?>

								<button
									type="button"
									class="button card__button"
									onclick="<?php echo esc_attr( get_sub_field( 'button_click_handler' ) ) ?>"
								>
									<?php echo esc_html( $button_label ) ?>
								</button>

								<?php
							else :
								$href = $button_type === 'internal'
									? get_sub_field( 'button_link_internal' )
									: get_sub_field( 'button_link_external' );

								$target = $button_type === 'internal'
									? '_self'
									: '_blank';

								$rel = $button_type === 'internal'
									? '' // reconsider
									: 'noreferrer noopener';
								?>

								<a
									class="button card__button"
									href="<?php echo esc_url( $href ) ?>"
									target="<?php echo esc_attr( $target ) ?>"
									rel="<?php echo esc_attr( $rel ) ?>"
								>
									<?php echo esc_html( $button_label ) ?>
								</a>

							<?php endif; ?>

						<?php endif; ?>
					</div>
				</div>
				<?php
			endwhile;
		endif;
		?>

	</div>
</section>
