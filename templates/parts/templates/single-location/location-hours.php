<div class="location-hours">
	<?php if ( have_rows( 'hours' ) ) : ?>
		<table class="location-hours__table">
			<tbody class="location-hours__tbody">
				<?php while ( have_rows( 'hours' ) ) : the_row(); ?>
					<tr class="location-hours__row">
						<td class="location-hours__cell location-hours__day"><?php echo esc_html( get_sub_field( 'day' ) ) ?></td>
						<?php
						$open  = get_sub_field( 'open' );
						$close = get_sub_field( 'close' );
						if ( $open === $close ) {
							$range = $open;
						} else {
							$range = "$open – $close";
						}
						?>
						<td class="location-hours__cell location-hours__time"><?php echo esc_html( $range ) ?></td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>
