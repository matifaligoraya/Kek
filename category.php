<?php
get_header(); // Include the header

$category = get_queried_object(); // Get the current category object

// Set up the query arguments to get posts from the current category
$args = array(
    'cat' => $category->term_id,
    'posts_per_page' => 10, // Number of posts per page
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1, // Pagination
);

// Create a new WP_Query instance
$query = new WP_Query($args);

?>
<main class="news pb-0">
    <div class="">
        <div class="container">
            <div class="news-title wow fadeInUp" data-wow-duration="1.5s">
                <h2><?php single_cat_title(); ?></h2>
            </div>
            <div class="row justify-content-center mb-3">
                <div class="col-lg-8">
                    <div class="news-grid news-grid--sm">
                        <?php
                        if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                        ?>
                        <div class="news-item news-item--video wow fadeInUp" data-wow-duration="1.5s">
                            <div class="news-item-image">
                                <a href="<?php the_permalink(); ?>" class="news-item-image-link" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>')"></a>
                                <div class="news-category">
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        foreach ($categories as $category) {
                                            echo '<span>' . esc_html($category->name) . '</span>';
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="news-item-play">
                                    <a href="<?php the_permalink(); ?>"><i class="fas fa-play"></i></a>
                                </div>
                            </div>
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        </div>
                        <?php
                        endwhile;
                        endif;
                        ?>
                    </div>
                    <div class="text-center pt-2 pb-4 wow fadeInUp" data-wow-duration="1.5s">
                        <?php
                        // Display pagination
                        echo paginate_links(array(
                            'total' => $query->max_num_pages,
                            'prev_text' => __('« Previous', 'text-domain'),
                            'next_text' => __('Next »', 'text-domain'),
                        ));
                        ?>
                    </div>
                </div>
                <div class="col-sm-6 col-md-5 col-lg-4">
                    <aside class="sidebar wow fadeInRight" data-wow-duration="1.5s">
                        <?php include 'banner-info.php' ?>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
wp_reset_postdata(); // Reset post data
get_footer(); // Include the footer
