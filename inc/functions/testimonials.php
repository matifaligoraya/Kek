<?php
// Register Testimonials Custom Post Type
function kek_register_testimonials_cpt() {
    $labels = array(
        'name'               => _x('Testimonials', 'post type general name', 'kek'),
        'singular_name'      => _x('Testimonial', 'post type singular name', 'kek'),
        'menu_name'          => _x('Testimonials', 'admin menu', 'kek'),
        'name_admin_bar'     => _x('Testimonial', 'add new on admin bar', 'kek'),
        'add_new'            => _x('Add New', 'testimonial', 'kek'),
        'add_new_item'       => __('Add New Testimonial', 'kek'),
        'new_item'           => __('New Testimonial', 'kek'),
        'edit_item'          => __('Edit Testimonial', 'kek'),
        'view_item'          => __('View Testimonial', 'kek'),
        'all_items'          => __('All Testimonials', 'kek'),
        'search_items'       => __('Search Testimonials', 'kek'),
        'parent_item_colon'  => __('Parent Testimonials:', 'kek'),
        'not_found'          => __('No testimonials found.', 'kek'),
        'not_found_in_trash' => __('No testimonials found in Trash.', 'kek'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'testimonial'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'thumbnail'),
    );

    register_post_type('testimonial', $args);
}

add_action('init', 'kek_register_testimonials_cpt');

function kek_testimonial_meta_box() {
    add_meta_box(
        'kek_testimonial_meta',
        __('Testimonial Details', 'kek'),
        'kek_testimonial_meta_callback',
        'testimonial',
        'normal',
        'high'
    );
}

function kek_testimonial_meta_callback($post) {
    wp_nonce_field('kek_save_testimonial_meta', 'kek_testimonial_meta_nonce');
    $name = get_post_meta($post->ID, '_kek_testimonial_name', true);
    $niche = get_post_meta($post->ID, '_kek_testimonials_niche', true);
    $followers = get_post_meta($post->ID, '_kek_testimonials_followers', true);
    
    echo '<div class="row">';
    echo '<div class="col-md-3">
            <div class="form-group">
                <label for="kek_testimonial_name">' . __('Name', 'kek') . '</label>
                <input class="form-control" type="text" id="kek_testimonial_name" name="kek_testimonial_name" value="' . esc_attr($name) . '" size="25" />
            </div>
        </div>';

    echo '<div class="col-md-3">
        <div class="form-group">
            <label for="kek_testimonials_niche">' . __('Niche', 'kek') . '</label>
            <input class="form-control" type="text" id="kek_testimonials_niche" name="kek_testimonials_niche" value="' . esc_attr($niche) . '" size="25" />
        </div>
    </div>';

    echo '<div class="col-md-3">
        <div class="form-group">
            <label for="kek_testimonials_followers">' . __('Followers', 'kek') . '</label>
            <input class="form-control" type="text" id="kek_testimonials_followers" name="kek_testimonials_followers" value="' . esc_attr($followers) . '" size="25" />
        </div>
    </div>';
    echo '</div>';
}

add_action('add_meta_boxes', 'kek_testimonial_meta_box');

function kek_save_testimonial_meta($post_id) {
    if (!isset($_POST['kek_testimonial_meta_nonce']) || !wp_verify_nonce($_POST['kek_testimonial_meta_nonce'], 'kek_save_testimonial_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['kek_testimonial_name'])) {
        update_post_meta($post_id, '_kek_testimonial_name', sanitize_text_field($_POST['kek_testimonial_name']));
    }

    if (isset($_POST['kek_testimonials_niche'])) {
        update_post_meta($post_id, '_kek_testimonials_niche', sanitize_text_field($_POST['kek_testimonials_niche']));
    }

    if (isset($_POST['kek_testimonials_followers'])) {
        update_post_meta($post_id, '_kek_testimonials_followers', sanitize_text_field($_POST['kek_testimonials_followers']));
    }
}

add_action('save_post', 'kek_save_testimonial_meta');
?>