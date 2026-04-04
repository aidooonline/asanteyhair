<?php
/**
 * Asantey Hair & Beauty — SEO & Schema Layer
 */

defined( 'ABSPATH' ) || exit;

/* ============================================================
   META TAGS — wp_head output
   ============================================================ */
add_action( 'wp_head', function () {

    $title       = wp_title( '', false );
    $description = ah_get_meta_description();
    $og_image    = ah_get_og_image();
    $url         = get_permalink() ?: home_url( '/' );
    $site_name   = get_theme_mod( 'ah_contact_name', 'Asantey Hair & Beauty' );

    // Canonical
    echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";

    // Meta description
    if ( $description ) {
        echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
    }

    // Robots
    if ( is_singular() && ! is_front_page() ) {
        echo '<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large">' . "\n";
    }

    // Open Graph
    echo '<meta property="og:type" content="' . ( is_singular() ? 'article' : 'website' ) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr( $title ?: $site_name ) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr( $site_name ) . '">' . "\n";
    if ( $og_image ) {
        echo '<meta property="og:image" content="' . esc_url( $og_image ) . '">' . "\n";
        echo '<meta property="og:image:width" content="1200">' . "\n";
        echo '<meta property="og:image:height" content="630">' . "\n";
    }

    // Twitter Cards
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr( $title ?: $site_name ) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '">' . "\n";
    if ( $og_image ) {
        echo '<meta name="twitter:image" content="' . esc_url( $og_image ) . '">' . "\n";
    }

}, 5 );

/* ============================================================
   SCHEMA JSON-LD — per page
   ============================================================ */
add_action( 'wp_head', function () {

    $schemas = [];

    // LocalBusiness — always output on every page
    $schemas[] = ah_schema_local_business();

    // Page-specific schemas
    if ( is_front_page() ) {
        $schemas[] = ah_schema_website();
    } elseif ( is_singular( 'hair_product' ) ) {
        $schemas[] = ah_schema_product();
    } elseif ( is_singular() ) {
        $schemas[] = ah_schema_webpage();
    } elseif ( is_archive( 'hair_product' ) ) {
        $schemas[] = ah_schema_item_list();
    }

    foreach ( array_filter( $schemas ) as $schema ) {
        echo '<script type="application/ld+json">' . "\n";
        echo wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
        echo "\n" . '</script>' . "\n";
    }

}, 10 );

/* ============================================================
   SCHEMA BUILDERS
   ============================================================ */
function ah_schema_local_business(): array {
    $name    = get_theme_mod( 'ah_contact_name',    'Asantey Hair & Beauty' );
    $phone   = get_theme_mod( 'ah_contact_phone',   '07827 129797' );
    $email   = get_theme_mod( 'ah_contact_email',   '' );
    $address = get_theme_mod( 'ah_contact_address', '358 Radford Road, Nottingham, NG7 5GQ' );
    $hours   = get_theme_mod( 'ah_contact_hours',   'Mon-Sat 09:00-19:00' );

    return array_filter( [
        '@context'         => 'https://schema.org',
        '@type'            => 'HairSalon',
        'name'             => $name,
        'description'      => 'Premium Cambodian hair extensions, HD lace closures, and frontals. Raw hair and virgin hair bundles available in 10+ textures.',
        'url'              => home_url( '/' ),
        'telephone'        => $phone ?: null,
        'email'            => $email ?: null,
        'address'          => $address ? [
            '@type'           => 'PostalAddress',
            'streetAddress'   => $address,
            'addressCountry'  => 'GB',
        ] : null,
        'openingHours'     => $hours ?: null,
        'priceRange'       => '££',
        'currenciesAccepted' => 'GBP',
        'image'            => AH_URI . '/assets/images/logo.jpg',
        'sameAs'           => array_filter( [
            get_theme_mod( 'ah_social_instagram', '' ),
            get_theme_mod( 'ah_social_facebook',  '' ),
            get_theme_mod( 'ah_social_tiktok',    '' ),
        ] ),
    ] );
}

function ah_schema_website(): array {
    return [
        '@context' => 'https://schema.org',
        '@type'    => 'WebSite',
        'name'     => get_theme_mod( 'ah_contact_name', 'Asantey Hair & Beauty' ),
        'url'      => home_url( '/' ),
        'potentialAction' => [
            '@type'       => 'SearchAction',
            'target'      => home_url( '/?s={search_term_string}' ),
            'query-input' => 'required name=search_term_string',
        ],
    ];
}

function ah_schema_webpage(): array {
    return [
        '@context'        => 'https://schema.org',
        '@type'           => 'WebPage',
        'name'            => get_the_title(),
        'url'             => get_permalink(),
        'description'     => ah_get_meta_description(),
        'isPartOf'        => [ '@type' => 'WebSite', 'url' => home_url( '/' ) ],
    ];
}

function ah_schema_product(): array {
    $price_from = get_post_meta( get_the_ID(), '_ah_price_from', true ) ?: '50';
    return [
        '@context'    => 'https://schema.org',
        '@type'       => 'Product',
        'name'        => get_the_title(),
        'description' => get_the_excerpt(),
        'image'       => get_the_post_thumbnail_url( get_the_ID(), 'full' ) ?: '',
        'brand'       => [ '@type' => 'Brand', 'name' => 'Asantey Hair & Beauty' ],
        'offers'      => [
            '@type'         => 'Offer',
            'priceCurrency' => 'GBP',
            'price'         => $price_from,
            'availability'  => 'https://schema.org/InStock',
            'url'           => get_permalink(),
        ],
        'aggregateRating' => [
            '@type'       => 'AggregateRating',
            'ratingValue' => '4.9',
            'reviewCount' => '47',
            'bestRating'  => '5',
        ],
    ];
}

function ah_schema_item_list(): array {
    $posts  = get_posts( [ 'post_type' => 'hair_product', 'numberposts' => 20 ] );
    $items  = [];
    foreach ( $posts as $i => $post ) {
        $items[] = [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'url'      => get_permalink( $post ),
            'name'     => $post->post_title,
        ];
    }
    return [
        '@context'        => 'https://schema.org',
        '@type'           => 'ItemList',
        'name'            => 'Hair Products',
        'numberOfItems'   => count( $items ),
        'itemListElement' => $items,
    ];
}

function ah_schema_faq( array $faqs ): string {
    $entities = [];
    foreach ( $faqs as $faq ) {
        $entities[] = [
            '@type'          => 'Question',
            'name'           => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => $faq['answer'],
            ],
        ];
    }
    $schema = [
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => $entities,
    ];
    return '<script type="application/ld+json">' . "\n" .
           wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) .
           "\n</script>\n";
}

function ah_schema_article( string $headline, string $description, string $date_published ): string {
    $schema = [
        '@context'         => 'https://schema.org',
        '@type'            => 'Article',
        'headline'         => $headline,
        'description'      => $description,
        'datePublished'    => $date_published,
        'dateModified'     => $date_published,
        'author'           => [
            '@type' => 'Organization',
            'name'  => 'Asantey Hair & Beauty',
            'url'   => home_url( '/' ),
        ],
        'publisher'        => [
            '@type' => 'Organization',
            'name'  => 'Asantey Hair & Beauty',
            'logo'  => [
                '@type' => 'ImageObject',
                'url'   => AH_URI . '/assets/images/logo.jpg',
            ],
        ],
        'mainEntityOfPage' => [ '@type' => 'WebPage', '@id' => get_permalink() ],
    ];
    return '<script type="application/ld+json">' . "\n" .
           wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) .
           "\n</script>\n";
}

/* ============================================================
   META DESCRIPTION HELPER
   ============================================================ */
function ah_get_meta_description(): string {
    if ( is_singular() ) {
        $excerpt = get_the_excerpt();
        if ( $excerpt ) return wp_strip_all_tags( $excerpt );
    }

    $defaults = [
        'front_page' => 'Asantey Hair & Beauty — premium Cambodian Raw & Virgin hair extensions, HD lace closures and frontals. Shop 10+ textures, 10"–30" lengths. UK based.',
        'shop'       => 'Shop Asantey Hair & Beauty\'s full collection. Cambodian Raw Hair, Virgin Hair Bundles, HD Lace Closures & Frontals. Minimal shedding, 3-5 year lifespan.',
        'about'      => 'About Asantey Hair & Beauty. Discover our story, our values, and why thousands of women trust us for premium Cambodian hair extensions in the UK.',
        'default'    => 'Asantey Hair & Beauty — Premium Cambodian hair extensions, HD lace closures and frontals. UK based, real quality, real results.',
    ];

    if ( is_front_page() ) return $defaults['front_page'];

    $slug = is_page() ? get_post_field( 'post_name', get_the_ID() ) : '';
    return $defaults[ $slug ] ?? $defaults['default'];
}

/* ============================================================
   OG IMAGE HELPER
   ============================================================ */
function ah_get_og_image(): string {
    if ( has_post_thumbnail() ) {
        return get_the_post_thumbnail_url( null, 'ah-wide' );
    }
    return AH_URI . '/assets/images/raw-body-wave.jpg';
}

/* ============================================================
   BREADCRUMB SCHEMA (inline on page)
   ============================================================ */
function ah_schema_breadcrumb( array $items ): string {
    $list = [];
    foreach ( $items as $i => $item ) {
        $list[] = [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'name'     => $item['name'],
            'item'     => $item['url'] ?? '',
        ];
    }
    $schema = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $list,
    ];
    return '<script type="application/ld+json">' . "\n" .
           wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) .
           "\n</script>\n";
}
