<?php
class WPBakeryKekAnimatedImageElement {
    public function __construct() {
        add_action('vc_before_init', array($this, 'register_elements'), 40);
        add_shortcode('kek_animated_image', array($this, 'render_kek_animated_image'), 40);
    }

    public function register_elements() {        
        vc_map(array(
            'name' => __('Kek Animated Image', 'kek'),
            'base' => 'kek_animated_image',
            'category' => __('Kek Essentials', 'kek'),
            'params' => array(               
                array(
                    'type' => 'attach_image',
                    'heading' => __('Side Image', 'kek'),                    
                    'param_name' => 'side_image',
                    'description' => __('Upload or select the side image.', 'kek'),
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => __('Main Image', 'kek'),
                    'param_name' => 'main_image',
                    'description' => __('Upload or select the main image.', 'kek'),
                ),
            ),
        ));
    }

    public function render_kek_animated_image($atts) {
        $atts = shortcode_atts(array(           
            'side_image' => '',
            'main_image' => '',
        ), $atts);

        // Get the image URLs
        $image_1_url = wp_get_attachment_image_url($atts['side_image'], 'full');
        $image_2_url = wp_get_attachment_image_url($atts['main_image'], 'full');

        ob_start();
        ?>

        <div class="slide-imgs" style="padding-left: 200px;">
            <?php if ($image_1_url) : ?>
                <img src="<?php echo esc_url($image_1_url); ?>" alt="Image" class="card-img">
            <?php endif; ?>
            <?php if ($image_2_url) : ?>
                <img src="<?php echo esc_url($image_2_url); ?>" alt="Image" class="iphone-img">
            <?php endif; ?>
        </div>

        <?php
        return ob_get_clean();
    }
}

// Instantiate the class
new WPBakeryKekAnimatedImageElement();
?>
