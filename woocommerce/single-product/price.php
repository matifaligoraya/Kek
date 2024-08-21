<?php
global $product;

$custom_price_1 = get_post_meta($product->get_id(), 'custom_price_1', true);
$group_key_1 = get_post_meta($product->get_id(), 'group_key_1', true);

// Add additional prices and keys as needed.

if ($custom_price_1) {
    echo '<div class="custom-prices">';
    
    // Group 1
    if ($group_key_1) {
        echo '<h4>' . esc_html($group_key_1) . '</h4>';
        echo '<label><input type="radio" name="product_price" value="' . esc_attr($custom_price_1) . '"> ' . wc_price($custom_price_1) . '</label><br>';
    }

    // Add additional grouped prices if needed.

    echo '</div>';
}
