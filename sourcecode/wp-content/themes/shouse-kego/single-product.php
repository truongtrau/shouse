<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @package WooCommerce
 * @since WooCommerce 1.0
 */

get_header('shop'); ?>

	<?php $sidebarposition = of_get_option('dessky_sidebar_position' ,'right'); ?>
        
    <!-- MAIN CONTENT -->
    <div id="outermain">
        <div class="container">
            <section id="maincontent" class="twelve columns">
            
             <!-- BEFORE CONTENT -->
                <div id="outerbeforecontent" class="nopagebar">
                    <div class="container">
                        <section id="beforecontent" class="twelve columns">
                            <?php  get_template_part( 'title');  ?>
                            <?php dynamic_sidebar('add-this-button'); ?>
                            <div class="clear"></div>
                        </section>
                    </div>
                </div>
                <!-- END BEFORE CONTENT -->
                
                <section id="content" class="nine columns <?php if($sidebarposition=="left"){echo "positionright omega";}else{echo "positionleft alpha";}?>">
                    <div class="padcontent product-detail">

						<?php 
                            /** 
                             * woocommerce_before_main_content hook
                             *
                             * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                             * @hooked woocommerce_breadcrumb - 20
                             */
							remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper');	
							remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);		 
                            do_action('woocommerce_before_main_content');
                        ?>
                    
                            <?php while ( have_posts() ) : the_post(); ?>
                    
                                <?php woocommerce_get_template_part( 'content', 'single-product' ); ?>
                    
                            <?php endwhile; // end of the loop. ?>
							<?php
                                /** 
                                 * woocommerce_after_main_content hook
                                 *
                                 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                                 */	 
								remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end');	
                                do_action('woocommerce_after_main_content'); 
                            ?>
    						<div class="clear"></div><!-- clear float --> 
                        </div><!-- main -->
                    </section><!-- content -->
                    
                    <aside id="sidebar" class="three columns <?php if($sidebarposition=="left"){echo "positionleft alpha";}else{echo "positionright omega";}?>">
                      <?php 
							/** 
							 * woocommerce_sidebar hook
							 *
							 * @hooked woocommerce_get_sidebar - 10
							 */		
							do_action('woocommerce_sidebar'); 
						?>
                    </aside><!-- sidebar -->
                    
                </section><!-- maincontent -->
            </div>
        </div>
        <!-- END MAIN CONTENT -->
	
<?php get_footer('shop'); ?>