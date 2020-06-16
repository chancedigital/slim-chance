<?php
/**
 * Core setup, site hooks and filters.
 *
 * @package slim-chance
 */

namespace ChanceDigital\Slim_Chance\Core;

use function ChanceDigital\Slim_Chance\Util\get_asset_url;
use function ChanceDigital\Slim_Chance\Util\get_asset_version;

/**
 * Set up theme defaults and register supported WordPress features.
 */
function setup() {
	$n = function( $function ) {
		$function = __NAMESPACE__ . "\\$function";
		if ( function_exists( $function ) ) {
			return $function;
		}
	};

	add_action( 'after_setup_theme',         $n( 'i18n' ) );
	add_action( 'after_setup_theme',         $n( 'theme_setup' ) );
	add_action( 'wp_enqueue_scripts',        $n( 'scripts' ) );
	add_action( 'wp_enqueue_scripts',        $n( 'styles' ) );
	add_action( 'widgets_init',              $n( 'widgets' ) );
	add_filter( 'acf/fields/google_map/api', $n( 'acf_map_api' ), 10, 1 );
	add_filter( 'script_loader_tag',         $n( 'script_loader_tag' ), 10, 2 );
}

/**
 * Makes Theme available for translation.
 *
 * Translations can be added to the /languages directory.
 * If you're building a theme based on "slim-chance", change the
 * filename of '/languages/slim-chance.pot' to the name of your project.
 */
function i18n() {
	load_theme_textdomain( 'slim-chance', SLIM_CHANCE_PATH . 'languages' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function theme_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'align-wide' );
	add_theme_support(
		'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		]
	);
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Additional theme support for woocommerce 3.0.+
	// Uncomment as needed.
	//add_theme_support( 'wc-product-gallery-zoom' );
	//add_theme_support( 'wc-product-gallery-lightbox' );
	//add_theme_support( 'wc-product-gallery-slider' );

	// Add featured image sizes.
	// Sizes are optimized and cropped for landscape aspect ratio and
	// optimized for HiDPI displays on 'small' and 'medium' screen sizes.
	add_image_size( 'featured-small', 640, 9999 );
	add_image_size( 'featured-medium', 1280, 9999 );
	add_image_size( 'featured-large', 1440, 9999 );
	add_image_size( 'featured-xlarge', 1920, 9999 );

	// Load editor stylesheet.
	add_editor_style( get_asset_url( 'css', 'editor' ) );

	// Register nav menus.
	register_nav_menus(
		[
			'main-navigation'      => __( 'Main Navigation', 'slim-chance' ),
			'secondary-navigation' => __( 'Secondary Navigation', 'slim-chance' ),
			'footer-navigation'    => __( 'Footer Navigation', 'slim-chance' ),
			'social'               => __( 'Social Navigation', 'slim-chance' ),
		]
	);
}

/**
 * Enqueue scripts for front-end.
 */
function scripts() {
	$gmaps_api_key = esc_html( get_option( 'options_google_maps_api_key' ) );

	// Deregister the jquery version bundled with WordPress.
	wp_deregister_script( 'jquery' );

	// CDN hosted jQuery placed in the header, as some plugins require that jQuery is loaded in the header.
	wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', [], '3.2.1', false );

	// Deregister the jquery-migrate version bundled with WordPress.
	wp_deregister_script( 'jquery-migrate' );

	// CDN hosted jQuery migrate for compatibility with jQuery 3.x.
	wp_register_script( 'jquery-migrate', '//code.jquery.com/jquery-migrate-3.0.1.min.js', [ 'jquery' ], '3.0.1', false );
	wp_enqueue_script( 'jquery-migrate' );

	// Google maps API
	if ( $gmaps_api_key ) {
		wp_enqueue_script( 'googlemaps', '//maps.googleapis.com/maps/api/js?key=' . $gmaps_api_key . '&libraries=places', [], null, false );
		// wp_script_add_data( 'googlemaps', 'script_execution', 'async defer' );
	}

	// Frontend JS.
	wp_register_script( 'frontend', get_asset_url( 'js', 'frontend' ), [ 'jquery' ], get_asset_version( 'js', 'frontend' ), true );
	wp_localize_script(
		'frontend', '__slimChanceAjax__', [
			'baseUrl'              => esc_url( get_site_url() ),
			'themeUrl'             => SLIM_CHANCE_TEMPLATE_URL,
			'customerFeedbackTo'   => esc_html( get_field( 'customer_feedback', 'option' ) ),
			'customerFeedbackFrom' => esc_html( get_field( 'customer_feedback_from', 'option' ) ),
			'ajaxUrl'     => esc_url( admin_url( 'admin-ajax.php' ) ),
			'gMapsApi'    => esc_html( get_option( 'options_google_maps_api_key' ) ),
			'loadButton'  => [
				'loading'     => esc_html__( 'Loading&hellip;', 'slim-chance' ),
				'noPosts'     => esc_html__( 'No Posts Found', 'slim-chance' ),
			],
			'nonce'       => wp_create_nonce( 'load_posts_nonce' ),
		]
	);
	wp_enqueue_script( 'frontend' );

	// Add the comment-reply library on pages where it is necessary.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

/**
 * Add async/defer attributes to enqueued scripts that have the specified script_execution flag.
 *
 * @link https://core.trac.wordpress.org/ticket/12009
 * @param  string $tag    The script tag.
 * @param  string $handle The script handle.
 * @return string
 */
function script_loader_tag( string $tag, string $handle ) {
	$script_execution = wp_scripts()->get_data( $handle, 'script_execution' );

	if ( ! $script_execution ) {
		return $tag;
	}

	if ( ! in_array( $script_execution, [ 'async', 'defer', 'async defer', 'defer async' ], true ) ) {
		return $tag;
	}

	// Abort adding async/defer for scripts that have this script as a dependency. _doing_it_wrong()?
	foreach ( wp_scripts()->registered as $script ) {
		if ( in_array( $handle, $script->deps, true ) ) {
			return $tag;
		}
	}

	// Add the attribute if it hasn't already been added.
	if ( ! preg_match( ":\s$script_execution(=|>|\s):", $tag ) ) {
		$tag = preg_replace( ':(?=></script>):', " $script_execution", $tag, 1 );
	}
	return $tag;
}

/**
 * Enqueue styles for front-end.
 */
function styles() {

	// Typekit.
	wp_enqueue_style( 'typekit', '//use.typekit.net/pyo1eko.css' );

	// Fancybox
	// Unable to import from node_modules due to scoped package import issues, so we'll use the CDN for now
	wp_enqueue_style( 'fancybox', '//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css' );

	// Frontend styles.
	wp_enqueue_style( 'frontend', get_asset_url( 'css', 'frontend' ), [], get_asset_version( 'css', 'frontend' ) );
}

/**
 * Register widget areas.
 */
function widgets() {
	register_sidebar(
		[
			'name'          => 'Main sidebar',
			'id'            => 'main-sidebar',
			'before_widget' => '<div class="sidebar__wrapper">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="sidebar__heading">',
			'after_title'   => '</h3>',
		]
	);
}

/**
 * Return API key for use in ACF filter.
 *
 * @param  string $api Google Maps API key.
 * @return array       API array with key added.
 */
function acf_map_api( $api ) {
	if ( function_exists( '\\get_field' ) ) {
		$api['key'] = get_field( 'google_maps_api_key', 'option' );
		return $api;
	}
}
