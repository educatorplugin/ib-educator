<form role="search" method="get" class="woocommerce-product-search search-form" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<label for="s">
		<span class="screen-reader-text"><?php _e( 'Search for:', 'ib-educator' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'ib-educator' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'ib-educator' ); ?>" />
	</label>
	<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'ib-educator' ); ?>" />
	<input type="hidden" name="post_type" value="product" />
</form>
