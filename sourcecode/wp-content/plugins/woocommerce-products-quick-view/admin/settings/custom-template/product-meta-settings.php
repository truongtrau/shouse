<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC Quick View Custom Template Product Data Settings

-----------------------------------------------------------------------------------*/

class WC_QV_Custom_Template_Product_Meta_Settings
{

	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'quick_view_template_product_meta_settings';

	/**
	 * @var array
	 */
	public $form_fields = array();

	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->init_form_fields();
	}

	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {

  		// Define settings
     	$this->form_fields = apply_filters( $this->form_key . '_settings_fields', array(

			array(
				'name'		=> __( 'Product Meta', 'woocommerce-products-quick-view' ),
                'type' 		=> 'heading',
                'class'		=> 'pro_feature_fields pro_feature_hidden',
                'id'		=> 'qv_template_product_meta_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Product Meta', 'woocommerce-products-quick-view' ),
				'id' 		=> 'show_product_meta',
				'class'		=> 'show_product_meta',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'checked_value'		=> 1,
				'unchecked_value' 	=> 0,
				'checked_label'		=> __( 'ON', 'woocommerce-products-quick-view' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-products-quick-view' ),
			),
			
			array(
				'name'		=> '',
                'type' 		=> 'heading',
				'class'		=> 'show_product_meta_container'
           	),
			array(  
				'name' 		=> __( 'Product Meta Alignment', 'woocommerce-products-quick-view' ),
				'id' 		=> 'meta_alignment',
				'type' 		=> 'onoff_radio',
				'default' 	=> 'left',
				'onoff_options' => array(
					array(
						'val' 				=> 'left',
						'text' 				=> __( 'Left', 'woocommerce-products-quick-view' ),
						'checked_label'		=> __( 'ON', 'woocommerce-products-quick-view' ) ,
						'unchecked_label' 	=> __( 'OFF', 'woocommerce-products-quick-view' ) ,
					),
					array(
						'val' 				=> 'center',
						'text' 				=> __( 'Center', 'woocommerce-products-quick-view' ),
						'checked_label'		=> __( 'ON', 'woocommerce-products-quick-view' ) ,
						'unchecked_label' 	=> __( 'OFF', 'woocommerce-products-quick-view' ) ,
					),
					array(
						'val' 				=> 'right',
						'text' 				=> __( 'Right', 'woocommerce-products-quick-view' ),
						'checked_label'		=> __( 'ON', 'woocommerce-products-quick-view' ) ,
						'unchecked_label' 	=> __( 'OFF', 'woocommerce-products-quick-view' ) ,
					),
				),
			),
			array(  
				'name' 		=> __( 'Product Meta Name Font', 'woocommerce-products-quick-view' ),
				'id' 		=> 'meta_name_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'line_height' => '1.4em', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' )
			),
			array(  
				'name' 		=> __( 'Product Meta Value Font', 'woocommerce-products-quick-view' ),
				'id' 		=> 'meta_value_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'line_height' => '1.4em', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' )
			),
			array(  
				'name' 		=> __( 'Product Meta Value Hover Color', 'woocommerce-products-quick-view' ),
				'id' 		=> 'meta_value_font_hover_color',
				'type' 		=> 'color',
				'default'	=> '#999999'
			),
			array(  
				'name' 		=> __( 'Product Meta Margin', 'woocommerce-products-quick-view' ),
				'id' 		=> 'meta_margin',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array( 
											'id' 		=> 'meta_margin_top',
	 										'name' 		=> __( 'Top', 'woocommerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5 ),
	 
	 								array(  'id' 		=> 'meta_margin_bottom',
	 										'name' 		=> __( 'Bottom', 'woocommerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5 ),
											
									array( 
											'id' 		=> 'meta_margin_left',
	 										'name' 		=> __( 'Left', 'woocommerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
											
									array( 
											'id' 		=> 'meta_margin_right',
	 										'name' 		=> __( 'Right', 'woocommerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
	 							)
			),
			
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	if ( $("input.show_product_meta:checked").val() != '1') {
		$(".show_product_meta_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
	}
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.show_product_meta', function( event, value, status ) {
		$(".show_product_meta_container").attr('style','display:none;');
		if ( status == 'true' ) {
			$(".show_product_meta_container").slideDown();
		} else {
			$(".show_product_meta_container").slideUp();
		}
	});
	
});
})(jQuery);
</script>
    <?php	
	}
	
}

global $wc_qv_custom_template_product_meta_settings;
$wc_qv_custom_template_product_meta_settings = new WC_QV_Custom_Template_Product_Meta_Settings();

?>