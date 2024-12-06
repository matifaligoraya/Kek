<?php

if (is_active_sidebar( 'footerfull' )): ?>
    <div class="wrapper bg-light mt-5 py-4 footer-back" id="wrapper-footer-widgets">
        
        <div class="container ">
            
            <div class="row">
                <?php dynamic_sidebar( 'footerfull' ); ?>
            </div>
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
        </div>
    </div>
<?php endif ?>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdowns = document.querySelectorAll('.dropdown');

        dropdowns.forEach(dropdown => {
            dropdown.addEventListener('mouseenter', function () {
                const menu = this.querySelector('.dropdown-menu');
                this.classList.add('show');
                menu.classList.add('show');
            });

            dropdown.addEventListener('mouseleave', function () {
                const menu = this.querySelector('.dropdown-menu');
                this.classList.remove('show');
                menu.classList.remove('show');
            });
        });
    });
</script>

<!-- <div class="wrapper py-3" id="wrapper-footer-colophon">
    <div class="container-fluid">

        <div class="row">

            <div class="col text-center ">

                <footer class="site-footer " id="colophon">
            
                    <div class="site-info">

                        <?php picostrap_site_info(); ?>

                    </div> 
                    
                </footer> 

            </div> 

        </div> 

    </div> 

</div>wrapper end -->