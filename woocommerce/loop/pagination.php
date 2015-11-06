<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wp_query;

if ( $wp_query->max_num_pages <= 1 ) {
	return;
}

$current_page = max( 1, get_query_var( 'paged' ) );
?>
<nav class="woocommerce-pagination pagination clearfix">
	<div class="text"><?php printf( __( 'Page %d of %d', 'ib-educator' ), intval( $current_page ), intval( $wp_query->max_num_pages ) ); ?></div>
	<div class="links">
		<?php
			echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
				'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
				'format'       => '',
				'add_args'     => '',
				'current'      => $current_page,
				'total'        => $wp_query->max_num_pages,
				'prev_text'    => '<span class="fa fa-angle-left"></span>',
				'next_text'    => '<span class="fa fa-angle-right"></span>',
				'type'         => 'plain',
				'end_size'     => 3,
				'mid_size'     => 3,
			) ) );
		?>
	</div>
</nav>
