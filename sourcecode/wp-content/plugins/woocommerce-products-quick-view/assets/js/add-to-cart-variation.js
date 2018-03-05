;(function ( $, window, document, undefined ) {

    /**
     * Stores a default attribute for an element so it can be reset later
     */
    $.fn.qv_wc_set_variation_attr = function( attr, value ) {
        if ( undefined === this.attr( 'data-o_' + attr ) ) {
            this.attr( 'data-o_' + attr, ( ! this.attr( attr ) ) ? '' : this.attr( attr ) );
        }
        if ( false === value ) {
            this.removeAttr( attr );
        } else {
            this.attr( attr, value );
        }
    };

    /**
     * Reset a default attribute for an element so it can be reset later
     */
    $.fn.qv_wc_reset_variation_attr = function( attr ) {
        if ( undefined !== this.attr( 'data-o_' + attr ) ) {
            this.attr( attr, this.attr( 'data-o_' + attr ) );
        }
    };

    /**
     * Reset the slide position if the variation has a different image than the current one
     */
    $.fn.qv_wc_maybe_trigger_slide_position_reset = function( variation ) {
        var $form                = $( this ),
            $product             = $form.closest( '.product' ),
            $product_gallery     = $product.find( '.images' ),
            reset_slide_position = false,
            new_image_id = ( variation && variation.image_id ) ? variation.image_id : '';

        if ( $form.attr( 'current-image' ) !== new_image_id ) {
            reset_slide_position = true;
        }

        $form.attr( 'current-image', new_image_id );

        if ( reset_slide_position ) {
            $product_gallery.trigger( 'woocommerce_gallery_reset_slide_position' );
        }
    };

    /**
     * Sets product images for the chosen variation
     */
    $.fn.qv_wc_variations_image_update = function( variation ) {
        var $form             = this,
            $product          = $form.closest( '.quick_view_popup_container_inner' ),
            $product_gallery  = $product.find( '.images' ),
            $gallery_nav      = $product.find( '.flex-control-nav' ),
            $gallery_img      = $gallery_nav.find( 'li:eq(0) img' ),
            $product_img_wrap = $product_gallery.find( '.woocommerce-product-gallery__image, .woocommerce-product-gallery__image--placeholder' ).eq( 0 ),
            $product_img      = $product_img_wrap.find( '.wp-post-image' ),
            $product_link     = $product_img_wrap.find( 'a' ).eq( 0 );

        if ( variation && variation.image && variation.image.src && variation.image.src.length > 1 ) {
            if ( $gallery_nav.find( 'li img[src="' + variation.image.thumb_src + '"]' ).length > 0 ) {
                $gallery_nav.find( 'li img[src="' + variation.image.thumb_src + '"]' ).trigger( 'click' );
                $form.attr( 'current-image', variation.image_id );
                return;
            } else {
                $product_img.qv_wc_set_variation_attr( 'src', variation.image.src );
                $product_img.qv_wc_set_variation_attr( 'height', variation.image.src_h );
                $product_img.qv_wc_set_variation_attr( 'width', variation.image.src_w );
                $product_img.qv_wc_set_variation_attr( 'srcset', variation.image.srcset );
                $product_img.qv_wc_set_variation_attr( 'sizes', variation.image.sizes );
                $product_img.qv_wc_set_variation_attr( 'title', variation.image.title );
                $product_img.qv_wc_set_variation_attr( 'alt', variation.image.alt );
                $product_img.qv_wc_set_variation_attr( 'data-src', variation.image.full_src );
                $product_img.qv_wc_set_variation_attr( 'data-large_image', variation.image.full_src );
                $product_img.qv_wc_set_variation_attr( 'data-large_image_width', variation.image.full_src_w );
                $product_img.qv_wc_set_variation_attr( 'data-large_image_height', variation.image.full_src_h );
                $product_img_wrap.qv_wc_set_variation_attr( 'data-thumb', variation.image.src );
                $gallery_img.qv_wc_set_variation_attr( 'src', variation.image.thumb_src );
                $product_link.qv_wc_set_variation_attr( 'href', variation.image.full_src );
            }
        } else {
            $product_img.qv_wc_reset_variation_attr( 'src' );
            $product_img.qv_wc_reset_variation_attr( 'width' );
            $product_img.qv_wc_reset_variation_attr( 'height' );
            $product_img.qv_wc_reset_variation_attr( 'srcset' );
            $product_img.qv_wc_reset_variation_attr( 'sizes' );
            $product_img.qv_wc_reset_variation_attr( 'title' );
            $product_img.qv_wc_reset_variation_attr( 'alt' );
            $product_img.qv_wc_reset_variation_attr( 'data-src' );
            $product_img.qv_wc_reset_variation_attr( 'data-large_image' );
            $product_img.qv_wc_reset_variation_attr( 'data-large_image_width' );
            $product_img.qv_wc_reset_variation_attr( 'data-large_image_height' );
            $product_img_wrap.qv_wc_reset_variation_attr( 'data-thumb' );
            $gallery_img.qv_wc_reset_variation_attr( 'src' );
            $product_link.qv_wc_reset_variation_attr( 'href' );
        }

        window.setTimeout( function() {
            $( window ).trigger( 'resize' );
            $form.qv_wc_maybe_trigger_slide_position_reset( variation );
            $product_gallery.trigger( 'woocommerce_gallery_init_zoom' );
        }, 20 );
    }

})( jQuery, window, document );

jQuery(document).ready(function($) {
    
	// Reset buttons
	$('.quick_view_reset_variations').on( 'click', function(){
		$('.quick_view_table_variations select').val('').change();
        $(this).css('visibility','hidden');
		return false;
	});

	//check if two arrays of attributes match
    function variations_match(attrs1, attrs2) {
        var match = true;
        for (name in attrs1) {
            var val1 = attrs1[name];
            var val2 = attrs2[name];

            if ( val1 !== undefined && val2 !== undefined && val1.length != 0 && val2.length != 0 && val1 != val2 ) {
                match = false;
            }
        }

        return match;
    }

    //search for matching variations for given set of attributes
    function find_matching_variations( product_variations, settings) {
        var matching = [];

        for (var i = 0; i < product_variations.length; i++) {
        	var variation = product_variations[i];
        	var variation_id = variation.variation_id;

			if(variations_match(variation.attributes, settings)) {
                matching.push(variation);
            }
        }
        return matching;
    }

    //disable option fields that are unavaiable for current set of attributes
    function update_variation_values(variations) {

        // Loop through selects and disable/enable options based on selections
        $('.quick_view_table_variations select').each(function( index, el ){

            var current_attr_name, current_attr_select = $( el ),
                    show_option_none                       = $( el ).data( 'show_option_none' ),
                    option_gt_filter                       = 'no' === show_option_none ? '' : ':gt(0)';

            // Reset options
            if ( ! current_attr_select.data( 'attribute_options' ) ) {
                current_attr_select.data( 'attribute_options', current_attr_select.find( 'option' + option_gt_filter ).get() );
            }

            current_attr_select.find( 'option' + option_gt_filter ).remove();
            current_attr_select.append( current_attr_select.data( 'attribute_options' ) );
            current_attr_select.find( 'option' + option_gt_filter ).removeClass( 'attached' );
            current_attr_select.find( 'option' + option_gt_filter ).removeClass( 'enabled' );
            current_attr_select.find( 'option' + option_gt_filter ).removeAttr( 'disabled' );

            // Get name from data-attribute_name, or from input name if it doesn't exist
            if ( typeof( current_attr_select.data( 'attribute_name' ) ) !== 'undefined' ) {
                current_attr_name = current_attr_select.data( 'attribute_name' );
            } else {
                current_attr_name = current_attr_select.attr( 'name' );
            }

	        // Loop through variations
	        for ( var num in variations ) {

                if ( typeof( variations[ num ] ) !== 'undefined' ) {

    	            var attributes = variations[ num ].attributes;

    	            for ( var attr_name in attributes ) {
                        if ( attributes.hasOwnProperty( attr_name ) ) {
        	                var attr_val = attributes[ attr_name ];

        	                if ( attr_name === current_attr_name ) {
                                var variation_active = '';

                                if ( variations[ num ].variation_is_active ) {
                                    variation_active = 'enabled';
                                }

                                if ( attr_val ) {

                                    // Decode entities
                                    attr_val = $( '<div/>' ).html( attr_val ).text();

                                    // Add slashes
                                    attr_val = attr_val.replace( /'/g, '\\\'' );
                                    attr_val = attr_val.replace( /"/g, '\\\"' );

                                    // Compare the meerkat
                                    current_attr_select.find( 'option[value="' + attr_val + '"]' ).addClass( 'attached ' + variation_active );

                                } else {

                                    current_attr_select.find( 'option' + option_gt_filter ).addClass( 'attached ' + variation_active );

                                }
        	                }
                        }
    	            }
                }
	        }

            // Detach unattached
            current_attr_select.find( 'option' + option_gt_filter + ':not(.attached)' ).remove();

            // Grey out disabled
            current_attr_select.find( 'option' + option_gt_filter + ':not(.enabled)' ).attr( 'disabled', 'disabled' );

        });

		// Custom event for when variations have been updated
		$(document).trigger('woocommerce_update_variation_values');

    }

    //show single variation details (price, stock, image)
    function show_variation(variation) {

        $('.quick_view_variations_form').qv_wc_variations_image_update( variation );

		$('.quick_view_variations_button').show();

        if ( ! variation.is_purchasable || ! variation.is_in_stock || ! variation.variation_is_visible ) {
            $('.quick_view_single_variation').html( 'Sorry, this product is unavailable. Please choose a different combination' );
            $('.quick_view_single_variation_wrap').find('.quick_view_add_to_cart_button').addClass('disabled');
        } else {
            $('.quick_view_single_variation').html( variation.price_html + variation.availability_html );
            $('.quick_view_single_variation_wrap').find('.quick_view_add_to_cart_button').removeClass('disabled');
        }

        if (variation.sku) {
        	 $('.product_meta').find('.sku').text( variation.sku );
        } else {
        	 $('.product_meta').find('.sku').text('');
        }

        $('.quick_view_single_variation_wrap').find('.quantity').show();

        if (variation.min_qty) {
        	$('.quick_view_single_variation_wrap').find('input[name=quantity]').attr('data-min', variation.min_qty).val(variation.min_qty);
        } else {
        	$('.quick_view_single_variation_wrap').find('input[name=quantity]').removeAttr('data-min');
        }

        if ( variation.max_qty ) {
        	$('.quick_view_single_variation_wrap').find('input[name=quantity]').attr('data-max', variation.max_qty);
        } else {
        	$('.quick_view_single_variation_wrap').find('input[name=quantity]').removeAttr('data-max');
        }

        if ( variation.is_sold_individually == 'yes' ) {
        	$('.quick_view_single_variation_wrap').find('input[name=quantity]').val('1');
        	$('.quick_view_single_variation_wrap').find('.quantity').hide();
        }

        $('.quick_view_single_variation_wrap').slideDown('200').trigger('variationWrapShown').trigger('show_variation'); // deprecated variationWrapShown
    }

	//when one of attributes is changed - check everything to show only valid options
    function check_variations( exclude, focus ) {
		var all_set = true;
		var any_set = false;
		var showing_variation = false;
		var current_settings = {};

		$('.quick_view_table_variations select').each(function(){

			if ( exclude && $(this).attr('name') == exclude ) {
				all_set = false;
				current_settings[$(this).attr('name')] = '';

			} else {
				if ($(this).val().length == 0) {
					all_set = false;
				} else {
					any_set = true;
				}

            	// Encode entities
            	value = $(this).val();

				// Add to settings array
				current_settings[$(this).attr('name')] = value;
			}

		});

        var product_variations = $( '.quick_view_variations_form' ).data( 'product_variations' );

        var matching_variations = find_matching_variations( product_variations, current_settings);

        if (all_set) {
        	var variation = matching_variations.pop();
        	if (variation) {
            	$('form input[name=variation_id]').val(variation.variation_id).change();
            	show_variation(variation);
            } else {
            	// Nothing found - reset fields
            	$('.quick_view_table_variations select').val('');
            	if ( ! focus ) $('.quick_view_variations_form').qv_wc_variations_image_update( false );
            }
        } else {
            update_variation_values(matching_variations);
            if ( ! focus ) $('.quick_view_variations_form').qv_wc_variations_image_update( false );
        }

        if (any_set) {
        	if ($('.reset_variations').css('visibility') == 'hidden') {
                $('.reset_variations').css('visibility','visible').hide().fadeIn();
            }
        } else {
			$('.reset_variations').css('visibility','hidden');
		}
    }

	$('.quick_view_table_variations select').on( 'change', function(){

		$('form input[name=variation_id]').val('').change();
        $('.quick_view_single_variation_wrap').hide();
        $('.quick_view_single_variation').text('');
		check_variations( '', false );
		$(this).blur();
		if( $().uniform && $.isFunction($.uniform.update) ) {
			$.uniform.update();
		}

	}).on( 'focusin touchstart', function() {

		check_variations( $(this).attr('name'), true );

	});

    $( function() {
        $( '.quick_view_variations_form' ).each( function() {
            $( this ).find('.quick_view_table_variations select:eq(0)').change();
        });
    });

});