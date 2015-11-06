<?php
/*
Template Name: Sections
*/
?>

<?php get_header(); ?>

<?php
	if ( have_posts() ) : the_post();
		the_content();
	endif;
?>

<?php get_footer(); ?>