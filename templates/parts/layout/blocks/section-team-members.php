<?php $heading = get_sub_field( 'section_heading' ); ?>
<section class="section-team-members" id="<?php echo esc_attr( get_sub_field( 'section_id' ) ?: uniqid() ) ?>">
	<div class="section-team-members__wrapper">
		<?php if ( $heading ) : ?>
			<h2 class="section-team-members__heading"><?php echo esc_html( $heading ) ?></h2>
		<?php endif; ?>
		<?php
		if ( get_sub_field( 'display_type' ) === 'all' ) :
			$team_query = new WP_Query( [
				'post_type'      => 'team',
				'posts_per_page' => 90,
			] );
			if ( $team_query->have_posts() ) :
				?>
				<ul class="section-team-members__list">
					<?php
					while ( $team_query->have_posts() ) :
						$team_query->the_post();
						?>
						<li class="section-team-members__list-item">
							<?php get_template_part( 'templates/parts/layout/blocks/post', 'team-member' ) ?>
						</li>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</ul>
				<?php
			endif;
		elseif ( get_sub_field( 'display_type' ) === 'select' ) :
			$team_members = get_sub_field( 'team_members' );
			if ( $team_members ) :
				?>
				<ul class="section-team-members__list">
					<?php
					foreach ( $team_members as $post ) :
						setup_postdata( $post );
						?>
						<li class="section-team-members__list-item">
							<?php get_template_part( 'templates/parts/layout/blocks/post', 'team-member' ) ?>
						</li>
						<?php
					endforeach;
					wp_reset_postdata();
					?>
				</ul>
				<?php
			endif;
		endif;
		?>
	</div>
</section>
