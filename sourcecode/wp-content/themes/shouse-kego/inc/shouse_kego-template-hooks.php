<?php
/**
 * shouse_kego hooks
 *
 * @package shouse_kego
 */

/**
 * General
 *
 * @see  shouse_kego_header_widget_region()
 * @see  shouse_kego_get_sidebar()
 */
add_action( 'shouse_kego_before_content', 'shouse_kego_header_widget_region', 10 );
add_action( 'shouse_kego_sidebar',        'shouse_kego_get_sidebar',          10 );

/**
 * Header
 *
 * @see  shouse_kego_skip_links()
 * @see  shouse_kego_secondary_navigation()
 * @see  shouse_kego_site_branding()
 * @see  shouse_kego_primary_navigation()
 */
add_action( 'shouse_kego_header', 'shouse_kego_skip_links',                       0 );
add_action( 'shouse_kego_header', 'shouse_kego_site_branding',                    20 );
add_action( 'shouse_kego_header', 'shouse_kego_secondary_navigation',             30 );
add_action( 'shouse_kego_header', 'shouse_kego_primary_navigation_wrapper',       42 );
add_action( 'shouse_kego_header', 'shouse_kego_primary_navigation',               50 );
add_action( 'shouse_kego_header', 'shouse_kego_primary_navigation_wrapper_close', 68 );

/**
 * Footer
 *
 * @see  shouse_kego_footer_widgets()
 * @see  shouse_kego_credit()
 */
add_action( 'shouse_kego_footer', 'shouse_kego_footer_widgets', 10 );
add_action( 'shouse_kego_footer', 'shouse_kego_credit',         20 );

/**
 * Homepage
 *
 * @see  shouse_kego_homepage_content()
 * @see  shouse_kego_product_categories()
 * @see  shouse_kego_recent_products()
 * @see  shouse_kego_featured_products()
 * @see  shouse_kego_popular_products()
 * @see  shouse_kego_on_sale_products()
 * @see  shouse_kego_best_selling_products()
 */
add_action( 'homepage', 'shouse_kego_homepage_content',      10 );
add_action( 'homepage', 'shouse_kego_product_categories',    20 );
add_action( 'homepage', 'shouse_kego_recent_products',       30 );
add_action( 'homepage', 'shouse_kego_featured_products',     40 );
add_action( 'homepage', 'shouse_kego_popular_products',      50 );
add_action( 'homepage', 'shouse_kego_on_sale_products',      60 );
add_action( 'homepage', 'shouse_kego_best_selling_products', 70 );

/**
 * Posts
 *
 * @see  shouse_kego_post_header()
 * @see  shouse_kego_post_meta()
 * @see  shouse_kego_post_content()
 * @see  shouse_kego_paging_nav()
 * @see  shouse_kego_single_post_header()
 * @see  shouse_kego_post_nav()
 * @see  shouse_kego_display_comments()
 */
add_action( 'shouse_kego_loop_post',           'shouse_kego_post_header',          10 );
add_action( 'shouse_kego_loop_post',           'shouse_kego_post_meta',            20 );
add_action( 'shouse_kego_loop_post',           'shouse_kego_post_content',         30 );
add_action( 'shouse_kego_loop_after',          'shouse_kego_paging_nav',           10 );
add_action( 'shouse_kego_single_post',         'shouse_kego_post_header',          10 );
add_action( 'shouse_kego_single_post',         'shouse_kego_post_meta',            20 );
add_action( 'shouse_kego_single_post',         'shouse_kego_post_content',         30 );
add_action( 'shouse_kego_single_post_bottom',  'shouse_kego_post_nav',             10 );
add_action( 'shouse_kego_single_post_bottom',  'shouse_kego_display_comments',     20 );
add_action( 'shouse_kego_post_content_before', 'shouse_kego_post_thumbnail',       10 );

/**
 * Pages
 *
 * @see  shouse_kego_page_header()
 * @see  shouse_kego_page_content()
 * @see  shouse_kego_display_comments()
 */
add_action( 'shouse_kego_page',       'shouse_kego_page_header',          10 );
add_action( 'shouse_kego_page',       'shouse_kego_page_content',         20 );
add_action( 'shouse_kego_page_after', 'shouse_kego_display_comments',     10 );

add_action( 'shouse_kego_homepage',       'shouse_kego_homepage_header',      10 );
add_action( 'shouse_kego_homepage',       'shouse_kego_page_content',         20 );