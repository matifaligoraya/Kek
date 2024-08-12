<?php
/**
 * Theme functions and definitions
 *
 * @package     KeK
 * @version     1.0.0
 * @author      KeK
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2020 KeK
 
 */

/**
 * Theme functions
 * All theme functions will load below.
 */
include kek_DIR.'inc/functions/helper.php';
include kek_DIR.'inc/functions/features.php';
include kek_DIR.'inc/functions/sidebars.php';
include kek_DIR.'inc/functions/scripts.php';
include kek_DIR.'inc/functions/plugins.php';
include kek_DIR.'inc/functions/functions.php';
include kek_DIR.'inc/functions/hooks.php';
/**
 * WooCommerce theme functions
 * All hooks, functions, features will load below.
 */
// if (class_exists('WooCommerce', false)) {
//     //require kek_DIR.'inc/woocommerce/woocommerce.php';
// }

/**
 * Theme customize and metaboxes
 */
require kek_DIR.'inc/metaboxes/meta-boxes.php';
require kek_DIR.'inc/customize/customize-style.php';
require kek_DIR.'inc/customize/customize-options.php';
