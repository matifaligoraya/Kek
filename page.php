<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>


<div id="container-content-page" class="container">
    <div class="row">
        <div class="col-12">
            <?php 

            if ( have_posts() ) : 
                while ( have_posts() ) : the_post();
                    the_content();
                endwhile;
            else :
                _e( 'Sorry, no posts matched your criteria.', 'textdomain' );
            endif;
            ?>
        </div>
    </div>
</div>


<?php get_footer();
