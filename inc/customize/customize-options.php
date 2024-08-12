<?php
/**
 * Import customize style
 *
 * @return Css inline at header.
 *
 * @package     KeK
 * @version     1.0.0
 * @author      KeK
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2018 KeK
 
 */

// Render css customize
add_action('wp_enqueue_scripts', 'kek_customze_options_inline', 99999);

if( !function_exists('kek_customze_options_inline')){
    function kek_customze_options_inline(){
        wp_add_inline_style('styles', kek_customize_options());
    }
}

if (!function_exists('kek_customize_options')) {
    function kek_customize_options()
    {
        
        /*===============Theme Customize Style============== */
            $css = null;
            // Accent color
            $kek_color_preset           = get_theme_mod('kek_color_preset');

            $kek_primary_color          = '#282828';
            $kek_site_color             = '#777';
            $kek_site_link_color        = '#282828';
            $kek_site_link_color_hover  = '#B8A16B';
            $kek_site_heading_color     = '#282828';
            switch ($kek_color_preset) {
                case 'black':
                    $kek_primary_color          = '#282828';
                    $kek_site_color             = '#424242';
                    $kek_site_link_color        = '#959595';
                    $kek_site_link_color_hover  = '#FF3738';
                    $kek_site_heading_color     = '#252525';
                    break;
                case 'blue':
                    $kek_primary_color          = '#0000FF';
                    $kek_site_color             = '#424242';
                    $kek_site_link_color        = '#959595';
                    $kek_site_link_color_hover  = '#FF3738';
                    $kek_site_heading_color     = '#252525';
                    break;
                case 'red':
                    $kek_primary_color          = '#FF0000';
                    $kek_site_color             = '#424242';
                    $kek_site_link_color        = '#959595';
                    $kek_site_link_color_hover  = '#FF3738';
                    $kek_site_heading_color     = '#252525';
                    break;
                case 'yellow':
                    $kek_primary_color          = '#FFFF00';
                    $kek_site_color             = '#424242';
                    $kek_site_link_color        = '#959595';
                    $kek_site_link_color_hover  = '#FF3738';
                    $kek_site_heading_color     = '#252525';
                    break;
                case 'green':
                    $kek_primary_color          = '#008000';
                    $kek_site_color             = '#424242';
                    $kek_site_link_color        = '#959595';
                    $kek_site_link_color_hover  = '#FF3738';
                    $kek_site_heading_color     = '#252525';
                    break;
                case 'grey':
                    $kek_primary_color          = '#808080';
                    $kek_site_color             = '#424242';
                    $kek_site_link_color        = '#959595';
                    $kek_site_link_color_hover  = '#FF3738';
                    $kek_site_heading_color     = '#252525';
                    break;
                case 'custom':
                    $kek_primary_color          = get_theme_mod('kek_primary_color');
                    $kek_site_color             = get_theme_mod('kek_site_color');
                    $kek_site_link_color        = get_theme_mod('kek_site_link_color');
                    $kek_site_link_color_hover  = get_theme_mod('kek_site_link_color_hover');
                    $kek_site_heading_color     = get_theme_mod('kek_site_heading_color');
                    break;
                default:

                    break;
            }

            /* Primary color page option */
            if(get_post_meta(get_the_ID(),'kek_primary_color', true)){
                $kek_primary_color = get_post_meta(get_the_ID(),'kek_primary_color', true);
            }
            // Primary color
            $css .= '
                body a,
                .widget ul li .count,
                .widget ul li .count:before,
                .widget ul li .count:after
            
            {color:'.$kek_primary_color.'}';
            // Site color
            $css .= '
                body{color:'.$kek_site_color.'}';

            // Site link color
            $css .= '
                body a{color:'.$kek_site_link_color.'}';

            // Site link hover color
            $css .= '
                body a:hover,
                .post-loop-item .post-inner .entry-title a:hover,
                .post-loop-item .post-inner .list-cat a:hover,
                .entry-content a:hover,
                .sidebar.widget-area .widget ul li a:hover,
                .sidebar .widget a:hover
            
            {color:'.$kek_site_link_color_hover.'}';

            $css .= '.main-content .error-404 svg{fill:'.$kek_primary_color.'}';

            // Button
            $kek_button_color = get_theme_mod('kek_button_color','#fff');
            $kek_button_background_color = get_theme_mod('kek_button_background_color','#282828');
            $kek_button_border_color = get_theme_mod('kek_button_border_color','#282828');

            $kek_button_color_hover = get_theme_mod('kek_button_color_hover','#fff'); 
            $kek_button_background_color_hover = get_theme_mod('kek_button_background_color_hover','#B8A16B');
            $kek_button_border_color_hover = get_theme_mod('kek_button_border_color_hover','#B8A16B');

            if($kek_button_color){
                $css .= '
                #theme-dev-actions .button,
                .woocommerce .woocommerce-cart-form .button,
                .main-content .widget .tagcloud a,
                .wpcf7-form .wpcf7-submit,
                .woocommerce #respond input#submit, 
                .woocommerce-checkout #payment .button, 
                .woocommerce-checkout #payment .button, 
                .woocommerce-checkout #payment .added_to_cart, 
                #add_payment_method .wc-proceed-to-checkout a.checkout-button, 
                .woocommerce-cart .wc-proceed-to-checkout a.checkout-button, 
                .woocommerce .widget_shopping_cart .buttons a,
                #theme-dev-actions .button,
                .btn, 
                input[type="submit"], 
                .button, 
                button, 
                .wp-block-button.is-style-squared .wp-block-button__link, 
                .wp-block-button .wp-block-button__link,
                .entry-content .wp-block-file__button
                  
                {color:'.$kek_button_color.'}';
            }
            if($kek_button_background_color){
                $css .= '
                #theme-dev-actions .button,
                .woocommerce .woocommerce-cart-form .button,
                .main-content .widget .tagcloud a,
                .wpcf7-form .wpcf7-submit,
                .woocommerce #respond input#submit, 
                .woocommerce-checkout #payment .button, 
                .woocommerce-checkout #payment .button, 
                .woocommerce-checkout #payment .added_to_cart, 
                #add_payment_method .wc-proceed-to-checkout a.checkout-button, 
                .woocommerce-cart .wc-proceed-to-checkout a.checkout-button, 
                .woocommerce .widget_shopping_cart .buttons a,
                #theme-dev-actions .button,
                .btn, 
                input[type="submit"], 
                .button, 
                button, 
                .wp-block-button.is-style-squared .wp-block-button__link, 
                .wp-block-button .wp-block-button__link,
                .entry-content .wp-block-file__button
                
                {background:'.$kek_button_background_color.'}';
            }
            if($kek_button_border_color){
                $css .= '
                #theme-dev-actions .button,
                .woocommerce .woocommerce-cart-form .button,
                .main-content .widget .tagcloud a,
                .wpcf7-form .wpcf7-submit,
                .woocommerce #respond input#submit, 
                .woocommerce-checkout #payment .button, 
                .woocommerce-checkout #payment .button, 
                .woocommerce-checkout #payment .added_to_cart, 
                #add_payment_method .wc-proceed-to-checkout a.checkout-button, 
                .woocommerce-cart .wc-proceed-to-checkout a.checkout-button, 
                .woocommerce .widget_shopping_cart .buttons a,
                #theme-dev-actions .button,
                .btn, 
                input[type="submit"], 
                .button, 
                button, 
                .wp-block-button.is-style-squared .wp-block-button__link, 
                .wp-block-button .wp-block-button__link,
                .entry-content .wp-block-file__button
                
                {border-color:'.$kek_button_border_color.'}';
            }
            if($kek_button_color_hover){
                $css .= '
                .sidebar.widget-area .widget.widget_tag_cloud .tagcloud a:hover,
                #site-main-content .navigation.pagination .nav-links .page-numbers.current, 
                #site-main-content .navigation.pagination .nav-links .page-numbers:hover,
                #theme-dev-actions .button:hover,
                .woocommerce .woocommerce-cart-form .button:hover,
                .main-content .widget .tagcloud a:hover,
                .wpcf7-form .wpcf7-submit:hover,
                .woocommerce #respond input#submit:hover, 
                .woocommerce-checkout #payment .button:hover, 
                .woocommerce-checkout #payment .button:hover, 
                .woocommerce-checkout #payment .added_to_cart:hover, 
                #add_payment_method .wc-proceed-to-checkout a.checkout-button:hover, 
                .woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover, 
                .woocommerce .widget_shopping_cart .buttons a:hover,
                #theme-dev-actions .button:hover,
                .btn:hover, 
                input[type="submit"]:hover, 
                .button:hover, 
                button:hover, 
                .wp-block-button.is-style-squared .wp-block-button__link:hover,
                .wp-block-button .wp-block-button__link:hover,
                .entry-content .wp-block-file__button:hover
                   
                {color:'.$kek_button_color_hover.'}';
            }
            if($kek_button_background_color_hover){
                $css .= '
                .sidebar.widget-area .widget.widget_tag_cloud .tagcloud a:hover,
                #site-main-content .navigation.pagination .nav-links .page-numbers:hover,
                #theme-dev-actions .button:hover,
                .woocommerce .woocommerce-cart-form .button:hover,
                .main-content .widget .tagcloud a:hover,
                .wpcf7-form .wpcf7-submit:hover,
                .woocommerce #respond input#submit:hover, 
                .woocommerce-checkout #payment .button:hover, 
                .woocommerce-checkout #payment .button:hover, 
                .woocommerce-checkout #payment .added_to_cart:hover, 
                #add_payment_method .wc-proceed-to-checkout a.checkout-button:hover, 
                .woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover, 
                .woocommerce .widget_shopping_cart .buttons a:hover,
                #theme-dev-actions .button:hover,
                .btn:hover, 
                input[type="submit"]:hover, 
                .button:hover, 
                button:hover, 
                .wp-block-button.is-style-squared .wp-block-button__link:hover,
                .wp-block-button .wp-block-button__link:hover,
                .entry-content .wp-block-file__button:hover
                
                {background:'.$kek_button_background_color_hover.'}';
            }
            if($kek_button_border_color_hover){
                $css .= '
                .sidebar.widget-area .widget.widget_tag_cloud .tagcloud a:hover, 
                #site-main-content .navigation.pagination .nav-links .page-numbers:hover,
                #theme-dev-actions .button:hover,
                .woocommerce .woocommerce-cart-form .button:hover,
                .main-content .widget .tagcloud a:hover,
                .wpcf7-form .wpcf7-submit:hover,
                .woocommerce #respond input#submit:hover, 
                .woocommerce-checkout #payment .button:hover, 
                .woocommerce-checkout #payment .button:hover, 
                .woocommerce-checkout #payment .added_to_cart:hover, 
                #add_payment_method .wc-proceed-to-checkout a.checkout-button:hover, 
                .woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover, 
                .woocommerce .widget_shopping_cart .buttons a:hover,
                #theme-dev-actions .button:hover,
                .btn:hover, 
                input[type="submit"]:hover, 
                .button:hover, 
                button:hover, 
                .wp-block-button.is-style-squared .wp-block-button__link:hover,
                .wp-block-button .wp-block-button__link:hover,
                .entry-content .wp-block-file__button:hover
                
                {border-color:'.$kek_button_border_color_hover.'}';
            }

            if($kek_site_heading_color){
                $css .= '
                h1,h2,h3,h4,h5,h6,
                .h1,.h2,.h3,.h4,.h5,.h6
                
                {color:'.$kek_site_heading_color.'}';
            }

            //Main Content
            $kek_body_background = get_post_meta(get_the_ID(),'kek_body_background', true);
            if( $kek_body_background ){
                $css .= '.page-main-content{background: '.$kek_body_background.'}';
            }
            if(!get_theme_mod('kek_enable_rtl', '1')){
                $css .= '#theme-dev-actions{display: none}';
            }
            

        /* ==============End Theme Customize Style ===========================*/
        return $css;
    }
}