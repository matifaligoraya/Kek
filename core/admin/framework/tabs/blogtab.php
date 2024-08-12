<?php
require_once kek_DIR . 'core/admin/framework/basetab.php'; // If SublimeBaseTab is in the same directory
add_action('admin_enqueue_scripts', 'wp_enqueue_color_picker');
function wp_enqueue_color_picker($hook_suffix) {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('wp-color-picker-script-handle', plugins_url('wp-color-picker-script.js', __FILE__), array('wp-color-picker'), false, true);
}

class SublimeBlogTab extends SublimeBaseTab {

    public function getTitle() {
        return __('Blog', 'sublimeplus');
    }

    public function render() {
        $this->renderopen();
        ?>
<div class="row">
    <div class="col-lg-12">
        <div class="mb-2">
            <label for="blog_title" class="form-label"><?php esc_html_e('Blog Title', 'sublimeplus') ?></label>
            <input type="text" value="<?php echo esc_html($this->getValue('blog_title')); ?>" class="form-control"
                name="<?php echo esc_attr($this->getName('blog_title')); ?>" />
            <small
                class="form-text text-muted"><?php esc_html_e('Enter the title for your blog.', 'sublimeplus'); ?></small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="mb-2">
            <label for="blog_description"
                class="form-label"><?php esc_html_e('Blog Description', 'sublimeplus'); ?></label>
            <textarea class="form-control" name="<?php echo esc_attr($this->getName('blog_description')); ?>"
                rows="4"><?php echo esc_html($this->getValue('blog_description')); ?></textarea>
            <small
                class="form-text text-muted"><?php esc_html_e('Enter a short description for your blog.', 'sublimeplus'); ?></small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="mb-2">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="<?php echo esc_attr($this->getName('show_footer_on_blog')); ?>" id="show_footer_on_blog" <?php checked($this->getValue('show_footer_on_blog'), 'on'); ?>>
            <label class="form-check-label" for="show_footer_on_blog"><?php esc_html_e('Show footer on blog page4', 'sublimeplus'); ?></label>
        </div>      
    
    </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <fieldset>
            <legend><label class="form-label"><?php esc_html_e('Post Setting/Options', 'sublimeplus'); ?></label>
            </legend>
            <div class="row mt-5">
                <div class="col-lg-6">
                    <div class="mb-2">

                        <div class="form-group">
                            <label for="recent_post_sort_order"
                                class="form-label"><?php esc_html_e('Recent Post Sort Order', 'sublimeplus'); ?></label>
                            <select name="<?php echo esc_attr($this->getName('recent_post_sort_order')); ?>"
                                id="recent_post_sort_order" class="flex-select mb-3">
                                <option value="date"
                                    <?php selected($this->getValue('recent_post_sort_order'), 'date'); ?>>
                                    <?php esc_html_e('Date', 'sublimeplus'); ?></option>
                                <option value="id" <?php selected($this->getValue('recent_post_sort_order'), 'id'); ?>>
                                    <?php esc_html_e('ID', 'sublimeplus'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="mb-2">
                        <label class="form-label"><?php esc_html_e('Video Analysis Category', 'sublimeplus'); ?></label>
                        <div class="form-group">
                            <select name="<?php echo esc_attr($this->getName('video_analysis_category')); ?>"
                                id="video_analysis_category" class="form-control">
                                <option value=""><?php esc_html_e('Select Category', 'sublimeplus'); ?></option>
                                <?php
                                        $categories = get_categories(array('hide_empty' => false));
                                        $selected_video_category = $this->getValue('video_analysis_category');
                                        foreach ($categories as $category) {
                                            ?>
                                <option value="<?php echo esc_attr($category->term_id); ?>"
                                    <?php selected($selected_video_category, $category->term_id); ?>>
                                    <?php echo esc_html($category->name); ?>
                                </option>
                                <?php
                                        }
                                        ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-lg-6">
                    <div class="form-group mt-3">
                        <label for="recent_post_categories" class="form-label">
                            <?php esc_html_e('Selected Categories', 'sublimeplus'); ?>
                            <span id="selected_categories_text"><?php echo $this->getSelectedCategoriesText(); ?></span>
                        </label>
                        <select name="<?php echo esc_attr($this->getName('recent_post_categories')); ?>[]"
                            id="recent_post_categories" class="form-control" multiple>
                            <option value="all"
                                <?php selected(empty($this->getValue('recent_post_categories')), true); ?>>
                                <?php esc_html_e('Show All', 'sublimeplus'); ?></option>
                            <?php
                                    $categories = get_categories(array('hide_empty' => false));
                                    $selected_categories = $this->getValue('recent_post_categories') ?: array();
                                    foreach ($categories as $category) {
                                        ?>
                            <option value="<?php echo esc_attr($category->term_id); ?>"
                                <?php echo in_array($category->term_id, $selected_categories) ? 'selected' : ''; ?>>
                                <?php echo esc_html($category->name); ?>
                            </option>
                            <?php
                                    }
                                    ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-2">
                        <label class="form-label"><?php esc_html_e('Blog Category', 'sublimeplus'); ?></label>
                        <div class="form-group">
                            <div class="flex-check d-inline-block mr-3">
                                <input type="checkbox" class="flex-check-input" id="show_category_list"
                                    name="<?php echo esc_attr($this->getName('show_category_list')); ?>"
                                    <?php checked($this->getValue('show_category_list'), 'on'); ?>>
                                <label class="flex-check-label for="
                                    show_category_list"><?php esc_html_e('Show Category List in Blog', 'sublimeplus'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </fieldset>
    </div>
</div>

<fieldset>
    <legend><label class="form-label"><?php esc_html_e('Subscription Section', 'sublimeplus'); ?></label>
    </legend>
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-2">
                <label class="form-label"><?php esc_html_e('Subscription Section', 'sublimeplus'); ?></label>
                <div class="form-group">
                    <label for="cta_title" class="form-label"><?php esc_html_e('Title', 'sublimeplus'); ?></label>
                    <input type="text" value="<?php echo esc_html($this->getValue('cta_title')); ?>"
                        class="form-control" name="<?php echo esc_attr($this->getName('cta_title')); ?>" />
                </div>
                <div class="form-group mt-3">
                    <label for="cta_content" class="form-label"><?php esc_html_e('Content', 'sublimeplus'); ?></label>
                    <textarea class="form-control" name="<?php echo esc_attr($this->getName('cta_content')); ?>"
                        rows="5"><?php echo esc_html($this->getValue('cta_content')); ?></textarea>
                </div>
            </div>
        </div>
    </div>


</fieldset>

<fieldset>
    <legend><label class="form-label"><?php esc_html_e('Call To Action', 'sublimeplus'); ?></label>
    </legend>
    <div class="row">
    <div class="col-lg-12">
        <div class="mb-2">
            <label for="button_text" class="form-label"><?php esc_html_e('Button Text', 'sublimeplus') ?></label>
            <input type="text" value="<?php echo esc_html($this->getValue('button_text')); ?>" class="form-control"
                name="<?php echo esc_attr($this->getName('button_text')); ?>" />
            <small class="form-text text-muted"><?php esc_html_e('Text on the button.', 'sublimeplus'); ?></small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="mb-2">
            <label for="cancel_info" class="form-label"><?php esc_html_e('Trial Cancel Info', 'sublimeplus') ?></label>
            <input type="text" value="<?php echo esc_html($this->getValue('cancel_info')); ?>" class="form-control"
                name="<?php echo esc_attr($this->getName('cancel_info')); ?>" />
            <small
                class="form-text text-muted"><?php esc_html_e('Small text under the button.', 'sublimeplus'); ?></small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="mb-2">
            <label for="heading" class="form-label"><?php esc_html_e('Heading', 'sublimeplus') ?></label>
            <input type="text" value="<?php echo esc_html($this->getValue('heading')); ?>" class="form-control"
                name="<?php echo esc_attr($this->getName('heading')); ?>" />
            <small class="form-text text-muted"><?php esc_html_e('Main heading text.', 'sublimeplus'); ?></small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="mb-2">
            <label for="description" class="form-label"><?php esc_html_e('Description', 'sublimeplus') ?></label>
            <textarea class="form-control" name="<?php echo esc_attr($this->getName('description')); ?>"
                rows="5"><?php echo esc_html($this->getValue('description')); ?></textarea>
            <small
                class="form-text text-muted"><?php esc_html_e('Description text below the heading.', 'sublimeplus'); ?></small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="mb-2">
            <label class="form-label"><?php esc_html_e('Background Image', 'sublimeplus'); ?></label>
            <div class="form-group">
                <input type="hidden" id="bg_image_id" value="<?php echo esc_attr($this->getValue('bg_image')); ?>"
                    class="form-control" name="<?php echo esc_attr($this->getName('bg_image')); ?>" />
                <input type="hidden" id="bg_image" value="<?php echo esc_url($this->getValue('bg_image_url')); ?>"
                    class="form-control" name="<?php echo esc_attr($this->getName('bg_image_url')); ?>" />
                <div class="d-flex">
                    <button type="button" class="btn btn-primary me-2"
                        id="bg_image_button"><?php esc_html_e('Choose Image', 'sublimeplus'); ?></button>
                    <button type="button" class="btn btn-danger"
                        id="remove_bg_image_button"><?php esc_html_e('Remove Image', 'sublimeplus'); ?></button>
                </div>
                <img id="bg_image_preview" src="<?php echo esc_url($this->getValue('bg_image_url')); ?>"
                    style="max-width: 250px; margin-top: 10px; display: <?php echo $this->getValue('bg_image_url') ? 'block' : 'none'; ?>;"
                    class="img-fluid mt-3" />
                <small
                    class="form-text text-muted"><?php esc_html_e('Choose a background image.', 'sublimeplus'); ?></small>
            </div>
        </div>
    </div>
</div>

    </fieldset>

<!-- New eBook Block Selection -->
<div class="row">
    <div class="col-lg-12">
        <fieldset>
            <legend><label class="form-label"><?php esc_html_e('eBook Block Selection', 'sublimeplus'); ?></label></legend>
            <div class="form-group">
                <label for="ebook_block" class="form-label"><?php esc_html_e('Select eBook Block', 'sublimeplus'); ?></label>
                <select name="<?php echo esc_attr($this->getName('ebook_block')); ?>" id="ebook_block" class="form-control">
                    <option value=""><?php esc_html_e('Select eBook Block', 'sublimeplus'); ?></option>
                    <?php
                    $ebook_blocks = get_posts(array(
                        'post_type' => 'ebook_block',
                        'posts_per_page' => -1
                    ));
                    $selected_ebook_block = $this->getValue('ebook_block');
                    foreach ($ebook_blocks as $ebook_block) {
                        ?>
                        <option value="<?php echo esc_attr($ebook_block->ID); ?>" <?php selected($selected_ebook_block, $ebook_block->ID); ?>>
                            <?php echo esc_html($ebook_block->post_title); ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </fieldset>
    </div>
</div>


<script>
jQuery(document).ready(function($) {
    $('#bg_image_button').on('click', function(e) {
        e.preventDefault();
        var image = wp.media({
                title: '<?php esc_html_e('Upload Image', 'sublimeplus'); ?>',
                multiple: false
            }).open()
            .on('select', function() {
                var uploaded_image = image.state().get('selection').first();
                var image_url = uploaded_image.toJSON().url;
                var image_id = uploaded_image.toJSON().id;
                $('#bg_image').val(image_url);
                $('#bg_image_id').val(image_id);
                $('#bg_image_preview').attr('src', image_url).show();
            });
    });

    $('#remove_bg_image_button').on('click', function(e) {
        e.preventDefault();
        $('#bg_image').val('');
        $('#bg_image_id').val('');
        $('#bg_image_preview').attr('src', '').hide();
    });

    $('#recent_post_categories').on('change', function() {
        var selectedCategories = $(this).val();
        if (selectedCategories.includes('all')) {
            $(this).val([]).trigger('change');
        }
        updateSelectedCategoriesText(selectedCategories);
    });

    function updateSelectedCategoriesText(selectedCategories) {
        if (selectedCategories.includes('all') || selectedCategories.length === 0) {
            $('#selected_categories_text').text('<?php esc_html_e('Show All', 'sublimeplus'); ?>');
        } else {
            var categoryNames = [];
            $('#recent_post_categories option:selected').each(function() {
                categoryNames.push($(this).text());
            });
            $('#selected_categories_text').text(categoryNames.join(', '));
        }
    }

    updateSelectedCategoriesText($('#recent_post_categories').val());
});
</script>


<?php
        $this->renderclose();
    }

    public function getSelectedCategoriesText() {
        $selected_categories = $this->getValue('recent_post_categories') ?: array();
        if (empty($selected_categories)) {
            return esc_html__('Show All', 'sublimeplus');
        } else {
            $category_names = array();
            foreach ($selected_categories as $category_id) {
                $category = get_category($category_id);
                if ($category) {
                    $category_names[] = $category->name;
                }
            }
            return esc_html(implode(', ', $category_names));
        }
    }

    public function renderopen() {
        echo '<div class="tab-pane" id="blog-settings" role="tabpanel" aria-labelledby="blog-settings_">';
        echo '<div class="bd-example bg-light p-3 f-18 border">';
        echo '<caption>' . esc_html($this->getTitle() . ' Options', 'sublimeplus') . '</caption>';
        echo '</div><div class="container my-5">
        <div class="row justify-content-center">
          <div class="col-lg-11">';
    }

    public function renderclose() {
        echo '</div></div></div></div>';
    }

    public function sanitize($inputs) {
        $sanitized_inputs = array();
        if (isset($inputs['blog_title'])) {
            $sanitized_inputs['blog_title'] = sanitize_text_field($inputs['blog_title']);
        }
        if (isset($inputs['blog_description'])) {
            $sanitized_inputs['blog_description'] = sanitize_textarea_field($inputs['blog_description']);
        }
        if (isset($inputs['recent_post_sort_order'])) {
            $sanitized_inputs['recent_post_sort_order'] = sanitize_text_field($inputs['recent_post_sort_order']);
        }
        if (isset($inputs['recent_post_categories'])) {
            $sanitized_inputs['recent_post_categories'] = array_map('absint', $inputs['recent_post_categories']);
        }
        if (isset($inputs['video_analysis_category'])) {
            $sanitized_inputs['video_analysis_category'] = absint($inputs['video_analysis_category']);
        }
        $sanitized_inputs['show_category_list'] = isset($inputs['show_category_list']) ? 'on' : 'off';
        if (isset($inputs['cta_title'])) {
            $sanitized_inputs['cta_title'] = sanitize_text_field($inputs['cta_title']);
        }
        if (isset($inputs['cta_content'])) {
            $sanitized_inputs['cta_content'] = wp_kses_post($inputs['cta_content']);
        }
        if (isset($inputs['button_text'])) {
            $sanitized_inputs['button_text'] = sanitize_text_field($inputs['button_text']);
        }
        if (isset($inputs['cancel_info'])) {
            $sanitized_inputs['cancel_info'] = sanitize_text_field($inputs['cancel_info']);
        }
        if (isset($inputs['heading'])) {
            $sanitized_inputs['heading'] = sanitize_text_field($inputs['heading']);
        }
        if (isset($inputs['description'])) {
            $sanitized_inputs['description'] = wp_kses_post($inputs['description']);
        }
        if (isset($inputs['bg_image'])) {
            $sanitized_inputs['bg_image'] = absint($inputs['bg_image']);
        }
        if (isset($inputs['bg_image_url'])) {
            $sanitized_inputs['bg_image_url'] = sanitize_text_field($inputs['bg_image_url']);
        }

        if (isset($inputs['ebook_block'])) {
            $sanitized_inputs['ebook_block'] = absint($inputs['ebook_block']);
        }

        
        $sanitized_inputs['show_footer_on_blog'] = isset($inputs['show_footer_on_blog']) ? 'on' : 'off';

        return $sanitized_inputs;
    }
}
?>