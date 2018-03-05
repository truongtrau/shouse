<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC Quick View ColorBox Popup Settings

-----------------------------------------------------------------------------------*/

class WC_QV_PrettyPhoto_Popup_Settings
{

	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_quick_view_prettyphoto_popup_settings';

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
            	'name' 		=> __( 'PrettyPhoto Pop Up', 'woocommerce-products-quick-view' ),
                'type' 		=> 'heading',
                'class'		=> 'quick_view_prettyphoto_popup_container',
                'id'		=> 'quick_view_prettyphoto_popup_box',
				'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Pop-up Maximum Width', 'woocommerce-products-quick-view' ),
				'id' 		=> 'quick_view_ultimate_prettyphoto_popup_width',
				'desc'		=> 'px',
				'type' 		=> 'slider',
				'default'	=> 800,
				'min'		=> 520,
				'max'		=> 1000,
				'increment'	=> 10
			),
			array(  
				'name' 		=> __( 'Opening & Closing Speed', 'woocommerce-products-quick-view' ),
				'desc' 		=> __( 'Milliseconds when open and close popup', 'woocommerce-products-quick-view' ),
				'id' 		=> 'quick_view_ultimate_prettyphoto_speed',
				'type' 		=> 'text',
				'css' 		=> 'width:40px;',
				'default'	=> '300'
			),
			array(  
				'name' 		=> __( 'Background Overlay Colour', 'woocommerce-products-quick-view' ),
				'desc' 		=> __('Select a colour or empty for use default color from WooCommerce.', 'woocommerce-products-quick-view' ),
				'id' 		=> 'quick_view_ultimate_prettyphoto_overlay_color',
				'type' 		=> 'bg_color',
				'default'	=> array( 'enable' => 1, 'color' => '#666666' )
			),
			
        ));
	}
}

global $wc_qv_prettyphoto_popup_settings;
$wc_qv_prettyphoto_popup_settings = new WC_QV_PrettyPhoto_Popup_Settings();

?>