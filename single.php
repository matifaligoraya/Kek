<?php
/**
 * The template for displaying all single posts.
 *
 * @package     KeK
 * @version     1.0.0
 * @author      KeK
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2020 KeK
 */


get_header();

$settings = get_option(kek_SETTINGS_KEY);

    // Retrieve the blog title from theme settings
    $blog_title = isset($settings['blog_title']) ? $settings['blog_title'] : '';
$show_subheader = get_post_meta(get_the_ID(), '_sublime_page_show_subheader', true);
$show_subheader =  $show_subheader == "" ? 'on' : $show_subheader;
$subheader_style = get_post_meta(get_the_ID(), '_sublime_page_subheader_style', true);
$subheader_style = $subheader_style == "" ? 'simple_left_aligned' : $subheader_style;
if ('on' === $show_subheader) {
  $subheader_title = get_post_meta(get_the_ID(), '_sublime_page_subheader_title', true);
  //print_r( $subheader_title);
  $subheader_title = $subheader_title == ""? $blog_title :  $subheader_title;
  $subheader_subtitle = get_post_meta(get_the_ID(), '_sublime_page_subheader_subtitle', true);
  
  $subheader_image = get_post_meta(get_the_ID(), '_sublime_page_subheader_image', true);
  $subheader_cssclass = get_post_meta(get_the_ID(), '_sublime_page_subheader_cssclass', true) == "" ? '' : get_post_meta(get_the_ID(), '_sublime_page_subheader_cssclass', true);
  $subheader_image = $subheader_image == ""? the_title() :  $subheader_image;
  // Render the subheader if checkbox is checked

  if($subheader_style == 'fancy_left_aligned')
  {
  ?>

  <article class="banner banner--big <?= $subheader_cssclass; ?>">
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
]
  <?php
  }else if($subheader_style == 'fancy_center_aligned')
  {
  ?>
  <article class="banner banner--big <?= $subheader_cssclass; ?>">
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
  }else  if($subheader_style == 'simple_left_aligned'){
  ?>


<article class="banner banner--page">
  <div class="container">
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
   if($main_class == "" )
   {
      $main_class = 'news news--inner';
   }
}

if (is_home() || is_front_page()) { ?>


<main class="home">
  <?php }else{
  ?>
  
  <main class="<?php echo $main_class; ?>">
      <div class="container container--big">
          <?php
}  
if (have_posts()) :
    while (have_posts()) : the_post();
        /**
         * Zoo Before Main Content
         *
         * @hooked kek_breadcrumb - 10
         * @hooked kek_blog_cover - 20
         */
        do_action('kek_before_main_content');
        ?>
      
    
            <?php
            /**
             * Zoo Before Single Blog Content
             *
             */
            do_action('kek_before_single_main_content');
            ?>
            <div class="container--big">
                <div class="row justify-content-center">
                    <div class="col-lg-8 <?php //echo esc_attr(kek_single_content_css()) ?>">
                        <?php
                        get_template_part('content', 'single');
                        ?>
                    </div>
                    <div class="col-sm-6 col-md-5 col-lg-4">
                    <?php
                    //get_sidebar('ewf-post-sidebar');

                        // Sidebar
                        if ( is_active_sidebar('ewf-post-sidebar')) {
                           // echo '<div class="col-sm-6 col-md-5 col-lg-4">';
                            echo '<aside class="sidebar wow fadeInRight pl-xl-4" data-wow-duration="1.5s">';
                            dynamic_sidebar('ewf-post-sidebar');
                            echo '</aside>';
                            //</div>';
                        }
                       
                    ?>
                    </div>
                </div>
            </div>
            <?php
            /**
             * Zoo After Loop Single Content
             *
             */
            do_action('kek_after_single_main_content');
            ?>
        </main>
        <?php

        /**
         * Zoo After Main Content
         *
         */
        do_action('kek_after_main_content');
    endwhile;
endif;
get_footer();
