<?php
/**
 * WooCommerce Shop / Archive Page
 * Asantey Hair & Beauty — safe universal loop pattern
 */
defined( 'ABSPATH' ) || exit;

get_header();

// Hero image with fallback
$hero_candidates = [
    get_template_directory() . '/assets/images/hero-shop.jpg'    => get_template_directory_uri() . '/assets/images/hero-shop.jpg',
    get_template_directory() . '/assets/images/hero-product.jpg' => get_template_directory_uri() . '/assets/images/hero-product.jpg',
    get_template_directory() . '/assets/images/hero-main.jpg'    => get_template_directory_uri() . '/assets/images/hero-main.jpg',
];
$hero_url = '';
foreach ( $hero_candidates as $path => $url ) {
    if ( file_exists( $path ) ) { $hero_url = $url; break; }
}
?>

<!-- ── SHOP HERO ──────────────────────────────────────────────────── -->
<div class="page-hero page-hero--shop">
    <?php if ( $hero_url ) : ?>
    <img src="<?php echo esc_url( $hero_url ); ?>"
         alt="Shop Asantey Hair Collections"
         class="page-hero__img" loading="eager" fetchpriority="high">
    <?php endif; ?>
    <div class="page-hero__overlay"></div>
    <div class="page-hero__content wrap">
        <?php if ( is_product_category() ) :
            $queried = get_queried_object(); ?>
            <h1 class="page-hero__title t-h1"><?php echo esc_html( $queried->name ); ?></h1>
            <?php if ( ! empty( $queried->description ) ) : ?>
                <p class="page-hero__sub"><?php echo esc_html( $queried->description ); ?></p>
            <?php endif; ?>
        <?php else : ?>
            <span class="t-label" style="color:rgba(255,255,255,.45);display:block;margin-bottom:1rem;">Collections</span>
            <h1 class="page-hero__title t-h1">Shop All Hair</h1>
            <p class="page-hero__sub">Cambodian Raw Hair &middot; Virgin Hair &middot; HD Lace Closures &amp; Frontals</p>
        <?php endif; ?>
    </div>
</div>

<!-- ── SHOP CONTENT ──────────────────────────────────────────────── -->
<section class="s s--white wc-main">
    <div class="wrap wc-wrap">

        <?php do_action( 'woocommerce_before_main_content' ); ?>
        <?php woocommerce_output_all_notices(); ?>

        <!-- Category filter bar (shop root only) -->
        <?php if ( ! is_product_category() ) :
            $filter_cats = get_terms( [
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'parent'     => 0,
                'exclude'    => (array) get_option( 'default_product_cat' ),
                'orderby'    => 'name',
            ] );
            if ( ! is_wp_error( $filter_cats ) && $filter_cats ) : ?>
            <div class="wc-filter-bar">
                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="active">All</a>
                <?php foreach ( $filter_cats as $fc ) : ?>
                <a href="<?php echo esc_url( get_term_link( $fc ) ); ?>">
                    <?php echo esc_html( $fc->name ); ?>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Toolbar -->
        <div class="wc-toolbar">
            <?php woocommerce_result_count(); ?>
            <?php woocommerce_catalog_ordering(); ?>
        </div>

        <!-- Product grid -->
        <?php if ( have_posts() ) : ?>

            <?php
            /**
             * Hook: woocommerce_before_shop_loop.
             * @hooked woocommerce_output_all_notices - 10
             */
            do_action( 'woocommerce_before_shop_loop' );
            ?>

            <ul class="products wc-product-grid">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php
                global $product;
                if ( ! $product || ! $product->is_visible() ) continue;

                $thumb_url  = get_the_post_thumbnail_url( get_the_ID(), 'woocommerce_thumbnail' ) ?: wc_placeholder_img_src( 'woocommerce_thumbnail' );
                $prod_title = get_the_title();
                $prod_url   = get_permalink();
                $price_html = $product->get_price_html();
                $prod_cats  = strip_tags( wc_get_product_category_list( get_the_ID(), ', ' ) );
                $is_sale    = $product->is_on_sale();
                $is_feat    = $product->is_featured();
                ?>
                <li <?php wc_product_class( 'wc-card-li', $product ); ?>>
                    <div class="wc-card">

                        <!-- Badges -->
                        <?php if ( $is_sale ) : ?>
                            <span class="wc-badge wc-badge--sale">Sale</span>
                        <?php elseif ( $is_feat ) : ?>
                            <span class="wc-badge wc-badge--new">Featured</span>
                        <?php endif; ?>

                        <!-- Image -->
                        <a href="<?php echo esc_url( $prod_url ); ?>" class="wc-card__img-link" tabindex="-1" aria-hidden="true">
                            <div class="wc-card__img-wrap">
                                <img src="<?php echo esc_url( $thumb_url ); ?>"
                                     alt="<?php echo esc_attr( $prod_title ); ?>"
                                     loading="lazy" width="600" height="800">
                            </div>
                        </a>

                        <!-- Body -->
                        <div class="wc-card__body">
                            <?php if ( $prod_cats ) : ?>
                                <span class="wc-card__cat"><?php echo esc_html( $prod_cats ); ?></span>
                            <?php endif; ?>
                            <h3 class="wc-card__title">
                                <a href="<?php echo esc_url( $prod_url ); ?>"><?php echo esc_html( $prod_title ); ?></a>
                            </h3>
                            <div class="wc-card__price"><?php echo $price_html; ?></div>
                        </div>

                        <!-- CTA -->
                        <div class="wc-card__footer">
                            <?php woocommerce_template_loop_add_to_cart( [ 'quantity' => 1 ] ); ?>
                        </div>

                    </div>
                </li>
            <?php endwhile; ?>
            </ul>

            <?php
            /**
             * Hook: woocommerce_after_shop_loop.
             * @hooked woocommerce_pagination - 10
             */
            do_action( 'woocommerce_after_shop_loop' );
            ?>

        <?php else : ?>
            <?php do_action( 'woocommerce_no_products_found' ); ?>
        <?php endif; ?>

        <?php do_action( 'woocommerce_after_main_content' ); ?>

    </div>
</section>

<style>
/* ── TOOLBAR ─────────────────────────────────────────── */
.wc-toolbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;flex-wrap:wrap;gap:.75rem;padding-bottom:1.5rem;border-bottom:1px solid var(--off)}
.wc-toolbar .woocommerce-result-count{font-family:var(--sans);font-size:.8rem;color:var(--g5);margin:0}
.wc-toolbar .woocommerce-ordering{margin:0}
.wc-toolbar .woocommerce-ordering select{font-family:var(--sans);font-size:.8rem;border:1px solid var(--off);padding:.5rem 2rem .5rem .875rem;background:var(--paper);color:var(--ink);cursor:pointer;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23555' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right .75rem center}

/* ── PRODUCT GRID ────────────────────────────────────── */
ul.products.wc-product-grid{display:grid!important;grid-template-columns:repeat(3,1fr);gap:1.5rem;list-style:none!important;margin:0!important;padding:0!important}
@media(max-width:960px){ul.products.wc-product-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:540px){ul.products.wc-product-grid{grid-template-columns:1fr}}

/* ── PRODUCT CARD ────────────────────────────────────── */
li.wc-card-li{margin:0!important;padding:0!important;list-style:none}
.wc-card{position:relative;background:var(--paper);border:1px solid var(--off);display:flex;flex-direction:column;overflow:hidden;height:100%;transition:transform .3s var(--e),box-shadow .3s var(--e)}
.wc-card:hover{transform:translateY(-5px);box-shadow:0 16px 48px rgba(0,0,0,.1)}

/* Image */
.wc-card__img-link{display:block;overflow:hidden}
.wc-card__img-wrap{aspect-ratio:3/4;overflow:hidden;background:var(--off)}
.wc-card__img-wrap img{width:100%;height:100%;object-fit:cover;object-position:center;transition:transform .6s var(--e);display:block}
.wc-card:hover .wc-card__img-wrap img{transform:scale(1.05)}

/* Badges */
.wc-badge{position:absolute;top:.875rem;left:.875rem;font-family:var(--sans);font-size:.58rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:.3rem .65rem;z-index:2;pointer-events:none}
.wc-badge--sale{background:var(--ink);color:var(--paper)}
.wc-badge--new{background:var(--gold);color:var(--paper)}

/* Body */
.wc-card__body{padding:1.1rem 1.25rem .75rem;flex:1}
.wc-card__cat{display:block;font-family:var(--sans);font-size:.6rem;letter-spacing:.16em;text-transform:uppercase;color:var(--g5);margin-bottom:.3rem}
.wc-card__title{font-family:var(--serif);font-size:clamp(1.05rem,1.6vw,1.3rem);font-weight:400;color:var(--ink);line-height:1.2;margin:0 0 .5rem}
.wc-card__title a{color:inherit;text-decoration:none}
.wc-card__price .price,.wc-card__price .amount{font-family:var(--sans);font-size:.875rem;color:var(--g5)}
.wc-card__price ins{text-decoration:none}.wc-card__price ins .amount{color:var(--ink);font-weight:500}
.wc-card__price del .amount{opacity:.5;font-size:.8rem}

/* Footer / ATC */
.wc-card__footer{padding:.75rem 1.25rem 1.25rem;margin-top:auto}
.wc-card__footer .button,
.wc-card__footer a.button,
.wc-card__footer .add_to_cart_button{display:block!important;width:100%;padding:.75rem 1rem;background:var(--ink)!important;color:var(--paper)!important;font-family:var(--sans)!important;font-size:.68rem!important;font-weight:600;letter-spacing:.12em;text-transform:uppercase;text-align:center;border:none;cursor:pointer;transition:background .2s;text-decoration:none!important}
.wc-card__footer .button:hover,
.wc-card__footer a.button:hover{background:var(--g3)!important}
.wc-card__footer .added_to_cart{display:none!important}
</style>

<?php get_footer(); ?>
