<?php
/**
 * Various utility functions.
 *
 * @package slim-chance
 */

namespace ChanceDigital\SlimChance\Util;

/**
 * Checks if an array is multidimensional.
 *
 * @param  array $a Array to check.
 * @return bool     Whether or not the array is multidimensional.
 */
function is_multi_array( array $a = [] ) : bool {
	foreach ( $a as $v ) {
		if ( is_array( $v ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Convert state names to abbreviations and vice versa.
 * @link https://awesometoast.com/php-state-names/
 *
 * @param  string $name State name or abbreviation.
 * @return string       Converted name or abbreviation.
 */
function convert_state_name( string $name ) : string {
	$states = array(
		[ 'name' => 'Alabama',        'abbr' => 'AL' ],
		[ 'name' => 'Alaska',         'abbr' => 'AK' ],
		[ 'name' => 'Arizona',        'abbr' => 'AZ' ],
		[ 'name' => 'Arkansas',       'abbr' => 'AR' ],
		[ 'name' => 'California',     'abbr' => 'CA' ],
		[ 'name' => 'Colorado',       'abbr' => 'CO' ],
		[ 'name' => 'Connecticut',    'abbr' => 'CT' ],
		[ 'name' => 'Delaware',       'abbr' => 'DE' ],
		[ 'name' => 'Florida',        'abbr' => 'FL' ],
		[ 'name' => 'Georgia',        'abbr' => 'GA' ],
		[ 'name' => 'Hawaii',         'abbr' => 'HI' ],
		[ 'name' => 'Idaho',          'abbr' => 'ID' ],
		[ 'name' => 'Illinois',       'abbr' => 'IL' ],
		[ 'name' => 'Indiana',        'abbr' => 'IN' ],
		[ 'name' => 'Iowa',           'abbr' => 'IA' ],
		[ 'name' => 'Kansas',         'abbr' => 'KS' ],
		[ 'name' => 'Kentucky',       'abbr' => 'KY' ],
		[ 'name' => 'Louisiana',      'abbr' => 'LA' ],
		[ 'name' => 'Maine',          'abbr' => 'ME' ],
		[ 'name' => 'Maryland',       'abbr' => 'MD' ],
		[ 'name' => 'Massachusetts',  'abbr' => 'MA' ],
		[ 'name' => 'Michigan',       'abbr' => 'MI' ],
		[ 'name' => 'Minnesota',      'abbr' => 'MN' ],
		[ 'name' => 'Mississippi',    'abbr' => 'MS' ],
		[ 'name' => 'Missouri',       'abbr' => 'MO' ],
		[ 'name' => 'Montana',        'abbr' => 'MT' ],
		[ 'name' => 'Nebraska',       'abbr' => 'NE' ],
		[ 'name' => 'Nevada',         'abbr' => 'NV' ],
		[ 'name' => 'New Hampshire',  'abbr' => 'NH' ],
		[ 'name' => 'New Jersey',     'abbr' => 'NJ' ],
		[ 'name' => 'New Mexico',     'abbr' => 'NM' ],
		[ 'name' => 'New York',       'abbr' => 'NY' ],
		[ 'name' => 'North Carolina', 'abbr' => 'NC' ],
		[ 'name' => 'North Dakota',   'abbr' => 'ND' ],
		[ 'name' => 'Ohio',           'abbr' => 'OH' ],
		[ 'name' => 'Oklahoma',       'abbr' => 'OK' ],
		[ 'name' => 'Oregon',         'abbr' => 'OR' ],
		[ 'name' => 'Pennsylvania',   'abbr' => 'PA' ],
		[ 'name' => 'Rhode Island',   'abbr' => 'RI' ],
		[ 'name' => 'South Carolina', 'abbr' => 'SC' ],
		[ 'name' => 'South Dakota',   'abbr' => 'SD' ],
		[ 'name' => 'Tennessee',      'abbr' => 'TN' ],
		[ 'name' => 'Texas',          'abbr' => 'TX' ],
		[ 'name' => 'Utah',           'abbr' => 'UT' ],
		[ 'name' => 'Vermont',        'abbr' => 'VT' ],
		[ 'name' => 'Virginia',       'abbr' => 'VA' ],
		[ 'name' => 'Washington',     'abbr' => 'WA' ],
		[ 'name' => 'West Virginia',  'abbr' => 'WV' ],
		[ 'name' => 'Wisconsin',      'abbr' => 'WI' ],
		[ 'name' => 'Wyoming',        'abbr' => 'WY' ],
		[ 'name' => 'Virgin Islands', 'abbr' => 'V.I.' ],
		[ 'name' => 'Guam',           'abbr' => 'GU' ],
		[ 'name' => 'Puerto Rico',    'abbr' => 'PR' ],
	);

	$return = false;
	$strlen = strlen( $name );

	foreach ( $states as $state ) :
		if ( $strlen < 2 ) {
			return false;
		} elseif ( $strlen === 2 ) {
			if ( strtolower( $state['abbr'] ) === strtolower( $name ) ) {
				$return = $state['name'];
				break;
			}
		} else {
			if ( strtolower( $state['name'] ) === strtolower( $name ) ) {
				$return = strtoupper( $state['abbr'] );
				break;
			}
		}
	endforeach;

	return $return;
}

/**
 * Determines whether or not a value is a whole number (can be parsed as a valid integer).
 * Example: '6', '6.00', 6, or 6.000 all return `true`
 *          '6.01', '10e5', or 6.0001 will all return `false`
 *
 * @param  mixed $var Variable to test.
 * @return bool       Whether or not the value is a whole number.
 */
function is_whole_number( $var ) : bool {
	return ( is_numeric( $var ) && ( intval( $var ) == floatval( $var ) ) ); // phpcs:ignore
}

/**
 * Calculates the great-circle distance between two points, with
 * the Haversine formula.
 * @param  float $latitude_from  Latitude of start point in [deg decimal]
 * @param  float $longitude_from Longitude of start point in [deg decimal]
 * @param  float $latitude_to    Latitude of target point in [deg decimal]
 * @param  float $longitude_to   Longitude of target point in [deg decimal]
 * @param  float $earth_radius   Mean earth radius in [m]
 * @return float                 Distance between points in [m] (same as earth_radius)
 */
function haversine_great_circle_distance(
	float $latitude_from,
	float $longitude_from,
	float $latitude_to,
	float $longitude_to,
	float $earth_radius = 6371000
) : float {
	// convert from degrees to radians
	$lat_from     = deg2rad( $latitude_from );
	$long_to_from = deg2rad( $longitude_from );
	$lat_to       = deg2rad( $latitude_to );
	$long_to_to   = deg2rad( $longitude_to );

	$lat_delta = $lat_to - $lat_from;
	$long_delta = $long_to_to - $long_to_from;

	$angle = 2 * asin( sqrt( pow( sin( $lat_delta / 2 ), 2 ) + cos( $lat_from ) * cos( $lat_to ) * pow( sin( $long_delta / 2 ), 2 ) ) );
	return $angle * $earth_radius;
}

/**
 * Convert meters to miles.
 *
 * @param  float $meters Distance in meters to convert.
 * @return float         Distance in miles.
 */
function meters_to_miles( float $meters ) : float {
	return $meters / 1609.344;
}
