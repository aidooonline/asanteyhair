<?php
/**
 * Asantey Hair & Beauty — Customizer Settings
 */

defined( 'ABSPATH' ) || exit;

add_action( 'customize_register', function ( WP_Customize_Manager $wp_customize ) {

    /* ========================================================
       HELPER — add a text setting + control
       ======================================================== */
    $text = function (
        $id, $label, $section, $default = '', $type = 'text'
    ) use ( $wp_customize ) {
        $wp_customize->add_setting( $id, [
            'default'           => $default,
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ] );
        $wp_customize->add_control( $id, [
            'label'   => $label,
            'section' => $section,
            'type'    => $type,
        ] );
    };

    $textarea = function ( $id, $label, $section, $default = '' ) use ( $wp_customize ) {
        $wp_customize->add_setting( $id, [
            'default'           => $default,
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'refresh',
        ] );
        $wp_customize->add_control( $id, [
            'label'   => $label,
            'section' => $section,
            'type'    => 'textarea',
        ] );
    };

    $url = function ( $id, $label, $section, $default = '' ) use ( $wp_customize ) {
        $wp_customize->add_setting( $id, [
            'default'           => $default,
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ] );
        $wp_customize->add_control( $id, [
            'label'   => $label,
            'section' => $section,
            'type'    => 'url',
        ] );
    };

    $color = function ( $id, $label, $section, $default = '' ) use ( $wp_customize ) {
        $wp_customize->add_setting( $id, [
            'default'           => $default,
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ] );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, [
            'label'   => $label,
            'section' => $section,
        ] ) );
    };

    $image = function ( $id, $label, $section ) use ( $wp_customize ) {
        $wp_customize->add_setting( $id, [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ] );
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, [
            'label'   => $label,
            'section' => $section,
        ] ) );
    };

    /* ========================================================
       PANEL: ASANTEY SETTINGS
       ======================================================== */
    $wp_customize->add_panel( 'ah_panel', [
        'title'       => 'Asantey Hair & Beauty',
        'description' => 'All theme settings for Asantey Hair & Beauty.',
        'priority'    => 10,
    ] );

    /* --------------------------------------------------------
       SECTION: HERO
       -------------------------------------------------------- */
    $wp_customize->add_section( 'ah_hero', [
        'title' => 'Hero Section',
        'panel' => 'ah_panel',
    ] );

    $text(  'ah_hero_label',    'Label (above title)',       'ah_hero', 'Premium Cambodian Hair Extensions' );
    $text(  'ah_hero_title',    'Main Title',                'ah_hero', 'Luxury Hair. Real Results.' );
    $text(  'ah_hero_subtitle', 'Subtitle',                  'ah_hero', 'Cambodian Raw & Virgin Hair Extensions — crafted for women who demand quality that lasts 3-5 years.' );
    $text(  'ah_hero_cta1_text','CTA Button 1 Text',         'ah_hero', 'Shop Collections' );
    $url(   'ah_hero_cta1_url', 'CTA Button 1 URL',          'ah_hero', '/shop/' );
    $text(  'ah_hero_cta2_text','CTA Button 2 Text',         'ah_hero', 'Order via WhatsApp' );
    $image( 'ah_hero_image',    'Hero Background Image',     'ah_hero' );

    /* --------------------------------------------------------
       SECTION: CONTACT DETAILS
       -------------------------------------------------------- */
    $wp_customize->add_section( 'ah_contact', [
        'title' => 'Contact Details',
        'panel' => 'ah_panel',
    ] );

    $text(     'ah_contact_name',    'Business Name',       'ah_contact', 'Asantey Hair & Beauty' );
    $text(     'ah_contact_phone',   'Phone Number',        'ah_contact', '07827 129797' );
    $text(     'ah_contact_email',   'Email Address',       'ah_contact', '' );
    $text(     'ah_whatsapp_number', 'WhatsApp Number (international format, e.g. 447911123456)', 'ah_contact', '447827129797' );
    $textarea( 'ah_contact_address', 'Full Address',        'ah_contact', '358 Radford Road, Nottingham, NG7 5GQ' );
    $text(     'ah_contact_hours',   'Business Hours',      'ah_contact', 'Mon–Sat: 9am–7pm' );
    $url(      'ah_contact_map',     'Google Maps Embed URL (iframe src)', 'ah_contact', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2403.8!2d-1.165!3d52.965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4879c13b!2s358+Radford+Road+Nottingham+NG7+5GQ!5e0!3m2!1sen!2suk!4v1' );
    $text(     'ah_contact_city',    'City / Region',       'ah_contact', 'Nottingham, UK' );
    $url(      'ah_booking_url',     'Booking Link (Acuity/Calendly)',     'ah_contact', 'https://asanteyhair.as.me/' );

    /* --------------------------------------------------------
       SECTION: SOCIAL MEDIA
       -------------------------------------------------------- */
    $wp_customize->add_section( 'ah_social', [
        'title' => 'Social Media',
        'panel' => 'ah_panel',
    ] );

    $url( 'ah_social_instagram', 'Instagram URL', 'ah_social', 'https://www.instagram.com/ahb_salon' );
    $url( 'ah_social_facebook',  'Facebook URL',  'ah_social', '' );
    $url( 'ah_social_tiktok',    'TikTok URL',    'ah_social', 'https://www.tiktok.com/@ahbsalon' );
    $url( 'ah_social_youtube',   'YouTube URL',   'ah_social', '' );

    /* --------------------------------------------------------
       SECTION: FOOTER
       -------------------------------------------------------- */
    $wp_customize->add_section( 'ah_footer', [
        'title' => 'Footer',
        'panel' => 'ah_panel',
    ] );

    $text(     'ah_footer_tagline',   'Brand Tagline',  'ah_footer', 'Premium Hair. Unmatched Quality. Timeless Beauty.' );
    $text(     'ah_footer_copyright', 'Copyright Text', 'ah_footer', '© ' . date( 'Y' ) . ' Asantey Hair & Beauty. All Rights Reserved.' );

    /* --------------------------------------------------------
       SECTION: BRAND COLORS
       -------------------------------------------------------- */
    $wp_customize->add_section( 'ah_colors', [
        'title' => 'Brand Color Overrides',
        'panel' => 'ah_panel',
    ] );

    $color( 'ah_color_primary',   'Primary (near black)',     'ah_colors', '#1a1a1a' );
    $color( 'ah_color_gold',      'Gold (secondary)',         'ah_colors', '#c9a47e' );
    $color( 'ah_color_gold_dark', 'Gold Dark',                'ah_colors', '#a8824f' );
    $color( 'ah_color_cream',     'Cream (accent)',           'ah_colors', '#f5e6d3' );
    $color( 'ah_color_white',     'Background White',         'ah_colors', '#fafafa' );
    $color( 'ah_color_text',      'Body Text',                'ah_colors', '#1a1a1a' );
    $color( 'ah_color_grey',      'Grey (muted text)',        'ah_colors', '#888888' );

    /* --------------------------------------------------------
       PRICING — RAW HAIR
       -------------------------------------------------------- */
    $wp_customize->add_section( 'ah_price_raw', [
        'title' => 'Pricing: Raw Hair Bundles',
        'panel' => 'ah_panel',
    ] );

    $raw_defaults = [
        '10' => '60', '12' => '63', '14' => '69', '16' => '75',
        '18' => '80', '20' => '88', '22' => '95', '24' => '100',
        '26' => '105','28' => '110','30' => '120',
    ];
    foreach ( $raw_defaults as $len => $price ) {
        $text( "ah_price_raw_{$len}", "{$len}\" — Price (£)", 'ah_price_raw', $price );
    }

    /* --------------------------------------------------------
       PRICING — VIRGIN HAIR
       -------------------------------------------------------- */
    $wp_customize->add_section( 'ah_price_virgin', [
        'title' => 'Pricing: Virgin Hair Bundles',
        'panel' => 'ah_panel',
    ] );

    $virgin_defaults = [
        '10' => '50', '12' => '53', '14' => '59', '16' => '65',
        '18' => '70', '20' => '78', '22' => '85', '24' => '90',
        '26' => '95', '28' => '100','30' => '110',
    ];
    foreach ( $virgin_defaults as $len => $price ) {
        $text( "ah_price_virgin_{$len}", "{$len}\" — Price (£)", 'ah_price_virgin', $price );
    }

    /* --------------------------------------------------------
       PRICING — 2x6 CLOSURE
       -------------------------------------------------------- */
    $wp_customize->add_section( 'ah_price_2x6', [
        'title' => 'Pricing: 2x6 Closure',
        'panel' => 'ah_panel',
    ] );
    $c2x6 = [ '12'=>'49','14'=>'51','16'=>'53','18'=>'58','20'=>'61','22'=>'67' ];
    foreach ( $c2x6 as $len => $price ) {
        $text( "ah_price_2x6_{$len}", "{$len}\" — Price (£)", 'ah_price_2x6', $price );
    }

    /* --------------------------------------------------------
       PRICING — 4x4 CLOSURE
       -------------------------------------------------------- */
    $wp_customize->add_section( 'ah_price_4x4', [
        'title' => 'Pricing: 4x4 Closure',
        'panel' => 'ah_panel',
    ] );
    $c4x4 = [ '12'=>'51','14'=>'53','16'=>'56','18'=>'62','20'=>'68','22'=>'72' ];
    foreach ( $c4x4 as $len => $price ) {
        $text( "ah_price_4x4_{$len}", "{$len}\" — Price (£)", 'ah_price_4x4', $price );
    }

    /* --------------------------------------------------------
       PRICING — 5x5 CLOSURE
       -------------------------------------------------------- */
    $wp_customize->add_section( 'ah_price_5x5', [
        'title' => 'Pricing: 5x5 Closure',
        'panel' => 'ah_panel',
    ] );
    $c5x5 = [ '12'=>'61','14'=>'65','16'=>'68','18'=>'75','20'=>'80','22'=>'90' ];
    foreach ( $c5x5 as $len => $price ) {
        $text( "ah_price_5x5_{$len}", "{$len}\" — Price (£)", 'ah_price_5x5', $price );
    }

    /* --------------------------------------------------------
       PRICING — 6x6 CLOSURE
       -------------------------------------------------------- */
    $wp_customize->add_section( 'ah_price_6x6', [
        'title' => 'Pricing: 6x6 Closure',
        'panel' => 'ah_panel',
    ] );
    $c6x6 = [ '12'=>'72','14'=>'77','16'=>'83','18'=>'90','20'=>'97','22'=>'107' ];
    foreach ( $c6x6 as $len => $price ) {
        $text( "ah_price_6x6_{$len}", "{$len}\" — Price (£)", 'ah_price_6x6', $price );
    }

    /* --------------------------------------------------------
       PRICING — 13x4 FRONTAL
       -------------------------------------------------------- */
    $wp_customize->add_section( 'ah_price_13x4', [
        'title' => 'Pricing: 13x4 Frontal',
        'panel' => 'ah_panel',
    ] );
    $f13x4 = [ '12'=>'80','14'=>'85','16'=>'90','18'=>'99','20'=>'107','22'=>'117' ];
    foreach ( $f13x4 as $len => $price ) {
        $text( "ah_price_13x4_{$len}", "{$len}\" — Price (£)", 'ah_price_13x4', $price );
    }

    /* --------------------------------------------------------
       PRICING — 13x6 FRONTAL
       -------------------------------------------------------- */
    $wp_customize->add_section( 'ah_price_13x6', [
        'title' => 'Pricing: 13x6 Frontal',
        'panel' => 'ah_panel',
    ] );
    $f13x6 = [ '12'=>'81','14'=>'85','16'=>'94','18'=>'103','20'=>'112','22'=>'124' ];
    foreach ( $f13x6 as $len => $price ) {
        $text( "ah_price_13x6_{$len}", "{$len}\" — Price (£)", 'ah_price_13x6', $price );
    }

} );

/* ============================================================
   OUTPUT CUSTOMIZER COLOR OVERRIDES AS CSS VARS
   ============================================================ */
add_action( 'wp_head', function () {
    $colors = [
        '--ah-black'      => get_theme_mod( 'ah_color_primary',   '#1a1a1a' ),
        '--ah-gold'       => get_theme_mod( 'ah_color_gold',       '#c9a47e' ),
        '--ah-gold-dark'  => get_theme_mod( 'ah_color_gold_dark',  '#a8824f' ),
        '--ah-cream'      => get_theme_mod( 'ah_color_cream',      '#f5e6d3' ),
        '--ah-white'      => get_theme_mod( 'ah_color_white',      '#fafafa' ),
    ];
    echo '<style id="ah-customizer-vars">:root{';
    foreach ( $colors as $var => $val ) {
        if ( $val ) echo esc_attr( $var ) . ':' . esc_attr( $val ) . ';';
    }
    echo '}</style>' . "\n";
}, 99 );

/* ============================================================
   HELPER — GET PRICING TABLE DATA
   ============================================================ */
function ah_get_pricing( string $type ): array {
    $defaults = [
        'raw'   => ['10'=>'60','12'=>'63','14'=>'69','16'=>'75','18'=>'80','20'=>'88','22'=>'95','24'=>'100','26'=>'105','28'=>'110','30'=>'120'],
        'virgin'=> ['10'=>'50','12'=>'53','14'=>'59','16'=>'65','18'=>'70','20'=>'78','22'=>'85','24'=>'90','26'=>'95','28'=>'100','30'=>'110'],
        '2x6'   => ['12'=>'49','14'=>'51','16'=>'53','18'=>'58','20'=>'61','22'=>'67'],
        '4x4'   => ['12'=>'51','14'=>'53','16'=>'56','18'=>'62','20'=>'68','22'=>'72'],
        '5x5'   => ['12'=>'61','14'=>'65','16'=>'68','18'=>'75','20'=>'80','22'=>'90'],
        '6x6'   => ['12'=>'72','14'=>'77','16'=>'83','18'=>'90','20'=>'97','22'=>'107'],
        '13x4'  => ['12'=>'80','14'=>'85','16'=>'90','18'=>'99','20'=>'107','22'=>'117'],
        '13x6'  => ['12'=>'81','14'=>'85','16'=>'94','18'=>'103','20'=>'112','22'=>'124'],
    ];

    if ( ! isset( $defaults[ $type ] ) ) return [];

    $rows = [];
    foreach ( $defaults[ $type ] as $len => $def_price ) {
        $rows[ $len ] = get_theme_mod( "ah_price_{$type}_{$len}", $def_price );
    }
    return $rows;
}

/* ============================================================
   HELPER — GET WHATSAPP ORDER URL
   ============================================================ */
function ah_whatsapp_url( string $message = '' ): string {
    $number = get_theme_mod( 'ah_whatsapp_number', '' );
    if ( ! $number ) return '#';
    $msg = $message ?: 'Hello! I would like to place an order with Asantey Hair & Beauty.';
    return 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $number ) . '?text=' . rawurlencode( $msg );
}
