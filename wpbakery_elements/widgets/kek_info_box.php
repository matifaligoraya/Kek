<?php
class WPBakeryKekInfoBoxElement {
    public function __construct() {
        add_action('vc_before_init', array($this, 'register_elements'), 40);
        add_shortcode('kek_info_box', array($this, 'render_kek_info_box'), 40);        
    }

    public function register_elements() {
        // Register the Info Box Element
        vc_map(array(
            'name' => __('Kek Info Box', 'kek'),
            'base' => 'kek_info_box',
            'category' => __('Kek Essentials', 'kek'),
            'params' => array(
                array(
                    'type' => 'iconpicker',
                    'heading' => __('Icon', 'kek'),
                    'param_name' => 'icon_class',
                    'description' => __('Select an icon for the heading.', 'kek'),
                    'settings' => array(
                        'emptyIcon' => true,
                        'iconsPerPage' => 200,
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Category', 'kek'),
                    'param_name' => 'pre_title',
                    'description' => __('Enter the category for the info box.', 'kek'),
                    'value' => 'Startup',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Title', 'kek'),
                    'param_name' => 'title',
                    'description' => __('Enter the title (e.g., Free).', 'kek'),
                    'value' => 'Free',
                ),
                array(
                    'type' => 'textarea',
                    'heading' => __('Description', 'kek'),
                    'param_name' => 'description',
                    'description' => __('Enter the description for the info box.', 'kek'),
                    'value' => 'Phosfluorescently negotiate alternative human capital with fully tested leadership skills. Quickly enable.',
                ),
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
                    'description' => __('Select an icon for the button.', 'kek'),
                    'settings' => array(
                        'emptyIcon' => true,
                        'iconsPerPage' => 200,
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
                    'type' => 'textfield',
                    'heading' => __('Starting Price', 'kek'),
                    'param_name' => 'starting_price',
                    'description' => __('Enter the starting price.', 'kek'),
                    'value' => '$4.80',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Star Rating', 'kek'),
                    'param_name' => 'star_rating',
                    'description' => __('Enter the number of stars (1-5).', 'kek'),
                    'value' => '5',
                ),
            ),
        ));
    }

    public function render_kek_info_box($atts) {
        $atts = shortcode_atts(array(
            'icon_class' => 'fa fa-eye',
            'pre_title' => 'Startup',
            'title' => 'Free',
            'description' => 'Phosfluorescently negotiate alternative human capital with fully tested leadership skills. Quickly enable.',
            'button_text' => 'Download Free',
            'button_icon_class' => 'fa fa-download',
            'button_link' => '#',
            'starting_price' => '$4.80',
            'star_rating' => '5',
        ), $atts);

        $stars_html = '';
        for ($i = 0; $i < (int)$atts['star_rating']; $i++) {
            $stars_html .= '<i class="fa fa-star float-end text-kek"></i>';
        }

        ob_start();
        ?>
        <div class="col-md-12 pricing-table">
            <div class="card shadow kek-info-box">
                <h7 class="text-uppercase ls-1 mb-2">
                    <i class="<?php echo esc_attr($atts['icon_class']); ?> text-kek"></i>
                    <?php echo esc_html($atts['pre_title']); ?>
                </h7>
                <h3 class="ls-0 fw-bold mb-3"><?php echo esc_html($atts['title']); ?></h3>
                <p class="mb-5 text-black-50"><?php echo esc_html($atts['description']); ?></p>                

                <a href="<?php echo esc_url($atts['button_link']); ?>" class="btn w-100 text-white bg-color rounded-3 p-3 fw-bold animation-cloud-btn">                    
                    <span class="cloud-button-content">
                        <i class="<?php echo esc_attr($atts['button_icon_class']); ?> cloud-button-icon mx-2"></i> 
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
                <br />
                <div class="row">
                    <div class="col-md-6">
                        <span>Starting at <b class="text-kek"><?php echo esc_html($atts['starting_price']); ?></b></span>
                    </div>
                    <div class="col-md-6 stars">
                        <?php echo $stars_html; ?>
                    </div>
                </div>    
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Instantiate the class
new WPBakeryKekInfoBoxElement();