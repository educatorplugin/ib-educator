<?php if ( $courses->have_posts() ) : ?>
	<?php
		$columns = isset( $atts['columns'] ) ? intval( $atts['columns'] ) : 1;
		$classes = apply_filters( 'ib_educator_courses_list_classes', array(
			'ib-edu-courses-list',
			'ib-edu-courses-list-' . $columns,
		) );
	?>

	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<?php
		while ( $courses->have_posts() ) {
			$courses->the_post();

			if ( $columns > 1 ) {
				IB_Educator_View::template_part( 'content', 'course' );
			} else {
				IB_Educator_View::template_part( 'content', 'course-fw' );
			}
		}
	?>
	</div>

	<?php
		wp_reset_postdata();

		if ( ! isset( $atts['nopaging'] ) || 1 != $atts['nopaging'] ) {
			educator_paging_nav( $courses->max_num_pages );
		}
	?>
<?php endif; ?>