<?php
class WPBakeryKekProductDisplayElement {
    public function __construct() {
        add_action('vc_before_init', array($this, 'register_elements'), 40);
        add_shortcode('kek_product_display', array($this, 'render_kek_product_display'), 40);

        // Hooks for handling autocomplete AJAX
        add_filter('vc_autocomplete_kek_product_display_categories_callback', array($this, 'get_categories_for_autocomplete'), 10, 1);
        add_filter('vc_autocomplete_kek_product_display_categories_render', array($this, 'render_category_for_autocomplete'), 10, 1);
    }

    public function register_elements() {
        vc_map(array(
            'name' => __('Kek Product Display', 'kek'),
            'base' => 'kek_product_display',
            'category' => __('Kek Essentials', 'kek'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => __('Number of Products', 'kek'),
                    'param_name' => 'product_count',
                    'description' => __('Enter the number of products to display.', 'kek'),
                    'value' => '4',
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __('Display Style', 'kek'),
                    'param_name' => 'display_style',
                    'value' => array(
                        __('Grid', 'kek') => 'grid',
                        __('List', 'kek') => 'list',
                    ),
                    'description' => __('Choose how to display the products.', 'kek'),
                ),
            ),
        ));
    }

    public function render_kek_product_display($atts) {
        $atts = shortcode_atts(array(
            'product_count' => '4',
            'display_style' => 'grid',
        ), $atts);
    
        $product_count = (int)$atts['product_count'];
        $display_style = esc_attr($atts['display_style']);
    
        // Query WooCommerce products
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $product_count,
        );
        $products = new WP_Query($args);
    
        if (!$products->have_posts()) {
            return '<p>' . __('No products found.', 'kek') . '</p>';
        }
    
        ob_start();
        ?>
        <div class="kek-product-display <?php echo $display_style; ?>">
            <div class="row">
                <?php while ($products->have_posts()): $products->the_post(); ?>
                    <?php 
                        $product = wc_get_product(get_the_ID());
                       // print_r(get_post_meta(get_the_ID()));
                        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                        $description = wp_trim_words(get_the_content(), 30, '...');
                        $custom_tabs = get_post_meta(get_the_ID(), '_kek_custom_product_tabs', true);
                       // print_r(value: $custom_tabs);
                        // Calculate the minimum "New Price" from options
                        $min_price = null;
                        if (!empty($custom_tabs)) {
                            foreach ($custom_tabs as $tab) {
                                if (!empty($tab['options'])) {
                                    foreach ($tab['options'] as $option) {
                                        if (isset($option['price']) && is_numeric($option['price'])) {
                                            $price = (float)$option['price'];
                                            $min_price = is_null($min_price) ? $price : min($min_price, $price);
                                        }
                                    }
                                }
                            }
                        }
                       // echo  $min_price ;
                    ?>
                <div class="col-md-<?php echo ($display_style === 'grid') ? '3' : '12'; ?> pricing-table">
                    
            <div class="card shadow kek-info-box">
                
                <h4 class="ls-0 fw-bold mb-3"><?php the_title(); ?></h4>
                <p class="mb-5 text-black-50"><?php echo $description; ?></p>                

                <a href="<?php the_permalink(); ?>"  Style="margin-bottom: 15px;"
                class="btn w-100 text-white bg-color rounded-3 p-3 fw-bold animation-cloud-btn">                    
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
                <br />
                <div class="row" >
                                    <div class="col-md-6">
                                        <?php if (!is_null($min_price)): ?>
                                            <span>Starting at <b class="text-kek"><?php echo wc_price($min_price); ?></b></span>
                                        <?php else: ?>
                                            <span> </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 stars">
                                        <?php for ($i = 0; $i < 5; $i++) : ?>
                                            <i class="fa fa-star float-end text-kek"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>    

            </div>
        </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php
        wp_reset_postdata();
    
        return ob_get_clean();
    }
    
}

// Instantiate the class
new WPBakeryKekProductDisplayElement();
?>
