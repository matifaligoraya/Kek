<?php
/**
 * The template for displaying archive pages.
 *
 * @package     KeK
 * @version     1.0.0
 * @author      KeK
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2020 KeK
 
 */

get_header();

/**
 * Zoo Before Main Content
 *
 * @hooked kek_breadcrumb - 10
 * @hooked kek_blog_cover - 20
 */
do_action('kek_before_main_content');
?>
    <main id="site-main-content" class="asd asd<?php echo esc_attr(kek_main_content_css()) ?>">
        <div class="container">
            <div class="row">
                <div class="<?php echo esc_attr(kek_loop_content_css()) ?>">
                    <?php
                    /**
                     * Zoo Before Loop Blog Content
                     *
                     */
                    do_action('kek_before_loop_content');
                    ?>
                    <div class="row">
                        <?php if (have_posts()) :
                            while (have_posts()) : the_post();
                                get_template_part('inc/templates/posts/loop/post', 'item');
                            endwhile;
                        else :
                            get_template_part('content', 'none');
                        endif; ?>
                    </div>
                    <?php
                    /**
                     * Zoo After Loop Blog Content
                     *@hooked kek_post_pagination - 10
                     */
                    do_action('kek_after_loop_content');
                    ?>
                </div>
                <?php get_sidebar();?>
            </div>
        </div>
    </main>
<?php
/**
 * Zoo After Main Content
 *
 */
do_action('kek_after_main_content');
get_footer();