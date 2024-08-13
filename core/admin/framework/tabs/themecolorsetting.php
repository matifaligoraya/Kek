<?php
require_once kek_DIR . 'core/admin/framework/basetab.php'; // If SublimeBaseTab is in the same directory

class ThemeColorSettingTab extends SublimeBaseTab {

    public function getTitle() {
        return __('Theme Color Setting', 'sublimeplus');
    }

    public function renderopen() {
        echo '<div class="tab-pane" id="ThemeColorSetting-settings" role="tabpanel" aria-labelledby="ThemeColorSetting-settings_">';
        echo '<div class="bd-example bg-secondary bg-gradient p-3 f-18 border row">';
        echo '<caption>' . esc_html_e($this->getTitle() . ' Options', 'sublimeplus') . '</caption>';
        echo '</div><div class="bg-secondary-subtle p-3 row">';
    }

    public function renderclsoe() {
        echo ' </div></div>';
    }

    public function render() {
        // Render the form fields specific for ThemeColorSetting Tab
        $this->renderopen();
        ?>
        
        <!-- Main Color Setting -->
        <div class="mb-3 col-3">
            <label for="main_color" class="form-label"><?php esc_html_e('Main Color', 'sublimeplus') ?></label>
            <input type="text" id="main_color" class="kek-color-field form-control"
             name="<?php echo esc_attr($this->getName('main_color')) ?>" 
             value="<?php echo esc_attr($this->getValue('main_color', '#1db954')); ?>">            
            <div id="mainColorHelp" class="form-text"><?php esc_html_e('Choose the main color for your theme.', 'sublimeplus') ?></div>
        </div>

        <!-- Heading Text Color Setting -->
        <div class="mb-3 col-3">
            <label for="heading_color" class="form-label"><?php esc_html_e('Heading Text Color', 'sublimeplus') ?></label>
            <input type="text" id="heading_color" class="kek-color-field form-control"
             name="<?php echo esc_attr($this->getName('heading_color')) ?>" 
             value="<?php echo esc_attr($this->getValue('heading_color', '#212529')); ?>">            
            <div id="headingColorHelp" class="form-text"><?php esc_html_e('Choose the text color for headings.', 'sublimeplus') ?></div>
        </div>

        <!-- Body Text Color Setting -->
        <div class="mb-3 col-3">
            <label for="body_text_color" class="form-label"><?php esc_html_e('Body Text Color', 'sublimeplus') ?></label>
            <input type="text" id="body_text_color" class="kek-color-field form-control"
             name="<?php echo esc_attr($this->getName('body_text_color')) ?>" 
             value="<?php echo esc_attr($this->getValue('body_text_color', '#495057')); ?>">            
            <div id="bodyTextColorHelp" class="form-text"><?php esc_html_e('Choose the text color for body content.', 'sublimeplus') ?></div>
        </div>

        <!-- Button Background Color Setting -->
        <div class="mb-3 col-3">
            <label for="button_bg_color" class="form-label"><?php esc_html_e('Button Background Color', 'sublimeplus') ?></label>
            <input type="text" id="button_bg_color" class="kek-color-field form-control"
             name="<?php echo esc_attr($this->getName('button_bg_color')) ?>" 
             value="<?php echo esc_attr($this->getValue('button_bg_color', '#0d6efd')); ?>">            
            <div id="buttonBgColorHelp" class="form-text"><?php esc_html_e('Choose the background color for buttons.', 'sublimeplus') ?></div>
        </div>

        <!-- Button Text Color Setting -->
        <div class="mb-3 col-3">
            <label for="button_text_color" class="form-label"><?php esc_html_e('Button Text Color', 'sublimeplus') ?></label>
            <input type="text" id="button_text_color" class="kek-color-field form-control"
             name="<?php echo esc_attr($this->getName('button_text_color')) ?>" 
             value="<?php echo esc_attr($this->getValue('button_text_color', '#ffffff')); ?>">            
            <div id="buttonTextColorHelp" class="form-text"><?php esc_html_e('Choose the text color for buttons.', 'sublimeplus') ?></div>
        </div>

       
<!-- Link Color Setting -->
<div class="mb-3 col-3">
    <label for="link_color" class="form-label"><?php esc_html_e('Link Color', 'sublimeplus') ?></label>
    <input type="text" id="link_color" class="kek-color-field form-control"
        name="<?php echo esc_attr($this->getName('link_color')) ?>" 
        value="<?php echo esc_attr($this->getValue('link_color', '#0d6efd')); ?>">            
    <div id="linkColorHelp" class="form-text"><?php esc_html_e('Choose the color for links.', 'sublimeplus') ?></div>
</div>

<!-- Link Hover Color Setting -->
<div class="mb-3 col-3">
    <label for="link_hover_color" class="form-label"><?php esc_html_e('Link Hover Color', 'sublimeplus') ?></label>
    <input type="text" id="link_hover_color" class="kek-color-field form-control"
        name="<?php echo esc_attr($this->getName('link_hover_color')) ?>" 
        value="<?php echo esc_attr($this->getValue('link_hover_color', '#0a58ca')); ?>">            
    <div id="linkHoverColorHelp" class="form-text"><?php esc_html_e('Choose the color for links when hovered.', 'sublimeplus') ?></div>
</div>

        <?php
        // End render
        $this->renderclsoe();
    }

    public function sanitize($inputs) {
        // Sanitize inputs for ThemeColorSetting Tab
        $sanitizedInputs = [];
    
        if (isset($inputs['main_color'])) {
            $sanitizedInputs['main_color'] = sanitize_hex_color($inputs['main_color']);
        }

        if (isset($inputs['heading_color'])) {
            $sanitizedInputs['heading_color'] = sanitize_hex_color($inputs['heading_color']);
        }

        if (isset($inputs['body_text_color'])) {
            $sanitizedInputs['body_text_color'] = sanitize_hex_color($inputs['body_text_color']);
        }

        if (isset($inputs['button_bg_color'])) {
            $sanitizedInputs['button_bg_color'] = sanitize_hex_color($inputs['button_bg_color']);
        }

        if (isset($inputs['button_text_color'])) {
            $sanitizedInputs['button_text_color'] = sanitize_hex_color($inputs['button_text_color']);
        }
    
        if (isset($inputs['link_color'])) {
            $sanitizedInputs['link_color'] = sanitize_hex_color($inputs['link_color']);
        }
        
        if (isset($inputs['link_hover_color'])) {
            $sanitizedInputs['link_hover_color'] = sanitize_hex_color($inputs['link_hover_color']);
        }
        
       
        return $sanitizedInputs;
    }    
}
