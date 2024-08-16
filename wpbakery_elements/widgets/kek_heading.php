<?php
class WPBakeryKekHeadingElement {
    public function __construct() {
        add_action('vc_before_init', array($this, 'register_elements'), 40);
        add_shortcode('kek_heading', array($this, 'render_kek_heading'), 40);
    }

    public function register_elements() {
        // Register the Heading Element
        vc_map(array(
            'name' => __('Kek Main Heading', 'kek'),
            'base' => 'kek_heading',
            'category' => __('Kek Essentials', 'kek'),
            'params' => array(                
                array(
                    'type' => 'textfield',
                    'heading' => __('Main Title', 'kek'),
                    'param_name' => 'main_title',
                    'description' => __('Enter the main title for the heading.', 'kek'),
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => __('Heading Color', 'kek'),
                    'param_name' => 'heading_color',
                    'description' => __('Choose a color for the heading text.', 'kek'),
                    'value' => '#ffffff', // Default color
                ),
            ),
        ));
    }

    public function render_kek_heading($atts) {
        $atts = shortcode_atts(array(            
            'main_title' => 'Our Design<br>Your Business.',            
            'heading_color' => '#ffffff', // Default color
        ), $atts);

        ob_start();
        ?>
        
        <h2 class="display-3 fw-bold" style="color: <?php echo esc_attr($atts['heading_color']); ?>; padding-left: 100px;">
            <?php echo wp_kses_post($atts['main_title']); ?>
        </h2>
        
        <?php
        return ob_get_clean();
    }
}

// Instantiate the class
new WPBakeryKekHeadingElement();
?>