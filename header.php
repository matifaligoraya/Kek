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
                            <ul class="top-links-container">
                                <li class="top-links-item"><a href="demo-seo.html">Home</a></li>
                                <li class="top-links-item"><a href="demo-seo-faqs.html">FAQs</a></li>
                                <li class="top-links-item"><a href="demo-seo-contact.html">Contact</a></li>                                
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-md-auto dark" data-bs-theme="dark">

                        <ul id="top-social">
                            <li><a href="https://facebook.com/semicolonweb" class="h-bg-facebook" target="_blank"><span class="ts-icon"><i class="fa-brands fa-facebook-f"></i></span><span class="ts-text">Facebook</span></a></li>
                            <li><a href="https://twitter.com/__semicolon" class="h-bg-x-twitter" target="_blank"><span class="ts-icon"><i class="fa-brands fa-x-twitter"></i></span><span class="ts-text">Twitter</span></a></li>
                            <li><a href="https://youtube.com/semicolonweb" class="h-bg-youtube" target="_blank"><span class="ts-icon"><i class="fa-brands fa-youtube"></i></span><span class="ts-text">Youtube</span></a></li>
                            <li><a href="https://instagram.com/semicolonweb" class="h-bg-instagram" target="_blank"><span class="ts-icon"><i class="fa-brands fa-instagram"></i></span><span class="ts-text">Instagram</span></a></li>
                            <li><a href="tel:+10.11.85412542" class="h-bg-call"><span class="ts-icon"><i class="fa-solid fa-phone"></i></span><span class="ts-text">+10.11.85412542</span></a></li>
                            <li><a href="mailto:info@canvas.com" class="h-bg-email3"><span class="ts-icon"><i class="bi-envelope-fill"></i></span><span class="ts-text">info@canvas.com</span></a></li>
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
                            <button class="cnvs-hamburger" type="button" title="Open Mobile Menu">
                                <span class="cnvs-hamburger-box"><span class="cnvs-hamburger-inner"></span></span>
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