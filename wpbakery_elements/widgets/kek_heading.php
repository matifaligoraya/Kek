<?php
class WPBakeryKekHeadingElement {
    public function __construct() {
        add_action('vc_before_init', array($this, 'register_elements'), 40);
        add_shortcode('kek_heading', array($this, 'render_kek_heading'), 40);
    }

    public function register_elements() {
        vc_map(array(
            'name' => __('Kek Heading', 'kek'),
            'base' => 'kek_heading',
            'category' => __('Kek Essentials', 'kek'),
            'params' => array(
                array(
                    'type' => 'dropdown',
                    'heading' => __('Heading Level', 'kek'),
                    'param_name' => 'heading_level',
                    'value' => array(
                        __('H1', 'kek') => 'h1',
                        __('H2', 'kek') => 'h2',
                        __('H3', 'kek') => 'h3',
                        __('H4', 'kek') => 'h4',
                        __('H5', 'kek') => 'h5',
                        __('H6', 'kek') => 'h6',
                    ),
                    'description' => __('Select the heading level.', 'kek'),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Heading Text', 'kek'),
                    'param_name' => 'heading_text',
                    'value' => __('Your Heading', 'kek'),
                    'description' => __('Enter the heading text.', 'kek'),
                ), array(
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
            'heading_level' => 'h1',
            'heading_text' => 'Your Heading',
            'heading_color' => '#000000',
        ), $atts);
    
        $heading_level = esc_attr($atts['heading_level']); // Escape HTML-sensitive attributes
        $heading_text = $atts['heading_text']; // Trust content; sanitize selectively
        $heading_color = $atts['heading_color'];
    
        // Define allowed HTML tags
        $allowed_html = array(
            'span' => array('class' => array()),
            'i' => array('class' => array()),
            'b' => array(),
            'strong' => array(),
            'em' => array(),
            'u' => array(),
            'a' => array(
                'href' => array(),
                'target' => array(),
                'rel' => array(),
            ),
        );
    
        ob_start();
        ?>
        <div class="twelve">
            <<?php echo $heading_level; ?> >
                <?php echo wp_kses($heading_text, $allowed_html); ?>
            </<?php echo $heading_level; ?>>
        </div>
        <style>
            <?php 
            $options = get_option(kek_SETTINGS_KEY);    
            $main_color = esc_attr($options['main_color'] ?? '#ec3454');    
            ?>
            .twelve <?php echo $heading_level; ?> {
                font-size: 28px;
                font-weight: 700;
                letter-spacing: 1px;
                text-transform: uppercase;
                text-align: center;
                white-space: nowrap;
                padding-bottom: 13px;
                position: relative;
                color:  <?php echo !empty($heading_color) ? esc_attr($heading_color) : esc_attr($main_color); ?>;
            }
    
            .twelve {
                width: 100%;
            }
           
            .twelve h1 {
                width: max-content;
            }
    
            /* Before pseudo-element (left line) */
            .twelve <?php echo $heading_level; ?>:before {
                background-color: #ec3454;
                content: '';
                display: block;
                height: 3px;
                width: 75px;
                position: absolute;
                left: 0;
                top: -2%;
                transform: translateY(-50%);
            }
    
            /* After pseudo-element (right line) */
            .twelve <?php echo $heading_level; ?>:after {
                background-color: #ec3454;  
                content: '';
                display: block;
                height: 3px;
                width: 15px;
                position: absolute;
                right: 0;
                top: 80%;
                transform: translateY(-50%);
            }
        </style>
        <?php
        return ob_get_clean();
    }
    
}

// Instantiate the class
new WPBakeryKekHeadingElement();
