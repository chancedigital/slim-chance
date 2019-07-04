<?php
$feat_image = get_the_post_thumbnail( $post->ID, 'medium', [ 'class' => 'post-preview__img' ] )
?>

<article <?php post_class( 'post-preview' ) ?>>
	<header class="post-preview__header">
		<?php
		if ( $feat_image ) :
			?>
			<div class="post-preview__img-wrapper">
			<a class="post-preview__img-link" href="<?php get_the_permalink() ?>" rel="bookmark">
				<?php echo $feat_image ?>
			</div>
			<?php
		endif;
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
