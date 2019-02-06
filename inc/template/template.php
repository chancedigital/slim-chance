<?php
/**
 * Custom template-related functions for this theme.
 *
 * @package slim-chance
 */

namespace ChanceDigital\SlimChance\Template;

add_filter( 'body_class', __NAMESPACE__ . '\\slim_chance_body_classes' );

/**
 * Filter body classes for pages.
 *
 * @param  array $classes  Class list.
 * @return array           Modified class list.
 */
function slim_chance_body_classes( array $classes ) {

	// Add page slug if it doesn't exist.
	if ( is_single() || is_page() && ! is_front_page() ) {
		$page_slug = basename( get_permalink() );
		if ( ! in_array( $page_slug, $classes, true ) ) {
			$classes[] = $page_slug;
		}
	}

	// Clean up class names for custom templates.
	$classes = array_map( function ( $class ) {
		return preg_replace( [ '/(-php)?$/', '/^templates/', '/^page-templates/' ], '', $class );
	}, $classes );
	return array_filter( $classes );
}
