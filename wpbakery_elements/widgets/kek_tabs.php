<?php
class WPBakeryKekBottomTabsElement {
    public function __construct() {
        add_action('vc_before_init', array($this, 'register_elements'), 40);
        add_shortcode('kek_bottom_tabs', array($this, 'render_kek_bottom_tabs'), 40);
    }

    public function register_elements() {
        // Register the Tabs Element
        vc_map(array(
            'name' => __('Kek Bottom Tabs', 'kek'),
            'base' => 'kek_bottom_tabs',
            'category' => __('Kek Essentials', 'kek'),
            'params' => array(
                array(
                    'type' => 'param_group',
                    'heading' => __('Tabs', 'kek'),
                    'param_name' => 'tabs',
                    'description' => __('Add tabs with icons, titles, and content.', 'kek'),
                    'params' => array(
                        array(
                            'type' => 'iconpicker',
                            'heading' => __('Icon', 'kek'),
                            'param_name' => 'icon',
                            'description' => __('Select an icon for this tab.', 'kek'),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Tab Title', 'kek'),
                            'param_name' => 'title',
                            'description' => __('Enter the title for this tab.', 'kek'),
                        ),
                        array(
                            'type' => 'textarea',
                            'heading' => __('Tab Content', 'kek'),
                            'param_name' => 'content',
                            'description' => __('Enter the content for this tab. HTML tags are allowed.', 'kek'),
                        ),
                    ),
                ),
            ),
        ));
    }

    public function render_kek_bottom_tabs($atts) {
        $atts = shortcode_atts(array(
            'tabs' => '',
        ), $atts);

        // Decode and prepare tabs
        $tabs = vc_param_group_parse_atts($atts['tabs']);
        if (empty($tabs)) {
            return '<p>' . __('No tabs found. Please add tabs in the settings.', 'kek') . '</p>';
        }

        ob_start();
        ?>
        <div class="content-tabs">
            <div class="tab-content">
                <?php foreach ($tabs as $index => $tab): ?>
                    <?php 
                    $content = isset($tab['content']) ? $tab['content'] : '';
                    $title = isset($tab['title']) ? esc_html($tab['title']) : __('Tab ' . ($index + 1), 'kek');
                    $icon = isset($tab['icon']) ? $tab['icon'] : '';
                    ?>
                    <div id="tab-<?php echo $index; ?>" 
                         class="tab-pane fade <?php echo $index === 0 ? 'in active' : ''; ?>">
                        <h3><i class="<?php echo esc_attr($icon); ?>"></i> <?php echo $title; ?></h3>
                        <hr>
                        <div><?php echo $content; // Content allows HTML ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <ul class="tabs">
                <?php foreach ($tabs as $index => $tab): ?>
                    <?php 
                    $title = isset($tab['title']) ? esc_html($tab['title']) : __('Tab ' . ($index + 1), 'kek');
                    $icon = isset($tab['icon']) ? $tab['icon'] : '';
                    ?>
                    <li class="<?php echo $index === 0 ? 'active' : ''; ?>">
                        <a data-toggle="tab" href="#tab-<?php echo $index; ?>">
                            <i class="<?php echo esc_attr($icon); ?>"></i>
                            <span><?php echo $title; ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Instantiate the class
new WPBakeryKekBottomTabsElement();
