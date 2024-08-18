<?php
class WPBakeryKekStepsElement {
    public function __construct() {
        add_action('vc_before_init', array($this, 'register_elements'), 40);
        add_shortcode('kek_steps', array($this, 'render_kek_steps'), 40);        
    }

    public function register_elements() {
        // Register the Steps Element
        vc_map(array(
            'name' => __('Kek Steps', 'kek'),
            'base' => 'kek_steps',
            'category' => __('Kek Essentials', 'kek'),
            'params' => array(
                
            ),
        ));
    }

    public function render_kek_steps($atts) {
        $atts = shortcode_atts(array(
            
        ), $atts);    

        ob_start();
        ?>        
        <ul class="swiper-links-container list-unstyled">
            <li class="swiper-tab-link active">
                <h3 class="swiper-tab-title">Connect Your Apps</h3>
                <p class="swiper-tab-content">Bridging the gap between apps, simplifying tasks and maximizing productivity by fostering seamless communication and efficient synergy.</p>
                <div class="swiper-pagination-progress">
                    <span class="swiper-pagination-bar"></span><span class="swiper-pagination-bar-active"></span>
                </div>
            </li>
            <li class="swiper-tab-link">
                <h3 class="swiper-tab-title">Get More Features</h3>
                <p class="swiper-tab-content">Unleash your creativity with an expansive website builder toolkit, providing advanced features for unparalleled design and functionality.</p>
                <div class="swiper-pagination-progress">
                    <span class="swiper-pagination-bar"></span><span class="swiper-pagination-bar-active"></span>
                </div>
            </li>
            <li class="swiper-tab-link">
                <h3 class="swiper-tab-title">Automations to the Max</h3>
                <p class="swiper-tab-content">Empower your website with advanced automation tools, enhancing user experience through intelligent, streamlined processes and personalized interactions.</p>
                <div class="swiper-pagination-progress">
                    <span class="swiper-pagination-bar"></span><span class="swiper-pagination-bar-active"></span>
                </div>
            </li>
        </ul>        
        <?php
        return ob_get_clean();
    }
}

// Instantiate the class
new WPBakeryKekStepsElement();