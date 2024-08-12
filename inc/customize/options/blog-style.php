<?php
/**
 * Customize for General Style
 */
return [ 
    [
        'name' => 'kek_blog_style',
        'type' => 'section',
        'label' => esc_html__('Blog Style', 'sublimeplus'),
        'panel' => 'kek_style',
    ],
    [
        'name' => 'kek_blog_archive_heading_color',
        'type' => 'heading',
        'section' => 'kek_blog_style',
        'title' => esc_html__('Blog Archive', 'sublimeplus'),
    ],
    [
        'name' => 'kek_blog_title_color',
        'type' => 'color',
        'section' => 'kek_blog_style',
        'title' => esc_html__('Title Color', 'sublimeplus'),
        'selector' => ".post-loop-item .entry-title",
        'css_format' => 'color: {{value}};',
    ],    [
        'name' => 'kek_site_title_color_hover',
        'type' => 'color',
        'section' => 'kek_blog_style',
        'title' => esc_html__('Title Color Hover', 'sublimeplus'),
        'selector' => ".post-loop-item .entry-title:hover",
        'css_format' => 'color: {{value}};',
    ],
    [
        'name' => 'kek_blog_date_color',
        'type' => 'color',
        'section' => 'kek_blog_style',
        'title' => esc_html__('Post date color', 'sublimeplus'),
        'selector' => ".post-loop-item .post-date",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'kek_blog_excerpt_color',
        'type' => 'color',
        'section' => 'kek_blog_style',
        'title' => esc_html__('Excerpt color', 'sublimeplus'),
        'selector' => ".post-loop-item .entry-content",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'kek_blog_readmore_color',
        'type' => 'color',
        'section' => 'kek_blog_style',
        'title' => esc_html__('Read More color', 'sublimeplus'),
        'selector' => ".post-loop-item .readmore",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'kek_blog_readmore_color_hover',
        'type' => 'color',
        'section' => 'kek_blog_style',
        'title' => esc_html__('Link color hover', 'sublimeplus'),
        'selector' => ".post-loop-item .readmore:hover",
        'css_format' => 'color: {{value}};',
    ],
    [
        'name' => 'kek_blog_single_heading_color',
        'type' => 'heading',
        'section' => 'kek_blog_style',
        'title' => esc_html__('Blog Single', 'sublimeplus'),
    ],
    [
        'name' => 'kek_blog_single_title_color',
        'type' => 'color',
        'section' => 'kek_blog_style',
        'title' => esc_html__('Title post', 'sublimeplus'),
        'selector' => ".post-loop-item .readmore:hover",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'kek_blog_single_info_color',
        'type' => 'color',
        'section' => 'kek_blog_style',
        'title' => esc_html__('Post Information', 'sublimeplus'),
        'description' => esc_html__('Color of block date post, categories, author.', 'sublimeplus'),
        'selector' => "post-detail .post-info",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'kek_blog_single_info_color_hover',
        'type' => 'color',
        'section' => 'kek_blog_style',
        'title' => esc_html__('Post Information Link hover', 'sublimeplus'),
        'description' => esc_html__('Color hover link of block date post, categories, author.', 'sublimeplus'),
        'selector' => ".post-detail .post-info a:hover",
        'css_format' => 'color: {{value}};',
    ],
];
