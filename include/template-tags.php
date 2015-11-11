<?php

if ( ! function_exists( 'educator_page_title' ) ) :
/**
 * Output page title.
 *
 * @param string $page
 */
function educator_page_title( $page ) {
	switch ( $page ) {
		case 'page':
			$title = get_the_title();

			if ( strlen( $title ) != 0 ) {
				$title = '<h1 class="entry-title">' . $title . '</h1>';
			}

			$subtitle = apply_filters( 'edutheme_subtitle', '' );

			if ( ! empty( $subtitle ) ) {
				$title .= $subtitle;
			} else {
				$subtitle = get_post_meta( get_the_ID(), '_educator_subtitle', true );

				if ( $subtitle ) {
					$title .= '<div class="subtitle">' . esc_html( $subtitle ) . '</div>';
				}
			}

			if ( $title ) : ?>
				<div id="page-title"><?php echo $title; ?></div>
			<?php endif;

			break;

		case 'index':
			if ( is_home() && 'posts' != get_option( 'show_on_front' ) && ( $page_for_posts = get_option( 'page_for_posts' ) ) ) {
				echo '<div id="page-title">';
				echo '<h1>' . get_the_title( $page_for_posts ) . '</h1>';

				// Subtitle.
				$subtitle = apply_filters( 'edutheme_subtitle', '' );

				if ( ! empty( $subtitle ) ) {
					echo $subtitle;
				} else {
					$subtitle = get_post_meta( $page_for_posts, '_educator_subtitle', true );

					if ( ! empty( $subtitle ) ) {
						echo '<div class="subtitle">' . esc_html( $subtitle ) . '</div>';
					}
				}

				echo '</div>';
			} elseif ( is_category() ) {
				echo '<div id="page-title">';
				echo '<h1>' . sprintf( __( 'Category Archives: %s', 'ib-educator' ), single_cat_title( '', false ) ) . '</h1>';

				$subtitle = apply_filters( 'edutheme_subtitle', '' );

				if ( ! empty( $subtitle ) ) {
					echo $subtitle;
				} else {
					$term_description = term_description();

					if ( ! empty( $term_description ) ) {
						echo '<div class="subtitle">' . $term_description . '</div>';
					}
				}

				echo '</div>';
			} elseif ( is_tag() ) {
				echo '<div id="page-title">';
				echo '<h1>' . sprintf( __( 'Tag Archives: %s', 'ib-educator' ), single_tag_title( '', false ) ) . '</h1>';

				$subtitle = apply_filters( 'edutheme_subtitle', '' );

				if ( ! empty( $subtitle ) ) {
					echo $subtitle;
				} else {
					$term_description = term_description();

					if ( ! empty( $term_description ) ) {
						echo '<div class="subtitle">' . $term_description . '</div>';
					}
				}

				echo '</div>';
			} elseif ( is_date() ) {
				echo '<div id="page-title">';
				the_archive_title( '<h1>', '</h1>' );
				the_archive_description( '<div class="subtitle">', '</div>' );
				echo '</div>';
			}

			break;

		case 'post_type_archive':
			?>
			<div id="page-title">
				<h1><?php post_type_archive_title(); ?></h1>

				<?php echo apply_filters( 'edutheme_subtitle', '' ); ?>
			</div>
			<?php
			break;

		case 'search':
			?>
			<div id="page-title">
				<h1><?php printf( __( 'Search Results for: %s', 'ib-educator' ), get_search_query() ); ?></h1>

				<?php echo apply_filters( 'edutheme_subtitle', '' ); ?>
			</div>
			<?php
			break;

		case 'ibeducator':
			?>
			<div id="page-title">
				<h1><?php
					if ( function_exists( 'ib_edu_page_title' ) ) {
						ib_edu_page_title();
					} elseif ( is_post_type_archive( array( 'ib_educator_course', 'ib_educator_lesson' ) ) ) {
						post_type_archive_title( '' );
					}
				?></h1>

				<?php echo apply_filters( 'edutheme_subtitle', '' ); ?>
			</div>
			<?php
			break;

		case 'ib_educator_category':
			?>
			<div id="page-title">
				<h1><?php _e( 'Courses', 'ib-educator' ); ?></h1>
				
				<?php echo apply_filters( 'edutheme_subtitle', '' ); ?>
			</div>
			<?php
			break;
	}
}
endif;

if ( ! function_exists( 'educator_paging_nav' ) ) :
/**
 * Output paging navigation for posts.
 */
function educator_paging_nav( $num_pages = null ) {
	if ( null === $num_pages ) {
		$num_pages = $GLOBALS['wp_query']->max_num_pages;
	}

	if ( $num_pages < 2 ) {
		return;
	}

	$big = 999999999;
	$current_page = max( 1, get_query_var( 'paged' ) );
	$paginate_links = paginate_links( array(
		'type'      => 'array',
		'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format'    => '?paged=%#%',
		'current'   => $current_page,
		'total'     => $num_pages,
		'mid_size'  => 1,
		'prev_text' => '<span class="fa fa-angle-left"></span>',
		'next_text' => '<span class="fa fa-angle-right"></span>',
	) );

	echo '<div class="pagination clearfix">';
	echo '<div class="text">' . sprintf( __( 'Page %d of %d', 'ib-educator' ), intval( $current_page ), intval( $num_pages ) ) . '</div>';
	echo '<div class="links">';

	foreach ( $paginate_links as $link ) {
		echo $link;
	}

	echo '</div>';
	echo '</div>';
}
endif;

if ( ! function_exists( 'educator_post_meta' ) ) :
/**
 * Get post meta.
 *
 * @param array $include
 * @return string
 */
function educator_post_meta( $include = null ) {
	if ( ! $include ) {
		$include = array( 'author', 'date', 'comments', 'tags' );
	}

	$include = apply_filters( 'edutheme_meta_include', $include );
	$meta = '';

	if ( in_array( 'author', $include ) ) {
		$meta .= sprintf(
		  	'<span class="author vcard"><a class="url fn n" href="%s" rel="author">%s</a></span>',
		  	esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		  	get_the_author()
	  	);
	}

	if ( in_array( 'date', $include ) ) {
		$time_string = sprintf( '<time class="entry-date" datetime="%1$s">%2$s</time>',
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		$meta .= sprintf( '<span class="post-date"><a href="%1$s" rel="bookmark">%2$s</a></span>',
			esc_url( get_permalink() ),
			$time_string
		);
	}

	if ( in_array( 'comments', $include ) && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		$meta .= '<span class="comments-link">';
		ob_start();
		comments_popup_link( '0', '1', '%' );
		$meta .= ob_get_clean();
		$meta .= '</span>';
	}

	if ( in_array( 'tags', $include ) ) {
		ob_start();
		the_tags( '<span class="tag-links">', _x( ', ', 'Used between list items, there is a space after the comma.', 'ib-educator' ), '</span>' );
		$meta .= ob_get_clean();
	}

	return apply_filters( 'edutheme_meta', $meta );
}
endif;

if ( ! function_exists( 'educator_share' ) ) :
/**
 * Get post share links.
 *
 * @return string
 */
function educator_share( $type = 'default' ) {
	if ( 1 != get_theme_mod( 'share_enable', 1 ) ) {
		return '';
	}

	$links = '';
	$include = explode( ' ', get_theme_mod( 'share_buttons', 'facebook google+ twitter' ) );

	if ( ! empty( $include ) ) {
		$links .= '<ul class="educator-share-links clearfix">';
	
		if ( 'default' == $type ) {
			$links .= '<li class="label">' . __( 'Share:', 'ib-educator' ) . '</li>';
		}

		$theme_settings = get_option( 'educator_settings', array() );
		$fb_api_key = ! isset( $theme_settings['facebook_api_key'] ) ? '' : $theme_settings['facebook_api_key'];
		$twitter_via = ! isset( $theme_settings['twitter_via'] ) ? '' : $theme_settings['twitter_via'];

		$encoded_permalink = urlencode( get_permalink() );

		foreach ( $include as $include_button ) {
			switch ( $include_button ) {
				case 'facebook':
					if ( empty( $fb_api_key ) ) {
						$facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_permalink;
					} else {
						$redirect_uri = urlencode( home_url( '/' ) );
						$facebook_url = 'https://www.facebook.com/dialog/share?app_id=' . $fb_api_key . '&href=' . $encoded_permalink . '&redirect_uri=' . $redirect_uri;
					}

					$links .= '<li><a href="' . esc_url( $facebook_url ) . '" title="' . __( 'Facebook', 'ib-educator' ) . '" target="_blank"><span class="fa fa-facebook"></span></a></li>';
					break;

				case 'google+':
					$googleplus_url = 'https://plus.google.com/share?url=' . $encoded_permalink;
					$links .= '<li><a href="' . esc_url( $googleplus_url ) . '" title="' . __( 'Google+', 'ib-educator' ) . '" target="_blank"><span class="fa fa-google-plus"></span></a></li>';
					break;

				case 'twitter':
					$twitter_url = 'https://twitter.com/share?url=' . $encoded_permalink . '&text=' . urlencode( get_the_title() ) . '&via=' . $twitter_via;
					$links .= '<li><a href="' . esc_url( $twitter_url ) . '" title="' . __( 'Twitter', 'ib-educator' ) . '" target="_blank"><span class="fa fa-twitter"></span></a></li>';
					break;

				default:
					$links .= apply_filters( 'edutheme_share_link', '', $include_button, $encoded_permalink );
					break;
			}
		}

		$links .= '</ul>';

		if ( 'menu' == $type ) {
			$links = '<div class="share-links-menu"><a href="#" title="' . __( 'Share', 'ib-educator' ) . '"><span class="fa fa-share-alt"></span></a>' . $links . '</div>';
		}
	}

	return $links;
}
endif;

if ( ! function_exists( 'educator_courses_filter' ) ) :
/**
 * Output courses filter block.
 */
function educator_courses_filter( $args = array() ) {
	$output = '<div id="courses-filter" class="clearfix">';

	// get current membership id.
	$membership_id = get_query_var( 'membership_id' );

	// Categories filter.
	$terms = get_terms( array( 'ib_educator_category' ) );

	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$current_category = get_query_var( 'ib_educator_category' );
		$current_category_name = '';

		foreach ( $terms as $term ) {
			if ( $term->slug == $current_category ) {
				$current_category_name = $term->name;
				break;
			}
		}

		if ( empty( $current_category_name ) ) {
			$current_category_name = __( 'Category', 'ib-educator' );
		}

		$output .= '<div class="drop-down"><a href="#"><span class="text">' . esc_html( $current_category_name ) . '</span><span class="icon"></span></a><ul>';

		// Reset link.
		if ( isset( $args['category_same_page'] ) ) {
			$permalink = get_permalink();
		} else {
			$permalink = get_post_type_archive_link( 'ib_educator_course' );
		}
		
		if ( $membership_id ) {
			$permalink = add_query_arg( 'membership_id', $membership_id, $permalink );
		}

		$output .= '<li><a href="' . esc_url( $permalink ) . '">' . __( 'All', 'ib-educator' ) . '</a></li>';

		// Term links.
		foreach ( $terms as $term ) {
			if ( isset( $args['category_same_page'] ) ) {
				$term_permalink = add_query_arg( 'ib_educator_category', $term->slug, $permalink );
			} else {
				$term_permalink = get_term_link( $term );
			}

			if ( $membership_id ) {
				$term_permalink = add_query_arg( 'membership_id', $membership_id, $term_permalink );
			}

			$output .= '<li><a href="' . esc_url( $term_permalink ) . '">' . esc_html( $term->name ) . '</a></li>';
		}

		$output .= '</ul></div>';
	}

	if ( class_exists( 'Edr_Memberships' ) && apply_filters( 'edutheme_memberships_filter', true ) ) {
		$memberships = Edr_Memberships::get_instance()->get_memberships();

		if ( ! empty( $memberships ) ) {
			$title = '';

			foreach ( $memberships as $membership ) {
				if ( $membership_id == $membership->ID ) {
					$title = $membership->post_title;
				}
			}

			if ( empty( $title ) ) {
				$title = __( 'Membership', 'ib-educator' );
			}

			if ( $memberships ) {
				$output .= '<div class="drop-down"><a href="#"><span class="text">' . esc_html( $title ) . '</span><span class="icon"></span></a><ul>';
				$permalink = ( is_ssl() ) ? 'https' : 'http';
				$permalink .= '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

				if ( get_option( 'permalink_structure' ) ) {
					$permalink = preg_replace( '/\/page\/[0-9]+/i', '', $permalink );
				} else {
					$permalink = remove_query_arg( 'paged', $permalink );
				}

				$output .= '<li><a href="' . esc_url( remove_query_arg( 'membership_id', $permalink ) ) . '">' . __( 'All', 'ib-educator' ) . '</a></li>';

				foreach ( $memberships as $membership ) {
					$m_permalink = add_query_arg( 'membership_id', $membership->ID, $permalink );
					$output .= '<li><a href="' . esc_url( $m_permalink ) . '">' . esc_html( $membership->post_title ) . '</a></li>';
				}

				$output .= '</ul></div>';
			}
		}
	}

	// Number of courses.
	$num_courses = 0;

	if ( isset( $args['num_courses'] ) ) {
		$num_courses = $args['num_courses'];
	} elseif ( isset( $GLOBALS['wp_query']->found_posts ) ) {
		$num_courses = $GLOBALS['wp_query']->found_posts;
	}

	if ( $num_courses ) {
		$output .= '<div class="courses-num">' . sprintf( __( '%d course(s)', 'ib-educator' ), intval( $num_courses ) ) . '</div>';
	}

	$output .= '</div>';
	echo $output; // sanitized above
}
endif;

if ( ! function_exists( 'educator_related_courses' ) ) :
/**
 * Get related courses.
 *
 * @param int $post_id
 * @return string
 */
function educator_related_courses( $post_id ) {
	$terms = get_the_terms( $post_id, 'ib_educator_category' );

	if ( ! $terms || is_wp_error( $terms ) ) {
		return;
	}

	$args = array(
		'post_type'      => 'ib_educator_course',
		'posts_per_page' => 3,
		'post__not_in'   => array( $post_id ),
	);

	$terms_ids = array();
	foreach ( $terms as $term ) {
		$terms_ids[] = $term->term_id;
	}
	$args['tax_query'] = array(
		array( 'taxonomy' => 'ib_educator_category', 'terms' => $terms_ids ),
	);

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		$output = '<section class="related-courses">';
		$output .= '<h1>' . __( 'Related Courses', 'ib-educator' ) . '</h1>';
		$api = IB_Educator::get_instance();
		$course_id = 0;

		while ( $query->have_posts() ) {
			$query->the_post();
			$course_id = get_the_ID();
			$output .= '<article class="' . esc_attr( implode( ' ', get_post_class( 'clearfix' ) ) ) . '">';

			if ( has_post_thumbnail() ) {
				$output .= '<div class="post-thumb"><a href="' . esc_url( get_permalink() ) . '">' . get_the_post_thumbnail( $course_id, 'thumbnail' ) . '</a></div>';
			}

			$output .= '<div class="post-summary">'
					 . '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">' . the_title( '', '', false ) . '</a></h2>';
			ob_start();
			the_excerpt();
			$output .= '<div class="post-excerpt">' . ob_get_clean() . '</div>';
			$output .= '<div class="post-meta">';

			if ( 'closed' != ib_edu_registration( $course_id ) ) {
				$output .= '<span class="price">' . ib_edu_format_course_price( ib_edu_get_course_price( $course_id ) ) . '</span>';
			}
			
			$output .= educator_course_meta( $course_id, array( 'num_lessons', 'difficulty' ) );
			$output .= '</div>';
			$output .= '</div>';
			$output .= '</article>';
		}

		wp_reset_postdata();
		$output .= '</section>';
		return $output;
	}

	return '';
}
endif;

if ( ! function_exists( 'educator_auth_nav' ) ) :
function educator_auth_nav() {
	$output = '<ul id="auth-nav">';
	$output .= '<li><a class="auth-nav-login" href="' . esc_url( wp_login_url() ) . '">' . __( 'Log in', 'ib-educator' ) . '</a></li>';
	$output .= '<li><div class="auth-nav-register"><a class="button" href="' . esc_url( wp_registration_url() ) . '">' . __( 'Register', 'ib-educator' ) . '</a></div></li>';
	$output .= '</ul>';

	return $output;
}
endif;

if ( ! function_exists( 'edutheme_lecturer_bio' ) ) :
function edutheme_lecturer_bio( $user_id ) {
	$author_posts_url = educator_theme_lecturer_link( $user_id );
	$output = '<section class="author-bio lecturer-bio clearfix">';
	$output .= '<h1>' . __( 'Lecturer', 'ib-educator' ) . '</h1>';

	// Photo.
	$photo = null;

	if ( function_exists( 'educator_get_user_profile_photo' ) ) {
		$photo = educator_get_user_profile_photo( $user_id );
	}

	if ( $photo ) {
		$output .= '<div class="photo"><a href="' . esc_url( $author_posts_url ) . '">' . $photo . '</a></div>';
	}

	$output .= '<div class="summary">';
	ob_start();
	?>
	<h2><?php the_author(); ?></h2>
	<?php
	the_author_meta( 'description' );
	$output .= ob_get_clean();
	$output .= '<div class="author-links"><a href="' . esc_url( $author_posts_url ) . '">' . __( 'View Profile', 'ib-educator' ) . ' <span class="fa fa-angle-double-right"></span></a></div>';
	$output .= '</div>';
	$output .= '</section>';

	return $output;
}
endif;

/**
 * Get available social networks links.
 *
 * @return array
 */
function edutheme_available_social_links() {
	return apply_filters( 'edutheme_social_links', array(
		'facebook'    => array( 'href' => '', 'title' => __( 'Facebook', 'ib-educator' ), 'html' => '<span class="fa fa-facebook"></span>' ),
		'google_plus' => array( 'href' => '', 'title' => __( 'Google+', 'ib-educator' ), 'html' => '<span class="fa fa-google-plus"></span>' ),
		'twitter'     => array( 'href' => '', 'title' => __( 'Twitter', 'ib-educator' ), 'html' => '<span class="fa fa-twitter"></span>' ),
		'linkedin'    => array( 'href' => '', 'title' => __( 'Linkedin', 'ib-educator' ), 'html' => '<span class="fa fa-linkedin"></span>' ),
		'youtube'     => array( 'href' => '', 'title' => __( 'Youtube', 'ib-educator' ), 'html' => '<span class="fa fa-youtube"></span>' ),
		'vimeo'       => array( 'href' => '', 'title' => __( 'Vimeo', 'ib-educator' ), 'html' => '<span class="fa fa-vimeo-square"></span>' ),
		'instagram'   => array( 'href' => '', 'title' => __( 'Instagram', 'ib-educator' ), 'html' => '<span class="fa fa-instagram"></span>' ),
		'pinterest'   => array( 'href' => '', 'title' => __( 'Pinterest', 'ib-educator' ), 'html' => '<span class="fa fa-pinterest"></span>' ),
		'vk'          => array( 'href' => '', 'title' => __( 'Vk', 'ib-educator' ), 'html' => '<span class="fa fa-vk"></span>' ),
	) );
}

if ( ! function_exists( 'edutheme_social_links' ) ) :
/**
 * Get HTML of the social networks links.
 *
 * @return string
 */
function edutheme_social_links() {
	$enabled_networks = explode( ' ', get_theme_mod( 'toolbar_links', 'facebook google+ twitter linkedin youtube vimeo instagram' ) );

	if ( empty( $enabled_networks ) ) {
		return '';
	}

	$theme_settings = get_option( 'educator_settings' );

	if ( ! is_array( $theme_settings ) ) {
		$theme_settings = array();
	}

	$output = '<ul class="toolbar-social">';

	// Get available social links.
	$links = edutheme_available_social_links();

	foreach ( $enabled_networks as $network ) {
		if ( 'google+' == $network ) {
			$network = 'google_plus';
		}

		if ( isset( $links[ $network ] ) ) {
			$href = '';
			$nw_data = $links[ $network ];

			if ( ! empty( $nw_data['href'] ) ) {
				$href = $nw_data['href'];
			} elseif ( ! empty( $theme_settings[ $network ] ) ) {
				$href = $theme_settings[ $network ];
			} else {
				continue;
			}

			$output .= '<li class="' . esc_attr( str_replace( '_', '-', $network ) ) . '">'
					 . '<a href="' . esc_url( $href ) . '" title="' . esc_attr( $nw_data['title'] ) . '" target="_blank">' . $nw_data['html'] . '</a>'
					 . '</li>';
		}
	}

	$output .= '</ul>';

	return $output;
}
endif;
