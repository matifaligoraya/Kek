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

    // Add meta box for all-time package
    add_meta_box(
        'kek_all_time_package',
        __('All-Time Package', 'kek'),
        'kek_all_time_package_callback',
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
                        
                        <?php if (!empty($tab['description'])): ?>
                            <div class="grey-title">                        
                                <p>
                                    <span dir="ltr">
                                        <?php echo esc_html($tab['description']); ?>
                                    </span>
                                </p>
                            </div>
                        <?php endif; ?>         
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
                                            
                                            // Create a unique ID for the radio buttons
                                            $unique_id = "btnradio-" . sanitize_title($tab['title']) . "-{$index}-{$chunkIndex}";
                                            ?>
                                            <div class="btn-radio<?php echo $isBigButton; ?>">
                                                <input type="radio" 
                                                    value="<?php echo isset($option['value']) ? esc_attr($option['value']) : ''; ?>" 
                                                    class="btn-check" 
                                                    id="<?php echo $unique_id; ?>"
                                                    name="single_option">
                                                <label class="btn" for="<?php echo $unique_id; ?>">
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
                                                                    <?php echo get_woocommerce_currency_symbol() . '' . esc_html($option['old_price']); ?>
                                                                </span>
                                                            <?php endif; ?>                                                            
                                                            <?php if ($option['price'] > 0): ?>
                                                                <?php echo get_woocommerce_currency_symbol() . '' . esc_html($option['price']); ?>
                                                            <?php endif; ?>
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
                                <button type="button" class="kek-action-btn btn-black w-100 mt-5 wcl_select_product_btn">
                                    <span class="btn-circle"></span>
                                    <span class="btn-circle"></span>
                                    <span class="btn-circle"></span>
                                    <strong>Buy now </strong>
                                </button>                                
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


/* All-in one option settings */

function kek_all_time_package_callback($post) {
    // Retrieve saved values
    $is_all_time_package = get_post_meta($post->ID, '_kek_all_time_package', true);
    $package_title = get_post_meta($post->ID, '_kek_package_title', true);
    $package_price = get_post_meta($post->ID, '_kek_package_price', true);
    $package_description = get_post_meta($post->ID, '_kek_package_description', true);
    $package_details = get_post_meta($post->ID, '_kek_package_details', true); // Array of details

    // Use nonce for verification
    wp_nonce_field('kek_save_all_time_package', 'kek_all_time_package_nonce');

    ?>
    <p>
        <label for="kek_all_time_package">
            <input type="checkbox" id="kek_all_time_package" name="kek_all_time_package" value="yes" <?php checked($is_all_time_package, 'yes'); ?> />
            <?php _e('Enable All-Time Package', 'kek'); ?>
        </label>
    </p>

    <p>
        <label for="kek_package_title"><?php _e('Title', 'kek'); ?></label>
        <input type="text" id="kek_package_title" name="kek_package_title" value="<?php echo esc_attr($package_title); ?>" style="width: 100%;" />
    </p>

    <p>
        <label for="kek_package_price"><?php _e('Price', 'kek'); ?></label>
        <input type="number" id="kek_package_price" name="kek_package_price" value="<?php echo esc_attr($package_price); ?>" style="width: 100%;" />
    </p>

    <p>
        <label for="kek_package_description"><?php _e('Description', 'kek'); ?></label>
        <textarea id="kek_package_description" name="kek_package_description" style="width: 100%;" rows="4"><?php echo esc_textarea($package_description); ?></textarea>
    </p>

    <hr>

    <h4><?php _e('Package Features', 'kek'); ?></h4>
    <p>
        <button type="button" class="btn btn-success" id="add-package-detail">
            <?php _e('Add Package Detail', 'kek'); ?>
        </button>
    </p>
    <div id="package-details-container">
        <?php
        if (!empty($package_details)) {
            foreach ($package_details as $index => $detail) {
                ?>
                <div class="package-detail">
                    <input type="text" name="package_details[<?php echo $index; ?>][title]" value="<?php echo esc_attr($detail['title']); ?>" placeholder="Number" style="width: 20%;" />
                    <input type="text" name="package_details[<?php echo $index; ?>][description]" value="<?php echo esc_attr($detail['description']); ?>" placeholder="Description" style="width: 75%;" />
                    <button type="button" class="btn btn-danger mt-3 mb-2 remove-package-detail">Remove</button>
                </div>
                <?php
            }
        }
        ?>
    </div>    

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            var detailIndex = <?php echo !empty($package_details) ? count($package_details) : 0; ?>;

            // Add new detail row
            $('#add-package-detail').on('click', function() {
                $('#package-details-container').append(
                    '<div class="package-detail">' +
                        '<input type="text" name="package_details[' + detailIndex + '][title]" placeholder="Title" style="width: 20%; margin-right: 5px;" />' +
                        '<input type="text" name="package_details[' + detailIndex + '][description]" placeholder="Description" style="width: 75%;" />' +
                        '<button type="button" class="btn btn-danger mt-3 mb-2 remove-package-detail">Remove</button>' +
                    '</div>'
                );
                detailIndex++;
            });

            // Remove detail row
            $(document).on('click', '.remove-package-detail', function() {
                $(this).closest('.package-detail').remove();
            });
        });
    </script>

    <?php
}

// Save the custom fields data
add_action('save_post', 'kek_save_all_time_package_data');
function kek_save_all_time_package_data($post_id) {
    // Check if nonce is set and verify
    if (!isset($_POST['kek_all_time_package_nonce']) || !wp_verify_nonce($_POST['kek_all_time_package_nonce'], 'kek_save_all_time_package')) {
        return;
    }

    // Save the checkbox value
    $is_all_time_package = isset($_POST['kek_all_time_package']) ? 'yes' : 'no';
    update_post_meta($post_id, '_kek_all_time_package', $is_all_time_package);

    // Save the title, price, description
    if (isset($_POST['kek_package_title'])) {
        update_post_meta($post_id, '_kek_package_title', sanitize_text_field($_POST['kek_package_title']));
    }

    if (isset($_POST['kek_package_price'])) {
        update_post_meta($post_id, '_kek_package_price', sanitize_text_field($_POST['kek_package_price']));
    }

    if (isset($_POST['kek_package_description'])) {
        update_post_meta($post_id, '_kek_package_description', wp_kses_post($_POST['kek_package_description']));
    }

    // Save the repeatable package details
    if (isset($_POST['package_details'])) {
        $package_details = array();
        foreach ($_POST['package_details'] as $detail) {
            $package_details[] = array(
                'title' => sanitize_text_field($detail['title']),
                'description'   => sanitize_text_field($detail['description'])
            );
        }
        update_post_meta($post_id, '_kek_package_details', $package_details);
    }
}

function kek_display_all_in_one_block() {
    global $post, $product;
    $is_all_time_package = get_post_meta($post->ID, '_kek_all_time_package', true);
    $title = get_post_meta($post->ID, '_kek_package_title', true);
    $price = get_post_meta($post->ID, '_kek_package_price', true);
    $description = get_post_meta($post->ID, '_kek_package_description', true);
    $package_details = get_post_meta($post->ID, '_kek_package_details', true);
    
    if(isset($is_all_time_package) && $is_all_time_package == 'yes'): ?>
    <section class="section-buy wcl-package-section">
        <div class="container">
            <div class="content-wrap">
                <div class="row">
                <div class="col col-12 col-lg-6">                    
                    <h2 class="all-in-one-title">All In One YouTube Subscribers Campaign</h2>
                    <div class="button-wrap">
                    <div class="label-red"> $68.00 </div>
                        <button type="button" class="kek-action-btn btn-black wcl_select_product_btn">
                            <span class="btn-circle"></span>
                            <span class="btn-circle"></span>
                            <span class="btn-circle"></span>
                            <strong>Buy now </strong>
                        </button> 
                    </div>
                    <div class="data-description">
                    <p data-pm-slice="1 1 []">Buy real YouTube subscribers from Views4You with an exclusive package, including <a href="https://views4you.com/buy-youtube-views/">buy YouTube Views</a> service to add more engagement to your videos. Also, you can <a href="https://views4you.com/buy-youtube-likes/">buy YouTube likes</a> service to increase your channel’s performance instantly. After your purchase, you can benefit from customer service at all hours of the day and night. </p>
                    </div>
                </div>
                <div class="col col-12 col-lg-6">
                    <div class="infoboxes">
                    <div class="col col-12 col-md-6">
                        <div class="infobox">
                        <div class="number"> 1000 </div>
                        <p> New active <br> subscribers at once </p>
                        </div>
                    </div>
                    <div class="col col-12 col-md-6">
                        <div class="infobox">
                        <div class="number"> 5000 </div>
                        <p> Views for <br> chosen video </p>
                        </div>
                    </div>
                    <div class="col col-12 col-md-6">
                        <div class="infobox">
                        <div class="number"> 500 </div>
                        <p> Likes for <br> chosen video </p>
                        </div>
                    </div>
                    <div class="col col-12 col-md-6">
                        <div class="infobox">
                        <div class="number"> 24/7 </div>
                        <p> Customers <br> Support </p>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="lines">
                <div class="line wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.75s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.75s; animation-name: fadeInLeft;">
                    <span></span>
                </div>
                <div class="line wow fadeInRight" data-wow-duration="1s" data-wow-delay="1.25s" style="visibility: visible; animation-duration: 1s; animation-delay: 1.25s; animation-name: fadeInRight;">
                    <span></span>
                </div>
                <div class="line wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.75s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.75s; animation-name: fadeInLeft;">
                    <span></span>
                </div>
                </div>
            </div>
        </div>
    </section>

    <?php endif;
}

add_action('display_all_in_one_block', 'kek_display_all_in_one_block');

?>