<?php
/**
 * shouse_kego Customizer Class
 *
 * @author   WooThemes
 * @package  shouse_kego
 * @since    2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'shouse_kego_Customizer' ) ) :

	/**
	 * The shouse_kego Customizer class
	 */
	class shouse_kego_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'customize_register',              array( $this, 'customize_register' ), 10 );
			add_filter( 'body_class',                      array( $this, 'layout_class' ) );
			add_action( 'wp_enqueue_scripts',              array( $this, 'add_customizer_css' ), 130 );
			add_action( 'after_setup_theme',               array( $this, 'custom_header_setup' ) );
			add_action( 'customize_controls_print_styles', array( $this, 'customizer_custom_control_css' ) );
			add_action( 'customize_register',              array( $this, 'edit_default_customizer_settings' ), 99 );
			add_action( 'init',                            array( $this, 'default_theme_mod_values' ), 10 );

			add_action( 'after_switch_theme',              array( $this, 'set_shouse_kego_style_theme_mods' ) );
			add_action( 'customize_save_after',            array( $this, 'set_shouse_kego_style_theme_mods' ) );
		}

		/**
		 * Returns an array of the desired default shouse_kego Options
		 *
		 * @return array
		 */
		public static function get_shouse_kego_default_setting_values() {
			return apply_filters( 'shouse_kego_setting_default_values', $args = array(
				'shouse_kego_heading_color'               => '#333333',
				'shouse_kego_text_color'                  => '#6d6d6d',
				'shouse_kego_accent_color'                => '#96588a',
				'shouse_kego_header_background_color'     => '#ffffff',
				'shouse_kego_header_text_color'           => '#404040',
				'shouse_kego_header_link_color'           => '#333333',
				'shouse_kego_footer_background_color'     => '#f0f0f0',
				'shouse_kego_footer_heading_color'        => '#333333',
				'shouse_kego_footer_text_color'           => '#6d6d6d',
				'shouse_kego_footer_link_color'           => '#333333',
				'shouse_kego_button_background_color'     => '#eeeeee',
				'shouse_kego_button_text_color'           => '#333333',
				'shouse_kego_button_alt_background_color' => '#333333',
				'shouse_kego_button_alt_text_color'       => '#ffffff',
				'shouse_kego_layout'                      => 'right',
				'background_color'                       => 'ffffff',
			) );
		}

		/**
		 * Adds a value to each shouse_kego setting if one isn't already present.
		 *
		 * @uses get_shouse_kego_default_setting_values()
		 */
		public function default_theme_mod_values() {
			foreach ( self::get_shouse_kego_default_setting_values() as $mod => $val ) {
				add_filter( 'theme_mod_' . $mod, array( $this, 'get_theme_mod_value' ), 10 );
			}
		}

		/**
		 * Get theme mod value.
		 *
		 * @param string $value
		 * @return string
		 */
		public function get_theme_mod_value( $value ) {
			$key = substr( current_filter(), 10 );

			$set_theme_mods = get_theme_mods();

			if ( isset( $set_theme_mods[ $key ] ) ) {
				return $value;
			}

			$values = $this->get_shouse_kego_default_setting_values();

			return isset( $values[ $key ] ) ? $values[ $key ] : $value;
		}

		/**
		 * Set Customizer setting defaults.
		 * These defaults need to be applied separately as child themes can filter shouse_kego_setting_default_values
		 *
		 * @param  array $wp_customize the Customizer object.
		 * @uses   get_shouse_kego_default_setting_values()
		 */
		public function edit_default_customizer_settings( $wp_customize ) {
			foreach ( self::get_shouse_kego_default_setting_values() as $mod => $val ) {
				$wp_customize->get_setting( $mod )->default = $val;
			}
		}

		/**
		 * Setup the WordPress core custom header feature.
		 *
		 * @uses shouse_kego_header_style()
		 * @uses shouse_kego_admin_header_style()
		 * @uses shouse_kego_admin_header_image()
		 */
		public function custom_header_setup() {
			add_theme_support( 'custom-header', apply_filters( 'shouse_kego_custom_header_args', array(
				'default-image' => '',
				'header-text'   => false,
				'width'         => 1950,
				'height'        => 500,
				'flex-width'    => true,
				'flex-height'   => true,
			) ) );
		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since  1.0.0
		 */
		public function customize_register( $wp_customize ) {

			// Move background color setting alongside background image.
			$wp_customize->get_control( 'background_color' )->section   = 'background_image';
			$wp_customize->get_control( 'background_color' )->priority  = 20;

			// Change background image section title & priority.
			$wp_customize->get_section( 'background_image' )->title     = __( 'Background', 'shouse_kego' );
			$wp_customize->get_section( 'background_image' )->priority  = 30;

			// Change header image section title & priority.
			$wp_customize->get_section( 'header_image' )->title         = __( 'Header', 'shouse_kego' );
			$wp_customize->get_section( 'header_image' )->priority      = 25;

			// Selective refresh.
			if ( function_exists( 'add_partial' ) ) {
				$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
				$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

				$wp_customize->selective_refresh->add_partial( 'custom_logo', array(
					'selector'        => '.site-branding',
					'render_callback' => array( $this, 'get_site_logo' ),
				) );

				$wp_customize->selective_refresh->add_partial( 'blogname', array(
					'selector'        => '.site-title.beta a',
					'render_callback' => array( $this, 'get_site_name' ),
				) );

				$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
					'selector'        => '.site-description',
					'render_callback' => array( $this, 'get_site_description' ),
				) );
			}

			/**
			 * Custom controls
			 */
			require_once dirname( __FILE__ ) . '/class-shouse_kego-customizer-control-radio-image.php';
			require_once dirname( __FILE__ ) . '/class-shouse_kego-customizer-control-arbitrary.php';

			if ( apply_filters( 'shouse_kego_customizer_more', true ) ) {
				require_once dirname( __FILE__ ) . '/class-shouse_kego-customizer-control-more.php';
			}

			/**
			 * Add the typography section
			 */
			$wp_customize->add_section( 'shouse_kego_typography' , array(
				'title'      			=> __( 'Typography', 'shouse_kego' ),
				'priority'   			=> 45,
			) );

			/**
			 * Heading color
			 */
			$wp_customize->add_setting( 'shouse_kego_heading_color', array(
				'default'           	=> apply_filters( 'shouse_kego_default_heading_color', '#484c51' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shouse_kego_heading_color', array(
				'label'	   				=> __( 'Heading color', 'shouse_kego' ),
				'section'  				=> 'shouse_kego_typography',
				'settings' 				=> 'shouse_kego_heading_color',
				'priority' 				=> 20,
			) ) );

			/**
			 * Text Color
			 */
			$wp_customize->add_setting( 'shouse_kego_text_color', array(
				'default'           	=> apply_filters( 'shouse_kego_default_text_color', '#43454b' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shouse_kego_text_color', array(
				'label'					=> __( 'Text color', 'shouse_kego' ),
				'section'				=> 'shouse_kego_typography',
				'settings'				=> 'shouse_kego_text_color',
				'priority'				=> 30,
			) ) );

			/**
			 * Accent Color
			 */
			$wp_customize->add_setting( 'shouse_kego_accent_color', array(
				'default'           	=> apply_filters( 'shouse_kego_default_accent_color', '#96588a' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shouse_kego_accent_color', array(
				'label'	   				=> __( 'Link / accent color', 'shouse_kego' ),
				'section'  				=> 'shouse_kego_typography',
				'settings' 				=> 'shouse_kego_accent_color',
				'priority' 				=> 40,
			) ) );

			$wp_customize->add_control( new Arbitrary_shouse_kego_Control( $wp_customize, 'shouse_kego_header_image_heading', array(
				'section'  				=> 'header_image',
				'type' 					=> 'heading',
				'label'					=> __( 'Header background image', 'shouse_kego' ),
				'priority' 				=> 6,
			) ) );

			/**
			 * Header Background
			 */
			$wp_customize->add_setting( 'shouse_kego_header_background_color', array(
				'default'           	=> apply_filters( 'shouse_kego_default_header_background_color', '#2c2d33' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shouse_kego_header_background_color', array(
				'label'	   				=> __( 'Background color', 'shouse_kego' ),
				'section'  				=> 'header_image',
				'settings' 				=> 'shouse_kego_header_background_color',
				'priority' 				=> 15,
			) ) );

			/**
			 * Header text color
			 */
			$wp_customize->add_setting( 'shouse_kego_header_text_color', array(
				'default'           	=> apply_filters( 'shouse_kego_default_header_text_color', '#9aa0a7' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shouse_kego_header_text_color', array(
				'label'	   				=> __( 'Text color', 'shouse_kego' ),
				'section'  				=> 'header_image',
				'settings' 				=> 'shouse_kego_header_text_color',
				'priority' 				=> 20,
			) ) );

			/**
			 * Header link color
			 */
			$wp_customize->add_setting( 'shouse_kego_header_link_color', array(
				'default'           	=> apply_filters( 'shouse_kego_default_header_link_color', '#d5d9db' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shouse_kego_header_link_color', array(
				'label'	   				=> __( 'Link color', 'shouse_kego' ),
				'section'  				=> 'header_image',
				'settings' 				=> 'shouse_kego_header_link_color',
				'priority' 				=> 30,
			) ) );

			/**
			 * Footer section
			 */
			$wp_customize->add_section( 'shouse_kego_footer' , array(
				'title'      			=> __( 'Footer', 'shouse_kego' ),
				'priority'   			=> 28,
				'description' 			=> __( 'Customize the look & feel of your website footer.', 'shouse_kego' ),
			) );

			/**
			 * Footer Background
			 */
			$wp_customize->add_setting( 'shouse_kego_footer_background_color', array(
				'default'           	=> apply_filters( 'shouse_kego_default_footer_background_color', '#f0f0f0' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shouse_kego_footer_background_color', array(
				'label'	   				=> __( 'Background color', 'shouse_kego' ),
				'section'  				=> 'shouse_kego_footer',
				'settings' 				=> 'shouse_kego_footer_background_color',
				'priority'				=> 10,
			) ) );

			/**
			 * Footer heading color
			 */
			$wp_customize->add_setting( 'shouse_kego_footer_heading_color', array(
				'default'           	=> apply_filters( 'shouse_kego_default_footer_heading_color', '#494c50' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shouse_kego_footer_heading_color', array(
				'label'	   				=> __( 'Heading color', 'shouse_kego' ),
				'section'  				=> 'shouse_kego_footer',
				'settings' 				=> 'shouse_kego_footer_heading_color',
				'priority'				=> 20,
			) ) );

			/**
			 * Footer text color
			 */
			$wp_customize->add_setting( 'shouse_kego_footer_text_color', array(
				'default'           	=> apply_filters( 'shouse_kego_default_footer_text_color', '#61656b' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shouse_kego_footer_text_color', array(
				'label'	   				=> __( 'Text color', 'shouse_kego' ),
				'section'  				=> 'shouse_kego_footer',
				'settings' 				=> 'shouse_kego_footer_text_color',
				'priority'				=> 30,
			) ) );

			/**
			 * Footer link color
			 */
			$wp_customize->add_setting( 'shouse_kego_footer_link_color', array(
				'default'           	=> apply_filters( 'shouse_kego_default_footer_link_color', '#2c2d33' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shouse_kego_footer_link_color', array(
				'label'	   				=> __( 'Link color', 'shouse_kego' ),
				'section'  				=> 'shouse_kego_footer',
				'settings' 				=> 'shouse_kego_footer_link_color',
				'priority'				=> 40,
			) ) );

			/**
			 * Buttons section
			 */
			$wp_customize->add_section( 'shouse_kego_buttons' , array(
				'title'      			=> __( 'Buttons', 'shouse_kego' ),
				'priority'   			=> 45,
				'description' 			=> __( 'Customize the look & feel of your website buttons.', 'shouse_kego' ),
			) );

			/**
			 * Button background color
			 */
			$wp_customize->add_setting( 'shouse_kego_button_background_color', array(
				'default'           	=> apply_filters( 'shouse_kego_default_button_background_color', '#96588a' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shouse_kego_button_background_color', array(
				'label'	   				=> __( 'Background color', 'shouse_kego' ),
				'section'  				=> 'shouse_kego_buttons',
				'settings' 				=> 'shouse_kego_button_background_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Button text color
			 */
			$wp_customize->add_setting( 'shouse_kego_button_text_color', array(
				'default'           	=> apply_filters( 'shouse_kego_default_button_text_color', '#ffffff' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shouse_kego_button_text_color', array(
				'label'	   				=> __( 'Text color', 'shouse_kego' ),
				'section'  				=> 'shouse_kego_buttons',
				'settings' 				=> 'shouse_kego_button_text_color',
				'priority' 				=> 20,
			) ) );

			/**
			 * Button alt background color
			 */
			$wp_customize->add_setting( 'shouse_kego_button_alt_background_color', array(
				'default'           	=> apply_filters( 'shouse_kego_default_button_alt_background_color', '#2c2d33' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shouse_kego_button_alt_background_color', array(
				'label'	   				=> __( 'Alternate button background color', 'shouse_kego' ),
				'section'  				=> 'shouse_kego_buttons',
				'settings' 				=> 'shouse_kego_button_alt_background_color',
				'priority' 				=> 30,
			) ) );

			/**
			 * Button alt text color
			 */
			$wp_customize->add_setting( 'shouse_kego_button_alt_text_color', array(
				'default'           	=> apply_filters( 'shouse_kego_default_button_alt_text_color', '#ffffff' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shouse_kego_button_alt_text_color', array(
				'label'	   				=> __( 'Alternate button text color', 'shouse_kego' ),
				'section'  				=> 'shouse_kego_buttons',
				'settings' 				=> 'shouse_kego_button_alt_text_color',
				'priority' 				=> 40,
			) ) );

			/**
			 * Layout
			 */
			$wp_customize->add_section( 'shouse_kego_layout' , array(
				'title'      			=> __( 'Layout', 'shouse_kego' ),
				'priority'   			=> 50,
			) );

			$wp_customize->add_setting( 'shouse_kego_layout', array(
				'default'    			=> apply_filters( 'shouse_kego_default_layout', $layout = is_rtl() ? 'left' : 'right' ),
				'sanitize_callback' 	=> 'shouse_kego_sanitize_choices',
			) );

			$wp_customize->add_control( new shouse_kego_Custom_Radio_Image_Control( $wp_customize, 'shouse_kego_layout', array(
				'settings'				=> 'shouse_kego_layout',
				'section'				=> 'shouse_kego_layout',
				'label'					=> __( 'General Layout', 'shouse_kego' ),
				'priority'				=> 1,
				'choices'				=> array(
											'right' => get_template_directory_uri() . '/assets/images/customizer/controls/2cr.png',
											'left'  => get_template_directory_uri() . '/assets/images/customizer/controls/2cl.png',
				),
			) ) );

			/**
			 * More
			 */
			if ( apply_filters( 'shouse_kego_customizer_more', true ) ) {
				$wp_customize->add_section( 'shouse_kego_more' , array(
					'title'      		=> __( 'More', 'shouse_kego' ),
					'priority'   		=> 999,
				) );

				$wp_customize->add_setting( 'shouse_kego_more', array(
					'default'    		=> null,
					'sanitize_callback' => 'sanitize_text_field',
				) );

				$wp_customize->add_control( new More_shouse_kego_Control( $wp_customize, 'shouse_kego_more', array(
					'label'    			=> __( 'Looking for more options?', 'shouse_kego' ),
					'section'  			=> 'shouse_kego_more',
					'settings' 			=> 'shouse_kego_more',
					'priority' 			=> 1,
				) ) );
			}
		}

		/**
		 * Get all of the shouse_kego theme mods.
		 *
		 * @return array $shouse_kego_theme_mods The shouse_kego Theme Mods.
		 */
		public function get_shouse_kego_theme_mods() {
			$shouse_kego_theme_mods = array(
				'background_color'            => shouse_kego_get_content_background_color(),
				'accent_color'                => get_theme_mod( 'shouse_kego_accent_color' ),
				'header_background_color'     => get_theme_mod( 'shouse_kego_header_background_color' ),
				'header_link_color'           => get_theme_mod( 'shouse_kego_header_link_color' ),
				'header_text_color'           => get_theme_mod( 'shouse_kego_header_text_color' ),
				'footer_background_color'     => get_theme_mod( 'shouse_kego_footer_background_color' ),
				'footer_link_color'           => get_theme_mod( 'shouse_kego_footer_link_color' ),
				'footer_heading_color'        => get_theme_mod( 'shouse_kego_footer_heading_color' ),
				'footer_text_color'           => get_theme_mod( 'shouse_kego_footer_text_color' ),
				'text_color'                  => get_theme_mod( 'shouse_kego_text_color' ),
				'heading_color'               => get_theme_mod( 'shouse_kego_heading_color' ),
				'button_background_color'     => get_theme_mod( 'shouse_kego_button_background_color' ),
				'button_text_color'           => get_theme_mod( 'shouse_kego_button_text_color' ),
				'button_alt_background_color' => get_theme_mod( 'shouse_kego_button_alt_background_color' ),
				'button_alt_text_color'       => get_theme_mod( 'shouse_kego_button_alt_text_color' ),
			);

			return apply_filters( 'shouse_kego_theme_mods', $shouse_kego_theme_mods );
		}

		/**
		 * Get Customizer css.
		 *
		 * @see get_shouse_kego_theme_mods()
		 * @return array $styles the css
		 */
		public function get_css() {
			$shouse_kego_theme_mods = $this->get_shouse_kego_theme_mods();
			$brighten_factor       = apply_filters( 'shouse_kego_brighten_factor', 25 );
			$darken_factor         = apply_filters( 'shouse_kego_darken_factor', -25 );

			$styles                = '
			.main-navigation ul li a,
			.site-title a,
			ul.menu li a,
			.site-branding h1 a,
			.site-footer .shouse_kego-handheld-footer-bar a:not(.button),
			button.menu-toggle,
			button.menu-toggle:hover {
				color: ' . $shouse_kego_theme_mods['header_link_color'] . ';
			}

			button.menu-toggle,
			button.menu-toggle:hover {
				border-color: ' . $shouse_kego_theme_mods['header_link_color'] . ';
			}

			.main-navigation ul li a:hover,
			.main-navigation ul li:hover > a,
			.site-title a:hover,
			a.cart-contents:hover,
			.site-header-cart .widget_shopping_cart a:hover,
			.site-header-cart:hover > li > a,
			.site-header ul.menu li.current-menu-item > a {
				color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['header_link_color'], 65 ) . ';
			}

			table th {
				background-color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['background_color'], -7 ) . ';
			}

			table tbody td {
				background-color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['background_color'], -2 ) . ';
			}

			table tbody tr:nth-child(2n) td,
			fieldset,
			fieldset legend {
				background-color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['background_color'], -4 ) . ';
			}

			.site-header,
			.secondary-navigation ul ul,
			.main-navigation ul.menu > li.menu-item-has-children:after,
			.secondary-navigation ul.menu ul,
			.shouse_kego-handheld-footer-bar,
			.shouse_kego-handheld-footer-bar ul li > a,
			.shouse_kego-handheld-footer-bar ul li.search .site-search,
			button.menu-toggle,
			button.menu-toggle:hover {
				background-color: ' . $shouse_kego_theme_mods['header_background_color'] . ';
			}

			p.site-description,
			.site-header,
			.shouse_kego-handheld-footer-bar {
				color: ' . $shouse_kego_theme_mods['header_text_color'] . ';
			}

			.shouse_kego-handheld-footer-bar ul li.cart .count,
			button.menu-toggle:after,
			button.menu-toggle:before,
			button.menu-toggle span:before {
				background-color: ' . $shouse_kego_theme_mods['header_link_color'] . ';
			}

			.shouse_kego-handheld-footer-bar ul li.cart .count {
				color: ' . $shouse_kego_theme_mods['header_background_color'] . ';
			}

			.shouse_kego-handheld-footer-bar ul li.cart .count {
				border-color: ' . $shouse_kego_theme_mods['header_background_color'] . ';
			}

			h1, h2, h3, h4, h5, h6 {
				color: ' . $shouse_kego_theme_mods['heading_color'] . ';
			}

			.widget h1 {
				border-bottom-color: ' . $shouse_kego_theme_mods['heading_color'] . ';
			}

			body,
			.secondary-navigation a,
			.onsale,
			.pagination .page-numbers li .page-numbers:not(.current), .woocommerce-pagination .page-numbers li .page-numbers:not(.current) {
				color: ' . $shouse_kego_theme_mods['text_color'] . ';
			}

			.widget-area .widget a,
			.hentry .entry-header .posted-on a,
			.hentry .entry-header .byline a {
				color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['text_color'], 5 ) . ';
			}

			a  {
				color: ' . $shouse_kego_theme_mods['accent_color'] . ';
			}

			a:focus,
			.button:focus,
			.button.alt:focus,
			.button.added_to_cart:focus,
			.button.wc-forward:focus,
			button:focus,
			input[type="button"]:focus,
			input[type="reset"]:focus,
			input[type="submit"]:focus {
				outline-color: ' . $shouse_kego_theme_mods['accent_color'] . ';
			}

			button, input[type="button"], input[type="reset"], input[type="submit"], .button, .added_to_cart, .widget a.button, .site-header-cart .widget_shopping_cart a.button {
				background-color: ' . $shouse_kego_theme_mods['button_background_color'] . ';
				border-color: ' . $shouse_kego_theme_mods['button_background_color'] . ';
				color: ' . $shouse_kego_theme_mods['button_text_color'] . ';
			}

			button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, .button:hover, .added_to_cart:hover, .widget a.button:hover, .site-header-cart .widget_shopping_cart a.button:hover {
				background-color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['button_background_color'], $darken_factor ) . ';
				border-color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['button_background_color'], $darken_factor ) . ';
				color: ' . $shouse_kego_theme_mods['button_text_color'] . ';
			}

			button.alt, input[type="button"].alt, input[type="reset"].alt, input[type="submit"].alt, .button.alt, .added_to_cart.alt, .widget-area .widget a.button.alt, .added_to_cart, .widget a.button.checkout {
				background-color: ' . $shouse_kego_theme_mods['button_alt_background_color'] . ';
				border-color: ' . $shouse_kego_theme_mods['button_alt_background_color'] . ';
				color: ' . $shouse_kego_theme_mods['button_alt_text_color'] . ';
			}

			button.alt:hover, input[type="button"].alt:hover, input[type="reset"].alt:hover, input[type="submit"].alt:hover, .button.alt:hover, .added_to_cart.alt:hover, .widget-area .widget a.button.alt:hover, .added_to_cart:hover, .widget a.button.checkout:hover {
				background-color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['button_alt_background_color'], $darken_factor ) . ';
				border-color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['button_alt_background_color'], $darken_factor ) . ';
				color: ' . $shouse_kego_theme_mods['button_alt_text_color'] . ';
			}

			.pagination .page-numbers li .page-numbers.current, .woocommerce-pagination .page-numbers li .page-numbers.current {
				background-color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['background_color'], $darken_factor ) . ';
				color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['text_color'], -10 ) . ';
			}

			#comments .comment-list .comment-content .comment-text {
				background-color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['background_color'], -7 ) . ';
			}

			.site-footer {
				background-color: ' . $shouse_kego_theme_mods['footer_background_color'] . ';
				color: ' . $shouse_kego_theme_mods['footer_text_color'] . ';
			}

			.site-footer a:not(.button) {
				color: ' . $shouse_kego_theme_mods['footer_link_color'] . ';
			}

			.site-footer h1, .site-footer h2, .site-footer h3, .site-footer h4, .site-footer h5, .site-footer h6 {
				color: ' . $shouse_kego_theme_mods['footer_heading_color'] . ';
			}

			#order_review {
				background-color: ' . $shouse_kego_theme_mods['background_color'] . ';
			}

			#payment .payment_methods > li .payment_box,
			#payment .place-order {
				background-color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['background_color'], -5 ) . ';
			}

			#payment .payment_methods > li:not(.woocommerce-notice) {
				background-color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['background_color'], -10 ) . ';
			}

			#payment .payment_methods > li:not(.woocommerce-notice):hover {
				background-color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['background_color'], -15 ) . ';
			}

			@media screen and ( min-width: 768px ) {
				.secondary-navigation ul.menu a:hover {
					color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['header_text_color'], $brighten_factor ) . ';
				}

				.secondary-navigation ul.menu a {
					color: ' . $shouse_kego_theme_mods['header_text_color'] . ';
				}

				.site-header-cart .widget_shopping_cart,
				.main-navigation ul.menu ul.sub-menu,
				.main-navigation ul.nav-menu ul.children {
					background-color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['header_background_color'], -15 ) . ';
				}

				.site-header-cart .widget_shopping_cart .buttons,
				.site-header-cart .widget_shopping_cart .total {
					background-color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['header_background_color'], -10 ) . ';
				}

				.site-header {
					border-bottom-color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['header_background_color'], -15 ) . ';
				}
			}';

			return apply_filters( 'shouse_kego_customizer_css', $styles );
		}

		/**
		 * Get Customizer css associated with WooCommerce.
		 *
		 * @see get_shouse_kego_theme_mods()
		 * @return array $woocommerce_styles the WooCommerce css
		 */
		public function get_woocommerce_css() {
			$shouse_kego_theme_mods = $this->get_shouse_kego_theme_mods();
			$brighten_factor       = apply_filters( 'shouse_kego_brighten_factor', 25 );
			$darken_factor         = apply_filters( 'shouse_kego_darken_factor', -25 );

			$woocommerce_styles    = '
			a.cart-contents,
			.site-header-cart .widget_shopping_cart a {
				color: ' . $shouse_kego_theme_mods['header_link_color'] . ';
			}

			table.cart td.product-remove,
			table.cart td.actions {
				border-top-color: ' . $shouse_kego_theme_mods['background_color'] . ';
			}

			.woocommerce-tabs ul.tabs li.active a,
			ul.products li.product .price,
			.onsale,
			.widget_search form:before,
			.widget_product_search form:before {
				color: ' . $shouse_kego_theme_mods['text_color'] . ';
			}

			.woocommerce-breadcrumb a,
			a.woocommerce-review-link,
			.product_meta a {
				color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['text_color'], 5 ) . ';
			}

			.onsale {
				border-color: ' . $shouse_kego_theme_mods['text_color'] . ';
			}

			.star-rating span:before,
			.quantity .plus, .quantity .minus,
			p.stars a:hover:after,
			p.stars a:after,
			.star-rating span:before,
			#payment .payment_methods li input[type=radio]:first-child:checked+label:before {
				color: ' . $shouse_kego_theme_mods['accent_color'] . ';
			}

			.widget_price_filter .ui-slider .ui-slider-range,
			.widget_price_filter .ui-slider .ui-slider-handle {
				background-color: ' . $shouse_kego_theme_mods['accent_color'] . ';
			}

			.order_details {
				background-color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['background_color'], -7 ) . ';
			}

			.order_details > li {
				border-bottom: 1px dotted ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['background_color'], -28 ) . ';
			}

			.order_details:before,
			.order_details:after {
				background: -webkit-linear-gradient(transparent 0,transparent 0),-webkit-linear-gradient(135deg,' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['background_color'], -7 ) . ' 33.33%,transparent 33.33%),-webkit-linear-gradient(45deg,' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['background_color'], -7 ) . ' 33.33%,transparent 33.33%)
			}

			p.stars a:before,
			p.stars a:hover~a:before,
			p.stars.selected a.active~a:before {
				color: ' . $shouse_kego_theme_mods['text_color'] . ';
			}

			p.stars.selected a.active:before,
			p.stars:hover a:before,
			p.stars.selected a:not(.active):before,
			p.stars.selected a.active:before {
				color: ' . $shouse_kego_theme_mods['accent_color'] . ';
			}

			.single-product div.product .woocommerce-product-gallery .woocommerce-product-gallery__trigger {
				background-color: ' . $shouse_kego_theme_mods['button_background_color'] . ';
				color: ' . $shouse_kego_theme_mods['button_text_color'] . ';
			}

			.single-product div.product .woocommerce-product-gallery .woocommerce-product-gallery__trigger:hover {
				background-color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['button_background_color'], $darken_factor ) . ';
				border-color: ' . shouse_kego_adjust_color_brightness( $shouse_kego_theme_mods['button_background_color'], $darken_factor ) . ';
				color: ' . $shouse_kego_theme_mods['button_text_color'] . ';
			}

			.button.loading {
				color: ' . $shouse_kego_theme_mods['button_background_color'] . ';
			}

			.button.loading:hover {
				background-color: ' . $shouse_kego_theme_mods['button_background_color'] . ';
			}

			.button.loading:after {
				color: ' . $shouse_kego_theme_mods['button_text_color'] . ';
			}

			@media screen and ( min-width: 768px ) {
				.site-header-cart .widget_shopping_cart,
				.site-header .product_list_widget li .quantity {
					color: ' . $shouse_kego_theme_mods['header_text_color'] . ';
				}
			}';

			return apply_filters( 'shouse_kego_customizer_woocommerce_css', $woocommerce_styles );
		}

		/**
		 * Assign shouse_kego styles to individual theme mods.
		 *
		 * @return void
		 */
		public function set_shouse_kego_style_theme_mods() {
			set_theme_mod( 'shouse_kego_styles', $this->get_css() );
			set_theme_mod( 'shouse_kego_woocommerce_styles', $this->get_woocommerce_css() );
		}

		/**
		 * Add CSS in <head> for styles handled by the theme customizer
		 * If the Customizer is active pull in the raw css. Otherwise pull in the prepared theme_mods if they exist.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function add_customizer_css() {
			$shouse_kego_styles             = get_theme_mod( 'shouse_kego_styles' );
			$shouse_kego_woocommerce_styles = get_theme_mod( 'shouse_kego_woocommerce_styles' );

			if ( is_customize_preview() || ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) || ( false === $shouse_kego_styles && false === $shouse_kego_woocommerce_styles ) ) {
				wp_add_inline_style( 'shouse_kego-style', $this->get_css() );
				wp_add_inline_style( 'shouse_kego-woocommerce-style', $this->get_woocommerce_css() );
			} else {
				wp_add_inline_style( 'shouse_kego-style', get_theme_mod( 'shouse_kego_styles' ) );
				wp_add_inline_style( 'shouse_kego-woocommerce-style', get_theme_mod( 'shouse_kego_woocommerce_styles' ) );
			}
		}

		/**
		 * Layout classes
		 * Adds 'right-sidebar' and 'left-sidebar' classes to the body tag
		 *
		 * @param  array $classes current body classes.
		 * @return string[]          modified body classes
		 * @since  1.0.0
		 */
		public function layout_class( $classes ) {
			$left_or_right = get_theme_mod( 'shouse_kego_layout' );

			$classes[] = $left_or_right . '-sidebar';

			return $classes;
		}

		/**
		 * Add CSS for custom controls
		 *
		 * This function incorporates CSS from the Kirki Customizer Framework
		 *
		 * The Kirki Customizer Framework, Copyright Aristeides Stathopoulos (@aristath),
		 * is licensed under the terms of the GNU GPL, Version 2 (or later)
		 *
		 * @link https://github.com/reduxframework/kirki/
		 * @since  1.5.0
		 */
		public function customizer_custom_control_css() {
			?>
			<style>
			.customize-control-radio-image input[type=radio] {
				display: none;
			}

			.customize-control-radio-image label {
				display: block;
				width: 48%;
				float: left;
				margin-right: 4%;
			}

			.customize-control-radio-image label:nth-of-type(2n) {
				margin-right: 0;
			}

			.customize-control-radio-image img {
				opacity: .5;
			}

			.customize-control-radio-image input[type=radio]:checked + label img,
			.customize-control-radio-image img:hover {
				opacity: 1;
			}

			</style>
			<?php
		}

		/**
		 * Get site logo.
		 *
		 * @since 2.1.5
		 * @return string
		 */
		public function get_site_logo() {
			return shouse_kego_site_title_or_logo( false );
		}

		/**
		 * Get site name.
		 *
		 * @since 2.1.5
		 * @return string
		 */
		public function get_site_name() {
			return get_bloginfo( 'name', 'display' );
		}

		/**
		 * Get site description.
		 *
		 * @since 2.1.5
		 * @return string
		 */
		public function get_site_description() {
			return get_bloginfo( 'description', 'display' );
		}
	}

endif;

return new shouse_kego_Customizer();
