<?php
class WPBakeryProductTabElement {
    public function __construct() {
        add_action('vc_before_init', array($this, 'register_elements'), 20);
        add_shortcode('product_tabs', array($this, 'render_product_tabs'));
    }

    public function register_elements() {
        vc_map(array(
            'name' => __('Product Tab', 'text-domain'),
            'base' => 'product_tabs',
            'category' => __('Kek Essentials', 'kek'),
            'params' => array(
                array(
                    'type' => 'param_group',
                    'heading' => __('Tabs', 'text-domain'),
                    'param_name' => 'tabs',
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => __('Tab Title', 'text-domain'),
                            'param_name' => 'tab_title',
                            'description' => __('Title of the tab', 'text-domain'),
                        ),
                        array(
                            'type' => 'textarea',
                            'heading' => __('Tab Description', 'text-domain'),
                            'param_name' => 'tab_description',
                            'description' => __('Description inside the tab', 'text-domain'),
                        ),
                        array(
                            'type' => 'param_group',
                            'heading' => __('Products', 'text-domain'),
                            'param_name' => 'products',
                            'params' => array(
                                array(
                                    'type' => 'textfield',
                                    'heading' => __('Product ID', 'text-domain'),
                                    'param_name' => 'product_id',
                                    'description' => __('Enter the WooCommerce product ID directly.', 'text-domain'),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ));
    }

    public function render_product_tabs($atts) {
        $atts = shortcode_atts(array(
            'tabs' => '',
        ), $atts);

        $tabs = vc_param_group_parse_atts($atts['tabs']);

        ob_start();
        ?>
        <div class="banner-box">
            <div class="box-head">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <?php
                    $tab_count = 0;
                    foreach ($tabs as $tab) {
                        $tab_count++;
                        $active_class = ($tab_count == 1) ? 'active' : '';
                        ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo esc_attr($active_class); ?>" id="<?php echo sanitize_title($tab['tab_title']); ?>-tab" data-bs-toggle="tab" data-bs-target="#<?php echo sanitize_title($tab['tab_title']); ?>" type="button" role="tab" aria-controls="<?php echo sanitize_title($tab['tab_title']); ?>" aria-selected="true">
                                <?php echo esc_html($tab['tab_title']); ?>
                            </button>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="tab-content" id="myTabContent">
                <?php
                $tab_content_count = 0;
                foreach ($tabs as $tab) {
                    $tab_content_count++;
                    $active_class = ($tab_content_count == 1) ? 'active show' : '';
                    ?>
                    <div class="tab-pane fade <?php echo esc_attr($active_class); ?>" id="<?php echo sanitize_title($tab['tab_title']); ?>" role="tabpanel" aria-labelledby="<?php echo sanitize_title($tab['tab_title']); ?>-tab">
                    <?php if(!empty($tab['tab_description'])) : ?>
                        <div class="grey-title">
                                <p><?php echo esc_html($tab['tab_description']); ?></p>
                            </div>
                            <?php echo $this->render_products($tab['products']); ?>
                        </div>
                    <?php endif ?>
                <?php } ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    private function render_products($products) {
        ob_start();
        
        // Decode the JSON-encoded string into a PHP array
        $products = vc_param_group_parse_atts($products);
        
        // Check if decoding was successful and $products is an array
        if (is_array($products)) {
            ?>
            <form class="wcl-form">
                <div class="kek-owl-carousel">
                <?php
                    $item_count = 0;
                    $radio_count = 0;
                    $first_item = true;
                    foreach ($products as $product):
                        // Ensure product_id is not null
                        if (!empty($product['product_id'])) {
                            // Get the main product using product ID
                            $product_post = wc_get_product($product['product_id']);
                            if ($product_post) {
                                // Check if the product has variations
                                if ($product_post->is_type('variable')) {
                                    $variations = $product_post->get_available_variations();
                                    foreach ($variations as $variation) {
                                        $variation_id = $variation['variation_id'];
                                        $variation_product = wc_get_product($variation_id);
                                        $variation_name = $variation_product->get_name();
                                        $variation_desc = $variation_product->get_description();
                                        $variation_url = $variation_product->add_to_cart_url();

                                        $regular_price = $variation_product->get_regular_price();
                                        $sale_price = $variation_product->get_sale_price();

                                        // Get the variation attributes
                                        $v_attributes = $variation_product->get_attributes();
                                        $attribute_name = "";
                                        foreach ($v_attributes as $att_name => $attribute) {
                                            $attribute_name = $att_name;
                                        }

                                        // Start a new item div if necessary
                                        if ($first_item && $radio_count == 0) {
                                            echo '<div class="item"><div class="btn-group" role="group">';
                                        } elseif (!$first_item && $radio_count % 4 == 0) {
                                            echo '</div></div><div class="item"><div class="btn-group" role="group">';
                                        }

                                        $radio_count++;
                                        ?>
                                        <div class="btn-radio <?php echo empty($sale_price) ? 'wcl-big-btn-radio' : ''; ?>">
                                            <input type="radio" value="<?php echo esc_attr($variation_id); ?>" class="btn-check" name="product_select" id="btnradio-<?php echo esc_attr($variation_id); ?>" autocomplete="off">
                                            <label class="btn" for="btnradio-<?php echo esc_attr($variation_id); ?>">
                                                <div class="col left-col">
                                                    <span class="number"><?php echo esc_html($v_attributes[strtolower($attribute_name)]); ?></span>
                                                    <span><?php echo esc_html($attribute_name); ?></span>
                                                </div>
                                                <div class="col right-col">
                                                    <div class="price">
                                                        <span class="old-price"><?php echo $regular_price; ?></span>
                                                        <?php if ($sale_price) : ?>
                                                            <span class="new-price"><?php echo $sale_price; ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if ($sale_price) : ?>
                                                        <?php
                                                        $discount = (($regular_price - $sale_price) / $regular_price) * 100;
                                                        $discount_percentage = round($discount);
                                                        ?>
                                                        <span class="save">save <?php echo esc_html($discount_percentage); ?>%</span>
                                                    <?php else : ?>
                                                        <span class="save">Free</span>
                                                    <?php endif; ?>
                                                </div>
                                            </label>
                                        </div>
                                        <?php

                                        if ($first_item && $radio_count == 5) {
                                            $first_item = false;
                                            $radio_count = 0;
                                            echo '</div></div>';
                                        }
                                    }
                                } else {
                                    // If not a variable product, render as a single option
                                    if ($first_item && $radio_count == 0) {
                                        echo '<div class="item"><div class="btn-group" role="group">';
                                    } elseif (!$first_item && $radio_count % 4 == 0) {
                                        echo '</div></div><div class="item"><div class="btn-group" role="group">';
                                    }

                                    $product_name = $product_post->get_name();
                                    $product_price = $product_post->get_price_html();
                                    $product_url = $product_post->add_to_cart_url();

                                    $radio_count++;
                                    ?>
                                    <div class="btn-radio">
                                        <input type="radio" value="<?php echo esc_attr($product['product_id']); ?>" class="btn-check" name="product_select" id="btnradio-<?php echo esc_attr($product['product_id']); ?>" autocomplete="off">
                                        <label class="btn" for="btnradio-<?php echo esc_attr($product['product_id']); ?>">
                                            <div class="col left-col">
                                                <span class="number"><?php echo esc_html($product_name); ?></span>
                                            </div>
                                            <div class="col right-col single">
                                                <div class="price"><?php echo wp_kses_post($product_price); ?></div>
                                            </div>
                                        </label>
                                    </div>
                                    <?php

                                    if ($first_item && $radio_count == 5) {
                                        $first_item = false;
                                        $radio_count = 0;
                                        echo '</div></div>';
                                    }
                                }
                            } else {
                                echo '';
                            }
                        } else {
                            echo '';
                        }
                    endforeach;

                    // Close the last item and btn-group divs
                    if ($radio_count > 0) {
                        echo '</div></div>';
                    }
                    ?>

                </div>                
                <a id="buy_now_btn" class="btn w-100 text-white bg-color rounded-3 p-3 fw-bold animation-cloud-btn" style="height:60px !important;">                    
                    <span class="cloud-button-content">
                        Buy Now
                    </span>
                    <span class="animation-cloud-btn-inner">
                        <span class="animation-cloud-parts">
                            <span class="animation-cloud-part"></span>
                            <span class="animation-cloud-part"></span>
                            <span class="animation-cloud-part"></span>
                            <span class="animation-cloud-part"></span>
                        </span>
                    </span>
                </a>                
            </form>
            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', function () {
                    var buyNowBtn = document.getElementById('buy_now_btn');
                    buyNowBtn.addEventListener('click', function () {
                        var selectedProduct = document.querySelector('input[name="product_select"]:checked');
                        if (selectedProduct) {
                            var productUrl = selectedProduct.closest('.item').dataset.productUrl;
                            if (productUrl !== '#') {
                                window.location.href = productUrl;
                            } else {
                                alert('Product is not available.');
                            }
                        } else {
                            alert('Please select a product first.');
                        }
                    });
                });
            </script>
            <?php
        } else {
            echo 'No products available.';
        }
        echo '<script>'."document.addEventListener('DOMContentLoaded', function () {
    // Initialize all carousels
    document.querySelectorAll('.kek-owl-carousel').forEach(function(carousel) {
        $(carousel).owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            items: 1
        });
    });
});
".'</script>';
        return ob_get_clean();
    }
    
    
}

// Instantiate the class
new WPBakeryProductTabElement();
