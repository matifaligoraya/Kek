<?php
function kek_theme_setup() {    
    add_theme_support('custom-logo', array(
        'height'      => 100, 
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    register_nav_menus(array(
        'main-menu' => __('Main Menu', 'kek'),
    ));
}
add_action('after_setup_theme', 'kek_theme_setup');

function kek_scripts() {
    wp_enqueue_style('main-style', get_stylesheet_uri());

    wp_enqueue_style('font-icons', get_template_directory_uri() . '/assets/css/font-icons.css');
    wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/css/swiper.css');
    wp_enqueue_style('custom', get_template_directory_uri() . '/assets/css/custom.css');    
}
add_action('wp_enqueue_scripts', 'kek_scripts');

function kek_add_admin_menu() {
    add_menu_page(
        __('KEK - Theme Settings', 'kek'),
        __('KEK - Theme Settings', 'kek'),
        'manage_options',
        'kek-settings',
        'kek_settings_page_html',
        get_template_directory_uri() . '/assets/images/theme-settings-menu-icon.png',
        2
    );
}
add_action('admin_menu', 'kek_add_admin_menu');

function kek_settings_init() {
    register_setting('kek_options', 'kek_options');

    add_settings_section(
        'kek_section_colors',
        __('Color Settings', 'kek'),
        'kek_section_colors_callback',
        'kek-settings'
    );

    add_settings_field(
        'kek_setting_color',
        __('Main Color', 'kek'),
        'kek_setting_color_render',
        'kek-settings',
        'kek_section_colors'
    );
}
add_action('admin_init', 'kek_settings_init');

function kek_section_colors_callback() {
    echo '<p>' . __('Manage kek colors here and make it yours ;)', 'kek') . '</p>';
}

function kek_setting_color_render() {
    $options = get_option('kek_options');
    ?>
    <input type='text' class='kek-color-field' name='kek_options[kek_setting_color]' value='<?php echo esc_attr($options['kek_setting_color'] ?? '#1db954'); ?>'>
    <?php
}

function kek_setting_color_rgb_render() {
    $options = get_option('kek_options');
    ?>
    <input type='text' name='kek_options[kek_setting_color_rgb]' value='<?php echo esc_attr($options['kek_setting_color_rgb'] ?? '29, 185, 84'); ?>'>
    <?php
}

function kek_settings_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_GET['settings-updated'])) {
        add_settings_error('kek_messages', 'kek_message', __('Settings Saved', 'kek'), 'updated');
    }

    settings_errors('kek_messages');
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <h2 class="nav-tab-wrapper">
            <a href="#kek-color-settings" class="nav-tab nav-tab-active">Colors</a>
            <a href="#kek-other-settings" class="nav-tab">Others</a>            
        </h2>
        <form action="options.php" method="post">
            <?php
            settings_fields('kek_options');
            ?>
            <div id="kek-color-settings" class="tab-content">
                <?php
                    do_settings_sections('kek-settings');
                ?>
            </div>
            <div id="kek-other-settings" class="tab-content" style="display:none;">
                <!-- Content for other settings -->
                <p>Other settings content goes here.</p>
            </div>
            <?php
            submit_button(__('Save Settings', 'kek'));
            ?>
        </form>
    </div>
    <?php
}

function kek_customize_css() {
    $options = get_option('kek_options');
    $color = esc_attr($options['kek_setting_color'] ?? '#1db954');    
    
    // Extract RGB from hex if not set
    $rgb = isset($options['kek_setting_color_rgb']) ? esc_attr($options['kek_setting_color_rgb']) : hex_to_rgb($color);
    
    ?>
    <style type="text/css">
        :root {
            --cnvs-themecolor: <?php echo $color; ?>;
            --cnvs-themecolor-rgb: <?php echo $rgb; ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'kek_customize_css');

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

function kek_admin_enqueue_scripts($hook_suffix) {
    if ('toplevel_page_kek-settings' !== $hook_suffix) {
        return;
    }

    // Enqueue the color picker script and styles
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('kek-admin-js', get_template_directory_uri() . '/assets/js/admin/admin.js', array('wp-color-picker'), false, true);
}
add_action('admin_enqueue_scripts', 'kek_admin_enqueue_scripts');

function kek_admin_styles() {
    ?>
    <style>
        .nav-tab-wrapper {
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }
        .nav-tab {
            padding: 10px 15px;
            margin-right: 5px;
            border: 1px solid #ddd;
            border-bottom: 1px solid transparent;
            border-radius: 3px 3px 0 0;
            background: #f1f1f1;
            color: #333;
            cursor: pointer;
        }
        .nav-tab-active {
            background: #fff;
            border-color: #ddd;
            border-bottom: 1px solid transparent;
            font-weight: bold;
        }
        .tab-content {
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
    </style>
    <?php
}
add_action('admin_head', 'kek_admin_styles');

// CUSTOM WALKER CLASS FOR MENU

class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"mega-menu-content mega-menu-style-2 px-0\"><div class=\"container\"><div class=\"row\">\n";
    }

    function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</div></div></div>\n";
    }

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item';
        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'current';
        }

        if ( $args->walker->has_children ) {
            $classes[] = 'mega-menu sub-menu';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (! empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .' class="menu-link"><div>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        if ( $args->walker->has_children ) {
            $item_output .= '<i class="sub-menu-indicator fa-solid fa-caret-down"></i>';
        }
        $item_output .= '</div></a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }
}