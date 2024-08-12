<?php
/**
 * Customize for Shop loop product
 */
return [
    [
        'name' => 'kek_blog',
        'type' => 'panel',
        'label' => esc_html__('Blog', 'sublimeplus'),
    ],[
        'name' => 'kek_blog_archive',
        'type' => 'section',
        'label' => esc_html__('Blog Archive', 'sublimeplus'),
        'panel' => 'kek_blog',
    ],
    [
        'name' => 'kek_blog_general_settings',
        'type' => 'heading',
        'label' => esc_html__('General Settings', 'sublimeplus'),
        'section' => 'kek_blog_archive',
    ],
    [
        'name' => 'kek_blog_layout',
        'type' => 'select',
        'section' => 'kek_blog_archive',
        'title' => esc_html__('Layout', 'sublimeplus'),
        'default' => 'list',
        'choices' => [
            'list' => esc_html__('List', 'sublimeplus'),
            'list-2' => esc_html__('List 2', 'sublimeplus'),
            'grid' => esc_html__('Grid', 'sublimeplus'),
            'masonry' => esc_html__('Masonry', 'sublimeplus'),
        ]
    ],
    [
        'name' => 'kek_blog_grid_img_size',
        'type' => 'select',
        'section' => 'kek_blog_archive',
        'label' => esc_html__('Image size', 'sublimeplus'),
        'description' => esc_html__('Select image size fit with layout you want use for improve performance.', 'sublimeplus'),
        'default' => 'medium',
        'required' => ['kek_blog_layout', '!=', 'list'],
	    'choices'=>kek_get_image_sizes()

    ],
	[
        'name' => 'kek_blog_img_size',
        'type' => 'select',
        'section' => 'kek_blog_archive',
        'label' => esc_html__('Image size', 'sublimeplus'),
        'description' => esc_html__('Select image size fit with layout you want use for improve performance.', 'sublimeplus'),
        'default' => 'full',
        'required' => ['kek_blog_layout', '==', 'list'],
	    'choices'=>kek_get_image_sizes()

    ],
	[
        'name' => 'kek_blog_cols',
        'type' => 'number',
        'section' => 'kek_blog_archive',
        'label' => esc_html__('Columns', 'sublimeplus'),
        'description' => esc_html__('Apply for Grid Layout only', 'sublimeplus'),
        'default' => 3,
        'required' => ['kek_blog_layout', '!=', 'list'],
        'input_attrs' => array(
            'min' => 1,
            'max' => 6,
            'class' => 'range-slider'
        ),
    ],
    [
        'name' => 'kek_enable_blog_cover',
        'type' => 'checkbox',
        'section' => 'kek_blog_archive',
        'label' => esc_html__('Enable Blog Cover', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 0
    ],
    [
        'name' => 'kek_blog_cover',
        'type' => 'styling',
        'section' => 'kek_blog_archive',
        'title' => esc_html__('Blog cover style', 'sublimeplus'),
        'description' => esc_html__('Styling for categories page', 'sublimeplus'),
        'required' => ['kek_enable_blog_cover', '==', '1'],
        'selector' => [
            'normal' => '.wrap-blog-cover',
        ],
        'css_format' => 'styling',
        'default' => [],
        'fields' => [
            'normal_fields' => [
                'margin' => false,
                'link_color' => false,
                'border_style' => false,
                'border_heading' => false,
                'border_radius' => false,
                'box_shadow' => false,
                'link_hover_color'   => false,
            ],
            'hover_fields' => false
        ]
    ],
    [
        'name' => 'kek_blog_sidebar_settings',
        'type' => 'heading',
        'label' => esc_html__('Sidebar Settings', 'sublimeplus'),
        'section' => 'kek_blog_archive'
    ],
    [
        'name' => 'kek_blog_sidebar_config',
        'type' => 'select',
        'section' => 'kek_blog_archive',
        'title' => esc_html__('Sidebar layout', 'sublimeplus'),
        'default' => 'right',
        'choices' => [
            '' => esc_html__('None', 'sublimeplus'),
            'left' => esc_html__('Left', 'sublimeplus'),
            'right' => esc_html__('Right', 'sublimeplus'),
        ]
    ],[
        'name' => 'kek_blog_sidebar',
        'type' => 'select',
        'section' => 'kek_blog_archive',
        'title' => esc_html__('Sidebar', 'sublimeplus'),
        'required' => ['kek_blog_sidebar_config', '!=', 'none'],
        'choices' => kek_get_registered_sidebars()
    ],
    [
        'name' => 'kek_blog_item_settings',
        'type' => 'heading',
        'label' => esc_html__('Blog Item', 'sublimeplus'),
        'section' => 'kek_blog_archive',
    ],
    [
        'name' => 'kek_blog_loop_post_info_style',
        'type' => 'select',
        'section' => 'kek_blog_archive',
        'title' => esc_html__('Post info style', 'sublimeplus'),
        'default' => 'icon',
        'choices' => [
            'icon' => esc_html__('icon', 'sublimeplus'),
            'text' => esc_html__('Text', 'sublimeplus'),
        ]
    ],
    [
        'name' => 'kek_enable_loop_author_post',
        'type' => 'checkbox',
        'section' => 'kek_blog_archive',
        'label' => esc_html__('Enable Author Post', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 1
    ], [
        'name' => 'kek_enable_loop_date_post',
        'type' => 'checkbox',
        'section' => 'kek_blog_archive',
        'label' => esc_html__('Enable Date Post', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 1
    ], [
        'name' => 'kek_enable_loop_cat_post',
        'type' => 'checkbox',
        'section' => 'kek_blog_archive',
        'label' => esc_html__('Enable Post Categories', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 1
    ],
    [
        'name' => 'kek_enable_loop_excerpt',
        'type' => 'checkbox',
        'section' => 'kek_blog_archive',
        'label' => esc_html__('Enable Blog Excerpt', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 0
    ],
    [
        'name' => 'kek_loop_excerpt_length',
        'type' => 'number',
        'section' => 'kek_blog_archive',
        'label' => esc_html__('Blog Excerpt length', 'sublimeplus'),
        'default' => 30,
        'required' => ['kek_enable_loop_excerpt', '==', 1],
        'input_attrs' => array(
            'min' => 1,
            'max' => 256,
            'class' => 'range-slider'
        ),
    ],
    [
        'name' => 'kek_enable_loop_readmore',
        'type' => 'checkbox',
        'section' => 'kek_blog_archive',
        'label' => esc_html__('Enable Read more', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'default' => 1
    ]
];