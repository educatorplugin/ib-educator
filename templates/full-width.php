<?php
/*
Template Name: Full width
*/
?>
<?php
	get_header();
	the_post();
?>

<section class="section-content">
	<div class="container clearfix">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php educator_page_title( 'page' ); ?>

			<div class="entry-content full-width-content">
				<?php
					the_content();
					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'ib-educator' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
					) );
				?>
			</div>
		</article>

		<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		?>
	</div>
</section>

<?php get_footer(); ?>