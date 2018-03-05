<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query. 
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
                <div class="row">
                <section id="maincontent" class="col-xs-12 col-sm-6 col-md-9">
                
                    <section id="content" class="col-md-9 <?php if($sidebarposition=="left"){echo "positionright omega";}else{echo "positionleft alpha";}?>">
                        <div class="padcontent">
							<?php
                            /* Run the loop to output the posts.
                            * If you want to overload this in a child theme then include a file
                            * called loop-index.php and that will be used instead.
                            */
                            get_template_part( 'loop', 'index' );
                            ?>
                    	<div class="clear"></div><!-- clear float --> 
                        </div><!-- main -->
                    </section><!-- content -->
                    
                    <aside id="sidebar" class="col-md-3 <?php if($sidebarposition=="left"){echo "positionleft alpha";}else{echo "positionright omega";}?>">
                        <?php get_sidebar();?>
                    </aside><!-- sidebar -->
                    
                </section><!-- maincontent -->

            </div>
        </div>
    </div>
        <!-- END MAIN CONTENT -->
<?php get_footer(); ?>