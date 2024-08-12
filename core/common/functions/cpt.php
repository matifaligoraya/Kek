<?php 
add_action('init', 'kek_create_ebook_block');
function kek_create_ebook_block() {
    register_post_type('ebook_block',
        array(
            'labels' => array(
                'name' => esc_html__('eBook Blocks', 'sublimeplus'),
                'singular_name' => esc_html__('eBook Block', 'sublimeplus'),
                'add_new' => esc_html__('Add New', 'sublimeplus'),
                'add_new_item' => esc_html__('Add New eBook Block', 'sublimeplus'),
                'edit' => esc_html__('Edit', 'sublimeplus'),
                'edit_item' => esc_html__('Edit eBook Block', 'sublimeplus'),
                'all_items' => esc_html__('All eBook Blocks', 'sublimeplus'),
                'new_item' => esc_html__('New eBook Block', 'sublimeplus'),
                'view' => esc_html__('View', 'sublimeplus'),
                'view_item' => esc_html__('View eBook Block', 'sublimeplus'),
                'search_items' => esc_html__('Search eBook Blocks', 'sublimeplus'),
                'not_found' => esc_html__('No eBook Blocks found', 'sublimeplus'),
                'not_found_in_trash' => esc_html__('No eBook Blocks found in Trash', 'sublimeplus'),
                'parent' => esc_html__('Parent eBook Block', 'sublimeplus')
            ),
            'hierarchical' => false,
            'public' => false,
            'show_ui' => true,
            'menu_position' => 60,
            'supports' => array('title', 'editor'),
            'menu_icon' => 'dashicons-book-alt',
            'publicly_queryable' => false,
            'exclude_from_search' => true,
            'has_archive' => false,
            'query_var' => true,
            'can_export' => true,
            'capability_type' => 'post'
        )
    );
}


// Register custom post type for Footer Builder in SublimePlus theme
add_action('init', 'kek_create_footer_builder');
function kek_create_footer_builder()
{
    register_post_type('sp_footer_builder',
        array(
            'labels' => array(
                'name' => esc_html__('Footer Builders', 'sublimeplus'),
                'singular_name' => esc_html__('Footer Builder', 'sublimeplus'),
                'add_new' => esc_html__('Add New', 'sublimeplus'),
                'add_new_item' => esc_html__('Add New Footer', 'sublimeplus'),
                'edit' => esc_html__('Edit', 'sublimeplus'),
                'edit_item' => esc_html__('Edit Footer', 'sublimeplus'),
                'all_items' => esc_html__('All Footers', 'sublimeplus'),
                'new_item' => esc_html__('New Footer', 'sublimeplus'),
                'view' => esc_html__('View', 'sublimeplus'),
                'view_item' => esc_html__('View Footer', 'sublimeplus'),
                'search_items' => esc_html__('Search Footers', 'sublimeplus'),
                'not_found' => esc_html__('No Footers found', 'sublimeplus'),
                'not_found_in_trash' => esc_html__('No Footers found in Trash', 'sublimeplus'),
                'parent' => esc_html__('Parent Footer', 'sublimeplus')
            ),
            'hierarchical' => false,
            'public' => false,
            'show_ui' => true,
            'menu_position' => 60,
            'supports' => array('title', 'editor'),
            'menu_icon' => 'dashicons-editor-kitchensink',
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'has_archive' => false,
            'query_var' => true,
            'can_export' => true,
            'capability_type' => 'post'
        )
    );
}

function set_wpbakery_post_types()
{
    $list = array(
        'page',
        'post',
        'sp_header_builder',
        'educationalpackage',
        'sp_footer_builder',
        'ebook_block',
        'sp_pre_footer_builder',  // Your custom post type identifier
    );
    vc_set_default_editor_post_types($list);
}
add_action('vc_before_init', 'set_wpbakery_post_types');


/** footer **/
if (!function_exists('sublime_footer_builder')) {
    function sublime_footer_builder() {
        // Define the base URI for your theme's JavaScript files
        $theme_js_uri = kek_URI . 'assets/js/';

        // Register and enqueue scripts
        wp_enqueue_script('popper-js', $theme_js_uri . 'popper.min.js?ver=8.6.1', array(), null, true);
        wp_enqueue_script('bootstrap-5-js', $theme_js_uri . 'bootstrap-5.1.3.min.js?ver=8.6.1', array(), null, true);
        wp_enqueue_script('bootstrap-4-js', $theme_js_uri . 'bootstrap-4.1.3.min.js?ver=8.6.1', array(), null, true);
        wp_enqueue_script('choices-js', $theme_js_uri . 'choices.min.js?ver=8.6.1', array(), null, true);
        wp_enqueue_script('swiper-js', $theme_js_uri . 'swiper-bundle.min.js?ver=8.6.1', array(), null, true);
        wp_enqueue_script('fancybox-js', $theme_js_uri . 'fancybox.umd.js?ver=1723200310', array(), null, true);
        wp_enqueue_script('owl-js', $theme_js_uri . 'owl.carousel.min.js?ver=8.6.1', array(), null, true);
        wp_enqueue_script('wow-js', $theme_js_uri . 'wow.min.js?ver=8.6.1', array(), null, true);
        wp_enqueue_script('main-js', $theme_js_uri . 'main.js?ver=1723200310', array(), null, true);
        wp_enqueue_script('wcl-functions-js', $theme_js_uri . 'wcl-functions.js?ver=1723200310', array(), null, true);

        // Localize script for passing data to main.js
        wp_localize_script('main-js', 'Views4YouConfig', array(
            'recaptcha_key' => '6Le21MgpAAAAAFZfbTlo5uVVtME1xDDSBX1TpKEa',
            'template_path' => 'https://views4you.com/wp-content/themes/views4you_theme',
            'template_version' => '8.6.1',
            'money_symbol' => '$',
            'money_currency' => 'USD',
        ));
    }

    // Hook the function to wp_enqueue_scripts
    add_action('wp_enqueue_scripts', 'sublime_footer_builder');
}

// Add image upload field to category add form
function add_category_image_field($taxonomy)
{
    ?>
    <div class="form-field term-group">
        <label for="category_image"><?php _e('Category Image', 'sublimeplus'); ?></label>
        <input type="hidden" id="category_image" name="category_image" value="">
        <div id="category_image_preview" style="margin-top: 10px;"></div>
        <button type="button" class="button button-secondary"
                id="upload_category_image"><?php _e('Upload Image', 'sublimeplus'); ?></button>
        <button type="button" class="button button-secondary"
                id="remove_category_image"><?php _e('Remove Image', 'sublimeplus'); ?></button>
    </div>
    <script>
        jQuery(document).ready(function($) {
            var frame;
            $('#upload_category_image').on('click', function(e) {
                e.preventDefault();
                if (frame) {
                    frame.open();
                    return;
                }
                frame = wp.media({
                    title: '<?php _e('Select or Upload Image', 'sublimeplus'); ?>',
                    button: {
                        text: '<?php _e('Use this image', 'sublimeplus'); ?>'
                    },
                    multiple: false
                });
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#category_image').val(attachment.id);
                    $('#category_image_preview').html('<img src="' + attachment.url +
                        '" style="max-width: 100%; height: auto;">');
                });
                frame.open();
            });
            $('#remove_category_image').on('click', function(e) {
                e.preventDefault();
                $('#category_image').val('');
                $('#category_image_preview').html('');
            });
        });
    </script>
    <?php
}
add_action('category_add_form_fields', 'add_category_image_field');

// Edit category form field
function edit_category_image_field($term, $taxonomy)
{
    $image_id = get_term_meta($term->term_id, 'category_image', true);
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="category_image"><?php _e('Category Image', 'sublimeplus'); ?></label>
        </th>
        <td>
            <input type="hidden" id="category_image" name="category_image" value="<?php echo esc_attr($image_id); ?>">
            <div id="category_image_preview" style="margin-top: 10px;">
                <?php if ($image_id) {
                    $image_url = wp_get_attachment_url($image_id);
                    if ($image_url) {
                        echo '<img src="' . esc_url($image_url) . '" style="max-width: 100%; height: auto;">';
                    }
                } ?>
            </div>
            <button type="button" class="button button-secondary"
                    id="upload_category_image"><?php _e('Upload Image', 'sublimeplus'); ?></button>
            <button type="button" class="button button-secondary"
                    id="remove_category_image"><?php _e('Remove Image', 'sublimeplus'); ?></button>
        </td>
    </tr>
    <script>
        jQuery(document).ready(function($) {
            var frame;
            $('#upload_category_image').on('click', function(e) {
                e.preventDefault();
                if (frame) {
                    frame.open();
                    return;
                }
                frame = wp.media({
                    title: '<?php _e('Select or Upload Image', 'sublimeplus'); ?>',
                    button: {
                        text: '<?php _e('Use this image', 'sublimeplus'); ?>'
                    },
                    multiple: false
                });
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#category_image').val(attachment.id);
                    $('#category_image_preview').html('<img src="' + attachment.url +
                        '" style="max-width: 100%; height: auto;">');
                });
                frame.open();
            });
            $('#remove_category_image').on('click', function(e) {
                e.preventDefault();
                $('#category_image').val('');
                $('#category_image_preview').html('');
            });
        });
    </script>
    <?php
}
add_action('category_edit_form_fields', 'edit_category_image_field', 10, 2);

// Save category image meta field
function save_category_image($term_id)
{
    if (isset($_POST['category_image'])) {
        update_term_meta($term_id, 'category_image', absint($_POST['category_image']));
    }
}
add_action('created_category', 'save_category_image');
add_action('edited_category', 'save_category_image');

// Display category image
function get_category_image_url($term_id)
{
    $image_id = get_term_meta($term_id, 'category_image', true);
    if ($image_id) {
        $image_url = wp_get_attachment_url($image_id);
        if ($image_url) {
            return esc_url($image_url);
        }
    }
    return '';
}

function list_all_categories_with_images()
{


    $settings = get_option(kek_SETTINGS_KEY); // Ensure the key is correct
    // show_category_list
    $show_category_list = isset($settings['show_category_list']) ? $settings['show_category_list'] : 'off';



    // Get all categories except 'Uncategorized' and empty categories
    $categories = get_categories(array(
        'hide_empty' => true, // Exclude empty categories
        'exclude' => 1, // Exclude 'Uncategorized' category, assuming its ID is 1
    ));
    $output = "";
    if ($show_category_list == "on") {

        // Start building the HTML output
        $output = '<div class="row mb-5 mt-5">';
        $output .= '<div class="col-md-12">';
        $output .= '<ul class="lp-home-categoires padding-left-0 new-banner-category-view4">';

        // Loop through each category
        foreach ($categories as $category) {
            $category_link = get_category_link($category->term_id);
            $category_name = esc_html($category->name);
            $category_image_url = get_category_image_url($category->term_id);

            // Default icon class if no image is set
            $icon_class = $category_image_url ? 'category-image' : 'fa-solid fa-circle';

            $output .= '<li>';
            $output .= '<a href="' . esc_url($category_link) . '" class="lp-border-radius-5">';
            if ($category_image_url) {
                $output .= '<img width="100px" src="' . esc_url($category_image_url) . '" alt="' . $category_name . '" class="category-icon">';
            } else {
                //   $output .= '<i class="icon icons-banner-cat ' . $icon_class . '"></i>';
            }
            $output .=  $category_name ;
            $output .= '</a>';
            $output .= '</li>';
        }

        $output .= '</ul>';
        $output .= '</div>';
        $output .= '</div>';
    }
    // Return the HTML output
    return $output;
}

function getAllowedHTMLTags()
{
    return $allowed_html = array(
        'script' => array(
            'type' => array(),
            'src' => array()
        ),
        'strong' => array(),
        'span' => array(
            'class' => array(),
        ), 'div' => array(
            'class' => array(),
        ),
        'p' => array(
            'class' => array(),
        ),
        'a' => array(
            'href' => array(),
            'title' => array(),
            'class' => array(),
            'style' => array(),
            'target' => array(),
        ),
        'br' => array(),
        'em' => array(),
        'b' => array(),
        'ul' => array(
            'class' => array(),
        ),
        'li' => array(
            'class' => array(),
        ),
        'iframe' => array(
            'src' => array(),
            'width' => array(),
            'height' => array(),
            'frameborder' => array(),
            'allow' => array(),
            'allowfullscreen' => array(),
        ),
        'form' => array(
            'action' => array(),
            'method' => array(),
            'class' => array(),
            'id' => array(),
            'name' => array(),
            'target' => array(),
        ),
        'input' => array(
            'type' => array(),
            'name' => array(),
            'value' => array(),
            'class' => array(),
            'id' => array(),
            'placeholder' => array(),
            'checked' => array(),
            'disabled' => array(),
            'readonly' => array(),
            'size' => array(),
            'maxlength' => array(),
            'src' => array(),
            'alt' => array(),
            'step' => array(),
            'min' => array(),
            'max' => array(),
        ),
        'textarea' => array(
            'name' => array(),
            'class' => array(),
            'id' => array(),
            'cols' => array(),
            'rows' => array(),
            'placeholder' => array(),
            'readonly' => array(),
            'maxlength' => array(),
        ),
        'select' => array(
            'name' => array(),
            'class' => array(),
            'id' => array(),
        ),
        'option' => array(
            'value' => array(),
            'selected' => array(),
        ),
        'button' => array(
            'type' => array(),
            'name' => array(),
            'value' => array(),
            'class' => array(),
            'id' => array(),
        ),
    );
}
// Use the function where you want to display the categories
//echo list_all_categories_with_images();
function ewf_blog_sidebar_init() {
    register_sidebar(array(
        'name'          => __('EWF Blog Sidebar', 'sublimeplus'),
        'id'            => 'ewf-blog-sidebar',
        'description'   => __('Widgets in this area will be shown on the blog pages.', 'sublimeplus'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    register_sidebar(array(
        'name'          => __('EWF Post Sidebar', 'sublimeplus'),
        'id'            => 'ewf-post-sidebar',
        'description'   => __('Widgets in this area will be shown on individual posts.', 'sublimeplus'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}


add_action('widgets_init', 'ewf_blog_sidebar_init');

function ewf_blog_sidebar() {
    if (is_active_sidebar('ewf-blog-sidebar')) {
        dynamic_sidebar('ewf-blog-sidebar');
    }
}


function get_breadcrumb() {
    echo '<a href="'.home_url().'" rel="nofollow">Home</a>' .   the_title();;
    if (is_category() || is_single()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        the_category(' &bull; ');
            if (is_single()) {
                echo " &nbsp;&nbsp;&#187;&nbsp;&nbsp; ";
                the_title();
            }
    } elseif (is_page()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        echo the_title();
    } elseif (is_search()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;Search Results for... ";
        echo '"<em>';
        echo the_search_query();
        echo '</em>"';
    }
}