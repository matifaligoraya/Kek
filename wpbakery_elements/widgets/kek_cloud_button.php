<?php
class WPBakeryKekCloudButtonElement {
    public function __construct() {
        add_action('vc_before_init', array($this, 'register_elements'), 40);
        add_shortcode('kek_cloud_button', array($this, 'render_kek_cloud_button'), 40);        
    }

    public function register_elements() {
        // Register the Cloud button Element
        vc_map(array(
            'name' => __('Kek Cloud Button', 'kek'),
            'base' => 'kek_cloud_button',
            'category' => __('Kek Essentials', 'kek'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => __('Button Text', 'kek'),
                    'param_name' => 'button_text',
                    'description' => __('Enter the text for the button.', 'kek'),
                    'value' => 'Download Free',
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => __('Button Icon', 'kek'),
                    'param_name' => 'button_icon_class',
                    'description' => __('Select an icon for the button (optional).', 'kek'),
                    'settings' => array(
                        'emptyIcon' => true,
                        'iconsPerPage' => 200,
                    ),
                    'dependency' => array(
                        'element' => 'button_icon_class',
                        'not_empty' => true,
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Button Link', 'kek'),
                    'param_name' => 'button_link',
                    'description' => __('Enter the URL for the button.', 'kek'),
                    'value' => '#',
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => __('Background Color', 'kek'),
                    'param_name' => 'background_color',
                    'description' => __('Select the background color for the button.', 'kek'),
                    'value' => '#FF6347',
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => __('Hover Color', 'kek'),
                    'param_name' => 'hover_color',
                    'description' => __('Select the hover color for the button.', 'kek'),
                    'value' => '#FFD700',
                ), 
            ),
        ));
    }

    public function render_kek_cloud_button($atts) {
        $atts = shortcode_atts(array(
            'button_text' => 'Download Free',
            'button_icon_class' => '',
            'button_link' => '#',
            'background_color' => '#FF6347',
            'hover_color' => '#FFD700',
        ), $atts);    

        ob_start();
        ?>        
        <a href="<?php echo esc_url($atts['button_link']); ?>" 
           class="btn w-100 text-white bg-color rounded-3 p-3 fw-bold animation-cloud-btn kek-cloud-button"
           style="background-color: <?php echo esc_attr($atts['background_color']); ?> !important;">                    
            <span class="cloud-button-content">
                <?php if ($atts['button_icon_class']) : ?>
                    <i class="<?php echo esc_attr($atts['button_icon_class']); ?> cloud-button-icon mx-2"></i>
                <?php endif; ?>
                <?php echo esc_html($atts['button_text']); ?>
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
        <style>
            .kek-cloud-button.animation-cloud-btn:hover {
                background-color: <?php echo esc_attr($atts['hover_color']); ?>;
            }

            .kek-cloud-button.animation-cloud-btn:hover span.cloud-button-content {
                color: <?php echo esc_attr($atts['background_color']); ?>;
            }

            .kek-cloud-button.animation-cloud-btn:hover span.cloud-button-content i {
                color: <?php echo esc_attr($atts['background_color']); ?>;
            }
        </style>
        <?php
        return ob_get_clean();
    }
}

// Instantiate the class
new WPBakeryKekCloudButtonElement();