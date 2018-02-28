<?php
	/* Highlight Shortcode */
	add_shortcode( 'highlight', 'dessky_highlight' );
	
	/* -----------------------------------------------------------------
		Highlight
	----------------------------------------------------------------- */
	function dessky_highlight($atts, $content = null) {
		extract(shortcode_atts(array(
					"color" => ''
		), $atts));
		$content =dessky_paragraph_formatter($content);
		if($color=="" || $color=="grey"){
			$output = '<span class="highlight1">'.$content.'</span>';
		}
		if($color=="black"){
			$output = '<span class="highlight2">'.$content.'</span>';
		}	
		return do_shortcode($output);
	}
?>