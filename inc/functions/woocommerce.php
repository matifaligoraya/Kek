<?php
// Add the custom meta box for product tabs
add_action('add_meta_boxes', 'kek_add_custom_product_tabs_meta_box');
function kek_add_custom_product_tabs_meta_box() {
    add_meta_box(
        'kek_custom_product_tabs',
        __('Product Custom Tabs', 'kek'),
        'kek_custom_product_tabs_callback',
        'product',
        'normal',
        'high'
    );
}

// Callback function to display the custom product tabs
function kek_custom_product_tabs_callback($post) {
    wp_nonce_field(basename(__FILE__), 'kek_custom_product_tabs_nonce');
    $stored_meta = get_post_meta($post->ID, '_kek_custom_product_tabs', true);
    ?>

    <div id="kek_custom_tabs_container">
        <div id="kek_custom_tabs">
            <?php
            if (!empty($stored_meta)) {
                foreach ($stored_meta as $index => $tab) {
                    ?>
                    <div class="kek_custom_tab">
                        <h3><?php _e('Tab', 'kek'); ?> <?php echo ($index + 1); ?></h3>
                        <p>
                            <label for="kek_custom_product_tabs[<?php echo $index; ?>][title]"><?php _e('Tab Title', 'kek'); ?></label>
                            <input type="text" name="kek_custom_product_tabs[<?php echo $index; ?>][title]" value="<?php echo esc_attr($tab['title']); ?>" />
                        </p>
                        <p>
                            <label for="kek_custom_product_tabs[<?php echo $index; ?>][description]"><?php _e('Tab Description', 'kek'); ?></label>
                            <textarea name="kek_custom_product_tabs[<?php echo $index; ?>][description]"><?php echo esc_html($tab['description']); ?></textarea>
                        </p>
                        <p>
                            <label><?php _e('Options', 'kek'); ?></label>
                            <ul>
                                <?php foreach ($tab['options'] as $option_index => $option) { ?>
                                    <li>
                                        <input type="text" name="kek_custom_product_tabs[<?php echo $index; ?>][options][<?php echo $option_index; ?>][title]" value="<?php echo esc_attr($option['title']); ?>" placeholder="<?php _e('Option Title', 'kek'); ?>" />
                                        <input type="number" name="kek_custom_product_tabs[<?php echo $index; ?>][options][<?php echo $option_index; ?>][price]" value="<?php echo esc_attr($option['price']); ?>" placeholder="<?php _e('Option Price', 'kek'); ?>" step="0.01" />
                                        <a href="#" class="kek_remove_option"><?php _e('Remove', 'kek'); ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                            <button class="kek_add_option button"><?php _e('Add Option', 'kek'); ?></button>
                        </p>
                        <a href="#" class="kek_remove_tab"><?php _e('Remove Tab', 'kek'); ?></a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <button id="kek_add_tab" class="button"><?php _e('Add Tab', 'kek'); ?></button>
    </div>

    <?php
}

// Save custom product tabs
add_action('save_post', 'kek_save_custom_product_tabs');
function kek_save_custom_product_tabs($post_id) {
    if (!isset($_POST['kek_custom_product_tabs_nonce']) || !wp_verify_nonce($_POST['kek_custom_product_tabs_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    $new_data = array();
    if (isset($_POST['kek_custom_product_tabs'])) {
        $tabs = $_POST['kek_custom_product_tabs'];

        foreach ($tabs as $tab) {
            $new_tab = array(
                'title' => sanitize_text_field($tab['title']),
                'description' => sanitize_textarea_field($tab['description']),
                'options' => array()
            );

            if (!empty($tab['options'])) {
                foreach ($tab['options'] as $option) {
                    $new_tab['options'][] = array(
                        'title' => sanitize_text_field($option['title']),
                        'price' => floatval($option['price'])
                    );
                }
            }

            $new_data[] = $new_tab;
        }
    }

    update_post_meta($post_id, '_kek_custom_product_tabs', $new_data);
}

// Hide the default product price
add_filter('woocommerce_get_price_html', '__return_empty_string');


function kek_display_product_detail_tabs() {
    global $post, $product;
    $custom_tabs = get_post_meta($post->ID, '_kek_custom_product_tabs', true);

    if (!empty($custom_tabs)) {
        echo '<div class="kek-custom-product-tabs">';
        foreach ($custom_tabs as $tab_index => $tab) {
            echo '<div class="kek-custom-tab">';
            echo '<h3>' . esc_html($tab['title']) . '</h3>';
            echo '<p>' . esc_html($tab['description']) . '</p>';

            if (!empty($tab['options'])) {
                echo '<form method="post" action="' . esc_url(wc_get_checkout_url()) . '">'; // Direct to checkout
                echo '<ul>';
                foreach ($tab['options'] as $option_index => $option) {
                    echo '<li>';
                    echo '<label>';
                    // Set the value of the radio button as the price
                    echo '<input type="radio" name="kek_custom_product_option[' . $tab_index . ']" value="' . esc_attr($option['price']) . '" required>';
                    echo esc_html($option['title']) . ' - $' . esc_html($option['price']);
                    echo '</label>';
                    echo '</li>';
                }                
                echo '</ul>';
                // Hidden fields to pass additional data
                echo '<input type="hidden" name="kek_custom_product_tab" value="' . esc_attr($tab['title']) . '">';
                echo '<input type="hidden" name="add-to-cart" value="' . esc_attr($product->get_id()) . '">';
                echo '<button type="submit" class="button kek-buy-now-button">' . __('Buy Now', 'kek') . '</button>';
                echo '</form>';
            }

            echo '</div>'; // End of tab
        }
        echo '</div>'; // End of custom product tabs
    }
}

add_action('display_product_detail_tabs', 'kek_display_product_detail_tabs');

// Admin scripts to manage the tabs and options in the backend
function kek_custom_product_tabs_admin_script() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            function updateTabNames() {
                $('#kek_custom_tabs .kek_custom_tab').each(function(index) {
                    $(this).find('h3').text('<?php _e('Tab', 'kek'); ?> ' + (index + 1));
                });
            }

            $('#kek_add_tab').on('click', function(e) {
                e.preventDefault();

                var tabCount = $('#kek_custom_tabs .kek_custom_tab').length;
                var newTab = $('<div class="kek_custom_tab">' +
                    '<h3><?php _e('Tab', 'kek'); ?> ' + (tabCount + 1) + '</h3>' +
                    '<p><label><?php _e('Tab Title', 'kek'); ?></label>' +
                    '<input type="text" name="kek_custom_product_tabs[' + tabCount + '][title]" /></p>' +
                    '<p><label><?php _e('Tab Description', 'kek'); ?></label>' +
                    '<textarea name="kek_custom_product_tabs[' + tabCount + '][description]"></textarea></p>' +
                    '<p><label><?php _e('Options', 'kek'); ?></label>' +
                    '<ul></ul><button class="kek_add_option button"><?php _e('Add Option', 'kek'); ?></button></p>' +
                    '<a href="#" class="kek_remove_tab"><?php _e('Remove Tab', 'kek'); ?></a>' +
                    '</div>');

                $('#kek_custom_tabs').append(newTab);
                updateTabNames();
            });

            $(document).on('click', '.kek_add_option', function(e) {
                e.preventDefault();

                var tab = $(this).closest('.kek_custom_tab');
                var optionCount = tab.find('ul li').length;
                var newOption = $('<li>' +
                    '<input type="text" name="kek_custom_product_tabs[' + tab.index() + '][options][' + optionCount + '][title]" placeholder="<?php _e('Option Title', 'kek'); ?>" />' +
                    '<input type="number" name="kek_custom_product_tabs[' + tab.index() + '][options][' + optionCount + '][price]" placeholder="<?php _e('Option Price', 'kek'); ?>" step="0.01" />' +
                    '<a href="#" class="kek_remove_option"><?php _e('Remove', 'kek'); ?></a>' +
                    '</li>');

                tab.find('ul').append(newOption);
            });

            $(document).on('click', '.kek_remove_tab', function(e) {
                e.preventDefault();
                $(this).closest('.kek_custom_tab').remove();
                updateTabNames();
            });

            $(document).on('click', '.kek_remove_option', function(e) {
                e.preventDefault();
                $(this).closest('li').remove();
            });
        });
    </script>
    <?php
}
add_action('admin_footer', 'kek_custom_product_tabs_admin_script');

function kek_redirect_checkout_directly($url) {
    if (isset($_POST['kek_custom_product_option']) && is_array($_POST['kek_custom_product_option'])) {
        $product_id = intval($_POST['add-to-cart']);
        $product = wc_get_product($product_id);

        // Get the selected option
        $selected_option_key = key($_POST['kek_custom_product_option']);
        $selected_option_price = sanitize_text_field($_POST['kek_custom_product_option'][$selected_option_key]);
        $tab_title = sanitize_text_field($_POST['kek_custom_product_tab']);        

        WC()->cart->empty_cart();
        WC()->cart->add_to_cart($product_id, 1, '', '', array(
            'kek_custom_product_price' => $selected_option_price,
            'kek_custom_product_tab' => $tab_title
        ));

        // Debugging output
        // print_r('Selected Option Price: ' . $selected_option_price); // Log the selected price
        // print_r('Cart Contents: ' . print_r(WC()->cart->get_cart(), true)); // Log current cart

        $url = wc_get_checkout_url();
    }
    return $url;
}

add_filter('woocommerce_add_to_cart_redirect', 'kek_redirect_checkout_directly', 10, 1);


function kek_save_custom_product_meta($item, $cart_item_key, $values, $order) {
    if (isset($values['kek_custom_product_price'])) {
        $item->add_meta_data(__('Custom Product Price', 'kek'), $values['kek_custom_product_price']);
    }
    if (isset($values['kek_custom_product_tab'])) {
        $item->add_meta_data(__('Selected Tab', 'kek'), $values['kek_custom_product_tab']);
    }
}
add_action('woocommerce_checkout_create_order_line_item', 'kek_save_custom_product_meta', 10, 4);


?>