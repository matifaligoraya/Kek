<?php
/**
 * The pagination for content post, page
 * Used for both single and page. Page Break / <!--nextpage-->
 *
 * @package     KeK
 * @version     1.0.0
 * @author      KeK
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2020 KeK
 
 */

wp_link_pages( array(
    'before'      => '<div class="wrap-pagination inpost-pagination"><div class="pagination clearfix"> ',
    'after'       => '</div></div>',
    'link_before' => '<span>',
    'link_after'  => '</span>',
    'pagelink'    => '%',
    'separator'   => '',
) );
