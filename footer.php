    <?php 
        $downloads = get_theme_mod('kek_footer_downloads', 15065421);
        $clients = get_theme_mod('kek_footer_clients', 18465);

        $visa_enabled = get_theme_mod('kek_visa_enabled', false);
        $master_enabled = get_theme_mod('kek_master_enabled', false);
        $american_express_enabled = get_theme_mod('kek_american_express_enabled', false);
        $stripe_enabled = get_theme_mod('kek_stripe_enabled', false);        
    ?>
    </div>
    <footer id="footer" class="background-image">
        <div class="container content">
            <div class="footer-widgets-wrap">
                <div class="row ">
                    <div class="col">
                        <div class="widget" style="text-align: center;">
                           
                            <?php echo get_theme_mod('kek_footer_highlight', ''); ?>
                           

                           
                        </div>
                    </div>

              
                </div>
            </div>
        </div>

        <div id="copyrights" class="content">
            <div class="container">
                <div class="row justify-content-between col-mb-30">
                    <div class="col-6 col-lg-auto text-center text-lg-start">                        
                        Copyrights © <?php echo date("Y"); ?> All Rights Reserved by <a href="https://bitandbytelab.com/">Bit & Byte Lab</a>
                    </div>                    
               

                    <div class="col-6 col-lg-auto text-center text-lg-start">                        
                
                                <?php
                                wp_nav_menu(array(
                                    'theme_location' => 'footer-menu',
                                    'container' => 'div',
                                    'container_class' => 'col-6 col-lg-3 widget_links',
                                    'menu_class' => 'footer-menu',
                                    'depth' => 1,
                                ));
                                ?>
                            
                    </div>                    
                </div>
             </div>
        </div>
    </footer>
<style>

.background-image {
    position: relative;
    background: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/footer.png') no-repeat bottom center;
    background-size: cover;
}

.background-image::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8); /* Adjust the opacity here (0.5 = 50% opacity) */
    z-index: 1;
}

.content {
    position: relative;
    z-index: 2; /* Keep content above the overlay */
    color: #000 !important; /* Ensure text is visible */
}
</style>
	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="uil uil-angle-up"></div>

	<!-- JavaScripts
	============================================= -->
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/plugins.min.js"></script>
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/functions.bundle.js"></script>    
</body>
</html>