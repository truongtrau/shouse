<?php
	/* Shortcode */
	add_shortcode('pre', 'dessky_pre');
	
	/* -----------------------------------------------------------------
		Pre
	----------------------------------------------------------------- */
	function dessky_pre($atts, $content) {
	
		$return_html = '<pre>'.strip_tags($content).'</pre>';
		
		return $return_html;
	}

?>