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
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => __('Text Color', 'kek'),
                    'param_name' => 'text_color',
                    'description' => __('Choose the text color.', 'kek'),
                ),
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
        $heading_text = esc_html($atts['heading_text']);
        $text_color = esc_attr($atts['text_color']);

        // Split the first word from the rest of the text
        $words = explode(' ', $heading_text, 2);
        $first_word = $words[0];
        $remaining_text = isset($words[1]) ? $words[1] : '';

        // Wrap the first word with a <span>
        $formatted_heading = '<span>' . $first_word . '</span> ' . $remaining_text;

        ob_start();
        ?>
        <div class="kek-heading twelve">
            <<?php echo $heading_level; ?> style="color: <?php echo $text_color; ?>;">
                <?php echo $formatted_heading; ?>
            </<?php echo $heading_level; ?>>
        </div>
        <style>
            <?php 
            $options = get_option('kek_SETTINGS_KEY');
            $main_color = esc_attr($options['main_color'] ?? '#1db954');    
            ?>
            .kek-heading {
                text-align: center;
                margin: 20px 0;
            }

            .kek-heading <?php echo $heading_level; ?> {
                font-size: 26px;
                font-weight: 700;
                letter-spacing: 1px;
                text-transform: uppercase;
                white-space: nowrap;
                position: relative;
            }

            .kek-heading <?php echo $heading_level; ?> span {
                color: <?php echo $main_color; ?>;
            }

            .kek-heading <?php echo $heading_level; ?>:after {
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
