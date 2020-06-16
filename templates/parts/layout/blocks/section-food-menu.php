<?php
$cat_slug = 'food_category';
$_terms   = get_terms( [ $cat_slug ] );
//var_dump( $_terms );

if ( ! empty( $_terms ) ) :
	?>
	<section class="section-food-menu" id="<?php echo esc_attr( get_sub_field( 'section_id' ) ?: uniqid() ) ?>">

		<?php foreach ( $_terms as $_term ) : ?>

			<div class="section-food-menu__wrapper">
				<h2 class="section-food-menu__heading"><?php echo esc_html( $_term->name ) ?></h2>

				<?php
				$menu_query = new WP_Query(
					[
						'post_type'      => 'food',
						'posts_per_page' => 50,
						'tax_query' => [
							[
								'taxonomy' => $cat_slug,
								'field'    => 'slug',
								'terms'    => $_term->slug,
							],
						],
					]
				);
				if ( $menu_query->have_posts() ) :
					?>
					<ul class="section-food-menu__menu">
						<?php
						while ( $menu_query->have_posts() ) :
							$menu_query->the_post();
							?>

							<li class="section-food-menu__item">
								<?php
								the_title(
									'<h3 class="section-food-menu__item-heading">',
									'</h3>'
								);
								?>
								<div class="section-food-menu__item-description">
									<?php echo wp_kses_post( get_field( 'description' ) ); ?>
								</div>
							</li>

						<?php endwhile; ?>
					</ul>
					<?php
				endif;
				wp_reset_postdata();
				?>
			</div>

		<?php endforeach; ?>

	</section>

<?php endif; ?>
