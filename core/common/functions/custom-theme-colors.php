<?php
function hex_to_rgb($hex) {
    $hex = ltrim($hex, '#');
    if (strlen($hex) == 6) {
        list($r, $g, $b) = array($hex[0].$hex[1], $hex[2].$hex[3], $hex[4].$hex[5]);
    } elseif (strlen($hex) == 3) {
        list($r, $g, $b) = array($hex[0].$hex[0], $hex[1].$hex[1], $hex[2].$hex[2]);
    } else {
        return '0, 0, 0';
    }
    return implode(', ', array_map(function($c) { return hexdec($c); }, array($r, $g, $b)));
}

function kek_customize_css() {    
    $options = get_option(kek_SETTINGS_KEY);    
    
    // Get the colors from theme options
    $main_color = esc_attr($options['main_color'] ?? '#1db954');    
    $heading_color = esc_attr($options['heading_color'] ?? '#212529');
    $body_text_color = esc_attr($options['body_text_color'] ?? '#495057');
    $button_bg_color = esc_attr($options['button_bg_color'] ?? '#0d6efd');
    $button_text_color = esc_attr($options['button_text_color'] ?? '#ffffff');
    
    // Custom link colors
    $link_color = esc_attr($options['link_color'] ?? '#0d6efd');
    $link_hover_color = esc_attr($options['link_hover_color'] ?? '#0a58ca');
    
    // Convert main color to RGB if not provided
    $main_color_rgb = isset($options['main_color_rgb']) ? esc_attr($options['main_color_rgb']) : hex_to_rgb($main_color);
    
    ?>
    <style type="text/css">
        :root {
            --kek-themecolor: <?php echo $main_color; ?>;
            --kek-themecolor-rgb: <?php echo $main_color_rgb; ?>;
            --kek-heading-color: <?php echo $heading_color; ?>;
            --kek-body-text-color: <?php echo $body_text_color; ?>;
            --kek-button-bg-color: <?php echo $button_bg_color; ?>;
            --kek-button-text-color: <?php echo $button_text_color; ?>;
            --kek-link-color: <?php echo $link_color; ?>;
            --kek-link-hover-color: <?php echo $link_hover_color; ?>;
        }
        
        /* Apply the custom link colors */
        a {
            color: var(--kek-link-color);
        }
        
        a:hover, a:focus {
            color: var(--kek-link-hover-color);
        }
    </style>
    <?php
}

add_action('wp_head', 'kek_customize_css');