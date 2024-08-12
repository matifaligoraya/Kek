<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package     KeK
 * @version     1.0.0
 * @author      KeK
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2020 KeK
 */

?>
 <article class="news-article wow fadeInLeft <?php post_class('post-item post-detail'); ?>"  id="post-<?php the_ID(); ?>" >
        <div class="header-post">
            <?php

            /**
             * Zoo Before Single Blog Content
             * kek_single_post_sticky_label 10
             */
            do_action('kek_before_single_post_title');
            ?>
            <h1 class="title-detail"><?php
                the_title();
                kek_single_post_sticky_label();
                ?>
            </h1>
            <?php
            /**
             * Zoo Before Single Blog Content
             * kek_single_post_info 10
             *
             */
            do_action('kek_after_single_post_title');
            ?>
        </div>
        <?php
        /**
         * Before single content post
         * kek_single_post_media 10
         *
         */
        do_action('kek_before_single_content');
        ?>
        <div class="post-content">ZX
            
            <?php
            the_content();
            ?>
        </div>
        <?php
        /**
         * Before after content post
         * kek_single_post_pagination 10
         * kek_single_post_bottom_content 20
         */
        do_action('kek_after_single_content');
        ?>
    </article>
<?php
/**
 * Bottom single post
 * kek_single_post_about_author 10
 * kek_single_post_navigation 20
 */
do_action('kek_single_post_bottom');

// If comments are open or we have at least one comment, load up the comment template.
if (comments_open() || get_comments_number()) :
   // comments_template('', true);
endif;