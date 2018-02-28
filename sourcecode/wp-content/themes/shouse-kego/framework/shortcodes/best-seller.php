<?php
	/* Best Seller Shortcode */
	add_shortcode( 'best_seller', 'dessky_best_seller' );
	
	/* -----------------------------------------------------------------
		Best Seller
	----------------------------------------------------------------- */
	function dessky_best_seller($atts, $content = null) {
		global $woocommerce;
		
		extract(shortcode_atts(array(
					'title' => 'Best Seller',
					'orderby' => 'date',
					'order' => 'desc',
					'showposts' => 10
		), $atts));
		$content = dessky_paragraph_formatter($content);
		
		$query_args = array(
    		'posts_per_page' => $showposts, 
    		'post_status' 	 => 'publish', 
    		'post_type' 	 => 'product',
    		'meta_key' 		 => 'total_sales',
    		'orderby' 		 => 'meta_value',
    		'no_found_rows'  => 1,
    	);
    	
    	$query_args['meta_query'] = array();
    	
		$query_args['meta_query'][] = array(
			'key'     => '_price',
			'value'   => 0,
			'compare' => '>',
			'type'    => 'DECIMAL',
		);

	    $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
	    $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
		
		$products = new WP_Query( $query_args );
		
		
		$output = '<section class="maincarousel">';
			$output .= '<h3>'. $title .'</h3>';
			
			if($content){
				$output .= '<p>'. $content .'</p>';
			}
			
			$output .= '<br /><br />';
			
			$output .= '<div class="flexslider-carousel">';
			
			if ( $products->have_posts() ) :
			
				$output .= '<ul class="slides">';
					while ( $products->have_posts() ) : $products->the_post();
					
						global $product;
						$output .= '<li>';
							$output .= '<a href="'. get_permalink( get_the_ID() ).'">';
							
								if ( has_post_thumbnail() )
									$output .= get_the_post_thumbnail( get_the_ID() , 'full', array('class' => 'scale-with-grid') ); 
								else 
									$output .= '<img src="'. woocommerce_placeholder_img_src() .'" alt="'. get_the_title( get_the_ID() ) .'" class="scale-with-grid" />';
								
							$output .= '</a>';
							$output .= '<h2><a href="'. get_permalink( get_the_ID() ).'">'. get_the_title( get_the_ID() ) .'</a></h2>';
							if ($price_html = $product->get_price_html()) : 
								$output .= '<div class="price">'. $price_html .'</div>';
                            endif;

						$output .= '</li>';
					
					endwhile;
				$output .= '</ul>';
			
			endif; 
			wp_reset_query();
			
			$output .= '</div>';
		$output .= '</section>';
		
		return $output;
	}
?>