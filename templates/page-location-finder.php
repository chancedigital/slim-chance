<?php
/**
 * Template Name: Location Finder
 */

// phpcs:disable WordPress.Security

use function ChanceDigital\Slim_Chance\Template\get_flex_content;
use function ChanceDigital\Slim_Chance\Template\get_template_part;
use function ChanceDigital\Slim_Chance\Util\haversine_great_circle_distance;
use function ChanceDigital\Slim_Chance\Util\meters_to_miles;

get_header();
?>

<div class="page-wrapper page-location-finder">

	<?php get_template_part( 'layout/header/page-header' ); ?>

	<div class="page-location-finder__content-wrapper">

		<main id="main" class="page-location-finder__main">

			<?php
			$location_posts = get_posts(
				[
					'post_type'      => 'location',
					'posts_per_page' => 50,
				]
			);
			if ( isset( $_REQUEST['lat'] ) && isset( $_REQUEST['lng'] ) ) {
				try {
					$lat_to = (float) $_REQUEST['lat'];
					$lng_to = (float) $_REQUEST['lng'];

					$locations = array_map(
						function( $location ) use ( $lat_to, $lng_to ) {
								$loc_id   = $location->ID;
								$address  = get_field( 'address', $loc_id );
								$lat      = is_array( $address ) ? (float) $address['lat'] : 0;
								$lng      = is_array( $address ) ? (float) $address['lng'] : 0;
								$distance = $lat && $lng ? haversine_great_circle_distance( $lat, $lng, $lat_to, $lng_to ) : 0;
								return [
									'post'     => $location,
									'lat'      => $lat ?: null,
									'lng'      => $lng ?: null,
									'distance' => $distance ?: null,

								];
						}, $location_posts
					);

					usort(
						$locations, function( $loc_a, $loc_b ) {
							if ( ! isset( $loc_a['distance'] ) && ! isset( $loc_b['distance'] ) ) {
								return 0;
							}
							if ( ! isset( $loc_a['distance'] ) ) {
								return 1;
							}
							if ( ! isset( $loc_b['distance'] ) ) {
								return -1;
							}
							return $loc_a['distance'] > $loc_b['distance'] ? 1 : -1;
						}
					);
				} catch ( \Exception $e ) {
					// TODO: Error handling
					error_log( $e ); // phpcs:ignore
				}
			} else {
				$locations = array_map(
					function( $location ) {
							return [
								'post'     => $location,
								'lat'      => null,
								'lng'      => null,
								'distance' => null,
							];
					}, $location_posts
				);
			}
			echo '<ul class="page-location-finder__location-list">';
			foreach ( $locations as $location ) {
				$dist   = isset( $location['distance'] ) ? meters_to_miles( $location['distance'] ) : null;
				$loc_id = isset( $location['post'] ) ? $location['post']->ID : null;
				if ( $loc_id ) {
					$post = $loc_id; // phpcs:ignore
					setup_postdata( $post );
					echo '<li class="page-location-finder__location">';
					echo '<a class="page-location-finder__location-link" href="' . esc_url( get_permalink() ) . '" rel="bookmark">';
					get_template_part( 'components/location-card', [ 'distance' => $dist ] );
					echo '</a></li>';
				}
				wp_reset_postdata();
			}
			echo '</ul>';
			?>

		</main>

		<aside id="aside" class="page-location-finder__sidebar">
			<?php get_template_part( 'components/location-search-form' ) ?>
		</aside>
	</div>

	<?php
	get_flex_content();
	get_template_part( 'layout/section-sign-up' );
	?>


</div><!-- .container -->
<?php get_footer(); ?>
