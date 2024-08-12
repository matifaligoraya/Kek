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
    $show_subheader =  $show_subheader == 'on';
  //exit;
   $subheader_style = get_post_meta(get_the_ID(), '_sublime_page_subheader_style', true);
   $subheader_style =  $show_subheader == 1 ? $subheader_style : "";
//exit;
if ($show_subheader ) {
    $subheader_title = get_post_meta(get_the_ID(), '_sublime_page_subheader_title', true);
    //print_r( $subheader_title);
    $subheader_title = $subheader_title == ""? the_title() :  $subheader_title;
    $subheader_subtitle = get_post_meta(get_the_ID(), '_sublime_page_subheader_subtitle', true);
    
    $subheader_image = get_post_meta(get_the_ID(), '_sublime_page_subheader_image', true);
    $subheader_cssclass = get_post_meta(get_the_ID(), '_sublime_page_subheader_cssclass', true) == "" ? '' : get_post_meta(get_the_ID(), '_sublime_page_subheader_cssclass', true);
    $subheader_image = $subheader_image == ""? the_title() :  $subheader_image;
    // Render the subheader if checkbox is checked

    if($subheader_style == 'fancy_left_aligned' &&  $show_subheader )
    {
    ?>

<article class="simple_left_aligned banner banner--big <?= $subheader_cssclass; ?>">
    <div class="container container--big">
        <div class="row">
            <div class="col-lg-5 text-left">
                <h1><?php echo $subheader_title; ?></h1>
                <p> <?= $subheader_subtitle  ?></p>
            </div>
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
            <div class="circles-item circles-item--1">
                <div></div>
            </div>
            <div class="circles-item circles-item--2">
                <div></div>
            </div>
            <div class="circles-item circles-item--3">
                <div></div>
            </div>
            <div class="circles-item circles-item--4">
                <div></div>
            </div>
            <div class="circles-item circles-item--5">
                <div></div>
            </div>
            <div class="circles-item circles-item--6">
                <div></div>
            </div>
            <div class="circles-item circles-item--7">
                <div></div>
            </div>
            <div class="circles-item circles-item--8">
                <div></div>
            </div>
            <span class="top_right blue"></span>
            <span class="bottom_left red"></span>
        </div>
    </div>
</article>

<?php
    }else if($subheader_style == 'fancy_center_aligned' &&  $show_subheader )
    {
    ?>
<article class="simple_left_aligned banner banner--big <?= $subheader_cssclass; ?>">
    <div class="container container--big">
        <div class="row justify-content-center">
            <div class="col-sm-7 col-lg-6">
                <h1><?php echo $subheader_title; ?></h1>
                <p> <?= $subheader_subtitle  ?></p>
            </div>
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
            <div class="circles-item circles-item--1">
                <div></div>
            </div>
            <div class="circles-item circles-item--2">
                <div></div>
            </div>
            <div class="circles-item circles-item--3">
                <div></div>
            </div>
            <div class="circles-item circles-item--4">
                <div></div>
            </div>
            <div class="circles-item circles-item--5">
                <div></div>
            </div>
            <div class="circles-item circles-item--6">
                <div></div>
            </div>
            <div class="circles-item circles-item--7">
                <div></div>
            </div>
            <div class="circles-item circles-item--8">
                <div></div>
            </div>
            <span class="top_right blue"></span>
            <span class="bottom_left red"></span>
        </div>
    </div>
</article>
<?php
    }else  if ($subheader_style == 'simple_left_aligned' &&  $show_subheader ) {
      //  echo $subheader_style;
    ?>


    <article class="banner banner--page simple_left_aligned ">
        <div class="container container--big">
            <h1><?php echo $subheader_title; ?></h1>
            <p> <?= $subheader_subtitle  ?></p>
            <?php if (function_exists('yoast_breadcrumb')) {
                yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
            } ?>
        </div>
    </article>

<?php
    }
     $main_class = get_post_meta(get_the_ID(), '_sublime_page_main_css_class', true);
     $customtyle =  '';
     if($main_class == "" )
     {
        $main_class = 'home';
        $customtyle =  'style="margin-top: 8.9rem;"';
     }
}

if (is_home() || is_front_page()) { ?>


<main class="home" style="margin-top: 8.9rem;">
    <?php }else{
    ?>

    <main class="<?php echo $main_class; ?>" $customtyle >
        <div class="container container--big">
            <?php
  }  ?>
            <?php while (have_posts()) : the_post();
            ?>

            <?php
                get_template_part('content', 'page');
                if (comments_open() || get_comments_number()) :
                    comments_template('', true);
                endif;
                ?>

            <?php
        endwhile; ?>
            <?php 
if (is_home() || is_front_page()) { ?>
    </main>
    <?php }else{
    ?>
</main>
</div>
<?php
  }  ?>
<?php
/**
 * Zoo After Main Content
 *
 */
do_action('kek_after_main_content');
get_footer();