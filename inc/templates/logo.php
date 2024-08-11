<?php
/** Logo
 *
 * @package     Kek
 * @version     1.0.0
 * @author      Kek
 * @link        https://bitandbytelab.com/
 * @copyright   Copyright (c) 2024 Kek
 */

if (get_theme_mod('custom_logo')) { ?>
        <a href="<?php echo esc_url(home_url('/')); ?>"
            rel="<?php esc_attr_e('home', 'kek'); ?>"
            title="<?php bloginfo('name'); ?>" class="header-logo">
            <img 
                class="logo-default"
                src="<?php echo wp_get_attachment_image_url(get_theme_mod('custom_logo'),'full')?>" 
                alt="<?php bloginfo('name'); ?>"/>
        </a>
    <?php
}