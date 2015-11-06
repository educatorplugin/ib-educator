<?php
$course_id = get_the_ID();
$classes = apply_filters( 'ib_educator_course_classes', array( 'course', 'post-fw' ) );
?>
<article id="course-<?php the_ID(); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="post-thumb">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'ib-educator-main-column' ); ?></a>
	</div>
	<?php endif; ?>

	<div class="summary">
		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
		<div class="price"><?php echo ib_edu_format_price( ib_edu_get_course_price( $course_id ) ); ?></div>
		<div class="post-excerpt">
			<?php the_excerpt(); ?>
		</div>
	</div>

	<footer class="post-meta">
		<?php
			echo educator_course_meta();
			echo educator_share( 'menu' );
		?>
	</footer>
</article>