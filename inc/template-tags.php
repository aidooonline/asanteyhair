<?php
/**
 * Asantey Hair & Beauty — Template Tags & Helpers
 */

defined( 'ABSPATH' ) || exit;

/* ============================================================
   SVG ICONS
   ============================================================ */
function ah_svg( string $icon, string $class = '' ): string {
    $cls = $class ? ' class="' . esc_attr( $class ) . '"' : '';

    $icons = [
        'whatsapp' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.117.552 4.103 1.516 5.833L.057 23.454a.5.5 0 0 0 .611.61l5.585-1.463A11.955 11.955 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 0 1-5.006-1.373l-.36-.214-3.716.974.99-3.615-.234-.372A9.817 9.817 0 0 1 2.182 12c0-5.414 4.404-9.818 9.818-9.818 5.414 0 9.818 4.404 9.818 9.818 0 5.414-4.404 9.818-9.818 9.818z"/></svg>',

        'instagram' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',

        'facebook' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',

        'tiktok' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>',

        'youtube' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',

        'phone' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.44 2 2 0 0 1 3.6 1.27h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.9a16 16 0 0 0 6.08 6.08l.91-.91a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',

        'mail' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',

        'location' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',

        'clock' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',

        'star' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>',

        'check' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>',

        'arrow-down' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>',

        'arrow-right' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>',

        'plus' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>',

        'gem' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="6 3 18 3 22 9 12 22 2 9"/><line x1="2" y1="9" x2="22" y2="9"/><line x1="12" y1="3" x2="6" y2="9"/><line x1="12" y1="3" x2="18" y2="9"/></svg>',

        'shield' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',

        'heart' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',

        'sparkle' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L9.5 9.5 2 12l7.5 2.5L12 22l2.5-7.5L22 12l-7.5-2.5L12 2z"/></svg>',

        'close' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',

        'chevron-left'  => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>',
        'chevron-right' => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>',
        'menu'          => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>',
        'zoom'          => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>',
        'truck'         => '<svg' . $cls . ' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>',
    ];

    return $icons[ $icon ] ?? '';
}

/* ============================================================
   BREADCRUMB
   ============================================================ */
function ah_breadcrumb(): void {
    $items = [];

    $items[] = '<a href="' . esc_url( home_url('/') ) . '">Home</a>';

    if ( is_singular( 'hair_product' ) ) {
        $items[] = '<a href="' . esc_url( home_url('/shop/') ) . '">Shop</a>';
        $terms   = get_the_terms( get_the_ID(), 'hair_category' );
        if ( $terms && ! is_wp_error( $terms ) ) {
            $items[] = esc_html( $terms[0]->name );
        }
        $items[] = '<span class="breadcrumb__current">' . esc_html( get_the_title() ) . '</span>';
    } elseif ( is_page() ) {
        $ancestors = get_post_ancestors( get_the_ID() );
        foreach ( array_reverse( $ancestors ) as $ancestor_id ) {
            $items[] = '<a href="' . esc_url( get_permalink( $ancestor_id ) ) . '">' . esc_html( get_the_title( $ancestor_id ) ) . '</a>';
        }
        $items[] = '<span class="breadcrumb__current">' . esc_html( get_the_title() ) . '</span>';
    } elseif ( is_archive() ) {
        $items[] = '<span class="breadcrumb__current">' . esc_html( get_the_archive_title() ) . '</span>';
    } elseif ( is_search() ) {
        $items[] = '<span class="breadcrumb__current">Search: ' . esc_html( get_search_query() ) . '</span>';
    } elseif ( is_404() ) {
        $items[] = '<span class="breadcrumb__current">Page Not Found</span>';
    }

    echo '<nav class="breadcrumb" aria-label="Breadcrumb">';
    echo implode( '<span class="breadcrumb__sep">&#8250;</span>', $items );
    echo '</nav>';
}

/* ============================================================
   PRICING TABLE RENDERER
   ============================================================ */
function ah_pricing_table( string $type, string $caption = '', string $note = '' ): void {
    $rows = ah_get_pricing( $type );
    if ( ! $rows ) return;

    // Get from-price
    $prices = array_values( $rows );
    $from   = min( array_map( 'floatval', $prices ) );

    echo '<div class="price-wrap">';
    echo '<table class="price-table" itemscope itemtype="https://schema.org/PriceSpecification">';
    if ( $caption ) {
        echo '<caption>' . esc_html( $caption ) . '</caption>';
    }
    echo '<thead><tr>';
    echo '<th scope="col">Length</th>';
    echo '<th scope="col">Price Per Bundle</th>';
    echo '<th scope="col">Order</th>';
    echo '</tr></thead><tbody>';

    foreach ( $rows as $length => $price ) {
        $wa_msg = 'Hello! I\'d like to order ' . $caption . ' ' . $length . '\" at £' . $price . '.';
        echo '<tr>';
        echo '<td>' . esc_html( $length ) . '"</td>';
        echo '<td class="price-col">&pound;' . esc_html( $price ) . '</td>';
        echo '<td><a href="' . esc_url( ah_whatsapp_url( $wa_msg ) ) . '" class="btn btn--wa btn--sm" target="_blank" rel="noopener noreferrer">' . ah_svg( 'whatsapp' ) . ' Order</a></td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
    if ( $note ) {
        echo '<p class="t-body" style="margin-top:var(--gap3);font-style:italic;">' . esc_html( $note ) . '</p>';
    }
    echo '</div>';
}

/* ============================================================
   SOCIAL LINKS
   ============================================================ */
function ah_social_links( string $class = 'ah-social-links' ): void {
    $links = [
        'instagram' => get_theme_mod( 'ah_social_instagram', '' ),
        'facebook'  => get_theme_mod( 'ah_social_facebook',  '' ),
        'tiktok'    => get_theme_mod( 'ah_social_tiktok',    '' ),
        'youtube'   => get_theme_mod( 'ah_social_youtube',   '' ),
    ];

    $labels = [
        'instagram' => 'Instagram',
        'facebook'  => 'Facebook',
        'tiktok'    => 'TikTok',
        'youtube'   => 'YouTube',
    ];

    echo '<div class="' . esc_attr( $class ) . '">';
    foreach ( $links as $platform => $url ) {
        if ( ! $url ) continue;
        echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr( $labels[ $platform ] ) . '">';
        echo ah_svg( $platform );
        echo '</a>';
    }
    echo '</div>';
}

/* ============================================================
   STAR RATING
   ============================================================ */
function ah_stars( int $count = 5 ): string {
    $out = '<div class="tcard__stars" aria-label="' . $count . ' out of 5 stars">';
    for ( $i = 0; $i < $count; $i++ ) {
        $out .= ah_svg( 'star' );
    }
    $out .= '</div>';
    return $out;
}

/* ============================================================
   PRODUCT CARD
   ============================================================ */
function ah_product_card( WP_Post $post ): void {
    $price_from  = get_post_meta( $post->ID, '_ah_price_from', true );
    $image_file  = get_post_meta( $post->ID, '_ah_image_file', true );
    $categories  = wp_get_object_terms( $post->ID, 'hair_category' );
    $textures    = wp_get_object_terms( $post->ID, 'hair_texture' );
    $category    = ! is_wp_error( $categories ) && $categories ? $categories[0]->name : '';
    $wa_msg      = 'Hello! I\'m interested in: ' . get_the_title( $post );
    $img_src     = has_post_thumbnail( $post->ID )
                   ? get_the_post_thumbnail_url( $post->ID, 'ah-product' )
                   : AH_URI . '/assets/images/' . ( $image_file ?: 'logo.jpg' );
    ?>
    <article class="product-card" data-category="<?php echo esc_attr( sanitize_title( $category ) ); ?>">
        <div class="product-card__img">
            <img src="<?php echo esc_url( $img_src ); ?>"
                 alt="<?php echo esc_attr( get_the_title( $post ) ); ?>"
                 loading="lazy" width="600" height="800">
            <?php if ( $category ) : ?>
                <span class="product-card__badge"><?php echo esc_html( $category ); ?></span>
            <?php endif; ?>
        </div>
        <div class="product-card__body">
            <?php if ( $category ) : ?>
                <span class="product-card__cat"><?php echo esc_html( $category ); ?></span>
            <?php endif; ?>
            <h3 class="product-card__title"><?php echo esc_html( get_the_title( $post ) ); ?></h3>
            <p class="product-card__desc"><?php echo esc_html( get_the_excerpt( $post ) ); ?></p>
            <?php if ( $price_from ) : ?>
                <p class="product-card__price">from &pound;<?php echo esc_html( $price_from ); ?> <span>per bundle</span></p>
            <?php endif; ?>
            <div class="product-card__actions">
                <a href="<?php echo esc_url( ah_whatsapp_url( $wa_msg ) ); ?>"
                   class="btn btn--black btn--sm"
                   target="_blank" rel="noopener noreferrer">
                    <?php echo ah_svg( 'whatsapp' ); ?> Order Now
                </a>
                <a href="<?php echo esc_url( get_permalink( $post ) ); ?>"
                   class="btn btn--outline btn--sm">Details</a>
            </div>
        </div>
    </article>
    <?php
}

/* ============================================================
   TEXTURES LIST
   ============================================================ */
function ah_textures_list(): array {
    return [
        'straight'      => 'Straight',
        'kinky-straight'=> 'Kinky Straight',
        'yaki-straight' => 'Yaki Straight',
        'deep-wave'     => 'Deep Wave',
        'body-wave'     => 'Body Wave',
        'loose-wave'    => 'Loose Wave',
        'water-wave'    => 'Water Wave',
        'burmese-curls' => 'Burmese Curls',
        'loose-deep'    => 'Loose Deep',
        'waver-wave'    => 'Waver Wave',
    ];
}
