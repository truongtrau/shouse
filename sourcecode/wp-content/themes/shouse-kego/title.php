
<?php
//custom meta field
$custom = get_post_custom(get_the_ID());
$cf_pagetitle = (isset($custom["page-title"][0]))? $custom["page-title"][0] : "";
?>

<?php 
if(is_singular('pdetail') || is_attachment()){

	$titleoutput='<h1 class="pagetitle"><span>'.get_the_title().'</span></h1>';
	echo $titleoutput;
	
}elseif ( is_tax() ){ 
	echo ' <h1 class="pagetitle"><span>';
	echo single_term_title( "", false );
	echo '</span> </h1>';
}elseif(is_archive()){ 
	echo ' <h1 class="pagetitle"><span>';
	if ( is_day() ) :
	printf( __( 'Daily Archives <span>%s</span>', 'dessky' ), get_the_date() );
	elseif ( is_month() ) :
	printf( __( 'Monthly Archives <span>%s</span>', 'dessky' ), get_the_date('F Y') );
	elseif ( is_year() ) :
	printf( __( 'Yearly Archives <span>%s</span>', 'dessky' ), get_the_date('Y') );
	elseif ( is_author()) :
	printf( __( 'Author Archives %s', 'dessky' ), "<a class='url fn n' href='" . get_author_posts_url( get_the_author_meta( 'ID' ) ) . "' title='" . esc_attr( get_the_author() ) . "' rel='me'>" . get_the_author() . "</a>" );
	elseif( is_woocommerce() ) :
	$shop_page = get_post( woocommerce_get_page_id( 'shop' ) );
    echo apply_filters( 'the_title', ( $shop_page_title = get_option( 'woocommerce_shop_page_title' ) ) ? $shop_page_title : $shop_page->post_title );
	else :
	printf( __( '%s', 'dessky' ), '<span>' . single_cat_title( '', false ) . '</span>' );
	endif;
	echo '</span> </h1>';
	
}elseif(is_search()){
	echo ' <h1 class="pagetitle"><span>';
	printf( __( 'Search Results for %s', 'dessky' ), '<span>' . get_search_query() . '</span>' );
	echo '</span> </h1>';
	
}elseif(is_404()){
	echo ' <h1 class="pagetitle"><span>';
	_e( '404 Page', 'dessky' );
	echo '</span> </h1>';
	
}elseif(is_home()){
	$theblogid = get_option('page_for_posts');
	$theblogtitle = get_the_title($theblogid);
	echo ' <h1 class="pagetitle"><span>';
	echo ($theblogid)? $theblogtitle : __( 'Blog', 'dessky' );
	echo '</span> </h1>';
	
}else{

 if (have_posts()) : while (have_posts()) : the_post();
		$titleoutput='';
		if($cf_pagetitle == ""){
			$titleoutput.='<h1 class="pagetitle"><span>'.get_the_title().'</span></h1>';
		}else{
			$titleoutput.='<h1 class="pagetitle"><span>'.$cf_pagetitle.'</span></h1>';
		}
		
		echo $titleoutput;
endwhile; endif; wp_reset_query();

}

?>