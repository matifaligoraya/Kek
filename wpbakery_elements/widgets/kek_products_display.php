<?php
class WPBakeryKekProductDisplayElement {
    public function __construct() {
        add_action('vc_before_init', array($this, 'register_elements'), 40);
        add_shortcode('kek_product_display', array($this, 'render_kek_product_display'), 40);

        // Hook for handling autocomplete AJAX
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
                    'value' => '4', // Default to 4 products
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

    public function render_kek_product_display($atts) {
        $atts = shortcode_atts(array(
            'categories' => '',
            'product_count' => '4',
            'display_style' => 'grid',
        ), $atts);

        $categories = explode(',', $atts['categories']);
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
        <div class="kek-product-display <?php echo $display_style; ?>">
            <div class="row">
                <?php while ($products->have_posts()): $products->the_post(); ?>
                    <div class="col-md-<?php echo ($display_style === 'grid') ? '3' : '12'; ?> product-item">
                        <div class="card">
                            <a href="<?php the_permalink(); ?>" class="product-image">
                                <?php the_post_thumbnail('medium', array('class' => 'img-fluid')); ?>
                            </a>
                            <div class="card-body">
                                <h5 class="product-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h5>
                                <div class="product-price">
                                    <?php echo wc_get_product(get_the_ID())->get_price_html(); ?>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary mt-3">
                                    <?php _e('View Product', 'kek'); ?>
                                </a>
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
