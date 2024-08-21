<?php
add_action('add_meta_boxes', 'custom_product_tabs_meta_box');
function custom_product_tabs_meta_box() {
    add_meta_box(
        'custom_product_tabs',
        __('Product Custom Tabs', 'your-textdomain'),
        'custom_product_tabs_callback',
        'product',
        'normal',
        'high'
    );
}

function custom_product_tabs_callback($post) {
    wp_nonce_field(basename(__FILE__), 'custom_product_tabs_nonce');
    $stored_meta = get_post_meta($post->ID, '_custom_product_tabs', true);
    ?>

    <div id="custom_tabs_container">
        <div id="custom_tabs">
            <?php
            if (!empty($stored_meta)) {
                foreach ($stored_meta as $index => $tab) {
                    ?>
                    <div class="custom_tab">
                        <h3><?php _e('Tab', 'your-textdomain'); ?> <?php echo ($index + 1); ?></h3>
                        <p>
                            <label for="custom_product_tabs[<?php echo $index; ?>][title]"><?php _e('Tab Title', 'your-textdomain'); ?></label>
                            <input type="text" name="custom_product_tabs[<?php echo $index; ?>][title]" value="<?php echo esc_attr($tab['title']); ?>" />
                        </p>
                        <p>
                            <label for="custom_product_tabs[<?php echo $index; ?>][description]"><?php _e('Tab Description', 'your-textdomain'); ?></label>
                            <textarea name="custom_product_tabs[<?php echo $index; ?>][description]"><?php echo esc_html($tab['description']); ?></textarea>
                        </p>
                        <p>
                            <label><?php _e('Options', 'your-textdomain'); ?></label>
                            <ul>
                                <?php foreach ($tab['options'] as $option_index => $option) { ?>
                                    <li>
                                        <input type="text" name="custom_product_tabs[<?php echo $index; ?>][options][<?php echo $option_index; ?>][title]" value="<?php echo esc_attr($option['title']); ?>" placeholder="<?php _e('Option Title', 'your-textdomain'); ?>" />
                                        <input type="number" name="custom_product_tabs[<?php echo $index; ?>][options][<?php echo $option_index; ?>][price]" value="<?php echo esc_attr($option['price']); ?>" placeholder="<?php _e('Option Price', 'your-textdomain'); ?>" step="0.01" />
                                        <a href="#" class="remove_option"><?php _e('Remove', 'your-textdomain'); ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                            <button class="add_option button"><?php _e('Add Option', 'your-textdomain'); ?></button>
                        </p>
                        <a href="#" class="remove_tab"><?php _e('Remove Tab', 'your-textdomain'); ?></a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <button id="add_tab" class="button"><?php _e('Add Tab', 'your-textdomain'); ?></button>
    </div>

    <?php
}

add_action('save_post', 'save_custom_product_tabs');
function save_custom_product_tabs($post_id) {
    if (!isset($_POST['custom_product_tabs_nonce']) || !wp_verify_nonce($_POST['custom_product_tabs_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    $new_data = array();
    if (isset($_POST['custom_product_tabs'])) {
        $tabs = $_POST['custom_product_tabs'];

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

    update_post_meta($post_id, '_custom_product_tabs', $new_data);
}
add_filter('woocommerce_product_tabs', 'add_dynamic_custom_product_tabs');
function add_dynamic_custom_product_tabs($tabs) {
    global $post;

    $custom_tabs = get_post_meta($post->ID, '_custom_product_tabs', true);
    if (!empty($custom_tabs)) {
        foreach ($custom_tabs as $index => $tab) {
            $tabs['custom_tab_' . $index] = array(
                'title' => $tab['title'],
                'priority' => 50 + $index,
                'callback' => function() use ($tab) {
                    echo '<h2>' . esc_html($tab['description']) . '</h2>';

                    if (!empty($tab['options'])) {
                        echo '<ul>';
                        foreach ($tab['options'] as $option) {
                            echo '<li>';
                            echo '<label>';
                            echo '<input type="radio" name="product_price" value="' . esc_attr($option['price']) . '" class="custom-option">';
                            echo esc_html($option['title']) . ' - $' . esc_html($option['price']);
                            echo '</label>';
                            echo '</li>';
                        }
                        echo '</ul>';
                    }
                }
            );
        }
    }
    return $tabs;
}
function custom_product_tabs_script() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            function updateTabNames() {
                $('#custom_tabs .custom_tab').each(function(index) {
                    $(this).find('h3').text('<?php _e('Tab', 'your-textdomain'); ?> ' + (index + 1));
                });
            }

            $('#add_tab').on('click', function(e) {
                e.preventDefault();

                var tabCount = $('#custom_tabs .custom_tab').length;
                var newTab = $('<div class="custom_tab">' +
                    '<h3><?php _e('Tab', 'your-textdomain'); ?> ' + (tabCount + 1) + '</h3>' +
                    '<p><label><?php _e('Tab Title', 'your-textdomain'); ?></label>' +
                    '<input type="text" name="custom_product_tabs[' + tabCount + '][title]" /></p>' +
                    '<p><label><?php _e('Tab Description', 'your-textdomain'); ?></label>' +
                    '<textarea name="custom_product_tabs[' + tabCount + '][description]"></textarea></p>' +
                    '<p><label><?php _e('Options', 'your-textdomain'); ?></label>' +
                    '<ul></ul><button class="add_option button"><?php _e('Add Option', 'your-textdomain'); ?></button></p>' +
                    '<a href="#" class="remove_tab"><?php _e('Remove Tab', 'your-textdomain'); ?></a>' +
                    '</div>');

                $('#custom_tabs').append(newTab);
                updateTabNames();
            });

            $(document).on('click', '.add_option', function(e) {
                e.preventDefault();

                var tab = $(this).closest('.custom_tab');
                var optionCount = tab.find('ul li').length;
                var newOption = $('<li>' +
                    '<input type="text" name="custom_product_tabs[' + tab.index() + '][options][' + optionCount + '][title]" placeholder="<?php _e('Option Title', 'your-textdomain'); ?>" />' +
                    '<input type="number" name="custom_product_tabs[' + tab.index() + '][options][' + optionCount + '][price]" placeholder="<?php _e('Option Price', 'your-textdomain'); ?>" step="0.01" />' +
                    '<a href="#" class="remove_option"><?php _e('Remove', 'your-textdomain'); ?></a>' +
                    '</li>');

                tab.find('ul').append(newOption);
            });

            $(document).on('click', '.remove_tab', function(e) {
                e.preventDefault();
                $(this).closest('.custom_tab').remove();
                updateTabNames();
            });

            $(document).on('click', '.remove_option', function(e) {
                e.preventDefault();
                $(this).closest('li').remove();
            });
        });
    </script>
    <?php
}
add_action('admin_footer', 'custom_product_tabs_script');

?>