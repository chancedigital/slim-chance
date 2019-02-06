<?php

namespace ChanceDigital\SlimChance\Post_Types\Types;

use ChanceDigital\SlimChance\Post_Types\Post_Type;

class Team extends Post_Type {

	protected function set_labels() {
		$this->labels = [
			'name'               => _x( 'Team', 'post type general name', 'chancedigital' ),
			'singular_name'      => _x( 'Team Member', 'post type singular name', 'chancedigital' ),
			'menu_name'          => _x( 'Team', 'admin menu', 'chancedigital' ),
			'name_admin_bar'     => _x( 'Team Member', 'add new on admin bar', 'chancedigital' ),
			'add_new'            => _x( 'Add New', 'location', 'chancedigital' ),
			'add_new_item'       => __( 'Add New Team Member', 'chancedigital' ),
			'new_item'           => __( 'New Team Member', 'chancedigital' ),
			'edit_item'          => __( 'Edit Team Member', 'chancedigital' ),
			'view_item'          => __( 'View Team Member', 'chancedigital' ),
			'all_items'          => __( 'All Team Members', 'chancedigital' ),
			'search_items'       => __( 'Search Team', 'chancedigital' ),
			'parent_item_colon'  => __( 'Parent Team Member:', 'chancedigital' ),
			'not_found'          => __( 'No Team Members found.', 'chancedigital' ),
			'not_found_in_trash' => __( 'No Team Members found in Trash.', 'chancedigital' ),
		];
	}

	protected function set_args() {
		$this->args = [
			'description'        => __( 'Description.', 'chancedigital' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'query_var'          => true,
			'capability_type'    => 'post',
			'show_in_rest'       => true,
			'supports'           => [ 'title', 'editor', 'thumbnail' ],
			'menu_icon'          => 'dashicons-groups',
		];
	}
}
