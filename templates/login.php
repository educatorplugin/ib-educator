<?php
/*
Template Name: Log In Page
*/
?>

<?php
	get_header();
	the_post();
?>

<section class="section-content">
	<div class="container clearfix">
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php educator_page_title( 'page' ); ?>
			
			<div class="entry-content">
				<?php the_content(); ?>

				<div id="auth-forms">
					<?php if ( ! is_user_logged_in() ) : ?>
						<div class="the-tabs">
							<ul>
								<li class="active"><a href="<?php echo esc_url( get_permalink( get_theme_mod( 'login_page' ) ) ); ?>"><?php _e( 'Log in', 'ib-educator' ); ?></a></li>
								<li><a href="<?php echo esc_url( get_permalink( get_theme_mod( 'register_page' ) ) ); ?>"><?php _e( 'Register', 'ib-educator' ); ?></a></li>
							</ul>
						</div>

						<?php
							if ( 'registered' == get_query_var( 'action' ) ) {
								echo '<div class="ib-edu-message success">' . __( 'Registration complete.', 'ib-educator' ) . '</div>';
							}
						?>

						<div class="login-form clearfix">
							<?php
								$redirect_to = get_query_var( 'redirect_to' );

								if ( empty( $redirect_to ) ) {
									// Determine default redirect URL.
									$student_courses_page_id = ib_edu_page_id( 'student_courses' );

									if ( $student_courses_page_id ) {
										$redirect_to = get_permalink( $student_courses_page_id );
									} else {
										$user_page_id = get_theme_mod( 'user_page' );

										if ( $user_page_id ) {
											$redirect_to = ib_edu_get_endpoint_url( 'action', 'courses', get_permalink( $user_page_id ) );
										}
									}
								}

								wp_login_form( array(
									'id_submit' => 'submit-login-form',
									'redirect'  => $redirect_to,
								) );
							?>

							<p class="lost-password-link">
								<a href="<?php echo esc_url( wp_lostpassword_url( get_permalink() ) ); ?>"><?php _e( 'Lost your password?', 'ib-educator' ); ?></a>
							</p>
						</div>
					<?php else : ?>
						<p class="text-center"><?php _e( 'You are logged in.', 'ib-educator' ); ?> <a href="<?php echo esc_url( wp_logout_url( get_permalink( get_theme_mod( 'login_page' ) ) ) ); ?>"><?php _e( 'Log out', 'ib-educator' ); ?></a></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
