<?php
/**
 * The template used for displaying page content
 *
 * @package     KeK
 * @version     1.0.0
 * @author      KeK
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2017 KeK
 
 */
if (get_post_meta(get_the_id(), 'kek_disable_title', true) != 'on') {
    ?>
    <h1 class="page-title the-title"><?php the_title(); ?>32132</h1>
    <?php
}?>
    <div class="page-content">
        <?php the_content(); ?>
    </div>
    <div class="clear-fix"></div>
<?php
//do not remove
get_template_part('inc/templates/pagination', 'detail');
edit_post_link(esc_html__('Edit', 'sublimeplus'), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>');