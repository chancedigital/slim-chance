<?php

$heading = get_sub_field( 'section_heading' );
$columns = get_sub_field( 'columns' );
if ( $columns ) :
	?>

	<section class="section-text-columns" id="<?php echo esc_attr( get_sub_field( 'section_id' ) ?: uniqid() ) ?>">
		<div class="section-text-columns__wrapper">
			<?php if ( $heading ) : ?>
				<h2 class="section-text-columns__heading"><?php echo esc_html( $heading ) ?></h2>
			<?php endif; ?>
			<ul class="section-text-columns__list">
				<?php
				foreach ( $columns as $column ) :
					if ( $column['content'] ) :
						?>
						<li class="section-text-columns__list-item">
							<?php echo wp_kses_post( $column['content'] ); ?>
						</li>
						<?php
					endif;
				endforeach;
				?>
			</ul>
		</div>
	</section>

<?php endif; ?>
