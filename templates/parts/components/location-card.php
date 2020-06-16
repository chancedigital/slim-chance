<?php

use function ChanceDigital\Slim_Chance\Template\get_address_from_location_post;

global $post;

// Get distance passed from parent template
$distance = (float) $template_args['distance'];

// Setup tags.
$tags = [];
if ( $distance ) {
	/* translators: distance in miles */
	$tags[] = sprintf( __( '%s miles away', 'slim-chance' ), number_format( $distance, 2 ) );
}
if ( get_field( 'carryout' ) ) {
	$tags[] = __( 'Carryout', 'slim-chance' );
}
if ( get_field( 'delivery' ) ) {
	$tags[] = __( 'Delivery', 'slim-chance' );
}
?>

<article class="location-card">
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="location-card__img-wrapper">
			<?php the_post_thumbnail( 'medium', [ 'class' => 'location-card__img' ] ); ?>
		</div>
	<?php endif; ?>
	<div class="location-card__content-wrapper">

		<header class="location-card__header">
			<?php the_title( '<h2 class="location-card__heading">', '</h2>' ); ?>
		</header>

		<div class="location-card__content">
			<?php echo get_address_from_location_post() ?>
		</div>

		<footer class="location-card__footer">
			<?php
			if ( ! empty( $tags ) ) {
				echo '<ul class="location-card__tags">';
				foreach ( $tags as $tag ) {
					echo '<li class="location-card__tag">' . $tag . '</li>';
				}
				echo '</ul>';
			}
			?>
		</footer>
	</div>
</article>
