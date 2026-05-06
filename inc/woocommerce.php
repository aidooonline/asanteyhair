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
        AH_VERSION
    );

    wp_enqueue_script(
        'ah-woocommerce-js',
        AH_ASSETS . '/js/woocommerce.js',
        [ 'jquery', 'ah-main-js' ],
        AH_VERSION,
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

add_action( 'woocommerce_before_main_content', function () {
    echo '<section class="s s--white wc-main"><div class="wrap wc-wrap">';
} );
add_action( 'woocommerce_after_main_content', function () {
    echo '</div></section>';
} );

/* ============================================================
   4. SHOP LOOP — product card tweaks
   ============================================================ */
// Remove default title + price from loop (we re-add in custom markup)
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

// Add category above title
add_action( 'woocommerce_shop_loop_item_title', function () {
    global $product;
    $cats = wc_get_product_category_list( $product->get_id(), ', ' );
    if ( $cats ) echo '<span class="wc-card__cat">' . strip_tags( $cats ) . '</span>';
    echo '<h3 class="wc-card__title">' . esc_html( get_the_title() ) . '</h3>';
}, 10 );

// Re-add price after title
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

// Product loop columns
add_filter( 'loop_shop_columns', fn() => 3 );

// Products per page
add_filter( 'loop_shop_per_page', fn() => 12 );

// Wrap loop item in our card class
add_action( 'woocommerce_before_shop_loop_item', function () {
    echo '<div class="wc-card">';
}, 5 );
add_action( 'woocommerce_after_shop_loop_item', function () {
    echo '</div>';
}, 20 );

// Add badge (sale / new)
add_action( 'woocommerce_before_shop_loop_item_title', function () {
    global $product;
    if ( $product->is_on_sale() ) {
        echo '<span class="wc-badge wc-badge--sale">Sale</span>';
    } elseif ( $product->is_featured() ) {
        echo '<span class="wc-badge wc-badge--new">Featured</span>';
    }
}, 5 );

/* ============================================================
   5. SINGLE PRODUCT TWEAKS
   ============================================================ */
// Move breadcrumb inside wrap
remove_action( 'woocommerce_before_single_product', 'woocommerce_breadcrumb', 20 );
add_action( 'woocommerce_before_single_product', function () {
    woocommerce_breadcrumb( [
        'delimiter'   => ' &rsaquo; ',
        'wrap_before' => '<nav class="wc-breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => 'Home',
    ] );
}, 5 );

// Add trust badges below Add to Cart
add_action( 'woocommerce_after_add_to_cart_form', function () {
    echo '<div class="wc-trust">
        <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>Secure Checkout</span>
        <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>Fast UK Dispatch</span>
        <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>Single Donor Hair</span>
        <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>3-5 Year Lifespan</span>
    </div>';
} );

// Add WhatsApp order option below Add to Cart
add_action( 'woocommerce_after_add_to_cart_form', function () {
    $number = get_theme_mod( 'ah_whatsapp_number', '' );
    if ( ! $number ) return;
    global $product;
    $msg = 'Hello! I would like to order: ' . get_the_title() . ' — ' . get_permalink();
    $url = 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $number ) . '?text=' . rawurlencode( $msg );
    echo '<a href="' . esc_url( $url ) . '" class="btn btn--wa wc-wa-btn" target="_blank" rel="noopener noreferrer">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        Order via WhatsApp
    </a>';
}, 15 );

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
    $count = WC()->cart->get_cart_contents_count();
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
   10. PRODUCT CATEGORY PAGE — use our page hero
   ============================================================ */
add_action( 'woocommerce_before_main_content', function () {
    if ( ! is_product_category() ) return;
    $cat  = get_queried_object();
    $thumb_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
    $img  = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'ah-wide' ) : '';
    echo '<div class="page-hero' . ( $img ? '' : ' page-hero--no-img' ) . '">';
    if ( $img ) echo '<img src="' . esc_url( $img ) . '" alt="' . esc_attr( $cat->name ) . '" class="page-hero__img">';
    echo '<div class="page-hero__overlay"></div>';
    echo '<div class="page-hero__content wrap">';
    echo '<h1 class="page-hero__title t-h1">' . esc_html( $cat->name ) . '</h1>';
    if ( $cat->description ) echo '<p class="page-hero__sub">' . esc_html( $cat->description ) . '</p>';
    echo '</div></div>';
}, 5 );

/* ============================================================
   11. AJAX — ADD TO CART RESPONSE
   ============================================================ */
add_action( 'wc_ajax_ah_refresh_cart', function () {
    check_ajax_referer( 'ah_wc_nonce', 'nonce' );
    WC()->cart->calculate_totals();
    wc_get_template( 'cart/mini-cart.php' );
    wp_die();
} );

/* ============================================================
   12. STOCK BADGE ON SINGLE PRODUCT
   ============================================================ */
add_action( 'woocommerce_single_product_summary', function () {
    global $product;
    if ( $product->managing_stock() ) {
        $qty = $product->get_stock_quantity();
        if ( $qty !== null && $qty <= 5 && $qty > 0 ) {
            echo '<p class="wc-low-stock">Only ' . esc_html( $qty ) . ' left in stock</p>';
        }
    }
}, 25 );

/* ============================================================
   13. RELATED PRODUCTS — limit to 3, one row
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
