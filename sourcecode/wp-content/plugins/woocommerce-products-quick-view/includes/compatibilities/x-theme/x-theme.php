<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Product Slider Legacy API Class
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( 'x' != get_template() ) return; // Exit if it's not X theme

add_action( 'woocommerce_before_shop_loop_item', 'quick_view_x_theme_woocommerce_before_shop_loop_item', 0 );

function quick_view_x_theme_woocommerce_before_shop_loop_item() {

	remove_action( 'woocommerce_before_shop_loop_item_title', 'x_woocommerce_before_shop_loop_item_title', 10 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'x_woocommerce_before_shop_loop_item_title', 12 );
}