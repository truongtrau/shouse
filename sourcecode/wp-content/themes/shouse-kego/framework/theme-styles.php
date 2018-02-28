<?php
function dessky_styles() {
	if (!is_admin()) {
		
		wp_register_style('skeleton-css', get_template_directory_uri().'/assets/skeleton.css', '', '', 'screen, all');
		wp_enqueue_style('skeleton-css');
		
		wp_register_style('general-css', get_bloginfo( 'stylesheet_url' ), '', '', 'all');
		wp_enqueue_style('general-css');
		
		wp_register_style('prettyPhoto-css', get_template_directory_uri().'/assets/prettyPhoto.css', '', '', 'screen, all');
		wp_enqueue_style('prettyPhoto-css');
		
		wp_register_style('flexslider-css', get_template_directory_uri().'/assets/flexslider.css', '', '', 'screen, all');
		wp_enqueue_style('flexslider-css');
		
		wp_register_style('layout-css', get_template_directory_uri().'/assets/layout.css', '', '', 'screen, all');
		wp_enqueue_style('layout-css');
		
		wp_register_style('custom-css', get_template_directory_uri().'/assets/custom.css', '', '', 'screen, all');
		wp_enqueue_style('custom-css');
		
	}
}
add_action('init', 'dessky_styles');
?>