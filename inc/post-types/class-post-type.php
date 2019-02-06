<?php

namespace ChanceDigital\SlimChance\Post_Types;

class Post_Type {

	private $slug = '';

	protected $labels = [];

	protected $args = [];

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

	protected function get_labels() {
		return $this->labels;
	}

	protected function get_args() {
		return $this->args;
	}

	public function register() {
		if ( ! empty( $this->slug ) && ! empty( $this->args ) && ! empty( $this->labels ) ) {
			$args           = $this->args;
			$args['labels'] = $this->labels;
			register_post_type( $this->slug, $args );
		}
	}
}
