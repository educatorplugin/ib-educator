<?php get_header(); ?>

<section class="section-content">
	<div class="container clearfix">
		<?php
			// Page layout.
			$layout = get_theme_mod( 'blog_layout', 'grid_sidebar' );
			$page = 'index';

			if ( is_search() ) {
				$page = 'search';
			}
		?>

		<?php if ( 'grid_sidebar' == $layout ) : ?>

			<div class="main-content">
				<?php
					if ( have_posts() ) :
						educator_page_title( $page );
						?>
						<div class="posts-grid posts-grid-2 clearfix">
						<?php
							while ( have_posts() ) : the_post();
								get_template_part( 'content', 'grid' );
							endwhile;
						?>
						</div>
						<?php
					else :
						get_template_part( 'content', 'none' );
					endif;
				?>

				<?php educator_paging_nav(); ?>
			</div>

			<?php get_sidebar(); ?>

		<?php elseif ( 'grid_no_sidebar' == $layout ) : ?>

			<div class="posts-grid posts-grid-3 clearfix">
				<?php
					if ( have_posts() ) :
						educator_page_title( $page );

						while ( have_posts() ) : the_post();
							get_template_part( 'content', 'grid' );
						endwhile;
					else :
						get_template_part( 'content', 'none' );
					endif;
				?>
			</div>

			<?php educator_paging_nav(); ?>

		<?php else : ?>

			<div class="main-content posts-list">
				<?php
					if ( have_posts() ) :
						educator_page_title( $page );

						while ( have_posts() ) : the_post();
							get_template_part( 'content' );
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
