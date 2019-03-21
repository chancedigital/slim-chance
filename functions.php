<?php
/**
 * WP Theme constants and setup functions
 *
 * @package slim-chance
 */

namespace ChanceDigital\SlimChance;

// Composer classes.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

// Constants
require_once __DIR__ . '/inc/constants.php';

// Require function files.
foreach ( [
	'util',
	'autoload',
	'core',
	'cleanup',
	'template',
	'images',
	'icons',
	'rest-api',
] as $inc ) {
	$filename = SLIM_CHANCE_INC . "$inc/$inc.php";
	if ( file_exists( $filename ) ) {
		require_once $filename;
	}
}

// Run the setup functions.
Core\setup();

/*
$news_posts = [
	[
		'post_title' => 'Nashville Pizza Joint, Slim and Husky’s, Delivering For Its Struggling Neighborhood',
		'post_date'  => '2017-08-10 10:00:00',
		'meta_input' => [
			'press_outlet' => 'CBS News, Press',
			'url'          => 'https://www.cbsnews.com/news/nashville-pizza-joint-slim-and-huskys-delivering-for-its-struggling-neighborhood/',
		],
	],
	[
		'post_title' => 'Booming Nashville Pizza Chain Headed to Fifth + Broadway Project',
		'post_date'  => '2018-12-10 10:00:00',
		'meta_input' => [
			'press_outlet' => 'BizJournals, Press',
			'url'          => 'https://www.bizjournals.com/nashville/news/2018/12/10/booming-nashville-pizza-chain-headed-to-fifth.html',
		],
	],
	[
		'post_title' => 'Slim & Husky’s ‘Pizza Beeria’ Gives Nashville Community Slice of Fame',
		'post_date'  => '2018-07-10 10:00:00',
		'meta_input' => [
			'press_outlet' => 'USA Today, Press',
			'url'          => 'https://www.usatoday.com/story/money/usaandmain/2018/07/10/slim-huskys-nashville-pizza-beeria/723809002/',
		],
	],
	[
		'post_title' => 'Nashville Pizzeria Slim & Husky’s Gains National Attention',
		'post_date'  => '2017-08-11 10:00:00',
		'meta_input' => [
			'press_outlet' => 'Tennessean, Press',
			'url'          => 'https://www.tennessean.com/story/money/2017/08/11/nashville-pizzeria-slim-huskys-gains-national-attention/559049001/',
		],
	],
	[
		'post_title' => 'Slim & Husky’s Celebrates Teachers at Antioch Opening',
		'post_date'  => '2018-06-14 10:00:00',
		'meta_input' => [
			'press_outlet' => 'News Channel 5, Press',
			'url'          => 'https://www.newschannel5.com/news/slim-huskys-celebrates-teachers-at-antioch-opening',
		],
	],
	[
		'post_title' => 'How Three Best Friends Slam-Dunked a Black-Owned Business in Nashville',
		'post_date'  => '2018-07-16 10:00:00',
		'meta_input' => [
			'press_outlet' => 'Essence, Press',
			'url'          => 'https://www.essence.com/culture/three-best-friends-black-owned-pizza-business-nashville-slim-huskys/',
		],
	],
];

foreach ( $news_posts as $news_post ) {
	$news_post['post_type'] = 'press';
	$post_id = wp_insert_post( $news_post, $wp_error );
	if ( ! is_wp_error( $post_id ) ) {
		//
	}
}
 */
