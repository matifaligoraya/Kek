<?php
defined( 'ABSPATH' ) || exit;

global $product;

// Get badge text from product meta
$badge_text = get_post_meta($product->get_id(), '_kek_product_title_badge', true);

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
    echo get_the_password_form();
    return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-content">
                <h1 class="product_title">
                    <?php
                    the_title();
                    if ($badge_text) {
                        echo ' <span class="product-title-badge">' . esc_html($badge_text) . '</span>';
                    }
                    ?>
                </h1>

                <div class="product-description">
                    <?php echo apply_filters('the_content', $product->get_description()); ?>
                </div>
            </div>

            <!-- Right Column: Custom Tabs with Options -->
            <div class="col-md-6">
                <div class="product-tabs">
                    <?php 
                    // Display the custom product tabs created
                    do_action('display_product_detail_tabs'); 
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php do_action('display_all_in_one_block'); ?>

    <?php
    /**
     * Hook: woocommerce_after_single_product.
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    do_action( 'woocommerce_after_single_product' );
    ?>
</div>