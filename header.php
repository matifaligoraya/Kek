<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Imports -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital@0;1&display=swap"
        rel="stylesheet">

    <?php wp_head(); ?>
    <?php $settings = get_option(kek_SETTINGS_KEY, true); ?>
</head>

<body <?php body_class('stretched'); ?>>
    <!-- Document Wrapper
	============================================= -->
    <div id="wrapper">
        <?php if (is_front_page()) : ?>
            <?php
           // $background_image_url = isset($settings['home_page_background']) ? $settings['home_page_background'] : '';

           // if (!empty($background_image_url)) : style="background-image: url('<?php echo get_stylesheet_directory_uri();/assets/images/main-background.svg" ?>
                <div class="position-absolute vh-100 w-100 top-0 start-0 overflow-hidden"
                    >
                    <div class="overlay"></div>
                    <div id="splash-background"></div>
                <?php //endif; ?>
                </div>
            <?php endif; ?>

          
            <header id="header" class="transparent-header floating-header header-size-md">
                <div id="header-wrap" class="">
                    <div class="container">
                        <div class="header-row top-search-parent">

                            <div id="logo">
                                <?php get_template_part('inc/templates/logo'); ?>
                            </div>
                            <div class="header-misc">
                                <a href="demo-seo-about.html" class="button button-rounded ms-3 d-none d-sm-block">Get
                                    Started</a>
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

            <?php
            $tiles = isset($settings['sub_header_tiles']) ? $settings['sub_header_tiles'] : array();

            if ($tiles): ?>
                <section class="kek-subheader-slider">
                    <div class="container data-wrapper">
                        <div class="owl-carousel owl-theme">
                            <?php


                            for ($i = 0; $i < count($tiles['image']); $i++):
                                $image = !empty($tiles['image'][$i]) ? $tiles['image'][$i] : '';
                                $title = !empty($tiles['title'][$i]) ? $tiles['title'][$i] : '';
                                $menu_id = !empty($tiles['menu'][$i]) ? $tiles['menu'][$i] : ''; // Get the associated menu ID
                                $isNew = !empty($tiles['isNew'][$i]); // Check if the tile is new

                                // Fetch the menu items based on the menu ID
                                $menu_items = wp_get_nav_menu_items($menu_id);
                            ?>
                                <div class="platform-item">
                                    <button class="data-button">
                                        <div class="data-logo">
                                            <img width="69" height="69" src="<?php echo esc_url($image); ?>"
                                                class="attachment-platform_logo size-platform_logo"
                                                alt="<?php echo esc_attr($title); ?>" decoding="async">
                                        </div>
                                        <div class="data-name-wrapper">
                                            <p class="data-name"><?php echo esc_html($title); ?></p>
                                            <?php if ($isNew): ?>
                                                <span class="data-label">new</span>
                                            <?php endif; ?>
                                        </div>
                                    </button>
                                    <ul class="data-pages">
                                        <?php if ($menu_items): ?>
                                            <?php foreach ($menu_items as $menu_item): ?>
                                                <li>
                                                    <a href="<?php echo esc_url($menu_item->url); ?>">
                                                        <?php echo esc_html($menu_item->title); ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            <?php
                            endfor;

                            ?>
                        </div>
                    </div>
                </section>
            <?php
            endif;
            ?>
            <?php if (is_front_page()) : ?>
                <!-- Custom Block Display -->
                <div class="custom-block-container">
                    <?php
                    // Retrieve the selected custom block ID from the settings
                    $custom_block_id = isset($settings['home_page_custom_block']) ? $settings['home_page_custom_block'] : '';

                    if (!empty($custom_block_id)) {
                        // Fetch the post content of the selected custom block
                        $custom_block = get_post($custom_block_id);

                        if ($custom_block && !is_wp_error($custom_block)) {
                            // Display the content with WPBakery shortcodes processed
                            echo apply_filters('the_content', $custom_block->post_content);
                        }
                    }
                    ?>
                </div>
            <?php endif; ?>
            <div class=" ">