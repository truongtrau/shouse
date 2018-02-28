<?php
/**
 * Template Name: Homepage with Slider
 *
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage WooShop
 * @since WooShop 1.0
 */

get_header(); ?>

		<?php $sidebarposition = of_get_option('dessky_sidebar_position' ,'right'); ?>
        
        <?php get_template_part('slidercode'); ?>
        
        <!-- MAIN CONTENT -->
        <div id="outermain">
        	<div class="container">
		
		
                <section id="maincontent" class="twelve columns">
                
                <?php 
				
				// Check - Is this home page, to add slider for Home or Title for the other pages...
				
				$disableSlider = of_get_option('dessky_disable_slider' ,'false');
				$hasslider = false;
				if($disableSlider==true){$class="noslider";}else{$class="";}

		      	?>          
                
                        <div class="padcontent">
                        
							<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <div class="entry-content">
                                    <?php the_content( __( 'Read More', 'dessky' ) ); ?>
                                    <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'dessky' ), 'after' => '</div>' ) ); ?>
                                    <?php edit_post_link( __( 'Edit', 'dessky' ), '<span class="edit-link">', '</span>' ); ?>
                                </div><!-- .entry-content -->
                            </div><!-- #post -->
                    
                            <?php endwhile; ?>
			    
                            <div class="clear"></div><!-- clear float --> 
                        </div><!-- main -->
                    
                </section><!-- maincontent -->
            </div>	
        </div>
        <!-- END MAIN CONTENT -->
        
<?php get_footer(); ?>
