<?php
?>

<section class="section-jobs" id="<?php echo esc_attr( get_sub_field( 'section_id' ) ?: uniqid() ) ?>">
	<div class="section-jobs__wrapper">
		<h2 class="section-jobs__heading">Current Openings</h2>
		<?php
		$jobs_query = new WP_Query(
			[
				'post_type'      => 'job',
				'posts_per_page' => 90,
			]
		);
		if ( $jobs_query->have_posts() ) :
			?>
			<ul class="section-jobs__listings">
				<?php
				while ( $jobs_query->have_posts() ) :
					$jobs_query->the_post();
					$locations  = get_field( 'location' );
					$all_states = [];
					$all_cities = [];
					foreach ( $locations as $location ) {
						$all_states[] = get_post_meta( $location->ID, 'state', true );
						$all_cities[] = get_post_meta( $location->ID, 'city', true );
					}
					// list of states and cities stored here.
					// @todo abstraction
					$states     = array_unique( $all_states );
					$cities     = array_unique( $all_cities );
					$cities_str = $cities;
					if ( ! empty( $cities_str ) ) {
						sort( $cities_str );
						$last_index                = count( $cities_str ) - 1;
						$last                      = $cities_str[ $last_index ];
						$cities_str[ $last_index ] = $last_index > 1 ? 'and ' . $last : $last;

						$cities_str = sprintf( 'Now hiring in %s!', implode( ', ', $cities_str ) );
					} else {
						$cities_str = '';
					}
					?>

					<li class="section-jobs__job">
						<?php
						the_title(
							'<h3 class="section-jobs__job-heading">',
							'</h3>'
						);
						?>
						<?php if ( $cities_str ) : ?>
							<p class="section-jobs__cities"><?php echo esc_html( $cities_str ) ?></p>
						<?php endif; ?>
						<a href="<?php echo esc_url( the_permalink() ) ?>" class="section-jobs__button button" rel="bookmark">Apply Now</a>
					</li>

				<?php endwhile; ?>
			</ul>
			<?php
		endif;
		wp_reset_postdata();
		?>
	</div>
</section>
