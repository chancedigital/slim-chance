<section class="section-locations" id="<?php echo esc_attr( get_sub_field( 'section_id' ) ?: uniqid() ) ?>">
	<div class="section-locations__wrapper">
		<h2 class="section-locations__heading">All Slim & Husky’s Restaurants</h2>
		<div class="section-locations__list-wrapper">
			<?php
			// phpcs:disable
			$all_locations = get_posts( [
				'post_type'   => 'location',
				'numberposts' => -1,
				] );
			// phpcs:enable

			$all_states = [];
			$all_cities = [];
			foreach ( $all_locations as $location ) {
				$all_states[] = get_post_meta( $location->ID, 'state', true );
				$all_cities[] = get_post_meta( $location->ID, 'city', true );
			}
			// list of states and cities stored here.
			$states = array_unique( $all_states );
			$cities = array_unique( $all_cities );

			if ( $states ) :
				?>
				<ul class="section-locations__states">
					<?php foreach ( $states as $state ) : ?>
						<li class="section-locations__state">
							<h3 class="section-locations__state-heading">
								<?php echo esc_html( $state ) ?>
							</h3>
							<ul class="section-locations__locations">
								<?php
								$location_query = new WP_Query( [
									'post_type'      => 'location',
									'posts_per_page' => 50,
									'order'          => 'ASC',
									'orderby'        => 'meta_value',
									'meta_key'       => 'city',
									'meta_query'     => [
										[
											'key'     => 'state',
											'value'   => $state,
											'compare' => '=',
										],
									],
								] );
								while ( $location_query->have_posts() ) :
									$location_query->the_post();
									?>
									<li class="section-locations__location">
										<span class="section-locations__city"><?php echo esc_html( get_field( 'city' ) ) ?></span>
										<span class="section-locations__sep">//</span>
										<span class="section-locations__location-label"><?php the_title(); ?></span>
										<a href="<?php echo esc_url( the_permalink() ) ?>" rel="bookmark" class="section-locations__location-link">Details</a>
									</li>
									<?php
								endwhile;
								wp_reset_postdata();
								?>
							</ul>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</section>
