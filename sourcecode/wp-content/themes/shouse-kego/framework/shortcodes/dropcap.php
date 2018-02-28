<?php
	/* Dropcap Shortcode */
	add_shortcode( 'dropcap', 'dessky_dropcap' );
	
	/* -----------------------------------------------------------------
		Dropcaps
	----------------------------------------------------------------- */
	function dessky_dropcap($atts, $content = null) {
		extract(shortcode_atts(array(
					"type" => ''
		), $atts));
		$content =dessky_paragraph_formatter($content);
		if($type=="circle"){
			$output = '<span class="dropcap2">'.$content.'</span>';
		}elseif($type=="square"){
			$output = '<span class="dropcap3">'.$content.'</span>';
		}else{
			$output = '<span class="dropcap1">'.$content.'</span>';
		}		
		return do_shortcode($output);
	}

?>