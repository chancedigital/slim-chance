<?php
$food_menu = get_field( 'food_menu', 'option' );
$ingr_list = get_field( 'ingredient_list', 'option' );
?>
<section class="section-food-menu" id="<?php echo esc_attr( get_sub_field( 'section_id' ) ?: uniqid() ) ?>">
	<div class="section-food-menu__wrapper">
		<header class="section-food-menu__header">
			<h2 class="section-food-menu__heading">
				You Can Get With <strong>This</strong>
			</h2>
			<p class="section-food-menu__subheading">S+H Signature Artisan Pizzas</p>
			<?php if ( $food_menu ) : ?>
				<a
					href="<?php echo esc_url( $food_menu['url'] ) ?>"
					class="section-food-menu__button button"
					target="_blank"
					rel="noreferrer noopener"
				>
					Click to Print
				</a>
			<?php endif; ?>
		</header>

		<?php
		$menu_query = new WP_Query( [
			'post_type'      => 'food',
			'posts_per_page' => 50,
		] );
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

		<footer class="section-food-menu__footer">
			<h2 class="section-food-menu__heading">
				<em>Or</em> You Can Get With <strong>That</strong>
			</h2>
			<p class="section-food-menu__subheading">Build Your Own Pizza</p>
			<?php if ( $ingr_list ) : ?>
				<a
					href="<?php echo esc_url( $ingr_list['url'] ) ?>"
					class="section-food-menu__button button"
					target="_blank"
					rel="noreferrer noopener"
				>
					See All Ingredients
				</a>
			<?php endif; ?>
		</footer>
	</div>
</section>
