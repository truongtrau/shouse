<?php
	/* Imgframe Shortcode */
	add_shortcode( 'imgframe', 'dessky_imgframe' );
	
	/* -----------------------------------------------------------------
		Imgframe
	----------------------------------------------------------------- */
	function dessky_imgframe($atts) {
		extract(shortcode_atts(array(
					"path" => '',
					"size" =>'',
					"class" => ''
		), $atts));
		
		if($path!=""){
				return '<span class="imgframecontainer '.$size.' '.$class.'"><span class="imgframe"><img src="'.$path.'" alt="" class=""></span></span>';
		}

	}

?>