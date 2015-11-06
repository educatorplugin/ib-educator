<?php get_header(); ?>
<?php
$curauth = ( get_query_var( 'author_name' ) ) ? get_user_by( 'slug', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );
$view = get_query_var( 'view' );

if ( empty( $view ) ) {
	$view = 'posts';
}

$role = '';

if ( in_array( 'lecturer', $curauth->roles ) ) {
	$role = 'lecturer';
}

$photo = '';

if ( function_exists( 'educator_get_user_profile_photo' ) ) {
	$photo = educator_get_user_profile_photo( $curauth->ID );
}
?>

<section class="section-content">
	<div class="container clearfix">
		<div id="page-title">
			<h1><?php
				if ( 'lecturer' == $role ) {
					_e( 'Lecturer Profile', 'ib-educator' );
				} else {
					_e( 'Author Profile', 'ib-educator' );
				}
			?></h1>
		</div>

		<section class="author-bio lecturer-bio clearfix">
			<?php if ( $photo ) : ?>
				<div class="photo">
					<?php echo $photo; ?>
				</div>
			<?php endif; ?>

			<div class="summary">
				<h1><?php echo esc_html( $curauth->display_name ); ?></h1>
				<?php echo esc_html( $curauth->user_description ); ?>
			</div>
		</section>

		<?php
			$tabs = array(
				'posts' => array(
					'label' => __( 'Posts', 'ib-educator' ),
					'href'  => get_author_posts_url( $curauth->ID ),
				),
			);

			if ( post_type_exists( 'ib_educator_course' ) ) {
				$tabs['courses'] = array( 'label' => __( 'Courses', 'ib-educator' ) );

				if ( get_option( 'permalink_structure' ) ) {
					$tabs['courses']['href'] = untrailingslashit( $tabs['posts']['href'] ) . '/view/courses/';
				} else {
					$tabs['courses']['href'] = add_query_arg( 'view', 'courses', $tabs['posts']['href'] );
				}
			}

			/**
			 * Filter the author tabs output.
			 * The tab label must be filtered for output.
			 *
			 * @since 1.2.2
			 *
			 * @param array $tabs
			 */
			$tabs = apply_filters( 'ib_educator_theme_author_tabs', $tabs );
		?>
		<div class="the-tabs author-tabs">
			<ul>
				<?php
					foreach ( $tabs as $key => $tab ) {
						echo '<li' . ( $key == $view ? ' class="active"' : '' ) . '><a href="' . esc_url( $tab['href'] ) . '">' . $tab['label'] . '</a></li>';
					}
				?>
			</ul>
		</div>
		
		<?php
			if ( have_posts() ) :
				echo '<div class="posts-grid posts-grid-3 clearfix">';

				while ( have_posts() ) : the_post();
					if ( 'courses' == $view ) :
						get_template_part( 'content', 'course-grid' );
					else :
						get_template_part( 'content', 'grid' );
					endif;
				endwhile;

				echo '</div>';
			elseif ( 'courses' == $view ) :
				echo '<p>' . __( 'No courses found.', 'ib-educator' ) . '</p>';
			else :
				echo '<p>' . __( 'No posts found.', 'ib-educator' ) . '</p>';
			endif;
		?>

		<?php educator_paging_nav(); ?>
	</div>
</section>

<?php get_footer(); ?>
