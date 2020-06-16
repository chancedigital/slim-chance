<section class="sign-up">
	<div class="sign-up__wrapper">
		<div class="sign-up__info">
			<h2 class="sign-up__heading">
				<?php echo esc_html( get_field( 'sign_up_heading', 'option' ) ) ?>
			</h2>
			<div class="sign-up__content">
				<?php echo wp_kses_post( get_field( 'sign_up_content', 'option' ) ) ?>
			</div>
			<div class="sign-up__form-wrapper">
				<?php echo do_shortcode( '[contact-form-7 id="91" title="Email Signup"]' ); ?>
			</div>
		</div>
	</div>
</section>
