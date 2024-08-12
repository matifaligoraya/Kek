<?php
/**
 * kek_Customize_Page
 *
 * @package KeK\Core\Admin\Classes
 * @author   KeK
 * @link     https://bitandbytelab.com/
 *
 */
final class kek_Customize_Page
{
    /**
     * Nope constructor
     */
    private function __construct()
    {

    }

    /**
     * Singleton
     */
    static function getInstance()
    {
        static $instance = null;

        if (null === $instance) {
            $instance = new self;
            add_action('admin_menu', [$instance, '_add'], 12);
        }
    }

    /**
     * Add to admin menu
     */
    function _add($context = '')
    {
		kek_add_submenu_page(
			kek_Welcome_Page::SLUG,
			esc_html__('Theme Customize', 'sublimeplus'),
			esc_html__('Theme Customize', 'sublimeplus'),
			'manage_options',
			admin_url('customize.php')
		);
    }
}
kek_Customize_Page::getInstance();
