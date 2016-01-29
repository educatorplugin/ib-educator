<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Educator_Theme_Customize {
	/**
	 * Initialize customizer.
	 */
	public static function init() {
		add_action( 'customize_register', array( __CLASS__, 'register' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'output_style' ), 20 );
	}

	/**
	 * Sanitize color hex.
	 * Regex from WordPress sanitize_hex_color
	 *
	 * @param string $color
	 * @return string
	 */
	public static function sanitize_hex_color( $color ) {
		if ( ! preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return '';
		}

		return $color;
	}

	/**
	 * Sanitize layout setting.
	 *
	 * @param string $layout
	 * @return string
	 */
	public static function sanitize_layout( $layout ) {
		if ( ! in_array( $layout, array( 'list', 'grid_sidebar', 'grid_no_sidebar' ) ) ) {
			$layout = '';
		}

		return $layout;
	}

	/**
	 * Sanitize footer layout setting.
	 *
	 * @param string $layout
	 * @return string
	 */
	public static function sanitize_footer_layout( $layout ) {
		if ( ! in_array( $layout, array( '3_columns', '4_columns' ) ) ) {
			$layout = '';
		}

		return $layout;
	}

	/**
	 * Sanitize share buttons setting.
	 *
	 * @param string $input
	 * @return string
	 */
	public static function sanitize_share_buttons( $input ) {
		$buttons = array_map( 'sanitize_text_field', explode( ' ', $input ) );
		
		return implode( ' ', $buttons );
	}

	/**
	 * Sanitize social networks setting.
	 *
	 * @param string $input
	 * @return string
	 */
	public static function sanitize_social_networks( $input ) {
		$clean = array();
		$available_links = edutheme_available_social_links();
		$networks = explode( ' ', $input );

		foreach ( $networks as $network ) {
			if ( 'google+' == $network ) {
				$key = 'google_plus';
			} else {
				$key = $network;
			}

			if ( array_key_exists( $key, $available_links ) ) {
				$clean[] = $network;
			}
		}

		return implode( ' ', $clean );
	}

	/**
	 * Sanitize facebook API key.
	 *
	 * @param string $key
	 * @return string
	 */
	public static function sanitize_facebook_api_key( $key ) {
		return esc_html( $key );
	}

	/**
	 * Sanitize sidebar position.
	 *
	 * @param string $input
	 * @return string
	 */
	public static function sanitize_sidebar_position( $input ) {
		if ( ! in_array( $input, array( 'left', 'right' ) ) ) {
			$input = '';
		}

		return $input;
	}

	/**
	 * Sanitize font name.
	 *
	 * @param string $input
	 * @return string
	 */
	public static function sanitize_font_name( $input ) {
		return preg_replace( '/[^a-z0-9 ]+/i', '', $input );
	}

	/**
	 * Sanitize simple HTML field.
	 *
	 * @param string $input
	 * @return string
	 */
	public static function simple_html( $input ) {
		return wp_kses( $input, array(
			'a' => array(
				'href'  => array(),
				'title' => array(),
			),
			'br' => array(),
		) );
	}

	public static function sanitize_font_size( $input ) {
		$input = intval( $input );

		if ( $input >= 14 && $input <= 15 ) {
			return $input;
		}

		return 14;
	}

	public static function sanitize_toolbar_text( $input ) {
		return wp_kses( $input, array(
			'a' => array(
				'href'  => array(),
				'title' => array(),
			),
			'strong' => array(),
		) );
	}

	public static function get_font_weight_choices() {
		return array(
			'normal'  => esc_html__( 'normal', 'ib-educator' ),
			'bold'    => esc_html__( 'bold', 'ib-educator' ),
			'bolder'  => esc_html__( 'bolder', 'ib-educator' ),
			'lighter' => esc_html__( 'lighter', 'ib-educator' ),
			'100'     => '100',
			'200'     => '200',
			'300'     => '300',
			'400'     => '400',
			'500'     => '500',
			'600'     => '600',
			'700'     => '700',
			'800'     => '800',
			'900'     => '900',
		);
	}

	/**
	 * Register settings.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public static function register( $wp_customize ) {
		self::general_settings( $wp_customize );
		self::font_settings( $wp_customize );
		self::color_settings( $wp_customize );
		self::toolbar_settings( $wp_customize );
		self::header_settings( $wp_customize );
		self::page_layouts_settings( $wp_customize );
		self::share_settings( $wp_customize );
		self::login_register_settings( $wp_customize );
		self::footer_settings( $wp_customize );
		self::advanced_settings( $wp_customize );
	}

	public static function general_settings( $wp_customize ) {
		// General settings section.
		$wp_customize->add_section(
			'educator_general',
			array(
				'title'       => __( 'General', 'ib-educator' ),
				'description' => __( 'General theme settings.', 'ib-educator' ),
				'priority'    => 0,
			)
		);

		// Logo.
		$wp_customize->add_setting(
			'logo',
			array(
				'default'           => get_template_directory_uri() . '/images/logo.png',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'educator_logo',
				array(
					'label'    => __( 'Logo', 'ib-educator' ),
					'section'  => 'educator_general',
					'settings' => 'logo',
					'priority' => 0,
				)
			)
		);

		// Logo 2x.
		$wp_customize->add_setting(
			'logo_2x',
			array(
				'default'           => get_template_directory_uri() . '/images/logo@2x.png',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'educator_logo_2x',
				array(
					'label'    => __( 'Logo 2x', 'ib-educator' ),
					'section'  => 'educator_general',
					'settings' => 'logo_2x',
					'priority' => 1,
				)
			)
		);

		// Logo height.
		$wp_customize->add_setting(
			'logo_height',
			array(
				'default'           => 28,
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'educator_logo_height',
			array(
				'type'     => 'text',
				'label'    => __( 'Logo Max Height', 'ib-educator' ),
				'section'  => 'educator_general',
				'settings' => 'logo_height',
				'priority' => 2,
			)
		);
	}

	public static function font_settings( $wp_customize ) {
		$fonts = apply_filters( 'ib_theme_get_fonts', array() );
		$headings_fonts = array();
		$body_fonts = array();

		foreach ( $fonts as $font_name => $font ) {
			if ( isset( $font['only_headings'] ) && true == $font['only_headings'] ) {
				$headings_fonts[ $font_name ] = $font_name;
				continue;
			}

			$headings_fonts[ $font_name ] = $font_name;
			$body_fonts[ $font_name ] = $font_name;
		}

		// Font Settings Section.
		$wp_customize->add_section(
			'educator_theme_font',
			array(
				'title'       => __( 'Font Settings', 'ib-educator' ),
				'description' => __( 'Google fonts settings.', 'ib-educator' ),
				'priority'    => 3,
			)
		);

		// Headings Font.
		$wp_customize->add_setting(
			'headings_font',
			array(
				'default'           => 'Open Sans',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => array( __CLASS__, 'sanitize_font_name' ),
			)
		);

		$wp_customize->add_control(
			'educator_headings_font',
			array(
				'label'    => __( 'Headings Font', 'ib-educator' ),
				'section'  => 'educator_theme_font',
				'settings' => 'headings_font',
				'type'     => 'select',
				'choices'  => $headings_fonts,
				'priority' => 2,
			)
		);

		// Body Font.
		$wp_customize->add_setting(
			'body_font',
			array(
				'default'           => 'Open Sans',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => array( __CLASS__, 'sanitize_font_name' ),
			)
		);

		$wp_customize->add_control(
			'educator_body_font',
			array(
				'label'    => __( 'Body Font', 'ib-educator' ),
				'section'  => 'educator_theme_font',
				'settings' => 'body_font',
				'type'     => 'select',
				'choices'  => $body_fonts,
				'priority' => 3,
			)
		);

		// Character Sets.
		$wp_customize->add_setting(
			'character_sets',
			array(
				'default'           => 'latin,latin-ext',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'educator_sanitize_character_sets',
			)
		);

		$wp_customize->add_control(
			'educator_character_sets',
			array(
				'label'       => __( 'Character Sets', 'ib-educator' ),
				'section'     => 'educator_theme_font',
				'settings'    => 'character_sets',
				'type'        => 'text',
				'description' => esc_html__( 'Enter character sets separated by ,(comma). These sets must be supported by the fonts you chose.', 'ib-educator' ),
				'priority'    => 4,
			)
		);

		// Font Size.
		$wp_customize->add_setting(
			'font_size',
			array(
				'default'           => 14,
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => array( __CLASS__, 'sanitize_font_size' ),
			)
		);

		$wp_customize->add_control(
			'educator_font_size',
			array(
				'label'    => __( 'Font Size', 'ib-educator' ),
				'section'  => 'educator_theme_font',
				'settings' => 'font_size',
				'type'     => 'select',
				'choices'  => array(
					'14' => '14px',
					'15' => '15px',
				),
				'priority' => 5,
			)
		);

		$font_weight = self::get_font_weight_choices();

		// Headings Font Weight.
		$wp_customize->add_setting(
			'headings_font_weight',
			array(
				'default'           => '600',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => array( __CLASS__, 'sanitize_font_weight' ),
			)
		);

		$wp_customize->add_control(
			'educator_headings_font_weight',
			array(
				'label'    => __( 'Headings Font Weight', 'ib-educator' ),
				'section'  => 'educator_theme_font',
				'settings' => 'headings_font_weight',
				'type'     => 'select',
				'choices'  => $font_weight,
				'priority' => 6,
			)
		);

		// Bold Text Font Weight.
		$wp_customize->add_setting(
			'bold_font_weight',
			array(
				'default'           => '600',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => array( __CLASS__, 'sanitize_font_weight' ),
			)
		);

		$wp_customize->add_control(
			'educator_bold_font_weight',
			array(
				'label'    => __( 'Bold Text Font Weight', 'ib-educator' ),
				'section'  => 'educator_theme_font',
				'settings' => 'bold_font_weight',
				'type'     => 'select',
				'choices'  => array(
					'bold' => esc_html__( 'Bold', 'ib-educator' ),
					'500'  => '500',
					'600'  => '600',
					'700'  => '700',
					'800'  => '800',
					'900'  => '900',
				),
				'priority' => 7,
			)
		);
	}

	public static function header_settings( $wp_customize ) {
		// Header Settings Section.
		$wp_customize->add_section(
			'educator_header',
			array(
				'title'    => __( 'Header Settings', 'ib-educator' ),
				'priority' => 2,
			)
		);

		// Fixed Header.
		$wp_customize->add_setting(
			'fixed_header',
			array(
				'default'           => 0,
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'educator_fixed_header',
			array(
				'label'    => __( 'Fixed Header', 'ib-educator' ),
				'section'  => 'educator_header',
				'settings' => 'fixed_header',
				'type'     => 'checkbox',
			)
		);

		// Show the Log in/Register Links in the Main Menu.
		$wp_customize->add_setting(
			'main_menu_auth',
			array(
				'default'           => '1',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'educator_main_menu_auth',
			array(
				'label'    => __( 'Show the Log in/Register Links in the Main Menu', 'ib-educator' ),
				'section'  => 'educator_header',
				'settings' => 'main_menu_auth',
				'type'     => 'checkbox',
			)
		);
	}

	public static function toolbar_settings( $wp_customize ) {
		// Toolbar Settings Section.
		$wp_customize->add_section(
			'educator_toolbar_settings',
			array(
				'title'    => __( 'Toolbar Settings', 'ib-educator' ),
				'priority' => 1,
			)
		);

		// Enable Toolbar.
		$wp_customize->add_setting(
			'toolbar_enable',
			array(
				'default'           => '1',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'educator_toolbar_enable',
			array(
				'label'    => __( 'Enable Toolbar', 'ib-educator' ),
				'section'  => 'educator_toolbar_settings',
				'settings' => 'toolbar_enable',
				'type'     => 'checkbox',
				'priority' => 0,
			)
		);

		// Toolbar Text.
		$wp_customize->add_setting(
			'toolbar_text',
			array(
				'default'           => '',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => array( __CLASS__, 'sanitize_toolbar_text' ),
			)
		);

		$wp_customize->add_control(
			'educator_toolbar_text',
			array(
				'label'       => __( 'Toolbar Text', 'ib-educator' ),
				'section'     => 'educator_toolbar_settings',
				'settings'    => 'toolbar_text',
				'type'        => 'text',
				'priority'    => 1,
			)
		);

		// Links to Social Networks.
		$wp_customize->add_setting(
			'toolbar_links',
			array(
				'default'           => 'facebook google+ twitter linkedin youtube vimeo instagram pinterest vk',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => array( __CLASS__, 'sanitize_social_networks' ),
			)
		);

		$wp_customize->add_control(
			'educator_toolbar_links',
			array(
				'label'       => __( 'Links to Social Networks', 'ib-educator' ),
				'section'     => 'educator_toolbar_settings',
				'settings'    => 'toolbar_links',
				'type'        => 'text',
				'description' => sprintf( __( 'List the names of the social networks. The names must be separated by spaces. Available social networks: %s', 'ib-educator' ), 'facebook google+ twitter linkedin youtube vimeo instagram pinterest vk' ),
				'priority'    => 1,
			)
		);

		// Facebook URL.
		$wp_customize->add_setting(
			'educator_settings[facebook]',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			'educator_facebook',
			array(
				'label'    => __( 'Facebook URL', 'ib-educator' ),
				'section'  => 'educator_toolbar_settings',
				'settings' => 'educator_settings[facebook]',
				'type'     => 'text',
				'priority' => 2,
			)
		);

		// Google+ URL.
		$wp_customize->add_setting(
			'educator_settings[google_plus]',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			'educator_google_plus',
			array(
				'label'    => __( 'Google+ URL', 'ib-educator' ),
				'section'  => 'educator_toolbar_settings',
				'settings' => 'educator_settings[google_plus]',
				'type'     => 'text',
				'priority' => 3,
			)
		);

		// Twitter URL.
		$wp_customize->add_setting(
			'educator_settings[twitter]',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			'educator_twitter',
			array(
				'label'    => __( 'Twitter URL', 'ib-educator' ),
				'section'  => 'educator_toolbar_settings',
				'settings' => 'educator_settings[twitter]',
				'type'     => 'text',
				'priority' => 4,
			)
		);

		// Linkedin URL.
		$wp_customize->add_setting(
			'educator_settings[linkedin]',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			'educator_linkedin',
			array(
				'label'    => __( 'Linkedin URL', 'ib-educator' ),
				'section'  => 'educator_toolbar_settings',
				'settings' => 'educator_settings[linkedin]',
				'type'     => 'text',
				'priority' => 5,
			)
		);

		// Youtube URL.
		$wp_customize->add_setting(
			'educator_settings[youtube]',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			'educator_youtube',
			array(
				'label'    => __( 'Youtube URL', 'ib-educator' ),
				'section'  => 'educator_toolbar_settings',
				'settings' => 'educator_settings[youtube]',
				'type'     => 'text',
				'priority' => 6,
			)
		);

		// Vimeo URL.
		$wp_customize->add_setting(
			'educator_settings[vimeo]',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			'educator_vimeo',
			array(
				'label'    => __( 'Vimeo URL', 'ib-educator' ),
				'section'  => 'educator_toolbar_settings',
				'settings' => 'educator_settings[vimeo]',
				'type'     => 'text',
				'priority' => 7,
			)
		);

		// Instagram URL.
		$wp_customize->add_setting(
			'educator_settings[instagram]',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			'educator_instagram',
			array(
				'label'    => __( 'Instagram URL', 'ib-educator' ),
				'section'  => 'educator_toolbar_settings',
				'settings' => 'educator_settings[instagram]',
				'type'     => 'text',
				'priority' => 8,
			)
		);

		// Pinterest URL.
		$wp_customize->add_setting(
			'educator_settings[pinterest]',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			'educator_pinterest',
			array(
				'label'    => __( 'Pinterest URL', 'ib-educator' ),
				'section'  => 'educator_toolbar_settings',
				'settings' => 'educator_settings[pinterest]',
				'type'     => 'text',
				'priority' => 9,
			)
		);

		// Vk URL.
		$wp_customize->add_setting(
			'educator_settings[vk]',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			'educator_vk',
			array(
				'label'    => __( 'Vk URL', 'ib-educator' ),
				'section'  => 'educator_toolbar_settings',
				'settings' => 'educator_settings[vk]',
				'type'     => 'text',
				'priority' => 10,
			)
		);
	}

	public static function page_layouts_settings( $wp_customize ) {
		// Page layouts section.
		$wp_customize->add_section(
			'educator_layouts',
			array(
				'title'       => __( 'Page Layouts', 'ib-educator' ),
				'description' => __( 'Select layouts for various pages of your website.', 'ib-educator' ),
				'priority'    => 4,
			)
		);

		// Sidebar Position.
		$wp_customize->add_setting(
			'sidebar_position',
			array(
				'default'           => 'right',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => array( __CLASS__, 'sanitize_sidebar_position' ),
			)
		);

		$wp_customize->add_control(
			'educator_sidebar_position',
			array(
				'label'    => __( 'Sidebar Position', 'ib-educator' ),
				'section'  => 'educator_layouts',
				'settings' => 'sidebar_position',
				'type'     => 'select',
				'choices'  => array(
					'right' => __( 'Right', 'ib-educator' ),
					'left'  => __( 'Left', 'ib-educator' ),
				),
			)
		);

		// Blog page layout.
		$wp_customize->add_setting(
			'blog_layout',
			array(
				'default'           => 'grid_sidebar',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => array( __CLASS__, 'sanitize_layout' ),
			)
		);

		$wp_customize->add_control(
			'educator_blog_layout',
			array(
				'label'    => __( 'Blog Layout', 'ib-educator' ),
				'section'  => 'educator_layouts',
				'settings' => 'blog_layout',
				'type'     => 'select',
				'choices'  => array(
					'list'            => __( 'List with sidebar', 'ib-educator' ),
					'grid_sidebar'    => __( 'Grid with sidebar', 'ib-educator' ),
					'grid_no_sidebar' => __( 'Grid without sidebar', 'ib-educator' ),
				),
			)
		);

		// Courses page layout.
		$wp_customize->add_setting(
			'courses_layout',
			array(
				'default'           => 'grid_sidebar',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => array( __CLASS__, 'sanitize_layout' ),
			)
		);

		$wp_customize->add_control(
			'educator_courses_layout',
			array(
				'label'    => __( 'Courses Layout', 'ib-educator' ),
				'section'  => 'educator_layouts',
				'settings' => 'courses_layout',
				'type'     => 'select',
				'choices'  => array(
					'list'            => __( 'List with sidebar', 'ib-educator' ),
					'grid_sidebar'    => __( 'Grid with sidebar', 'ib-educator' ),
					'grid_no_sidebar' => __( 'Grid without sidebar', 'ib-educator' ),
				),
			)
		);

		// Lessons on the course page.
		$wp_customize->add_setting(
			'lessons_layout',
			array(
				'default'           => 'default',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_control(
			'educator_lessons_layout',
			array(
				'label'    => __( 'Lessons on the course page', 'ib-educator' ),
				'section'  => 'educator_layouts',
				'settings' => 'lessons_layout',
				'type'     => 'select',
				'choices'  => array(
					'default' => __( 'Default', 'ib-educator' ),
					'compact' => __( 'Compact', 'ib-educator' ),
				),
			)
		);

		// Shop layout.
		$wp_customize->add_setting(
			'shop_layout',
			array(
				'default'           => 'default',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_control(
			'educator_shop_layout',
			array(
				'label'    => __( 'Shop Layout', 'ib-educator' ),
				'section'  => 'educator_layouts',
				'settings' => 'shop_layout',
				'type'     => 'select',
				'choices'  => array(
					'default' => __( 'Default', 'ib-educator' ),
					'fw'      => __( 'Full width', 'ib-educator' ),
				),
			)
		);

		// Shop columns.
		$wp_customize->add_setting(
			'shop_columns',
			array(
				'default'           => 3,
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'educator_shop_columns',
			array(
				'label'    => __( 'Shop Columns', 'ib-educator' ),
				'section'  => 'educator_layouts',
				'settings' => 'shop_columns',
				'type'     => 'select',
				'choices'  => array(
					2 => 2,
					3 => 3,
					4 => 4,
				),
			)
		);
	}

	public static function color_settings( $wp_customize ) {
		// Main Color.
		$wp_customize->add_setting(
			'main_color',
			array(
				'default'           => '#149dd2',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'educator_main_color',
				array(
					'label'    => __( 'Main Color', 'ib-educator' ),
					'section'  => 'colors',
					'settings' => 'main_color',
					'priority' => 0,
				)
			)
		);

		// Hover Color.
		$wp_customize->add_setting(
			'hover_color',
			array(
				'default'           => '#057caa',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'educator_hover_color',
				array(
					'label'    => __( 'Hover Color', 'ib-educator' ),
					'section'  => 'colors',
					'settings' => 'hover_color',
					'priority' => 1,
				)
			)
		);

		// Text Color.
		$wp_customize->add_setting(
			'text_color',
			array(
				'default'           => '#555',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'educator_text_color',
				array(
					'label'    => __( 'Text Color', 'ib-educator' ),
					'section'  => 'colors',
					'settings' => 'text_color',
					'priority' => 2,
				)
			)
		);

		// Headings Color.
		$wp_customize->add_setting(
			'headings_color',
			array(
				'default'           => '#333',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'educator_headings_color',
				array(
					'label'    => __( 'Headings Color', 'ib-educator' ),
					'section'  => 'colors',
					'settings' => 'headings_color',
					'priority' => 3,
				)
			)
		);

		// Hover BG Color.
		$wp_customize->add_setting(
			'hover_bg',
			array(
				'default'           => '#f5f5f5',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'educator_hover_bg',
				array(
					'label'       => __( 'Hover Background Color', 'ib-educator' ),
					'section'     => 'colors',
					'settings'    => 'hover_bg',
					'priority'    => 4,
					'description' => __( 'Sub menu items, share buttons, etc.', 'ib-educator' ),
				)
			)
		);

		// Hover Text Color.
		$wp_customize->add_setting(
			'hover_text',
			array(
				'default'           => '#149dd2',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'educator_hover_text',
				array(
					'label'       => __( 'Hover Text Color', 'ib-educator' ),
					'section'     => 'colors',
					'settings'    => 'hover_text',
					'priority'    => 5,
					'description' => __( 'Sub menu items, share buttons, etc.', 'ib-educator' ),
				)
			)
		);
	}

	public static function share_settings( $wp_customize ) {
		// Share settings section.
		$wp_customize->add_section(
			'educator_share_settings',
			array(
				'title'    => __( 'Share Settings', 'ib-educator' ),
				'priority' => 5,
			)
		);

		// Enable/disable share buttons.
		$wp_customize->add_setting(
			'share_enable',
			array(
				'default'           => '1',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'educator_share_enable',
			array(
				'label'    => __( 'Enable Share Buttons', 'ib-educator' ),
				'section'  => 'educator_share_settings',
				'settings' => 'share_enable',
				'type'     => 'checkbox',
			)
		);

		// Share buttons.
		$wp_customize->add_setting(
			'share_buttons',
			array(
				'default'           => 'facebook google+ twitter',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => array( __CLASS__, 'sanitize_share_buttons' ),
			)
		);

		$wp_customize->add_control(
			'educator_share_buttons',
			array(
				'label'       => __( 'Share buttons', 'ib-educator' ),
				'section'     => 'educator_share_settings',
				'settings'    => 'share_buttons',
				'type'        => 'text',
				'description' => sprintf( __( 'List the names of the share buttons you would like to use. The names must be separated by spaces. Available share buttons: %s', 'ib-educator' ), 'facebook google+ twitter' ),
			)
		);

		// Facebook API key.
		$wp_customize->add_setting(
			'educator_settings[facebook_api_key]',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => array( __CLASS__, 'sanitize_facebook_api_key' ),
			)
		);

		$wp_customize->add_control(
			'educator_facebook_api_key',
			array(
				'label'       => __( 'Facebook App ID', 'ib-educator' ),
				'section'     => 'educator_share_settings',
				'settings'    => 'educator_settings[facebook_api_key]',
				'type'        => 'text',
				'description' => __( 'This ID is required to create a Facebook share link.', 'ib-educator' ),
			)
		);

		// Twitter Via.
		$wp_customize->add_setting(
			'educator_settings[twitter_via]',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'educator_twitter_via',
			array(
				'label'       => __( 'Twitter via', 'ib-educator' ),
				'section'     => 'educator_share_settings',
				'settings'    => 'educator_settings[twitter_via]',
				'type'        => 'text',
				'description' => __( 'Your twitter screen name.', 'ib-educator' ),
			)
		);
	}

	public static function login_register_settings( $wp_customize ) {
		// Log in/register Section.
		$wp_customize->add_section(
			'educator_login_settings',
			array(
				'title'    => __( 'Log in/register', 'ib-educator' ),
				'priority' => 6,
			)
		);

		// Log In Page.
		$wp_customize->add_setting(
			'login_page',
			array(
				'default'           => 0,
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'educator_login_page',
			array(
				'label'    => __( 'Log In Page', 'ib-educator' ),
				'section'  => 'educator_login_settings',
				'settings' => 'login_page',
				'type'     => 'dropdown-pages',
				'priority' => 0,
			)
		);

		// Register Page.
		$wp_customize->add_setting(
			'register_page',
			array(
				'default'           => 0,
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'educator_register_page',
			array(
				'label'    => __( 'Register Page', 'ib-educator' ),
				'section'  => 'educator_login_settings',
				'settings' => 'register_page',
				'type'     => 'dropdown-pages',
				'priority' => 1,
			)
		);

		// Profile.
		$wp_customize->add_setting(
			'user_page',
			array(
				'default'           => 0,
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'educator_user_page',
			array(
				'label'    => __( 'Profile', 'ib-educator' ),
				'section'  => 'educator_login_settings',
				'settings' => 'user_page',
				'type'     => 'dropdown-pages',
				'priority' => 2,
			)
		);
	}

	public static function footer_settings( $wp_customize ) {
		// Footer settings section.
		$wp_customize->add_section(
			'educator_footer_settings',
			array(
				'title'    => __( 'Footer Settings', 'ib-educator' ),
				'priority' => 7,
			)
		);

		// Enable/disable footer widgets.
		$wp_customize->add_setting(
			'footer_widgets_enable',
			array(
				'default'           => '1',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'educator_footer_widgets_enable',
			array(
				'label'    => __( 'Enable Footer Widgets', 'ib-educator' ),
				'section'  => 'educator_footer_settings',
				'settings' => 'footer_widgets_enable',
				'type'     => 'checkbox',
			)
		);

		// Footer layout.
		$wp_customize->add_setting(
			'footer_layout',
			array(
				'default'           => '3_columns',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => array( __CLASS__, 'sanitize_footer_layout' ),
			)
		);

		$wp_customize->add_control(
			'educator_footer_layout',
			array(
				'label'    => __( 'Footer Layout', 'ib-educator' ),
				'section'  => 'educator_footer_settings',
				'settings' => 'footer_layout',
				'type'     => 'select',
				'choices'  => array(
					'3_columns' => __( '3 columns', 'ib-educator' ),
					'4_columns' => __( '4 columns', 'ib-educator' ),
				),
			)
		);

		// Footer copy.
		$wp_customize->add_setting(
			'footer_copy',
			array(
				'default'           => '',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => array( __CLASS__, 'simple_html' ),
			)
		);

		$wp_customize->add_control(
			'educator_footer_copy',
			array(
				'label'       => __( 'Footer Copyright Notice', 'ib-educator' ),
				'section'     => 'educator_footer_settings',
				'settings'    => 'footer_copy',
				'type'        => 'textarea',
				'description' => sprintf( __( 'You may use these HTML tags and attributes: %s', 'ib-educator' ), '&lt;a href="" title=""&gt;' ),
			)
		);
	}

	public static function advanced_settings( $wp_customize ) {
		$wp_customize->add_section(
			'educator_advanced_settings',
			array(
				'title'    => __( 'Advanced', 'ib-educator' ),
				'priority' => 8,
			)
		);

		// lecturer_link.
		$wp_customize->add_setting(
			'lecturer_link',
			array(
				'default'           => 'courses',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_control(
			'educator_lecturer_link',
			array(
				'label'    => __( 'Lecturer&apos;s profile link goes to', 'ib-educator' ),
				'section'  => 'educator_advanced_settings',
				'settings' => 'lecturer_link',
				'type'     => 'radio',
				'choices'  => array(
					'courses' => __( 'Courses', 'ib-educator' ),
					'posts'   => __( 'Posts', 'ib-educator' ),
				),
			)
		);

		// disable lightbox.
		$wp_customize->add_setting(
			'disable_lightbox',
			array(
				'default'           => 0,
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'educator_disable_lightbox',
			array(
				'label'    => __( 'Disable the default lightbox', 'ib-educator' ),
				'section'  => 'educator_advanced_settings',
				'settings' => 'disable_lightbox',
				'type'     => 'checkbox',
			)
		);

		// continue reading.
		$wp_customize->add_setting(
			'continue_reading',
			array(
				'default'           => 0,
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'educator_continue_reading',
			array(
				'label'    => __( 'Enable the Continue reading link', 'ib-educator' ),
				'section'  => 'educator_advanced_settings',
				'settings' => 'continue_reading',
				'type'     => 'checkbox',
			)
		);

		// enable WooCommerce support.
		$wp_customize->add_setting(
			'woocommerce_enable',
			array(
				'default'           => 1,
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'educator_woocommerce_enable',
			array(
				'label'    => __( 'Enable WooCommerce Support', 'ib-educator' ),
				'section'  => 'educator_advanced_settings',
				'settings' => 'woocommerce_enable',
				'type'     => 'checkbox',
			)
		);

		// Owl Carousel Version.
		$wp_customize->add_setting(
			'owl_carousel',
			array(
				'default'           => 1,
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'educator_owl_carousel',
			array(
				'label'    => __( 'Owl Carousel Version', 'ib-educator' ),
				'section'  => 'educator_advanced_settings',
				'settings' => 'owl_carousel',
				'type'     => 'select',
				'choices'  => array(
					1 => 1,
					2 => 2,
				),
			)
		);
	}

	/**
	 * Sanitize font-weight css property.
	 *
	 * @param string $input
	 * @return string
	 */
	public static function sanitize_font_weight( $input ) {
		switch ( $input ) {
			case 'normal':
			case 'bold':
			case 'bolder':
			case 'lighter':
			case '100':
			case '200':
			case '300':
			case '400':
			case '500':
			case '600':
			case '700':
			case '800':
			case '900':
				return $input;
				break;
		}

		return 'normal';
	}

	/**
	 * Output customized style.
	 */
	public static function output_style() {
		$text_color           = self::sanitize_hex_color( get_theme_mod( 'text_color', '#555555' ) );
		$main_color           = self::sanitize_hex_color( get_theme_mod( 'main_color', '#149dd2' ) );
		$hover_color          = self::sanitize_hex_color( get_theme_mod( 'hover_color', '#057caa' ) );
		$headings_color       = self::sanitize_hex_color( get_theme_mod( 'headings_color', '#333333' ) );
		$hover_bg             = self::sanitize_hex_color( get_theme_mod( 'hover_bg', '#f5f5f5' ) );
		$hover_text           = self::sanitize_hex_color( get_theme_mod( 'hover_text', '#149dd2' ) );
		$headings_font_weight = self::sanitize_font_weight( get_theme_mod( 'headings_font_weight', '600' ) );
		$bold_font_weight     = self::sanitize_font_weight( get_theme_mod( 'bold_font_weight', '600' ) );
		$headings_font        = self::sanitize_font_name( get_theme_mod( 'headings_font', 'Open Sans' ) );
		$body_font            = self::sanitize_font_name( get_theme_mod( 'body_font', 'Open Sans' ) );
		$font_size            = self::sanitize_font_size( get_theme_mod( 'font_size', 14 ) );

		if ( ! empty( $headings_font ) && 'Default' != $headings_font ) {
			$headings_font = '"' . $headings_font . '", "Helvetica Neue", Helvetica, Arial, sans-serif';
		} else {
			$headings_font = '"Helvetica Neue", Helvetica, Arial, sans-serif';
		}

		if ( ! empty( $body_font ) && 'Default' != $body_font ) {
			$body_font = '"' . $body_font . '", "Helvetica Neue", Helvetica, Arial, sans-serif';
		} else {
			$body_font = '"Helvetica Neue", Helvetica, Arial, sans-serif';
		}

		ob_start();
		include get_template_directory() . '/include/custom-style.php';
		$custom_style = ob_get_clean();

		wp_add_inline_style( 'educator-style', $custom_style );
	}
}

Educator_Theme_Customize::init();
