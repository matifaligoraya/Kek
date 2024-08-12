<?php
/**
 * Breadcrumb functionality
 *
 * @package    Lib\Functions
 */

/**
* kek_breadcrumbs
*/
if (!function_exists('kek_breadcrumbs'))
{
    function kek_breadcrumbs($home_title = '', $home_icon = '', $sep = '')
    {
        $breadcrumb = new kek_Breadcrumb($home_title, $home_icon, $sep);

        $breadcrumb->render($GLOBALS['wp_query']);
    }
}
