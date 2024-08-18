<?php
class WPBakeryKekBrandsElement {
    public function __construct() {
        add_action('vc_before_init', array($this, 'register_elements'), 40);
        add_shortcode('kek_brands', array($this, 'render_kek_brands'), 40);
    }

    public function register_elements() {
        // Register the Brands Element
        vc_map(array(
            'name' => __('Kek Brands', 'kek'),
            'base' => 'kek_brands',
            'category' => __('Kek Essentials', 'kek'),
            'params' => array(
                array(
                    'type' => 'attach_image',
                    'heading' => __('Brand Image 1', 'kek'),
                    'param_name' => 'brand_image_1',
                    'description' => __('Upload the first brand image.', 'kek'),
                    'admin_label' => true,
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => __('Brand Image 2', 'kek'),
                    'param_name' => 'brand_image_2',
                    'description' => __('Upload the second brand image.', 'kek'),
                    'admin_label' => true,
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => __('Brand Image 3', 'kek'),
                    'param_name' => 'brand_image_3',
                    'description' => __('Upload the third brand image.', 'kek'),
                    'admin_label' => true,
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => __('Brand Image 4', 'kek'),
                    'param_name' => 'brand_image_4',
                    'description' => __('Upload the fourth brand image.', 'kek'),
                    'admin_label' => true,
                ),
            ),
        ));
    }

    public function render_kek_brands($atts) {
        $atts = shortcode_atts(array(
            'brand_image_1' => '',
            'brand_image_2' => '',
            'brand_image_3' => '',
            'brand_image_4' => '',
        ), $atts);

        // Get image URLs
        $brand_images = array(
            wp_get_attachment_image_url($atts['brand_image_1'], 'full'),
            wp_get_attachment_image_url($atts['brand_image_2'], 'full'),
            wp_get_attachment_image_url($atts['brand_image_3'], 'full'),
            wp_get_attachment_image_url($atts['brand_image_4'], 'full'),
        );

        ob_start();
        ?>
        <div class="section-clients">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-7 d-flex align-items-lg-center flex-row">
                        <?php foreach ($brand_images as $image): ?>
                            <?php if (!empty($image)): ?>
                                <div class="col">
                                    <img src="<?php echo esc_url($image); ?>" alt="Clients">
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Instantiate the class
new WPBakeryKekBrandsElement();
