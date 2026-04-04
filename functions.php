<?php
/**
 * Asantey Hair & Beauty — functions.php
 * Core theme setup, enqueue, auto-create pages, includes.
 */

defined( 'ABSPATH' ) || exit;

define( 'AH_VERSION',   '1.0.0' );
define( 'AH_DIR',       get_template_directory() );
define( 'AH_URI',       get_template_directory_uri() );
define( 'AH_ASSETS',    AH_URI . '/assets' );

/* ============================================================
   INCLUDES
   ============================================================ */
require_once AH_DIR . '/inc/customizer.php';
require_once AH_DIR . '/inc/custom-post-types.php';
require_once AH_DIR . '/inc/template-tags.php';
require_once AH_DIR . '/inc/seo.php';
require_once AH_DIR . '/inc/forms.php';
require_once AH_DIR . '/inc/meta-boxes.php';

// ACF fields — only if ACF is active
if ( function_exists( 'acf_add_local_field_group' ) ) {
    require_once AH_DIR . '/inc/acf-fields.php';
}

/* ============================================================
   THEME SETUP
   ============================================================ */
add_action( 'after_setup_theme', function () {

    load_theme_textdomain( 'asantey-theme', AH_DIR . '/languages' );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [
        'comment-list', 'comment-form', 'search-form',
        'gallery', 'caption', 'style', 'script',
    ] );
    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ] );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'wp-block-styles' );

    // Image sizes
    add_image_size( 'ah-product',    600,  800,  true );
    add_image_size( 'ah-hero',      1920,  1080, true );
    add_image_size( 'ah-gallery',    800,  1000, true );
    add_image_size( 'ah-thumb',      400,  500,  true );
    add_image_size( 'ah-wide',      1280,  720,  true );

    // Navigation menus
    register_nav_menus( [
        'primary'  => __( 'Primary Navigation', 'asantey-theme' ),
        'footer'   => __( 'Footer Navigation', 'asantey-theme' ),
        'products' => __( 'Products Navigation', 'asantey-theme' ),
    ] );

} );

/* ============================================================
   ENQUEUE SCRIPTS & STYLES
   ============================================================ */
add_action( 'wp_enqueue_scripts', function () {

    // Main CSS (font-face + component styles)
    wp_enqueue_style(
        'ah-main-css',
        AH_ASSETS . '/css/main.css',
        [],
        AH_VERSION
    );

    // Theme stylesheet (design system)
    wp_enqueue_style(
        'ah-theme',
        get_stylesheet_uri(),
        [ 'ah-main-css' ],
        AH_VERSION
    );

    // Main JS
    wp_enqueue_script(
        'ah-main-js',
        AH_ASSETS . '/js/main.js',
        [],
        AH_VERSION,
        true
    );

    // Pass PHP data to JS
    wp_localize_script( 'ah-main-js', 'ahData', [
        'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
        'nonce'      => wp_create_nonce( 'ah_forms_nonce' ),
        'whatsapp'   => esc_attr( get_theme_mod( 'ah_whatsapp_number', '' ) ),
        'themeUri'   => AH_URI,
    ] );

} );

/* ============================================================
   ELEMENTOR COMPATIBILITY
   ============================================================ */
add_action( 'elementor/theme/register_locations', function ( $elementor_theme_manager ) {
    $elementor_theme_manager->register_all_core_location();
} );

/* ============================================================
   WIDGET AREAS
   ============================================================ */
add_action( 'widgets_init', function () {

    $sidebar_args = [
        'before_widget' => '<div id="%1$s" class="ah-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="ah-widget__title">',
        'after_title'   => '</h3>',
    ];

    register_sidebar( array_merge( $sidebar_args, [
        'name' => __( 'Blog Sidebar', 'asantey-theme' ),
        'id'   => 'sidebar-blog',
    ] ) );

    register_sidebar( array_merge( $sidebar_args, [
        'name' => __( 'Footer Column 1', 'asantey-theme' ),
        'id'   => 'footer-1',
    ] ) );

} );

/* ============================================================
   AUTO-CREATE PAGES ON ACTIVATION
   ============================================================ */
function ah_create_pages() {
    $pages = [
        [
            'title'    => 'Salon Services',
            'slug'     => 'salon-services',
            'template' => 'page-templates/page-salon.php',
        ],
        [
            'title'    => 'Book Appointment',
            'slug'     => 'book-appointment',
            'template' => '',
        ],
        [
            'title'    => 'Home',
            'slug'     => 'home',
            'template' => '',
        ],
        [
            'title'    => 'About Us',
            'slug'     => 'about',
            'template' => 'page-templates/page-about.php',
        ],
        [
            'title'    => 'Shop',
            'slug'     => 'shop',
            'template' => 'page-templates/page-shop.php',
        ],
        [
            'title'    => 'Raw Hair',
            'slug'     => 'raw-hair',
            'template' => 'page-templates/page-raw-hair.php',
        ],
        [
            'title'    => 'Virgin Hair',
            'slug'     => 'virgin-hair',
            'template' => 'page-templates/page-virgin-hair.php',
        ],
        [
            'title'    => 'Closures & Frontals',
            'slug'     => 'closures-frontals',
            'template' => 'page-templates/page-closures.php',
        ],
        [
            'title'    => 'Client Gallery',
            'slug'     => 'gallery',
            'template' => 'page-templates/page-gallery.php',
        ],
        [
            'title'    => 'Hair Care Guide',
            'slug'     => 'hair-care-guide',
            'template' => 'page-templates/page-care-guide.php',
        ],
        [
            'title'    => 'FAQ',
            'slug'     => 'faq',
            'template' => 'page-templates/page-faq.php',
        ],
        [
            'title'    => 'Contact',
            'slug'     => 'contact',
            'template' => 'page-templates/page-contact.php',
        ],
        [
            'title'    => 'Order Enquiry',
            'slug'     => 'order',
            'template' => 'page-templates/page-order.php',
        ],
        [
            'title'    => 'Shipping & Returns',
            'slug'     => 'shipping-returns',
            'template' => 'page-templates/page-shipping.php',
        ],
        [
            'title'    => 'Privacy Policy',
            'slug'     => 'privacy-policy',
            'template' => 'page-templates/page-privacy.php',
        ],
        [
            'title'    => 'Terms & Conditions',
            'slug'     => 'terms-conditions',
            'template' => 'page-templates/page-terms.php',
        ],
    ];

    foreach ( $pages as $page ) {
        $existing = get_page_by_path( $page['slug'] );
        if ( $existing ) continue;

        $id = wp_insert_post( [
            'post_title'   => $page['title'],
            'post_name'    => $page['slug'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
        ] );

        if ( ! is_wp_error( $id ) && ! empty( $page['template'] ) ) {
            update_post_meta( $id, '_wp_page_template', $page['template'] );
        }
    }

    // Set front page
    $front = get_page_by_path( 'home' );
    if ( $front ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front->ID );
    }
}
add_action( 'after_switch_theme', 'ah_create_pages' );

/* ============================================================
   REMOVE EMOJI (PERFORMANCE)
   ============================================================ */
remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles',     'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles',  'print_emoji_styles' );

/* ============================================================
   CLEAN UP WP HEAD
   ============================================================ */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

/* ============================================================
   PRELOAD FONTS
   ============================================================ */
add_action( 'wp_head', function () {
    $fonts = [
        'cormorant-garamond-400-normal.woff2',
        'cormorant-garamond-400-italic.woff2',
        'jost-400-normal.woff2',
        'jost-500-normal.woff2',
    ];
    foreach ( $fonts as $font ) {
        echo '<link rel="preload" href="' . esc_url( AH_ASSETS . '/fonts/' . $font ) . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
    }
}, 1 );

/* ============================================================
   BODY CLASSES
   ============================================================ */
add_filter( 'body_class', function ( $classes ) {
    if ( is_singular() ) {
        $classes[] = 'ah-singular';
    }
    if ( is_front_page() ) {
        $classes[] = 'ah-front-page';
    }
    return $classes;
} );

/* ============================================================
   EXCERPT LENGTH
   ============================================================ */
add_filter( 'excerpt_length', fn() => 25 );
add_filter( 'excerpt_more', fn() => '&hellip;' );

/* ============================================================
   DISABLE GUTENBERG ON PAGES (use Elementor)
   ============================================================ */
add_filter( 'use_block_editor_for_post_type', function ( $use, $post_type ) {
    if ( 'page' === $post_type ) return false;
    return $use;
}, 10, 2 );
