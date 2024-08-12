(function ($) {
    "use strict";
    jQuery(document).ready(function () {
        if (typeof wc_add_to_cart_params != 'undefined') {

            /* Ajax mini cart remove and Revert item remove from cart.*/
            $(document).on('click', '.woocommerce-mini-cart-item .remove', function (e) {
                e.preventDefault();
                var $thisbutton = $(this),
                    $mini_cart = $thisbutton.closest('.widget_shopping_cart_content'),
                    $cart_item = $thisbutton.closest('.woocommerce-mini-cart-item');
                $cart_item.addClass('loading');
                if (!$(this).hasClass('revert-cart-item')) {
                    $.post(wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'remove_from_cart'), {cart_item_key: $thisbutton.data('cart_item_key')}, function (response) {
                        if (!response || !response.fragments) {
                            window.location = $thisbutton.attr('href');
                            return;
                        }
                        $thisbutton.addClass('revert-cart-item');

                        $mini_cart.find('.pre-remove').addClass('removed');
                        $cart_item.addClass('pre-remove');

                        $mini_cart.find('.woocommerce-mini-cart__total.total .woocommerce-Price-amount').replaceWith(response.fragments.cart_subtotal);
                        $mini_cart.find('.free-shipping-required-notice').replaceWith(response.fragments.free_shipping_cart_notice);
                        $thisbutton.closest('.widget_shopping_cart ').find('.total-cart-item').replaceWith(response.fragments['.total-cart-item']);

                        setTimeout(function () {
                            $mini_cart.find('.removed').remove();
                        }, 500);
                        if (response.fragments.cart_count == 0) {
                            $mini_cart.find('.wrap-bottom-mini-cart').fadeOut();
                        }

                        $cart_item.removeClass('loading');
                        $(document).trigger('sublimeplus_after_remove_product_item', {
                            "fragments": response.fragments
                        });
                    }).fail(function () {
                        window.location = $thisbutton.attr('href');
                        return;
                    });
                } else {
                    var cart_item_key = $thisbutton.data('cart_item_key');
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: wc_add_to_cart_params.ajax_url,
                        data: {
                            action: "restore_cart_item",
                            cart_item_key: cart_item_key
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            console.log('AJAX Restore ' + errorThrown);
                            console.log('AJAX Restore ' + cart_item_key);
                        },
                        success: function (data) {
                            $(document).trigger('sublimeplus_after_restore_product_item', {
                                "fragments": data
                            });
                            $thisbutton.removeClass('revert-cart-item');

                            $cart_item.removeClass('pre-remove');
                            if (!$mini_cart.find('.wrap-bottom-mini-cart').is(":visible")) {
                                $mini_cart.find('.wrap-bottom-mini-cart').fadeIn();
                            }
                            $mini_cart.find('.woocommerce-mini-cart__total.total .woocommerce-Price-amount').replaceWith(data.cart_subtotal);
                            $mini_cart.find('.free-shipping-required-notice').replaceWith(data.free_shipping_cart_notice);
                            $thisbutton.closest('.widget_shopping_cart ').find('.total-cart-item').replaceWith(data['.total-cart-item']);
                            $cart_item.removeClass('loading');
                        }
                    });
                    return false;
                }
            });

            //Update mini top cart ajax
            $(document).on('added_to_cart', function (event, fragments) {
                if (!$('.cafe-canvas-cart')[0])
                    sublimeplus_add_to_cart_mess(fragments['sublimeplus_add_to_cart_message']);

            });
            /* End Ajax cart for shop loop product item*/

            //Refresh variations_form button added to cart when change option.
            $("form.variations_form").on("woocommerce_variation_select_change", function () {
                $(this).find('.cart-added').removeClass('cart-added');
            });

            
        }
        /* End Ajax Add to Cart for Single Product */

        //Function for Add to Cart message
        function sublimeplus_add_to_cart_mess($sublimeplus_mess) {
            if (!!$sublimeplus_mess && $sublimeplus_mess != undefined) {
                if ($('#add-to-cart-message')[0]) {
                    $('#add-to-cart-message').replaceWith($sublimeplus_mess);
                } else {
                    $('body').append($sublimeplus_mess);
                }
                setTimeout(function () {
                    $('#add-to-cart-message').addClass('active');
                }, 100);
                setTimeout(function () {
                    $('#add-to-cart-message').removeClass('active');
                }, 3500);
            }
        }

        /* Quick view js */
        $(document).on('click', '.product .btn-quick-view', function (e) {
            e.preventDefault();
            $('.mask-close').addClass('loading active mask-quick-view');
            var load_product_id = $(this).attr('data-productid');
            var data = {action: 'sublimeplus_quick_view', product_id: load_product_id};
            $(this).parent().addClass('loading');
            var $this = $(this);
            $.ajax({
                url: ajaxurl,
                data: data,
                type: "POST",
                success: function (response) {
                    $('body').append(response);
                    $this.parent().removeClass('loading');
                    // Variation Form
                    var form_variation = $(document).find('#quickview-lb .variations_form');
                    form_variation.wc_variation_form();
                    form_variation.trigger('check_variations');
                    sublimeplus_quick_view_gal();
                    //Sync button compare/wishlist quickview load.
                    if ($('#quickview-lb .wishlist-button')[0]) {
                        if (window.zooWishlist.model.exists($('#quickview-lb .wishlist-button').data('id'))) {
                            window.zooWishlist.view.renderBrowseButton($('#quickview-lb .wishlist-button'));
                        }
                    }
                    if ($('#quickview-lb .compare-button')[0]) {
                        if (window.zooProductsCompare.model.exists($('#quickview-lb .compare-button').data('id'))) {
                            window.zooProductsCompare.view.renderBrowseButton($('#quickview-lb .compare-button'));
                        }
                    }
                    setTimeout(function () {
                        $('#quickview-lb').css('opacity', '1');
                        $('#quickview-lb').css('top', '50%');
                    }, 100);
                }
            });
        });

        $(document).on('click', '.close-quickview, .mask-close.mask-quick-view', function (e) {
            e.preventDefault();
            sublimeplus_close_quick_view();
        });
        //Close Quickview when click to compare/wish list.
        $(document).on('sublimeplus_browse_wishlist', function () {
            sublimeplus_close_quick_view();
        });
        $(document).on('sublimeplus_browse_compare', function () {
            sublimeplus_close_quick_view();
        });
        //Swatches gallery for quick view
        $(document).on('cleverswatch_update_gallery', function (event, response) {
            if ($('#quickview-lb')[0])
                sublimeplus_quick_view_gal();
        });

        //Close Quickview;
        function sublimeplus_close_quick_view() {
            $('.mask-close').removeClass('loading active mask-quick-view');
            $('#quickview-lb').css({'top': 'calc(50% + 150px)', 'opacity': '0'});
            setTimeout(function () {
                $('#quickview-lb').remove();
            }, 500)
        }

        //Quickview gallery
        function sublimeplus_quick_view_gal() {
            if ($('.product-quick-view .wrap-main-product-gallery')[0]) {
                let thumb_num = $('.product-gallery.images').data('columns');
                if (typeof  $.fn.slick != 'undefined') {
                    $('.product-quick-view .wrap-main-product-gallery').slick({
                        slidesToShow: 1,
                        rows: 0,
                        slidesToScroll: 1,
                        dots: true,
                        focusOnSelect: true,
                        rtl: $('body.rtl')[0] ? true : false,
                        prevArrow: '<span class="carousel-btn prev-item"><i class="icon-arrow-left"></i></span>',
                        nextArrow: '<span class="carousel-btn next-item"><i class="icon-arrow-right"></i></span>',
                    });
                }
            }
        }

        /* End Quick view js */
    })
})(jQuery);