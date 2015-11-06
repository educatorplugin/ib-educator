<?php get_header(); ?>

<section class="section-content">
	<div class="container clearfix">
		<?php
			$layout = get_theme_mod( 'courses_layout', 'grid_sidebar' );
		?>

		<?php if ( 'grid_sidebar' == $layout ) : ?>

		<div class="main-content">
			<?php
				educator_page_title( 'ib_educator_category' );
				educator_courses_filter();

				if ( have_posts() ) :
					echo '<div class="posts-grid clearfix">';
					while ( have_posts() ) : the_post();
						get_template_part( 'content', 'course-grid' );
					endwhile;
					echo '</div>';
				else :
					echo '<div class="page-content text-center"><p>' . __( 'No courses found.', 'ib-educator' ) . '</p></div>';
				endif;
			?>

			<?php educator_paging_nav(); ?>
		</div>

		<?php get_sidebar(); ?>

		<?php elseif ( 'grid_no_sidebar' == $layout ) : ?>

		<?php
			educator_page_title( 'ib_educator_category' );
			educator_courses_filter();
				
			if ( have_posts() ) :
				echo '<div class="posts-grid clearfix">';
				while ( have_posts() ) : the_post();
					get_template_part( 'content', 'course-grid' );
				endwhile;
				echo '</div>';
			else :
				echo '<div class="page-content text-center"><p>' . __( 'No courses found.', 'ib-educator' ) . '</p></div>';
			endif;
		?>

		<?php educator_paging_nav(); ?>

		<?php else : ?>

		<div class="main-content">
			<?php
				educator_page_title( 'ib_educator_category' );
				educator_courses_filter();
				
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();
						get_template_part( 'content', 'course' );
					endwhile;
				else :
					get_template_part( 'content', 'none' );
				endif;
			?>

			<?php educator_paging_nav(); ?>
		</div>

		<?php get_sidebar(); ?>

		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
