<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Get the course meta.
 *
 * @param int $course_id
 * @param array $include
 * @return string
 */
function educator_course_meta( $course_id = null, $include = null ) {
	if ( ! $course_id ) {
		$course_id = get_the_ID();
	}

	if ( ! $include ) {
		$include = array( 'lecturer', 'num_lessons', 'difficulty' );
	}

	$include = apply_filters( 'edutheme_course_meta_include', $include );

	$meta = apply_filters( 'pre_educator_course_meta', '', $course_id, $include );

	if ( ! empty( $meta ) ) {
		return $meta;
	}

	foreach ( $include as $item ) {
		switch ( $item ) {
			// Lecturer.
			case 'lecturer':
				$meta .= '<span class="author lecturer">' . sprintf( __( 'by %s', 'ib-educator' ), get_the_author() ) . '</span>';

				break;

			// Number of lessons.
			case 'num_lessons':
				$num_lessons = IB_Educator::get_instance()->get_num_lessons( $course_id );

				if ( $num_lessons ) {
					$meta .= '<span class="num-lessons">' . sprintf( _n( '1 lesson', '%d lessons', $num_lessons, 'ib-educator' ), $num_lessons ) . '</span>';
				}

				break;

			// Difficulty.
			case 'difficulty':
				$difficulty = ib_edu_get_difficulty( $course_id );

				if ( $difficulty ) {
					$meta .= '<span class="difficulty">' . esc_html( $difficulty['label'] ) . '</span>';
				}

				break;

			// Categories.
			case 'categories':
				$categories = get_the_term_list( get_the_ID(), 'ib_educator_category', '', __( ', ', 'ib-educator' ) );

				if ( $categories ) {
					echo '<span class="cat-links">' . $categories . '</span>';
				}

				break;
		}
	}

	return apply_filters( 'edutheme_course_meta', $meta );
}

function educator_before_course_content() {
	// Output course featured image.
	$show_thumbnail = get_post_meta( get_the_ID(), '_educator_show_image', true );

	if ( 1 == $show_thumbnail && has_post_thumbnail() ) {
		echo '<div class="course-image">';
		the_post_thumbnail( 'ib-educator-main-column' );
		echo '</div>';
	}
}
add_action( 'ib_educator_before_course_content', 'educator_before_course_content' );

function educator_format_price( $formatted, $currency, $price ) {
	if ( 0 == $price ) {
		return __( 'Free', 'ib-educator' );
	}

	return $formatted;
}
add_filter( 'ib_educator_format_price', 'educator_format_price', 10, 3 );

// Remove default stylesheet.
add_filter( 'ib_educator_stylesheet', '__return_false' );

// Add course meta to course single template.
function educator_single_course_meta() {
	echo '<div class="post-meta course-meta">', educator_course_meta( get_the_ID(), array( 'num_lessons', 'categories' ) ) ,'</div>';
}
add_action( 'ib_educator_after_course_title', 'educator_single_course_meta' );

/**
 * Add JavaScript pager to the lessons list.
 *
 * @param int $course_id
 */
function educator_add_js_pager( $course_id ) {
	$perpage = (int) get_post_meta( $course_id, '_educator_lessons_per_page', true );

	if ( ! $perpage ) {
		return;
	}

	wp_enqueue_script( 'educator-js-pager', get_template_directory_uri() . '/js/pager.js', array(), '1.0', true );
	?>
	<script>
		(function($) {
			var lessonsContainer = document.querySelector('.ib-edu-lessons');

			if (!lessonsContainer) {
				return;
			}

			lessonsContainer.className += ' edu-js-pager';

			$(document).ready(function() {
				var pager;

				lessonsContainer.setAttribute('data-perpage', '<?php echo $perpage; ?>');
				lessonsContainer.setAttribute('data-left', '<?php echo esc_js( __( 'Previous', 'ib-educator' ) ); ?>');
				lessonsContainer.setAttribute('data-right', '<?php echo esc_js( __( 'Next', 'ib-educator' ) ); ?>');

				pager = new IBEducator.Pager(lessonsContainer, {
					itemClass: 'ib-edu-lesson'
				});
			});
		})(jQuery);
	</script>
	<?php
}
add_action( 'edr_course_footer', 'educator_add_js_pager' );

// Remove default HTML actions.
if ( defined( 'IBEDUCATOR_VERSION' ) ) {
	if ( version_compare( IBEDUCATOR_VERSION, '1.5', '>=' ) ) {
		remove_action( 'ib_educator_before_main_loop', 'edr_before_main_loop' );
		remove_action( 'ib_educator_after_main_loop', 'edr_after_main_loop' );
		remove_action( 'ib_educator_sidebar', 'edr_show_sidebar' );
		remove_action( 'ib_educator_before_course_content', 'edr_show_course_difficulty' );
		remove_action( 'ib_educator_before_course_content', 'edr_show_course_categories' );
	} else {
		remove_action( 'ib_educator_before_main_loop', array( 'IB_Educator_Main', 'action_before_main_loop' ) );
		remove_action( 'ib_educator_after_main_loop', array( 'IB_Educator_Main', 'action_after_main_loop' ) );
		remove_action( 'ib_educator_sidebar', array( 'IB_Educator_Main', 'action_sidebar' ) );
		remove_action( 'ib_educator_before_course_content', array( 'IB_Educator_Main', 'before_course_content' ) );
	}
}
