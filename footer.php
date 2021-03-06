<?php
/**
 * The template for displaying the footer.
 *
 * @package slim-chance
 */

use ChanceDigital\Slim_Chance\Nav\Walker_Nav_Menu_Bem;

?>

	</div><!-- .content-area -->
</div><!-- .site-wrapper -->


<footer class="site-footer">
	<div class="site-footer__wrapper">
		<?php
		wp_nav_menu(
			[
				'menu_class'      => 'social-nav__menu',
				'container'       => 'nav',
				'container_class' => 'social-nav site-footer__social-nav',
				'theme_location'  => 'social',
				'link_before'     => '<span class="screen-reader-text">',
				'link_after'      => '</span">',
				'walker'          => new Walker_Nav_Menu_Bem(),
			]
		);
		wp_nav_menu(
			[
				'menu_class'      => 'footer-nav__menu',
				'container'       => 'nav',
				'container_class' => 'footer-nav site-footer__nav',
				'theme_location'  => 'footer-navigation',
				'walker'          => new Walker_Nav_Menu_Bem(),
			]
		);
		?>
		<nav class="site-footer__copyright" aria-label="<?php esc_attr_e( 'Additional Information', 'slim-chance' ) ?>">
			<a href="/privacy-policy/"><?php esc_html_e( 'Privacy Policy', 'slim-chance' ) ?></a> |
			<a href="/refund-policy/"><?php esc_html_e( 'Refund Policy', 'slim-chance' ) ?></a> |
			<?php
			echo esc_html( sprintf(
				/* translators: 1. Copyright symbol; 2. Current year */
				__( '%1$s %2$s All Rights Reserved', 'slim-chance' ),
				'&copy;',
				date( 'Y' )
			) );
			?>
			<br />
			<span style="font-weight: 300;color: rgba(255,255,255,0.5);">Website by <a style="color: rgba(255,255,255,0.5);" href="https://chancedigital.io" target="_blank" rel="nofollow noopener noreferrer">Chance Digital</a></span>
		</nav>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
