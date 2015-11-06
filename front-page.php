<?php
	if ( 'posts' == get_option( 'show_on_front' ) ) {
		get_header();
		include( get_home_template() );
		get_footer();
	} else {
		if ( function_exists( 'educator_page_section' ) ) {
			get_header();

			while ( have_posts() ) : the_post();
				the_content();
			endwhile;

			get_footer();
		} else {
			get_template_part( 'page' );
		}
	}
?>
