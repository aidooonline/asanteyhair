<?php
/**
 * Template Name: Shipping & Returns
 * Asantey Hair & Beauty
 */
get_header();
echo ah_schema_breadcrumb([['name'=>'Home','url'=>home_url('/')],['name'=>'Shipping &amp; Returns','url'=>get_permalink()]]);
?>
<div class="ah-header-offset"></div>
<section class="ah-page-hero"><div class="ah-page-hero__content"><span class="ah-page-hero__label">Policies</span><h1 class="ah-page-hero__title">Shipping &amp; Returns</h1><p class="ah-page-hero__subtitle">Everything you need to know about delivery and our returns process.</p></div></section>
<?php ah_breadcrumb(); ?>

<div class="ah-legal">
  <p class="ah-last-updated">Last Updated: January 2024</p>

  <h2>UK Delivery</h2>
  <p>All orders are dispatched within <strong>2–3 business days</strong> of confirmed payment. We use tracked shipping services for all UK orders. Standard delivery typically takes <strong>1–3 business days</strong> from dispatch.</p>
  <p>A tracking number will be sent to you via email or WhatsApp once your order has been dispatched. You can use this to monitor your delivery in real time.</p>

  <h2>Express Delivery</h2>
  <p>If you require your order urgently, please contact us via WhatsApp before placing your order. Express delivery options are available at an additional cost and are subject to availability at the time of your order.</p>

  <h2>International Shipping</h2>
  <p>We currently ship primarily within the United Kingdom. For international orders, please contact us via WhatsApp or the <a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact page</a> before ordering to confirm availability, shipping costs, and estimated delivery times to your location.</p>
  <p>Please note that international customers may be responsible for any import duties, taxes, or customs fees applicable in their country. Asantey Hair &amp; Beauty is not liable for any such charges.</p>

  <h2>Order Processing</h2>
  <p>Orders placed over the weekend or on UK bank holidays will be processed on the next working business day. During peak periods (e.g. around major holidays), processing times may be slightly longer. We will communicate any delays promptly via email or WhatsApp.</p>

  <h2>Returns Policy</h2>
  <p>Due to the personal nature of hair extension products, <strong>we are unable to accept returns on opened hair</strong>. This policy is in place to protect the hygiene and quality standards of all our products.</p>
  <p>If your order arrives:</p>
  <ul>
    <li>Damaged or defective</li>
    <li>Incorrectly described or labelled</li>
    <li>Different from what you ordered</li>
  </ul>
  <p>Please contact us within <strong>48 hours of delivery</strong> with photographic evidence of the issue. We will review the situation and arrange a replacement or refund as appropriate.</p>

  <h2>Exchanges</h2>
  <p>Exchanges for <strong>unopened, sealed bundles</strong> may be considered within 14 days of delivery if you have ordered the wrong length or texture. The product must be in its original, unopened packaging. Please contact us via WhatsApp or email to discuss your situation before sending anything back.</p>
  <p>We reserve the right to decline exchange requests if the product appears to have been opened, used, or tampered with.</p>

  <h2>Refunds</h2>
  <p>Where a refund is agreed upon, it will be processed within <strong>5–10 business days</strong> via the original payment method. Asantey Hair &amp; Beauty is not responsible for any delays caused by your bank or payment provider.</p>

  <h2>Contact Us</h2>
  <p>For any questions about shipping or returns, please reach out:</p>
  <ul>
    <?php if(get_theme_mod('ah_whatsapp_number')): ?><li>WhatsApp: <a href="<?php echo esc_url(ah_whatsapp_url()); ?>"><?php echo esc_html(get_theme_mod('ah_whatsapp_number')); ?></a></li><?php endif; ?>
    <?php if(get_theme_mod('ah_contact_email')): ?><li>Email: <a href="mailto:<?php echo esc_attr(get_theme_mod('ah_contact_email')); ?>"><?php echo esc_html(get_theme_mod('ah_contact_email')); ?></a></li><?php endif; ?>
  </ul>
</div>

<?php get_footer(); ?>
