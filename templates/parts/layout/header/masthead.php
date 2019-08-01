<?php
/**
 * Site masthead.
 *
 * @package slim-chance
 */

use ChanceDigital\SlimChance\Nav\Walker_Nav_Menu_Bem;
use function ChanceDigital\SlimChance\Template\get_template_part;

?>

<header class="masthead" id="js-masthead">
	<div class="masthead__wrapper">
		<div class="masthead__logo-wrapper">
			<?php the_custom_logo(); ?>
		</div>
		<div id="js-masthead-nav-wrapper" class="masthead__nav-wrapper">
			<?php
			wp_nav_menu(
				[
					'menu_class'      => 'secondary-nav__menu',
					'container'       => 'nav',
					'container_id'    => 'js-secondary-nav',
					'container_class' => 'secondary-nav masthead__secondary-nav',
					'depth'           => 1,
					'theme_location'  => 'secondary-navigation',
					'walker'          => new Walker_Nav_Menu_Bem(),
				]
			);
			echo '<hr class="masthead__nav-sep" />';
			wp_nav_menu(
				[
					'menu_class'      => 'topnav__menu',
					'container'       => 'nav',
					'container_id'    => 'js-topnav',
					'container_class' => 'topnav masthead__topnav',
					'theme_location'  => 'main-navigation',
					'walker'          => new Walker_Nav_Menu_Bem(),
				]
			);
			?>
		</div>
		<button id="js-masthead-menu-toggle" class="masthead__hamburger" type="button">
			<?php get_template_part( 'components/hamburger' ); ?>
		</button>
	</div>
</header>
