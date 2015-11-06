<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Educator_Theme_WooCommerce {
	/**
	 * @var Educator_Theme_WooCommerce
	 */
	protected static $instance = null;

	/**
	 * Get instance.
	 *
	 * @return Educator_Theme_WooCommerce
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	protected function __construct() {
		// Don't use default styles.
		add_filter( 'woocommerce_enqueue_styles', '__return_false' );

		// Don't show page title.
		add_filter( 'woocommerce_show_page_title', '__return_false' );
		
		// Move sale message above the price.
		remove_filter( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
		add_filter( 'woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 8 );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_filter( 'loop_shop_columns', array( $this, 'loop_shop_columns' ) );
		add_action( 'woocommerce_before_shop_loop', array( $this, 'before_shop_loop' ), 999 );
		add_action( 'woocommerce_after_shop_loop', array( $this, 'after_shop_loop' ), 0 );

		// Change the position of the shop loop results count and ordering.
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
		add_action( 'woocommerce_before_shop_loop', array( $this, 'shop_loop_info' ), 20 );

		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'cart_widget_fragments' ) );
	}

	/**
	 * Get custom shopping cart widget.
	 *
	 * @return string
	 */
	public function get_cart_widget() {
		$cart = WC()->cart;
		$count = $cart->cart_contents_count;
		$output = '<a class="edu-cart-widget" href="' . esc_url( $cart->get_cart_url() )
				. '" title="' . __( 'View shopping cart', 'ib-educator' ) . '">'
				. sprintf( _n( '%d item', '%d items', $count, 'ib-educator' ), $count )
				. ' - ' . $cart->get_cart_total() . '</a>';

		return $output;
	}

	/**
	 * Enqueue scripts and styles.
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'educator-woocommerce', get_template_directory_uri() . '/css/woocommerce.css' );
	}

	/**
	 * Get the number of columns for the shop loop.
	 *
	 * @return int
	 */
	public function loop_shop_columns() {
		return intval( get_theme_mod( 'shop_columns', 3 ) );
	}

	/**
	 * Wrap ul.products list on the shop loop page.
	 */
	public function before_shop_loop() {
		$layout = get_theme_mod( 'shop_layout', 'default' );

		echo '<div class="shop-layout shop-layout-' . esc_attr( $layout ) . ' columns-' . $this->loop_shop_columns() . '">';
	}

	/**
	 * Close the ul.products list wrapper.
	 */
	public function after_shop_loop() {
		echo '</div>';
	}

	/**
	 * Display shop loop results count and ordering.
	 */
	public function shop_loop_info() {
		echo '<div class="edu-shop-loop-info">';
		woocommerce_catalog_ordering();
		woocommerce_result_count();
		echo '</div>';
	}

	/**
	 * Update the custom shopping cart UI when a product is added to cart.
	 */
	public function cart_widget_fragments( $fragments ) {
		$fragments['a.edu-cart-widget'] = $this->get_cart_widget();

		return $fragments;
	}
}

Educator_Theme_WooCommerce::instance();
