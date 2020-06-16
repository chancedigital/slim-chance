<?php
$heading = get_sub_field( 'section_heading' );
$gallery = get_sub_field( 'gallery' );
if ( $gallery ) :
	?>

	<section class="section-image-gallery" id="<?php echo esc_attr( get_sub_field( 'section_id' ) ?: uniqid() ) ?>">
		<div class="section-image-gallery__wrapper">
			<?php if ( $heading ) : ?>
				<h2 class="section-image-gallery__heading"><?php echo esc_html( $heading ) ?></h2>
			<?php endif; ?>
			<ul class="section-image-gallery__list">
				<?php foreach ( $gallery as $image ) : ?>
					<li class="section-image-gallery__list-item">
						<a class="section-image-gallery__image-link" data-fancybox href="<?php echo esc_url( $image['url'] ) ?>">
							<?php
							echo wp_get_attachment_image(
								$image['ID'],
								'thumbnail',
								false,
								[ 'class' => 'section-image-gallery__image' ]
							);
							?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

<?php endif; ?>
