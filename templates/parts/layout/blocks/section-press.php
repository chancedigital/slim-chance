<?php $heading = get_sub_field( 'section_heading' ); ?>
<section class="section-press" id="<?php echo esc_attr( get_sub_field( 'section_id' ) ?: uniqid() ) ?>">
	<div class="section-press__wrapper">
		<?php if ( $heading ) : ?>
			<h2 class="section-press__heading"><?php echo esc_html( $heading ) ?></h2>
		<?php endif; ?>
		<?php
		$press_query = new WP_Query( [
			'post_type'      => 'press',
			'posts_per_page' => 90,
		] );
		if ( $press_query->have_posts() ) :
			?>
			<ul class="section-press__list">
				<?php
				while ( $press_query->have_posts() ) :
					$press_query->the_post();
					$outlet = get_field( 'press_outlet' );
					$url    = get_field( 'url' );
					?>
					<li class="section-press__list-item">
						<article <?php post_class( 'section-press__article' ) ?>>
							<header class="section-press__article-header">
								<h3 class="section-press__article-outlet">
									<?php echo esc_html( $outlet ); ?>
								</h3>
								<span class="section-press__article-date"><?php echo get_the_date( 'F j, Y' ); ?></span>
							</header>
							<div class="section-press__article-content">
								<a class="section-press__article-link" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
									<?php the_title() ?>
								</a>
							</div>
						</article>

					</li>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</ul>
		<?php endif; ?>
	</div>
</section>
