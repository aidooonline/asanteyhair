<?php
/**
 * Asantey Hair & Beauty — Single Product Page
 * Dark editorial luxury design. Pill variation selectors. Zero WC hook conflicts.
 */
defined( 'ABSPATH' ) || exit;
get_header();

while ( have_posts() ) : the_post();
global $product;

$title        = get_the_title();
$price_html   = $product->get_price_html();
$short_desc   = $product->get_short_description();
$description  = $product->get_description();
$sku          = $product->get_sku();
$stock_status = $product->get_stock_status();
$stock_qty    = $product->get_stock_quantity();
$avg_rating   = $product->get_average_rating();
$review_count = $product->get_review_count();
$is_variable  = $product->is_type('variable');

/* Gallery */
$attachment_ids = $product->get_gallery_image_ids();
$main_img_id    = $product->get_image_id();
if ( $main_img_id ) array_unshift( $attachment_ids, $main_img_id );

/* Category */
$cats           = wc_get_product_category_list( get_the_ID(), ', ' );
$cats_plain     = strip_tags( $cats );
$prod_cats      = get_the_terms( get_the_ID(), 'product_cat' );
$breadcrumb_cat = ( $prod_cats && !is_wp_error($prod_cats) ) ? $prod_cats[0] : null;

/* WhatsApp */
$wa_num = get_theme_mod('ah_whatsapp_number','');
$wa_msg = 'Hello! I would like to enquire about: ' . $title . ' ' . get_permalink();
$wa_url = $wa_num ? 'https://wa.me/' . preg_replace('/[^0-9]/','', $wa_num) . '?text=' . rawurlencode($wa_msg) : '';
?>

<!-- ═══════════════ SINGLE PRODUCT ══ -->
<div class="wcp-page">

    <!-- LEFT: Gallery -->
    <div class="wcp-gallery">

        <!-- Main image -->
        <div class="wcp-gallery__main" id="wcp-main">
            <?php if ($main_img_id) :
                $main_src = wp_get_attachment_image_url($main_img_id,'woocommerce_single');
                $main_alt = get_post_meta($main_img_id,'_wp_attachment_image_alt',true) ?: $title;
            ?>
                <img src="<?php echo esc_url($main_src); ?>" alt="<?php echo esc_attr($main_alt); ?>"
                     id="wcp-main-img" loading="eager" fetchpriority="high">
            <?php else : ?>
                <img src="<?php echo esc_url(wc_placeholder_img_src('woocommerce_single')); ?>"
                     alt="<?php echo esc_attr($title); ?>" id="wcp-main-img" loading="eager">
            <?php endif; ?>

            <?php if ($product->is_on_sale()) : ?>
            <span class="wcp-badge wcp-badge--sale">Sale</span>
            <?php elseif ($product->is_featured()) : ?>
            <span class="wcp-badge wcp-badge--feat">Featured</span>
            <?php endif; ?>

            <button class="wcp-zoom" id="wcp-zoom" aria-label="Zoom image">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35M11 8v6M8 11h6"/></svg>
            </button>
        </div>

        <!-- Thumbnails -->
        <?php if (count($attachment_ids) > 1) : ?>
        <div class="wcp-thumbs" role="list">
            <?php foreach ($attachment_ids as $i => $aid) :
                $t = wp_get_attachment_image_url($aid,'thumbnail');
                $f = wp_get_attachment_image_url($aid,'woocommerce_single');
                $a = get_post_meta($aid,'_wp_attachment_image_alt',true) ?: $title;
            ?>
            <button class="wcp-thumb<?php echo $i===0?' wcp-thumb--on':''; ?>"
                    data-full="<?php echo esc_url($f); ?>"
                    aria-label="Image <?php echo $i+1; ?>">
                <img src="<?php echo esc_url($t); ?>" alt="<?php echo esc_attr($a); ?>" loading="lazy">
            </button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div><!-- .wcp-gallery -->

    <!-- RIGHT: Summary -->
    <div class="wcp-summary">

        <!-- Breadcrumb -->
        <nav class="wcp-breadcrumb" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
            <span>&rsaquo;</span>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Shop</a>
            <?php if ($breadcrumb_cat) : ?>
            <span>&rsaquo;</span>
            <a href="<?php echo esc_url(get_term_link($breadcrumb_cat)); ?>"><?php echo esc_html($breadcrumb_cat->name); ?></a>
            <?php endif; ?>
        </nav>

        <!-- Category + Title -->
        <?php if ($cats_plain) : ?>
        <span class="wcp-cat"><?php echo esc_html($cats_plain); ?></span>
        <?php endif; ?>
        <h1 class="wcp-title"><?php echo wp_kses_post($title); ?></h1>

        <!-- Rating -->
        <?php if ($review_count > 0) : ?>
        <div class="wcp-rating">
            <span class="wcp-stars" aria-label="<?php echo esc_attr($avg_rating); ?> out of 5">
                <?php for ($s=1;$s<=5;$s++) : ?>
                <svg width="12" height="12" viewBox="0 0 24 24"
                     fill="<?php echo $s<=round($avg_rating)?'#c9a47e':'none'; ?>"
                     stroke="#c9a47e" stroke-width="1.5">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
                <?php endfor; ?>
            </span>
            <a href="#wcp-reviews" class="wcp-rcount" data-opentab="reviews">
                <?php echo esc_html($review_count); ?> <?php echo _n('review','reviews',$review_count,'asantey-theme'); ?>
            </a>
        </div>
        <?php endif; ?>

        <div class="wcp-divider"></div>

        <!-- Price -->
        <div class="wcp-price"><?php echo $price_html; ?></div>

        <!-- Short description -->
        <?php if ($short_desc) : ?>
        <div class="wcp-short-desc"><?php echo wp_kses_post($short_desc); ?></div>
        <?php endif; ?>

        <!-- Stock notice -->
        <?php if ($stock_status === 'outofstock') : ?>
        <p class="wcp-stock wcp-stock--out">Currently out of stock</p>
        <?php elseif ($stock_qty !== null && $stock_qty > 0 && $stock_qty <= 5) : ?>
        <p class="wcp-stock wcp-stock--low">Only <?php echo esc_html($stock_qty); ?> left</p>
        <?php endif; ?>

        <!-- Add to cart form -->
        <div class="wcp-form-wrap" id="wcp-form-wrap">
            <?php
            /*
             * For variable products we render pill selectors that drive
             * the hidden WC <select> elements. For simple products we
             * render the standard WC form directly.
             */
            ?>
            <?php if ($is_variable) :
                $attributes   = $product->get_variation_attributes();
                $variations   = $product->get_available_variations();
                $var_json     = json_encode($variations);
            ?>
            <form class="wcp-var-form" id="wcp-var-form"
                  action="<?php echo esc_url(get_permalink()); ?>" method="post"
                  enctype="multipart/form-data">

                <?php foreach ($attributes as $attr_name => $attr_options) :
                    $label      = wc_attribute_label($attr_name);
                    $field_name = 'attribute_' . sanitize_title($attr_name);
                ?>
                <div class="wcp-attr" data-attr="<?php echo esc_attr($field_name); ?>">
                    <div class="wcp-attr__head">
                        <span class="wcp-attr__label"><?php echo esc_html($label); ?></span>
                        <span class="wcp-attr__chosen" id="chosen-<?php echo esc_attr(sanitize_title($attr_name)); ?>"></span>
                    </div>
                    <div class="wcp-pills" role="group" aria-label="<?php echo esc_attr($label); ?>">
                        <?php foreach ($attr_options as $option) : ?>
                        <button type="button"
                                class="wcp-pill-opt"
                                data-attr="<?php echo esc_attr($field_name); ?>"
                                data-value="<?php echo esc_attr($option); ?>"
                                aria-pressed="false">
                            <?php echo esc_html($option); ?>
                        </button>
                        <?php endforeach; ?>
                    </div>
                    <!-- Hidden select WooCommerce reads -->
                    <select name="<?php echo esc_attr($field_name); ?>"
                            id="<?php echo esc_attr($field_name); ?>"
                            class="wcp-hidden-select"
                            aria-hidden="true"
                            tabindex="-1">
                        <option value="">Choose <?php echo esc_html($label); ?></option>
                        <?php foreach ($attr_options as $option) :
                            echo '<option value="' . esc_attr($option) . '">' . esc_html($option) . '</option>';
                        endforeach; ?>
                    </select>
                </div>
                <?php endforeach; ?>

                <!-- Hidden variation ID populated by JS -->
                <input type="hidden" name="variation_id" id="wcp-variation-id" value="0">

                <!-- Price display updated by JS when variation selected -->
                <div class="wcp-var-price" id="wcp-var-price" aria-live="polite"></div>

                <!-- Qty + ATC row -->
                <div class="wcp-atc-row">
                    <div class="wcp-qty-wrap">
                        <button type="button" class="wcp-qty-btn wcp-qty-minus" aria-label="Decrease">
                            <svg width="12" height="2" viewBox="0 0 12 2"><path d="M0 1h12" stroke="currentColor" stroke-width="1.5"/></svg>
                        </button>
                        <input type="number" class="wcp-qty-input" name="quantity" value="1" min="1" max="99" aria-label="Quantity">
                        <button type="button" class="wcp-qty-btn wcp-qty-plus" aria-label="Increase">
                            <svg width="12" height="12" viewBox="0 0 12 12"><path d="M6 0v12M0 6h12" stroke="currentColor" stroke-width="1.5"/></svg>
                        </button>
                    </div>
                    <button type="submit"
                            name="add-to-cart"
                            value="<?php echo esc_attr($product->get_id()); ?>"
                            class="wcp-atc-btn"
                            id="wcp-atc-btn"
                            disabled
                            aria-label="Add to bag">
                        Add to Bag
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39A2 2 0 009.07 16h9.86a2 2 0 001.96-1.61L23 6H6"/></svg>
                    </button>
                </div>

                <!-- WC required hidden fields -->
                <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>">
                <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>

                <!-- Variation data for JS -->
                <script>var wcpVariations=<?php echo $var_json; ?>,wcpProductId=<?php echo (int)$product->get_id(); ?>;</script>

            </form>

            <?php else : /* Simple / External product */ ?>
            <?php woocommerce_template_single_add_to_cart(); ?>
            <?php endif; ?>
        </div>

        <!-- WhatsApp -->
        <?php if ($wa_url) : ?>
        <a href="<?php echo esc_url($wa_url); ?>" class="wcp-wa" target="_blank" rel="noopener noreferrer">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Order via WhatsApp
        </a>
        <?php endif; ?>

        <!-- Trust bar -->
        <div class="wcp-trust">
            <div class="wcp-trust__item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>Secure Checkout
            </div>
            <div class="wcp-trust__item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>UK Dispatch 2&ndash;3 Days
            </div>
            <div class="wcp-trust__item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>Single Donor Hair
            </div>
            <div class="wcp-trust__item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>3&ndash;5 Year Lifespan
            </div>
        </div>

        <!-- Meta -->
        <?php if ($sku) : ?>
        <p class="wcp-sku">SKU: <span><?php echo esc_html($sku); ?></span></p>
        <?php endif; ?>

    </div><!-- .wcp-summary -->

</div><!-- .wcp-page -->

<!-- ═══════════════ TABS ══ -->
<div class="wcp-tabs-section" id="wcp-tabs">
    <div class="wrap">
        <div class="wcp-tabs" role="tablist">
            <button class="wcp-tab wcp-tab--on" data-tab="desc" role="tab" aria-selected="true">Description</button>
            <?php if ($product->get_reviews_allowed()) : ?>
            <button class="wcp-tab" data-tab="reviews" role="tab" aria-selected="false" id="wcp-reviews">
                Reviews<?php if ($review_count) echo ' <span class="wcp-tab__n">'.esc_html($review_count).'</span>'; ?>
            </button>
            <?php endif; ?>
            <button class="wcp-tab" data-tab="care" role="tab" aria-selected="false">Care Guide</button>
            <button class="wcp-tab" data-tab="ship" role="tab" aria-selected="false">Shipping</button>
        </div>

        <div class="wcp-panel wcp-panel--on" id="wcp-panel-desc" role="tabpanel">
            <?php if ($description) : ?>
            <div class="wcp-prose"><?php echo wp_kses_post($description); ?></div>
            <?php else : ?>
            <p class="wcp-prose" style="color:var(--g9)">No additional description for this product.</p>
            <?php endif; ?>
        </div>

        <?php if ($product->get_reviews_allowed()) : ?>
        <div class="wcp-panel" id="wcp-panel-reviews" role="tabpanel" hidden>
            <div class="wcp-prose"><?php comments_template(); ?></div>
        </div>
        <?php endif; ?>

        <div class="wcp-panel" id="wcp-panel-care" role="tabpanel" hidden>
            <div class="wcp-prose">
                <h3>Hair Care Guide</h3>
                <p>With the right care your Asantey hair will last 3&ndash;5 years. Treat it as you would your own and it will reward you every time.</p>
                <h4>Washing</h4>
                <ul>
                    <li>Wash every 1&ndash;2 weeks using a sulphate-free shampoo.</li>
                    <li>Work shampoo down the length &mdash; never scrub in circles.</li>
                    <li>Deep condition from mid-lengths to ends, leave 5 minutes, rinse with lukewarm water.</li>
                </ul>
                <h4>Drying &amp; Heat</h4>
                <ul>
                    <li>Pat dry with a microfibre towel &mdash; never rub.</li>
                    <li>Air-dry where possible. Apply heat protectant before any heat styling.</li>
                    <li>Keep heat tools below 180&deg;C for maximum longevity.</li>
                    <li>Detangle when wet, starting from ends upward with a wide-tooth comb.</li>
                </ul>
                <h4>Nighttime</h4>
                <ul>
                    <li>Loosely braid or twist before sleep.</li>
                    <li>Sleep on a satin or silk pillowcase, or wear a satin bonnet.</li>
                </ul>
                <h4>Curly &amp; Wavy Textures</h4>
                <ul>
                    <li>Apply curl cream to wet hair and air-dry for maximum definition.</li>
                    <li>Refresh between washes with a water and conditioner mist.</li>
                    <li>Deep condition every two weeks.</li>
                </ul>
                <p><a href="<?php echo esc_url(home_url('/hair-care-guide/')); ?>">Read the full Hair Care Guide &rarr;</a></p>
            </div>
        </div>

        <div class="wcp-panel" id="wcp-panel-ship" role="tabpanel" hidden>
            <div class="wcp-prose">
                <h3>Shipping &amp; Returns</h3>
                <div class="wcp-ship-grid">
                    <div class="wcp-ship-card">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                        <strong>Standard UK</strong><span>2&ndash;3 business days</span>
                    </div>
                    <div class="wcp-ship-card">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <strong>Collect In-Store</strong><span>358 Radford Road, Nottingham NG7 5GQ</span>
                    </div>
                    <div class="wcp-ship-card">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>
                        <strong>Returns</strong><span>14 days &mdash; unused, original packaging</span>
                    </div>
                    <div class="wcp-ship-card">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <strong>Secure Payments</strong><span>Stripe &amp; PayPal accepted</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════ RELATED ══ -->
<?php
$rel_ids = wc_get_related_products($product->get_id(), 3);
$rel_ids = array_filter($rel_ids);
if ($rel_ids) :
    $rel_products = array_filter(array_map('wc_get_product', $rel_ids));
?>
<div class="wcp-related">
    <div class="wrap">
        <div class="wcp-related__head">
            <span class="wcp-related__label">You May Also Like</span>
            <h2 class="wcp-related__title">Complete Your Look</h2>
        </div>
        <div class="wcp-related__grid">
        <?php foreach ($rel_products as $rp) :
            $r_img   = $rp->get_image_id() ? wp_get_attachment_image_url($rp->get_image_id(),'woocommerce_thumbnail') : wc_placeholder_img_src();
            $r_cats  = strip_tags(wc_get_product_category_list($rp->get_id(),' &middot; '));
        ?>
            <a href="<?php echo esc_url($rp->get_permalink()); ?>" class="wcp-rel-card">
                <div class="wcp-rel-card__img">
                    <img src="<?php echo esc_url($r_img); ?>" alt="<?php echo esc_attr($rp->get_name()); ?>" loading="lazy">
                    <div class="wcp-rel-card__hover" aria-hidden="true">
                        <span>View Product <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
                    </div>
                </div>
                <div class="wcp-rel-card__body">
                    <?php if ($r_cats) : ?><span class="wcp-rel-card__cat"><?php echo $r_cats; ?></span><?php endif; ?>
                    <h3 class="wcp-rel-card__name"><?php echo esc_html($rp->get_name()); ?></h3>
                    <div class="wcp-rel-card__price"><?php echo $rp->get_price_html(); ?></div>
                </div>
            </a>
        <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ═══════════════ LIGHTBOX ══ -->
<div class="wcp-lb" id="wcp-lb" hidden role="dialog" aria-modal="true" aria-label="Zoom">
    <div class="wcp-lb__inner">
        <button class="wcp-lb__close" id="wcp-lb-close" aria-label="Close">&times;</button>
        <img src="" alt="" id="wcp-lb-img">
    </div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
