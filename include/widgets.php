<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Custom Widget for displaying contact info.
 *
 * @link http://codex.wordpress.org/Widgets_API#Developing_Widgets
 */
class Educator_Contact_Widget extends WP_Widget {
	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct( 'widget_educator_contact', __( 'Educator Theme Contact', 'ib-educator' ), array(
			'classname'   => 'widget-educator-contact',
			'description' => __( 'Use this widget to display your contact info.', 'ib-educator' ),
		) );
	}

	public function get_social_net_items() {
		return array(
			'email'       => __( 'Email', 'ib-educator' ), 
			'facebook'    => __( 'Facebook', 'ib-educator' ),
			'twitter'     => __( 'Twitter', 'ib-educator' ),
			'google_plus' => __( 'Google+', 'ib-educator' ),
			'youtube'     => __( 'Youtube', 'ib-educator' ),
			'vimeo'       => __( 'Vimeo', 'ib-educator' ),
			'instagram'   => __( 'Instagram', 'ib-educator' ),
			'pinterest'   => __( 'Pinterest', 'ib-educator' ),
			'vk'          => __( 'Vk', 'ib-educator' ),
		);
	}

	/**
	 * Output the HTML for this widget.
	 *
	 * @param array $args     An array of standard parameters for widgets in this theme.
	 * @param array $instance An array of settings for this widget instance.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$text = empty( $instance['text'] ) ? '' : $instance['text'];
		$order = empty( $instance['order'] ) ? array() : explode( ' ', $instance['order'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) ) { echo $args['before_title'] . $title . $args['after_title']; }
		?>
		<div class="text"><?php echo wpautop( $text ); ?></div>
		<?php
		$items = $this->get_social_net_items();
		$icons = array(
			'email'       => 'fa-envelope-o', 
			'facebook'    => 'fa-facebook',
			'twitter'     => 'fa-twitter',
			'google_plus' => 'fa-google-plus',
			'youtube'     => 'fa-youtube',
			'vimeo'       => 'fa-vimeo-square',
			'instagram'   => 'fa-instagram',
			'pinterest'   => 'fa-pinterest',
			'vk'          => 'fa-vk',
		);

		echo '<ul class="links">';
		foreach ( $order as $item ) {
			if ( ! empty( $items[ $item ] ) ) {
				$item_name = $items[ $item ];
				if ( empty( $instance[ $item ] ) ) continue;
				$href = ( 'email' == $item ) ? 'mailto:' . esc_attr( antispambot( $instance[ $item ] ) ) : esc_url( $instance[ $item ] );
				$icon_name = isset( $icons[ $item ] ) ? $icons[ $item ] : '';
				echo '<li><a href="' . $href . '" title="' . $item_name . '" target="_blank"><i class="fa ' . $icon_name . '"></i></a></li>';
			}
		}
		echo '</ul>';

		echo $args['after_widget'];
	}

	/**
	 * Deal with the settings when they are saved by the admin.
	 *
	 * @param array $new_instance New widget instance.
	 * @param array $instance     Original widget instance.
	 *
	 * @return array Updated widget instance.
	 */
	function update( $new_instance, $instance ) {
		$instance['title']  = strip_tags( $new_instance['title'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] =  $new_instance['text'];
		} else {
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) ); // wp_filter_post_kses() expects slashed
		}
		$instance['email'] = sanitize_email( $new_instance['email'] );
		$instance['facebook'] = esc_url_raw( $new_instance['facebook'] );
		$instance['twitter'] = esc_url_raw( $new_instance['twitter'] );
		$instance['google_plus'] = esc_url_raw( $new_instance['google_plus'] );
		$instance['youtube'] = esc_url_raw( $new_instance['youtube'] );
		$instance['vimeo'] = esc_url_raw( $new_instance['vimeo'] );
		$instance['instagram'] = esc_url_raw( $new_instance['instagram'] );
		$instance['pinterest'] = esc_url_raw( $new_instance['pinterest'] );
		$instance['vk'] = esc_url_raw( $new_instance['vk'] );
		$instance['order'] = sanitize_text_field( $new_instance['order'] );

		return $instance;
	}

	/**
	 * Display the form for this widget on the Widgets page of the Admin area.
	 *
	 * @param array $instance
	 */
	function form( $instance ) {
		$title = empty( $instance['title'] ) ? '' : strip_tags( $instance['title'] );
		$text = empty( $instance['text'] ) ? '' : $instance['text'];
		$items = $this->get_social_net_items();
		$order = empty( $instance['order'] ) ? implode( ' ', array_keys( $items ) ) : $instance['order'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ib-educator' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text:', 'ib-educator' ); ?></label>
			<textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo esc_textarea( $text ); ?></textarea>
		</p>
		<?php
		foreach ( $items as $item => $item_name ) {
			?>
			<p>
				<label for="<?php echo $this->get_field_id( $item ); ?>"><?php echo $item_name; ?></label>
				<input id="<?php echo $this->get_field_id( $item ); ?>" class="widefat" name="<?php echo $this->get_field_name( $item ); ?>" type="text" value="<?php if ( ! empty( $instance[ $item ] ) ) echo esc_attr( $instance[ $item ] ); ?>">
			</p>
			<?php
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order:', 'ib-educator' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'order' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'order' ); ?>" type="text" value="<?php echo esc_attr( $order ); ?>">
		</p>
		<?php
	}
}
