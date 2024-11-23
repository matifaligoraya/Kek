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
                    'type' => 'textfield',
                    'heading' => __('Heading', 'kek'),
                    'param_name' => 'heading',
                    'description' => __('Enter the heading to display before the product list.', 'kek'),
                ),
                array(
                    'type' => 'textarea',
                    'heading' => __('Description', 'kek'),
                    'param_name' => 'description',
                    'description' => __('Enter a brief description to display before the product list.', 'kek'),
                ),
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
            'description' => '4',
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
        <?php if ($enable_overlay): ?>
            <div class="overlay"></div>
            <div class="rotate-img">
            <img src="<?php echo kek_URI ?>assets/images/info-box-bg-light.svg" style="width: 32px;" >

                  <div class="rotate-sty-2"></div>
              </div>
              <?php endif; ?>
            <div class="row">
                <div class="col">
                    <div class="twelve">
                        <h3><?php echo $atts['heading']; ?></h3>
                    </div>
                    <p >
                       <?php echo $atts['description']; ?>
                    </p>
                </div>
            </div>
          
            <div class="row">
                <?php while ($products->have_posts()): $products->the_post(); ?>
                    <?php
                    $product = wc_get_product(get_the_ID());
                    // print_r(get_post_meta(get_the_ID()));
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    $description = wp_trim_words(get_the_content(), 20, '...');
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
                    <div class="col-md-<?php echo ($display_style === 'grid') ? '4' : '12'; ?> pricing-table">

                        <div class="card shadow kek-info-box">

                            <h4 class="ls-0 fw-bold mb-3"><?php the_title(); ?></h4>
                            <p class="mb-5 text-black-50"><?php echo $description; ?></p>

                            <a href="<?php the_permalink(); ?>" Style="margin-bottom: 15px;"
                                class="btn w-100 text-white bg-color rounded-3 p-3 fw-bold animation-cloud-btn">
                                <span class="cloud-button-content">
                                    <i class="fa-solid fa-cart-shopping"></i>
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
                            <div class="row">
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