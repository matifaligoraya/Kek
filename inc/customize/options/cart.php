<?php
/**
 * Customize for Shop loop product
 */
return [
	[
		'type'           => 'section',
		'name'           => 'kek_cart',
		'title'          => esc_html__( 'Cart Page', 'sublimeplus' ),
		'panel'          => 'woocommerce',
		'theme_supports' => 'woocommerce'
	],
	[
		'name'           => 'kek_cart_general_settings',
		'type'           => 'heading',
		'label'          => esc_html__( 'General Settings', 'sublimeplus' ),
		'section'        => 'kek_cart',
		'theme_supports' => 'woocommerce'
	],
	[
		'type'        => 'image',
		'name'        => 'kek_cart_trust_badges',
		'label'       => esc_html__( 'Trust Badges', 'sublimeplus' ),
		'section'     => 'kek_cart',
		'description' => esc_html__( 'Security & trust badges logo on cart & checkout pages.', 'sublimeplus' ),
	],
];
