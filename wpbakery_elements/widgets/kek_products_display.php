<?php
class WPBakeryKekProductDisplayElement
{
    public function __construct()
    {
        add_action('vc_before_init', array($this, 'register_elements'), 40);
        add_shortcode('kek_product_display', array($this, 'render_kek_product_display'), 40);

        // Hooks for handling autocomplete AJAX
        add_filter('vc_autocomplete_kek_product_display_categories_callback', array($this, 'get_categories_for_autocomplete'), 10, 1);
        add_filter('vc_autocomplete_kek_product_display_categories_render', array($this, 'render_category_for_autocomplete'), 10, 1);
    }

    public function register_elements()
    {
        vc_map(array(
            'name' => __('Kek Product Display', 'kek'),
            'base' => 'kek_product_display',
            'category' => __('Kek Essentials', 'kek'),
            'params' => array(
             
                array(
                    'type' => 'autocomplete',
                    'heading' => __('Categories', 'kek'),
                    'param_name' => 'categories',
                    'description' => __('Select WooCommerce product categories.', 'kek'),
                    'settings' => array(
                        'multiple' => true,
                        'sortable' => true,
                        'unique_values' => true,
                    ),
                ),
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
                array(
                    'type' => 'checkbox',
                    'heading' => __('Enable Overlay on Images', 'kek'),
                    'param_name' => 'enable_overlay',
                    'description' => __('Check to enable an overlay effect on product images.', 'kek'),
                ),
            ),
        ));
    }

    public function render_kek_product_display($atts)
    {
        $atts = shortcode_atts(array(
            'categories' => '',
            'heading' => '4',
           
            'product_count' => '4',
            'display_style' => 'grid',
            'enable_overlay' => '',     
        ), $atts);
        $categories = explode(',', $atts['categories']);
        $enable_overlay = $atts['enable_overlay'] === 'true'; // Checkbox returns 'true' if checked
        $product_count = (int)$atts['product_count'];
        $display_style = esc_attr($atts['display_style']);

        // Query WooCommerce products
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $product_count,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $categories,
                ),
            ),

        );
        $products = new WP_Query($args);

        if (!$products->have_posts()) {
            return '<p>' . __('No products found.', 'kek') . '</p>';
        }

        ob_start();
?>
      <section class="kek-product-display <?php echo $display_style; ?>">
    <div class="container">
        <div class="row">
            <?php
            if ($products->have_posts()):
                while ($products->have_posts()): $products->the_post();
                    $product = wc_get_product(get_the_ID());
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    $title = get_the_title();
                    $description = wp_trim_words(get_the_content(), 20, '...');
                    $custom_tabs = get_post_meta(get_the_ID(), '_kek_custom_product_tabs', true);
                    $features = get_post_meta(get_the_ID(), '_product_features', true);
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
                    $price = $product->get_price_html();
                    $permalink = get_permalink();
                    ?>
                    <div class="col">
                        <div class="product-container">
                            <a href="<?php echo esc_url($permalink); ?>">
                            <div class="product-image">
                                <span class="hover-link"></span>
                                <span class="product-link">Buy</span>
                                <?php if (!empty($features)): ?>
                                    <div class="product-features">
                                        <?php foreach ($features as $feature): ?>
                                            <div class="feature">
                                                <i class="<?php echo esc_attr($feature['icon']); ?>"></i>
                                                <p><?php echo esc_html($feature['text']); ?></p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                <p class="price"> <?php if (!is_null($min_price)): ?>
                                        <span>Starting from <b ><?php echo wc_price($min_price); ?></b></span>
                                    <?php else: ?>
                                        <span> </span>
                                    <?php endif; ?></p>
                            </div>
                            <div class="product-description">
                            <div class="stars"  style="width: 100%;display: flex;font-size: 8px;">
                                    <?php for ($i = 0; $i < 5; $i++) : ?>
                                        <i class="fa fa-star float-end text-kek" style="margin-right: 3px; color: #d6bf04 !important;"></i>
                                    <?php endfor; ?>
                                </div>
                                <div class="product-label">
                                
                                    <div class="product-name">
                                        <h1 style="font-size: 100%;"><?php echo esc_html($title); ?></h1>
                                        
                                      
                                    </div>
                                </div>
                                <div class="product-option">
                                    <div class="product-size">
                                 <p style="font-size: 14px;"> <?php echo $description; ?></p> 
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            else: ?>
                <p class="col-12">No products found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
        wp_reset_postdata();

        return ob_get_clean();
    }


    public function render_category_for_autocomplete($query) {
        $term = get_term_by('slug', $query['value'], 'product_cat');

        if ($term) {
            return array(
                'value' => $term->slug,
                'label' => $term->name,
            );
        }

        return false;
    }
    public function get_categories_for_autocomplete($query) {
        $categories = get_terms(array(
            'taxonomy' => 'product_cat',
            'name__like' => $query,
            'hide_empty' => false,
        ));

        $suggestions = array();

        foreach ($categories as $category) {
            $suggestions[] = array(
                'value' => $category->slug,
                'label' => $category->name,
            );
        }

        return $suggestions;
    }

}

// Instantiate the class
new WPBakeryKekProductDisplayElement();
?>