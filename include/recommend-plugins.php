<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Get plugins required by this theme.
 */
function educator_get_plugins() {
	$plugins = array(
		array(
			'name'     => 'Educator Theme Features',
			'slug'     => 'ib-educator-theme',
			'source'   => 'https://github.com/educatorplugin/ib-educator-theme/archive/1.4.0.zip',
			'required' => false,
			'version'  => '1.4.0',
		),

		array(
			'name'     => 'ib-slideshow',
			'slug'     => 'ib-slideshow',
			'source'   => 'https://github.com/educatorplugin/ib-slideshow/archive/1.1.0.zip',
			'required' => false,
			'version'  => '1.1.0',
		),

		array(
			'name'     => 'ib-retina',
			'slug'     => 'ib-retina',
			'source'   => 'https://github.com/educatorplugin/ib-retina/archive/1.1.0.zip',
			'required' => false,
			'version'  => '1.1.0',
		),

		array(
			'name'     => 'Dm3Shortcodes',
			'slug'     => 'dm3-shortcodes',
			'source'   => 'https://github.com/educatorplugin/dm3-shortcodes/archive/2.2.1.zip',
			'required' => false,
			'version'  => '2.2.1',
		),

		array(
			'name'     => 'Educator',
			'slug'     => 'ibeducator',
			'required' => false,
		),

		array(
			'name'     => 'WooSidebars',
			'slug'     => 'woosidebars',
			'required' => false,
		),

		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'required' => false,
		),

		array(
			'name'     => 'Educator WooCommerce Integration',
			'slug'     => 'educator-woocommerce-integration',
			'required' => false,
		),
	);

	return apply_filters( 'educator_theme_get_plugins', $plugins );
}

/**
 * TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/include/class-tgm-plugin-activation.php';

/**
 * Register the recommended plugins with the TGM Plugin Activation.
 */
function educator_tgmpa_register() {
	$config = array(
		'id'           => 'tgmpa',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'ib-educator' ),
			'menu_title'                      => __( 'Install Plugins', 'ib-educator' ),
			'installing'                      => __( 'Installing Plugin: %s', 'ib-educator' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'ib-educator' ),
			'notice_can_install_required'     => _n_noop(
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'ib-educator'
			), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop(
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'ib-educator'
			), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop(
				'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
				'ib-educator'
			), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'ib-educator'
			), // %1$s = plugin name(s).
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'ib-educator'
			), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop(
				'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
				'ib-educator'
			), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'ib-educator'
			), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'ib-educator'
			), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop(
				'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
				'ib-educator'
			), // %1$s = plugin name(s).
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'ib-educator'
			),
			'update_link'                     => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'ib-educator'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'ib-educator'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'ib-educator' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'ib-educator' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'ib-educator' ),
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'ib-educator' ),  // %1$s = plugin name(s).
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'ib-educator' ),  // %1$s = plugin name(s).
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'ib-educator' ), // %s = dashboard link.
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'ib-educator' ),
			'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
	);

	tgmpa( educator_get_plugins(), $config );
}
add_action( 'tgmpa_register', 'educator_tgmpa_register' );
