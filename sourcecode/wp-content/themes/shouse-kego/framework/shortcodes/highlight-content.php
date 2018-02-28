<?php
	/* Shortcode */
	add_shortcode('highlight_content', 'dessky_highlight_content');
	
	/* -----------------------------------------------------------------
		Highlight Content
	----------------------------------------------------------------- */
	function dessky_highlight_content($atts, $content = null) {
		extract(shortcode_atts(array(
		), $atts));
		$content =dessky_paragraph_formatter($content);
		$output = '<div class="highlight-content">'.$content.'</div>';
		return do_shortcode($output);
	}
?>