<?php if (get_theme_mod('kek_site_logo_sticky', '') != '') { ?>
    <div class="sticky-logo">
        <a href="<?php echo esc_url(home_url('/')); ?>" rel="<?php esc_attr_e('home','sublimeplus'); ?>"
           title="<?php bloginfo('name'); ?>"><img
                src="<?php echo esc_url(get_theme_mod('kek_site_logo_sticky')) ?>" alt="<?php bloginfo('name'); ?>"/></a>
    </div>
<?php } ?>