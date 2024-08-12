<?php
/**
 * kek_Welcome_Page
 *
 * @package KeK\Core\Admin\Classes
 * @author   KeK
 * @link     https://bitandbytelab.com/
 *
 */
final class kek_Welcome_Page
{
    /**
     * Slug
     */
    const SLUG = 'theme-welcome';

    /**
     * Option group
     *
     * @var  string
     */
    const GROUP = 'kek_welcome_group';

    /**
     * Theme object
     */
    protected $theme;

    /**
     * Hook suffix
     */
    public $hook_suffix;

    /**
     * Settings
     *
     * @var  array
     */
    protected $settings;

    /**
     * Constructor
     */
    private function __construct()
    {
        $this->theme = kek_get_parent_theme_object();
        $this->settings = (array)get_option(kek_SETTINGS_KEY) ? : array();
    }

    /**
     * Singleton
     */
    static function getInstance()
    {
        static $instance = null;

        if (null === $instance) {
            $instance = new self;
            add_action('admin_menu', array($instance, '_add'));
        }
    }

    /**
     * Add to admin menu
     */
    function _add($context = '')
    {
        echo $this->theme->name;
        $label = !empty($this->theme->name) ? $this->theme->name : esc_html__('Welcome', 'sublimeplus');
        $this->hook_suffix = kek_add_menu_page(
            $label,
            $label,
            'manage_options',
            self::SLUG,
            array($this, '_render'),
            get_template_directory_uri() . '/assets/images/theme-settings-menu-icon.png',
            3
        );
    }

    /**
     * Render
     */
    function _render()
    {
        global $wpdb;

        wp_enqueue_script('dashboard');

       

        if (defined('WP_DEBUG') && WP_DEBUG) {
            $wp_debug_mode = 'true';
        } else {
            $wp_debug_mode = 'false';
        }

        $active_plugin_slugs = get_option('active_plugins');

        $active_plugins = array();

        foreach ($active_plugin_slugs as $slug) {
            $plugin = get_plugin_data(WP_PLUGIN_DIR . '/' . $slug);
            $active_plugins[] = $plugin['Name'] . ' v' . $plugin['Version'];
        }

        $multisize = is_multisite() ? 'true' : 'false';

        ?><div class="theme-welcome">
    <div id="welcome-panel" class="sublimeplus-welcome-panel">
      <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="welcome-heading">
                        <h1><?php printf(esc_html__( 'Welcome to %s', 'sublimeplus' ), $this->theme->name); ?></h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9 pt-5">


                    <p><?php printf( 'Thank you for choosing <b>%s</b>! Get ready to build something beautiful. Please register your purchase to get automatic theme updates, import sample data and install premium plugins. Check out theme documentation and our support center to learn how to receive product support and how to make awesome things with this theme. We hope you enjoy it!',  $this->theme->name); ?>
                    </p>
                </div>

                <div class="col-lg-3 text-center">
                    <div class="welcome-theme-logo">
                        <img src="<?php echo esc_url(kek_LOGO) ?>" alt="<?php bloginfo('name'); ?>" width="120"
                            height="auto">
                        <p><strong><?php echo esc_html($this->theme->name) . ' &nbsp;<span>v' . esc_html($this->theme->version) ?></span></strong>
                        </p>
                    </div>
                </div>
            </div>


       
    <div class="dashboard-widgets-wrap">
        <div id="dashboard-widgets" class="metabox-holder">
            <table class="system-status widefat" cellspacing="0">
                <thead>
                    <tr>
                        <th colspan="3"><?php esc_html_e('System Status', 'sublimeplus') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-export-label="MySQL Version">MySQL version:</td>
                        <td><?php echo esc_html($wpdb->db_version()) ?></td>
                    </tr>
                    <tr>
                        <td>PHP version:</td>
                        <td><?php echo phpversion() ?></td>
                    </tr>
                    <tr>
                        <td>PHP post max size:</td>
                        <td><?php echo ini_get('post_max_size') ?></td>
                    </tr>
                    <tr>
                        <td>PHP max execution time:</td>
                        <td><?php echo ini_get('max_execution_time') ?></td>
                    </tr>
                    <tr>
                        <td>PHP max input vars:</td>
                        <td><?php echo ini_get('max_input_vars') ?></td>
                    </tr>
                    <tr>
                        <td>PHP max upload size:</td>
                        <td><?php echo ini_get('upload_max_filesize') ?></td>
                    </tr>
                    <tr>
                        <td>WordPress version:</td>
                        <td><?php echo esc_html($GLOBALS['wp_version']) ?></td>
                    </tr>
                    <tr>
                        <td>WordPress multisite:</td>
                        <td><?php echo esc_html($multisize) ?></td>
                    </tr>
                    <tr>
                        <td>WordPress debug mode:</td>
                        <td><?php echo esc_html($wp_debug_mode) ?></td>
                    </tr>
                    <tr>
                        <td>WordPress active plugins:</td>
                        <td><?php echo implode(', ', $active_plugins) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<?php
    }
}
kek_Welcome_Page::getInstance();