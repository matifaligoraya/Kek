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
                        <div class="grey-title">
                            <p><?php echo esc_html($tab['tab_description']); ?></p>
                        </div>
                        <?php echo $this->render_products($tab['products']); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    function get_prefix_from_name($name, $delimiter = ' ') {
        $parts = explode($delimiter, $name);
        print_r($parts);
        return $parts[1]; // Return the first part as the prefix
    }

    function get_variation_attributes($attributes,$variation_id) {
      //  $variation_product = wc_get_product($variation_id);
     //   $attributes = $variation_product ? $variation_product->get_attributes() : array();
        $attribute_details = array();
    
        foreach ($attributes as $attribute_name => $attribute) {
            // Get attribute title (name) and its value(s)
            print_r($attribute_name);   
            if ($attribute->is_taxonomy()) {
                $term_names = wp_get_post_terms($variation_id, str_replace('pa_', '', $attribute_name), array('fields' => 'names'));
                $attribute_title = ucfirst(str_replace('pa_', '', $attribute_name)); // Assuming taxonomy attributes
            } else {
                $attribute_title = $attribute_name;
                $term_names = $attribute->get_options();
            }
            
            $attribute_details[] = array(
                'name' => $attribute_title,
                'value' => implode(', ', $term_names)
            );
        }
    
        return $attribute_details;
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
                    <?php foreach ($products as $product): ?>
                        <?php
                        // Ensure product_id is not null
                        if (!empty($product['product_id'])) {
                            // Get the main product using product ID
                            $product_post = wc_get_product($product['product_id']);
                            if ($product_post) {
                                // Check if the product has variations
                                if ($product_post->is_type('variable')) {
                                    $variations = $product_post->get_available_variations();
                                    foreach ($variations as $variation) {
                                       echo $variation_id = $variation['variation_id'];
                                        $variation_product = wc_get_product($variation_id);

                                      $v_attributes =  $variation_product->get_attributes();
                                      $attribute_name = "";
                                      //  $xyz = $this->get_variation_attributes($v_attributes,$variation_id);
                                       // print_r($xyz);
                                       foreach ($v_attributes as $att_name => $attribute) {
                                        // Get attribute title (name) and its value(s)
                                        $attribute_name = $att_name;
                                      //  print_r($attribute_name);  
                                       }
                                        $variation_name = $variation_product->get_name();
                                        $variation_price = $variation_product->get_price_html();
                                        $variation_url = $variation_product->add_to_cart_url();
                                         $delimiter = "-";
                                        // Extract the prefix
                                         //$prefix = $this->get_prefix_from_name($variation_name,$delimiter);
                                      
                                        ?>
                                        <div class="item" data-product-url="<?php echo esc_url($variation_url); ?>">
                                            <div class="btn-group" role="group">
                                                <div class="btn-radio">
                                                    <input type="radio" value="<?php echo esc_attr($variation_id); ?>" class="btn-check" name="product_select" id="btnradio-<?php echo esc_attr($variation_id); ?>" autocomplete="off">
                                                    <label class="btn" for="btnradio-<?php echo esc_attr($variation_id); ?>">
                                                        <div class="col left-col">
                                                            <span class="number"><?php echo esc_html($variation_name); ?> <?=$attribute_name  ?></span>
                                                        </div>
                                                        <div class="col right-col single">
                                                            <div class="price"><?php echo wp_kses_post($variation_price); ?></div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    // If not a variable product, render as a single option
                                    $product_name = $product_post->get_name();
                                    $product_price = $product_post->get_price_html();
                                    $product_url = $product_post->add_to_cart_url();
                                    ?>
                                    <div class="item" data-product-url="<?php echo esc_url($product_url); ?>">
                                        <div class="btn-group" role="group">
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
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo 'Invalid Product ID';
                            }
                        } else {
                            echo 'No Product ID';
                        }
                        ?>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-black wcl_select_product_btn" id="buy_now_btn"><strong>Buy now</strong></button>
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
