<?php
/*
Template Name: Register Page
*/
?>

<?php get_header(); ?>

<?php the_post(); ?>

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
								<li><a href="<?php echo esc_url( get_permalink( get_theme_mod( 'login_page' ) ) ); ?>"><?php _e( 'Log in', 'ib-educator' ); ?></a></li>
								<li class="active"><a href="<?php echo esc_url( get_permalink( get_theme_mod( 'register_page' ) ) ); ?>"><?php _e( 'Register', 'ib-educator' ); ?></a></li>
							</ul>
						</div>

						<?php
							if ( ! get_option( 'users_can_register' ) ) {
								?>
								<p><?php _e( 'Registration is disabled.', 'ib-educator' ); ?></p>
								</div><!-- #auth-forms -->
								</div><!-- .entry-content -->
								</div><!-- #post -->
								</div><!-- .container -->
								</section><!-- .section-content -->
								<?php
								get_footer();
								return;
							}

							$user_login = isset( $_POST['user_login'] ) ? $_POST['user_login'] : '';
							$user_email = isset( $_POST['user_email'] ) ? $_POST['user_email'] : '';
							$form_action = '';
							$redirect_to = '';
							$ufw_enabled = ( get_option( 'ib_ufw_enabled' ) && class_exists( 'IBFW_User_Flow' ) );

							if ( $ufw_enabled ) {
								$form_action = get_permalink();
								$redirect_to = add_query_arg( 'action', 'registered', wp_login_url() );

								// Check for errors.
								$ufw = IBFW_User_Flow::get_instance();
								$errors = $ufw->get_errors();

								if ( is_wp_error( $errors ) ) {
									foreach ( $errors->get_error_messages() as $message ) {
										echo '<div class="ib-edu-message error">' . $message . '</div>';
									}
								}

								// Get the entered first and last names.
								$first_name = isset( $_POST['first_name'] ) ? $_POST['first_name'] : '';
								$last_name  = isset( $_POST['last_name'] ) ? $_POST['last_name'] : '';
							} else {
								$form_action = site_url( 'wp-login.php?action=register' );
								$redirect_to = add_query_arg( 'action', 'registered', get_permalink() );

								if ( 'registered' == get_query_var( 'action' ) ) {
									echo '<div class="ib-edu-message success">' . __( 'Registration complete. Please check your e-mail.', 'ib-educator' ) . '</div>';
								}
							}
						?>

						<div class="register-form">
							<form id="registerform1" name="registerform" action="<?php echo esc_url( $form_action ); ?>" method="post">
								<input type="hidden" name="redirect_to" value="<?php echo esc_url( $redirect_to ); ?>">

								<p class="login-username">
									<label for="register-login"><?php _e( 'Username', 'ib-educator' ); ?> <span class="required">*</span></label>
									<input type="text" name="user_login" id="register-login" class="input" value="<?php echo esc_attr( $user_login ); ?>" required>
								</p>

								<p class="login-email">
									<label for="register-email"><?php _e( 'Email', 'ib-educator' ); ?> <span class="required">*</span></label>
									<input type="email" name="user_email" id="register-email" class="input" value="<?php echo esc_attr( $user_email ); ?>" required>
								</p>

								<?php if ( $ufw_enabled ) : ?>
									<p class="user-first-name">
										<label for="user-first-name"><?php _e( 'First Name', 'ib-educator' ); ?></label>
										<input type="text" name="first_name" id="user-first-name" class="input" value="<?php echo esc_attr( $first_name ); ?>">
									</p>

									<p class="user-last-name">
										<label for="user-last-name"><?php _e( 'Last Name', 'ib-educator' ); ?></label>
										<input type="text" name="last_name" id="user-last-name" class="input" value="<?php echo esc_attr( $last_name ); ?>">
									</p>

									<?php
										/**
										 * This action can be used to output additional form fields.
										 */
										do_action( 'ibfw_ufw_register_fields' );
									?>

									<p class="user-password">
										<label for="user-password"><?php _e( 'Password', 'ib-educator' ); ?> <span class="required">*</span></label>
										<input type="password" name="user_pass" id="user-password" class="input" autocomplete="off" required>
									</p>

									<p class="user-repeat-password">
										<label for="user-repeat-password"><?php _e( 'Repeat Password', 'ib-educator' ); ?> <span class="required">*</span></label>
										<input type="password" name="repeat_user_pass" id="user-repeat-password" class="input" autocomplete="off" required>
									</p>

									<?php
										/**
										 * This action can be used to output additional form fields.
										 */
										do_action( 'ibfw_ufw_register_footer' );
									?>

									<input type="hidden" name="ibfw_ufw_action" value="register">
									<?php wp_nonce_field( 'ibfw_ufw_register', 'ibfw_ufw_nonce' ); ?>
								<?php endif; ?>

								<p class="login-submit">
									<input type="submit" name="wp-submit" id="submit-register-form" class="button" value="<?php _e( 'Register', 'ib-educator' ); ?>">
								</p>
							</form>
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
