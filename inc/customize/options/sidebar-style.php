<?php
/**
 * Customize for General Style
 */
return [ 
    [
        'name' => 'kek_sidebar_style',
        'type' => 'section',
        'label' => esc_html__('Sidebar Style', 'sublimeplus'),
        'panel' => 'kek_style',
        'description' => esc_html__('Leave option blank if you want use default style of theme.', 'sublimeplus'),
    ],
    [
        'name' => 'kek_sidebar_heading_color',
        'type' => 'heading',
        'section' => 'kek_sidebar_style',
        'title' => esc_html__('Color', 'sublimeplus'),
    ],
    [
        'name' => 'kek_sidebar_title_color',
        'type' => 'color',
        'section' => 'kek_sidebar_style',
        'title' => esc_html__('Title Sidebar Color', 'sublimeplus'),
        'selector' => ".sidebar .widget-title",
        'css_format' => 'color: {{value}};',
    ],
    [
        'name' => 'kek_sidebar_color',
        'type' => 'color',
        'section' => 'kek_sidebar_style',
        'title' => esc_html__('Text color', 'sublimeplus'),
        'selector' => ".sidebar",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'kek_sidebar_link_color',
        'type' => 'color',
        'section' => 'kek_sidebar_style',
        'title' => esc_html__('Link color', 'sublimeplus'),
        'selector' => ".sidebar a, .widget > ul li a",
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'kek_sidebar_link_color_hover',
        'type' => 'color',
        'section' => 'kek_sidebar_style',
        'title' => esc_html__('Link color hover', 'sublimeplus'),
        'selector' => ".sidebar a:hover, .widget > ul li a:hover",
        'css_format' => 'color: {{value}};',
    ],
];
