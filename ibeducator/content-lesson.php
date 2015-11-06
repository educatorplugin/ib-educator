<?php
$lesson_id = get_the_ID();
$classes = apply_filters( 'ib_educator_lesson_classes', array( 'ib-edu-lesson' ), $lesson_id );
$layout = get_theme_mod( 'lessons_layout' );

if ( 'compact' == $layout ) {
	$classes[] = 'lesson-compact';
}
?>
<article id="lesson-<?php the_ID(); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<?php
		if ( 'compact' == $layout ) {
			$meta = ib_edu_has_quiz( $lesson_id ) ? '<div class="meta"><span>' . __( 'Quiz', 'ib-educator' ) . '</span></div>' : '';

			echo '<h1 class="clearfix"><a href="' . esc_url( get_permalink() ) . '">' . the_title( '', '', false ) . '</a>' . $meta . '</h1>';

			if ( has_excerpt() ) {
				echo '<div class="excerpt">';
				the_excerpt();
				echo '</div>';
			}
		} else {
			the_title( sprintf( '<h1><a href="%s">', esc_url( get_permalink() ) ), '</a></h1>' );

			if ( has_excerpt() ) {
				echo '<div class="excerpt">';
				the_excerpt();
				echo '</div>';
			}

			if ( ib_edu_has_quiz( $lesson_id ) ) {
				echo '<div class="ib-edu-lesson-meta"><span class="quiz">' . __( 'Quiz', 'ib-educator' ) . '</span></div>';
			}
		}
	?>
</article>