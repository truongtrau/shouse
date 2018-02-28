<?php
	/* Toggle Shortcode */
	add_shortcode('toggles', 'dessky_toggles');
	add_shortcode('toggle', 'dessky_toggle');
	
	/* -----------------------------------------------------------------
		Toggle
	----------------------------------------------------------------- */
	function dessky_toggle($atts, $content = null) {
		
		extract(shortcode_atts(array(
			'title' => 'Unnamed'
		), $atts));
		
		$output = '
				<h2 class="trigger"><span>'.$title.'</span></h2>
				<div class="toggle_container">
					<div class="block">'.dessky_paragraph_formatter($content).'</div>
				</div>';
			
		return do_shortcode($output);
		
	}
	
	
	/* -----------------------------------------------------------------
		Toggles container
	----------------------------------------------------------------- */
	function dessky_toggles($atts, $content = null) {
		$output = '<div id="toggle">'.dessky_paragraph_formatter($content).'</div>';
		return do_shortcode($output);
		
	}
?>