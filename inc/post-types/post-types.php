<?php

namespace ChanceDigital\SlimChance\Post_Types;

use ChanceDigital\SlimChance\Post_Types\Factory;

add_action( 'init', __NAMESPACE__ . '\\register_post_types' );

/**
 * Register our post types.
 * Call the Factory::build method to add post types after creating your new post type class.
 * Post type classes must be added to the `types` sub-directory and a `Types` sub-namespace.
 */
function register_post_types() {
	/**
	 * Factory::build()
	 *
	 * @param $type string Class name.
	 * @param $slug string Post type slug.
	 */
	Factory::build( 'Team', 'team' );
}
