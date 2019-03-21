<section class="section-one-column" id="<?php echo esc_attr( get_sub_field( 'section_id' ) ?: uniqid() ) ?>">
	<div class="section-one-column__wrapper">
		<?php if ( get_sub_field( 'section_heading' ) ) : ?>
			<h2 class="section-one-column__heading"><?php echo esc_html( get_sub_field( 'section_heading' ) ) ?></h2>
		<?php endif; ?>
		<?php echo get_sub_field( 'content' ) // figure out proper escaping ?>
	</div>
</section>
