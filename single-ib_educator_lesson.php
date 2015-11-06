<?php get_header(); ?>
<?php the_post(); ?>

<section class="section-content">
	<div class="container clearfix">
		<div class="main-content">
			<?php IB_Educator_View::template_part( 'content', 'single-lesson' ); ?>
		</div>

		<div class="page-sidebar">
			<?php
				$lesson_id = get_the_ID();
				$api = IB_Educator::get_instance();
				$lessons = $api->get_lessons( ib_edu_get_course_id( $lesson_id ) );

				if ( $lessons->have_posts() ) {
					$cl = null;

					if ( class_exists( 'IB_Educator_Completed_Lessons' ) ) {
						$cl = IB_Educator_Completed_Lessons::get_instance();
					}

					echo '<aside class="widget"><h1 class="widget-title">' . __( 'Lessons', 'ib-educator' ) . '</h1>';
					echo '<ul class="lessons-nav">';

					while ( $lessons->have_posts() ) {
						$lessons->the_post();
						$classes = null;

						if ( $cl ) {
							$classes = $cl->add_lesson_class( array(), get_the_ID() );
						}

						if ( $lesson_id == get_the_ID() ) :
						?>
						<li<?php if ( ! empty( $classes ) ) echo ' class="' . esc_attr( implode( ' ', $classes ) ) . '"'; ?>>
							<span><?php the_title(); if ( ib_edu_has_quiz( get_the_ID() ) ) echo ' (' . __( 'Quiz', 'ib-educator' ) . ')'; ?></span>
						</li>
						<?php
						else :
						?>
						<li<?php if ( ! empty( $classes ) ) echo ' class="' . esc_attr( implode( ' ', $classes ) ) . '"'; ?>>
							<a href="<?php the_permalink(); ?>"><?php the_title(); if ( ib_edu_has_quiz( get_the_ID() ) ) echo ' (' . __( 'Quiz', 'ib-educator' ) . ')'; ?></a>
						</li>
						<?php
						endif;
					}

					echo '</ul></aside>';

					wp_reset_postdata();
				}
			?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
