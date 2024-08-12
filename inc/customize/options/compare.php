<?php
/**
 * Customize Compare Options
 */
return [
    [
        'type' => 'section',
        'name' => 'kek_compare',
        'title' => esc_html__('Compare', 'sublimeplus'),
        'panel' => 'woocommerce',
        'theme_supports' => 'woocommerce'
    ],
    [
        'name' => 'kek_compare_general_settings',
        'type' => 'heading',
        'label' => esc_html__('General Settings', 'sublimeplus'),
        'section' => 'kek_compare'
    ],
    [
        'name' => 'kek_enable_compare',
        'type' => 'checkbox',
        'section' => 'kek_compare',
        'label' => esc_html__('Enable Compare', 'sublimeplus'),
        'checkbox_label' => esc_html__('Will be enabled if checked.', 'sublimeplus'),
        'theme_supports' => 'woocommerce',
        'default' => 1
    ],
    [
        'name' => 'kek_enable_shop_loop_compare',
        'type' => 'checkbox',
        'section' => 'kek_compare',
        'label' => esc_html__('Enable Shop Compare', 'sublimeplus'),
        'checkbox_label' => esc_html__('compare button will show in shop loop if checked.', 'sublimeplus'),
        'theme_supports' => 'woocommerce',
        'default' => 1
    ],
    [
        'name' => 'kek_enable_compare_redirect',
        'type' => 'checkbox',
        'section' => 'kek_compare',
        'label' => esc_html__('Enable compare Redirect Link', 'sublimeplus'),
        'checkbox_label' => esc_html__('Redirect to compare page when click to button browse compare.', 'sublimeplus'),
        'theme_supports' => 'woocommerce',
        'default' => 0
    ],
    [
        'name' => 'kek_compare_page',
        'type' => 'select',
        'section' => 'kek_compare',
        'title' => esc_html__('Compare page', 'sublimeplus'),
        'default' => '',
        'theme_supports' => 'woocommerce',
        'choices' => kek_list_pages_by_slug(),
        'required' => ['kek_enable_compare_redirect', '==', 1]
    ],
    [
        'name' => 'kek_compare_add_to_compare_settings',
        'type' => 'heading',
        'label' => esc_html__('Add to compare Settings', 'sublimeplus'),
        'section' => 'kek_compare',
        'required' => ['kek_enable_compare', '==', 1]
    ],
    [
        'name' => 'kek_text_add_to_compare',
        'type' => 'text',
        'section' => 'kek_compare',
        'label' => esc_html__('Label', 'sublimeplus'),
        'default' => esc_html__('Add to Compare', 'sublimeplus'),
        'required' => ['kek_enable_compare', '==', 1]
    ],
    [
        'name' => 'kek_icon_add_to_compare',
        'type' => 'icon',
        'section' => 'kek_compare',
        'label' => esc_html__('Icon', 'sublimeplus'),
        'default' => [
            'type' => 'icon',
            'icon' => 'icon-refresh'
        ],
        'required' => ['kek_enable_compare', '==', 1]
    ],
    [
        'name' => 'kek_compare_browse_to_compare_settings',
        'type' => 'heading',
        'label' => esc_html__('Browse to compare Settings', 'sublimeplus'),
        'section' => 'kek_compare',
        'required' => ['kek_enable_compare', '==', 1]
    ],
    [
        'name' => 'kek_text_browse_to_compare',
        'type' => 'text',
        'section' => 'kek_compare',
        'label' => esc_html__('Label', 'sublimeplus'),
        'default' => esc_html__('Browse compare', 'sublimeplus'),
        'required' => ['kek_enable_compare', '==', 1]
    ],
    [
        'name' => 'kek_icon_browse_to_compare',
        'type' => 'icon',
        'section' => 'kek_compare',
        'label' => esc_html__('Icon', 'sublimeplus'),
        'default' => [
            'type' => 'icon',
            'icon' => 'icon-refresh'
        ],
        'required' => ['kek_enable_compare', '==', 1]
    ],
    [
        'name' => 'kek_compare_style_settings',
        'type' => 'heading',
        'label' => esc_html__('compare Style', 'sublimeplus'),
        'section' => 'kek_compare',
        'required' => ['kek_enable_compare', '==', 1]
    ],
    [
        'name' => 'kek_compare_icon_size',
        'type' => 'slider',
        'label' => esc_html__('Font Size', 'sublimeplus'),
        'section' => 'kek_compare',
        'min' => 8,
        'step' => 1,
        'max' => 100,
        'selector' => ".woocommerce ul.products li.product .compare-button>i",
        'css_format' => "font-size: {{value}};",
        'required' => ['kek_enable_compare', '==', 1]
    ],
    [
        'name' => 'kek_compare_shop_style',
        'type' => 'styling',
        'section' => 'kek_compare',
        'title' => esc_html__('compare style', 'sublimeplus'),
        'description' => esc_html__('Advanced styling for compare in shop loop', 'sublimeplus'),
        'required' => ['kek_enable_compare', '==', 1],
        'selector' => [
            'normal' => '.woocommerce ul.products li.product .compare-button',
            'hover' => '.woocommerce ul.products li.product .compare-button:hover, .woocommerce ul.products li.product .compare-button.browse-products-compare',
        ],
        'css_format' => 'styling',
        'priority' => 11,
        'default' => [],
        'fields' => [
            'normal_fields' => [
                'link_color' => false, // disable for special field.
                'margin' => false,
                'padding' => false,
                'bg_image' => false,
                'device_settings' => false,
                'link_hover_color'   => false,
            ],
            'hover_fields' => [
                'link_color' => false, // disable for special field.
            ]
        ]
    ]
];
