<?php
/**
 * Template Name: Blog
 *
 * A custom page template for blog page.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage WooShop
 * @since WooShop 1.0
 */

get_header(); ?>


		<?php $sidebarposition = of_get_option('dessky_sidebar_position' ,'right'); ?>
    
        <!-- MAIN CONTENT -->
        <div id="outermain">
        	<div class="container">
                <section id="maincontent" class="twelve columns">
                
                    <section id="content" class="nine columns <?php if($sidebarposition=="left"){echo "positionright omega";}else{echo "positionleft alpha";}?>">
                        
						<div class="padcontent">
                       
						<?php 
							$cat = of_get_option('dessky_blog_category' ,'blog');
                            global $more;	$more = 0; $post;
							$args = array(
								'post_type' => 'post',
								'paged' => $paged
								);
							if($cat!="allcategories"){
								$args['cat'] =  $cat;
							}
							
                            query_posts($args); 
                            /* Since we called the_post() above, we need to
                            * rewind the loop back to the beginning that way
                            * we can run the loop properly, in full.
                            */
                            rewind_posts();
                            /* Run the loop for the archives page to output the posts.
                            * If you want to overload this in a child theme then include a file
                            * called loop-archives.php and that will be used instead.
                            */
                            get_template_part( 'loop', 'archive' );
                            
                            wp_reset_query();
                        ?>
                        <div class="clear"></div><!-- clear float --> 
                        </div><!-- main -->
                    </section><!-- content -->
                    
                    <aside id="sidebar" class="three columns <?php if($sidebarposition=="left"){echo "positionleft alpha";}else{echo "positionright omega";}?>">
                        <?php get_sidebar();?>  
                    </aside><!-- sidebar -->
                    
                </section><!-- maincontent -->
            </div>
        </div>
        <!-- END MAIN CONTENT -->
        
<?php get_footer(); ?>