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
                    </div>
                </div>
            </div>
            <div class="header-wrap-clone"></div>
        </header>
        <br />
        <div class="slick-slider">
            <?php
                $settings = get_option(kek_SETTINGS_KEY, true);
                $tiles = isset($settings['sub_header_tiles']) ? $settings['sub_header_tiles'] : array();                            

                if ($tiles): ?>                
                    <div class="container mt-4">
                        <div class="row">
                            <?php for ($i = 0; $i < count($tiles['image']); $i++): 
                                $image = !empty($tiles['image'][$i]) ? $tiles['image'][$i] : '';
                                $title = !empty($tiles['title'][$i]) ? $tiles['title'][$i] : '';
                                $isNew = !empty($tiles['isNew'][$i]); // Check if the tile is new
                            ?>
                                <div class="platform-item col-md-4 mb-4">
                                    <div class="d-flex align-items-center p-3">
                                        <img src="<?php echo esc_url($image); ?>" alt="Logo" class="subheader-tile-image">
                                        <div class="ml-2 flex-grow-1">
                                            <?php if ($isNew): ?>
                                                <span class="badge bg-kek">New</span>
                                            <?php endif; ?>
                                            <h5 class="mb-1"><?php echo esc_html($title); ?></h5>                                            
                                        </div>                                              
                                    </div>
                                    <ul class="data-pages">
                                            <li>
                                            <a href="https://views4you.com/buy-instagram-followers/">
                                            Buy Instagram Followers </a>
                                            </li>
                                            <li>
                                            <a href="https://views4you.com/buy-instagram-likes/">
                                            Buy Instagram Likes </a>
                                            </li>
                                            <li>
                                            <a href="https://views4you.com/buy-instagram-views/">
                                            Buy Instagram Views </a>
                                            </li>
                                            <li>
                                            <a href="https://views4you.com/buy-instagram-reels-views/">
                                            Buy Instagram Reels Views </a>
                                            </li>
                                            <li>
                                            <a href="https://views4you.com/buy-instagram-auto-likes/">
                                            Buy Instagram Auto Likes </a>
                                            </li>
                                        </ul>  
                                </div>
                            <?php endfor; ?>
                        </div>                                                 
                    </div>
                <?php endif; ?>                        
        </div>               