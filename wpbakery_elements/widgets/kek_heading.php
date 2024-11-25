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
                )
              
            ),
        ));
    }

    public function render_kek_heading($atts) {
        $atts = shortcode_atts(array(
            'heading_level' => 'h1',
            'heading_text' => 'Your Heading',
            'text_color' => '#000000',
        ), $atts);

        $heading_level = esc_attr($atts['heading_level']);
        $heading_text = wp_kses_post(rawurldecode(base64_decode($atts['heading_text'])));
        $text_color = esc_attr($atts['text_color']);
        // Split the first word from the rest of the text
$words = explode(' ', $heading_text, 2); // Limit to 2 parts
$first_word = $words[0];
$remaining_text = isset($words[1]) ? $words[1] : '';

// Wrap the first word with a <span>
$heading_text = '<span>' . $first_word . '</span> ' . $remaining_text;

        ob_start();
        ?>
        <div class="twelve">
            <<?php echo $heading_level; ?> >
                <?php echo $heading_text; ?>
            </<?php echo $heading_level; ?>>
        </div>
        <style>
            <?php 
            $options = get_option(kek_SETTINGS_KEY);    
           // print_r($options );
            // Get the colors from theme options
            $main_color = esc_attr($options['main_color'] ?? '#1db954');    
            
            ?>
            .twelve <?php echo $heading_level; ?> {
                font-size: 26px;
                font-weight: 700;
                letter-spacing: 1px;
                text-transform: uppercase;
                text-align: center;
              
                white-space: nowrap;
                padding-bottom: 13px;
                position: relative;
            }

            .twelve {
                width: 100%;
            }

            .twelve h1 {
                width: max-content;
            }

            /* Before pseudo-element (left line) */
            .twelve <?php echo $heading_level; ?>:before {
                background-color: <?php echo $main_color; ?>;
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
                background-color: <?php echo $main_color; ?>;
                content: '';
                display: block;
                height: 3px;
                width: 75px;
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
