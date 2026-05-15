<?php
/**
 * Asantey Hair & Beauty — Single Hair Product Template
 * Reads images from WordPress Media Library (set via Product Details meta box).
 */
defined( 'ABSPATH' ) || exit;
get_header();

while ( have_posts() ) : the_post();

$price_from  = get_post_meta( get_the_ID(), '_ah_price_from',      true );
$price_to    = get_post_meta( get_the_ID(), '_ah_price_to',        true );
$lengths_raw = get_post_meta( get_the_ID(), '_ah_lengths',         true );
$badge       = get_post_meta( get_the_ID(), '_ah_badge',           true );

// Main image: custom meta first, then WP featured image
$feat_img_id = (int) get_post_meta( get_the_ID(), '_ah_feat_img_id', true );
if ( ! $feat_img_id ) $feat_img_id = (int) get_post_thumbnail_id();

$main_img_src = $feat_img_id ? wp_get_attachment_image_url( $feat_img_id, 'large' )        : '';
$main_img_alt = $feat_img_id ? get_post_meta( $feat_img_id, '_wp_attachment_image_alt', true ) : get_the_title();

// Gallery images
$gallery_ids_raw = get_post_meta( get_the_ID(), '_ah_gallery_img_ids', true ) ?: '';
$gallery_ids     = array_filter( array_map( 'absint', explode( ',', $gallery_ids_raw ) ) );
$all_images      = $feat_img_id ? array_merge( [$feat_img_id], $gallery_ids ) : $gallery_ids;

// Lengths
$lengths = $lengths_raw ? array_map( 'trim', explode( ',', $lengths_raw ) ) : [];

// Price display
$sym = ah_currency_symbol();
$price_display = $price_from ? $sym . $price_from : '';
if ( $price_to ) $price_display .= ' – ' . $sym . $price_to;

// Category
$categories = get_the_terms( get_the_ID(), 'hair_category' );
$cat_name   = ( $categories && ! is_wp_error($categories) ) ? $categories[0]->name : '';

// WhatsApp
$wa_num = get_theme_mod('ah_whatsapp_number','');
$wa_msg = 'Hello! I would like to enquire about: ' . get_the_title() . ' — ' . get_permalink();
$wa_url = $wa_num ? 'https://wa.me/' . preg_replace('/[^0-9]/','', $wa_num) . '?text=' . rawurlencode($wa_msg) : '';
?>

<div class="wcp-page">

    <!-- GALLERY -->
    <div class="wcp-gallery">
        <div class="wcp-gallery__main" id="wcp-main">
            <?php if ( $main_img_src ) : ?>
            <img src="<?php echo esc_url($main_img_src); ?>"
                 alt="<?php echo esc_attr($main_img_alt ?: get_the_title()); ?>"
                 id="wcp-main-img" loading="eager" fetchpriority="high">
            <?php else : ?>
            <img src="<?php echo esc_url(wc_placeholder_img_src()); ?>"
                 alt="<?php echo esc_attr(get_the_title()); ?>"
                 id="wcp-main-img" loading="eager">
            <?php endif; ?>

            <?php if ($badge) : ?>
            <span class="wcp-badge wcp-badge--feat"><?php echo esc_html($badge); ?></span>
            <?php endif; ?>

            <button class="wcp-zoom" id="wcp-zoom" aria-label="Zoom image">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35M11 8v6M8 11h6"/></svg>
            </button>
        </div>

        <?php if ( count($all_images) > 1 ) : ?>
        <div class="wcp-thumbs" role="list">
            <?php foreach ($all_images as $i => $aid) :
                $t = wp_get_attachment_image_url($aid,'thumbnail');
                $f = wp_get_attachment_image_url($aid,'large');
                $a = get_post_meta($aid,'_wp_attachment_image_alt',true) ?: get_the_title();
                if (!$t) continue;
            ?>
            <button class="wcp-thumb<?php echo $i===0?' wcp-thumb--on':''; ?>"
                    data-full="<?php echo esc_url($f); ?>"
                    aria-label="Image <?php echo $i+1; ?>">
                <img src="<?php echo esc_url($t); ?>" alt="<?php echo esc_attr($a); ?>" loading="lazy">
            </button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- SUMMARY -->
    <div class="wcp-summary">

        <nav class="wcp-breadcrumb" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
            <span>&rsaquo;</span>
            <a href="<?php echo esc_url(home_url('/hair-collection/')); ?>">Hair Collection</a>
            <?php if ($cat_name) : ?>
            <span>&rsaquo;</span>
            <span><?php echo esc_html($cat_name); ?></span>
            <?php endif; ?>
        </nav>

        <?php if ($cat_name) : ?>
        <span class="wcp-cat"><?php echo esc_html($cat_name); ?></span>
        <?php endif; ?>

        <h1 class="wcp-title"><?php the_title(); ?></h1>

        <div class="wcp-divider"></div>

        <?php if ($price_display) : ?>
        <div class="wcp-price"><span class="price amount"><?php echo esc_html($price_display); ?></span></div>
        <?php endif; ?>

        <div class="wcp-short-desc"><?php the_excerpt(); ?></div>

        <?php if ($lengths) : ?>
        <div class="wcp-attr" style="margin-bottom:1.5rem;">
            <div class="wcp-attr__head">
                <span class="wcp-attr__label">Available Lengths</span>
            </div>
            <div class="wcp-pills">
                <?php foreach ($lengths as $len) : ?>
                <span class="wcp-pill-opt" style="cursor:default;"><?php echo esc_html($len); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>



        <?php if ($wa_url) : ?>
        <a href="<?php echo esc_url(get_theme_mod('ah_booking_url','https://asanteyhair.as.me/')); ?>" class="wcp-book-btn" target="_blank" rel="noopener noreferrer">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Book a Salon Appointment
        </a>

        <a href="<?php echo esc_url($wa_url); ?>" class="wcp-wa" target="_blank" rel="noopener noreferrer">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Order via WhatsApp
        </a>
        <?php endif; ?>

        <div class="wcp-trust">
            <div class="wcp-trust__item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>Secure Checkout</div>
            <div class="wcp-trust__item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>UK Dispatch 2&ndash;3 Days</div>
            <div class="wcp-trust__item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>Single Donor Hair</div>
            <div class="wcp-trust__item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>3&ndash;5 Year Lifespan</div>
        </div>

    </div>
</div>

<!-- TABS -->
<div class="wcp-tabs-section">
    <div class="wrap">
        <div class="wcp-tabs" role="tablist">
            <button class="wcp-tab wcp-tab--on" data-tab="desc" role="tab" aria-selected="true">Description</button>
            <button class="wcp-tab" data-tab="care" role="tab" aria-selected="false">Care Guide</button>
            <button class="wcp-tab" data-tab="ship" role="tab" aria-selected="false">Shipping</button>
        </div>
        <div class="wcp-panel wcp-panel--on" id="wcp-panel-desc" role="tabpanel">
            <div class="wcp-prose"><?php the_content(); ?></div>
        </div>
        <div class="wcp-panel" id="wcp-panel-care" role="tabpanel" hidden>
            <div class="wcp-prose">
                <h3>Hair Care Guide</h3>
                <ul>
                    <li>Wash every 1&ndash;2 weeks with a sulphate-free shampoo.</li>
                    <li>Deep condition from mid-lengths to ends, leave 5 minutes, rinse with lukewarm water.</li>
                    <li>Pat dry &mdash; never rub. Air-dry where possible.</li>
                    <li>Apply heat protectant before any heat styling. Keep tools below 180&deg;C.</li>
                    <li>Sleep on satin or use a satin bonnet. Loosely braid before sleep.</li>
                </ul>
                <p><a href="<?php echo esc_url(home_url('/hair-care-guide/')); ?>">Read the full Hair Care Guide &rarr;</a></p>
            </div>
        </div>
        <div class="wcp-panel" id="wcp-panel-ship" role="tabpanel" hidden>
            <div class="wcp-prose">
                <h3>Shipping &amp; Returns</h3>
                <ul>
                    <li>Standard UK: 2&ndash;3 business days</li>
                    <li>Collect in-store: 358 Radford Road, Nottingham NG7 5GQ</li>
                    <li>Returns: 14 days, unused, original packaging</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- LIGHTBOX -->
<div class="wcp-lb" id="wcp-lb" hidden role="dialog" aria-modal="true">
    <div class="wcp-lb__inner">
        <button class="wcp-lb__close" id="wcp-lb-close">&times;</button>
        <img src="" alt="" id="wcp-lb-img">
    </div>
</div>

<?php endwhile; ?>
<?php get_footer(); ?>
