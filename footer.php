    <?php 
        $downloads = get_theme_mod('kek_footer_downloads', 15065421);
        $clients = get_theme_mod('kek_footer_clients', 18465);

        $visa_enabled = get_theme_mod('kek_visa_enabled', false);
        $master_enabled = get_theme_mod('kek_master_enabled', false);
        $american_express_enabled = get_theme_mod('kek_american_express_enabled', false);
        $stripe_enabled = get_theme_mod('kek_stripe_enabled', false);        
    ?>
    </div>
    <footer id="footer" style="background: url('<?php echo esc_url(get_theme_mod('kek_footer_bg_image', '')); ?>') repeat; background-size: cover;">
        <div class="container">
            <div class="footer-widgets-wrap">
                <div class="row col-mb-50">
                    <div class="col-md-8">
                        <div class="widget">
                            <img src="<?php echo get_theme_mod('kek_footer_image', ''); ?>" alt=" " class="alignleft" style="margin-top: 8px; padding-right: 18px; border-right: 1px solid #4A4A4A;">
                            <?php echo get_theme_mod('kek_footer_highlight', ''); ?>
                            <div class="line" style="margin: 30px 0;"></div>

                           
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="widget">
                            <div class="row col-mb-30">
                                <div class="col-lg-6">
                                    <div class="counter counter-small">                                        
                                        <span data-from="50" data-to="<?php echo $downloads ?>" data-refresh-interval="80" data-speed="3000" data-comma="true"></span>
                                    </div>
                                    <h5 class="mb-0">YouTube Views</h5>
                                </div>

                                <div class="col-lg-6">
                                    <div class="counter counter-small">                                                                                
                                        <span data-from="50" data-to="<?php echo $clients ?>" data-refresh-interval="50" data-speed="2000" data-comma="true"></span>
                                    </div>
                                    <h5 class="mb-0">Clients</h5>
                                </div>
                            </div>
                        </div>
                        <br />
                      
                    </div>
                </div>
            </div>
        </div>

        <div id="copyrights">
            <div class="container">
                <div class="row justify-content-between col-mb-30">
                    <div class="col-12 col-lg-auto text-center text-lg-start">                        
                        Copyrights © <?php echo date("Y"); ?> All Rights Reserved by <a href="https://bitandbytelab.com/">Bit & Byte Lab</a>
                    </div>                    
                </div>
           <div class="row justify-content-between col-mb-30">
                    <div class="col-12 col-lg-auto text-center text-lg-start">                        
                    <div class="row col-mb-30">
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
        </div>
    </footer>

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="uil uil-angle-up"></div>

	<!-- JavaScripts
	============================================= -->
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/plugins.min.js"></script>
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/functions.bundle.js"></script>    
</body>
</html>