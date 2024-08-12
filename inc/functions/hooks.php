<?php
/**
 * Hooks of Blog
 * All templates of theme will load by hook. User can change order and location at custom file.
 *
 */

/**
 * Hook follow blog layout
 * */
add_action('kek_before_post_item', 'kek_post_item_thumbnail', 20);

/**
 * kek_breadcrumb
 * Get template breadcrumb
 * @uses use function and hook to kek_before_main_content
 * */
if (!function_exists('kek_breadcrumb')) {
    function kek_breadcrumb()
    {
        get_template_part('inc/templates/breadcrumbs');
    }
}
add_action('kek_before_main_content', 'kek_breadcrumb', 10);

/**
 * kek_blog_cover
 * Get template blog cover
 * @uses use function and hook to kek_before_main_content
 * */
if (!function_exists('kek_blog_cover')) {
    function kek_blog_cover()
    {
        get_template_part('inc/templates/posts/blog', 'cover');
    }
}
add_action('kek_before_main_content', 'kek_blog_cover', 20);


/**
 * kek_post_pagination
 * Get template post pagination for loop
 * @uses use function and hook to kek_before_main_content
 * */
if (!function_exists('kek_post_pagination')) {
    function kek_post_pagination()
    {
        get_template_part('inc/templates/posts/post', 'pagination');
    }
}
add_action('kek_after_loop_content', 'kek_post_pagination', 10);

/**
 * kek_post_item_thumbnail
 * Get template post item thumbnail for loop
 * @uses use function and hook to kek_post_item_thumbnail
 * */
if (!function_exists('kek_post_item_thumbnail')) {
    function kek_post_item_thumbnail()
    {
        get_template_part('inc/templates/posts/loop/thumbnail');
    }
}
/**
 * kek_post_item_info
 * Get template post item thumbnail for loop
 * @uses use function and hook to kek_post_item_thumbnail
 * */
if (!function_exists('kek_post_item_info')) {
    function kek_post_item_info()
    {
        get_template_part('inc/templates/posts/loop/post', 'info');;
    }
}
/**
 * kek_post_item_cat
 * Get template post item thumbnail for loop
 * @uses use function and hook to kek_post_item_thumbnail
 * */
if (!function_exists('kek_post_item_cat')) {
    function kek_post_item_cat()
    {
        if (get_theme_mod('kek_blog_layout', 'list') == 'grid' || get_theme_mod('kek_blog_layout', 'list') == 'masonry') {
            if (!has_post_thumbnail()) {
                get_template_part('inc/templates/posts/global/sticky');
            }
        }
        if (get_theme_mod('kek_enable_loop_cat_post', '1') == 1) {
            ?>
            <div class="list-cat">
                <?php if (get_theme_mod('kek_blog_loop_post_info_style', '') == 'icon') { ?>
                    <i class="cs-font clever-icon-document"></i>
                    <?php
                }
                echo get_the_term_list(get_the_ID(), 'category', '', ', ', ''); ?></div>
        <?php }
    }
}
add_action('kek_before_post_item_title', 'kek_post_item_cat', 20);

/**
 * kek_post_item_readmore
 * Get template post item thumbnail for loop
 * @uses use function and hook to kek_post_item_readmore
 * */
if (!function_exists('kek_post_item_readmore')) {
    function kek_post_item_readmore()
    {
        if (get_theme_mod('kek_enable_loop_readmore', '1') == 1 || get_the_title() == '') {
            ?>
            <a href="<?php echo esc_url(the_permalink()); ?>"
               class="readmore"><?php echo esc_html__('Read more', 'sublimeplus'); ?><i class="cs-font clever-icon-arrow-right-5"></i> </a>
            <?php
        }
    }
}
add_action('kek_after_post_item', 'kek_post_item_readmore', 10);

/**---------------------------------------------------------
 *----------------------SINGLE POST------------------------
 *----------------------------------------------------------*/

/**
 * kek_single_post_sticky_label
 * Get sticky label template
 * */
if (!function_exists('kek_single_post_sticky_label')) {
    function kek_single_post_sticky_label()
    {
        get_template_part('inc/templates/posts/global/sticky');
    }
}
/**
 * kek_single_post_category
 * Get sticky label template
 * @uses hook to kek_before_single_post_title
 * */
if (!function_exists('kek_single_post_category')) {
    function kek_single_post_category()
    {
        get_template_part('inc/templates/posts/single/post','cat');
    }
}
add_action('kek_before_single_post_title', 'kek_single_post_category', 10);

/**
 * kek_single_post_sticky_label
 * Get sticky label template
 * @uses hook to kek_before_single_post_title
 * */
if (!function_exists('kek_single_post_info')) {
    function kek_single_post_info()
    {
        get_template_part('inc/templates/posts/single/post-info');
    }
}
add_action('kek_after_single_post_title', 'kek_single_post_info', 10);

/**
 * kek_single_post_media
 * Get media template of single post
 * @uses hook to kek_before_single_content
 * */
if (!function_exists('kek_single_post_media')) {
    function kek_single_post_media()
    {
        get_template_part('inc/templates/posts/single/media');
    }
}
add_action('kek_before_single_content', 'kek_single_post_media', 10);

/**
 * kek_single_post_gallery
 * Get media template of single post
 * @uses hook to kek_before_single_content
 * */
if (!function_exists('kek_single_post_gallery')) {
    function kek_single_post_gallery()
    {
        get_template_part('inc/templates/posts/single/gallery');
    }
}
add_action('kek_before_main_content', 'kek_single_post_gallery', 10);

/**
 * !IMPORTANT This is default feature of WP, don't remove.
 * kek_single_post_pagination
 * Get pagination template of single post
 * @uses hook to kek_after_single_content
 * */
if (!function_exists('kek_single_post_pagination')) {
    function kek_single_post_pagination()
    {
        get_template_part('inc/templates/pagination', 'detail');
    }
}
add_action('kek_after_single_content', 'kek_single_post_pagination', 10);

/**
 * kek_single_post_bottom_content
 * Get bottom post template of single post
 * Display share, tag, category.
 * @uses hook to kek_after_single_content
 * */
if (!function_exists('kek_single_post_bottom_content')) {
    function kek_single_post_bottom_content()
    {
        get_template_part('inc/templates/posts/single/bottom-post-content');
    }
}
add_action('kek_after_single_content', 'kek_single_post_bottom_content', 20);

/**
 * kek_single_post_about_author
 * Get temple about post author
 * Display post author.
 * @uses hook to kek_single_post_bottom
 * */
if (!function_exists('kek_single_post_about_author')) {
    function kek_single_post_about_author()
    {
        get_template_part('inc/templates/posts/single/about', 'author');
    }
}
add_action('kek_single_post_bottom', 'kek_single_post_about_author', 10);

/**
 * kek_single_post_navigation
 * Get template post navigation
 * Display next and previous post.
 * @uses hook to kek_single_post_bottom
 * */
if (!function_exists('kek_single_post_navigation')) {
    function kek_single_post_navigation()
    {
        get_template_part('inc/templates/posts/single/post', 'navigation');
    }
}
add_action('kek_single_post_bottom', 'kek_single_post_navigation', 20);

/**
 * kek_single_post_related
 * Get template related posts
 * Display related posts.
 * @uses hook to kek_single_post_bottom
 * */
if (!function_exists('kek_single_post_related')) {
    function kek_single_post_related()
    {
        get_template_part('inc/templates/posts/single/related', 'posts');
    }
}
add_action('kek_after_single_main_content', 'kek_single_post_related', 10);



