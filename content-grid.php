<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-grid' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="post-thumb">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'ib-educator-grid' ); ?></a>
	</div>
	<?php endif; ?>

	<div class="post-body">
		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

		<div class="post-excerpt entry-summary">
			<?php
				if ( post_password_required() ) {
					_e( 'This post is password protected.', 'ib-educator' );
				} elseif ( is_search() ) {
					the_excerpt();
				} else {
					$continue_reading = get_theme_mod( 'continue_reading' )
						? sprintf( __( 'Continue reading %s', 'ib-educator' ), the_title( '<span class="screen-reader-text">', '</span>', false ) )
						: '';
					the_content( $continue_reading );
				}
			?>
		</div>

		<?php
			if ( is_sticky() ) {
				echo '<div class="post-badge post-badge-sticky"></div>';
			}
		?>
	</div>

	<footer class="post-meta">
		<?php
			echo educator_post_meta( array( 'date', 'comments' ) );
			echo educator_share( 'menu' );
		?>
	</footer>
</article>
