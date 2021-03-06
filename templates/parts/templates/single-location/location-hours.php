<?php
$open_status = get_field( 'open_status' );
?>

<div class="location-hours">
	<div class="location-hours__inner">
		<?php if ( $open_status === 'coming_soon' ) : ?>
			<div>
				<h2><?php _e( 'Store opening soon!', 'slim-chance' ) // phpcs:ignore ?></h2>
			</div>
		<?php elseif ( $open_status === 'temporarily_closed' ) : ?>
			<div>
				<h2><?php _e( 'Temporarily closed', 'slim-chance' ) // phpcs:ignore ?></h2>
			</div>
		<?php elseif ( have_rows( 'hours' ) ) : ?>
			<table class="location-hours__table">
				<tbody class="location-hours__tbody">
					<?php
					while ( have_rows( 'hours' ) ) :
						the_row();
						?>
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
</div>
