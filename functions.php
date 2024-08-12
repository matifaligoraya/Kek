<?php
/**
 * Theme functions file
 *
 * @package  kek
 * @author   Bit & Byte Lab
 * @link     https://bitandbytelab.com/
 *
 */

/**
 * Load default constants
 *
 * @var  resource
 */
require get_template_directory() . '/core/const.php';

/**
 * Check if system meets requirements
 *
 * @see  https://developer.wordpress.org/reference/hooks/after_switch_theme/
 */
function kek_pre_activation_check($old_theme_name, WP_Theme $old_theme_object)
{
    try {
        if (version_compare(PHP_VERSION, '5.6', '<')) {
            throw new Exception(sprintf('Whoops, this theme requires %1$s version %2$s at least. Please upgrade %1$s to the latest version for better perfomance and security!', 'PHP', '5.6'));
        }

        if (version_compare($GLOBALS['wpdb']->db_version(), '5.0', '<')) {
            throw new Exception(sprintf('Whoops, this theme requires %1$s version %2$s at least. Please upgrade %1$s to the latest version for better perfomance and security.', 'MySQL', '5.6'));
        }

        if (version_compare($GLOBALS['wp_version'], '5.2', '<')) {
            throw new Exception(sprintf('Whoops, this theme requires %1$s version %2$s at least. Please upgrade %1$s to the latest version for better perfomance and security!', 'WordPress', '5.2'));
        }

        if (!defined('WP_CONTENT_DIR') || !is_writable(WP_CONTENT_DIR)) {
            throw new Exception('WordPress content directory is not writable. Please correct this directory permissions!');
        }
    } catch (Exception $e) {
        $die_msg = sprintf('<h1 class="align-center">'.esc_html__('Theme Activation Error', 'sublimeplus').'</h1><p class="active-theme-error" >%s</p><p class="align-center"><a href="%s">'.esc_html__('Return to dashboard', 'sublimeplus').'</a></p>', $e->getMessage(), get_admin_url(null, 'index.php'));
        switch_theme($old_theme_object->stylesheet);
        wp_die($die_msg, esc_html__('Theme Activation Error', 'sublimeplus'), 500);
    }

    add_option(kek_SETTINGS_KEY, [
        'header_scripts'  => '',
        'footer_scripts'  => '',
        'import_settings' => '',
        'enable_dev_mode' => 0,
        'enable_builtin_mega_menu' => 0,
        'mobile_breakpoint_width' => 992,
    ]);

    if (!is_child_theme()) {
        set_transient('theme_setup_wizard_redirect', '1');
    }
}
add_action('after_switch_theme', 'kek_pre_activation_check', 10, 2);

/**
 * Setup theme
 *
 * @see  https://developer.wordpress.org/reference/hooks/after_setup_theme/
 */
function kek_default_setup()
{
    $settings = get_option(kek_SETTINGS_KEY);

    register_nav_menus([
        'top-menu'     => esc_html__('Top Menu', 'sublimeplus'),
        'mobile-menu'  => esc_html__('Mobile Menu', 'sublimeplus'),
        'primary-menu' => esc_html__('Primary Menu', 'sublimeplus'),
    ]);

    // Load common resources
    require kek_DIR . 'core/common/functions/filesystem.php';
    require kek_DIR . 'core/common/functions/formatting.php';
    require kek_DIR . 'core/common/functions/customize.php';
    require kek_DIR . 'core/common/functions/layout.php';
    require kek_DIR . 'core/common/functions/plugin.php';
    require kek_DIR . 'core/common/functions/fonts.php';
    require kek_DIR . 'core/common/functions/media.php';
    require kek_DIR . 'core/common/functions/theme.php';
    require kek_DIR . 'core/common/functions/page.php';
    require kek_DIR . 'core/common/functions/css.php';
    require kek_DIR . 'core/common/hooks.php';
    require kek_DIR . 'core/admin/formatting.php';
    // custom post types
    require kek_DIR . 'core/common/functions/cpt.php';
    // Load admin resources.
    if (is_admin()) {
     
        require kek_DIR . 'core/admin/functions/menu.php';
        
        require kek_DIR . 'core/admin/pages/welcome-page.php';
        require kek_DIR . 'core/admin/pages/customize-page.php';
        require kek_DIR . 'core/admin/pages/settings-page.php';
        require kek_DIR . 'core/admin/migration/class-wxr-parser.php';
        require kek_DIR . 'core/admin/migration/class-wxr-importer.php';
        require kek_DIR . 'core/admin/migration/class-customize-importer.php';
        require kek_DIR . 'core/admin/migration/tgm-plugin-activation.php';
        require kek_DIR . 'core/admin/migration/class-demo-importer.php';
        require kek_DIR . 'core/admin/pages/setup-demo-page.php';
        require kek_DIR . 'core/admin/migration/class-setup-wizard.php';
        require kek_DIR . 'core/admin/hooks.php';
    } else { // Load public resources.
        //require kek_DIR . 'core/public/megamenu/class-mega-menu-walker.php';
        require kek_DIR . 'core/public/breadcrumb/breadcrumb.php';
        require kek_DIR . 'core/public/functions/nav-menu.php';
        require kek_DIR . 'core/public/functions/pagination.php';
        require kek_DIR . 'core/public/functions/breadcrumb.php';
        require kek_DIR . 'core/public/hooks.php';
    }

    // Load extra theme functionality.
    require kek_DIR . 'inc/init.php';

    // Load customize resources.
    require kek_DIR . 'core/customize/class-customize-sanitizer.php';
    require kek_DIR . 'core/customize/class-customize-live-css.php';
    require kek_DIR . 'core/customize/class-customizer.php';
}
add_action('after_setup_theme', 'kek_default_setup', 9, 0);

/**
 * Register Elementor Locations.
 *
 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
 */
function kek_register_elementor_locations($elementor_theme_manager) {
	$elementor_theme_manager->register_all_core_location(); // Full support.
}
add_action('elementor/theme/register_locations', 'kek_register_elementor_locations');


function display_active_custom_posts() {
    $prefix = '_on_'; // Replace with your actual prefix
    // Replace 'promo-note' with your actual custom post type
    $args = array(
        'post_type' => 'promo-note',
        'posts_per_page' => -1, // Retrieve all posts
        'post_status'    => 'publish', // Add other statuses if needed
        'meta_query'     => array(
            array(
                'key'     => '_on_is_active',
                'value'   => 'on', // Adjust this based on how the value is stored
                'compare' => '=',
            ),
        ),
        'suppress_filters' => true, // Override publicly_queryable
    );

    $query = new WP_Query($args);
    //print_r($query );
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Get the meta values for the current post
            $background_color = get_post_meta(get_the_ID(), $prefix . 'promo_background_color', true);
            $text_color = get_post_meta(get_the_ID(), $prefix . 'promo_text_color', true);
            $button_color = get_post_meta(get_the_ID(), $prefix . 'promo_button_color', true);
            $promo_text = get_post_meta(get_the_ID(), $prefix . 'promo_text', true);
            $promo_button_text = get_post_meta(get_the_ID(), $prefix . 'promo_button_text', true);
            $promo_link = get_post_meta(get_the_ID(), $prefix . 'promo_link', true);

            // Generate the HTML with inline styles for colors
            echo '<div class="promo show" style="background-color: ' . esc_attr($background_color) . '; color: ' . esc_attr($text_color) . ';">';
            echo '<strong>' . esc_html($promo_text) . '</strong>';
            echo '<a href="' . esc_url($promo_link) . '" class="btn btn--black btn--xs" style="background-color: ' . esc_attr($button_color) . ';">' . esc_html($promo_button_text) . '</a>';
            echo '<button class="promo-close">Close</button>';
            echo '</div>';
        }
        wp_reset_postdata();
    } else {
        echo '<p>No active promotions found.</p>';
    }
}


function get_svg_files_from_directory() {
    $svg_files = [];
    $directory = ABSPATH . 'img/svg/'; // Adjust path as needed to the installation root

    $files = glob($directory . '*.svg');

    foreach ($files as $file) {
        $filename = basename($file);
        $svgs[] = array(
            'value' => $filename,
            'label' => $filename
        );
    }
    return $svgs;
    //return $svg_files;
}

// Allow SVG uploads
function custom_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'custom_mime_types');

// Ensure SVG uploads are sanitized
function wpcontent_svg_mime_type( $data, $file, $filename, $mimes ) {
    $ext = pathinfo( $filename, PATHINFO_EXTENSION );
    if ( 'svg' === $ext ) {
        $data['ext'] = 'svg';
        $data['type'] = 'image/svg+xml';
    } elseif ( 'svgz' === $ext ) {
        $data['ext'] = 'svgz';
        $data['type'] = 'image/svg+xml';
    }
    return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'wpcontent_svg_mime_type', 10, 4 );


// Function to update the meta title tag
function kek_custom_title_tag($title) {
    // Ensure the key is correct
    $settings = get_option(kek_SETTINGS_KEY);

    // Retrieve the blog title from theme settings
    $blog_title = isset($settings['blog_title']) ? $settings['blog_title'] : 'Blog';
//print_r( $blog_title);
//exit;
    // Check if it's the blog page
   // echo is_home();
    if (is_home()) {
        // Set the custom title
        $title = $blog_title;// . ' | ' . get_bloginfo('name');
      //exit;
    }
//echo $title;
    return $title;
}
add_filter('wp_title', 'kek_custom_title_tag', 10, 2);
add_filter('pre_get_document_title', 'kek_custom_title_tag'); // For modern themes
add_filter('wpseo_title', 'kek_custom_title_tag');

function theme_setup() {
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'theme_setup');
// Function to update the Yoast SEO breadcrumb title
function kek_custom_wpseo_breadcrumb_single_link($link_output, $breadcrumb) {
    // Ensure the key is correct
    $settings = get_option(kek_SETTINGS_KEY);

    // Retrieve the blog title from theme settings
    $blog_title = isset($settings['blog_title']) ? $settings['blog_title'] : 'Blog';

    // Check if it's the blog page in the breadcrumb
    if (is_home() && strpos($link_output, 'breadcrumb_last') !== false) {
        // Replace the breadcrumb title
        $link_output = str_replace($breadcrumb['text'], $blog_title, $link_output);
    }

    return $link_output;
}
add_filter('wpseo_breadcrumb_single_link', 'kek_custom_wpseo_breadcrumb_single_link', 10, 2);



function kek_social_links_shortcode($atts) {
    $settings = get_option(kek_SETTINGS_KEY, true);
   
    $social_links = isset($settings['social_links']) ? $settings['social_links'] : array(); // Fetch the saved social links and make it empty if not set
 if(isset(  $social_links)){
    ob_start();
    ?>
    <div class="about-contacts-social wow fadeInUp" data-wow-duration="1.5s" style="visibility: visible; animation-duration: 1.5s; animation-name: fadeInUp;">
        <?php foreach ($social_links['url'] as $index => $url) : ?>
            <?php if (!empty($url) && !empty($social_links['icon'][$index])) : ?>
                <a href="<?php echo esc_url($url); ?>" target="_blank">
                    <i class="<?php echo esc_attr($social_links['icon'][$index]); ?>"></i>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
}
add_shortcode('kek_social_links', 'kek_social_links_shortcode');

// function kek_vc_map_social_links() {
//     vc_map(array(
//         "name" => __("Social Links", "sublimeplus"),
//         "base" => "kek_social_links",
//         "class" => "",
//         "category" => __("SublimePlus", "sublimeplus"),
//         "params" => array(
//             array(
//                 "type" => "textfield",
//                 "heading" => __("Extra Class Name", "sublimeplus"),
//                 "param_name" => "el_class",
//                 "description" => __("Add a class name and refer to it in custom CSS.", "sublimeplus"),
//             ),
//         )
//     ));
// }
// add_action('vc_before_init', 'kek_vc_map_social_links');




function kek_scripts() {
    wp_enqueue_style('main-style', get_stylesheet_uri());

    wp_enqueue_style('font-icons', get_template_directory_uri() . '/assets/css/font-icons.css');
    wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/css/swiper.css');
    wp_enqueue_style('custom', get_template_directory_uri() . '/assets/css/custom.css');    
}
add_action('wp_enqueue_scripts', 'kek_scripts');

function kek_customize_register($wp_customize) {
    // Footer Settings
    $wp_customize->add_section('footer_settings', array(
        'title' => __('Footer Settings', 'kek'),
        'priority' => 30,
    ));

    // Footer Background Image
    $wp_customize->add_setting('kek_footer_bg_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'kek_footer_bg_image', array(
        'label' => __('Footer Background Image', 'kek'),
        'section' => 'footer_settings',
        'settings' => 'kek_footer_bg_image',
    )));

    // Footer main logo image
    $wp_customize->add_setting('kek_footer_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'kek_footer_image', array(
        'label' => __('Footer Image', 'kek'),
        'section' => 'footer_settings',
        'settings' => 'kek_footer_image',
    )));

    // Footer highlight HTML (Text)    
    $wp_customize->add_setting('kek_footer_highlight', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post', // Allows some HTML tags
    ));

    $wp_customize->add_control(new WP_Customize_HTML_Control($wp_customize, 'kek_footer_highlight', array(
        'label' => __('Footer Highlight (HTML)', 'kek'),
        'section' => 'footer_settings',
        'settings' => 'kek_footer_highlight',
    )));

    // Downloads Counter
    $wp_customize->add_setting('kek_footer_downloads', array(
        'default' => '15065421',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('kek_footer_downloads', array(
        'label' => __('Total Downloads', 'kek'),
        'section' => 'footer_settings',
        'settings' => 'kek_footer_downloads',
        'type' => 'number',
    ));

    // Clients Counter
    $wp_customize->add_setting('kek_footer_clients', array(
        'default' => '18465',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('kek_footer_clients', array(
        'label' => __('Total Clients', 'kek'),
        'section' => 'footer_settings',
        'settings' => 'kek_footer_clients',
        'type' => 'number',
    ));

    // Enable/Disable Payment Gateways
    $wp_customize->add_section('payment_gateways', array(
        'title' => __('Enable/Disable Payments', 'kek'),
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('kek_visa_enabled', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('kek_visa_enabled', array(
        'label' => __('VISA', 'kek'),
        'section' => 'payment_gateways',
        'settings' => 'kek_visa_enabled',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('kek_master_enabled', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('kek_master_enabled', array(
        'label' => __('Master', 'kek'),
        'section' => 'payment_gateways',
        'settings' => 'kek_master_enabled',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('kek_american_express_enabled', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('kek_american_express_enabled', array(
        'label' => __('American Express', 'kek'),
        'section' => 'payment_gateways',
        'settings' => 'kek_american_express_enabled',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('kek_stripe_enabled', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('kek_stripe_enabled', array(
        'label' => __('Stripe', 'kek'),
        'section' => 'payment_gateways',
        'settings' => 'kek_stripe_enabled',
        'type' => 'checkbox',
    ));
}

add_action('customize_register', 'kek_customize_register');

function add_additional_class_on_li($classes, $item, $args) {
    if(isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

/*
    KEK
    THEME SETTINGS BELOW e.g
        COLORS
        SOCIAL ICONS
*/

function kek_customize_css() {    
    $options = get_option('kek_options');    
    $color = esc_attr($options['main_color'] ?? '#1db954');    
        
    $rgb = isset($options['main_color_rgb']) ? esc_attr($options['main_color_rgb']) : hex_to_rgb($color);
    
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

function kek_admin_enqueue_scripts() {    
    // print_r("THIS IS THE CONDITION: " . 'kek_page_theme-setting' !== $hook_suffix);
    // if ('kek_page_theme-setting' !== $hook_suffix) {
    //     return;
    // }    
    
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

/* 
    KEK
        CUSTOM CLASSES & CONTROLS BELOW
*/

// CUSTOM WALKER FOR HEADER MENU

class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $classes = array('sub-menu-container'); // Class for <ul>
        $class_names = join(' ', apply_filters('nav_menu_submenu_css_class', $classes, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= "\n$indent<ul$class_names>\n";
    }

    function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item';
        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'current';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = ! empty($item->target)     ? $item->target     : '';
        $atts['rel']    = ! empty($item->xfn)        ? $item->xfn        : '';
        $atts['href']   = ! empty($item->url)        ? $item->url        : '';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (! empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . ' class="menu-link"><div>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        if ($args->walker->has_children) {
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

// CUSTOMIZE HTML CONTROL IN APPEARANCE -> CUSTOMIZE

if (class_exists('WP_Customize_Control')) {
    class WP_Customize_HTML_Control extends WP_Customize_Control {
        public $type = 'html';

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <textarea style="width:100%;" rows="5" <?php $this->link(); ?>><?php echo esc_textarea($this->value()); ?></textarea>
            </label>
            <?php
        }
    }
}
