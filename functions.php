<?php
/**
 * fHomeopathy functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage fHomeopathy
 * @author tishonator
 * @since fHomeopathy 1.0.0
 *
 */

if ( ! function_exists( 'fhomeopathy_setup' ) ) :
/**
 * fHomeopathy setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 */
function fhomeopathy_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'fhomeopathy', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );

	// add custom background
	add_theme_support( 'custom-background', 
				   array ('default-color'  => '#FFFFFF')
				 );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 'full', 'full', true );

	// This theme uses wp_nav_menu() in header menu
	register_nav_menus( array(
		'primary'   => __( 'primary menu', 'fhomeopathy' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );

	// add the visual editor to resemble the theme style
	add_editor_style( array( 'css/editor-style.css' ) );

	// add content width
	if ( ! isset( $content_width ) ) {

		$content_width = 900;
	}

	// add custom header
	add_theme_support( 'custom-header', array (
					   'default-image'          => '',
					   'random-default'         => '',
					   'width'                  => 190,
					   'height'                 => 36,
					   'flex-height'            => true,
					   'flex-width'             => true,
					   'default-text-color'     => '',
					   'header-text'            => '',
					   'uploads'                => true,
					   'wp-head-callback'       => '',
					   'admin-head-callback'    => '',
					   'admin-preview-callback' => '',
					) );
}
endif; // fhomeopathy_setup

add_action( 'after_setup_theme', 'fhomeopathy_setup' );

/**
 * the main function to load scripts in the fHomeopathy theme
 * if you add a new load of script, style, etc. you can use that function
 * instead of adding a new wp_enqueue_scripts action for it.
 */
function fhomeopathy_load_scripts() {

	// load main stylesheet.
	wp_enqueue_style( 'fhomeopathy-style', get_stylesheet_uri(), array( ) );
	
	wp_enqueue_style( 'fhomeopathy-fonts', fhomeopathy_fonts_url(), array(), null );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	// Load Utilities JS Script
	wp_enqueue_script( 'fhomeopathy-js', get_template_directory_uri() . '/js/utilities.js', array( 'jquery' ) );	
}

add_action( 'wp_enqueue_scripts', 'fhomeopathy_load_scripts' );

/* 
 * Display the inline css style for the header tag
 */
function fhomeopathy_header_css_style() {

	$backgroundImageUrl = get_theme_mod('fhomeopathy_header_topbackground',
							get_stylesheet_directory_uri() . '/images/topbackground.jpg');

	if ( empty($backgroundImageUrl) ) {
		return;
	}

	$css = 'background-image: url(' . "'" . $backgroundImageUrl . "'" . ');';

	$css .= 'background-repeat: no-repeat;';

	if ( get_theme_mod('fhomeopathy_header_topbackgroundfullscreen', 1) == 1 ) {

		$css .= 'height:100vh;';
	}

	echo 'style="' . $css .'"';
}

/**
 *	Load google font url used in the fHomeopathy theme
 */
function fhomeopathy_fonts_url() {

    $fonts_url = '';
 
    /* Translators: If there are characters in your language that are not
    * supported by PT Sans, translate this to 'off'. Do not translate
    * into your own language.
    */
    $cantarell = _x( 'on', 'Yanone Kaffeesatz font: on or off', 'fhomeopathy' );

    if ( 'off' !== $cantarell ) {
        $font_families = array();
 
        $font_families[] = 'Yanone Kaffeesatz';
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }
 
    return $fonts_url;
}

/**
 * Display website's logo image
 */
function fhomeopathy_show_website_logo_image_or_title() {

	if ( get_header_image() != '' ) {
	
		// Check if the user selected a header Image in the Customizer or the Header Menu
		$logoImgPath = get_header_image();
		$siteTitle = get_bloginfo( 'name' );
		$imageWidth = get_custom_header()->width;
		$imageHeight = get_custom_header()->height;
		
		echo '<a href="' . esc_url( home_url('/') ) . '" title="' . esc_attr( get_bloginfo('name') ) . '">';
		
		echo '<img src="' . esc_attr( $logoImgPath ) . '" alt="' . esc_attr( $siteTitle ) . '" title="' . esc_attr( $siteTitle ) . '" width="' . esc_attr( $imageWidth ) . '" height="' . esc_attr( $imageHeight ) . '" />';
		
		echo '</a>';

	} else {
	
		echo '<a href="' . esc_url( home_url('/') ) . '" title="' . esc_attr( get_bloginfo('name') ) . '">';
		
		echo '<h1>'.get_bloginfo('name').'</h1>';
		
		echo '</a>';
		
		echo '<strong>'.get_bloginfo('description').'</strong>';
	}
}

/**
 *	Displays the copyright text.
 */
function fhomeopathy_show_copyright_text() {

	$footerText = get_theme_mod('fhomeopathy_footer_copyright', null);

	if ( !empty( $footerText ) ) {

		echo esc_html( $footerText ) . ' | ';		
	}
}

/**
 *	widgets-init action handler. Used to register widgets and register widget areas
 */
function fhomeopathy_widgets_init() {
	
	// Register Sidebar Widget.
	register_sidebar( array (
						'name'	 		 =>	 __( 'Sidebar Widget Area', 'fhomeopathy'),
						'id'		 	 =>	 'sidebar-widget-area',
						'description'	 =>  __( 'The sidebar widget area', 'fhomeopathy'),
						'before_widget'	 =>  '',
						'after_widget'	 =>  '',
						'before_title'	 =>  '<div class="sidebar-before-title"></div><h3 class="sidebar-title">',
						'after_title'	 =>  '</h3><div class="sidebar-after-title"></div>',
					) );
}
add_action( 'widgets_init', 'fhomeopathy_widgets_init' );

/**
 * Gets additional theme settings description
 */
function fhomeopathy_get_customizer_sectoin_info() {

	$premiumThemeUrl = 'https://tishonator.com/product/thomeopathy';

	return sprintf( __( 'The fHomeopathy theme is a free version of the professional WordPress theme tHomeopathy. <a href="%s" class="button-primary" target="_blank">Get tHomeopathy Theme</a><br />', 'fhomeopathy' ), $premiumThemeUrl );
}

/**
 * Register theme settings in the customizer
 */
function fhomeopathy_customize_register( $wp_customize ) {

	// Site Identity
	$wp_customize->add_section( 'title_tagline', array(
		'title' => __( 'Site Identity', 'fhomeopathy' ),
		'description' => fhomeopathy_get_customizer_sectoin_info(),
		'priority' => 30,
	) );

	// Header Image Section
	$wp_customize->add_section( 'header_image', array(
		'title' => __( 'Header Image', 'fhomeopathy' ),
		'description' => fhomeopathy_get_customizer_sectoin_info(),
		'theme_supports' => 'custom-header',
		'priority' => 60,
	) );

	// Colors Section
	$wp_customize->add_section( 'colors', array(
		'title' => __( 'Colors', 'fhomeopathy' ),
		'description' => fhomeopathy_get_customizer_sectoin_info(),
		'priority' => 50,
	) );


	// Background Image Section
	$wp_customize->add_section( 'background_image', array(
			'title' => __( 'Background Image', 'fhomeopathy' ),
			'description' => fhomeopathy_get_customizer_sectoin_info(),
			'priority' => 70,
		) );

	/**
	 * Add Header and Footer Section
	 */
	$wp_customize->add_section(
		'fhomeopathy_header_and_footer_settings',
		array(
			'title'       => __( 'Header and Footer', 'fhomeopathy' ),
			'capability'  => 'edit_theme_options',
			'description' => fhomeopathy_get_customizer_sectoin_info(),
		)
	);

	// Add top background image
	$wp_customize->add_setting( 'fhomeopathy_header_topbackground', array(
					'sanitize_callback' => 'esc_url_raw',
					'default' 			=> get_stylesheet_directory_uri().'/images/topbackground.jpg',
				) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fhomeopathy_header_topbackground',
			array(
				'label'   	 => __( 'Top Background Image', 'fhomeopathy' ),
				'section' 	 => 'fhomeopathy_header_and_footer_settings',
				'settings'   => 'fhomeopathy_header_topbackground',
			) 
		)
	);

	// Display top image full screen
	$wp_customize->add_setting(
		'fhomeopathy_header_topbackgroundfullscreen',
		array(
		    'default'           => 1,
		    'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fhomeopathy_header_topbackgroundfullscreen',
        array(
            'label'          => __( 'Display Top Image in Full Screen Height', 'fhomeopathy' ),
            'section'        => 'fhomeopathy_header_and_footer_settings',
            'settings'       => 'fhomeopathy_header_topbackgroundfullscreen',
            'type'           => 'checkbox',
            )
        )
	);

	// Add footer copyright text
	$wp_customize->add_setting(
		'fhomeopathy_footer_copyright',
		array(
		    'default'           => '',
		    'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fhomeopathy_footer_copyright',
        array(
            'label'          => __( 'Copyright Text', 'fhomeopathy' ),
            'section'        => 'fhomeopathy_header_and_footer_settings',
            'settings'       => 'fhomeopathy_footer_copyright',
            'type'           => 'text',
            )
        )
	);
}
add_action('customize_register', 'fhomeopathy_customize_register');

?>
