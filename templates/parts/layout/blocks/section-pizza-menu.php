<?php
$pizza_menu = get_field( 'pizza_menu', 'option' );
?>
<section class="section-pizza-menu" id="<?php echo esc_attr( get_sub_field( 'section_id' ) ?: uniqid() ) ?>">
	<div class="section-pizza-menu__wrapper">
		<header class="section-pizza-menu__header">
			<h2 class="section-pizza-menu__heading">
				You Can Get With <strong>This</strong>
			</h2>
			<p class="section-pizza-menu__subheading">S+H Signature Artisan Pizzas</p>
			<?php if ( $pizza_menu ) : ?>
				<a
					href="<?php echo esc_url( $pizza_menu['url'] ) ?>"
					class="section-pizza-menu__button button"
					target="_blank"
					rel="noreferrer noopener"
				>
					Click to Print
				</a>
			<?php endif; ?>
		</header>

		<?php
		$menu_query = new WP_Query(
			[
				'post_type'      => 'pizza',
				'posts_per_page' => 50,
			]
		);
		if ( $menu_query->have_posts() ) :
			?>
			<ul class="section-pizza-menu__menu">
				<?php
				while ( $menu_query->have_posts() ) :
					$menu_query->the_post();
					?>

					<li class="section-pizza-menu__item">
						<?php
						the_title(
							'<h3 class="section-pizza-menu__item-heading">',
							'</h3>'
						);
						?>
						<div class="section-pizza-menu__item-description">
							<?php echo wp_kses_post( get_field( 'description' ) ); ?>
						</div>
					</li>

				<?php endwhile; ?>
			</ul>
			<?php
		endif;
		wp_reset_postdata();
		?>

		<footer class="section-pizza-menu__footer">
			<h2 class="section-pizza-menu__heading">
				<em>Or</em> You Can Get With <strong>That</strong>
			</h2>
			<p class="section-pizza-menu__subheading">Build Your Own Pizza</p>
			<a href="/order-online" class="section-pizza-menu__button button">
				Order Online
			</a>
		</footer>
	</div>
</section>
