<?php
function dessky_script() {
	if (!is_admin()) {
		
		wp_enqueue_script('jquery');
		
		//wp_register_script('jUI', get_template_directory_uri().'/assets/js/jquery-1.8.2.js', array('jquery'), '1.8', true);
		wp_register_script('jUI', '//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js', array('jquery'), '1.8', true);
		wp_enqueue_script('jUI');
		
		wp_register_script('jprettyPhoto', get_template_directory_uri().'/assets/js/jquery.prettyPhoto.js', array('jquery'), '3.0', true);
		wp_enqueue_script('jprettyPhoto');
		
		wp_register_script('jhoverIntent', get_template_directory_uri().'/assets/js/hoverIntent.js', array('jquery'), '1.0', true);
		wp_enqueue_script('jhoverIntent');
		
		wp_register_script('jsuperfish', get_template_directory_uri().'/assets/js/superfish.js', array('jquery'), '1.4.8', true);
		wp_enqueue_script('jsuperfish');
		
		wp_register_script('jsupersubs', get_template_directory_uri().'/assets/js/supersubs.js', array('jquery'), '0.2', true);
		wp_enqueue_script('jsupersubs');
		
		wp_register_script('jflexslider', get_template_directory_uri().'/assets/js/jquery.flexslider-min.js', array('jquery'), '1.8', true);
		wp_enqueue_script('jflexslider');
		
		wp_register_script('jtweet', get_template_directory_uri().'/assets/js/jquery.tweet.js', array('jquery'), '1.0.0', true);
		wp_enqueue_script('jtweet');
		
		wp_register_script('tinynav', get_template_directory_uri().'/assets/js/tinynav.min.js', array('jquery'), '1.0.3', true);
		wp_enqueue_script('tinynav');
		
		wp_register_script('jeasing', get_template_directory_uri().'/assets/js/jquery.easing.1.3.js', array('jquery'), '1.3', true);
		wp_enqueue_script('jeasing');
		
		wp_register_script('jfunctions', get_template_directory_uri().'/assets/js/functions.min.js', array('jquery'), '1.0', true);
		wp_enqueue_script('jfunctions');
		
	}
}
add_action('init', 'dessky_script');
?>