<?php
/**
 * Fuction yang digunakan di theme ini.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

add_action( 'after_setup_theme', 'velocitychild_theme_setup', 9 );

function velocitychild_theme_setup() {
	
	// Load justg_child_enqueue_parent_style after theme setup
	add_action( 'wp_enqueue_scripts', 'justg_child_enqueue_parent_style', 20 );
	
	if (class_exists('Kirki')):
		
		/**
		* Customizer control in child themes
		* Sample Panel
		* 
		*/ 
		Kirki::add_panel('panel_home', [
			'priority'    => 10,
			'title'       => esc_html__('Home', 'justg'),
			'description' => esc_html__('', 'justg'),
		]);

		/**
		* Sample section
		* 
		*/ 
		Kirki::add_section('home_slider', [
			'panel'    => 'panel_home',
			'title'    => __('Slider', 'justg'),
			'priority' => 10,
		]);

		/**
		* Sample Field
		* 
		*/ 
		// Kirki::add_field( 'justg_config', [
		// 	'type'        => 'repeater',
		// 	'label'       => esc_html__( 'Slider Home', 'justg' ),
		// 	'section'     => 'home_slider',
		// 	'priority'    => 10,
		// 	'row_label' => [
		// 		'type'  => 'text',
		// 		'value' => esc_html__( 'Slide', 'justg' ),
		// 	],
		// 	'button_label' => esc_html__('Tambah Slide', 'justg' ),
		// 	'settings'     => 'home_slider_setting',
		// 	'fields' => [
		// 		'image' => [
		// 			'type'        => 'image',
		// 			'label'       => esc_html__( 'Gambar', 'justg' ),
		// 			'description' => esc_html__( 'gunakan gambar dengan ukuran sama', 'justg' ),
		// 			'default'     => '',
		// 		],
		// 		'link_url'  => [
		// 			'type'        => 'text',
		// 			'label'       => esc_html__( 'Url slide', 'justg' ),
		// 			'description' => esc_html__( 'link saat gambar di klik', 'justg' ),
		// 			'default'     => '',
		// 		],
		// 	]
		// ] );
		
	endif;
}