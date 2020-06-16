<?php
$job_title = get_field( 'job_title' );
$quote     = get_field( 'featured_quote' );
$bio       = get_field( 'bio' );
$img       = get_the_post_thumbnail();
$high_res  = get_field( 'high_resolution_headshot' );

// wrapper class
$wrapper_class = 'section-team-members__team-member';
if ( $img ) {
	$wrapper_class .= " $wrapper_class--has-image";
}
?>

<article <?php post_class( $wrapper_class ) ?>>
	<header class="section-team-members__team-member-header">
		<?php the_title( '<h3 class="section-team-members__team-member-heading">', '</h3>' ); ?>
		<span class="section-team-members__team-member-job-title">
			<?php echo esc_html( $job_title ); ?>
		</span>
	</header>
	<?php if ( $img ) : ?>

		<?php if ( $high_res ) : ?>

			<a data-fancybox href="<?php echo esc_url( $high_res['url'] ) ?>">
				<div class="section-team-members__team-member-image-wrapper">
					<?php the_post_thumbnail( 'large', [ 'class' => 'section-team-members__team-member-image' ] ); ?>
				</div>
			</a>

		<?php else : ?>

			<div class="section-team-members__team-member-image-wrapper">
				<?php the_post_thumbnail( 'large', [ 'class' => 'section-team-members__team-member-image' ] ); ?>
			</div>

		<?php endif; ?>

	<?php endif; ?>

	<div class="section-team-members__team-member-content">
		<?php if ( $quote ) : ?>
			<blockquote class="section-team-members__team-member-quote">
				<p><?php echo esc_html( $quote ) ?></p>
			</blockquote>
		<?php endif; ?>
		<div class="section-team-members__team-member-body">
			<?php echo do_shortcode( wp_kses_post( $bio ) ); ?>
		</div>
		<?php if ( $high_res ) : ?>
			<a data-fancybox href="<?php echo esc_url( $high_res['url'] ) ?>">
				<strong>Download High-Resolution Photo</strong>
			</a>
		<?php endif; ?>
	</div>
</article>
