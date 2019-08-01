<?php
/**
 * Clean up WordPress defaults
 *
 * @package slim-chance
 */

namespace ChanceDigital\Slim_Chance\Cleanup;

add_action( 'after_setup_theme', __NAMESPACE__ . '\\start_cleanup' );

/**
 * Add hooks.
 */
function start_cleanup() {
	add_action( 'init',          __NAMESPACE__ . '\\cleanup_head' );
	add_filter( 'the_generator', __NAMESPACE__ . '\\remove_rss_version' );
	add_filter( 'wp_head',       __NAMESPACE__ . '\\remove_wp_widget_recent_comments_style', 1 );
	add_action( 'wp_head',       __NAMESPACE__ . '\\remove_recent_comments_style', 1 );
}

/**
 * Clean up HTML head
 */
function cleanup_head() {

	// EditURI link.
	remove_action( 'wp_head', 'rsd_link' );

	// Category feed links.
	remove_action( 'wp_head', 'feed_links_extra', 3 );

	// Post and comment feed links.
	remove_action( 'wp_head', 'feed_links', 2 );

	// Windows Live Writer.
	remove_action( 'wp_head', 'wlwmanifest_link' );

	// Index link.
	remove_action( 'wp_head', 'index_rel_link' );

	// Previous link.
	remove_action( 'wp_head', 'parent_post_rel_link', 10 );

	// Start link.
	remove_action( 'wp_head', 'start_post_rel_link', 10 );

	// Canonical.
	remove_action( 'wp_head', 'rel_canonical', 10 );

	// Shortlink.
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );

	// Links for adjacent posts.
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );

	// WP version.
	remove_action( 'wp_head', 'wp_generator' );

	// Emoji detection script.
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );

	// Emoji styles.
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
}

/**
 * Remove WP version from RSS.
 */
function remove_rss_version() {
	return '';
}

/**
 * Remove injected CSS for recent comments widget.
 */
function remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

/**
 * Remove injected CSS from recent comments widget.
 */
function remove_recent_comments_style() {
	global $wp_widget_factory;
	if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
		remove_action( 'wp_head', [ $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ] );
	}
}
