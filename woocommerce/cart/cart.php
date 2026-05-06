<?php
/**
 * WooCommerce Cart Page
 * Asantey Hair & Beauty custom template
 */
defined( 'ABSPATH' ) || exit;
get_header(); ?>

<div class="page-hero page-hero--short" style="height:30vh;min-height:220px;">
    <div class="page-hero__overlay" style="background:var(--ink);opacity:.96;"></div>
    <div class="page-hero__content wrap">
        <span class="t-label" style="color:rgba(255,255,255,.4);display:block;margin-bottom:.75rem;">Review</span>
        <h1 class="page-hero__title t-h1">Your Bag</h1>
    </div>
</div>

<section class="s s--white wc-main woocommerce-cart">
    <div class="wrap wc-wrap">
        <?php woocommerce_output_all_notices(); ?>
        <?php do_action( 'woocommerce_before_cart' ); ?>
        <?php woocommerce_cart(); ?>
        <?php do_action( 'woocommerce_after_cart' ); ?>
    </div>
</section>

<?php get_footer(); ?>
