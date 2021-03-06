<?php

use function ChanceDigital\Slim_Chance\Icons\get_svg;
use function ChanceDigital\Slim_Chance\Template\get_address_from_location_post;

$open_status        = get_field( 'open_status' );
$status_explanation = get_field( 'status_explanation' );
$phone              = get_field( 'phone' );
$map_url            = get_field( 'map_link' );
$has_carryout       = get_field( 'carryout' );
$has_delivery       = get_field( 'delivery' );
$online_order       = get_field( 'online_order' );
$doordash_id        = get_field( 'doordash_id' );
$has_phone          = preg_match(
	'/^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/',
	$phone
);
?>

<div class="location-contact">
	<div class="location-contact__col">
		<address>
			<?php echo get_address_from_location_post() ?>
		</address>

		<?php if ( $open_status === 'temporarily_closed' && $status_explanation ) : ?>

			<div class="location-contact__note">
				<?php echo esc_html( $status_explanation ) ?>
			</div>

		<?php elseif ( $open_status === 'coming_soon' && $status_explanation ) : ?>

			<div class="location-contact__note">
				<?php echo esc_html( $status_explanation ) ?>
			</div>

		<?php elseif ( $open_status === 'open' ) : ?>

			<div class="location-contact__note">
				We do not accept call-in orders. To place an order, please <a href="#section-app-download-bar">download our app</a> or use one of the links below.
			</div>

		<?php endif; ?>

	</div>
	<div class="location-contact__col">

		<?php /* if ( $has_phone ) : ?>

			Call-in orders not desired at this time, want to drive people to the app.
			If this changes in the future let's add this link back.

			<a class="location-contact__button button" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $phone ) ) ?>"><?php _e( 'Call Now', 'slim-chance' ) // phpcs:ignore ?></a>

		<?php endif; */ ?>

		<?php if ( $map_url ) : ?>

			<a class="location-contact__button button" href="<?php echo esc_url( $map_url ) ?>" rel="noopener noreferrer" target="_blank"><?php _e( 'Get Directions', 'slim-chance' ) // phpcs:ignore ?></a>

		<?php endif; ?>

		<?php if ( $open_status === 'open' && $has_delivery && $doordash_id ) : ?>

			<a class="location-contact__button button" href="https://www.doordash.com/store/<?php echo esc_attr( $doordash_id ) ?>/?utm_source=partner-link&utm_medium=website&utm_campaign=<?php echo esc_attr( $doordash_id ) ?>" target="_blank">
				<?php _e( 'Order Delivery', 'slim-chance' ) // phpcs:ignore ?>
				<span class="button__icon">
					<?php echo get_svg( [ 'icon' => 'doordash' ] ) ?>
				</span>
			</a>

		<?php endif; ?>

		<?php if ( $open_status === 'open' && $has_carryout && $online_order ) : ?>

			<a class="location-contact__button button" href="https://slimandhuskys.alohaorderonline.com/Locations.aspx" target="_blank" rel="noreferrer noopener">
				<?php _e( 'Order Carryout', 'slim-chance' ) // phpcs:ignore ?>
			</a>

		<?php endif; ?>

	</div>
</div>
