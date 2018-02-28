<?php 
	/* Columns Shortcode */
	add_shortcode('one_half', 'dessky_one_half');
	add_shortcode('one_third', 'dessky_one_third');
	add_shortcode('one_fourth', 'dessky_one_fourth');
	add_shortcode('one_fifth', 'dessky_one_fifth');
	add_shortcode('one_sixth', 'dessky_one_sixth');
	
	add_shortcode('two_third', 'dessky_two_third');
	add_shortcode('two_fourth', 'dessky_two_fourth');
	add_shortcode('two_fifth', 'dessky_two_fifth');
	add_shortcode('two_sixth', 'dessky_two_sixth');
	
	
	add_shortcode('three_fourth', 'dessky_three_fourth');
	add_shortcode('three_fifth', 'dessky_three_fifth');
	add_shortcode('three_sixth', 'dessky_three_sixth');
	
	add_shortcode('four_fifth', 'dessky_four_fifth');
	add_shortcode('four_sixth', 'dessky_four_sixth');
	
	add_shortcode('five_sixth', 'dessky_five_sixth');
	
	
	
	/* -----------------------------------------------------------------
		Columns shortcodes
	----------------------------------------------------------------- */
	function dessky_one_half($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		$content = dessky_paragraph_formatter($content);
		
		$content = ($content);
		$output = '<div class="one_half '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	

	function dessky_one_third($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		$content = dessky_paragraph_formatter($content);
		
		$content = ($content);
		$output = '<div class="one_third '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	
	function dessky_one_fourth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		$content = dessky_paragraph_formatter($content);
		
		$content = ($content);
		$output = '<div class="one_fourth '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	
	function dessky_one_fifth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		$content = dessky_paragraph_formatter($content);
		
		$content = ($content);
		$output = '<div class="one_fifth '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	function dessky_one_sixth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		$content = dessky_paragraph_formatter($content);
		
		$content = ($content);
		$output = '<div class="one_sixth '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	function dessky_two_third($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		$content = dessky_paragraph_formatter($content);
		
		$content = ($content);
		$output = '<div class="two_third '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	function dessky_two_fourth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		$content = dessky_paragraph_formatter($content);
		
		$content = ($content);
		$output = '<div class="two_fourth '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	function dessky_two_fifth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		$content = dessky_paragraph_formatter($content);
		
		$content = ($content);
		$output = '<div class="two_fifth '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	function dessky_two_sixth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		$content = dessky_paragraph_formatter($content);
		
		$content = ($content);
		$output = '<div class="two_sixth '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	function dessky_three_fourth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		$content = dessky_paragraph_formatter($content);
		
		$content = ($content);
		$output = '<div class="three_fourth '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	function dessky_three_fifth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		$content = dessky_paragraph_formatter($content);
		
		$content = ($content);
		$output = '<div class="three_fifth '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	function dessky_three_sixth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		$content = dessky_paragraph_formatter($content);
		
		$content = ($content);
		$output = '<div class="three_sixth '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	function dessky_four_fifth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		$content = dessky_paragraph_formatter($content);
		
		$content = ($content);
		$output = '<div class="four_fifth '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	
	function dessky_four_sixth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		$content = dessky_paragraph_formatter($content);
		
		$content = ($content);
		$output = '<div class="four_sixth '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	function dessky_five_sixth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		$content = dessky_paragraph_formatter($content);
		
		$content = ($content);
		$output = '<div class="five_sixth '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
?>