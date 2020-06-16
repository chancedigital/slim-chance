<div class="image-blocks" id="<?php echo esc_attr( get_sub_field( 'section_id' ) ?: uniqid() ) ?>">
	<?php
	if ( have_rows( 'image_blocks' ) ) :
		while ( have_rows( 'image_blocks' ) ) :
			the_row();
			$block_image   = get_sub_field( 'block_image' );
			$block_content = get_sub_field( 'block_content' );
			$block_type    = $block_content['content_type'];
			$button_label  = $block_content['button_label'];
			$button_type   = $block_content['button_link_type'];
			?>

			<section class="image-blocks__block">
				<div class="image-blocks__image-wrapper">
					<img
						class="image-blocks__image"
						src="<?php echo esc_url( $block_image['url'] ) ?>"
						alt="<?php echo esc_html( $block_image['alt'] ) ?>"
					/>
				</div>
				<div class="image-blocks__content-wrapper">

					<?php if ( $block_type === 'blockquote' ) : ?>

						<blockquote class="image-blocks__quote">
							<?php echo wp_kses_post( $block_content['quote_text'] ) ?>

							<?php if ( $block_content['quote_credit'] ) : ?>

								<footer class="image-blocks__quote-footer">
									<cite class="image-blocks__quote-cite">
										<?php echo esc_html( $block_content['quote_credit'] ) ?>
									</cite>
								</footer>

							<?php endif; ?>

						</blockquote>

					<?php elseif ( $block_type === 'heading-body' ) : ?>

						<h2 class="image-blocks__heading"><?php echo esc_html( $block_content['heading'] ) ?></h2>
						<div class="image-blocks__body"><?php echo wp_kses_post( $block_content['body'] ) ?></div>

					<?php endif; ?>

					<?php if ( $button_label ) : ?>

						<?php if ( $button_type === 'onclick' ) : ?>

							<button
								type="button"
								class="button image-blocks__button"
								onclick="<?php echo esc_attr( $block_content['button_click_handler'] ) ?>"
							>
								<?php echo esc_html( $button_label ) ?>
							</button>

							<?php
						else :
							$href = $button_type === 'internal'
								? $block_content['button_link_internal']
								: $block_content['button_link_external'];

							$target = $button_type === 'internal'
								? '_self'
								: '_blank';

							$rel = $button_type === 'internal'
								? '' // reconsider
								: 'noreferrer noopener';
							?>

							<a
								class="button image-blocks__button"
								href="<?php echo esc_url( $href ) ?>"
								target="<?php echo esc_attr( $target ) ?>"
								rel="<?php echo esc_attr( $rel ) ?>"
							>
								<?php echo esc_html( $button_label ) ?>
							</a>

						<?php endif; ?>

					<?php endif; ?>

				</div>
			</section>

			<?php
		endwhile;
	endif;
	?>

</div>
