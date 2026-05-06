<?php
/**
 * Asantey Hair & Beauty — Single Product Page
 * Fully custom template matching the editorial luxury design system.
 * Replaces WooCommerce default rendering entirely.
 */
defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) : the_post();
global $product;

$title        = get_the_title();
$price_html   = $product->get_price_html();
$short_desc   = $product->get_short_description();
$description  = $product->get_description();
$cats         = wc_get_product_category_list( $product->get_id(), ', ' );
$cats_plain   = strip_tags( $cats );
$sku          = $product->get_sku();
$stock_status = $product->get_stock_status();
$stock_qty    = $product->get_stock_quantity();
$avg_rating   = $product->get_average_rating();
$review_count = $product->get_review_count();

// Gallery images
$attachment_ids = $product->get_gallery_image_ids();
$main_image_id  = $product->get_image_id();
if ( $main_image_id ) array_unshift( $attachment_ids, $main_image_id );
$has_gallery = count( $attachment_ids ) > 1;

// WhatsApp
$wa_number = get_theme_mod( 'ah_whatsapp_number', '' );
$wa_msg    = 'Hello! I would like to order: ' . $title . ' ' . get_permalink();
$wa_url    = $wa_number ? 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $wa_number ) . '?text=' . rawurlencode( $wa_msg ) : '';

// Breadcrumb
$product_cats   = get_the_terms( get_the_ID(), 'product_cat' );
$breadcrumb_cat = ( $product_cats && ! is_wp_error( $product_cats ) ) ? $product_cats[0] : null;
?>

<div class="ahp-topbar">
    <nav class="ahp-breadcrumb" aria-label="Breadcrumb">
        <a href="<?php echo esc_url( home_url('/') ); ?>">Home</a>
        <span>&rsaquo;</span>
        <a href="<?php echo esc_url( wc_get_page_permalink('shop') ); ?>">Shop</a>
        <?php if ( $breadcrumb_cat ) : ?>
        <span>&rsaquo;</span>
        <a href="<?php echo esc_url( get_term_link( $breadcrumb_cat ) ); ?>"><?php echo esc_html( $breadcrumb_cat->name ); ?></a>
        <?php endif; ?>
        <span>&rsaquo;</span>
        <span><?php echo esc_html( $title ); ?></span>
    </nav>
</div>

<div class="ahp-product">

    <!-- LEFT: Image gallery -->
    <div class="ahp-gallery" id="ahp-gallery">
        <div class="ahp-gallery__main" id="ahp-main-img">
            <?php if ( $main_image_id ) : ?>
                <img src="<?php echo esc_url( wp_get_attachment_image_url( $main_image_id, 'woocommerce_single' ) ); ?>"
                     alt="<?php echo esc_attr( $title ); ?>"
                     id="ahp-main-photo" loading="eager" fetchpriority="high">
            <?php else : ?>
                <img src="<?php echo esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ); ?>"
                     alt="<?php echo esc_attr( $title ); ?>" id="ahp-main-photo" loading="eager">
            <?php endif; ?>
            <?php if ( $product->is_on_sale() ) : ?>
                <span class="ahp-badge ahp-badge--sale">Sale</span>
            <?php elseif ( $product->is_featured() ) : ?>
                <span class="ahp-badge ahp-badge--feat">Featured</span>
            <?php endif; ?>
            <button class="ahp-zoom-btn" id="ahp-zoom-btn" aria-label="Zoom image">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35M11 8v6M8 11h6"/></svg>
            </button>
        </div>
        <?php if ( $has_gallery ) : ?>
        <div class="ahp-gallery__thumbs" role="list" aria-label="Product images">
            <?php foreach ( $attachment_ids as $i => $att_id ) :
                $thumb_url = wp_get_attachment_image_url( $att_id, 'thumbnail' );
                $full_url  = wp_get_attachment_image_url( $att_id, 'woocommerce_single' );
                $alt       = get_post_meta( $att_id, '_wp_attachment_image_alt', true ) ?: $title;
            ?>
            <button class="ahp-thumb<?php echo $i === 0 ? ' ahp-thumb--active' : ''; ?>"
                    data-full="<?php echo esc_url( $full_url ); ?>"
                    role="listitem" aria-label="Image <?php echo $i + 1; ?>">
                <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy">
            </button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- RIGHT: Summary -->
    <div class="ahp-summary">

        <?php if ( $cats_plain ) : ?>
        <span class="ahp-cat-label"><?php echo esc_html( $cats_plain ); ?></span>
        <?php endif; ?>

        <h1 class="ahp-title" itemprop="name"><?php echo wp_kses_post( $title ); ?></h1>

        <?php if ( $review_count > 0 ) : ?>
        <div class="ahp-rating">
            <div class="ahp-stars" aria-label="<?php echo esc_attr( $avg_rating ); ?> out of 5">
                <?php for ( $s = 1; $s <= 5; $s++ ) : ?>
                <svg width="13" height="13" viewBox="0 0 24 24"
                     fill="<?php echo $s <= round($avg_rating) ? 'currentColor' : 'none'; ?>"
                     stroke="currentColor" stroke-width="1.5">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
                <?php endfor; ?>
            </div>
            <a href="#ahp-panel-reviews" class="ahp-review-count" data-open-tab="reviews">
                <?php echo esc_html( $review_count ); ?> <?php echo _n('review','reviews',$review_count,'asantey-theme'); ?>
            </a>
        </div>
        <?php endif; ?>

        <div class="ahp-rule"></div>

        <div class="ahp-price" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
            <meta itemprop="priceCurrency" content="GBP">
            <?php echo $price_html; ?>
        </div>

        <?php if ( $short_desc ) : ?>
        <div class="ahp-short-desc"><?php echo wp_kses_post( $short_desc ); ?></div>
        <?php endif; ?>

        <!-- Stock warning -->
        <?php if ( $stock_status === 'outofstock' ) : ?>
        <p class="ahp-stock ahp-stock--out">Currently Out of Stock</p>
        <?php elseif ( $stock_qty !== null && $stock_qty > 0 && $stock_qty <= 5 ) : ?>
        <p class="ahp-stock ahp-stock--low">Only <?php echo esc_html( $stock_qty ); ?> left in stock</p>
        <?php endif; ?>

        <!-- Add to cart -->
        <div class="ahp-atc-wrap">
            <?php woocommerce_template_single_add_to_cart(); ?>
        </div>

        <!-- WhatsApp -->
        <?php if ( $wa_url ) : ?>
        <a href="<?php echo esc_url( $wa_url ); ?>" class="ahp-wa-btn" target="_blank" rel="noopener noreferrer">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Order via WhatsApp
        </a>
        <?php endif; ?>

        <!-- Trust bar -->
        <div class="ahp-trust">
            <div class="ahp-trust__item">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span>Secure Checkout</span>
            </div>
            <div class="ahp-trust__item">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                <span>UK Dispatch 2&ndash;3 Days</span>
            </div>
            <div class="ahp-trust__item">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                <span>Single Donor Hair</span>
            </div>
            <div class="ahp-trust__item">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                <span>3&ndash;5 Year Lifespan</span>
            </div>
        </div>

        <!-- Meta -->
        <div class="ahp-meta">
            <?php if ( $sku ) : ?>
            <div class="ahp-meta__row">
                <span class="ahp-meta__label">SKU</span>
                <span class="ahp-meta__value"><?php echo esc_html( $sku ); ?></span>
            </div>
            <?php endif; ?>
            <?php if ( $cats_plain ) : ?>
            <div class="ahp-meta__row">
                <span class="ahp-meta__label">Category</span>
                <span class="ahp-meta__value"><?php echo wp_kses_post( $cats ); ?></span>
            </div>
            <?php endif; ?>
        </div>

    </div><!-- .ahp-summary -->

</div><!-- .ahp-product -->

<!-- TABS -->
<div class="ahp-tabs-section">
    <div class="wrap ahp-tabs-wrap">
        <div class="ahp-tabs" role="tablist">
            <button class="ahp-tab ahp-tab--active" role="tab" data-tab="description" aria-selected="true">Description</button>
            <?php if ( $product->get_reviews_allowed() ) : ?>
            <button class="ahp-tab" role="tab" data-tab="reviews" aria-selected="false">
                Reviews<?php if ( $review_count ) echo ' <span class="ahp-tab__count">' . esc_html($review_count) . '</span>'; ?>
            </button>
            <?php endif; ?>
            <button class="ahp-tab" role="tab" data-tab="care" aria-selected="false">Care Guide</button>
            <button class="ahp-tab" role="tab" data-tab="shipping" aria-selected="false">Shipping</button>
        </div>

        <div class="ahp-panel ahp-panel--active" id="ahp-panel-description" role="tabpanel">
            <?php if ( $description ) : ?>
            <div class="ahp-panel__body ahp-prose"><?php echo wp_kses_post( $description ); ?></div>
            <?php else : ?>
            <p class="ahp-panel__empty">No additional description for this product.</p>
            <?php endif; ?>
        </div>

        <?php if ( $product->get_reviews_allowed() ) : ?>
        <div class="ahp-panel" id="ahp-panel-reviews" role="tabpanel" hidden>
            <div class="ahp-panel__body"><?php comments_template(); ?></div>
        </div>
        <?php endif; ?>

        <div class="ahp-panel" id="ahp-panel-care" role="tabpanel" hidden>
            <div class="ahp-panel__body ahp-prose">
                <h3>Hair Care Guide</h3>
                <p>With the right care, your Asantey hair will last 3&ndash;5 years. Treat it as you would your own hair and it will reward you every time.</p>
                <h4>Washing</h4>
                <ul>
                    <li>Wash every 1&ndash;2 weeks with a sulphate-free shampoo.</li>
                    <li>Work product down the length &mdash; never scrub in circles.</li>
                    <li>Follow with a moisturising conditioner from mid-lengths to ends.</li>
                    <li>Rinse thoroughly with lukewarm water. Avoid very hot water.</li>
                </ul>
                <h4>Drying &amp; Styling</h4>
                <ul>
                    <li>Pat dry with a microfibre towel &mdash; never rub.</li>
                    <li>Air-dry where possible. Apply heat protectant before any heat tool use.</li>
                    <li>Detangle when wet using a wide-tooth comb, starting from ends upward.</li>
                    <li>Keep heat tools below 180&deg;C for maximum longevity.</li>
                </ul>
                <h4>Nighttime Care</h4>
                <ul>
                    <li>Braid or loosely twist hair before sleep to prevent tangling.</li>
                    <li>Sleep on satin or silk, or use a satin bonnet.</li>
                    <li>Store wigs on a stand and cover with a silk bag.</li>
                </ul>
                <h4>Curly &amp; Wavy Textures</h4>
                <ul>
                    <li>Apply curl cream to wet hair and air-dry for maximum definition.</li>
                    <li>Refresh between washes with a water and conditioner mist.</li>
                    <li>Deep condition every two weeks.</li>
                </ul>
                <p><a href="<?php echo esc_url( home_url('/hair-care-guide/') ); ?>" class="ahp-text-link">Read the full Hair Care Guide &rarr;</a></p>
            </div>
        </div>

        <div class="ahp-panel" id="ahp-panel-shipping" role="tabpanel" hidden>
            <div class="ahp-panel__body ahp-prose">
                <h3>Shipping &amp; Delivery</h3>
                <div class="ahp-ship-grid">
                    <div class="ahp-ship-item">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                        <div><strong>Standard UK</strong><span>2&ndash;3 business days</span></div>
                    </div>
                    <div class="ahp-ship-item">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.09 11a19.79 19.79 0 01-3.07-8.67A2 2 0 012 .18h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z"/></svg>
                        <div><strong>Order by WhatsApp</strong><span>Personal service from our team</span></div>
                    </div>
                    <div class="ahp-ship-item">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <div><strong>In-Store Collection</strong><span>358 Radford Road, Nottingham NG7 5GQ</span></div>
                    </div>
                    <div class="ahp-ship-item">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>
                        <div><strong>Returns</strong><span>14 days &mdash; unused, original packaging</span></div>
                    </div>
                </div>
                <p style="margin-top:1.5rem"><a href="<?php echo esc_url( home_url('/shipping-returns/') ); ?>" class="ahp-text-link">Full Shipping &amp; Returns Policy &rarr;</a></p>
            </div>
        </div>
    </div>
</div>

<!-- RELATED PRODUCTS -->
<?php
$related_ids = wc_get_related_products( $product->get_id(), 3 );
$related_products = $related_ids ? array_filter( array_map( 'wc_get_product', $related_ids ) ) : [];
if ( $related_products ) :
?>
<div class="ahp-related">
    <div class="wrap">
        <div class="ahp-related__head">
            <span class="t-label" style="color:var(--g5)">You May Also Like</span>
            <h2 class="ahp-related__title">Complete Your Look</h2>
        </div>
        <div class="ahp-related__grid">
        <?php foreach ( $related_products as $rel ) :
            $rel_img   = $rel->get_image_id() ? wp_get_attachment_image_url( $rel->get_image_id(), 'woocommerce_thumbnail' ) : wc_placeholder_img_src();
            $rel_cats  = strip_tags( wc_get_product_category_list( $rel->get_id(), ', ' ) );
        ?>
            <a href="<?php echo esc_url( $rel->get_permalink() ); ?>" class="ahp-rel-card">
                <div class="ahp-rel-card__img">
                    <img src="<?php echo esc_url( $rel_img ); ?>" alt="<?php echo esc_attr( $rel->get_name() ); ?>" loading="lazy">
                </div>
                <div class="ahp-rel-card__body">
                    <?php if ( $rel_cats ) : ?><span class="ahp-rel-card__cat"><?php echo esc_html( $rel_cats ); ?></span><?php endif; ?>
                    <h3 class="ahp-rel-card__title"><?php echo esc_html( $rel->get_name() ); ?></h3>
                    <div class="ahp-rel-card__price"><?php echo $rel->get_price_html(); ?></div>
                </div>
                <span class="ahp-rel-card__cta">View Product</span>
            </a>
        <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- LIGHTBOX -->
<div class="ahp-lightbox" id="ahp-lightbox" role="dialog" aria-modal="true" hidden>
    <div class="ahp-lightbox__inner">
        <button class="ahp-lightbox__close" id="ahp-lb-close" aria-label="Close">&times;</button>
        <img src="" alt="" id="ahp-lb-img">
    </div>
</div>

<?php endwhile; ?>

<style>
.ahp-topbar{background:var(--off);padding:.75rem var(--gap);border-bottom:1px solid #e8e8e8}
.ahp-breadcrumb{max-width:var(--max);margin-inline:auto;font-family:var(--sans);font-size:.7rem;letter-spacing:.08em;text-transform:uppercase;color:var(--g5);display:flex;align-items:center;gap:.5rem;flex-wrap:wrap}
.ahp-breadcrumb a{color:var(--g5);transition:color var(--t)}.ahp-breadcrumb a:hover{color:var(--ink)}
.ahp-breadcrumb span{color:#ccc}

/* Two-column grid */
.ahp-product{display:grid;grid-template-columns:1fr 1fr;min-height:85vh;background:var(--paper);max-width:var(--max);margin-inline:auto}
@media(max-width:900px){.ahp-product{grid-template-columns:1fr}}

/* Gallery */
.ahp-gallery{position:sticky;top:var(--hh);height:calc(100vh - var(--hh));display:flex;flex-direction:column;background:#f8f8f8;overflow:hidden}
@media(max-width:900px){.ahp-gallery{position:relative;height:auto}}
.ahp-gallery__main{flex:1;position:relative;overflow:hidden;cursor:zoom-in}
.ahp-gallery__main img{width:100%;height:100%;object-fit:cover;object-position:center;transition:transform .6s var(--e)}
.ahp-gallery__main:hover img{transform:scale(1.04)}
.ahp-badge{position:absolute;top:1.25rem;left:1.25rem;font-family:var(--sans);font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;padding:.35rem .8rem;z-index:2}
.ahp-badge--sale{background:var(--ink);color:var(--paper)}.ahp-badge--feat{background:var(--gold);color:var(--paper)}
.ahp-zoom-btn{position:absolute;bottom:1.25rem;right:1.25rem;width:40px;height:40px;background:rgba(255,255,255,.9);backdrop-filter:blur(6px);border:1px solid rgba(0,0,0,.1);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .2s;z-index:2}
.ahp-zoom-btn:hover{background:#fff}
.ahp-gallery__thumbs{display:flex;gap:2px;padding:2px;background:#e8e8e8;flex-shrink:0;overflow-x:auto;scrollbar-width:none}
.ahp-gallery__thumbs::-webkit-scrollbar{display:none}
.ahp-thumb{width:76px;height:76px;flex-shrink:0;border:2px solid transparent;padding:0;background:none;cursor:pointer;overflow:hidden;transition:border-color .2s}
.ahp-thumb img{width:100%;height:100%;object-fit:cover}
.ahp-thumb--active{border-color:var(--ink)}

/* Summary */
.ahp-summary{padding:clamp(2.5rem,4vw,4rem) clamp(2rem,3.5vw,3.5rem);display:flex;flex-direction:column;overflow-y:auto;color:var(--ink)}
.ahp-cat-label{font-family:var(--sans);font-size:.65rem;letter-spacing:.18em;text-transform:uppercase;color:var(--g5);display:block;margin-bottom:.875rem}
.ahp-title{font-family:var(--serif);font-size:clamp(1.9rem,3vw,3rem);font-weight:400;color:var(--ink);line-height:1.05;letter-spacing:-.02em;margin-bottom:1rem}

/* Rating */
.ahp-rating{display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem}
.ahp-stars{display:flex;gap:2px;color:var(--gold)}
.ahp-review-count{font-family:var(--sans);font-size:.8rem;color:var(--g5);text-decoration:underline;text-underline-offset:3px;cursor:pointer}

.ahp-rule{height:1px;background:var(--off);margin-bottom:1.5rem}

/* Price */
.ahp-price{margin-bottom:1.5rem}
.ahp-price .price,.ahp-price .amount{font-family:var(--sans);font-size:1.75rem;font-weight:500;color:var(--ink)}
.ahp-price del .amount{font-size:1.1rem;color:var(--g9);font-weight:400}
.ahp-price ins{text-decoration:none}

/* Short desc */
.ahp-short-desc{font-family:var(--sans);font-size:.9rem;color:var(--g5);line-height:1.85;margin-bottom:1.75rem;padding-bottom:1.75rem;border-bottom:1px solid var(--off)}

/* Stock */
.ahp-stock{font-family:var(--sans);font-size:.8rem;font-weight:600;margin-bottom:1rem}
.ahp-stock--out{color:#c0392b}.ahp-stock--low{color:#e67e22}

/* ATC wrap - override WC defaults to match our style */
.ahp-atc-wrap{margin-bottom:1rem}
.ahp-atc-wrap form.cart{display:flex;flex-direction:column;gap:.875rem;margin:0}
.ahp-atc-wrap .variations{width:100%;border-collapse:collapse;margin-bottom:0}
.ahp-atc-wrap .variations td,.ahp-atc-wrap .variations th{padding:.4rem 0;vertical-align:middle}
.ahp-atc-wrap .variations label{font-family:var(--sans);font-size:.65rem;letter-spacing:.12em;text-transform:uppercase;color:var(--g5);font-weight:500}
.ahp-atc-wrap .variations select{width:100%;padding:.8rem 2.5rem .8rem 1rem;border:1px solid #ddd;background:var(--paper);color:var(--ink);font-family:var(--sans);font-size:.9rem;cursor:pointer;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23555' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 1rem center;transition:border-color .2s}
.ahp-atc-wrap .variations select:focus{outline:none;border-color:var(--ink)}
.ahp-atc-wrap .reset_variations{display:none!important}
.ahp-atc-wrap .cart{display:flex;flex-direction:column;gap:.875rem}
.ahp-atc-wrap .quantity{display:none} /* hide default qty, our JS adds custom stepper */
.ahp-atc-wrap .wc-qty-wrap{display:flex;border:1px solid #ddd;width:120px;margin-bottom:.5rem}
.ahp-atc-wrap .wc-qty-btn{width:38px;height:50px;background:none;border:none;font-size:1.15rem;color:var(--g5);cursor:pointer;transition:background .2s}
.ahp-atc-wrap .wc-qty-btn:hover{background:var(--off);color:var(--ink)}
.ahp-atc-wrap input.qty{border:none;border-left:1px solid #ddd;border-right:1px solid #ddd;height:50px;width:44px;text-align:center;font-family:var(--sans);font-size:.9rem;color:var(--ink)}
.ahp-atc-wrap .single_add_to_cart_button{width:100%;height:52px;background:var(--ink)!important;color:var(--paper)!important;border:none;font-family:var(--sans)!important;font-size:.72rem!important;font-weight:700;letter-spacing:.15em;text-transform:uppercase;cursor:pointer;transition:background .2s}
.ahp-atc-wrap .single_add_to_cart_button:hover{background:var(--g3)!important}
.ahp-atc-wrap .single_add_to_cart_button.loading{opacity:.7}

/* WA button */
.ahp-wa-btn{display:flex;align-items:center;justify-content:center;gap:.6rem;padding:.9rem;background:#25D366;color:#fff;font-family:var(--sans);font-size:.7rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;text-decoration:none;margin-bottom:1.75rem;transition:background .2s}
.ahp-wa-btn:hover{background:#1ebe5d}

/* Trust */
.ahp-trust{display:grid;grid-template-columns:1fr 1fr;gap:.75rem;padding:1.5rem 0;border-top:1px solid var(--off);border-bottom:1px solid var(--off);margin-bottom:1.75rem}
.ahp-trust__item{display:flex;align-items:center;gap:.5rem;font-family:var(--sans);font-size:.75rem;color:var(--g5)}
.ahp-trust__item svg{stroke:var(--g9);flex-shrink:0}

/* Meta */
.ahp-meta{display:flex;flex-direction:column;gap:.5rem}
.ahp-meta__row{display:flex;gap:.75rem;font-family:var(--sans);font-size:.8rem}
.ahp-meta__label{font-size:.65rem;letter-spacing:.1em;text-transform:uppercase;color:var(--g9);font-weight:500;min-width:80px}
.ahp-meta__value{color:var(--g5)}.ahp-meta__value a{color:var(--g5);text-decoration:underline}

/* Tabs */
.ahp-tabs-section{background:var(--paper);border-top:1px solid var(--off)}
.ahp-tabs-wrap{max-width:var(--max);margin-inline:auto;padding-inline:var(--gap)}
.ahp-tabs{display:flex;border-bottom:1px solid var(--off);overflow-x:auto;scrollbar-width:none}
.ahp-tabs::-webkit-scrollbar{display:none}
.ahp-tab{font-family:var(--sans);font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;padding:1.5rem 2rem;background:none;border:none;border-bottom:2px solid transparent;color:var(--g5);cursor:pointer;transition:color .2s,border-color .2s;white-space:nowrap;display:flex;align-items:center;gap:.4rem}
.ahp-tab:hover{color:var(--ink)}.ahp-tab--active{color:var(--ink);border-bottom-color:var(--ink)}
.ahp-tab__count{background:var(--ink);color:var(--paper);font-size:.55rem;padding:.15rem .45rem;border-radius:20px;line-height:1.4}
.ahp-panel{padding:3rem 0;display:none}.ahp-panel--active{display:block}
.ahp-panel__empty{font-family:var(--sans);color:var(--g5)}
.ahp-panel__body{max-width:800px}

/* Prose */
.ahp-prose{font-family:var(--sans);font-size:.95rem;color:var(--g5);line-height:1.85}
.ahp-prose h2,.ahp-prose h3{font-family:var(--serif);color:var(--ink);font-weight:400;margin:2rem 0 .75rem}
.ahp-prose h3{font-size:clamp(1.4rem,2.5vw,1.9rem)}
.ahp-prose h4{font-family:var(--sans);font-size:.72rem;letter-spacing:.12em;text-transform:uppercase;color:var(--ink);font-weight:700;margin:1.5rem 0 .5rem}
.ahp-prose p{margin-bottom:1.1rem}
.ahp-prose ul,.ahp-prose ol{padding-left:1.25rem;margin-bottom:1.1rem}
.ahp-prose li{margin-bottom:.35rem}
.ahp-prose strong{color:var(--ink);font-weight:600}
.ahp-text-link{color:var(--ink);font-weight:500;text-decoration:underline;text-underline-offset:3px;font-size:.85rem}

/* Ship grid */
.ahp-ship-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-top:1.5rem}
@media(max-width:600px){.ahp-ship-grid{grid-template-columns:1fr}}
.ahp-ship-item{display:flex;align-items:flex-start;gap:.875rem;padding:1.25rem;border:1px solid var(--off)}
.ahp-ship-item svg{stroke:var(--ink);flex-shrink:0;margin-top:.1rem}
.ahp-ship-item strong{display:block;font-family:var(--sans);font-size:.8rem;font-weight:600;color:var(--ink);margin-bottom:.2rem}
.ahp-ship-item span{font-family:var(--sans);font-size:.8rem;color:var(--g5)}

/* Related */
.ahp-related{background:var(--off);padding:clamp(4rem,7vw,7rem) 0}
.ahp-related__head{text-align:center;margin-bottom:3rem}
.ahp-related__title{font-family:var(--serif);font-size:clamp(2rem,4vw,3.25rem);color:var(--ink);font-weight:400;margin-top:.75rem}
.ahp-related__grid{display:grid;grid-template-columns:repeat(3,1fr);gap:2px}
@media(max-width:768px){.ahp-related__grid{grid-template-columns:1fr 1fr}}
@media(max-width:480px){.ahp-related__grid{grid-template-columns:1fr}}
.ahp-rel-card{display:flex;flex-direction:column;background:var(--paper);text-decoration:none;color:var(--ink);overflow:hidden;transition:transform .3s var(--e)}
.ahp-rel-card:hover{transform:translateY(-4px)}
.ahp-rel-card__img{aspect-ratio:3/4;overflow:hidden}
.ahp-rel-card__img img{width:100%;height:100%;object-fit:cover;transition:transform .6s var(--e)}
.ahp-rel-card:hover .ahp-rel-card__img img{transform:scale(1.04)}
.ahp-rel-card__body{padding:1.25rem 1.25rem .75rem}
.ahp-rel-card__cat{font-family:var(--sans);font-size:.6rem;letter-spacing:.15em;text-transform:uppercase;color:var(--g5);display:block;margin-bottom:.3rem}
.ahp-rel-card__title{font-family:var(--serif);font-size:1.1rem;color:var(--ink);font-weight:400;line-height:1.15;margin-bottom:.4rem}
.ahp-rel-card__price .amount{font-family:var(--sans);font-size:.85rem;color:var(--g5)}
.ahp-rel-card__cta{margin:auto 1.25rem 1.25rem;padding:.65rem;background:var(--ink);color:var(--paper);font-family:var(--sans);font-size:.65rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;text-align:center;transition:background .2s;display:block}
.ahp-rel-card:hover .ahp-rel-card__cta{background:var(--g3)}

/* Lightbox */
.ahp-lightbox{position:fixed;inset:0;background:rgba(0,0,0,.92);z-index:9999;display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .3s}
.ahp-lightbox:not([hidden]){opacity:1}
.ahp-lightbox[hidden]{display:none!important}
.ahp-lightbox__inner{position:relative;max-width:90vw;max-height:90vh}
.ahp-lightbox__inner img{max-width:90vw;max-height:85vh;object-fit:contain;display:block}
.ahp-lightbox__close{position:absolute;top:-2.5rem;right:0;background:none;border:none;color:#fff;font-size:2.25rem;cursor:pointer;line-height:1;padding:0}

/* Mobile sticky ATC */
.ahp-sticky-atc{position:fixed;bottom:0;left:0;right:0;z-index:800;background:var(--paper);border-top:1px solid var(--off);padding:.875rem var(--gap);display:flex;align-items:center;gap:1rem;transform:translateY(100%);transition:transform .3s var(--e);box-shadow:0 -4px 24px rgba(0,0,0,.08)}
.ahp-sticky-atc.visible{transform:translateY(0)}
.ahp-sticky-atc__name{font-family:var(--serif);font-size:1rem;color:var(--ink);flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.ahp-sticky-atc__btn{background:var(--ink);color:var(--paper);border:none;padding:.75rem 1.5rem;font-family:var(--sans);font-size:.68rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;cursor:pointer;flex-shrink:0;white-space:nowrap}

/* WC comments / reviews inside our template */
#reviews #comments{font-family:var(--sans)}
#reviews .woocommerce-Reviews-title{font-family:var(--serif);font-size:clamp(1.4rem,2.5vw,2rem);color:var(--ink);margin-bottom:2rem;font-weight:400}
#reviews .review{border-bottom:1px solid var(--off);padding:1.5rem 0}
#reviews .review .meta{font-family:var(--sans);font-size:.8rem;color:var(--g5);margin-bottom:.5rem}
#reviews .star-rating{color:var(--gold);margin-bottom:.5rem;overflow:hidden}
#reviews #review_form label{font-family:var(--sans);font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:var(--g5);display:block;margin-bottom:.4rem}
#reviews #review_form input[type=text],#reviews #review_form input[type=email],#reviews #review_form textarea{width:100%;max-width:500px;border:1px solid var(--off);padding:.75rem 1rem;font-family:var(--sans);font-size:.9rem;margin-bottom:1.25rem;color:var(--ink);display:block}
#reviews #review_form .form-submit input{background:var(--ink);color:var(--paper);border:none;padding:.85rem 2rem;font-family:var(--sans);font-size:.7rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;cursor:pointer;transition:background .2s}
#reviews #review_form .form-submit input:hover{background:var(--g3)}

@media(max-width:900px){
    .ahp-gallery__main{min-height:380px;height:72vw}
    .ahp-summary{padding:2rem var(--gap) 3rem}
}
@media(max-width:540px){
    .ahp-trust{grid-template-columns:1fr 1fr}
    .ahp-tab{padding:1.1rem .875rem}
    .ahp-related__grid{grid-template-columns:1fr 1fr}
}
</style>

<script>
(function(){
'use strict';

// Thumbnail switcher
var thumbs  = document.querySelectorAll('.ahp-thumb');
var mainImg = document.getElementById('ahp-main-photo');
thumbs.forEach(function(btn){
    btn.addEventListener('click',function(){
        thumbs.forEach(function(t){t.classList.remove('ahp-thumb--active');});
        btn.classList.add('ahp-thumb--active');
        if(!mainImg) return;
        mainImg.style.opacity='0';
        mainImg.style.transition='opacity .22s';
        setTimeout(function(){
            mainImg.src = btn.dataset.full;
            mainImg.onload = function(){ mainImg.style.opacity='1'; };
        },220);
    });
});

// Lightbox
var lb      = document.getElementById('ahp-lightbox');
var lbImg   = document.getElementById('ahp-lb-img');
var lbClose = document.getElementById('ahp-lb-close');
var zoomBtn = document.getElementById('ahp-zoom-btn');
var galMain = document.getElementById('ahp-main-img');

function openLb(){
    if(!lb||!mainImg) return;
    lbImg.src = mainImg.src;
    lb.removeAttribute('hidden');
    document.body.style.overflow='hidden';
    if(lbClose) lbClose.focus();
}
function closeLb(){
    if(!lb) return;
    lb.setAttribute('hidden','');
    document.body.style.overflow='';
}
if(zoomBtn) zoomBtn.addEventListener('click',openLb);
if(galMain) galMain.addEventListener('click',function(e){
    if(e.target===zoomBtn||zoomBtn.contains(e.target)) return;
    openLb();
});
if(lbClose) lbClose.addEventListener('click',closeLb);
if(lb) lb.addEventListener('click',function(e){if(e.target===lb) closeLb();});
document.addEventListener('keydown',function(e){
    if(e.key==='Escape'&&lb&&!lb.hasAttribute('hidden')) closeLb();
});

// Tabs
var tabs   = document.querySelectorAll('.ahp-tab');
var panels = document.querySelectorAll('.ahp-panel');
function openTab(tabId){
    tabs.forEach(function(t){t.classList.remove('ahp-tab--active');t.setAttribute('aria-selected','false');});
    panels.forEach(function(p){p.classList.remove('ahp-panel--active');p.setAttribute('hidden','');});
    var activeTab = document.querySelector('.ahp-tab[data-tab="'+tabId+'"]');
    var activePanel = document.getElementById('ahp-panel-'+tabId);
    if(activeTab){activeTab.classList.add('ahp-tab--active');activeTab.setAttribute('aria-selected','true');}
    if(activePanel){activePanel.classList.add('ahp-panel--active');activePanel.removeAttribute('hidden');}
}
tabs.forEach(function(tab){
    tab.addEventListener('click',function(){ openTab(tab.dataset.tab); });
});

// Review link -> open reviews tab
var ratingLink = document.querySelector('[data-open-tab="reviews"]');
if(ratingLink){
    ratingLink.addEventListener('click',function(e){
        e.preventDefault();
        openTab('reviews');
        var tabsSection = document.querySelector('.ahp-tabs-section');
        if(tabsSection) window.scrollTo({top:tabsSection.offsetTop-120,behavior:'smooth'});
    });
}

// Mobile sticky Add to Cart
var atcBtn = document.querySelector('.ahp-atc-wrap .single_add_to_cart_button');
var atcForm = document.querySelector('.ahp-atc-wrap');
if(atcBtn && atcForm && window.innerWidth <= 900){
    var sticky = document.createElement('div');
    sticky.className = 'ahp-sticky-atc';
    var titleEl = document.querySelector('.ahp-title');
    var prodName = titleEl ? titleEl.textContent.trim() : 'Add to Bag';
    sticky.innerHTML = '<span class="ahp-sticky-atc__name">'+prodName+'</span><button class="ahp-sticky-atc__btn">Add to Bag</button>';
    document.body.appendChild(sticky);
    sticky.querySelector('.ahp-sticky-atc__btn').addEventListener('click',function(){ atcBtn.click(); });
    if('IntersectionObserver' in window){
        new IntersectionObserver(function(entries){
            sticky.classList.toggle('visible',!entries[0].isIntersecting);
        },{threshold:0}).observe(atcForm);
    }
}

})();
</script>
<?php get_footer(); ?>
