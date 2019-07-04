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
 * @return boolean  Whether or not the array is multidimensional.
 */
function is_multi_array( array $a = [] ) {
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
function convert_state_name( string $name ) {
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
