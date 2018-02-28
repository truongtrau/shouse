<?php
	/* Shortcode */
	add_shortcode('separator', 'dessky_separator');
	add_shortcode('clear', 'dessky_clearfloat');
	add_shortcode('clearfix', 'dessky_clearfixfloat');
	
	/* -----------------------------------------------------------------
		Separator
	----------------------------------------------------------------- */
	function dessky_separator($atts, $content = null) {
		extract(shortcode_atts(array(
					"line" => ''
		), $atts));
		$content =dessky_paragraph_formatter($content);
		if($line==""){
		$output = '<div class="separator"><div></div></div>';
		}else{
		$output = '<div class="clear"></div><div class="separator line"><div></div></div>';
		}
		
		return do_shortcode($output);
		
	}
	
	/* -----------------------------------------------------------------
		Clear
	----------------------------------------------------------------- */
	function dessky_clearfloat($atts, $content = null) {
		$content =dessky_paragraph_formatter($content);
		$output = '<div class="clear">&nbsp;</div>';
		return do_shortcode($output);
		
	}
	
	/* -----------------------------------------------------------------
		Clearfix
	----------------------------------------------------------------- */
	function dessky_clearfixfloat($atts, $content = null) {
		$content =dessky_paragraph_formatter($content);
		$output = '<div class="clearfix">&nbsp;</div><br/>';
		return do_shortcode($output);
		
	}
?>