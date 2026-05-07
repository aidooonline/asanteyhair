<?php
/**
 * Asantey Hair & Beauty — WooCommerce Integration
 * Full support layer: hooks, mini-cart, loop tweaks, checkout, My Account
 */

defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'WooCommerce' ) ) return;

/* ============================================================
   1. DECLARE WOOCOMMERCE SUPPORT
   ============================================================ */
add_action( 'after_setup_theme', function () {
    add_theme_support( 'woocommerce', [
        'thumbnail_image_width' => 600,
        'single_image_width'    => 900,
        'product_grid'          => [
            'default_rows'    => 4,
            'min_rows'        => 1,
            'max_rows'        => 8,
            'default_columns' => 3,
            'min_columns'     => 1,
            'max_columns'     => 4,
        ],
    ] );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
} );

/* ============================================================
   2. ENQUEUE WC SCRIPTS & STYLES
   ============================================================ */
add_action( 'wp_enqueue_scripts', function () {
    if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_account_page() ) return;

    wp_enqueue_style(
        'ah-woocommerce',
        AH_URI . '/assets/css/woocommerce.css',
        [ 'woocommerce-general', 'ah-theme' ],
        filemtime( AH_DIR . '/assets/css/woocommerce.css' )
    );

    wp_enqueue_script(
        'ah-woocommerce-js',
        AH_ASSETS . '/js/woocommerce.js',
        [ 'jquery', 'ah-main-js' ],
        filemtime( AH_DIR . '/assets/js/woocommerce.js' ),
        true
    );

    wp_localize_script( 'ah-woocommerce-js', 'ahWC', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'ah_wc_nonce' ),
        'cartUrl' => wc_get_cart_url(),
    ] );
}, 20 );

/* ============================================================
   3. REMOVE DEFAULT WC WRAPPERS — we use our own layout
   ============================================================ */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// Wrapper for cart / checkout / my account (these use WC default rendering)
// Archive and single product have fully custom templates so no wrapper needed there
add_action( 'woocommerce_before_main_content', function () {
    if ( is_shop() || is_product_category() || is_product() ) return;
    echo '<section class="s s--white wc-main"><div class="wrap wc-wrap">';
} );
add_action( 'woocommerce_after_main_content', function () {
    if ( is_shop() || is_product_category() || is_product() ) return;
    echo '</div></section>';
} );

/* ============================================================
   4. SHOP LOOP — column count and per-page only
   (card markup is handled directly in woocommerce/archive-product.php)
   ============================================================ */
add_filter( 'loop_shop_columns',  fn() => 3 );
add_filter( 'loop_shop_per_page', fn() => 12 );

/* ============================================================
   5. SINGLE PRODUCT TWEAKS
   ============================================================ */
/* Breadcrumb is rendered directly in woocommerce/single-product.php */
remove_action( 'woocommerce_before_single_product', 'woocommerce_breadcrumb', 20 );

/* ============================================================
   6. MINI-CART / CART ICON IN HEADER
   ============================================================ */
add_action( 'wp_footer', function () {
    if ( ! is_cart() && ! is_checkout() ) : ?>
    <div class="ah-mini-cart" id="ah-mini-cart" aria-label="Mini cart" role="dialog" aria-modal="true">
        <div class="ah-mini-cart__inner">
            <div class="ah-mini-cart__head">
                <span class="ah-mini-cart__title">Your Bag</span>
                <button class="ah-mini-cart__close" id="ah-mini-cart-close" aria-label="Close cart">&times;</button>
            </div>
            <div class="ah-mini-cart__body" id="ah-mini-cart-body">
                <?php woocommerce_mini_cart(); ?>
            </div>
        </div>
    </div>
    <div class="ah-mini-cart__overlay" id="ah-mini-cart-overlay"></div>
    <?php endif;
} );

// AJAX refresh mini-cart fragment
add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
    ob_start();
    woocommerce_mini_cart();
    $fragments['#ah-mini-cart-body'] = '<div class="ah-mini-cart__body" id="ah-mini-cart-body">' . ob_get_clean() . '</div>';

    // Cart count bubble
    $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
    $fragments['.ah-cart-count'] = '<span class="ah-cart-count' . ( $count ? ' has-items' : '' ) . '">' . $count . '</span>';

    return $fragments;
} );

/* ============================================================
   7. CHECKOUT TWEAKS
   ============================================================ */
// Reorder checkout fields
add_filter( 'woocommerce_checkout_fields', function ( $fields ) {
    // Move phone to top of billing
    $fields['billing']['billing_phone']['priority'] = 5;
    $fields['billing']['billing_email']['priority'] = 10;
    $fields['billing']['billing_first_name']['priority'] = 15;
    $fields['billing']['billing_last_name']['priority'] = 20;
    return $fields;
} );

// Remove unneeded checkout fields
add_filter( 'woocommerce_checkout_fields', function ( $fields ) {
    unset( $fields['billing']['billing_company'] );
    unset( $fields['billing']['billing_address_2'] );
    return $fields;
} );

// Custom order notes placeholder
add_filter( 'woocommerce_checkout_fields', function ( $fields ) {
    $fields['order']['order_comments']['placeholder'] = 'Any special requests? Texture preferences, urgency, or anything else?';
    $fields['order']['order_comments']['label']       = 'Order Notes (optional)';
    return $fields;
} );

/* ============================================================
   8. MY ACCOUNT TWEAKS
   ============================================================ */
// Custom My Account menu order
add_filter( 'woocommerce_account_menu_items', function ( $items ) {
    return [
        'dashboard'       => 'Dashboard',
        'orders'          => 'My Orders',
        'downloads'       => 'Downloads',
        'edit-address'    => 'Addresses',
        'edit-account'    => 'Account Details',
        'customer-logout' => 'Log Out',
    ];
} );

/* ============================================================
   9. BREADCRUMB STYLING
   ============================================================ */
add_filter( 'woocommerce_breadcrumb_defaults', function ( $defaults ) {
    $defaults['delimiter']   = ' &rsaquo; ';
    $defaults['wrap_before'] = '<nav class="wc-breadcrumb" aria-label="Breadcrumb">';
    $defaults['wrap_after']  = '</nav>';
    return $defaults;
} );

/* ============================================================
/* ============================================================
   10. PRODUCT CATEGORY PAGE
   Hero is handled directly in woocommerce/archive-product.php
   ============================================================ */

/* ============================================================
   11. AJAX — ADD TO CART RESPONSE
   ============================================================ */
add_action( 'wc_ajax_ah_refresh_cart', function () {
    check_ajax_referer( 'ah_wc_nonce', 'nonce' );
    WC()->cart->calculate_totals();
    wc_get_template( 'cart/mini-cart.php' );
    wp_die();
} );

/* Stock badge rendered directly in woocommerce/single-product.php */

/* ============================================================
   12. RELATED PRODUCTS — limit to 3, one row
   ============================================================ */
add_filter( 'woocommerce_output_related_products_args', fn() => [
    'posts_per_page' => 3,
    'columns'        => 3,
    'orderby'        => 'rand',
] );

/* ============================================================
   14. DISABLE WC STYLESHEETS WE OVERRIDE
   ============================================================ */
add_filter( 'woocommerce_enqueue_styles', function ( $enqueue_styles ) {
    // Keep core styles, remove layout ones we override
    unset( $enqueue_styles['woocommerce-layout'] );
    unset( $enqueue_styles['woocommerce-smallscreen'] );
    return $enqueue_styles;
} );

/* ============================================================
   15. CART PAGE — empty cart CTA
   ============================================================ */
add_action( 'woocommerce_cart_is_empty', function () {
    echo '<div class="wc-empty-cart">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        <h2>Your bag is empty</h2>
        <p>Discover our premium Cambodian hair collections.</p>
        <a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '" class="btn btn--w">Shop Collections</a>
    </div>';
} );
