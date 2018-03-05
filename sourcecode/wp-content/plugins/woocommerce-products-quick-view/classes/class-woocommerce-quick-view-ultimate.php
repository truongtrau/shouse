<?php
/**
 * WC_Quick_View_Ultimate Class
 *
 * Table Of Contents
 *
 * WC_Quick_View_Ultimate()
 * init()
 * fix_responsi_theme()
 * fix_style_js_responsi_theme()
 * add_quick_view_ultimate_under_image_each_products()
 * add_quick_view_ultimate_hover_each_products()
 * quick_view_ultimate_wp_enqueue_script()
 * quick_view_ultimate_wp_enqueue_style()
 * quick_view_ultimate_popup()
 * quick_view_ultimate_reload_cart()
 * a3_wp_admin()
 * plugin_extension()
 * plugin_extra_links()
 */
class WC_Quick_View_Ultimate
{
	public function __construct() {
		$this->init();
	}
	
	public function init () {
		add_action( 'wp', array( $this, 'set_customer_cookie' ) );

		//Fix Responsi Theme
		add_action( 'woocommerce_before_shop_loop_item', array( $this, 'fix_responsi_theme'), 42 );
		
		//Add Quick View Hover Each Products
		//add_action( 'woocommerce_after_shop_loop_item', array( $this, 'add_quick_view_ultimate_hover_each_products'), 10 );
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'add_quick_view_ultimate_hover_each_products'), 11 );
		
		//Add Quick View Under Image Each Products
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'add_quick_view_ultimate_under_image_each_products'), 11 );
		
		//Enqueue Script
		add_action( 'wp_enqueue_scripts', array ( $this, 'frontend_register_scripts'), 11 );
		add_action( 'woocommerce_after_shop_loop', array( $this, 'quick_view_ultimate_wp_enqueue_style'), 13 );
		add_action( 'wp_head', array( $this, 'fix_style_js_responsi_theme'), 13 );
		
		// Include google fonts into header
		add_action( 'wp_enqueue_scripts', array( $this, 'add_google_fonts'), 9 );
		
		// Add script check if checkout then close popup and redirect to checkout page
		add_action( 'wp_head', array( $this, 'redirect_to_checkout_page_from_popup') );
		
		//Enqueue Script On Home Page Responsi	
		add_action( 'wp_footer', array( $this, 'quick_view_ultimate_popup') );
		
		//Ajax Action
		add_action('wp_ajax_quick_view_ultimate_reload_cart', array( $this, 'quick_view_ultimate_reload_cart') );
		add_action('wp_ajax_nopriv_quick_view_ultimate_reload_cart', array( $this, 'quick_view_ultimate_reload_cart') );
	}

	public function frontend_register_scripts() {
		$quick_view_ultimate_enable = get_option('quick_view_ultimate_enable');
		if ( 'no' == $quick_view_ultimate_enable ) return ;

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$quick_view_ultimate_type = get_option('quick_view_ultimate_type');
		if ( 'hover' == $quick_view_ultimate_type ) {
			wp_register_script( 'quick-view-hover-script', WC_QUICK_VIEW_ULTIMATE_JS_URL.'/quick_view_hover.js', array('jquery'), WC_QUICK_VIEW_ULTIMATE_VERSION, true );
			wp_enqueue_script( 'quick-view-hover-script' );
		}

		$quick_view_ultimate_popup_tool = get_option('quick_view_ultimate_popup_tool');
		if ( 'colorbox' == $quick_view_ultimate_popup_tool ) {
			wp_enqueue_style( 'a3_colorbox_style', WC_QUICK_VIEW_ULTIMATE_JS_URL . '/colorbox/colorbox.css' );
			wp_enqueue_script( 'colorbox_script', WC_QUICK_VIEW_ULTIMATE_JS_URL . '/colorbox/jquery.colorbox'.$suffix.'.js', array('jquery'), false, false );
		} else {
			$wc_assets_path = str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) . '/assets/';

			wp_enqueue_style( 'woocommerce_prettyPhoto_css', WC_QUICK_VIEW_ULTIMATE_CSS_URL . '/prettyPhoto.css' );

			wp_deregister_script( 'prettyPhoto' );
			wp_enqueue_script( 'prettyPhoto', WC_QUICK_VIEW_ULTIMATE_JS_URL . '/prettyPhoto/jquery.prettyPhoto' . $suffix . '.js', array('jquery'), '3.1.6', false );
		}

		wp_enqueue_style( 'quick-view-css', WC_QUICK_VIEW_ULTIMATE_CSS_URL.'/style.css', array(), WC_QUICK_VIEW_ULTIMATE_VERSION );

		$quick_view_ultimate_popup_content = get_option('quick_view_ultimate_popup_content', 'custom_template' );

		if ( 'custom_template' == $quick_view_ultimate_popup_content ) {

			if ( current_theme_supports( 'wc-product-gallery-zoom' ) ) {
				wp_enqueue_script( 'zoom' );
			}
			if ( current_theme_supports( 'wc-product-gallery-slider' ) ) {
				wp_enqueue_script( 'flexslider' );
			}
			if ( current_theme_supports( 'wc-product-gallery-lightbox' ) ) {
				wp_enqueue_script( 'photoswipe-ui-default' );
				wp_enqueue_style( 'photoswipe-default-skin' );
				add_action( 'wp_footer', 'woocommerce_photoswipe' );
			}
			wp_enqueue_script( 'wc-single-product' );

			$_upload_dir = wp_upload_dir();
			if ( file_exists( $_upload_dir['basedir'] . '/sass/wc_product_quick_view.min.css' ) ) {
				global $wc_qv_less;
				wp_enqueue_style( 'a3' . $wc_qv_less->css_file_name );
			} else {
				include( WC_QUICK_VIEW_ULTIMATE_DIR . '/templates/customized_popup_style.php' );
			}

			wp_register_script( 'quick-view-popup-script', WC_QUICK_VIEW_ULTIMATE_JS_URL.'/quick_view_ultimate.js', array('jquery'), WC_QUICK_VIEW_ULTIMATE_VERSION, true );
			wp_enqueue_script( 'quick-view-popup-script' );

			wp_localize_script( 'quick-view-popup-script',
				'wc_qv_vars',
				apply_filters( 'wc_qv_vars', array(
					'ajax_url' => admin_url( 'admin-ajax.php', 'relative' )
				) )
			);
		}

	}

	public function set_customer_cookie() {
		if ( ! is_admin() ) {
			WC()->session->set_customer_session_cookie(true);
		}
	}
	
	public function redirect_to_checkout_page_from_popup() {
		if ( is_checkout() ) {
			$woocommerce_db_version = get_option( 'woocommerce_db_version', null );
	?>
    	<script type="text/javascript">
		if ( window.self !== window.top ) {
			self.parent.location.href = '<?php if ( version_compare( $woocommerce_db_version, '2.1', '<' ) ) { echo get_permalink( woocommerce_get_page_id( 'checkout' ) ); } else { echo get_permalink( wc_get_page_id( 'checkout' ) ); } ?>';
		}
		</script>
    <?php
		}
	}
	
	public function fix_responsi_theme(){
		if(function_exists('add_responsi_pagination_theme')){
			remove_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'add_quick_view_ultimate_under_image_each_products'), 11 );
			add_action( 'responsi_before_shop_loop_item_content_container', array( $this, 'add_quick_view_ultimate_under_image_each_products'), 11 );
		}
	}
	
	public function add_google_fonts() {
		global $wc_qv_fonts_face;
		$quick_view_ultimate_on_hover_bt_font = get_option( 'quick_view_ultimate_on_hover_bt_font' );
		$quick_view_ultimate_under_image_link_font = get_option( 'quick_view_ultimate_under_image_link_font' );
		$quick_view_ultimate_under_image_bt_font = get_option( 'quick_view_ultimate_under_image_bt_font' );
		
		$google_fonts = array( $quick_view_ultimate_on_hover_bt_font['face'], $quick_view_ultimate_under_image_link_font['face'], $quick_view_ultimate_under_image_bt_font['face'] );
		
		$wc_qv_fonts_face->generate_google_webfonts( $google_fonts );
	}
	
	public function fix_style_js_responsi_theme(){
		if ( (is_home() && function_exists('add_responsi_pagination_theme')) ){
			add_action( 'woo_main_end', array( $this, 'quick_view_ultimate_wp_enqueue_style'), 13 );
			add_action( 'a3rev_main_end', array( $this, 'quick_view_ultimate_wp_enqueue_style'), 13 );
		}
		if ( is_singular('product') ) {
			add_action( 'wp_footer', array( $this, 'quick_view_ultimate_wp_enqueue_style'), 13 );
		}
	}
	
	public function add_quick_view_ultimate_under_image_each_products(){
		
		//if (!is_tax( 'product_cat' ) && !is_post_type_archive('product') && !is_tax( 'product_tag' )) return; // Not on product page - return
		
		$quick_view_ultimate_enable = get_option('quick_view_ultimate_enable');
		$quick_view_ultimate_type = get_option('quick_view_ultimate_type');
		
		$do_this = false;
		
		if( $quick_view_ultimate_enable == 'yes' ) $do_this = true;
		if( !$do_this ) return;
		if( $quick_view_ultimate_type != 'under' ) return;
		
		$this->quick_view_ultimate_under_image();

	}

	public function quick_view_ultimate_under_image() {
		$quick_view_ultimate_popup_tool = get_option( 'quick_view_ultimate_popup_tool' );
		$quick_view_ultimate_under_image_bt_type = get_option( 'quick_view_ultimate_under_image_bt_type' );
		$quick_view_ultimate_under_image_link_text = esc_attr( stripslashes( get_option( 'quick_view_ultimate_under_image_link_text' ) ) );
		$quick_view_ultimate_under_image_bt_text = esc_attr( stripslashes( get_option( 'quick_view_ultimate_under_image_bt_text' ) ) );
		
		$quick_view_ultimate_button = '';
		$link_text = $quick_view_ultimate_under_image_link_text;
		$class = $quick_view_ultimate_popup_tool.' quick_view_ultimate_under_link quick_view_ultimate_click';
		if( $quick_view_ultimate_under_image_bt_type == 'button' ){
			$link_text = $quick_view_ultimate_under_image_bt_text;
			$class = $quick_view_ultimate_popup_tool.' quick_view_ultimate_under_button quick_view_ultimate_click';
		}
		
		$quick_view_ultimate_button .= '<div style="clear:both;"></div><div class="quick_view_ultimate_container_under"><div class="quick_view_ultimate_content_under"><span class="'.$class.'" id="'.get_the_ID().'" data-link="'.get_permalink().'">'.$link_text.'</span></div></div><div style="clear:both;"></div>';
		
		echo $quick_view_ultimate_button;
	}
	
	public function add_quick_view_ultimate_hover_each_products(){
		
		//if (!is_tax( 'product_cat' ) && !is_post_type_archive('product') && !is_tax( 'product_tag' )) return; // Not on product page - return
		
		$quick_view_ultimate_enable = get_option('quick_view_ultimate_enable');
		$quick_view_ultimate_type = get_option('quick_view_ultimate_type');
		
		$do_this = false;
		
		if( $quick_view_ultimate_enable == 'yes' ) $do_this = true;
		
		if( !$do_this ) return;
		if( $quick_view_ultimate_type != 'hover' ) return;
		
		$this->quick_view_ultimate_hover();
		
	}

	public function quick_view_ultimate_hover() {
		$quick_view_ultimate_on_hover_bt_alink = esc_attr( stripslashes( get_option('quick_view_ultimate_on_hover_bt_alink') ) );
		$quick_view_ultimate_popup_tool = get_option( 'quick_view_ultimate_popup_tool' );
		$quick_view_ultimate_on_hover_bt_text = esc_attr( stripslashes( get_option( 'quick_view_ultimate_on_hover_bt_text' ) ) );
		
		$quick_view_ultimate_button = '';
		
		$class = $quick_view_ultimate_popup_tool.' quick_view_ultimate_button quick_view_ultimate_click';
		
		$quick_view_ultimate_button .= '<div class="quick_view_ultimate_container" position="'.$quick_view_ultimate_on_hover_bt_alink.'"><div class="quick_view_ultimate_content"><span id="'.get_the_ID().'" data-link="'.get_permalink().'" class="'.$class.'">'.$quick_view_ultimate_on_hover_bt_text.'</span></div></div>';
		echo $quick_view_ultimate_button;
	}

	public function quick_view_ultimate_wp_enqueue_style(){
		$quick_view_ultimate_enable = get_option('quick_view_ultimate_enable');
		if ( 'no' == $quick_view_ultimate_enable ) return ;

		wp_enqueue_style( 'quick-view-css', WC_QUICK_VIEW_ULTIMATE_CSS_URL.'/style.css', array(), WC_QUICK_VIEW_ULTIMATE_VERSION );

		$quick_view_ultimate_popup_content = get_option('quick_view_ultimate_popup_content', 'custom_template' );
		if ( 'custom_template' == $quick_view_ultimate_popup_content ) {

			$_upload_dir = wp_upload_dir();
			if ( file_exists( $_upload_dir['basedir'] . '/sass/wc_product_quick_view.min.css' ) ) {
				global $wc_qv_less;
				wp_enqueue_style( 'a3' . $wc_qv_less->css_file_name );
			} else {
				include( WC_QUICK_VIEW_ULTIMATE_DIR . '/templates/customized_popup_style.php' );
			}
		}
	}
	
	public function quick_view_ultimate_popup(){
		global $wc_qv_admin_interface;
				
		$quick_view_ultimate_enable = get_option('quick_view_ultimate_enable');
		if ( 'no' == $quick_view_ultimate_enable ) return ;

		$quick_view_ultimate_popup_tool = get_option('quick_view_ultimate_popup_tool');

		$quick_view_ultimate_popup_content = get_option('quick_view_ultimate_popup_content', 'custom_template' );
		
		$quick_view_ultimate_colorbox_center_on_scroll = get_option('quick_view_ultimate_colorbox_center_on_scroll');
		if ( $quick_view_ultimate_colorbox_center_on_scroll == '' ) $quick_view_ultimate_colorbox_center_on_scroll = 'false';
		$quick_view_ultimate_colorbox_transition = get_option('quick_view_ultimate_colorbox_transition');
		$quick_view_ultimate_colorbox_speed = get_option('quick_view_ultimate_colorbox_speed');
		$quick_view_ultimate_colorbox_overlay_color = get_option('quick_view_ultimate_colorbox_overlay_color');

		$quick_view_ultimate_prettyphoto_speed = get_option('quick_view_ultimate_prettyphoto_speed');
		$quick_view_ultimate_prettyphoto_overlay_color = get_option('quick_view_ultimate_prettyphoto_overlay_color');
		
		?>
		<script type="text/javascript">
		jQuery(document).ready(function() {
			function wc_qv_getWidth() {
				xWidth = null;
				if(window.screen != null)
				  xWidth = window.screen.availWidth;
			
				if(window.innerWidth != null)
				  xWidth = window.innerWidth;
			
				if(document.body != null)
				  xWidth = document.body.clientWidth;
			
				return xWidth;
			}

			function wc_qv_get_custom_template( product_id, extra_parameters = '' ) {
				var is_shop = '<?php echo ( is_shop() ? 'yes': 'no' ); ?>';
				<?php if ( is_product_category() ) { 
				$term = get_queried_object();
				?>
				var is_category = '<?php echo $term->term_id; ?>';
				<?php } else { ?>
				var is_category = 'no';
				<?php } ?>
				var orderby = jQuery('.woocommerce-ordering').find('select[name=orderby]').val();

				var url = '<?php echo admin_url('admin-ajax.php', 'relative');?>'+'?action=quick_view_custom_template_load&product_id='+product_id+'&is_shop='+is_shop+'&is_category='+is_category+'&orderby='+orderby+'&security=<?php echo wp_create_nonce("quick_view_custom_template_load");?>';

				if ( '' !== extra_parameters ) {
					url += extra_parameters;
				}

				return url;
			}

			<?php if ( 'colorbox' == $quick_view_ultimate_popup_tool ) { ?>
			jQuery(document).on( 'quick_view_close_popup', function(){
				jQuery.colorbox.close();
			});
			
			jQuery(document).bind('cbox_cleanup', function(){
				jQuery.post( '<?php echo admin_url('admin-ajax.php', 'relative');?>?action=quick_view_ultimate_reload_cart&security=<?php echo wp_create_nonce("reload-cart");?>', '', function(rsHTML){
					jQuery('.widget_shopping_cart_content').html(rsHTML);
					
				});
			});
			jQuery(document).on("click", ".quick_view_ultimate_click.colorbox", function(){
				
				var product_id = jQuery(this).attr('id');
				var product_url = jQuery(this).attr('data-link');

				<?php if ( $quick_view_ultimate_popup_content == 'full_page' ) { ?>
				var url = product_url;
				<?php } else { ?>
				var url = wc_qv_get_custom_template( product_id );
				<?php } ?>
				
				var popup_wide = <?php echo (int) get_option('quick_view_ultimate_colorbox_popup_width', 600 ); ?>;
				var popup_tall = <?php echo (int) get_option('quick_view_ultimate_colorbox_popup_height', 500 ); ?>;
				if ( wc_qv_getWidth()  <= 568 ) {
					popup_wide = '100%';
					popup_tall = '90%';
				}
				
				jQuery.colorbox({
					href		: url,
					<?php if ( $quick_view_ultimate_popup_content != 'custom_template' ) { ?>
					iframe		: true,
					<?php } ?>
					opacity		: 0.85,
					scrolling	: true,
					initialWidth: 100,
					initialHeight: 100,
					innerWidth	: popup_wide,
					innerHeight	: popup_tall,
					maxWidth  	: '100%',
					maxHeight  	: '90%',
					returnFocus : true,
					transition  : '<?php echo $quick_view_ultimate_colorbox_transition;?>',
					speed		: <?php echo $quick_view_ultimate_colorbox_speed;?>,
					fixed		: <?php echo $quick_view_ultimate_colorbox_center_on_scroll;?>
				});
				return false;
			});

			<?php } else { ?>

			jQuery(document).on( 'quick_view_close_popup', function(){
				if ( jQuery('div.pp_overlay').length > 0 ) {
					jQuery.prettyPhoto.close();
				}
			});

			jQuery(".init_prettyphoto").prettyPhoto({
				animation_speed: <?php echo ( int ) $quick_view_ultimate_prettyphoto_speed; ?>,
				social_tools: false,
				theme: 'pp_woocommerce',
				horizontal_padding: 20,
				opacity: 0.8,
				ajaxcallback: function(){
					jQuery(document).find('.pp_content').append( '<div class="quick_view_popup_loading"></div>' );
					jQuery('.quick_view_popup_loading').show();
					jQuery('.pp_loaderIcon').show();
				},
				changepicturecallback: function(){
					<?php if ( $quick_view_ultimate_popup_content == 'full_page' ) { ?>
					jQuery('.quick_view_popup_loading').hide();
					jQuery('.pp_loaderIcon').hide();
					<?php } else { ?>
					var popup_container = jQuery('.quick_view_popup_container');
					var product_id = popup_container.data('product_id');
					var orderby = popup_container.data('orderby');
					var is_shop = popup_container.data('is_shop');
					var is_category = popup_container.data('is_category');
					var qv_data = {
						action: "quick_view_prettyphoto_custom_template_load",
						product_id : product_id,
						orderby: orderby,
						is_shop: is_shop,
						is_category: is_category
					};
					jQuery.post( '<?php echo admin_url('admin-ajax.php', 'relative');?>', qv_data, function(responsve){
						popup_container.html(responsve);
						jQuery('.quick_view_popup_loading').hide();
						jQuery('.pp_loaderIcon').hide();
					});
					<?php } ?>
				}
			});
			jQuery(document).on("click", ".quick_view_ultimate_click.prettyphoto", function(){

				var product_id = jQuery(this).attr('id');
				var product_url = jQuery(this).attr('data-link');

				<?php if ( $quick_view_ultimate_popup_content == 'full_page' ) { ?>
				var url = product_url + '?iframe=true';
				var popup_tall = 800;
				<?php } else { ?>
				var url = wc_qv_get_custom_template( product_id, '&ajax=true' );
				var popup_tall = 300;
				<?php } ?>
				
				var popup_wide = <?php echo (int) get_option('quick_view_ultimate_prettyphoto_popup_width', 600 ); ?>;
				if ( wc_qv_getWidth()  <= 600 ) { 
					popup_wide = '90%';
					popup_tall = '90%'; 
				}

				jQuery.prettyPhoto.open( url  + '&width=' + popup_wide + '&height=' + popup_tall, '', ''  );

				return false;
			});

			<?php } ?>

		});	
		</script>
        <style type="text/css">
		#cboxOverlay{ <?php echo $wc_qv_admin_interface->generate_background_color_css( $quick_view_ultimate_colorbox_overlay_color ); ?> }
		body .pp_overlay { <?php echo $wc_qv_admin_interface->generate_background_color_css( $quick_view_ultimate_prettyphoto_overlay_color ); ?> }
        </style>
		<?php

		global $wc_quick_view_ultimate_style;
		$wc_quick_view_ultimate_style->button_style_under_image();
		$wc_quick_view_ultimate_style->button_style_show_on_hover();
	}
	
	public function strip_shortcodes ($content='') {
		$content = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $content);
		
		return $content;
	}
	
	public function limit_words($str='',$len=100,$more=true) {
		if (trim($len) == '' || $len < 0) $len = 100;
	   if ( $str=="" || $str==NULL ) return $str;
	   if ( is_array($str) ) return $str;
	   $str = trim($str);
	   $str = strip_tags($str);
	   if ( strlen($str) <= $len ) return $str;
	   $str = substr($str,0,$len);
	   if ( $str != "" ) {
			if ( !substr_count($str," ") ) {
					  if ( $more ) $str .= " ...";
					return $str;
			}
			while( strlen($str) && ($str[strlen($str)-1] != " ") ) {
					$str = substr($str,0,-1);
			}
			$str = substr($str,0,-1);
			if ( $more ) $str .= " ...";
			}
			return $str;
	}

	
	public function quick_view_ultimate_reload_cart() {
		if(function_exists('woocommerce_mini_cart')) woocommerce_mini_cart() ;
		die();
	}
	
	public function a3_wp_admin() {
		wp_enqueue_style( 'a3rev-wp-admin-style', WC_QUICK_VIEW_ULTIMATE_CSS_URL . '/a3_wp_admin.css' );
	}
	
	public function admin_sidebar_menu_css() {
		wp_enqueue_style( 'a3rev-wc-qv-admin-sidebar-menu-style', WC_QUICK_VIEW_ULTIMATE_CSS_URL . '/admin_sidebar_menu.css' );
	}
	
	public function plugin_extra_links($links, $plugin_name) {
		if ( $plugin_name != WC_QUICK_VIEW_ULTIMATE_NAME) {
			return $links;
		}

		global $wc_qv_admin_init;
		$links[] = '<a href="http://docs.a3rev.com/user-guides/plugins-extensions/woocommerce-quick-view-ultimate/" target="_blank">'.__('Documentation', 'woocommerce-products-quick-view' ).'</a>';
		$links[] = '<a href="'.$wc_qv_admin_init->support_url.'" target="_blank">'.__('Support', 'woocommerce-products-quick-view' ).'</a>';
		return $links;
	}

	public function settings_plugin_links($actions) {
		$actions = array_merge( array( 'settings' => '<a href="admin.php?page=wc-quick-view">' . __( 'Settings', 'woocommerce-products-quick-view' ) . '</a>' ), $actions );

		return $actions;
	}

	public function plugin_extension_box( $boxes = array() ) {
		global $wc_qv_admin_init;

		$support_box = '<a href="'.$wc_qv_admin_init->support_url.'" target="_blank" alt="'.__('Go to Support Forum', 'woocommerce-products-quick-view' ).'"><img src="'.WC_QUICK_VIEW_ULTIMATE_IMAGES_URL.'/go-to-support-forum.png" /></a>';

		$boxes[] = array(
			'content' => $support_box,
			'css' => 'border: none; padding: 0; background: none;'
		);

		$review_box = '<div style="margin-bottom: 5px; font-size: 12px;"><strong>' . __('Is this plugin is just what you needed? If so', 'woocommerce-products-quick-view' ) . '</strong></div>';
        $review_box .= '<a href="https://wordpress.org/support/view/plugin-reviews/woocommerce-products-quick-view#postform" target="_blank" alt="'.__('Submit Review for Plugin on WordPress', 'woocommerce-products-quick-view' ).'"><img src="'.WC_QUICK_VIEW_ULTIMATE_IMAGES_URL.'/a-5-star-rating-would-be-appreciated.png" /></a>';

        $boxes[] = array(
            'content' => $review_box,
            'css' => 'border: none; padding: 0; background: none;'
        );


		$free_woocommerce_box = '<a href="https://profiles.wordpress.org/a3rev/#content-plugins" target="_blank" alt="'.__('Free WooCommerce Plugins', 'woocommerce-products-quick-view' ).'"><img src="'.WC_QUICK_VIEW_ULTIMATE_IMAGES_URL.'/free-woocommerce-plugins.png" /></a>';

		$boxes[] = array(
			'content' => $free_woocommerce_box,
			'css' => 'border: none; padding: 0; background: none;'
		);

		$free_wordpress_box = '<a href="https://profiles.wordpress.org/a3rev/#content-plugins" target="_blank" alt="'.__('Free WordPress Plugins', 'woocommerce-products-quick-view' ).'"><img src="'.WC_QUICK_VIEW_ULTIMATE_IMAGES_URL.'/free-wordpress-plugins.png" /></a>';

		$boxes[] = array(
			'content' => $free_wordpress_box,
			'css' => 'border: none; padding: 0; background: none;'
		);

		$connect_box = '<div style="margin-bottom: 5px;">' . __('Connect with us via', 'woocommerce-products-quick-view') . '</div>';
		$connect_box .= '<a href="https://www.facebook.com/a3rev" target="_blank" alt="'.__('a3rev Facebook', 'woocommerce-products-quick-view' ).'" style="margin-right: 5px;"><img src="'.WC_QUICK_VIEW_ULTIMATE_IMAGES_URL.'/follow-facebook.png" /></a> ';
		$connect_box .= '<a href="https://twitter.com/a3rev" target="_blank" alt="'.__('a3rev Twitter', 'woocommerce-products-quick-view' ).'"><img src="'.WC_QUICK_VIEW_ULTIMATE_IMAGES_URL.'/follow-twitter.png" /></a>';

		$boxes[] = array(
			'content' => $connect_box,
			'css' => 'border-color: #3a5795;'
		);

		return $boxes;
	}
}

$GLOBALS['wc_quick_view_ultimate'] = new WC_Quick_View_Ultimate();

?>
