<?php
/**
 * Location search form powered by Google Places API
 *
 * @package slim-chance
 */

?>
<div class="location-search-form">
	<form class="location-search-form__form" role="search" id="js-location-search-form">
		<label class="location-search-form__label screen-reader-text" for="js-location-search-address">Your Address</label>
		<input class="location-search-form__input" id="js-location-search-address" type="text" name="address" class="controls" placeholder="Your Address" required />
		<input class="location-search-form__input location-search-form__input--hidden" id="js-location-search-lat" type="hidden" name="lat" />
		<input class="location-search-form__input location-search-form__input--hidden" id="js-location-search-lng" type="hidden" name="lng" />
		<button class="button location-search-form__submit">Search Stores</button>
	</form>
</div>
