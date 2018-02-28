<?php

/*********For Localization**************/
load_theme_textdomain( 'dessky', get_template_directory().'/framework/languages' );

$locale = get_locale();
$locale_file = get_template_directory()."/framework/languages/$locale.php";
if ( is_readable($locale_file) )
    require_once($locale_file);
/*********End For Localization**************/


// The excerpt based on character
if(!function_exists("dessky_string_limit_char")){
	function dessky_string_limit_char($excerpt, $substr=0, $strmore = "..."){
		$string = strip_tags(str_replace('...', '...', $excerpt));
		if ($substr>0) {
			$string = substr($string, 0, $substr);
		}
		if(strlen($excerpt)>=$substr){
			$string .= $strmore;
		}
		return $string;
	}
}
// The excerpt based on words
if(!function_exists("dessky_string_limit_words")){
	function dessky_string_limit_words($string, $word_limit){
	  $words = explode(' ', $string, ($word_limit + 1));
	  if(count($words) > $word_limit)
	  array_pop($words);
	  
	  return implode(' ', $words);
	}
}

if ( ! isset( $content_width ) )
	$content_width = 610;

add_action( 'after_setup_theme', 'dessky_setup' );


/* Remove inline styles printed when the gallery shortcode is used.*/
function dessky_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'dessky_remove_gallery_css' );

/*Template for comments and pingbacks. */
if ( ! function_exists( 'dessky_comment' ) ) :
function dessky_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="con-comment">
		<div class="comment-author vcard">
			<?php //echo get_avatar( $comment, 60, 60 ); ?>
			<img class="avatar avatar-60 photo" width="60" height="60" src="http://0.gravatar.com/avatar/21ecbc5fb334068eae24691ddd6261d9?s=60&d=http%3A%2F%2F0.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D60&r=G&forcedefault=1" alt="">
		</div><!-- .comment-author .vcard -->


		<div class="comment-body">
			<?php  printf( __( '%s ', 'dessky' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
            <span class="time">
            <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
            <?php
                /* translators: 1: date, 2: time */
                printf( __( '%1$s %2$s', 'dessky' ), get_comment_date(),  get_comment_time() ); ?></a>
                <?php edit_comment_link( __( '(Edit)', 'dessky' ), ' ' );?>
            </span>/
            <span class="reply"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ,'reply_text' => 'Reply') ) ); ?></span>
			<div class="commenttext">
			<?php comment_text(); ?>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php _e( 'Your comment is awaiting moderation.', 'dessky' ); ?></em>
			<?php endif; ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'dessky' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'dessky'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;


/* social icon */
if (!function_exists('dessky_socialicon')){
	function dessky_socialicon(){
		
		$socialfolder = get_template_directory_uri() . '/assets/images/social/';

		$outputli = "";
		$twitterlink = of_get_option( DESSKY_SHORTNAME . '_twitter_link', "" );
		if($twitterlink!=""){
			$twittericon = $socialfolder . "icon-twitter.png" ;
			$outputli .= '<li><a href="'.$twitterlink.'"><span class="icon-img" style="background-image:url('.$twittericon.')"></span></a></li>'."\n";
		}
		
		$facebooklink = of_get_option( DESSKY_SHORTNAME . '_facebook_link', "" );
		if($facebooklink!=""){
			$facebookicon = $socialfolder . "icon-facebook.png" ;
			$outputli .= '<li><a href="'.$facebooklink.'"><span class="icon-img" style="background-image:url('.$facebookicon.')"></span></a></li>'."\n";
		}
		
		$gpluslink = of_get_option( DESSKY_SHORTNAME . '_googleplus_link', "" );
		if($gpluslink!=""){
			$gplusicon = $socialfolder . "icon-googleplus.png" ;
			$outputli .= '<li><a href="'.$gpluslink.'"><span class="icon-img" style="background-image:url('.$gplusicon.')"></span></a></li>'."\n";
		}
		
		$pinterestlink = of_get_option( DESSKY_SHORTNAME . '_pinterest_link', "" );
		if($pinterestlink!=""){
			$pinteresticon = $socialfolder . "icon-pinterest.png" ;
			$outputli .= '<li><a href="'.$pinterestlink.'"><span class="icon-img" style="background-image:url('.$pinteresticon.')"></span></a></li>'."\n";
		}
		
		$socialcustom = of_get_option( DESSKY_SHORTNAME . '_socialicon_custom', "" );
		if($socialcustom!=""){
			$outputli .= $socialcustom."\n";
		}
		
		$output = "";
		if($outputli!=""){
			$output .= '<ul class="sn">';
			$output .= $outputli;
			$output .= '</ul>';
		}
		return $output;
	}
}//end if(!function_exists('dessky_get_socialicon'))

/*Prints HTML with meta information for the current post (category, tags and permalink).*/
if ( ! function_exists( 'dessky_posted_in' ) ) :
function dessky_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'Categories: %1$s <br/> Tags: %2$s', 'dessky' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'Categories: %1$s', 'dessky' );
	} else {
		$posted_in = __( '', 'dessky' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

/*Clearing the automatic paragraphs and breaks on shortcodes that WordPress is adding automatically when filtering content.*/
function dessky_paragraph_formatter($content) { 
	$content = do_shortcode(shortcode_unautop($content)); 
	$content = preg_replace('#^<\/p>|^<br \/>|<p>$#', '', $content);
	$content = str_replace('<br />', '', $content);
	$content = str_replace('<p><div', '<div', $content);
	return $content;
}

/* for top menu */
function nav_page_fallback() {
if(is_front_page()){$class="current_page_item";}else{$class="";}
print '<ul id="topnav" class="sf-menu"><li class="'.$class.'"><a href=" '.home_url( '/') .' " title=" '.__('Click for Home','dessky').' ">'.__('Home','dessky').'</a></li>';
    wp_list_pages( 'title_li=&sort_column=menu_order' );
print '</ul>';
}

/* for user menu */
function nav_user_fallback() {
if(is_front_page()){$class="current_page_item";}else{$class="";}
print '<ul id="user-nav" class="sf-menu"><li class="'.$class.'"><a href=" '.home_url( '/') .' " title=" '.__('Click for Home','dessky').' ">'.__('Home','dessky').'</a></li>';
    wp_list_pages( 'title_li=&sort_column=menu_order' );
print '</ul>';
}



/* Filter Custom Post Type Categories */
add_action( 'restrict_manage_posts', 'dessky_add_taxonomy_filters' );
function dessky_add_taxonomy_filters() {
	global $typenow;
	
	$taxonomy = 'pcategory';
	if( $typenow=='pdetail'){
		$filters = array($taxonomy);
		foreach ($filters as $tax_slug) {
			$tax_obj = get_taxonomy($tax_slug);
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
			echo "<option value=''>".__('View All','dessky')." "."$tax_name</option>";
			foreach ($terms as $term) { 
				$selectedstr = '';
				if(isset($_GET[$tax_slug]) && $_GET[$tax_slug] == $term->slug){
					$selectedstr = ' selected="selected"';
				}
				echo '<option value='. $term->slug. $selectedstr . '>' . $term->name .' (' . $term->count .')</option>'; 
			}
			echo "</select>";
		}
	}
}

/* for lighter  color button  */
function hex_lighter($hex,$factor = 30) 
    { 
    $new_hex = ''; 
     
    $base['R'] = hexdec($hex{0}.$hex{1}); 
    $base['G'] = hexdec($hex{2}.$hex{3}); 
    $base['B'] = hexdec($hex{4}.$hex{5}); 
     
    foreach ($base as $k => $v) 
        { 
        $amount = 255 - $v; 
        $amount = $amount / 100; 
        $amount = round($amount * $factor); 
        $new_decimal = $v + $amount; 
     
        $new_hex_component = dechex($new_decimal); 
        if(strlen($new_hex_component) < 2) 
            { $new_hex_component = "0".$new_hex_component; } 
        $new_hex .= $new_hex_component; 
        } 
         
    return $new_hex;     
} 


/* for shortcode widget  */
add_filter('widget_text', 'do_shortcode');

/*
	Remove WooCommerce Warning
*/
add_theme_support('woocommerce');

/*
	Adding Logout Link
*/

add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );
function add_loginout_link( $items, $args ) {
    if (is_user_logged_in() && $args->theme_location == 'topmenu') {
        $items .= '<li><a href="'. wp_logout_url( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) ) .'">Log Out</a></li>';
    }
    elseif (!is_user_logged_in() && $args->theme_location == 'topmenu') {
        $items .= '<li><a href="' . get_permalink( woocommerce_get_page_id( 'myaccount' ) ) . '">Log In</a></li>';
    }
    return $items;
}

/*
	WooShop Paid Version Notice
*/

add_action('admin_notices', 'wooshop_paid_admin_notice');

function wooshop_paid_admin_notice() {
	global $current_user ;
        $user_id = $current_user->ID;
        /* Check that the user hasn't already clicked to ignore the message */
	if ( ! get_user_meta($user_id, 'wooshop_paid_ignore_notice') ) {
        echo '<div class="updated"><p>'; 
        printf(__('If You like this theme You\'re gonna love WooShop Paid version. <strong>It comes with the Sidebar, Portfolio and Testimonials Manager!</strong>  Best of all, it is <strong>only $19</strong>. <a href="http://dessky.com/themes/wooshop-responsive-woocommerce-wordpress-theme/" target="blank"><strong>Click here to learn more.</strong></a> | <a href="%1$s">Hide Notice</a>'), '?wooshop_paid_nag_ignore=0');
        echo "</p></div>";
	}
}

add_action('admin_init', 'wooshop_paid_nag_ignore');

function wooshop_paid_nag_ignore() {
	global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['wooshop_paid_nag_ignore']) && '0' == $_GET['wooshop_paid_nag_ignore'] ) {
             add_user_meta($user_id, 'wooshop_paid_ignore_notice', 'true', true);
	}
}

?>