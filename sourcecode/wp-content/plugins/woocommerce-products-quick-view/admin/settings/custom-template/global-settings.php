<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC Quick View Custom Template Global Settings

TABLE OF CONTENTS

- var parent_tab
- var subtab_data
- var option_name
- var form_key
- var position
- var form_fields
- var form_messages

- __construct()
- subtab_init()
- set_default_settings()
- get_settings()
- subtab_data()
- add_subtab()
- settings_form()
- init_form_fields()

-----------------------------------------------------------------------------------*/

class WC_QV_Custom_Template_Global_Settings extends WC_QV_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'custom-template';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'quick_view_template_global_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'quick_view_template_global_settings';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 1;
	
	/**
	 * @var array
	 */
	public $form_fields = array();
	
	/**
	 * @var array
	 */
	public $form_messages = array();
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->init_form_fields();
		$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Global Settings successfully saved.', 'woocommerce-products-quick-view' ),
				'error_message'		=> __( 'Error: Global Settings can not save.', 'woocommerce-products-quick-view' ),
				'reset_message'		=> __( 'Global Settings successfully reseted.', 'woocommerce-products-quick-view' ),
			);

		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );

		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );

		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* subtab_init() */
	/* Sub Tab Init */
	/*-----------------------------------------------------------------------------------*/
	public function subtab_init() {
		
		add_filter( $this->plugin_name . '-' . $this->parent_tab . '_settings_subtabs_array', array( $this, 'add_subtab' ), $this->position );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* set_default_settings()
	/* Set default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function set_default_settings() {
		global $wc_qv_admin_interface;
		
		$wc_qv_admin_interface->reset_settings( $this->form_fields, $this->option_name, false );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {
		global $wc_qv_admin_interface;
		
		$wc_qv_admin_interface->get_settings( $this->form_fields, $this->option_name );
	}
	
	/**
	 * subtab_data()
	 * Get SubTab Data
	 * =============================================
	 * array ( 
	 *		'name'				=> 'my_subtab_name'				: (required) Enter your subtab name that you want to set for this subtab
	 *		'label'				=> 'My SubTab Name'				: (required) Enter the subtab label
	 * 		'callback_function'	=> 'my_callback_function'		: (required) The callback function is called to show content of this subtab
	 * )
	 *
	 */
	public function subtab_data() {
		
		$subtab_data = array( 
			'name'				=> 'settings',
			'label'				=> __( 'Container Style', 'woocommerce-products-quick-view' ),
			'callback_function'	=> 'wc_qv_custom_template_global_settings_form',
		);
		
		if ( $this->subtab_data ) return $this->subtab_data;
		return $this->subtab_data = $subtab_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_subtab() */
	/* Add Subtab to Admin Init
	/*-----------------------------------------------------------------------------------*/
	public function add_subtab( $subtabs_array ) {
	
		if ( ! is_array( $subtabs_array ) ) $subtabs_array = array();
		$subtabs_array[] = $this->subtab_data();
		
		return $subtabs_array;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* settings_form() */
	/* Call the form from Admin Interface
	/*-----------------------------------------------------------------------------------*/
	public function settings_form() {
		global $wc_qv_admin_interface;
		
		$output = '';
		$output .= $wc_qv_admin_interface->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );
		
		return $output;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
		
  		// Define settings			
     	$this->form_fields = array(
     		array(
            	'name' 		=> __( 'CUSTOM TEMPLATE PREMIUM', 'woocommerce-products-quick-view' ),
                'type' 		=> 'heading',
                'desc'		=> '<img class="rwd_image_maps" src="'.WC_QUICK_VIEW_ULTIMATE_IMAGES_URL.'/premium-custom-template.png" usemap="#customTemplateMap" style="width: auto; max-width: 100%;" border="0" />
<map name="customTemplateMap" id="customTemplateMap">
	<area shape="rect" coords="470,145,890,210" href="'.$this->pro_plugin_page_url.'" target="_blank" />
</map>',
				'alway_open'=> true,
                'id'		=> 'custom_template_premium_box',
                'is_box'	=> true,
           	),

			array(
				'name' 		=> __( 'Container Style', 'woocommerce-products-quick-view' ),
				'class'		=> 'pro_feature_fields pro_feature_hidden',
				'id'		=> 'qv_template_container_box',
				'type' 		=> 'heading',
				'is_box'	=> true,
			),
			array(  
				'name' 		=> __( 'Gallery Container Wide', 'woocommerce-products-quick-view' ),
				'id' 		=> 'gallery_container_wide',
				'desc'		=> '%',
				'type' 		=> 'slider',
				'default'	=> 33,
				'min'		=> 30,
				'max'		=> 70,
				'increment'	=> 1
			),
			array(  
				'name' 		=> __( 'Gallery Position', 'woocommerce-products-quick-view' ),
				'id' 		=> 'gallery_position',
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
						'val' 				=> 'right',
						'text' 				=> __( 'Right', 'woocommerce-products-quick-view' ),
						'checked_label'		=> __( 'ON', 'woocommerce-products-quick-view' ) ,
						'unchecked_label' 	=> __( 'OFF', 'woocommerce-products-quick-view' ) ,
					),
				),
			),
			array(  
				'name' 		=> __( 'Pop-up Container Background Colour', 'woocommerce-products-quick-view' ),
				'desc' 		=> __('Default', 'woocommerce-products-quick-view' ). ' [default_value]',
				'id' 		=> 'container_bg_color',
				'type' 		=> 'color',
				'default'	=> '#FFFFFF'
			),
        );

		include_once( $this->admin_plugin_dir() . '/settings/custom-template/control-settings.php' );
		global $wc_qv_custom_template_control_settings;
		$this->form_fields = array_merge( $this->form_fields, $wc_qv_custom_template_control_settings->form_fields );

		include_once( $this->admin_plugin_dir() . '/settings/custom-template/product-title-settings.php' );
		global $wc_qv_custom_template_product_title_settings;
		$this->form_fields = array_merge( $this->form_fields, $wc_qv_custom_template_product_title_settings->form_fields );

		include_once( $this->admin_plugin_dir() . '/settings/custom-template/product-rating-settings.php' );
		global $wc_qv_custom_template_product_rating_settings;
		$this->form_fields = array_merge( $this->form_fields, $wc_qv_custom_template_product_rating_settings->form_fields );

		include_once( $this->admin_plugin_dir() . '/settings/custom-template/product-description-settings.php' );
		global $wc_qv_custom_template_product_description_settings;
		$this->form_fields = array_merge( $this->form_fields, $wc_qv_custom_template_product_description_settings->form_fields );

		include_once( $this->admin_plugin_dir() . '/settings/custom-template/product-meta-settings.php' );
		global $wc_qv_custom_template_product_meta_settings;
		$this->form_fields = array_merge( $this->form_fields, $wc_qv_custom_template_product_meta_settings->form_fields );

		include_once( $this->admin_plugin_dir() . '/settings/custom-template/product-price-settings.php' );
		global $wc_qv_custom_template_product_price_settings;
		$this->form_fields = array_merge( $this->form_fields, $wc_qv_custom_template_product_price_settings->form_fields );

		include_once( $this->admin_plugin_dir() . '/settings/custom-template/quantity-selector-settings.php' );
		global $wc_qv_custom_template_quantity_selector_settings;
		$this->form_fields = array_merge( $this->form_fields, $wc_qv_custom_template_quantity_selector_settings->form_fields );

		include_once( $this->admin_plugin_dir() . '/settings/custom-template/add-to-cart-settings.php' );
		global $wc_qv_custom_template_addtocart_button_settings;
		$this->form_fields = array_merge( $this->form_fields, $wc_qv_custom_template_addtocart_button_settings->form_fields );

		include_once( $this->admin_plugin_dir() . '/settings/custom-template/read-more-settings.php' );
		global $wc_qv_custom_template_readmore_button_settings;
		$this->form_fields = array_merge( $this->form_fields, $wc_qv_custom_template_readmore_button_settings->form_fields );

		$this->form_fields = apply_filters( $this->option_name . '_settings_fields', $this->form_fields );
	}

	public function include_script() {
		global $wc_qv_admin_interface;
		$wc_qv_admin_interface->reset_settings( $this->form_fields, $this->option_name, true, true );

		wp_enqueue_script( 'jquery-rwd-image-maps' );
?>
<style type="text/css">
	.a3rev_panel_container p.submit {
		display: none;
	}
</style>
<?php
		global $wc_qv_custom_template_control_settings;

		$wc_qv_custom_template_control_settings->include_script();

		global $wc_qv_custom_template_product_rating_settings;
		global $wc_qv_custom_template_product_description_settings;
		global $wc_qv_custom_template_product_meta_settings;
		global $wc_qv_custom_template_product_price_settings;
		global $wc_qv_custom_template_quantity_selector_settings;
		global $wc_qv_custom_template_addtocart_button_settings;
		global $wc_qv_custom_template_readmore_button_settings;

		$wc_qv_custom_template_product_rating_settings->include_script();
		$wc_qv_custom_template_product_description_settings->include_script();
		$wc_qv_custom_template_product_meta_settings->include_script();
		$wc_qv_custom_template_product_price_settings->include_script();
		$wc_qv_custom_template_quantity_selector_settings->include_script();
		$wc_qv_custom_template_addtocart_button_settings->include_script();
		$wc_qv_custom_template_readmore_button_settings->include_script();
	}
}

global $wc_qv_custom_template_global_settings;
$wc_qv_custom_template_global_settings = new WC_QV_Custom_Template_Global_Settings();

/** 
 * wc_qv_custom_template_global_settings_form()
 * Define the callback function to show subtab content
 */
function wc_qv_custom_template_global_settings_form() {
	global $wc_qv_custom_template_global_settings;
	$wc_qv_custom_template_global_settings->settings_form();
}

?>