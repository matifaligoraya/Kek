<?php
class WPBakeryKekSliderElement {
    public function __construct() {
        add_action('vc_before_init', array($this, 'register_elements'), 40);
        add_shortcode('kek_slider', array($this, 'render_kek_slider'), 40);
    }

    public function register_elements() {
        // Register the Slider Element
        vc_map(array(
            'name' => __('Kek Slider', 'kek'),
            'base' => 'kek_slider',
            'category' => __('Kek Essentials', 'kek'),
            'params' => array(
                array(
                    'type' => 'attach_image',
                    'heading' => __('Background Image', 'kek'),
                    'param_name' => 'background_image',
                    'description' => __('Select a background image for the slider.', 'kek'),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Main Title', 'kek'),
                    'param_name' => 'main_title',
                    'description' => __('Enter the main title for the slider.', 'kek'),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Subtitle', 'kek'),
                    'param_name' => 'subtitle',
                    'description' => __('Enter the subtitle for the slider.', 'kek'),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('App Store Link', 'kek'),
                    'param_name' => 'app_store_link',
                    'description' => __('Enter the App Store link.', 'kek'),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Play Store Link', 'kek'),
                    'param_name' => 'play_store_link',
                    'description' => __('Enter the Play Store link.', 'kek'),
                ),
            ),
        ));
    }

    public function render_kek_slider($atts) {
        $atts = shortcode_atts(array(
            'background_image' => '',
            'main_title' => 'Our Design<br>Your Business.',
            'subtitle' => 'Best Wallet App for your upcoming Projects.',
            'app_store_link' => '#',
            'play_store_link' => '#',
        ), $atts);

        $bg_image_url = wp_get_attachment_image_url($atts['background_image'], 'full');

        ob_start();
        ?>
        <!-- Slider -->
        <section id="slider" class="slider-element dark min-vh-100 " style="background-image: url('<?php echo esc_url($bg_image_url); ?>');">
            <div class="slider-inner flex-column">

                <div class="vertical-middle">
                    <div class="container">
                        <div class="row align-items-lg-center g-0">

                            <div class="col-lg-6 col-md-6">
                                <h2 class="display-3 fw-bold text-white"><?php echo wp_kses_post($atts['main_title']); ?></h2>
                                <p class="lead mb-4 fw-normal"><?php echo esc_html($atts['subtitle']); ?></p>
                                <div>
                                    <a href="<?php echo esc_url($atts['app_store_link']); ?>" class="btn mt-2 text-dark bg-white rounded-3 px-4 py-3 text-transform-none ls-0 shadow-sm">
                                        <i class="fa-brands fa-apple me-2"></i>Get it on the App Store
                                    </a>
                                    <a href="<?php echo esc_url($atts['play_store_link']); ?>" class="ms-0 ms-lg-2 mt-2 btn text-dark bg-white rounded-3 px-4 py-3 text-transform-none ls-0 shadow-sm">
                                        <i class="fa-brands fa-google-play me-2"></i>Get it on Play Store
                                    </a>
                                </div>
                                <p class="text-white-50 text-uppercase mt-2 ls-1 fw-medium"><small>Sign up &amp; Get 30 Days Free trial</small></p>
                            </div>

                            <div class="col-lg-1 d-md-none d-lg-block"></div>

                            <div class="col-lg-5 col-md-6 align-self-lg-end">
                                <div class="slide-imgs">
                                    <img src="demos/landing/images/hero/1-2.png" alt="Image" class="card-img">
                                    <img src="demos/landing/images/hero/1-1.png" alt="Image" class="iphone-img">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="section-clients">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 col-md-7 d-flex align-items-lg-center flex-row">
                                <div class="col"><img src="demos/conference/images/sponcors/amazon.svg" alt="Clients"></div>
                                <div class="col"><img src="demos/conference/images/sponcors/netflix.svg" alt="Clients"></div>
                                <div class="col"><img src="demos/conference/images/sponcors/google.svg" alt="Clients"></div>
                                <div class="col"><img src="demos/conference/images/sponcors/linkedin.svg" alt="Clients"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section><!-- #slider end -->
        <?php
        return ob_get_clean();
    }
}

// Instantiate the class
new WPBakeryKekSliderElement();