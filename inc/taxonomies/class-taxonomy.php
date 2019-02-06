<?php

namespace ChanceDigital\SlimChance\Taxonomies;

class Taxonomy {

	private $slug = '';

	protected $labels = [];

	protected $args = [];

	protected $post_types = [];

	public function __construct( $slug ) {
		$this->set_slug( $slug );
		$this->set_labels();
		$this->set_args();
	}

	private function set_slug( $slug ) {
		$this->slug = str_replace( '-', '_', sanitize_key( $slug ) );
	}

	protected function set_labels() {
		$this->labels = [];
	}

	protected function set_args() {
		$this->args = [];
	}

	protected function set_post_types() {
		$this->post_types = [];
	}

	protected function get_labels() {
		return $this->labels;
	}

	protected function get_args() {
		return $this->args;
	}

	protected function get_post_types() {
		return $this->post_types;
	}

	public function register() {
		if ( ! empty( $this->slug ) && ! empty( $this->args ) && ! empty( $this->labels ) ) {
			$args           = $this->args;
			$args['labels'] = $this->labels;
			register_taxonomy( $this->slug, $this->post_types, $args );
		}
	}
}
