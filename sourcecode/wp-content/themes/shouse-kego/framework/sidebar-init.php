<?php
function dessky_widgets_init() {
	register_sidebar( array(
		'name' 					=> __( 'Post Sidebar', 'dessky' ),
		'id' 						=> 'post-sidebar',
		'description' 		=> __( 'Located at the left/right side of archives, single and search.', 'dessky' ),
		'before_widget' 	=> '<ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 		=> '</li></ul>',
		'before_title' 		=> '<h2 class="widget-title"><span>',
		'after_title' 			=> '</span></h2>',
	));
	
	register_sidebar(array(
		'name'          		=> __('Page Sidebar', 'dessky' ),
		'id'         				=> 'page-sidebar',
		'description'   		=> __( 'Located at the left/right side of page templates.', 'dessky' ),
		'before_widget' 	=> '<ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 		=> '</li></ul>',
		'before_title' 		=> '<h2 class="widget-title"><span>',
		'after_title' 			=> '</span></h2>',
	));
	
	register_sidebar(array(
		'name'          => __('Footer1 Sidebar', 'dessky' ),
		'id'         	=> 'footer1',
		'description'   => __( 'Located at the footer column 1.', 'dessky' ),
		'before_widget' => '<div class="widget-bottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '</li></ul></div>',
		'before_title' 	=> '<h2 class="widget-title"><span>',
		'after_title' 	=> '</span></h2>',
	));
	
	register_sidebar(array(
		'name'          => __('Footer2 Sidebar', 'dessky' ),
		'id'         	=> 'footer2',
		'description'   => __( 'Located at the footer column 2.', 'dessky' ),
		'before_widget' => '<div class="widget-bottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '</li></ul></div>',
		'before_title' 	=> '<h2 class="widget-title"><span>',
		'after_title' 	=> '</span></h2>',
	));
	
	register_sidebar(array(
		'name'          => __('Footer3 Sidebar', 'dessky' ),
		'id'         	=> 'footer3',
		'description'   => __( 'Located at the footer column 3.', 'dessky' ),
		'before_widget' => '<div class="widget-bottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '</li></ul></div>',
		'before_title' 	=> '<h2 class="widget-title"><span>',
		'after_title' 	=> '</span></h2>',
	));
	
	register_sidebar(array(
		'name'          => __('Footer4 Sidebar', 'dessky' ),
		'id'         	=> 'footer4',
		'description'   => __( 'Located at the footer column 4.', 'dessky' ),
		'before_widget' => '<div class="widget-bottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '</li></ul></div>',
		'before_title' 	=> '<h2 class="widget-title"><span>',
		'after_title' 	=> '</span></h2>',
	));
	
	//Register dynamic sidebar
	$textarrayval = get_option('dessky_sidebar');
	if(is_array($textarrayval)){
		
		foreach($textarrayval as $ids => $val){
			if ( function_exists('register_sidebar') )
			register_sidebar(array(
				'name'          		=> $val,
				'id'					=> $ids,
				'description'   		=> __( 'A Custom sidebar created from Theme Options. It\'s called ', 'dessky' ).$ids,
				'before_widget' 	=> '<ul><li id="%1$s" class="widget-container %2$s">',
				'after_widget' 		=> '</li></ul>',
				'before_title' 		=> '<h2 class="widget-title"><span>',
				'after_title' 			=> '</span></h2>'
			));
		}
		
	}
				
}
/** Register sidebars by running creativedesign_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'dessky_widgets_init' );
?>