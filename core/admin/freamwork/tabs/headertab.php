<?php
require_once kek_DIR . 'core/admin/freamwork/basetab.php';

class SublimeHeaderTab extends SublimeBaseTab {
    
    public function getTitle() {
        return __('Header', 'sublimeplus');
    }

    public function renderopen() {
        echo '<div class="tab-pane" id="header-settings" role="tabpanel" aria-labelledby="header-settings_">';
        echo '<div class="bd-example bg-light p-3 f-18 border">';
        echo '<caption>'. esc_html($this->getTitle(). ' Options', 'sublimeplus') . '</caption>';
        echo '</div><div class="highlight pan">' ;
    }

    public function renderclose() {
        echo ' </div></div>';
    }

    public function render() {
        // Render the form fields specific for Header Tab
        $this->renderopen();
        ?>

        <?php $enable_login_popup_in_menu = intval($this->getValue('enable_login_popup_in_menu')) ?>
        <div class="mb-3">
            <label class="form-label"><?php esc_html_e('Enable Login PopUp In header', 'sublimeplus') ?></label>
            <input type="checkbox" class="" name="<?php echo esc_attr($this->getName('enable_login_popup_in_menu')) ?>"
                value="1" <?php if ($enable_login_popup_in_menu) echo ' checked'; ?>>
            <small class="form-text"><?php esc_html_e('Whether to enable PopUp for login in header.', 'sublimeplus'); ?></small>
        </div>

        <?php $html_of_login_popup_in_menu = $this->getValue('html_of_login_popup_in_menu'); ?>
        <div class="mb-3">
            <label class="form-label"><?php esc_html_e('HTML for Login Popup', 'sublimeplus'); ?></label>
            <textarea class="form-control" name="<?php echo esc_attr($this->getName('html_of_login_popup_in_menu')) ?>"
                rows="4"><?php echo esc_html($html_of_login_popup_in_menu); ?></textarea>
            <small class="form-text"><?php esc_html_e('Any HTML in it will be considered as content of popup model.', 'sublimeplus'); ?></small>
        </div>

        <?php $show_trial_button_in_menu = intval($this->getValue('show_trial_button_in_menu')) ?>
        <div class="mb-3">
            <label class="form-label"><?php esc_html_e('Show Trial Button in Header', 'sublimeplus') ?></label>
            <input type="checkbox" class="" name="<?php echo esc_attr($this->getName('show_trial_button_in_menu')) ?>"
                value="1" <?php if ($show_trial_button_in_menu) echo ' checked'; ?>>
            <small class="form-text"><?php esc_html_e('Show trial button in header.', 'sublimeplus'); ?></small>
        </div>

        <?php $trial_button_text = $this->getValue('trial_button_text'); ?>
        <div class="mb-3">
            <label class="form-label"><?php esc_html_e('Trial Button Text', 'sublimeplus'); ?></label>
            <input type="text" class="form-control" name="<?php echo esc_attr($this->getName('trial_button_text')) ?>"
                value="<?php echo esc_attr($trial_button_text); ?>">
            <small class="form-text"><?php esc_html_e('Please provide button text.', 'sublimeplus'); ?></small>
        </div>

        <?php $trial_button_url = $this->getValue('trial_button_url'); ?>
        <div class="mb-3">
            <label class="form-label"><?php esc_html_e('Trial Button URL', 'sublimeplus'); ?></label>
            <input type="text" class="form-control" name="<?php echo esc_attr($this->getName('trial_button_url')) ?>"
                value="<?php echo esc_attr($trial_button_url); ?>">
            <small class="form-text"><?php esc_html_e('Please provide button URL.', 'sublimeplus'); ?></small>
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="<?php echo esc_attr($this->getName('show_social_in_header')); ?>" id="show_social_in_header" <?php checked($this->getValue('show_social_in_header'), 'on'); ?>>
            <label class="form-check-label" for="show_social_in_header"><?php esc_html_e('Show social media links in header', 'sublimeplus'); ?></label>
        </div>
        <?php
        $this->renderclose();
    }

    public function sanitize($inputs) {
        // Sanitize inputs for Header Tab
        $sanitizedInputs = [];

        if (isset($inputs['enable_login_popup_in_menu'])) {
            $sanitizedInputs['enable_login_popup_in_menu'] = intval($inputs['enable_login_popup_in_menu']);
        }

        if (isset($inputs['html_of_login_popup_in_menu'])) {
            $sanitizedInputs['html_of_login_popup_in_menu'] = wp_kses_post($inputs['html_of_login_popup_in_menu']);
        }

        if (isset($inputs['show_trial_button_in_menu'])) {
            $sanitizedInputs['show_trial_button_in_menu'] = intval($inputs['show_trial_button_in_menu']);
        }

        if (isset($inputs['trial_button_text'])) {
            $sanitizedInputs['trial_button_text'] = sanitize_text_field($inputs['trial_button_text']);
        }

        if (isset($inputs['trial_button_url'])) {
            $sanitizedInputs['trial_button_url'] = esc_url_raw($inputs['trial_button_url']);
        }

        $sanitizedInputs['show_social_in_header'] = isset($inputs['show_social_in_header']) ? 'on' : 'off';

        return $sanitizedInputs;
    }
}
?>
