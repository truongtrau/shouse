<?php
	/* Pullquote &amp; Blockquote */
	add_shortcode( 'pullquote', 'dessky_pullquote' );
	add_shortcode( 'blockquote', 'dessky_blockquote' );
	
	/* -----------------------------------------------------------------
		Pullquote
	----------------------------------------------------------------- */
	function dessky_pullquote($atts, $content = null) {
		extract(shortcode_atts(array(
					"position" => 'left'
		), $atts));
		
		$content =dessky_paragraph_formatter($content);
		
			$output = '<span class="pullquote-'.$position.'">'.$content.'</span>';
			
		return do_shortcode($output);
	}
	
	
 	/* -----------------------------------------------------------------
		Blockquote
	----------------------------------------------------------------- */
	function dessky_blockquote($atts, $content = null) {
		$content =dessky_paragraph_formatter($content);
		$output = '<blockquote>'.$content.'</blockquote>';
		return do_shortcode($output);
	}

?>