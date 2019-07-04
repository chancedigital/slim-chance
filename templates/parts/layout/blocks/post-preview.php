<article <?php post_class( 'post-preview' ) ?>>
	<header class="post-preview__header">
		<?php
		the_title(
			'<a class="post-preview__link" href="' . get_the_permalink() . '" rel="bookmark"><h3 class="post-preview__title">',
			'</h3></a>'
		);
		?>
		<span class="post-preview__date"><?php echo get_the_date( 'F j, Y' ); ?></span>
	</header>
	<div class="post-preview__content">
		<div class="post-preview__excerpt">
			<?php the_excerpt(); ?>
		</div>
	</div>
</article>
