<?php
/**
 * Custom template-related functions for this theme.
 *
 * @package slim-chance
 */

namespace ChanceDigital\Slim_Chance\Template;

use function ChanceDigital\Slim_Chance\Icons\get_svg;
use function ChanceDigital\Slim_Chance\Util\convert_state_name;

add_action( 'after_setup_theme', __NAMESPACE__ . '\\add_options_page', 10, 0 );
add_filter( 'body_class',        __NAMESPACE__ . '\\body_classes' );
add_filter( 'script_loader_tag', __NAMESPACE__ . '\\make_ig_tag_async', 10, 2 );
add_shortcode( 'dd_button',      __NAMESPACE__ . '\\shortcode_dd_button' );

/**
 * Extend wp_kses_post to allow HTML tags.
 * TODO: Add support for all valid SVG child elements
 *
 * @param  string $data Text content to filter.
 * @return string       Filtered content containing only the allowed HTML.
 */
function kses_post( $data ) {
	$allowed_tags        = wp_kses_allowed_html( 'post' );
	$allowed_tags['svg'] = [
		'aria-describedby' => true,
		'aria-details'     => true,
		'aria-label'       => true,
		'aria-labelledby'  => true,
		'aria-hidden'      => true,
		'class'            => true,
		'id'               => true,
		'style'            => true,
		'title'            => true,
		'role'             => true,
		'viewBox'          => true,
		'data-*'           => true,
	];
	$allowed_tags['use'] = [
		'href'       => true,
		'xlink:href' => true,
	];
	return wp_kses( $data, $allowed_tags );
}

/**
 * Add an ACF options page.
 * @link https://www.advancedcustomfields.com/resources/options-page/
 *
 * @return void
 */
function add_options_page() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page(
			[
				'page_title' => 'Theme Settings',
				'menu_title' => 'Theme Settings',
				'menu_slug'  => 'theme-settings',
				'capability' => 'edit_posts',
				'redirect'   => false,
			]
		);
	}
}

/**
 * Filter body classes for pages.
 *
 * @param  array $classes  Class list.
 * @return array           Modified class list.
 */
function body_classes( array $classes ) {

	// Add page slug if it doesn't exist.
	if ( is_single() || is_page() && ! is_front_page() ) {
		$page_slug = basename( get_permalink() );
		if ( ! in_array( $page_slug, $classes, true ) ) {
			$classes[] = $page_slug;
		}
	}

	// Clean up class names for custom templates.
	$classes = array_map(
		function ( $class ) {
				return preg_replace( [ '/(-php)?$/', '/^templates/', '/^page-templates/' ], '', $class );
		}, $classes
	);
	return array_filter( $classes );
}

/**
 * Like WP core's get_template_part(), but this lets you pass args to the template file
 * Args are available in the template as $template_args array.
 *
 * @param  string              $file          Filename for the template.
 * @param  string|array|object $template_args Argument list.
 * @param  string|array|object $cache_args    Arguments to cache.
 * @return mixed
 */
function get_template_part( string $file, $template_args = [], $cache_args = [] ) {
	$template_args = wp_parse_args( $template_args );
	$cache_args    = wp_parse_args( $cache_args );
	if ( $cache_args ) {
		foreach ( $template_args as $key => $value ) {
			if ( is_scalar( $value ) || is_array( $value ) ) {
				$cache_args[ $key ] = $value;
			} elseif ( is_object( $value ) && method_exists( $value, 'get_id' ) ) {
				$cache_args[ $key ] = call_user_func( [ $value, 'get_id' ] );
			}
		}
		$cache = wp_cache_get( $file, serialize( $cache_args ) ); // phpcs:ignore
		if ( $cache !== false ) {
			if ( ! empty( $template_args['return'] ) ) {
				return $cache;
			}
			echo $cache; // phpcs:ignore
			return;
		}
	}
	$file_handle = $file;
	do_action( 'start_operation', "slim_chance_template_part::$file_handle" );

	// First check in templates/parts.
	if ( file_exists( SLIM_CHANCE_PATH . "templates/parts/{$file}.php" ) ) {
		$file = SLIM_CHANCE_PATH . "templates/parts/{$file}.php";
	} elseif ( file_exists( SLIM_CHANCE_PATH . "templates/parts/{$file}" ) ) {
		$file = SLIM_CHANCE_PATH . "templates/parts/{$file}";

		// Next check in the root path
	} elseif ( file_exists( SLIM_CHANCE_PATH . "{$file}.php" ) ) {
		$file = SLIM_CHANCE_PATH . "{$file}.php";
	} elseif ( file_exists( SLIM_CHANCE_PATH . $file ) ) {
		$file = SLIM_CHANCE_PATH . $file;

		// If nothing is found, bail.
	} elseif ( ! file_exists( $file ) ) {
		return;
	}
	ob_start();
	$return = require $file;
	$data   = ob_get_clean();
	do_action( 'end_operation', "slim_chance_template_part::$file_handle" );
	if ( $cache_args ) {
		wp_cache_set( $file, $data, serialize( $cache_args ), 3600 ); // phpcs:ignore
	}
	if ( ! empty( $template_args['return'] ) ) {
		return $return === false ? false : $data;
	}
	echo $data; // phpcs:ignore
}

/**
 * Enqueue Instagram emded script.
 * Use in any template before calling `instagram_embed`
 *
 * @return void
 */
function enqueue_instagram_embed_script() {
	$script_handle = 'instagram-embed';
	$script_url    = '//www.instagram.com/embed.js';

	if ( ! wp_script_is( $script_handle, 'enqueued' ) ) {
		wp_enqueue_script( $script_handle, $script_url, [], SLIM_CHANCE_VERSION, false );
	}
}

/**
 * Embed an Instagram post in a template.
 *
 * @param string $ig_url
 * @return void
 */
function instagram_embed( string $ig_url ) {
	// Check for the proper IG embed URL.
	if ( strpos( $ig_url, '//www.instagram.com/p/' ) !== false ) :
		?>
		<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="<?php echo esc_url( $ig_url ) ?>?utm_source=ig_embed&amp;utm_medium=loading" data-instgrm-version="12" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:16px;"> <a href="<?php echo esc_url( $ig_url ) ?>?utm_source=ig_embed&amp;utm_medium=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank"> <div style=" display: flex; flex-direction: row; align-items: center;"> <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div></div></div><div style="padding: 19% 0;"></div><div style="display:block; height:50px; margin:0 auto 12px; width:50px;"><svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-511.000000, -20.000000)" fill="#000000"><g><path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path></g></g></g></svg></div><div style="padding-top: 8px;"> <div style=" color:#3897f0; font-size:14px; font-style:normal; font-weight:550; line-height:18px;"> View this post on Instagram</div></div><div style="padding: 12.5% 0;"></div> <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;"><div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div> <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div></div><div style="margin-left: 8px;"> <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div> <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div></div><div style="margin-left: auto;"> <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div> <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div> <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div></div></div></a></div></blockquote>
		<?php
	endif;
}

/**
 * Add async attribute to the IG embed script tag.
 *
 * @param  string $tag    The `<script>` tag for the enqueued script.
 * @param  string $handle The script's registered handle.
 * @return string         The filtered script tag.
 */
function make_ig_tag_async( string $tag, string $handle ) {
	if ( $handle !== 'instagram-embed' ) {
		return $tag;
	}
	return str_replace( ' src', ' async src', $tag );
}

/**
 * Create an AJAX post loader button.
 *
 * @param  string    $section_id ID for the containing section
 * @param  \WP_Query $query      The WP_Query object. Defaults to the global $wp_query.
 * @param  array     $data_atts  Additional data attributes to add to the button.
 * @return void
 */
function load_more_button( string $section_id, \WP_Query $query = null, $data_atts = [] ) : void {
	if ( empty( $query ) ) {
		global $wp_query;
		$query = $wp_query;
	}
	if ( $query->max_num_pages > 1 ) :
		$section_id = esc_attr( $section_id );
		$button_id  = 'js-load-more-' . $section_id;
		if ( ! empty( $data_atts ) ) {
			$clean_atts = '';
			foreach ( $data_atts as $prop => $value ) {
				$prop        = sanitize_title( $prop );
				$value       = esc_attr( $value );
				$clean_atts .= ' data-' . $prop . '="' . $value . '"';
			}
		}
		?>
		<button
			type="button"
			id="<?php echo esc_attr( $button_id ) ?>"
			class="button button--load-more"
			data-query="<?php echo htmlspecialchars( wp_json_encode( $query->query_vars ), ENT_QUOTES, 'UTF-8' ) // phpcs:ignore ?>"
			data-current-page="<?php echo $query->paged ? (int) $query->paged : 1 ?>"
			data-max-pages="<?php echo (int) $query->max_num_pages ?: null ?>"
			data-offset="<?php echo (int) $query->post_count ?>"
			data-section-id="<?php echo esc_attr( $section_id ) ?>"
			<?php echo $clean_atts // phpcs:ignore ?>
		>
			<?php
			/* translators: 1. Screen-reader opening tag, 2. Sreen-reader closing tag */
			printf( esc_html__( 'Load More%1$s Posts%2$s', 'slim-chance' ), '<span class="screen-reader-text">', '</span>' );
			?>
		</button>
		<?php
	endif;
}

/**
 * Get a formatted address for location posts.
 *
 * @param integer $post_id Post ID; Defaults to current post.
 * @return string          Address as formatted HTML string, if it exists.
 */
function get_address_from_location_post( $post_id = 0 ) {
	global $post;
	$ouput = '';
	if ( function_exists( 'get_field' ) ) {
		if ( ! $post_id ) {
			$post_id = $post->ID;
		}
		$address_1 = get_field( 'address_line_1', $post_id );
		$address_2 = get_field( 'address_line_2', $post_id );
		$city      = get_field( 'city', $post_id );
		$state     = get_field( 'state', $post_id );
		$zip       = get_field( 'zip', $post_id );
		$phone     = get_field( 'phone', $post_id );
		$map_url   = get_field( 'map_link', $post_id );
		$has_phone = preg_match(
			'/^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/',
			$phone
		);
		$ouput    .= $address_1 ? esc_html( $address_1 ) : '';
		$ouput    .= $address_2 ? ( $ouput ? '<br />' : '' ) . esc_html( $address_2 ) : '';
		$ouput    .= $city ? ( $ouput ? '<br />' : '' ) . esc_html( $city ) : '';
		$ouput    .= $state ? ( $city ? ', ' : ( $ouput ? '<br />' : '' ) ) . esc_html( convert_state_name( $state ) ) : '';
		$ouput    .= $zip ? ( $state ? ' ' : ( $city ? ', ' : ( $ouput ? '<br />' : '' ) ) ) . esc_html( $zip ) : '';
		$ouput    .= $has_phone ? ( $ouput ? '<br />' : '' ) . esc_html( $phone ) : '';
	}
	return $ouput;
}

/**
 * Get ACF flex content fields.
 *
 * @return void
 */
function get_flex_content() {
	if ( function_exists( 'have_rows' ) && have_rows( 'page_layout' ) ) {
		while ( have_rows( 'page_layout' ) ) {
			the_row();
			get_template_part( 'layout/blocks/section-' . str_replace( '_', '-', get_row_layout() ) );
		}
	}
}

function shortcode_dd_button( $atts = [] ) {
	$atts = shortcode_atts(
		[
			'id'           => '74682', // default to business ID
			'button_text'  => __( 'Order Delivery', 'slim-chance' ),
			'button_type'  => 'business', // business or store
		], $atts, 'dd_button'
	);

	$id          = esc_attr( $atts['id'] );
	$button_type = esc_attr( $atts['button_type'] );
	$link        = "https://www.doordash.com/{$button_type}/{$id}/?utm_source=partner-link&utm_medium=website&utm_campaign={$id}";

	ob_start();
	?>
	<a class="button" href="<?php echo $link // phpcs:ignore ?>" target="_blank">
		<?php echo esc_html( $atts['button_text'] ) ?>
		<span class="button__icon">
			<?php echo get_svg( [ 'icon' => 'doordash' ] ) ?>
		</span>
	</a>
	<?php
	$out = ob_get_contents();
	ob_end_clean();
	return $out;
}
