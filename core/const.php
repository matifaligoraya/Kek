<?php
/**
 * Core Constants
 *
 * @package KeK\Core
 * @author   KeK
 * @link     https://bitandbytelab.com/
 *
 */

/**
 * Childtheme slug
 *
 * @var  string
 */
define('kek_CHILD_THEME_SLUG', get_option('stylesheet', 'KeK-child'));

/**
 * Theme settings key
 *
 * Key to store settings other than theme mods.
 *
 * @var  string
 */
define('kek_SETTINGS_KEY', 'kek_settings_for_' . get_option('template', 'sublimeplus'));

/**
 * Theme version
 *
 * @var  string
 */
define('kek_VERSION', wp_get_theme()->version);
define('MFN_THEME_VERSION', wp_get_theme()->version);
/**
 * Theme base path
 *
 * @var  string
 */
define('kek_DIR', wp_normalize_path(get_template_directory() . '/'));


/**
 * Theme base uri
 *
 * @see  https://google.github.io/styleguide/htmlcssguide.xml?showone=Protocol#Protocol
 *
 * @var  string
 */
define('kek_URI',  get_template_directory_uri() . '/');

/**
 * CSS file suffix
 *
 * @var  string
 */
define('kek_CSS_SUFFIX', (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '.css' : '.min.css');

/**
 * JS file suffix
 *
 * @var  string
 */
define('kek_JS_SUFFIX', (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '.js' : '.min.js');


/**
 * Theme Logo
 */
if (file_exists(kek_DIR.'assets/images/logo.png')) {
    define('kek_LOGO', kek_URI.'assets/images/logo.png');
} else {
    define('kek_LOGO', admin_url('images/wordpress-logo.svg'));
}