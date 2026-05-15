<?php
/**
 * Asantey Hair & Beauty — Cart Page
 * Professional two-column layout
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<div class="ah-cart-page">

    <!-- Page Header -->
    <div class="ah-cart-header">
        <div class="ah-cart-header__inner">
            <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="ah-cart-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                Continue Shopping
            </a>
            <h1 class="ah-cart-header__title">Your Bag</h1>
            <span class="ah-cart-header__count">
                <?php
                $count = WC()->cart->get_cart_contents_count();
                echo $count . ' ' . _n('item','items',$count,'asantey-theme');
                ?>
            </span>
        </div>
    </div>

    <div class="ah-cart-body">
        <?php woocommerce_output_all_notices(); ?>
        <?php do_action('woocommerce_before_cart'); ?>

        <?php if ( WC()->cart->is_empty() ) : ?>
        <!-- Empty Cart -->
        <div class="ah-cart-empty">
            <div class="ah-cart-empty__icon">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 01-8 0"/>
                </svg>
            </div>
            <h2>Your bag is empty</h2>
            <p>Discover our premium Cambodian hair collections and find your perfect match.</p>
            <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="ah-cart-empty__btn">
                Shop Collections
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

        <?php else : ?>
        <!-- Cart with items — two column layout -->
        <form class="ah-cart-form woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

            <!-- LEFT: Cart Items -->
            <div class="ah-cart-items">
                <div class="ah-cart-items__head">
                    <span>Product</span>
                    <span>Price</span>
                    <span>Qty</span>
                    <span>Total</span>
                </div>

                <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                    $_product   = $cart_item['data'];
                    $product_id = $cart_item['product_id'];
                    if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] == 0 ) continue;

                    $thumbnail  = $_product->get_image('woocommerce_thumbnail');
                    $permalink  = $_product->get_permalink($cart_item);
                    $price      = WC()->cart->get_product_price($_product);
                    $subtotal   = WC()->cart->get_product_subtotal($_product,$cart_item['quantity']);
                    $item_name  = $_product->get_name();
                ?>
                <div class="ah-cart-item">
                    <!-- Remove -->
                    <div class="ah-cart-item__remove">
                        <?php
                        echo apply_filters('woocommerce_cart_item_remove_link',
                            sprintf(
                                '<a href="%s" class="ah-remove-item" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                </a>',
                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                esc_attr__('Remove this item','asantey-theme'),
                                esc_attr($product_id),
                                esc_attr($cart_item_key),
                                esc_attr($_product->get_sku())
                            ),
                            $cart_item_key
                        );
                        ?>
                    </div>

                    <!-- Image + Name -->
                    <div class="ah-cart-item__product">
                        <a href="<?php echo esc_url($permalink); ?>" class="ah-cart-item__img">
                            <?php echo $thumbnail; ?>
                        </a>
                        <div class="ah-cart-item__info">
                            <a href="<?php echo esc_url($permalink); ?>" class="ah-cart-item__name">
                                <?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name',$item_name,$cart_item,$cart_item_key)); ?>
                            </a>
                            <?php echo wc_get_formatted_cart_item_data($cart_item); ?>
                        </div>
                    </div>

                    <!-- Unit Price -->
                    <div class="ah-cart-item__price" data-label="Price">
                        <?php echo apply_filters('woocommerce_cart_item_price',WC()->cart->get_product_price($_product),$cart_item,$cart_item_key); ?>
                    </div>

                    <!-- Quantity -->
                    <div class="ah-cart-item__qty" data-label="Qty">
                        <?php
                        $qty_input = woocommerce_quantity_input([
                            'input_name'   => "cart[{$cart_item_key}][qty]",
                            'input_value'  => $cart_item['quantity'],
                            'max_value'    => $_product->get_max_purchase_quantity(),
                            'min_value'    => '0',
                            'product_name' => $item_name,
                        ], $_product, false);
                        echo $qty_input;
                        ?>
                    </div>

                    <!-- Subtotal -->
                    <div class="ah-cart-item__subtotal" data-label="Total">
                        <?php echo apply_filters('woocommerce_cart_item_subtotal',WC()->cart->get_product_subtotal($_product,$cart_item['quantity']),$cart_item,$cart_item_key); ?>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Actions row -->
                <div class="ah-cart-actions">
                    <div class="ah-cart-coupon">
                        <input type="text"
                               name="coupon_code"
                               id="coupon_code"
                               class="input-text"
                               value=""
                               placeholder="Coupon code">
                        <button type="submit"
                                class="ah-cart-coupon__btn"
                                name="apply_coupon"
                                value="<?php esc_attr_e('Apply coupon','woocommerce'); ?>">
                            Apply
                        </button>
                    </div>
                    <button type="submit"
                            class="ah-cart-update"
                            name="update_cart"
                            value="Update cart">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/></svg>
                        Update Bag
                    </button>
                    <?php wp_nonce_field('woocommerce-cart','woocommerce-cart-nonce'); ?>
                    <?php do_action('woocommerce_cart_actions'); ?>
                </div>
            </div><!-- /.ah-cart-items -->

            <!-- RIGHT: Order Summary -->
            <div class="ah-cart-summary">
                <h2 class="ah-cart-summary__title">Order Summary</h2>

                <?php do_action('woocommerce_before_cart_totals'); ?>

                <div class="ah-cart-summary__rows">
                    <div class="ah-cart-summary__row">
                        <span>Subtotal</span>
                        <span><?php wc_cart_totals_subtotal_html(); ?></span>
                    </div>

                    <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
                    <div class="ah-cart-summary__row ah-cart-summary__row--discount">
                        <span>Discount (<?php echo esc_html($code); ?>)</span>
                        <span><?php wc_cart_totals_coupon_html($coupon); ?></span>
                    </div>
                    <?php endforeach; ?>

                    <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
                    <div class="ah-cart-summary__row">
                        <span>Shipping</span>
                        <span><?php woocommerce_cart_totals_shipping_html(); ?></span>
                    </div>
                    <?php endif; ?>

                    <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                    <div class="ah-cart-summary__row">
                        <span><?php echo esc_html($fee->name); ?></span>
                        <span><?php wc_cart_totals_fee_html($fee); ?></span>
                    </div>
                    <?php endforeach; ?>

                    <?php if ( wc_tax_enabled() && 'excl' === WC()->cart->get_tax_price_display_mode() ) : ?>
                    <div class="ah-cart-summary__row">
                        <span><?php echo esc_html(WC()->countries->tax_or_vat()); ?></span>
                        <span><?php wc_cart_totals_taxes_total_html(); ?></span>
                    </div>
                    <?php endif; ?>

                    <div class="ah-cart-summary__row ah-cart-summary__row--total">
                        <span>Total</span>
                        <span><?php wc_cart_totals_order_total_html(); ?></span>
                    </div>
                </div>

                <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="ah-cart-checkout-btn">
                    Proceed to Checkout
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>

                <!-- Trust badges -->
                <div class="ah-cart-trust">
                    <div class="ah-cart-trust__item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Secure Checkout
                    </div>
                    <div class="ah-cart-trust__item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                        UK Dispatch 2&ndash;3 Days
                    </div>
                    <div class="ah-cart-trust__item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        Single Donor Hair
                    </div>
                    <div class="ah-cart-trust__item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        3&ndash;5 Year Lifespan
                    </div>
                </div>

                <?php do_action('woocommerce_after_cart_totals'); ?>
            </div><!-- /.ah-cart-summary -->

        </form>

        <?php do_action('woocommerce_after_cart'); ?>
        <?php endif; ?>
    </div><!-- /.ah-cart-body -->

</div><!-- /.ah-cart-page -->

<?php get_footer(); ?>
