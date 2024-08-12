<?php
/**
 * Layout Functionality
 *
 * @package KeK\Core\Common\Functions
 * @author   KeK
 * @link     https://bitandbytelab.com/
 *
 */

/**
 * Get registered sidebar id=>name
 *
 * @return  array
 */
function kek_get_registered_sidebars()
{
    global $wp_registered_sidebars;

    $sidebar_options = [];

    foreach ($wp_registered_sidebars as $sidebar) {
        $sidebar_options[$sidebar['id']] = $sidebar['name'];
    }

    return $sidebar_options;
}