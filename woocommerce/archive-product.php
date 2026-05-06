<?php
/**
 * WooCommerce Shop/Archive Page
 * Asantey Hair & Beauty custom template
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<!-- Page Hero -->
<div class="page-hero page-hero--shop">
    <?php
    $img = get_template_directory_uri() . '/assets/images/hero-shop.jpg';
    ?>
    <img src="<?php echo esc_url($img); ?>" alt="Shop Asantey Hair Collections" class="page-hero__img" loading="eager">
    <div class="page-hero__overlay"></div>
    <div class="page-hero__content wrap">
        <?php if ( is_product_category() ) :
            $cat = get_queried_object();
            echo '<h1 class="page-hero__title t-h1">' . esc_html($cat->name) . '</h1>';
            if ($cat->description) echo '<p class="page-hero__sub">' . esc_html($cat->description) . '</p>';
        else : ?>
            <span class="t-label" style="color:rgba(255,255,255,.5);display:block;margin-bottom:1rem;">Collections</span>
            <h1 class="page-hero__title t-h1">Shop All Hair</h1>
            <p class="page-hero__sub">Cambodian Raw Hair · Virgin Hair · HD Lace Closures & Frontals</p>
        <?php endif; ?>
    </div>
</div>

<section class="s s--white wc-main">
    <div class="wrap wc-wrap">

        <!-- Category Filter Bar -->
        <?php if ( ! is_product_category() ) : ?>
        <div class="wc-filter-bar">
            <a href="<?php echo esc_url( wc_get_page_permalink('shop') ); ?>"
               class="<?php echo ! is_product_category() ? 'active' : ''; ?>">All</a>
            <?php
            $cats = get_terms(['taxonomy'=>'product_cat','hide_empty'=>true,'parent'=>0,'exclude'=>get_option('default_product_cat')]);
            foreach($cats as $cat) :
                $is_active = is_product_category($cat->slug);
            ?>
            <a href="<?php echo esc_url(get_term_link($cat)); ?>"
               class="<?php echo $is_active ? 'active' : ''; ?>">
                <?php echo esc_html($cat->name); ?>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Toolbar: result count + sorting -->
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
            <?php woocommerce_result_count(); ?>
            <?php woocommerce_catalog_ordering(); ?>
        </div>

        <?php if ( woocommerce_product_loop() ) : ?>
            <?php woocommerce_product_loop_start(); ?>
                <?php woocommerce_shop_loop(); ?>
            <?php woocommerce_product_loop_end(); ?>
            <?php woocommerce_pagination(); ?>
        <?php else : ?>
            <?php do_action( 'woocommerce_no_products_found' ); ?>
        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>
