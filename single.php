<?php get_header(); ?>
<?php the_post(); ?>

<section class="section-content">
	<div class="container clearfix">
		<div class="main-content">
			<?php
				get_template_part( 'content', 'single' );
				echo educator_share();

				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

				the_post_navigation( array(
					'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'ib-educator' ) . '</span> ' .
						'<span class="screen-reader-text">' . __( 'Next post:', 'ib-educator' ) . '</span> ' .
						'<span class="post-title">%title</span>',
					'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'ib-educator' ) . '</span> ' .
						'<span class="screen-reader-text">' . __( 'Previous post:', 'ib-educator' ) . '</span> ' .
						'<span class="post-title">%title</span>',
				) );
			?>
		</div>

		<?php get_sidebar(); ?>
	</div>
</section>

<?php get_footer(); ?>
