<?php

use function ChanceDigital\SlimChance\Template\enqueue_instagram_embed_script;
use function ChanceDigital\SlimChance\Template\instagram_embed;

$heading = get_sub_field( 'section_heading' );
$links   = get_sub_field( 'instagram_links' );
if ( $links ) :
	enqueue_instagram_embed_script();
	?>

	<section class="section-instagram-embeds" id="<?php echo esc_attr( get_sub_field( 'section_id' ) ?: uniqid() ) ?>">
		<div class="section-instagram-embeds__wrapper">
			<?php if ( $heading ) : ?>
				<h2 class="section-instagram-embeds__heading"><?php echo esc_html( $heading ) ?></h2>
			<?php endif; ?>
			<ul class="section-instagram-embeds__list">
				<?php
				foreach ( $links as $link ) :
					$ig_url = $link['post_url'];
					if ( $ig_url ) :
						?>
						<li class="section-instagram-embeds__list-item">
							<?php instagram_embed( esc_url( $ig_url ) ); ?>
						</li>
						<?php
					endif;
				endforeach;
				?>
			</ul>
		</div>
	</section>

<?php endif; ?>
