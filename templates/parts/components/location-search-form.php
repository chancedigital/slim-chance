<?php
/**
 * Location search form powered by Google Places API
 *
 * @package slim-chance
 */

?>
<div class="location-search-form">
	<h2 class="location-search-form__heading"><?php _e( 'Find Your Store', 'slim-chance' ); ?></h2>
	<form class="location-search-form__form" role="search" id="js-location-search-form">
		<label class="location-search-form__label screen-reader-text" for="js-location-search-address">Your Address</label>
		<input class="location-search-form__input" id="js-location-search-address" type="text" name="address" class="controls" placeholder="Your Address" required />
		<input class="location-search-form__input location-search-form__input--hidden" id="js-location-search-lat" type="hidden" name="lat" />
		<input class="location-search-form__input location-search-form__input--hidden" id="js-location-search-lng" type="hidden" name="lng" />
		<button class="button location-search-form__submit" id="js-location-search-submit" disabled>Search Stores</button>
	</form>
</div>
