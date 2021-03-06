<?php
/**
 * WC Quick View Template Gallery Class
 *
 * Class Function into woocommerce plugin
 *
 * Table Of Contents
 *
 * wc_dynamic_gallery_display()
 * wc_dynamic_gallery_preview()
 */
class WC_Quick_View_Template_Gallery_Class
{
	public function __construct() {
		$quick_view_ultimate_popup_content = get_option('quick_view_ultimate_popup_content', 'custom_template' );
		if ( 'custom_template' == $quick_view_ultimate_popup_content ) {
			add_action( 'wp_enqueue_scripts', array ( $this, 'frontend_register_scripts') );
		}
	}

	public function frontend_register_scripts() {
		wp_register_style( 'a3-dgallery-style', WC_QUICK_VIEW_ULTIMATE_JS_URL . '/mygallery/jquery.a3-dgallery.css', array(), WC_QUICK_VIEW_ULTIMATE_VERSION );
		wp_register_script( 'a3-dgallery-script', WC_QUICK_VIEW_ULTIMATE_JS_URL . '/mygallery/jquery.a3-dgallery.js', array( 'jquery' ), WC_QUICK_VIEW_ULTIMATE_VERSION, true );
	}

	public function wc_dynamic_gallery_display( $product_id = 0, $next_previous_loaded = 'no' ) {
		/**
		 * Single Product Image
		 */
		global $wc_qv_fonts_face;
		global $quick_view_template_gallery_style_settings;
		global $quick_view_template_gallery_thumbnails_settings;

		$global_stop_scroll_1image = $quick_view_template_gallery_style_settings['stop_scroll_1image'];
		$enable_scroll             = 'true';
		$display_back_and_forward  = 'true';
		$no_image_uri              = $this->get_no_image_uri();

		$get_again = false;

		// Get gallery of this product
		$dgallery_ids = $this->get_gallery_ids( $product_id );
		if ( ! is_array( $dgallery_ids ) ) {
			$dgallery_ids = array();
		}

		$main_dgallery       = array();
		$ogrinal_product_id  = $product_id;
		$product_id          .= '_' . rand( 100, 10000 );
		$lightbox_class      = '';
		$thumbs_list_class	 = '';
		$max_height          = 0;
		$width_of_max_height = 0;

		// Process to get max height and width of max height for set gallery container
		if ( count( $dgallery_ids ) > 0 ) {
			$lightbox_class = 'lightbox';

			// Assign image data into main gallery array
			foreach ( $dgallery_ids as $img_id ) {
				// Check if image id is existed on main gallery then just use it again for decrease query
				if ( isset( $main_dgallery[$img_id] ) ) {
					continue;
				}

				$image_data            = get_post( $img_id );
				$large_image_attribute = wp_get_attachment_image_src( $img_id, 'large' );
				$thumb_image_attribute = wp_get_attachment_image_src( $img_id, 'shop_thumbnail' );

				$alt                   = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
				$large_srcset          = '';
				$large_sizes           = '';
				$thumb_srcset          = '';
				$thumb_sizes           = '';

				if ( function_exists( 'wp_get_attachment_image_srcset' ) ) {
					$large_srcset = wp_get_attachment_image_srcset( $img_id, 'large' );
					$thumb_srcset = wp_get_attachment_image_srcset( $img_id, 'shop_thumbnail' );
				}
				if ( function_exists( 'wp_get_attachment_image_sizes' ) ) {
					$large_sizes = wp_get_attachment_image_sizes( $img_id, 'large' );
					$thumb_sizes = wp_get_attachment_image_sizes( $img_id, 'shop_thumbnail' );
				}

				$main_dgallery[$img_id] = array (
						'caption_text' => $image_data->post_excerpt,
						'alt_text'     => $alt,
						'thumb'        => array (
								'url'        => $thumb_image_attribute[0],
								'width'      => $thumb_image_attribute[1],
								'height'     => $thumb_image_attribute[2],
								'img_srcset' => $thumb_srcset,
								'img_sizes'  => $thumb_sizes,
							),
						'large'        => array (
								'url'        => $large_image_attribute[0],
								'width'      => $large_image_attribute[1],
								'height'     => $large_image_attribute[2],
								'img_srcset' => $large_srcset,
								'img_sizes'  => $large_sizes,
							),
					);

				$height_current = $large_image_attribute[2];
				if ( $height_current > $max_height ) {
					$max_height          = $height_current;
					$width_of_max_height = $large_image_attribute[1];
				}
			}
		}
		?>

		<?php if ( ! $get_again ) { ?>
		<div class="gallery_container">
		<?php } ?>

		<div class="product_gallery">
            <?php
			$woo_dg_width_type   = '%';
			$gallery_height_type = $quick_view_template_gallery_style_settings['gallery_height_type'];
			$g_width             = '100%';

			// Set height for when gallery is responsive wide or dynamic height
			if ( 'px' != $woo_dg_width_type || 'dynamic' == $gallery_height_type ) {
				if ( $max_height > 0 ) {
					$g_height = false;
			?>
	            <script type="text/javascript">
				(function($) {
					$(document).ready(function() {
						a3revWCDynamicGallery_<?php echo $product_id; ?> = {

							setHeightProportional: function () {
								var image_wrapper_width  = parseInt( $( '#gallery_<?php echo $product_id; ?>' ).find('.a3dg-image-wrapper').outerWidth() );
								var width_of_max_height  = parseInt(<?php echo $width_of_max_height; ?>);
								var image_wrapper_height = parseInt(<?php echo $max_height; ?>);
								console.log( image_wrapper_width );
								if( width_of_max_height > image_wrapper_width ) {
									var ratio = width_of_max_height / image_wrapper_width;
									image_wrapper_height = parseInt(<?php echo $max_height; ?>) / ratio;
								}
								$( '#gallery_<?php echo $product_id; ?>' ).find('.a3dg-image-wrapper').css({ height: image_wrapper_height });
							}
						}

						<?php if ( $next_previous_loaded == 'yes' ) { ?>
							a3revWCDynamicGallery_<?php echo $product_id; ?>.setHeightProportional();
						<?php } else { ?>
						setTimeout( function() {
							a3revWCDynamicGallery_<?php echo $product_id; ?>.setHeightProportional();
						}, 500 );
						<?php } ?>

						$( window ).resize(function() {
							a3revWCDynamicGallery_<?php echo $product_id; ?>.setHeightProportional();
						});
					});
				})(jQuery);
				</script>
			<?php
				} else {
					$g_height = 138;
				}
			}

			$shop_thumbnail  = wc_get_image_size( 'shop_thumbnail' );
			$g_thumb_width   = $shop_thumbnail['width'];
			$g_thumb_height  = $shop_thumbnail['height'];
			$thumb_show_type = $quick_view_template_gallery_thumbnails_settings['thumb_show_type'];
			$thumb_columns   = $quick_view_template_gallery_thumbnails_settings['thumb_columns'];
			$thumb_spacing   = $quick_view_template_gallery_thumbnails_settings['thumb_spacing'];
			if ( 'static' == $thumb_show_type ) {
				$thumbs_list_class = 'a3dg-thumbs-static';
			}

			$g_auto               = $quick_view_template_gallery_style_settings['product_gallery_auto_start'];
			$g_speed              = $quick_view_template_gallery_style_settings['product_gallery_speed'];
			$g_effect             = $quick_view_template_gallery_style_settings['product_gallery_effect'];
			$g_animation_speed    = $quick_view_template_gallery_style_settings['product_gallery_animation_speed'];
			$product_gallery_nav  = $quick_view_template_gallery_style_settings['product_gallery_nav'];
			$main_margin_left     = $quick_view_template_gallery_style_settings['main_margin_left'];
			$main_margin_right    = $quick_view_template_gallery_style_settings['main_margin_right'];
			$navbar_margin_left   = $quick_view_template_gallery_style_settings['navbar_margin_left'];
			$navbar_margin_right  = $quick_view_template_gallery_style_settings['navbar_margin_right'];
			$lazy_load_scroll     = $quick_view_template_gallery_style_settings['lazy_load_scroll'];
			$enable_gallery_thumb = $quick_view_template_gallery_thumbnails_settings['enable_gallery_thumb'];

			$display_ctrl = '';
			if ( 'no' == $product_gallery_nav ) {
				$display_ctrl = 'display:none !important;';
			}

			$popup_gallery     = 'deactivate';
			$hide_thumb_1image = $quick_view_template_gallery_thumbnails_settings['hide_thumb_1image'];
			$start_label       = __('START SLIDESHOW', 'wooquickview');
			$stop_label        = __('STOP SLIDESHOW', 'wooquickview');

			if ( 'yes' == $global_stop_scroll_1image && count( $dgallery_ids ) <= 1 ) {
				$enable_scroll            = 'false';
				$display_back_and_forward = 'false';
				$start_label              = '';
				$stop_label               = '';
			}

			if ( 'static' == $thumb_show_type ) {
				$display_back_and_forward = 'false';
			}

			$zoom_label = __('ZOOM +', 'wooquickview');
			if ( 'deactivate' == $popup_gallery ) {
				$zoom_label     = '';
				$lightbox_class = '';
			}

			if ( '' == $lightbox_class && 'false' == $enable_scroll ) {
				$display_ctrl = 'display:none !important;';
			}

			echo '<style>
				.a3-dgallery .a3dg-image-wrapper {
					'. ( ( $g_height != false ) ? 'height: '. $g_height.'px;' : '' ) .'
				}
				.product_gallery #gallery_'.$product_id.' .a3dg-navbar-control {
					'.$display_ctrl.';
					width: calc( 100% - '.( $navbar_margin_left + $navbar_margin_right ).'px );
				}';

				if ( 'yes' == $product_gallery_nav ) {
					echo '.a3dg-image-wrapper .slide-ctrl {
						display: none !important;
					}';
				}

				if ( 'no' == $lazy_load_scroll ) {
					echo '.a3-dgallery .lazy-load {
						display: none !important;
					}';
				}

				if ( 'yes' == $hide_thumb_1image && count( $dgallery_ids ) <= 1 ) {
					echo '#gallery_'.$product_id.' .a3dg-nav {
						display:none;
					}
					.woocommerce #gallery_'.$product_id.' .images {
						margin-bottom: 15px;
					}';
				}

				if ( 'yes' == $global_stop_scroll_1image && count( $dgallery_ids ) <= 1 ) {
					echo '#gallery_'.$product_id.' .a3dg-navbar-control {
						width: calc( 50% - '.( ( $navbar_margin_left + $navbar_margin_right ) / 2 ).'px ) !important;
					}
					#gallery_'.$product_id.' .a3dg-navbar-control .icon_zoom {
						width: 100%;
					}
					#gallery_'.$product_id.' .a3dg-navbar-separator,
					#gallery_'.$product_id.' .slide-ctrl {
						display: none;
					}';
				}
				if ( 'deactivate' == $popup_gallery ) {
					echo '.a3-dgallery .a3dg-image-wrapper .a3dg-image img {
						cursor: default;
					}
					#gallery_'.$product_id.' .a3dg-navbar-control {
						width: calc( 50% - '.( ( $navbar_margin_left + $navbar_margin_right ) / 2 ).'px ) !important;
						float: right;
					}
					#gallery_'.$product_id.' .a3dg-navbar-control .slide-ctrl {
						width: 100%;
					}
					#gallery_'.$product_id.' .a3dg-navbar-separator,
					#gallery_'.$product_id.' .icon_zoom {
						display: none;
					}';
				}

				if ( 'no' == $enable_gallery_thumb ) {
					echo '.a3dg-nav {
						display:none;
						height:1px;
					}
					.woocommerce .images {
						margin-bottom: 15px;
					}';
				}

			echo '
			</style>';

			echo '<script type ="text/javascript">
				jQuery(document).ready(function() {
					var settings_defaults_'.$product_id.' = { loader_image: "'.WC_QUICK_VIEW_ULTIMATE_JS_URL.'/mygallery/loader.gif",
						start_at_index: 0,
						gallery_ID: "'.$product_id.'",
						lightbox_class: "'.$lightbox_class.'",
						description_wrapper: false,
						thumb_opacity: 0.5,
						animate_first_image: false,
						animation_speed: '.$g_animation_speed.'000,
						width: false,
						height: false,
						display_next_and_prev: '.$enable_scroll.',
						display_back_and_forward: '.$display_back_and_forward.',
						scroll_jump: 0,
						slideshow: {
							enable: '.$enable_scroll.',
							autostart: '.$g_auto.',
							speed: '.$g_speed.'000,
							start_label: "'.$start_label.'",
							stop_label: "'.$stop_label.'",
							zoom_label: "'.$zoom_label.'",
							stop_on_scroll: true,
							countdown_prefix: "(",
							countdown_sufix: ")",
							onStart: false,
							onStop: false
						},
						effect: "'.$g_effect.'",
						enable_keyboard_move: true,
						cycle: true,
						callbacks: {
						init: false,
						afterImageVisible: false,
						beforeImageVisible: false
					}
				};';

			if ( $next_previous_loaded == 'yes' ) {
				echo '
				jQuery("#gallery_'.$product_id.'").adGallery(settings_defaults_'.$product_id.');';
			} else {
				echo '
				setTimeout( function() {
                	jQuery("#gallery_'.$product_id.'").adGallery(settings_defaults_'.$product_id.');
				}, 1000 );';
			}

			echo '
			});

            </script>';

            echo '<img style="width: 0px ! important; height: 0px ! important; display: none ! important; position: absolute;" src="'.WC_QUICK_VIEW_ULTIMATE_IMAGES_URL . '/blank.gif">';

			echo '<div id="gallery_'.$product_id.'"
			class="a3-dgallery"
			data-height_type="'. esc_attr( $gallery_height_type ).'"
			data-show_navbar_control="'. esc_attr( $product_gallery_nav ) .'"
			data-show_thumb="'. esc_attr( $enable_gallery_thumb ) .'"
			data-hide_one_thumb="'. esc_attr( $hide_thumb_1image ) .'"
			data-thumb_show_type="'. esc_attr( $thumb_show_type ) .'"
			data-thumb_visible="'. esc_attr( $thumb_columns ) .'"
			data-thumb_spacing="'. esc_attr( $thumb_spacing ) .'"
			style="width: 100%; max-width: '.$g_width.';">
				<div class="a3dg-image-wrapper" style="width: calc(100% - '.( (int) $main_margin_left + (int) $main_margin_right ).'px); ' . ( ( $g_height != false ) ? 'height: '.$g_height.'px;' : '' ) . '"></div>
				<div class="lazy-load"></div>
				<div style="clear: both"></div>
				<div class="a3dg-navbar-control"><div class="a3dg-navbar-separator"></div></div>
				<div style="clear: both"></div>
				<div class="a3dg-nav">
					<div class="a3dg-thumbs '.$thumbs_list_class.'">
						<ul class="a3dg-thumb-list">';

                        if ( count( $dgallery_ids ) > 0 ) {

							$current_color_text = '';

							$idx    = 0;

							foreach ( $dgallery_ids as $img_id ) {
								if ( ! isset( $main_dgallery[$img_id] ) ) {
									continue;
								}

								// Get image data from main gallery array
								$gallery_item = $main_dgallery[$img_id];

								$li_class        = '';
								if ( 'static' == $thumb_show_type ) {
									if ( $idx % $thumb_columns == 0 ) {
										$li_class    = 'first_item';
									} elseif ( ( $idx % $thumb_columns + 1 ) == $thumb_columns ) {
										$li_class    = 'last_item';
									}
								} else {
									if ( $idx == 0 ) {
										$li_class    = 'first_item';
									} elseif ( $idx == count( $dgallery_ids ) - 1 ) {
										$li_class    = 'last_item';
									}
								}

								$image_large_url = $gallery_item['large']['url'];
								$image_thumb_url = $gallery_item['thumb']['url'];

								$thumb_height    = $g_thumb_height;
								$thumb_width     = $g_thumb_width;
								$width_old       = $gallery_item['thumb']['width'];
								$height_old      = $gallery_item['thumb']['height'];

								if ( $width_old > $g_thumb_width || $height_old > $g_thumb_height ) {
									if ( $height_old > $g_thumb_height && $g_thumb_height > 0 ) {
										$factor       = ($height_old / $g_thumb_height);
										$thumb_height = $g_thumb_height;
										$thumb_width  = $width_old / $factor;
									}
									if ( $thumb_width > $g_thumb_width && $g_thumb_width > 0 ) {
										$factor       = ($width_old / $g_thumb_width);
										$thumb_height = $height_old / $factor;
										$thumb_width  = $g_thumb_width;
									} elseif ( $thumb_width == $g_thumb_width && $width_old > $g_thumb_width && $g_thumb_width > 0 ) {
										$factor       = ($width_old / $g_thumb_width);
										$thumb_height = $height_old / $factor;
										$thumb_width  = $g_thumb_width;
									}
								} else {
									$thumb_height = $height_old;
									$thumb_width = $width_old;
								}

								echo '<li class="'.$li_class.'">';
								echo '<a alt="'. esc_attr( $gallery_item['alt_text'] ).'" class="gallery_product_'.$product_id.' gallery_product_'.$product_id.'_'.$idx.'" title="'. esc_attr( $gallery_item['caption_text'] ).'" rel="gallery_product_'.$product_id.'" href="'.$image_large_url.'">';
								echo '<img
								org-width="'. esc_attr( $gallery_item['large']['width'] ).'"
								org-height="'. esc_attr( $gallery_item['large']['height'] ).'"
								org-sizes="'. esc_attr( $gallery_item['large']['img_sizes'] ).'"
								org-srcset="'. esc_attr( $gallery_item['large']['img_srcset'] ).'"
								sizes="'. esc_attr( $gallery_item['thumb']['img_sizes'] ) .'"
								srcset="'. esc_attr( $gallery_item['thumb']['img_srcset'] ).'"
								idx="'.$idx.'"
								src="'.$image_thumb_url.'"
								alt="'. esc_attr( $gallery_item['alt_text'] ).'"
								data-caption="'. esc_attr( $gallery_item['caption_text'] ).'"
								class="image'.$idx.'"
								width="'.$thumb_width.'"
								height="'.$thumb_height.'">';
								echo '</a>';
								echo '</li>';

								$idx++;
							}

						} else {
							echo '<li>';
							echo '<a class="" rel="gallery_product_'.$product_id.'" href="'.$no_image_uri.'">';
							echo '<img org-width="" org-height="" sizes="" srcset="" src="'.$no_image_uri.'" class="image" alt="">';
							echo '</a>';
							echo '</li>';
						}

						echo '</ul>

					</div>
				</div>
			</div>';
		?>
		</div>

		<?php if ( ! $get_again ) { ?>
		</div>
		<?php } ?>
	<?php
	}

	public function get_no_image_uri() {
		$no_image_uri = apply_filters( 'wc_dg_no_image_uri', WC_QUICK_VIEW_ULTIMATE_JS_URL . '/mygallery/no-image.png' );

		return $no_image_uri;
	}

	public function get_gallery_ids( $post_id = 0 ) {

		if ( $post_id < 1 ) return array();

		$have_gallery_ids = false;

		// Use the WooCommerce Default Gallery
		$dgallery_ids = get_post_meta( $post_id, '_product_image_gallery', true );
		if ( ! empty( $dgallery_ids ) && '' != trim( $dgallery_ids ) ) {
			$dgallery_ids = explode( ',', $dgallery_ids );

			if ( count( $dgallery_ids ) > 0 ) {
				$have_gallery_ids = true;
			}
		}

		if ( $have_gallery_ids ) {

			foreach ( $dgallery_ids as $img_id ) {
				// Remove image id if it is not image
				if ( ! wp_attachment_is_image( $img_id ) ) {
					$dgallery_ids = array_diff( $dgallery_ids, array( $img_id ) );
				}
			}

			if ( count( $dgallery_ids ) > 0 ) {
				return $dgallery_ids;
			}

		}

		// set dgallery_ids to empty array if don't have Woo Default Gallery
		$dgallery_ids = array();

		$featured_img_id = (int) get_post_meta( $post_id, '_thumbnail_id', true );
		if ( ! empty( $featured_img_id ) && $featured_img_id > 0 ) {
			$dgallery_ids[] = $featured_img_id;
		}

		$attached_images = (array) get_posts( array(
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'numberposts'    => -1,
			'post_status'    => null,
			'post_parent'    => $post_id,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'exclude'        => array( $featured_img_id ),
		) );

		if ( is_array( $attached_images ) && count( $attached_images ) > 0 ) {
			foreach ( $attached_images as $item_thumb ) {
				$is_excluded   = get_post_meta( $item_thumb->ID, '_woocommerce_exclude_image', true );

				// Don't get if this image is excluded on main gallery
				if ( 1 == $is_excluded ) continue;

				$dgallery_ids[]    = $item_thumb->ID;
			}
		}

		return $dgallery_ids;
	}
}

global $wc_quick_view_template_gallery_class;
$wc_quick_view_template_gallery_class = new WC_Quick_View_Template_Gallery_Class();

?>
