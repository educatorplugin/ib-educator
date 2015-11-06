<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	<?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) ) : ?>
		<div class="post-meta center">
			<span class="cat-links"><?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'ib-educator' ) ); ?></span>
		</div>
	<?php endif; ?>

	<?php
		$show_thumbnail = get_post_meta( get_the_ID(), '_educator_show_image', true );
	?>
	<?php if ( 1 == $show_thumbnail && has_post_thumbnail() ) : ?>
		<div class="post-thumb">
			<?php the_post_thumbnail( 'ib-educator-main-column' ); ?>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php
			the_content();
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'ib-educator' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>'
			) );
		?>
	</div>

	<footer class="post-meta">
		<?php echo educator_post_meta(); ?>
	</footer>
</article>
