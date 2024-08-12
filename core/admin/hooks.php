<?php
/**
 * Admin Hooks
 *
 * Hooks used on admin screens only.
 *
 * @package KeK\Core\Admin
 * @author   KeK
 * @link     https://bitandbytelab.com/
 *
 */

/**
 * @see  https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
 */
add_action('admin_enqueue_scripts', function($hook_suffix)
{
    if (isset($_GET['page']) && 'theme-settings' === $_GET['page']) {
        wp_add_inline_style('dashicons', '#wpcontent{padding-left:0 !important}');
    }

    if (isset($_GET['page']) && 'theme-setup-demo' === $_GET['page']) {
        wp_add_inline_style('dashicons', '#wpcontent #wpbody #wpbody-content .notice{display:none !important}');
    }

    wp_enqueue_media();
    wp_enqueue_style('bootstrap', kek_URI.'assets/bootstrap/css/bootstrap.css', array('dashicons'), kek_VERSION);
    wp_enqueue_script('bootstrap-js', kek_URI.'assets/bootstrap/js/bootstrap.bundle.min.js', array('jquery-core'), kek_VERSION);
    wp_enqueue_script('jquery-core');
    wp_enqueue_script('jquery-migrate-js');
    //wp_enqueue_style('bootstrap');
    wp_enqueue_style('theme-admin', kek_URI.'core/assets/css/admin.min.css', array('dashicons'), kek_VERSION);
//
   // wp_enqueue_script('theme-admin', kek_URI.'core/assets/js/admin.min.js', array('jquery'), kek_VERSION, true);
    wp_localize_script('theme-admin', 'zooAdminL10n', [
        'install' => esc_html__('Install', 'sublimeplus'),
        'installing' => esc_html__('Installing...', 'sublimeplus'),
        'installed' => esc_html__('Installed', 'sublimeplus'),
        'uninstall' => esc_html__('Uninstall', 'sublimeplus'),
        'uninstalling' => esc_html__('Uninstalling...', 'sublimeplus')
    ]);
});
