<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package     KeK
 * @version     1.0.0
 * @author      KeK
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2020 KeK
 */

get_header();
/**
 * Zoo Before Main Content
 *
 * @hooked kek_breadcrumb - 10
 * @hooked kek_blog_cover - 20
 */
do_action('kek_before_main_content');

 $show_subheader = get_post_meta(get_the_ID(), '_sublime_page_show_subheader', true);
if ('on' === $show_subheader) {
    $subheader_title = get_post_meta(get_the_ID(), '_sublime_page_subheader_title', true);
  //  print_r( $subheader_title);
    $subheader_title = $subheader_title == ""? the_title() :  $subheader_title;
    $subheader_subtitle = get_post_meta(get_the_ID(), '_sublime_page_subheader_subtitle', true);
    
    $subheader_image = get_post_meta(get_the_ID(), '_sublime_page_subheader_image', true);
    $subheader_image = $subheader_image == ""? the_title() :  $subheader_image;
    // Render the subheader if checkbox is checked
    ?>


<article class="banner banner--big banner--education">
    <div class="container container--big">
        <div class="row">
            <div class="col-lg-8 text-left">
            <h1><?php echo $subheader_title ?>1213</h1>
                <p><?php echo $subheader_subtitle ?> </p>
            </div>
        </div>
    </div>
    <div class="banner-back">
        <div class="container container--big">
            <!-- <a href="education.php"><i class="fas fa-arrow-left"></i> Back</a> -->
        </div>
    </div>
    <div class="shapes">
        <div class="shapes-base shapes-base--one"></div>
        <div class="shapes-base shapes-base--two d-none d-md-block"></div>
        <div class="decor">
            <span class="top_left"></span>
            <img src="/img/circle-stripe-1.png" alt="">
        </div>
        <div class="circles d-none d-md-block">
            <div class="circles-item circles-item--1"><div></div></div>
            <div class="circles-item circles-item--2"><div></div></div>
            <div class="circles-item circles-item--3"><div></div></div>
            <div class="circles-item circles-item--4"><div></div></div>
            <div class="circles-item circles-item--5"><div></div></div>
            <div class="circles-item circles-item--6"><div></div></div>
            <div class="circles-item circles-item--7"><div></div></div>
            <div class="circles-item circles-item--8"><div></div></div>
            <span class="top_right blue"></span>
            <span class="bottom_left red"></span>
        </div>
    </div>
</article>

    <?php   
}
?>
<main class="education">
    <section class="education-section">
        <div class="container container--big">
            <?php while (have_posts()) : the_post();
            ?>

            <?php
                get_template_part('content', 'educational');
                if (comments_open() || get_comments_number()) :
                    comments_template('', true);
                endif;
                ?>

            <?php
        endwhile; ?>
                </div>
        <div class="decor">
            <span class="top_left"></span>
            <img src="img/circle-stripe-1.png" alt="">
        </div>
    </section>
</main>

<?php
/**
 * Zoo After Main Content
 *
 */
do_action('kek_after_main_content');
get_footer();