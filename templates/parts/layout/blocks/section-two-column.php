<section class="section-two-column" id="<?php echo esc_attr( get_sub_field( 'section_id' ) ?: uniqid() ) ?>">
	<div class="section-two-column__wrapper">
		<?php if ( get_sub_field( 'section_heading' ) ) : ?>
			<h2 class="section-two-column__heading"><?php echo esc_html( get_sub_field( 'section_heading' ) ) ?></h2>
		<?php endif; ?>
		<div class="section-two-column__col section-two-column__col--1">
			<?php echo wp_kses_post( get_sub_field( 'left_content' ) ) ?>
		</div>
		<div class="section-two-column__col section-two-column__col--2">
			<?php echo wp_kses_post( get_sub_field( 'right_content' ) ) ?>
		</div>
	</div>
</section>
