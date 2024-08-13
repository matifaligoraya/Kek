<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Imports -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital@0;1&display=swap" rel="stylesheet">

    <?php wp_head(); ?>
</head>
<body <?php body_class('stretched'); ?>>
     <!-- Document Wrapper
	============================================= -->
    <div id="wrapper">
        <div id="top-bar" class="transparent-topbar">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-12 col-md-auto">

                        <div class="top-links">
                            <?php
                                wp_nav_menu(array(
                                    'menu_class' => 'top-links-container',
                                    'theme_location' => 'top-menu',
                                    'container' => true,                                    
                                    'fallback_cb' => false,
                                    'add_li_class'  => 'top-links-item'
                                ));
                            ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-auto dark" data-bs-theme="dark">

                        <ul id="top-social">
                            <?php
                                $settings = get_option(kek_SETTINGS_KEY, true);
                                $socials = isset($settings['social_links']) ? $settings['social_links'] : array();                                

                                if($socials) {
                                    for ($i = 0; $i < count($socials['icon']); $i++) {
                                        $social_icon = !empty($socials['icon'][$i]) ? $socials['icon'][$i] : '';
                                        $url = !empty($socials['url'][$i]) ? $socials['url'][$i] : '#';
                                        $container_class = !empty($socials['container_class'][$i]) ? $socials['container_class'][$i] : '';
                                        $icon_text = !empty($socials['icon_text'][$i]) ? $socials['icon_text'][$i] : '';
                                        $custom_icon_class = !empty($socials['custom_icon_class'][$i]) ? $socials['custom_icon_class'][$i] : '';

                                        $icon = $custom_icon_class == '' ? esc_attr($icon) : esc_attr($custom_icon_class);
                            
                                        echo '<li>
                                                <a href="' . esc_url($url) . '" class="' . $container_class . '" target="_blank">
                                                    <span class="ts-icon">
                                                        <i class="' . $icon . '"></i>
                                                    </span>
                                                    <span class="ts-text">' . $icon_text . '</span>
                                                </a>
                                            </li>';
                                    }
                                }
                            ?>                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <header id="header" class="transparent-header floating-header header-size-md">
            <div id="header-wrap" class="">
                <div class="container">
                    <div class="header-row top-search-parent">

                        <div id="logo">
                            <?php get_template_part('inc/templates/logo'); ?>
                        </div>
                        <div class="header-misc">
                            <div id="top-search" class="header-misc-icon">
                                <a href="#" id="top-search-trigger"><i class="uil uil-search"></i><i class="bi-x-lg"></i></a>
                            </div>
                            <a href="demo-seo-about.html" class="button button-rounded ms-3 d-none d-sm-block">Get Started</a>
                        </div>
                        <div class="primary-menu-trigger">
                            <button class="kek-hamburger" type="button" title="Open Mobile Menu">
                                <span class="kek-hamburger-box"><span class="kek-hamburger-inner"></span></span>
                            </button>
                        </div>

                        <nav class="primary-menu with-arrows primary-menu-init">
                        <?php
                            wp_nav_menu(array(
                                'theme_location' => 'main-menu',
                                'container' => false,
                                'menu_class' => 'menu-container',
                                'items_wrap' => '<ul class="%2$s">%3$s</ul>', // Custom wrapper for list items
                                'link_before' => '<div>', // Wraps link text with a div
                                'link_after' => '</div>', // Closes the div
                                'fallback_cb' => false, // Disable fallback to page list
                                'walker' => new Custom_Walker_Nav_Menu(), // Use the custom walker
                            ));
                        ?>
                        </nav>
                        <form class="top-search-form" action="search.html" method="get" style="width: 1260px;">
                            <input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter.." autocomplete="off">
                        </form>
                    </div>
                </div>
            </div>
            <div class="header-wrap-clone"></div>
        </header>
        <div class="content">
            <section class="owl">
                <h2>Owl</h2>
                <div class="owl-carousel owl-theme">
                <div class="item"><h4>1</h4></div>
                <div class="item"><h4>2</h4></div>
                <div class="item"><h4>3</h4></div>
                <div class="item"><h4>4</h4></div>
                <div class="item"><h4>5</h4></div>
                <div class="item"><h4>6</h4></div>
                <div class="item"><h4>7</h4></div>
                <div class="item"><h4>8</h4></div>
                <div class="item"><h4>9</h4></div>
                <div class="item"><h4>10</h4></div>
                </div>
            </section>
        </div>