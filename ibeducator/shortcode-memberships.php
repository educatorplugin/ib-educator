<?php
$atts = shortcode_atts( array(
	'layout' => '2 columns',
), $atts );

$query = new WP_Query( array(
	'post_type'      => 'ib_edu_membership',
	'posts_per_page' => -1,
	'post_status'    => 'publish',
	'order'          => 'ASC',
	'orderby'        => 'menu_order',
) );

$classes = array();
$classes[] = 'ib-edu-memberships';

switch ( $atts['layout'] ) {
	case '3 columns':
		$classes[] = 'ib-edu-memberships-3';
		break;

	case '2 columns':
		$classes[] = 'ib-edu-memberships-2';
		break;

	case 'list':
		$classes[] = 'ib-edu-memberships-list';
		break;
}

if ( $query->have_posts() ) :
	$tmp_more = $GLOBALS['more'];
	$GLOBALS['more'] = 0;
	?>
	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<?php
		$i = 1;

		while ( $query->have_posts() ) {
			$query->the_post();
			set_query_var( 'ibeducator_post_count', $i++ );
			IB_Educator_View::template_part( 'content', 'membership' );
		}
	?>
	</div>
	<?php
	$GLOBALS['more'] = $tmp_more;
	wp_reset_postdata();
else :
	echo '<p>' . __( 'No memberships found.', 'ib-educator' ) . '</p>';
endif;
?>