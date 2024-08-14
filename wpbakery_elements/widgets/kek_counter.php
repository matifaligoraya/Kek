<?php
class WPBakeryKekCounterElement {
    public function __construct() {
        add_action('vc_before_init', array($this, 'register_elements'), 40);
        add_shortcode('kek_counter', array($this, 'render_kek_counter'), 40);        
    }

    public function register_elements() {
        // Register the Counter Element
        vc_map(array(
            'name' => __('Kek Counter', 'kek'),
            'base' => 'kek_counter',
            'category' => __('Kek Essentials', 'kek'),
            'params' => array(
                array(
                    'type' => 'iconpicker',
                    'heading' => __('Icon', 'kek'),
                    'param_name' => 'icon_class',
                    'description' => __('Select an icon for the counter.', 'kek'),
                    'settings' => array(
                        'emptyIcon' => true,
                        'iconsPerPage' => 200,
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Count From', 'kek'),
                    'param_name' => 'count_from',
                    'description' => __('Enter the starting number for the counter.', 'kek'),
                    'value' => '100',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Count To', 'kek'),
                    'param_name' => 'count_to',
                    'description' => __('Enter the ending number for the counter.', 'kek'),
                    'value' => '8465',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Postfix', 'kek'),
                    'param_name' => 'count_postfix',
                    'description' => __('Enter a postfix for the counter value (e.g., K, M).', 'kek'),
                    'value' => '',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Speed', 'kek'),
                    'param_name' => 'speed',
                    'description' => __('Enter the speed of the counter animation in milliseconds.', 'kek'),
                    'value' => '2000',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Refresh Interval', 'kek'),
                    'param_name' => 'refresh_interval',
                    'description' => __('Enter the refresh interval of the counter in milliseconds.', 'kek'),
                    'value' => '50',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Title', 'kek'),
                    'param_name' => 'title',
                    'description' => __('Enter the title for the counter.', 'kek'),
                    'value' => 'Clients Served',
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => __('Counter Color', 'kek'),
                    'param_name' => 'counter_color',
                    'description' => __('Pick a color for the counter number.', 'kek'),
                    'value' => '#FF6347',
                ),
            ),
        ));
    }

    public function render_kek_counter($atts) {
        $atts = shortcode_atts(array(
            'icon_class' => '',
            'count_from' => '100',
            'count_to' => '8465',
            'count_postfix' => '',
            'speed' => '2000',
            'refresh_interval' => '50',
            'title' => 'Clients Served',
            'counter_color' => '#FF6347',
        ), $atts);

        ob_start();
        ?>
        <div class="col-sm-6 col-lg-12 text-center">
            <?php if ($atts['icon_class']) : ?>
                <i class="i-plain i-xlarge mx-auto mb-0 <?php echo esc_attr($atts['icon_class']); ?>"></i>
            <?php endif; ?>
            <div class="counter counter-large d-flex justify-content-center" style="color: <?php echo esc_attr($atts['counter_color']); ?>;">                            
                <span data-from="<?php echo esc_attr($atts['count_from']); ?>" 
                      data-to="<?php echo esc_attr($atts['count_to']); ?>" 
                      data-refresh-interval="<?php echo esc_attr($atts['refresh_interval']); ?>" 
                      data-speed="<?php echo esc_attr($atts['speed']); ?>">
                      <?php echo esc_html($atts['count_to']); ?>                      
                </span>
                <p class="mx-2"><?php echo esc_html($atts['count_postfix']); ?></span>
            </div>
            <h5 class="fw-bold"><?php echo esc_html($atts['title']); ?></h5>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Instantiate the class
new WPBakeryKekCounterElement();