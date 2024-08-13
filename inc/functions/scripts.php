<?php
/**
 * Register theme Scripts/Style.
 *
 * @package     KeK
 * @version     3.0.0
 * @author      KeK
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2020 KeK
 * @des         All js, css of theme user must register in this file. Dev can remove or delete js/css don't use.
 */

/**
 * Load theme style
 */
if (!function_exists('kek_styles')) {
    function kek_styles()
    {       
        if (class_exists('WooCommerce', false)) {
            //Remove style don't use.
            wp_deregister_style('woocommerce-layout');
            wp_deregister_style('woocommerce-smallscreen');
            wp_deregister_style('woocommerce_prettyPhoto_css');
            wp_deregister_style('jquery-selectBox');
            //Custom Woocommerce Css
            wp_enqueue_style('woocommerce', kek_URI . 'assets/css/woocommerce.css');
        }
        wp_register_style( 'base-styles', false );
        wp_enqueue_style('base-styles');
        wp_enqueue_style('main-style', kek_URI);

        wp_enqueue_style('font-icons', kek_URI . '/assets/css/font-icons.css');
        wp_enqueue_style('swiper', kek_URI . '/assets/css/swiper.css');
        wp_enqueue_style('custom', kek_URI . '/assets/css/custom.css');
        wp_enqueue_style('slick', kek_URI . '/assets/css//slick/slick.css');
        wp_enqueue_style('slick-theme', kek_URI . '/assets/css/slick/slick-theme.css');      
        //Load style of customize
        $kek_auto_css = kek_Customize_Live_CSS::get_instance();

        wp_add_inline_style('styles', $kek_auto_css->auto_css());
        // Main style
        wp_enqueue_style('sublimeplus', get_stylesheet_uri());

    }
}
add_action('wp_enqueue_scripts', 'kek_styles', 999);

/**
 * Load theme Script
 */
if (!function_exists('kek_scripts')) {
    function kek_scripts()
    {
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }


        
        // <!-- build:js js/vendor.js -->
        // <script src="js/jquery-3.3.1.min.js"></script>
        // <script src="js/popper.min.js" ></script>
        // <script src="js/bootstrap.min.js"></script>
        // <script src="js/slick.min.js"></script>
        // <script src="js/wow.min.js"></script>
        // <script src="js/jquery.mCustomScrollbar.js"></script>
        // <script src="js/slideNav.min.js"></script>
        // <script src="js/masonry.pkgd.min.js"></script>
        // <script src="js/lightgallery-all.min.js"></script>
        // <!-- endbuild -->

        // <!-- build:js js/custom.js -->
        // <script src="js/main.js"></script>
        // <!-- endbuild -->
        wp_register_script('popper', kek_URI . 'assets/js/wave/popper.min.js');
        wp_register_script('bootstrap', kek_URI . 'assets/js/wave/bootstrap.min.js');
        wp_register_script('popper', kek_URI . 'assets/js/wave/popper.min.js');
        wp_register_script('wow', kek_URI . 'assets/js/wave/wow.min.js');
        wp_register_script('mCustomScrollbar', kek_URI . 'assets/js/wave/jquery.mCustomScrollbar.js');
        wp_register_script('slideNav', kek_URI . 'assets/js/wave/slideNav.min.js');
        wp_register_script('masonry', kek_URI . 'assets/js/wave/masonry.pkgd.min.js');
        wp_register_script('lightgallery', kek_URI . 'assets/js/wave/lightgallery-all.min.js');        

        //wp_register_script('jquery-core', kek_URI . 'assets/js/wave/jquery-3.3.1.min.js', true);
        wp_register_script('slick', kek_URI . 'assets/js/wave/slick.min.js');        

        wp_register_script('isotope', kek_URI . 'assets/vendor/isotope/isotope.pkgd.min.js', array('jquery-core'), '3.0.6', true);
        wp_enqueue_script('defer-js', kek_URI . 'assets/vendor/defer/defer.min.js', array('jquery-core'), '3.0.6', true);
        wp_register_script('scripts', kek_URI . 'assets/js/scripts.js', array('jquery-core'), false, true);

        if (class_exists('WooCommerce', false)) {
	        wp_register_script('spritespin', kek_URI . 'assets/vendor/spritespin/spritespin.js', array('jquery-core'), false, true);
            if (get_theme_mod('kek_enable_quick_view', '1') == 1) {
                wp_enqueue_script('countdown');
                wp_enqueue_script('wc-add-to-cart-variation');
            }
            wp_enqueue_script('woo-ajax', kek_URI . 'assets/js/woo-ajax.js', array('jquery-core'), false, true);
            wp_enqueue_script('woocommerce', kek_URI . 'assets/js/woocommerce.js', array('jquery-core'), false, true);
        }

        wp_enqueue_script('scripts');
        wp_enqueue_script('jquery-core');
        wp_enqueue_script('jquery-migrate-js');
      
        wp_enqueue_script('bootstrap'); 
        wp_enqueue_script('wow');
        wp_enqueue_script('custom');
        wp_enqueue_script('lightgallery');
        wp_enqueue_script('masonry');
        wp_enqueue_script('slideNav');
        wp_enqueue_script('mCustomScrollbar');
        wp_enqueue_script('popper');
        wp_enqueue_script('slick');
        wp_enqueue_script('main');
        wp_enqueue_script('site', kek_URI . 'assets/js/site.js');
    }
}
add_action('wp_enqueue_scripts', 'kek_scripts');

/**
 * Add pingback
 */
if (!function_exists('kek_pingback_header')) {
    function kek_pingback_header() {
        if ( is_singular() && pings_open() ) {
            printf( '<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo( 'pingback_url' ) ));
        }
    }
}
add_action( 'wp_head', 'kek_pingback_header' );

/**
 * Ajax Url
 */
add_action('wp_enqueue_scripts', 'kek_framework_ajax_url_render', 1000);
// Enqueue scripts for theme.
if (!function_exists('kek_framework_ajax_url_render')) {
    function kek_framework_ajax_url_render()
    {
        // Load custom style
        wp_add_inline_script('scripts', kek_framework_ajax_url());
    }
}
if (!function_exists('kek_framework_ajax_url')) {
    function kek_framework_ajax_url()
    {
        $ajaxurl = 'var ajaxurl = "' . esc_url(admin_url('admin-ajax.php')) . '";';
        return $ajaxurl;
    }
}