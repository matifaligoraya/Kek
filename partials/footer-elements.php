<?php

if (is_active_sidebar( 'footerfull' )): ?>
    <div class="wrapper bg-light mt-5 py-5" id="wrapper-footer-widgets">
        
        <div class="container mb-5">
            
            <div class="row">
                <?php dynamic_sidebar( 'footerfull' ); ?>
            </div>

        </div>
    </div>
<?php endif ?>


<div class="wrapper py-3" id="wrapper-footer-colophon">
    <div class="container-fluid">

        <div class="row">

            <div class="col text-center footer-back">

                <footer class="site-footer " id="colophon">
            
                    <div class="site-info">

                        <?php picostrap_site_info(); ?>

                    </div><!-- .site-info -->
                    <ul class="circles">
                    <li><i class="fab fa-youtube"></i></li>
        <li><i class="fab fa-tiktok"></i></li>
        <li><i class="fab fa-instagram"></i></li>
        <li><i class="far fa-comment-alt"></i></li>
        <li><i class="far fa-thumbs-up"></i></li>
        <li><i class="fas fa-share-alt"></i></li>
        <li><i class="fab fa-facebook-f"></i></li>
        <li><i class="fab fa-twitter"></i></li>
        <li><i class="fas fa-heart"></i></li>
        <li><i class="fab fa-linkedin-in"></i></li>
            </ul>
                </footer><!-- #colophon -->

            </div><!--col end -->

        </div><!-- row end -->

    </div><!-- container end -->

</div><!-- wrapper end -->