Slim Chance
=====================
Custom WordPress theme for the Slim + Huskys website.

## Dependencies

1. [Node & Yarn](https://yarnpkg.com/) - Build packages and 3rd party dependencies are managed through Yarn, so you will need that installed globally. I recommend using [`nvm`](https://github.com/creationix/nvm) to develop with Node v8.12.
2. [Gulp](https://gulpjs.com/) - Gulp is used as the main task runner. it runs Sass, PostCSS, processes images/SVG files, and executes Webpack.
3. [Webpack](https://webpack.js.org/) - Webpack is used to process the JavaScript.
4. [Composer](https://getcomposer.org/) - Install and manage PHP dependencies.

## Getting Started
* From the theme directory, run `yarn start` to begin development.

## Commands

`yarn start` (install dependencies and run initial Gulp)

`yarn watch` (watch)

`yarn build` (build all files)

`yarn deploy` (build all files ready for deployment)

## Theme Features

### JavaScript DOM-based routing
This theme utilizes DOM-based routing for JavaScript, inspired by [Roots by Sage](https://roots.io/sage/docs/theme-development-and-building/). This functionality enables you to run specific scripts on specific pages. Routes (and the scripts they include) run when the route name matches a class on the body element of the current page.

One note: the route must be converted to camel case when the body class in question uses hyphenated strings. So if your body class matches the slug `about-us`, your route name would be `aboutUs`. Note also that the route's file name (e.g., `aboutUs.js`) doesn't have to match the body class. What's important is that the name used for the import that is registered with the router (`aboutUs`) matches.

Every route is defined in its own file in `assets/js/frontend/routes`.

Each route includes two methods: init() and finalize():

```javascript
export default {
	init() {
		// scripts here run on the DOM load event
	},
	finalize() {
		// scripts here fire after init() runs
	}
};
```

The order of execution for routes is:

1. The `init` scripts in the `common` route (after the browser's DOM load event)
2. For each route matching the loaded page (e.g., `home`), the `init` scripts and then the `finalize` scripts
3. The `finalize` scripts in the common route
4.
More than one page-specific route might can a given page. For example, if you register both a route matching all single posts (`singlePost`) and a route for single posts with the video post format (`singleFormatVideo`), both would fire when a video post is viewed.

To add scripts to an existing route, add the desired JavaScript within the route's `init()` or `finalize()` methods. For example, the `init()` method on the `common` route might contain the code needed to toggle your site's menu when its icon is clicked.

Because all routes run after the browser has fired the DOM load event, you do not need to wrap the code in your routes within an event handler that watches for that event (e.g., `jQuery(document).ready()`).

### 3rd party packages
Example of how to add 3rd party packages* and have them included in the theme:

1. From the theme directory, add the package using `yarn`. So if we're using Slick Carousel:
	* Run `yarn add slick-carousel`
	* Add the entry points for the package in your JavaScript and Sass files. If you're using the Slick Carousel, then your theme JS and CSS, respectively, would look like:

```javascript
import 'slick-carousel/slick/slick.min';
```
```scss
@import "~slick-carousel/slick/slick.scss";
@import "~slick-carousel/slick/slick-theme.scss";
```

Running your build might fail if 3rd party packages' relative paths are not configured before imported. For example, to load Slick Carousel's paths add the following line in your `_variables.scss` file:

```scss
// Slick Carousel font path
$slick-font-path: "~slick-carousel/slick/fonts/";

// Slick Carousel ajax-loader.gif path
$slick-loader-path: "~slick-carousel/slick/";
```
