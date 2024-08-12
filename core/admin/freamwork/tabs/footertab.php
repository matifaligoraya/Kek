<?php
require_once kek_DIR . 'core/admin/freamwork/basetab.php'; // If SublimeBaseTab is in the same directory
class SublimeFooterTab extends SublimeBaseTab {

    public function getTitle() {
        return __('Footer', 'sublimeplus');
    }
    
    public function renderopen() {
        echo '<div class="tab-pane" id="footer-settings" role="tabpanel" aria-labelledby="footer-settings_">';
        echo '<div class="bd-example bg-light p-3 f-18 border">';
        echo '<caption>' . esc_html($this->getTitle() . ' Options', 'sublimeplus') . '</caption>';
        echo '</div><div class="highlight pan">';
    }
    
    public function renderclsoe() {
        echo '</div></div>';
    }
    
    public function render() {
        // Render the form fields specific for footer Tab
        $this->renderopen();
        $footer_layouts = $this->get_custom_post_type_sp_footer_builder(); // Fetch the footer layout choices
        ?>
        <div class="mb-3">
            <label for="footer_layout" class="form-label"><?php esc_html_e('Select Footer', 'sublimeplus') ?></label>
            <select name="<?php echo esc_attr($this->getName('footer_layout')); ?>" id="footer_layout" class="form-control">
                <option value=""><?php esc_html_e('Select a footer', 'sublimeplus'); ?></option>
                <?php foreach ($footer_layouts as $id => $title) : ?>
                    <option value="<?php echo esc_attr($id); ?>"
                        <?php selected($this->getValue('footer_layout'), $id); ?>>
                        <?php echo esc_html($title); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <small class="form-text text-muted"><?php esc_html_e('Choose a footer for all site here.', 'sublimeplus'); ?></small>
        </div>
        
        <div class="mb-3">
            <label for="footer_copyrights" class="form-label"><?php esc_html_e('Copyrights', 'sublimeplus') ?></label>
            <input type="text" value="<?php echo esc_html($this->getValue('footer_copyrights')); ?>" class="form-control" name="<?php echo esc_attr($this->getName('footer_copyrights')) ?>" />
            <small class="form-text text-muted"><?php esc_html_e('i.e. ABC Company. All Rights Reserved ', 'sublimeplus'); ?></small>
        </div>
        
        <div class="mb-3">
            <label for="footer_disclaimer" class="form-label"><?php esc_html_e('Disclaimer', 'sublimeplus') ?></label>
            <textarea class="form-control" name="<?php echo esc_attr($this->getName('footer_disclaimer')); ?>" rows="4"><?php echo esc_html($this->getValue('footer_disclaimer')); ?></textarea>
            <small class="form-text text-muted"><?php esc_html_e('Add your footer disclaimer text here. If empty then will not be shown.', 'sublimeplus'); ?></small>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="<?php echo esc_attr($this->getName('show_social_in_footer')); ?>" id="show_social_in_footer" <?php checked($this->getValue('show_social_in_footer'), 'on'); ?>>
            <label class="form-check-label" for="show_social_in_footer"><?php esc_html_e('Show social media links in footer', 'sublimeplus'); ?></label>
        </div>
        <?php
        $this->renderclsoe();
    }
    
    function get_custom_post_type_sp_footer_builder() {
        $args = array(
            'post_type'      => 'sp_footer_builder', // Ensure this matches your registered post type
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC'
        );
        
        $posts = get_posts($args);
        $choices = array();
        if ($posts) {
            foreach ($posts as $post) {
                $choices[$post->ID] = $post->post_title;
            }
        }
        return $choices;
    }
    
    public function sanitize($inputs) {
        // Sanitize inputs for footer Tab
        $sanitizedInputs = array();
        if (isset($inputs['footer_layout'])) {
            $sanitizedInputs['footer_layout'] = sanitize_text_field($inputs['footer_layout']);
        }
        if (isset($inputs['footer_copyrights'])) {
            $sanitizedInputs['footer_copyrights'] = sanitize_text_field($inputs['footer_copyrights']);
        }
        if (isset($inputs['footer_disclaimer'])) {
            $sanitizedInputs['footer_disclaimer'] = sanitize_textarea_field($inputs['footer_disclaimer']);
        }
        $sanitized_inputs['show_social_in_footer'] = isset($inputs['show_social_in_footer']) ? 'on' : 'off';
        return $sanitizedInputs;
    }
}
