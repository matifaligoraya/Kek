<?php
/* 
    Custom Product Tabs and Badge
    for WooCommerce product edit page
*/

// Add the custom meta box for product tabs
add_action('add_meta_boxes', 'kek_add_custom_product_tabs_meta_box');
function kek_add_custom_product_tabs_meta_box() {
    add_meta_box(
        'kek_product_title_badge',
        __('Product Title Badge', 'kek'),
        'kek_product_title_badge_callback',
        'product',
        'normal',
        'high'
    );

    add_meta_box(
        'kek_custom_product_tabs',
        __('Product Custom Tabs', 'kek'),
        'kek_custom_product_tabs_callback',
        'product',
        'normal',
        'high'
    );    
}

// Callback function to display the product title badge
function kek_product_title_badge_callback($post) {
    wp_nonce_field(basename(__FILE__), 'kek_product_title_badge_nonce');
    $badge_value = get_post_meta($post->ID, '_kek_product_title_badge', true);
    ?>
    <p>
        <label for="kek_product_title_badge"><?php _e('Badge Text', 'kek'); ?></label>
        <input type="text" name="_kek_product_title_badge" value="<?php echo esc_attr($badge_value); ?>" />
    </p>
    <?php
}

// Save the product title badge
add_action('save_post', 'kek_save_product_title_badge');
function kek_save_product_title_badge($post_id) {
    if (!isset($_POST['kek_product_title_badge_nonce']) || !wp_verify_nonce($_POST['kek_product_title_badge_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    $badge_value = isset($_POST['_kek_product_title_badge']) ? sanitize_text_field($_POST['_kek_product_title_badge']) : '';
    update_post_meta($post_id, '_kek_product_title_badge', $badge_value);
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
                    <div class="kek_custom_tab mb-4">
                        <h3 class="h5 mt-3 mb-3"><?php _e('Tab', 'kek'); ?> <?php echo ($index + 1); ?></h3>
                        
                        <div class="mb-3">
                            <label for="kek_custom_product_tabs[<?php echo $index; ?>][title]" class="form-label"><?php _e('Tab Title', 'kek'); ?></label>
                            <input type="text" name="kek_custom_product_tabs[<?php echo $index; ?>][title]" value="<?php echo esc_attr($tab['title']); ?>" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="kek_custom_product_tabs[<?php echo $index; ?>][tab_title_badge]" class="form-label"><?php _e('Tab Title Badge', 'kek'); ?></label>
                            <input type="text" name="kek_custom_product_tabs[<?php echo $index; ?>][tab_title_badge]" value="<?php echo esc_attr($tab['tab_title_badge']); ?>" class="form-control" />
                        </div>
                        
                        <div class="mb-3">
                            <label for="kek_custom_product_tabs[<?php echo $index; ?>][description]" class="form-label"><?php _e('Tab Description', 'kek'); ?></label>
                            <textarea id="kek_custom_product_tabs[<?php echo $index; ?>][description]" name="kek_custom_product_tabs[<?php echo $index; ?>][description]" class="form-control tinymce-editor"><?php echo esc_html($tab['description']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php _e('Options', 'kek'); ?></label>
                            <ul class="list-unstyled">
                                <?php foreach ($tab['options'] as $option_index => $option) { ?>
                                    <li class="list-group-item d-flex align-items-start mb-3">
                                        <div class="input-group me-2 flex-grow-1">
                                            <input type="text" name="kek_custom_product_tabs[<?php echo $index; ?>][options][<?php echo $option_index; ?>][title]" value="<?php echo esc_attr($option['title']); ?>" placeholder="<?php _e('Option Title', 'kek'); ?>" class="form-control" />
                                        </div>
                                        <div class="input-group me-2 flex-grow-1">
                                            <input type="number" name="kek_custom_product_tabs[<?php echo $index; ?>][options][<?php echo $option_index; ?>][old_price]" value="<?php echo esc_attr($option['old_price']); ?>" placeholder="<?php _e('Old Price', 'kek'); ?>" step="0.01" class="form-control" />
                                        </div>
                                        <div class="input-group me-2 flex-grow-1">
                                            <input type="number" name="kek_custom_product_tabs[<?php echo $index; ?>][options][<?php echo $option_index; ?>][price]" value="<?php echo esc_attr($option['price']); ?>" placeholder="<?php _e('New Price', 'kek'); ?>" step="0.01" class="form-control" />
                                        </div>
                                        <div class="input-group me-2 flex-grow-1">
                                            <input type="text" name="kek_custom_product_tabs[<?php echo $index; ?>][options][<?php echo $option_index; ?>][badge]" value="<?php echo esc_attr($option['badge']); ?>" placeholder="<?php _e('Badge', 'kek'); ?>" class="form-control" />
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm kek_remove_option">
                                            <?php _e('Remove', 'kek'); ?>
                                        </button>
                                    </li>
                                <?php } ?>
                            </ul>
                            <button class="kek_add_option btn btn-primary"><?php _e('Add Option', 'kek'); ?></button>
                        </div>

                        <div class="text-end">
                            <a href="#" class="kek_remove_tab btn btn-danger"><?php _e('Remove Tab', 'kek'); ?></a>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <button id="kek_add_tab" class="btn btn-success"><?php _e('Add Tab', 'kek'); ?></button>
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
                'tab_title_badge' => sanitize_text_field($tab['tab_title_badge']),
                'description' => sanitize_textarea_field($tab['description']),
                'options' => array()
            );

            if (!empty($tab['options'])) {
                foreach ($tab['options'] as $option) {
                    $new_tab['options'][] = array(
                        'title' => sanitize_text_field($option['title']),
                        'old_price' => floatval($option['old_price']),
                        'price' => floatval($option['price']),
                        'badge' => sanitize_text_field($option['badge'])
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

    if (!empty($custom_tabs)) { ?>

    <div class="col col-box">
        <div class="banner-box">
            <div class="box-head">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <?php if (!empty($custom_tabs)): ?>
                        <?php foreach ($custom_tabs as $index => $tab): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php echo ($index === 0) ? 'active' : ''; ?>" 
                                        id="<?php echo sanitize_title($tab['title']); ?>-tab" 
                                        data-bs-toggle="tab" 
                                        data-bs-target="#<?php echo sanitize_title($tab['title']); ?>" 
                                        type="button" 
                                        role="tab" 
                                        aria-controls="<?php echo sanitize_title($tab['title']); ?>" 
                                        aria-selected="<?php echo ($index === 0) ? 'true' : 'false'; ?>">
                                    <?php echo esc_html($tab['title']); ?>
                                </button>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="tab-content" id="myTabContent">
                <?php if (!empty($custom_tabs)): ?>
                    <?php foreach ($custom_tabs as $index => $tab): ?>
                        <div class="tab-pane fade <?php echo ($index === 0) ? 'show active' : ''; ?>" 
                            id="<?php echo sanitize_title($tab['title']); ?>" 
                            role="tabpanel" 
                            aria-labelledby="<?php echo sanitize_title($tab['title']); ?>-tab">                        
                            
                            <?php if(!empty($tab['description'])) { ?>
                                <div class="grey-title">                        
                                <p>
                                    <span dir="ltr">
                                        <?php echo esc_html($tab['description']); ?>
                                    </span>
                                </p>
                                </div>
                            <?php } ?>         
                            <form class="wcl-form">                   
                            <?php if (!empty($tab['options'])): ?>
                                <?php 
                                    $totalOptions = count($tab['options']);
                                    $chunkedOptions = array_chunk($tab['options'], 5);
                                ?>
                                <?php foreach ($chunkedOptions as $chunkIndex => $chunk): ?>                                    
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <?php foreach ($chunk as $index => $option): ?>
                                            <?php 
                                            $title = $option['title'];                       
                                            if (isset($title) && !empty($title)) {
                                                $title_parts = explode(' ', $title);
                                                $pre_title = $title_parts[0] ?? '';
                                                $post_title = isset($title_parts[1]) ? implode(' ', array_slice($title_parts, 1)) : ''; 
                                            } else {                                                    
                                                $pre_title = '';
                                                $post_title = '';
                                            }
                                            
                                            $isBigButton = (count($chunk) === 5 && $index === 0) ? ' wcl-big-btn-radio' : '';
                                            ?>
                                            <div class="btn-radio<?php echo $isBigButton; ?>">
                                                <input type="radio" 
                                                    value="<?php echo isset($option['value']) ? esc_attr($option['value']) : ''; ?>" 
                                                    class="btn-check" 
                                                    name="btnradio" 
                                                    id="btnradio-<?php echo $chunkIndex . '-' . $index; ?>" 
                                                    autocomplete="off">
                                                <label class="btn" for="btnradio-<?php echo $chunkIndex . '-' . $index; ?>">
                                                    <div class="col left-col">
                                                        <span class="number">
                                                            <?php echo $pre_title; ?>
                                                        </span>                                                         
                                                        <span><?php echo $post_title; ?></span>                                                       
                                                    </div>
                                                    <div class="col right-col">
                                                        <div class="price">                                                            
                                                            <?php if (isset($option['old_price'])): ?>
                                                                <span class="old-price">
                                                                    <?php echo get_woocommerce_currency_symbol() . ' ' . esc_html($option['old_price']); ?>
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php echo get_woocommerce_currency_symbol() . ' ' . esc_html($option['price']); ?>
                                                        </div>
                                                        <?php if (isset($option['badge'])): ?>
                                                            <span class="save"><?php echo esc_html($option['badge']); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>                                    
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="box-footer">
                <ul>
                    <?php 
                    $product_short_description = get_the_excerpt($post->ID);
                    if (!empty($product_short_description)): ?>
                        <?php                     
                        $short_description_items = explode("\n", wp_strip_all_tags($product_short_description)); 
                        ?>
                        <?php foreach ($short_description_items as $item): ?>
                            <li><?php echo esc_html(trim($item)); ?></li>
                        <?php endforeach; ?>                
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </div>
        
    <?php }
}

add_action('display_product_detail_tabs', 'kek_display_product_detail_tabs');

// Admin scripts to manage the tabs and options in the backend
function kek_custom_product_tabs_admin_script() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            tinymce.init({
                selector: '.tinymce-editor',
                menubar: false,
                toolbar: 'bold italic | alignleft aligncenter alignright | bullist numlist outdent indent',
                branding: false
            });

            function updateTabNames() {
                $('#kek_custom_tabs .kek_custom_tab').each(function(index) {
                    $(this).find('h3').text('<?php _e('Tab', 'kek'); ?> ' + (index + 1));
                });
            }

            $('#kek_add_tab').on('click', function(e) {
                e.preventDefault();

                var tabCount = $('#kek_custom_tabs .kek_custom_tab').length;
                var newTab = $('<div class="kek_custom_tab mb-4">' +
                    '<h3 class="h5 mt-3 mb-3"><?php _e("Tab", "kek"); ?> ' + (tabCount + 1) + '</h3>' +

                    // Tab Title
                    '<div class="mb-3">' +
                        '<label for="tab-title-' + tabCount + '" class="form-label"><?php _e("Tab Title", "kek"); ?></label>' +
                        '<input type="text" id="tab-title-' + tabCount + '" name="kek_custom_product_tabs[' + tabCount + '][title]" class="form-control" />' +
                    '</div>' +

                    // Tab Title
                    '<div class="mb-3">' +
                        '<label for="tab-title-badge-' + tabCount + '" class="form-label"><?php _e("Tab Title Badge", "kek"); ?></label>' +
                        '<input type="text" id="tab-title-badge-' + tabCount + '" name="kek_custom_product_tabs[' + tabCount + '][tab_title_badge]" class="form-control" />' +
                    '</div>' +

                    // Tab Description with HTML editor
                    '<div class="mb-3">' +
                        '<label for="tab-description-' + tabCount + '" class="form-label"><?php _e("Tab Description", "kek"); ?></label>' +
                        '<textarea id="tab-description-' + tabCount + '" name="kek_custom_product_tabs[' + tabCount + '][description]" class="form-control tinymce-editor"></textarea>' +
                    '</div>' +

                    // Options Section
                    '<div class="mb-3">' +
                        '<label class="form-label"><?php _e("Options", "kek"); ?></label>' +
                        '<ul class="list-unstyled"></ul>' +
                        '<button type="button" class="kek_add_option btn btn-primary"><?php _e("Add Option", "kek"); ?></button>' +
                    '</div>' +

                    // Remove Tab Button
                    '<div class="text-end">' +
                        '<a href="#" class="kek_remove_tab btn btn-danger"><?php _e("Remove Tab", "kek"); ?></a>' +
                    '</div>' +
                '</div>');

                // After appending the new tab, initialize TinyMCE editor
                $('#kek_custom_tabs_container').append(newTab);  
                tinymce.init({
                    selector: '.tinymce-editor',
                    menubar: false,
                    toolbar: 'bold italic | alignleft aligncenter alignright | bullist numlist outdent indent',
                    branding: false
                });                          
                updateTabNames();
            });

            $(document).on('click', '.kek_add_option', function(e) {
                e.preventDefault();

                var tab = $(this).closest('.kek_custom_tab');
                var optionCount = tab.find('ul li').length;

                var newOption = $(`
                    <li class="list-group-item d-flex align-items-start mb-3">
                        <div class="input-group me-2 flex-grow-1">
                            <input type="text" class="form-control" 
                                name="kek_custom_product_tabs[${tab.index()}][options][${optionCount}][title]" 
                                placeholder="<?php _e('Option Title', 'kek'); ?>" />
                        </div>
                        <div class="input-group me-2 flex-grow-1">
                            <input type="number" class="form-control" 
                                name="kek_custom_product_tabs[${tab.index()}][options][${optionCount}][old_price]" 
                                placeholder="<?php _e('Old Price', 'kek'); ?>" step="0.01" />
                        </div>
                        <div class="input-group me-2 flex-grow-1">
                            <input type="number" class="form-control" 
                                name="kek_custom_product_tabs[${tab.index()}][options][${optionCount}][price]" 
                                placeholder="<?php _e('New Price', 'kek'); ?>" step="0.01" />
                        </div>
                        <div class="input-group me-2 flex-grow-1">
                            <input type="text" class="form-control" 
                                name="kek_custom_product_tabs[${tab.index()}][options][${optionCount}][badge]" 
                                placeholder="<?php _e('Badge', 'kek'); ?>" />
                        </div>
                        <button type="button" class="btn btn-danger btn-sm kek_remove_option">
                            <?php _e('Remove', 'kek'); ?>
                        </button>
                    </li>
                `);

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