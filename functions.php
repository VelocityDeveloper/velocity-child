<?php
/**
 * Child theme functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Text Domain: justg
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

/**
 * Load other required files
 *
 */
// require_once('inc/meta-box.php');

/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */
if( ! function_exists( 'justg_child_enqueue_parent_style') ) {
	function justg_child_enqueue_parent_style() {
		// Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update your theme)
		$parenthandle = 'parent-style'; 
        $theme = wp_get_theme();
		
		// Load the stylesheet
        wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 
            array(),  // if the parent theme code has a dependency, copy it to here
            $theme->parent()->get('Version')
        );
        
        $css_version = $theme->parent()->get('Version') . '.' . filemtime( get_stylesheet_directory() . '/css/custom.css' );
        // wp_enqueue_style( 'slick-style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css', $css_version);
        // wp_enqueue_style( 'slick-style-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css', $css_version);
        wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/css/custom.css', 
            array(),  // if the parent theme code has a dependency, copy it to here
            $css_version
        );
        
        wp_enqueue_style( 'child-style', get_stylesheet_uri(),
            array( $parenthandle ),
            $theme->get('Version')
        );
        
        $js_version = $theme->parent()->get('Version') . '.' . filemtime( get_stylesheet_directory() . '/js/custom.js' );
        // wp_enqueue_script( 'slick-scripts', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array(), $js_version, true );
        wp_enqueue_script( 'justg-custom-scripts', get_stylesheet_directory_uri() . '/js/custom.js', array(), $js_version, true );

	}
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

//[resize-thumbnail width="300" height="150" linked="true" class="w-100"]
add_shortcode('resize-thumbnail', 'resize_thumbnail');
function resize_thumbnail($atts) {
    ob_start();
	global $post;
    $atribut = shortcode_atts( array(
        'output'	=> 'image', /// image or url
        'width'    	=> '300', ///width image
        'height'    => '150', ///height image
        'crop'      => 'false',
        'upscale'   => 'true',
        'linked'   	=> 'true', ///return link to post	
        'class'   	=> 'w-100', ///return class name to img	
    ), $atts );

    $output			= $atribut['output'];
    $width          = $atribut['width'];
    $height         = $atribut['height'];
    $crop           = $atribut['crop'];
    $upscale        = $atribut['upscale'];
    $linked        	= $atribut['linked'];
    $class        	= $atribut['class']?'class="'.$atribut['class'].'"':'';
	$urlimg			= get_the_post_thumbnail_url($post->ID,'full');

	if($urlimg):
		$urlresize      = aq_resize( $urlimg, $width, $height, $crop, true, $upscale );
		if($output=='image'):
			if($linked=='true'):
				echo '<a href="'.get_the_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
			endif;
			echo '<img src="'.$urlresize.'" width="'.$width.'" height="'.$height.'" loading="lazy" '.$class.'>';
			if($linked=='true'):
				echo '</a>';
			endif;
		else:
			echo $urlresize;
		endif;
	endif;

	return ob_get_clean();
}
