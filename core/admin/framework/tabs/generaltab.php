<?php
require_once kek_DIR . 'core/admin/framework/basetab.php'; // If SublimeBaseTab is in the same directory

class GeneralTab extends SublimeBaseTab {

    public function getTitle() {
        return __('General', 'sublimeplus');
    }

    public function renderopen() {
        echo '<div class="tab-pane active show" id="general-settings" role="tabpanel" aria-labelledby="general-settings_">';
        echo '<div class="bd-example bg-secondary bg-gradient p-3 f-18 border">';
        echo '<caption>' . esc_html_e($this->getTitle() . ' Options', 'sublimeplus') . '</caption>';
        echo '</div><div class="bg-secondary-subtle p-3">';
    }

    public function renderclsoe() {
        echo ' </div></div>';
    }

    public function render() {
        // Render the form fields specific for General Tab
        $this->renderopen();
        ?>
        
        <!-- Mega Menu Option -->
        <div class="mb-3">
            <?php $enable_mega_menu = intval($this->getValue('enable_builtin_mega_menu')) ?>
            <label for="enable_builtin_mega_menu" class="form-label"><?php esc_html_e('Enable Built-in Mega Menu Editor', 'sublimeplus') ?></label>
            <div class="form-check">
                <input type="checkbox" class="" id="enable_builtin_mega_menu" name="<?php echo esc_attr($this->getName('enable_builtin_mega_menu')) ?>" value="1" <?php if ($enable_mega_menu) echo ' checked'; ?>>
                <label class="form-check-label" for="enable_builtin_mega_menu">
                    <?php esc_html_e('Whether to enable built-in mega menu or not.', 'sublimeplus'); ?>
                </label>
            </div>
        </div>
        
        <!-- Color Setting -->
        <div class="mb-3">
            <label for="main_color" class="form-label"><?php esc_html_e('Main Color', 'sublimeplus') ?></label>
            <input type="text" id="main_color" class="kek-color-field form-control" name="<?php echo esc_attr($this->getName('main_color')) ?>" value="<?php echo esc_attr($this->getValue('main_color', '#1db954')); ?>">            
            <div id="mainColorHelp" class="form-text"><?php esc_html_e('Choose the main color for your theme.', 'sublimeplus') ?></div>
        </div>

        <!-- Header Scripts -->
        <div class="mb-3">
            <label for="header_scripts" class="form-label"><?php esc_html_e('Header scripts', 'sublimeplus') ?></label>
            <textarea class="form-control" id="header_scripts" name="<?php echo esc_attr($this->getName('header_scripts')) ?>" rows="6"><?php echo wp_unslash($this->getValue('header_scripts')) ?></textarea>
            <div id="headerScriptsHelp" class="form-text">
                <?php esc_html_e('Here come custom scripts inserted inside HEAD tag.', 'sublimeplus') ?>
            </div>
        </div>

        <!-- Footer Scripts -->
        <div class="mb-3">
            <label for="footer_scripts" class="form-label"><?php esc_html_e('Footer scripts', 'sublimeplus') ?></label>
            <textarea class="form-control" id="footer_scripts" name="<?php echo esc_attr($this->getName('footer_scripts')) ?>" rows="6"><?php echo wp_unslash($this->getValue('footer_scripts')) ?></textarea>
            <div id="footerScriptsHelp" class="form-text">
                <?php esc_html_e('Here comes your Google Analytics code or any other JS code you want to be loaded in the footer of your website.', 'sublimeplus') ?>
            </div>
        </div>

        <?php
        // End render
        $this->renderclsoe();
    }

    public function sanitize($inputs) {
        // Sanitize inputs for General Tab
        $sanitizedInputs = [];
    
        if (isset($inputs['main_color'])) {
            $sanitizedInputs['main_color'] = sanitize_hex_color($inputs['main_color']);
        }
    
        if (isset($inputs['enable_builtin_mega_menu'])) {
            $sanitizedInputs['enable_builtin_mega_menu'] = (bool) intval($inputs['enable_builtin_mega_menu']);
        }
    
        // Sanitize other General tab settings here
        $sanitizedInputs['header_scripts'] = isset($inputs['header_scripts']) ? wp_kses_post($inputs['header_scripts']) : '';
        $sanitizedInputs['footer_scripts'] = isset($inputs['footer_scripts']) ? wp_kses_post($inputs['footer_scripts']) : '';
    
        return $sanitizedInputs;
    }    
}