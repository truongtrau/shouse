<?php
	/* Featured Product Shortcode */
	add_shortcode( 'recent_featured_product', 'dessky_recent_featured_product' );
	
	/* -----------------------------------------------------------------
		Featured Product
	----------------------------------------------------------------- */
	function dessky_recent_featured_product($atts, $content = null) {
		extract(shortcode_atts(array(
					'title' => 'Recent Featured Products',
					'orderby' => 'date',
					'order' => 'desc'
		), $atts));
		$content =dessky_paragraph_formatter($content);
		
		$args = array(
			'post_type'	=> 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' => 1,
			'orderby' => $orderby,
			'order' => $order,
			'meta_query' => array(
				array(
					'key' => '_visibility',
					'value' => array('catalog', 'visible'),
					'compare' => 'IN'
				),
				array(
					'key' => '_featured',
					'value' => 'yes'
				)
			)
		);
		
		$products = new WP_Query( $args );
		
		
		$output = '<section class="maincarousel">';
			$output .= '<h2>'. $title .'</h2>';
			
			if($content){
				$output .= '<h5>'. $content .'</h5>';
			}
			
			$output .= '<br /><br />';
			
			$output .= '<div class="flexslider-carousel">';
			
			if ( $products->have_posts() ) :
			
				$output .= '<ul class="slides" id="featured_product_sidebar">';
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