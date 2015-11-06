<?php get_header(); ?>

<section id="section-breadcrumbs" class="section-content">
	<div class="container">
		<?php
			woocommerce_breadcrumb( array(
				'wrap_before' => '<nav class="woocommerce-breadcrumb">',
				'wrap_after'  => '</nav>',
			) );
		?>
	</div>
</section>

<section class="section-content">
	<div class="container clearfix">
		<?php if ( is_product() ) : ?>
			<div class="main-content">
				<?php woocommerce_content(); ?>
			</div>

			<?php get_sidebar( 'shop' ); ?>
		<?php else : ?>
			<?php
				$layout = get_theme_mod( 'shop_layout', 'default' );

				if ( 'default' == $layout ) {
					echo '<div class="main-content">';
				}
			?>

			<div id="page-title">
				<h1><?php woocommerce_page_title(); ?></h1>

				<?php
					if ( is_shop() ) {
						$subtitle = apply_filters( 'edutheme_subtitle', '' );

						if ( ! empty( $subtitle ) ) {
							echo $subtitle;
						} else {
							$subtitle = get_post_meta( wc_get_page_id( 'shop' ), '_educator_subtitle', true );

							if ( $subtitle ) {
								echo '<div class="subtitle">' . esc_html( $subtitle ) . '</div>';
							}
						}
					}
				?>
			</div>

			<?php woocommerce_content(); ?>

			<?php
				if ( 'default' == $layout ) {
					echo '</div>';

					get_sidebar( 'shop' );
				}
			?>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
