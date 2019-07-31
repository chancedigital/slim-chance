<?php

use function ChanceDigital\SlimChance\Template\load_more_button;

$heading    = get_sub_field( 'section_heading' );
$section_id = esc_attr( get_sub_field( 'section_id' ) ?: uniqid() );
?>
<section class="section-blog-posts" id="<?php echo $section_id ?>">
	<div class="section-blog-posts__wrapper">
		<?php if ( $heading ) : ?>
			<h2 class="section-blog-posts__heading"><?php echo esc_html( $heading ) ?></h2>
		<?php endif; ?>

		<?php
		$load_more      = get_sub_field( 'load_more' );
		$posts_per_page = (int) get_sub_field( 'posts_per_page' ) ?: (int) get_option( 'posts_per_page' ) ?: 20;
		$categories     = [
			'tax' => 'category',
			'terms' => get_sub_field( 'categories' ),
		];
		$tags           = [
			'tax' => 'post_tag',
			'terms' => get_sub_field( 'tags' ),
		];
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
		$blog_query = new WP_Query(
			[
				'post_type'      => 'post',
				'posts_per_page' => $posts_per_page,
				'tax_query'      => $tax_query,
			]
		);

		if ( $blog_query->have_posts() ) :
			?>
			<ul class="section-blog-posts__list more-wrapper" id="js-posts-container-<?php echo $section_id ?>">
				<?php
				while ( $blog_query->have_posts() ) :
					$blog_query->the_post();
					?>
					<li class="section-blog-posts__list-item">
						<?php get_template_part( 'templates/parts/layout/blocks/post-preview' ); ?>
					</li>
				<?php endwhile; ?>
			</ul>

			<?php if ( $load_more ) : ?>

				<div class="section-blog-posts__load-more-wrapper">
					<?php
					$data_atts = [
						'wrapper-element' => 'li',
						'wrapper-class'   => 'section-blog-posts__list-item',
					];
					load_more_button( $section_id, $blog_query, $data_atts );
					?>
				</div>

				<?php
			endif;
			wp_reset_postdata();
		endif;
		?>
	</div>
</section>
