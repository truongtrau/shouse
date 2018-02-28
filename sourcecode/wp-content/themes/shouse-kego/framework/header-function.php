<?php 
// get website title
if(!function_exists("dessky_document_title")){
	function dessky_document_title(){
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global $page, $paged;
	
		wp_title( '|', true, 'right' );
	
		// Add the blog name.
		bloginfo( 'name' );
	
		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";
	
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'dessky' ), max( $paged, $page ) );
	}// end dessky_get_title()
}

// head action hook
if(!function_exists("dessky_head")){
	function dessky_head(){
		do_action("dessky_head");
	}
	add_action('wp_head', 'dessky_head', 20);
}

// get style
if(!function_exists("dessky_print_stylesheet")){
	function dessky_print_stylesheet(){
		
	//Get Option Background Style
	$optBodyBG = of_get_option('dessky_body_background');
	$optBodyBGColor = $optBodyBG['color'];
	$optBodyBGImage = $optBodyBG['image'];
	$optBodyBGPosition = $optBodyBG['position'];
	$optBodyBGStyle = $optBodyBG['repeat'];
	$optBodyBGattachment = $optBodyBG['attachment'];

		
?>

	<style type="text/css" media="screen">	
	/* Body */
	body{
		<?php if($optBodyBGImage!="" || $optBodyBGColor!=""){?>
		background-color:<?php echo $optBodyBGColor ; ?>;
		background-image:url(<?php echo $optBodyBGImage ; ?>);
		background-repeat:<?php echo $optBodyBGStyle ; ?>;
		background-position: <?php echo $optBodyBGPosition; ?>;
		background-attachment: <?php echo $optBodyBGattachment ; ?>;
		<?php } ?>
	}
    </style>

<?php
		
	}// end function dessky_print_stylesheet
	add_action("dessky_head","dessky_print_stylesheet",7);
}


// print the logo html
if(!function_exists("dessky_logo")){
	function dessky_logo(){ 
	
		$logotype = of_get_option('dessky_logo_type');
		$logoimage = of_get_option('dessky_logo_image'); 
		$sitename =  of_get_option('dessky_site_name');
		$tagline = of_get_option('dessky_tagline');
		if($logoimage == ""){ $logoimage = get_stylesheet_directory_uri() . "/assets/images/logolite.png"; }
?>
		<?php if($logotype == 'textlogo'){ ?>
			
			<?php if($sitename=="" && $tagline==""){?>
                <h1><a href="<?php echo home_url( '/'); ?>" title="<?php _e('Click for Home','dessky'); ?>"><?php bloginfo('name'); ?></a></h1><span class="desc"><?php bloginfo('description'); ?></span>
            <?php }else{ ?>
                <h1><a href="<?php echo home_url( '/'); ?>" title="<?php _e('Click for Home','dessky'); ?>"><?php echo $sitename; ?></a></h1><span class="desc"><?php echo $tagline; ?></span>
            <?php }?>
        
        <?php } else { ?>
        	
            <div id="logoimg">
            <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'dessky' ) ); ?>" >
                <img src="<?php echo $logoimage;?>" alt="" />
            </a>
            </div>
            
		<?php } ?>
        
<?php 
	}
}
?>