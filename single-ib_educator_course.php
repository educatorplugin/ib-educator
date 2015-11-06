<?php get_header(); ?>

<section class="section-content">
	<div class="container clearfix">
		<div class="main-content">
			<?php
				while ( have_posts() ) : the_post();
					IB_Educator_View::template_part( 'content', 'single-course' );
					get_template_part( 'lecturer-bio' );
					echo educator_share();
					echo educator_related_courses( get_the_ID() );
				endwhile;
			?>
		</div>

		<?php get_sidebar(); ?>
	</div>
</section>

<?php get_footer(); ?>
