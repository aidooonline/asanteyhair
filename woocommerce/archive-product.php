<?php
/**
 * Asantey Hair & Beauty — Shop / Archive Page
 * Dark editorial design. Self-contained. WooCommerce 4.x+ compatible.
 */
defined( 'ABSPATH' ) || exit;
get_header();

/* hero */
$hero_url = '';
foreach ( ['hero-shop.jpg','hero-product.jpg','hero-main.jpg'] as $f ) {
    if ( file_exists( get_template_directory() . '/assets/images/' . $f ) ) {
        $hero_url = get_template_directory_uri() . '/assets/images/' . $f;
        break;
    }
}

/* filter terms */
$filter_terms = get_terms(['taxonomy'=>'product_cat','hide_empty'=>true,'parent'=>0,
    'exclude'=>(array)get_option('default_product_cat'),'orderby'=>'name']);
if ( is_wp_error($filter_terms) ) $filter_terms = [];

$current_cat = is_product_category() ? get_queried_object() : null;
$shop_url    = wc_get_page_permalink('shop');
?>

<div class="wcs-hero">
    <?php if ($hero_url) : ?>
    <img class="wcs-hero__bg" src="<?php echo esc_url($hero_url); ?>" alt="" loading="eager" fetchpriority="high" aria-hidden="true">
    <?php endif; ?>
    <div class="wcs-hero__overlay"></div>
    <div class="wcs-hero__body wrap">
        <span class="wcs-hero__eyebrow"><?php echo $current_cat ? esc_html($current_cat->name) : 'Collections'; ?></span>
        <h1 class="wcs-hero__title"><?php echo $current_cat ? esc_html($current_cat->name) : 'Shop All Hair'; ?></h1>
        <?php if ($current_cat && $current_cat->description) : ?>
            <p class="wcs-hero__sub"><?php echo esc_html($current_cat->description); ?></p>
        <?php elseif (!$current_cat) : ?>
            <p class="wcs-hero__sub">Cambodian Raw &middot; Virgin Hair &middot; HD Lace Closures &amp; Frontals</p>
        <?php endif; ?>
    </div>
</div>

<div class="wcs-body">

    <div class="wcs-filters-wrap">
        <nav class="wcs-filters wrap" aria-label="Filter products">
            <a href="<?php echo esc_url($shop_url); ?>" class="wcs-pill<?php echo !is_product_category() ? ' wcs-pill--on' : ''; ?>">All</a>
            <?php foreach ($filter_terms as $ft) : ?>
            <a href="<?php echo esc_url(get_term_link($ft)); ?>"
               class="wcs-pill<?php echo ($current_cat && $current_cat->term_id===$ft->term_id) ? ' wcs-pill--on' : ''; ?>">
                <?php echo esc_html($ft->name); ?>
            </a>
            <?php endforeach; ?>
        </nav>
    </div>

    <div class="wcs-toolbar wrap">
        <?php woocommerce_result_count(); ?>
        <?php woocommerce_catalog_ordering(); ?>
    </div>

    <div class="wrap">
        <?php woocommerce_output_all_notices(); ?>

        <?php if (have_posts()) : ?>
        <ul class="wcs-grid">
        <?php $n=0; while (have_posts()) : the_post(); global $product;
            if (!$product||!$product->is_visible()) continue;
            $n++;
            $img_id     = $product->get_image_id();
            $img_url    = $img_id ? wp_get_attachment_image_url($img_id,'woocommerce_thumbnail') : wc_placeholder_img_src();
            $img_2x     = $img_id ? wp_get_attachment_image_url($img_id,'woocommerce_single') : '';
            $prod_title = get_the_title();
            $prod_url   = get_permalink();
            $price_html = $product->get_price_html();
            $cats_str   = strip_tags(wc_get_product_category_list(get_the_ID(),' &middot; '));
            $is_sale    = $product->is_on_sale();
            $is_feat    = $product->is_featured();
        ?>
        <li class="wcs-item">
            <a href="<?php echo esc_url($prod_url); ?>" class="wcs-card" aria-label="<?php echo esc_attr($prod_title); ?>">
                <?php if ($is_sale) : ?><span class="wcs-badge wcs-badge--sale">Sale</span><?php
                elseif ($is_feat) : ?><span class="wcs-badge wcs-badge--feat">Featured</span><?php endif; ?>
                <div class="wcs-card__img-box">
                    <img src="<?php echo esc_url($img_url); ?>"
                         <?php if ($img_2x) echo 'data-full="'.esc_url($img_2x).'"'; ?>
                         alt="<?php echo esc_attr($prod_title); ?>"
                         loading="<?php echo $n<=4?'eager':'lazy'; ?>"
                         width="600" height="750">
                    <div class="wcs-card__overlay" aria-hidden="true">
                        <span class="wcs-card__cta-text">View Product <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
                    </div>
                </div>
                <div class="wcs-card__body">
                    <?php if ($cats_str) : ?><span class="wcs-card__cat"><?php echo $cats_str; ?></span><?php endif; ?>
                    <h2 class="wcs-card__name"><?php echo esc_html($prod_title); ?></h2>
                    <div class="wcs-card__price"><?php echo $price_html; ?></div>
                </div>
            </a>
        </li>
        <?php endwhile; ?>
        </ul>

        <div class="wcs-pagination">
        <?php
        $big = 999999999;
        echo paginate_links([
            'base'      => str_replace($big,'%#%',esc_url(get_pagenum_link($big))),
            'format'    => '?paged=%#%',
            'current'   => max(1,get_query_var('paged')),
            'total'     => $GLOBALS['wp_query']->max_num_pages,
            'prev_text' => '&larr;',
            'next_text' => '&rarr;',
        ]);
        ?>
        </div>

        <?php else : ?>
        <div class="wcs-empty">
            <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39A2 2 0 009.07 16h9.86a2 2 0 001.96-1.61L23 6H6"/></svg>
            <p>No products found</p>
            <a href="<?php echo esc_url($shop_url); ?>" class="wcs-btn">View All Products</a>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
