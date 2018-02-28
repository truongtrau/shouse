<?php
/**
 * shouse_kego WooCommerce hooks
 *
 * @package shouse_kego
 */

/**
 * Styles
 *
 * @see  shouse_kego_woocommerce_scripts()
 */

/**
 * Layout
 *
 * @see  shouse_kego_before_content()
 * @see  shouse_kego_after_content()
 * @see  woocommerce_breadcrumb()
 * @see  shouse_kego_shop_messages()
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb',                   20 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper',       10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end',   10 );
remove_action( 'woocommerce_sidebar',             'woocommerce_get_sidebar',                  10 );
remove_action( 'woocommerce_after_shop_loop',     'woocommerce_pagination',                   10 );
remove_action( 'woocommerce_before_shop_loop',    'woocommerce_result_count',                 20 );
remove_action( 'woocommerce_before_shop_loop',    'woocommerce_catalog_ordering',             30 );
add_action( 'woocommerce_before_main_content',    'shouse_kego_before_content',                10 );
add_action( 'woocommerce_after_main_content',     'shouse_kego_after_content',                 10 );
add_action( 'shouse_kego_content_top',             'shouse_kego_shop_messages',                 15 );
add_action( 'shouse_kego_content_top',             'woocommerce_breadcrumb',                   10 );

add_action( 'woocommerce_after_shop_loop',        'shouse_kego_sorting_wrapper',               9 );
add_action( 'woocommerce_after_shop_loop',        'woocommerce_catalog_ordering',             10 );
add_action( 'woocommerce_after_shop_loop',        'woocommerce_result_count',                 20 );
add_action( 'woocommerce_after_shop_loop',        'woocommerce_pagination',                   30 );
add_action( 'woocommerce_after_shop_loop',        'shouse_kego_sorting_wrapper_close',         31 );
add_action( 'woocommerce_after_shop_loop',        'shouse_kego_product_columns_wrapper_close', 40 );

add_action( 'woocommerce_before_shop_loop',       'shouse_kego_sorting_wrapper',               9 );
add_action( 'woocommerce_before_shop_loop',       'woocommerce_catalog_ordering',             10 );
add_action( 'woocommerce_before_shop_loop',       'woocommerce_result_count',                 20 );
add_action( 'woocommerce_before_shop_loop',       'shouse_kego_woocommerce_pagination',        30 );
add_action( 'woocommerce_before_shop_loop',       'shouse_kego_sorting_wrapper_close',         31 );
add_action( 'woocommerce_before_shop_loop',       'shouse_kego_product_columns_wrapper',       40 );

add_action( 'shouse_kego_footer',                  'shouse_kego_handheld_footer_bar',           999 );

// Legacy WooCommerce columns filter.
if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.3', '<' ) ) {
	add_filter( 'loop_shop_columns', 'shouse_kego_loop_columns' );
}

/**
 * Products
 *
 * @see  shouse_kego_upsell_display()
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display',               15 );
add_action( 'woocommerce_after_single_product_summary',    'shouse_kego_upsell_display',                15 );
remove_action( 'woocommerce_before_shop_loop_item_title',  'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_after_shop_loop_item_title',      'woocommerce_show_product_loop_sale_flash', 6 );

/**
 * Header
 *
 * @see  shouse_kego_product_search()
 * @see  shouse_kego_header_cart()
 */
add_action( 'shouse_kego_header', 'shouse_kego_product_search', 40 );
add_action( 'shouse_kego_header', 'shouse_kego_header_cart',    60 );

/**
 * Cart fragment
 *
 * @see shouse_kego_cart_link_fragment()
 */
if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
	add_filter( 'woocommerce_add_to_cart_fragments', 'shouse_kego_cart_link_fragment' );
} else {
	add_filter( 'add_to_cart_fragments', 'shouse_kego_cart_link_fragment' );
}
