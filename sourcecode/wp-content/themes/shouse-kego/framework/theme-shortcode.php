<?php
/**
 * Theme Short-code Functions
 */
 $shortcode_path = get_template_directory() . '/framework/shortcodes/';
 
/****************Standards Shortcodes***********************/ 
require_once($shortcode_path. "columns.php" );
require_once($shortcode_path. "dropcap.php" );
require_once($shortcode_path. "tabs.php" );
require_once($shortcode_path. "toggles.php" );
require_once($shortcode_path. "highlight.php" );
require_once($shortcode_path. "quote.php" );
require_once($shortcode_path. "separator.php" );
require_once($shortcode_path. "pre.php" );
require_once($shortcode_path. "highlight-content.php" );
require_once($shortcode_path. "imgframe.php" );
require_once($shortcode_path. "featured-product.php" );
require_once($shortcode_path. "recent-featured-product.php" );
require_once($shortcode_path. "best-seller.php" );
?>