<?php

use function ChanceDigital\SlimChance\Template\get_address_from_location_post;

$phone     = get_field( 'phone' );
$map_url   = get_field( 'map_link' );
$has_phone = preg_match(
	'/^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/',
	$phone
);
?>

<div class="location-contact">
	<div class="location-contact__col">
		<address>
			<?php echo get_address_from_location_post() ?>
		</address>
	</div>
	<div class="location-contact__col">
		<?php if ( $has_phone ) : ?>
			<a class="location-contact__button button" href="tel:<?php echo preg_replace( '/[^0-9]/', '', esc_attr( $phone ) ) ?>">Call Now</a>
		<?php endif; ?>
		<?php if ( $map_url ) : ?>
			<a class="location-contact__button button" href="<?php echo esc_url( $map_url ) ?>" rel="noopener noreferrer" target="_blank">Get Directions</a>
		<?php endif; ?>
	</div>
</div>
