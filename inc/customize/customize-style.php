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
add_action('wp_enqueue_scripts', 'kek_enqueue_render', 1000);
// Enqueue scripts for theme.
function kek_enqueue_render()
{
    // Load custom style
    wp_add_inline_style('base-styles', kek_customize_style());
}

if (!function_exists('kek_customize_style')) {
    function kek_customize_style()
    {
        $css = '';
        /* ----------------------------------------------------------
                                    Typography
                            All typography must add here
        ---------------------------------------------------------- */
        if (get_theme_mod('kek_use_font', 'default') == 'default') {
            wp_enqueue_style('Montserrat-font', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap');
            //display font
            // $css .= 'body,.entry-content{';
            // $css .= 'font-family: \'Jost\', sans-serif;';
            // $css .= 'font-weight: 400;';
            // $css .= 'font-style:  normal;';
            // $css .= "}";

            // $css .= 'h1,h2,h3,h4,h5,h6{';
            // $css .= 'font-family: \'Jost\', sans-serif;';
            // $css .= 'font-weight: 500;';
            // $css .= 'font-style:  normal;';
            // $css .= "}";
        }
        if (get_theme_mod('kek_use_font', 'default') != 'default') {
            $font_name = get_theme_mod('kek_typo_new_font_family');
            $font_arr = get_theme_mod('kek_font_items');
            foreach ($font_arr as $key => $font) {
                $css .= '@font-face {';
                $css .= 'font-family: ' . $font_name . ';';
                $css .= 'font-weight: ' . $font['weight'] . ';';
                $css .= 'font-style:  ' . $font['style'] . ';';

                $css .= 'src:';
                $arr = array();
                if ($font['woff2']) {
                    $arr[] = 'url(' . esc_url($font['woff2']) . ") format('woff2')";
                }
                if ($font['woff']) {
                    $arr[] = 'url(' . esc_url($font['woff']) . ") format('woff')";
                }
                if ($font['ttf']) {
                    $arr[] = 'url(' . esc_url($font['ttf']) . ") format('truetype')";
                }
                if ($font['svg']) {
                    $arr[] = 'url(' . esc_url($font['svg']) . '#' . esc_attr(strtolower(str_replace(' ', '_', $font_name))) . ") format('svg')";
                }
                $css .= join(', ', $arr);
                $css .= ';';
                $css .= '}';
            }
            //display font
            $css .= 'body{';
            $css .= 'font-family: "' . $font_name . '", sans-serif;';
            $css .= 'font-weight: normal;';
            $css .= 'font-style:  normal;';
            $css .= 'font-size:  16px;';
            $css .= '}';

        }

        //font-size
        // $css .= "html{";
        // $css .= "font-size: 16px;";
        // $css .= "}";
        // $css .= "body{";
        // $css .= "font-size: 1rem;";
        // $css .= "}";
        /* ----------------------------------------------------------
                                            Responsive control
                                    Control Breakpoint of header Layout
                                    Don't remove this section
                ---------------------------------------------------------- */
        $theme_settings = get_option(kek_SETTINGS_KEY, []);
        $mobile_breakpoint = !empty($theme_settings['mobile_breakpoint_width']) ? strval(intval($theme_settings['mobile_breakpoint_width'])) : '992';
        $css .= '@media(min-width: ' . $mobile_breakpoint . 'px) {
                    .wrap-site-header-mobile {
                        display: none;
                    }
                    .show-on-mobile {
                        display: none;
                    }
                }
        
                @media(max-width: ' . $mobile_breakpoint . 'px) {
                    .wrap-site-header-desktop {
                        display: none;
                    }
                    .show-on-desktop {
                        display: none;
                    }
                }
        ';
        $css .= '@media(min-width:1500px){.elementor-section.elementor-section-boxed>.elementor-container,.container{max-width:' . kek_site_width() . ';width:100%}}';
        /* ----------------------------------------------------------
                            End Responsive control
                    Control Breakpoint of header Layout
                    Don't remove this section
        ---------------------------------------------------------- */
        return $css;
    }
}