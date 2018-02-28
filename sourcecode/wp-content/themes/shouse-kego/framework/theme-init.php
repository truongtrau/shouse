<?php

add_action( 'after_setup_theme', 'dessky_setup' );

if ( ! function_exists( 'dessky_setup' ) ):

function dessky_setup() {

	// This theme styles the visual editor with assets/editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'post-slider', 960, 450, true ); // Slider
		add_image_size( 'post-blog', 690, 227, true ); // Blog Image
		add_image_size( 'post-thumb-small', 58, 58, true ); // Recent Post Widget Image
		add_image_size( 'post-col4', 420, 214, true );
		add_image_size( 'home-thumb-small', 110, 110, true );
	}

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'mainmenu' => __( 'Main Menu', 'dessky' )

	) );
	
	register_nav_menus( array(
		'topmenu' => __( 'Top Menu', 'dessky' )

	) );
	
}
endif;
if (function_exists('register_sidebar')){
	
	register_sidebar(array(
		'name'=> 'ShareThis Box',
		'id' => 'add-this-button',
		'before_widget' => '<div class="shareThis">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	));
}
/* Slider */
function dessky_post_type_slider() {
	register_post_type( 'slider-view',
                array( 
				'label' => __('Slider', 'dessky'), 
				'public' => true, 
				'show_ui' => true,
				'show_in_nav_menus' => false,
				'rewrite' => true,
				'hierarchical' => true,
				'menu_position' => 5,
				'exclude_from_search' =>true,
				'supports' => array(
				                     'title',
									 'custom-fields',
                                     'thumbnail',
									 'excerpt')
					) 
				);
}

add_action('init', 'dessky_post_type_slider');

add_post_type_support( 'page', 'excerpt' ); // Enable excerpts for pages.

?>
