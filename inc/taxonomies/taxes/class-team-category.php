<?php

namespace ChanceDigital\SlimChance\Taxonomies\Taxes;

use ChanceDigital\SlimChance\Taxonomies\Taxonomy;

class Team_Category extends Taxonomy {

	protected function set_labels() {
		$this->labels = [
			'name'              => _x( 'Team Categories', 'taxonomy general name', 'slim-chance' ),
			'singular_name'     => _x( 'Team Category', 'taxonomy singular name', 'slim-chance' ),
			'search_items'      => __( 'Search Team Categories', 'slim-chance' ),
			'all_items'         => __( 'All Team Categories', 'slim-chance' ),
			'parent_item'       => __( 'Parent Team Category', 'slim-chance' ),
			'parent_item_colon' => __( 'Parent Team Category:', 'slim-chance' ),
			'edit_item'         => __( 'Edit Team Category', 'slim-chance' ),
			'update_item'       => __( 'Update Team Category', 'slim-chance' ),
			'add_new_item'      => __( 'Add New Team Category', 'slim-chance' ),
			'new_item_name'     => __( 'New Team Category Name', 'slim-chance' ),
			'menu_name'         => __( 'Team Categories', 'slim-chance' ),
		];
	}

	protected function set_args() {
		$this->args = [
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => [
				'slug'         => 'team-category',
				'hierarchical' => true,
			],
		];
	}

	protected function set_post_types() {
		$this->post_types = [ 'team' ];
	}
}
