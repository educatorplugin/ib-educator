<?php
$ms = Edr_Memberships::get_instance();
$membership_id = get_the_ID();
$membership_meta = $ms->get_membership_meta( $membership_id );
$post_count = get_query_var( 'ibeducator_post_count' );
$classes = array();

if ( $post_count % 2 == 0 ) {
	$classes[] = 'second';
}

if ( $post_count % 3 == 0 ) {
	$classes[] = 'third';
}
?>
<article <?php post_class( $classes ); ?>>
	<header class="membership-title">
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	</header>

	<section class="price">
		<?php echo $ms->format_price( $membership_meta['price'], $membership_meta['duration'], $membership_meta['period'] ); ?>
	</section>

	<section class="membership-summary">
		<?php
			$continue_reading = get_theme_mod( 'continue_reading' )
				? sprintf( __( 'Continue reading %s', 'ib-educator' ), the_title( '<span class="screen-reader-text">', '</span>', false ) )
				: '';
			the_content( $continue_reading );
		?>
	</section>

	<footer class="membership-options post-meta">
		<?php
			if ( function_exists( 'ib_edu_purchase_link' ) ) {
				echo ib_edu_purchase_link( array(
					'object_id' => $membership_id,
					'type'      => 'membership',
				) );
			} else {
				$purchase_url = ib_edu_get_endpoint_url( 'edu-membership', $membership_id, get_permalink( ib_edu_page_id( 'payment' ) ) );
				echo '<a href="' . esc_url( $purchase_url ) .'">' . __( 'Purchase', 'ib-educator' ) . '</a>';
			}
		?>

		<?php
			echo educator_share( 'menu' );
		?>
	</footer>
</article>