<?php $heading = get_sub_field( 'section_heading' ); ?>
<section class="section-blog-posts" id="<?php echo esc_attr( get_sub_field( 'section_id' ) ?: uniqid() ) ?>">
	<div class="section-blog-posts__wrapper">
		<?php if ( $heading ) : ?>
			<h2 class="section-blog-posts__heading"><?php echo esc_html( $heading ) ?></h2>
		<?php endif; ?>
		<?php
		$posts_per_page = (int) get_sub_field( 'posts_per_page' ) ?: (int) get_option( 'posts_per_page' ) ?: 20;
		$categories     = [ 'tax' => 'category', 'terms' => get_sub_field( 'categories' ) ];
		$tags           = [ 'tax' => 'post_tag', 'terms' => get_sub_field( 'tags' ) ];
		$tax_query      = [];
		foreach ( [ $categories, $tags ] as $tax ) {
			if ( isset( $tax['terms'] ) && ! empty( $tax['terms'] ) ) {
				$tax_query[] = [
					'taxonomy' => $tax['tax'],
					'field'    => 'term_id',
					'terms'    => $tax['terms'],
				];
			}
		}
		if ( ! empty( $tax_query ) ) {
			$tax_query['relation'] = 'OR';
		}
		$blog_query = new WP_Query( [
			'post_type'      => 'post',
			'posts_per_page' => $posts_per_page,
			'tax_query'      => $tax_query,
		] );
		if ( $blog_query->have_posts() ) :
			?>
			<ul class="section-blog-posts__list">
				<?php
				while ( $blog_query->have_posts() ) :
					$blog_query->the_post();
					?>
					<li class="section-blog-posts__list-item">
						<article <?php post_class( 'section-blog-posts__article' ) ?>>
							<header class="section-blog-posts__article-header">
								<a class="section-blog-posts__article-link" href="<?php the_permalink() ?>" rel="bookmark">
									<h3 class="section-blog-posts__article-title">
										<?php the_title(); ?>
									</h3>
								</a>
								<span class="section-blog-posts__article-date"><?php echo get_the_date( 'F j, Y' ); ?></span>
							</header>
							<div class="section-blog-posts__article-content">
								<div class="section-blog-posts__article-excerpt">
									<?php the_excerpt(); ?>
								</div>
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
