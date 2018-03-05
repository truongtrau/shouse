<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * Compatibility with WooCommerce Carousel Slider and WooCommerce Product Slider plugins from a3rev
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'get_plugins' ) ) {
	require_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

$compatibility_plugins = array( 'woocommerce-carousel-slider', 'woocommerce-product-slider' );

$have_plugin_activated = false;

foreach ( $compatibility_plugins as $plugin_slug ) {
	if ( is_dir( WP_PLUGIN_DIR . '/' . $plugin_slug ) ) {
		$installed_plugin = get_plugins( '/' . $plugin_slug );
		$key = array_keys( $installed_plugin );
		$key = array_shift( $key );
		$plugin_path = $plugin_slug.'/'.$key;

		if ( is_plugin_active( $plugin_path ) ) {
			$have_plugin_activated = true;
			break;
		}
	}
}

if ( ! $have_plugin_activated ) return; // Exit if above compatibility plugins is not activated

add_action( 'woocommerce_api_wc_product_slider_legacy_api', 'wc_product_slider_api_handler_custom', 9 );

function wc_product_slider_api_handler_custom() {
	global $wc_quick_view_ultimate;

	add_action( 'woocommerce_after_shop_loop_item', array( $wc_quick_view_ultimate, 'quick_view_ultimate_under_image' ), 9 );
}
