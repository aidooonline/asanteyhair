<?php
/**
 * WooCommerce Checkout Page
 * Asantey Hair & Beauty custom template
 */
defined( 'ABSPATH' ) || exit;
get_header(); ?>

<div class="page-hero page-hero--short" style="height:28vh;min-height:200px;">
    <div class="page-hero__overlay" style="background:var(--ink);opacity:.96;"></div>
    <div class="page-hero__content wrap">
        <span class="t-label" style="color:rgba(255,255,255,.4);display:block;margin-bottom:.75rem;">Almost There</span>
        <h1 class="page-hero__title t-h1">Checkout</h1>
    </div>
</div>

<section class="s s--white wc-main woocommerce-checkout">
    <div class="wrap wc-wrap" style="max-width:1100px;margin-inline:auto;">
        <?php woocommerce_output_all_notices(); ?>
        <?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>
        <?php woocommerce_checkout_form(); ?>
        <?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
    </div>
</section>

<?php get_footer(); ?>
