<?php
/** Logo
 *
 * @package     KeK
 * @version     1.0.0
 * @author      KeK
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2019 KeK
 */

if (get_theme_mod('custom_logo')) { ?>    
        <a href="<?php echo esc_url(home_url('/')); ?>"
           rel="<?php esc_attr_e('home', 'sublimeplus'); ?>"
           title="<?php bloginfo('name'); ?>" class="footer-logo">
            <img src="<?php echo wp_get_attachment_image_url(get_theme_mod('custom_logo'),'full')?>"
                width="414"
                height="80"
                class="entered lazyloaded"
                alt="<?php bloginfo('name'); ?>"/>
        </a>
    <?php
}

