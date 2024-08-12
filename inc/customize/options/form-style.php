<?php
/**
 * Customize for Form field and Button Style
 */
return [ 
    [
        'name' => 'kek_form_field_style',
        'type' => 'section',
        'label' => esc_html__('Form Field and Button Style', 'sublimeplus'),
        'panel' => 'kek_style',
    ],
    [
        'name' => 'kek_form_field_heading_color',
        'type' => 'heading',
        'section' => 'kek_form_field_style',
        'title' => esc_html__('Form Field', 'sublimeplus'),
    ],
    [
        'name' => 'kek_form_field_color',
        'type' => 'color',
        'section' => 'kek_form_field_style',
        'title' => esc_html__('Color', 'sublimeplus'),
        'selector' => '.text-field, input[type="text"], input[type="search"], input[type="password"], textarea, input[type="email"], input[type="tel"]',
        'css_format' => 'color: {{value}};',
    ],    [
        'name' => 'kek_form_field_border_color',
        'type' => 'color',
        'section' => 'kek_form_field_style',
        'title' => esc_html__('Border Color', 'sublimeplus'),
        'selector' => '.text-field, input[type="text"], input[type="search"], input[type="password"], textarea, input[type="email"], input[type="tel"]',
        'css_format' => 'border-color: {{value}};',
    ],[
        'name' => 'kek_form_field_border_color_active',
        'type' => 'color',
        'section' => 'kek_form_field_style',
        'title' => esc_html__('Border Color Active', 'sublimeplus'),
        'selector' => '.text-field:focus, input[type="text"]:focus, input[type="search"]:focus, input[type="password"]:focus, textarea:focus, input[type="email"]:focus, input[type="tel"]:focus',
        'css_format' => 'border-color: {{value}};',
    ],
    [
        'name' => 'kek_form_field_background',
        'type' => 'color',
        'section' => 'kek_form_field_style',
        'title' => esc_html__('Background', 'sublimeplus'),
        'selector' => '.text-field, input[type="text"], input[type="search"], input[type="password"], textarea, input[type="email"], input[type="tel"]',
        'css_format' => 'background-color: {{value}};',
    ],
    [
        'name' => 'kek_form_field_button_heading',
        'type' => 'heading',
        'section' => 'kek_form_field_style',
        'title' => esc_html__('Button', 'sublimeplus'),
    ],
    [
        'name' => 'kek_button_color',
        'type' => 'color',
        'section' => 'kek_form_field_style',
        'title' => esc_html__('Color', 'sublimeplus'),
        'selector' => '.btn, input[type="submit"], .button, button',
        'css_format' => 'color: {{value}};',
    ], [
        'name' => 'kek_button_background_color',
        'type' => 'color',
        'section' => 'kek_form_field_style',
        'title' => esc_html__('Background Color', 'sublimeplus'),
        'selector' => '.btn, input[type="submit"], .button, button',
        'css_format' => 'background-color: {{value}};',
    ],[
        'name' => 'kek_button_color_hover',
        'type' => 'color',
        'section' => 'kek_form_field_style',
        'title' => esc_html__('Color hover', 'sublimeplus'),
        'selector' => '.btn:hover, input[type="submit"]:hover, .button:hover, button:hover',
        'css_format' => 'color: {{value}};',
    ],[
        'name' => 'kek_button_background_color_hover',
        'type' => 'color',
        'section' => 'kek_form_field_style',
        'title' => esc_html__('Background Color hover', 'sublimeplus'),
        'selector' => '.btn:hover, input[type="submit"]:hover, .button:hover, button:hover',
        'css_format' => 'background-color: {{value}};',
    ],
];
