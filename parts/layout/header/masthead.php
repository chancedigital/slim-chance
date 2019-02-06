<section class="masthead" id="js-masthead">
	<div class="container">
		<div class="masthead__logo-wrapper">
			<?php the_custom_logo(); ?>
		</div>
		<div class="masthead__nav-wrapper">
			<?php
			wp_nav_menu( [
				'menu_class'      => 'topnav__menu',
				'container'       => 'nav',
				'container_id'    => 'js-topnav',
				'container_class' => 'topnav',
				'theme_location'  => 'main-navigation',
				'walker'          => new ChanceDigital\SlimChance\Nav\Walker_Nav_Menu_Bem(),
			] );
			?>
			<button id="js-topnav-toggle" class="masthead__hamburger">
				<?php get_template_part( 'parts/components/hamburger' ); ?>
			</button>
		</div>
	</div>
</section>
