<?php
/**
 * Foundation template mods.
 *
 * @package slim-chance
 */

namespace ChanceDigital\SlimChance\Foundation;

add_filter( 'embed_oembed_html', __NAMESPACE__ . '\\responsive_video_oembed_html', 10, 4 );
add_filter( 'post_class',        __NAMESPACE__ . '\\sticky_posts' );

/**
 * Enable Foundation responsive embeds for WP video embeds.
 *
 * @param mixed  $html     The cached HTML result, stored in post meta.
 * @param string $url      The attempted embed URL.
 * @param array  $attr     An array of shortcode attributes.
 * @param int    $post_id  Post ID.
 * @return mixed           Modified HTML.
 */
function responsive_video_oembed_html( $html, $url, $attr, $post_id ) {

	// Whitelist of oEmbed compatible sites that **ONLY** support video.
	// Cannot determine if embed is a video or not from sites that
	// support multiple embed types such as Facebook.
	// Official list can be found here https://codex.wordpress.org/Embeds.
	$video_sites = [
		'youtube', // First for performance.
		'collegehumor',
		'dailymotion',
		'funnyordie',
		'ted',
		'videopress',
		'vimeo',
	];

	// Assume oEmbed is NOT a video unless we pass the checks.
	$is_video = false;

	// Determine if embed is a video.
	foreach ( $video_sites as $site ) {

		// Match on `$html` instead of `$url` because of
		// shortened URLs like `youtu.be` will be missed.
		if ( strpos( $html, $site ) ) {
			$is_video = true;
			break;
		}
	}

	// Process video embed.
	if ( $is_video ) {

		// Find the `<iframe>`.
		$doc = new DOMDocument();
		$doc->loadHTML( $html );
		$tags = $doc->getElementsByTagName( 'iframe' );

		// Get width and height attributes.
		foreach ( $tags as $tag ) {
			$width  = $tag->getAttribute( 'width' );
			$height = $tag->getAttribute( 'height' );
			break;
		}
		$class = 'responsive-embed'; // Foundation class.

		// Determine if aspect ratio is 16:9 or wider.
		if ( is_numeric( $width ) && is_numeric( $height ) && ( $width / $height >= 1.7 ) ) {
			$class .= ' widescreen';
		}

		// Wrap oEmbed markup in Foundation responsive embed.
		return '<div class="' . $class . '">' . $html . '</div>';
	} else {
		return $html;
	}
}

/**
 * Change the class for sticky posts to .wp-sticky to avoid conflicts with Foundation's Sticky plugin.
 *
 * @param  array $classes  Class list.
 * @return array           Modified class list.
 */
function sticky_posts( $classes ) {
	if ( in_array( 'sticky', $classes, true ) ) {
		$classes   = array_diff( $classes, [ 'sticky' ] );
		$classes[] = 'wp-sticky';
	}
	return $classes;
}
