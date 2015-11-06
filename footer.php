		<?php if ( 1 == get_theme_mod( 'footer_widgets_enable', 1 ) ) : ?>
		<?php
			$footer_layout = get_theme_mod( 'footer_layout', '3_columns' );

			switch ( $footer_layout ) {
				case '4_columns':
					$column_class = 'one-fourth';
					break;

				default:
					$column_class = 'one-third';
			}
		?>
		<footer id="footer-widgets">
			<div class="container clearfix">
				<?php if ( is_active_sidebar( 'footer' ) ) : ?>
					<div class="widgets widgets-1 <?php echo esc_attr( $column_class ); ?>">
						<?php dynamic_sidebar( 'footer' ); ?>
					</div>
				<?php endif; ?>
				
				<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
					<div class="widgets widgets-2 <?php echo esc_attr( $column_class ); ?>">
						<?php dynamic_sidebar( 'footer-2' ); ?>
					</div>
				<?php endif; ?>

				<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
					<div class="widgets widgets-3 <?php echo esc_attr( $column_class ); ?>">
						<?php dynamic_sidebar( 'footer-3' ); ?>
					</div>
				<?php endif; ?>

				<?php if ( '4_columns' == $footer_layout && is_active_sidebar( 'footer-4' ) ) : ?>
					<div class="widgets widgets-4 <?php echo esc_attr( $column_class ); ?>">
						<?php dynamic_sidebar( 'footer-4' ); ?>
					</div>
				<?php endif; ?>
			</div>
		</footer>
		<?php endif; ?>
	</div><!-- #page-container -->

	<footer id="page-footer">
		<div class="container clearfix">
			<div class="copy"><?php
				echo wp_kses( get_theme_mod( 'footer_copy', '' ), array(
					'a' => array(
						'href' => array(),
					),
					'br' => array(),
				) );
			?></div>
			<button type="button" id="back-to-top"><span class="fa fa-angle-up"></span></button>
			<nav id="footer-nav">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'footer',
						'container'      => false,
						'fallback_cb'    => false,
					) );
				?>
			</nav>
		</div>
	</footer>
<?php wp_footer(); ?>
</body>
</html>
