<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add default fonts choices.
 *
 * @param array $fonts
 * @return array
 */
function educator_theme_default_fonts( $fonts ) {
	$fonts['Default'] = array();

	$fonts['Open Sans'] = array(
		'font_styles' => '400,600,700,400italic,600italic,700italic',
	);

	$fonts['PT Sans'] = array(
		'font_styles' => '400,700,400italic,700italic',
	);

	$fonts['Roboto'] = array(
		'font_styles' => '300,400,700,300italic,400italic,700italic',
	);
	
	$fonts['Noto Sans'] = array(
		'font_styles' => '400,700,400italic,700italic',
	);

	$fonts['Oxygen'] = array(
		'font_styles'   => '300,400,700',
		'only_headings' => true,
	);

	return $fonts;
}
add_filter( 'ib_theme_get_fonts', 'educator_theme_default_fonts' );

/**
 * Sanitize google fonts subsets list.
 *
 * @param string $input Comma separated list of subsets (e.g. latin,latin-ext).
 * @return string
 */
function educator_sanitize_character_sets( $input ) {
	if ( empty( $input ) ) {
		return '';
	}

	$parts = explode( ',', $input );

	if ( empty( $parts ) ) {
		return '';
	}

	$sanitized = array();

	foreach ( $parts as $part ) {
		$part = trim( $part );

		if ( preg_match( '/^[a-zA-Z0-9\-]+$/', $part ) ) {
			$sanitized[] = $part;
		}
	}

	return implode( ',', $sanitized );
}

if ( ! function_exists( 'educator_theme_fonts_url' ) ) :
/**
 * Get fonts URL.
 *
 * @return string
 */
function educator_theme_fonts_url() {
	$fonts = array();
	$fonts[] = get_theme_mod( 'headings_font', 'Open Sans' );
	$fonts[] = get_theme_mod( 'body_font', 'Open Sans' );
	$font_families = array();
	$available_fonts = apply_filters( 'ib_theme_get_fonts', array() );

	foreach ( $fonts as $font_name ) {
		if ( isset( $font_families[ $font_name ] ) ) {
			continue;
		}

		if ( isset( $available_fonts[ $font_name ] ) ) {
			$font = $available_fonts[ $font_name ];
			$font_families[ $font_name ] = urlencode( $font_name );

			if ( ! empty( $font['font_styles'] ) ) {
				$font_families[ $font_name ] .= ':' . $font['font_styles'];
			}
		}
	}

	if ( empty( $font_families ) ) {
		return false;
	}

	$query_args = array( array(
		'family' => implode( '|', $font_families ),
	) );

	$charater_sets = get_theme_mod( 'charater_sets', 'latin,latin-ext' );

	if ( ! empty( $charater_sets ) ) {
		$query_args['subset'] = educator_sanitize_character_sets( $charater_sets );
	}

	return add_query_arg( $query_args, '//fonts.googleapis.com/css' );
}
endif;
