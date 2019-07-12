<?php
use function ChanceDigital\SlimChance\Util\haversine_great_circle_distance;
use function ChanceDigital\SlimChance\Util\meters_to_miles;

/**
 * Template Name: Location Finder
 */

get_header();
?>
<style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
      #target {
        width: 345px;
      }
</style>

<div class="page-wrapper page-location-finder">

	<main id="main" class="page-location-finder__main">

		<?php
		get_template_part( 'templates/parts/layout/header/page-header' );
		if ( isset( $_REQUEST['lat'] ) && isset( $_REQUEST['lng'] ) ) {
			$lat_to     = $_REQUEST['lat'];
			$lng_to     = $_REQUEST['lng'];

			$locations = get_posts( [
				'post_type'      => 'location',
				'posts_per_page' => 50,
			] );
			$locations = array_map( function( $location ) use ( $lat_to, $lng_to ) {
				$loc_id  = $location->ID;
				$address = get_field( 'address', $loc_id );
				$lat     = $address['lat'];
				$lng     = $address['lng'];
				$distance = haversine_great_circle_distance( $lat, $lng, $lat_to, $lng_to );
				return [
					'post'     => $location,
					'lat'      => $lat,
					'lng'      => $lng,
					'distance' => $distance,

				];
			}, $locations );

			usort( $locations, function( $loc_a, $loc_b ) {
				return $loc_a['distance'] > $loc_b['distance'];
			} );

			echo '<ul>';
			foreach ( $locations as $location ) {
				echo '<li>';
				$dist   = meters_to_miles( $location['distance'] );
				$loc_id = $location['post']->ID;
				echo '<h3>' . get_the_title( $loc_id ) . '</h3>';
				echo '<span>' . sprintf( __( '%s miles away', 'slim-chance' ), number_format( round( $dist, 2 ), 2 ) ) . '</span>';
				echo '</li>';
			}
			echo '</ul>';
		}
		get_template_part( 'templates/parts/components/location-search-form' );
		?>

		<?php
		get_template_part( 'templates/parts/layout/section', 'sign-up' );
		?>

	</main>

</div><!-- .container -->
<?php get_footer(); ?>
