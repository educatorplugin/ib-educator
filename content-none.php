<div class="page-content">
	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

		<p><?php
			printf(
				__( 'Ready to publish your first post? %s.', 'ib-educator' ),
				'<a href="' . esc_url( admin_url( 'post-new.php' ) ) . '">' . __( 'Get started here', 'ib-educator' ) . '</a>'
			);
		?></p>

	<?php elseif ( is_search() ) : ?>

		<div id="page-title">
			<h1><?php _e( 'Not Found', 'ib-educator' ); ?></h1>
		</div>

		<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'ib-educator' ); ?></p>

		<?php get_search_form(); ?>

	<?php else : ?>

		<div id="page-title">
			<h1><?php _e( 'Not Found', 'ib-educator' ); ?></h1>
		</div>

		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'ib-educator' ); ?></p>

		<?php get_search_form(); ?>

	<?php endif; ?>
</div>
