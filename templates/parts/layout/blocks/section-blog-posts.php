<?php $heading = get_sub_field( 'section_heading' ); ?>
<section class="section-blog-posts" id="<?php echo esc_attr( get_sub_field( 'section_id' ) ?: uniqid() ) ?>">
	<div class="section-blog-posts__wrapper">
		<?php if ( $heading ) : ?>
			<h2 class="section-blog-posts__heading"><?php echo esc_html( $heading ) ?></h2>
		<?php endif; ?>
		<?php
		$blog_query = new WP_Query( [
			'post_type'      => 'post',
			'posts_per_page' => 100,
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
