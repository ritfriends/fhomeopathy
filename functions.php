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
 * @subpackage fHomeopathy
 * @author tishonator
 * @since fHomeopathy 1.0.0
 *
 */

require_once( trailingslashit( get_template_directory() ) . 'customize-pro/class-customize.php' );

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
	set_post_thumbnail_size( 1200, 0, true );

	// This theme uses wp_nav_menu() in header menu
	register_nav_menus( array(
		'primary'   => __( 'Primary Menu', 'fhomeopathy' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// add the visual editor to resemble the theme style
	add_editor_style( array( 'css/editor-style.css', get_template_directory_uri() . '/css/font-awesome.min.css' ) );

	// add content width
	global $content_width;
	if ( ! isset( $content_width ) ) {

		$content_width = 900;
	}

	// add custom header
    add_theme_support( 'custom-header', array (
                       'default-image'          => '',
                       'random-default'         => '',
                       'flex-height'            => true,
                       'flex-width'             => true,
                       'uploads'                => true,
                       'width'                  => 900,
                       'height'                 => 100,
                       'default-text-color'     => '#000000',
                       'wp-head-callback'       => 'fhomeopathy_header_style',
                    ) );

    // add custom logo
    add_theme_support( 'custom-logo', array (
                       'width'                  => 145,
                       'height'                 => 36,
                       'flex-height'            => true,
                       'flex-width'             => true,
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
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array( ) );
	wp_enqueue_style( 'fhomeopathy-style', get_stylesheet_uri(), array() );
	
	wp_enqueue_style( 'fhomeopathy-fonts', fhomeopathy_fonts_url(), array(), null );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	// Load Utilities JS Script
	wp_enqueue_script( 'fhomeopathy-js', get_template_directory_uri() . '/js/utilities.js', array( 'jquery' ) );	
}

add_action( 'wp_enqueue_scripts', 'fhomeopathy_load_scripts' );

function fhomeopathy_should_display_slider() {

	return is_front_page() && (fhomeopathy_get_slides_count() > 0);
}

function fhomeopathy_slides_json() {

	$result = array();
	for ( $i = 1; $i <= 3; ++$i ) {

		$defaultSlideImage = get_template_directory_uri().'/images/slider/' . $i .'.jpg';
		$slideImage = get_theme_mod( 'fhomeopathy_slide'.$i.'_image', $defaultSlideImage );

		if ( $slideImage != '' ) {

			$slide = array( 'slideImage' => $slideImage, );

			array_push($result, $slide);
		}
	}

	return json_encode($result);
}

function fhomeopathy_get_slides_count() {

	$result = 0;
	for ( $i = 1; $i <= 3; ++$i ) {

		$defaultSlideImage = get_template_directory_uri().'/images/slider/' . $i .'.jpg';
		$slideImage = get_theme_mod( 'fhomeopathy_slide'.$i.'_image', $defaultSlideImage );
		if ( $slideImage != '' ) {

			++$result;
		}
	}

	return $result;
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
function fhomeopathy_show_website_logo_image_and_title() {

	if ( has_custom_logo() ) {

        the_custom_logo();
    }

    $header_text_color = get_header_textcolor();

    if ( 'blank' !== $header_text_color ) {
    
        echo '<div id="site-identity">';
        echo '<a href="' . esc_url( home_url('/') ) . '" title="' . esc_attr( get_bloginfo('name') ) . '">';
        echo '<h1 class="entry-title">' . esc_html( get_bloginfo('name') ) . '</h1>';
        echo '</a>';
        echo '<strong>' . esc_html( get_bloginfo('description') ) . '</strong>';
        echo '</div>';
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

	// Register Footer Column #1
	register_sidebar( array (
							'name'			 =>  __( 'Footer Column #1', 'fhomeopathy' ),
							'id' 			 =>  'footer-column-1-widget-area',
							'description'	 =>  __( 'The Footer Column #1 widget area', 'fhomeopathy' ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="footer-title">',
							'after_title'	 =>  '</h2><div class="footer-after-title"></div>',
						) );
	
	// Register Footer Column #2
	register_sidebar( array (
							'name'			 =>  __( 'Footer Column #2', 'fhomeopathy' ),
							'id' 			 =>  'footer-column-2-widget-area',
							'description'	 =>  __( 'The Footer Column #2 widget area', 'fhomeopathy' ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="footer-title">',
							'after_title'	 =>  '</h2><div class="footer-after-title"></div>',
						) );
	
	// Register Footer Column #3
	register_sidebar( array (
							'name'			 =>  __( 'Footer Column #3', 'fhomeopathy' ),
							'id' 			 =>  'footer-column-3-widget-area',
							'description'	 =>  __( 'The Footer Column #3 widget area', 'fhomeopathy' ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="footer-title">',
							'after_title'	 =>  '</h2><div class="footer-after-title"></div>',
						) );
}
add_action( 'widgets_init', 'fhomeopathy_widgets_init' );

/**
 * Register theme settings in the customizer
 */
function fhomeopathy_customize_register( $wp_customize ) {

	/**
	 * Add Slider Section
	 */
	$wp_customize->add_section(
		'fhomeopathy_slider_section',
		array(
			'title'       => __( 'Header Slider', 'fhomeopathy' ),
			'capability'  => 'edit_theme_options',
		)
	);
	
	// Add slide 1 background image
	$wp_customize->add_setting( 'fhomeopathy_slide1_image',
		array(
			'default' => get_template_directory_uri().'/images/slider/' . '1.jpg',
    		'sanitize_callback' => 'esc_url_raw'
		)
	);

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fhomeopathy_slide1_image',
			array(
				'label'   	 => __( 'Slide 1 Image', 'fhomeopathy' ),
				'section' 	 => 'fhomeopathy_slider_section',
				'settings'   => 'fhomeopathy_slide1_image',
			) 
		)
	);
	
	// Add slide 2 background image
	$wp_customize->add_setting( 'fhomeopathy_slide2_image',
		array(
			'default' => get_template_directory_uri().'/images/slider/' . '2.jpg',
    		'sanitize_callback' => 'esc_url_raw'
		)
	);

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fhomeopathy_slide2_image',
			array(
				'label'   	 => __( 'Slide 2 Image', 'fhomeopathy' ),
				'section' 	 => 'fhomeopathy_slider_section',
				'settings'   => 'fhomeopathy_slide2_image',
			) 
		)
	);
	
	// Add slide 3 background image
	$wp_customize->add_setting( 'fhomeopathy_slide3_image',
		array(
			'default' => get_template_directory_uri().'/images/slider/' . '3.jpg',
    		'sanitize_callback' => 'esc_url_raw'
		)
	);

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fhomeopathy_slide3_image',
			array(
				'label'   	 => __( 'Slide 3 Image', 'fhomeopathy' ),
				'section' 	 => 'fhomeopathy_slider_section',
				'settings'   => 'fhomeopathy_slide3_image',
			) 
		)
	);

	/**
	 * Add Footer Section
	 */
	$wp_customize->add_section(
		'fhomeopathy_header_and_footer_settings',
		array(
			'title'       => __( 'Footer', 'fhomeopathy' ),
			'capability'  => 'edit_theme_options',
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

function fhomeopathy_header_style() {

    $header_text_color = get_header_textcolor();

    if ( ! has_header_image()
        && ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color
             || 'blank' === $header_text_color ) ) {

        return;
    }

    $headerImage = get_header_image();
?>
    <style type="text/css">
        <?php if ( has_header_image() ) : ?>

                #header-main-fixed {background-image: url("<?php echo esc_url( $headerImage ); ?>");}

        <?php endif; ?>

        <?php if ( get_theme_support( 'custom-header', 'default-text-color' ) !== $header_text_color
                    && 'blank' !== $header_text_color ) : ?>

                #header-main-fixed, #header-main-fixed h1.entry-title {color: #<?php echo esc_attr( $header_text_color ); ?>;}

        <?php endif; ?>
    </style>
<?php
}

?>
