<?php
$sliderarrange = of_get_option('dessky_slider_arrange');
$sliderDisableText = of_get_option('dessky_slider_disable_text');
?>


<!-- SLIDER -->
<div id="outerslider">
    <div class="container">
        <div id="slidercontainer" class="twelve columns">

            <section id="slider">
                <div id="slideritems" class="flexslider">
                    <ul class="slides">
                    
						<?php
                        query_posts('post_type=slider-view&post_status=publish&showposts=-1&order=' . $sliderarrange);
                        while ( have_posts() ) : the_post();
                        
                        $custom = get_post_custom($post->ID);
                        $cf_slideurl = (isset($custom["slider-url"][0]))?$custom["slider-url"][0] : "";
                        $cf_thumb = (isset($custom["slider-image"][0]))? $custom["slider-image"][0] : "";
                        
                        $output="";
                        $output .='<li>';
                        
                            if($cf_slideurl!=""){
                                $output .= '<a href="'.$cf_slideurl.'">';
                            }
                           
                            //slider images
                            if(has_post_thumbnail( get_the_ID()) || $cf_thumb!=""){
                                if($cf_thumb!=""){
                                    $output .= '<img src="'.$cf_thumb.'" alt="'.get_the_title().'" />';
                                }else{
                                    $output .= get_the_post_thumbnail($post->ID,'post-slider');
                                }
                            }
                                
                            if($cf_slideurl!=""){
                                $output .= '</a>';
                            }
                            
                           //slider text
                           if($sliderDisableText!=true){
                               $output .='<div class="flex-caption">';
                               
								   $output .='<h1>'.get_the_title().'</h1>';
								   $output .='<p>'.get_the_excerpt().'</p>';
								   if($cf_slideurl!=""){
										$output .='<a href="'.$cf_slideurl.'" class="button">'.__('Read the Detail', 'dessky' ).'</a>';
								   }
								   
                               $output .='</div>';
                           }
                            
                        $output .='</li>';
                        
                        echo $output;
                        
                        endwhile;
                        wp_reset_query();
                        ?>
                        
                    </ul>
                </div>
                
<!--
	Flexslider navigation
-->

<ul class="flex-direction-nav"><li><a href="#" class="flex-prev">Previous</a></li><li><a href="#" class="flex-next">Next</a></li></ul>           
<!--
	/Flexslider navigation
-->                
                
          	</section>
            
        </div>
    </div>
</div>
<!-- END SLIDER -->

