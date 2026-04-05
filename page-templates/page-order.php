<?php
/**
 * Template Name: Order Enquiry
 * Asantey Hair & Beauty
 */
get_header();
echo ah_schema_breadcrumb([['name'=>'Home','url'=>home_url('/')],['name'=>'Order Enquiry','url'=>get_permalink()]]);
?>

<div class="header-offset"></div>
<section class="page-hero">
  <div class="page-hero__content">
    <span class="t-label">Place Your Order</span>
    <h1 class="t-h1">Order Enquiry</h1>
    <p >Fill in the form below and we&rsquo;ll confirm availability and send your invoice within 24 hours.</p>
  </div>
</section>
<?php ah_breadcrumb(); ?>

<section class="section">
  <div class="wrap">
    <div class="grid-2" style="gap:4rem;align-items:start;">

      <!-- How It Works -->
      <div class="reveal">
        <span class="t-label">Simple &amp; Straightforward</span>
        <h2 class="t-h3" style="margin:1rem 0;">How Ordering Works</h2>
        <span class="rule"></span>
        <div class="steps" style="grid-template-columns:1fr;margin-top:2rem;">
          <?php
          $steps = [
            ['Fill in the Order Form','Select your product category, texture, length, and quantity. Add any special requests in the notes field.'],
            ['We Confirm & Invoice','We&rsquo;ll confirm availability and send you an invoice with payment details within 24 hours — often within a few hours.'],
            ['Payment & Dispatch','Once payment is received, your hair is prepared and dispatched within 2–3 business days with a tracking number.'],
          ];
          foreach($steps as $s): ?>
            <div class="step">
              <h3 class="step__title"><?php echo esc_html($s[0]); ?></h3>
              <p class="step__body"><?php echo $s[1]; ?></p>
            </div>
          <?php endforeach; ?>
        </div>

        <div style="margin-top:2.5rem;padding:1.5rem;background:#f8f8f8;border-left:3px solid var(--gold);">
          <h4 style="font-family:var(--ah-font-display);font-size:var(--ah-text-2xl);margin-bottom:var(--gap2);">Prefer WhatsApp?</h4>
          <p class="t-body" style="margin-bottom:1.25rem;">If you&rsquo;d rather order directly and get an instant response, WhatsApp is always the fastest route.</p>
          <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I\'d like to place an order.')); ?>"
             class="btn btn--wa" target="_blank" rel="noopener noreferrer">
            <?php echo ah_svg('whatsapp'); ?> Order on WhatsApp
          </a>
        </div>
      </div>

      <!-- Order Form -->
      <div class="reveal d2">
        <span class="t-label">Ready to Order?</span>
        <h2 class="t-h3" style="margin:1rem 0;">Order Enquiry Form</h2>
        <span class="rule"></span>
        <p class="t-body" style="margin-bottom:2rem;">
          Complete the form and we&rsquo;ll send a confirmation and invoice within 24 hours.
          You&rsquo;ll also receive an automatic copy of your enquiry.
        </p>
        <?php ah_order_form(); ?>
      </div>

    </div>
  </div>
</section>

<!-- Product Quick Links -->
<section class="section section--grey">
  <div class="wrap">
    <div class="sh sh--c reveal">
      <span class="t-label">Browse Before You Order</span>
      <h2 class="t-h2">View Full Collections</h2>
      <span class="rule rule--center"></span>
    </div>
    <div class="grid-3">
      <?php
      $products = [
        ['Cambodian Raw Hair','Unprocessed. Single-donor. 10+ textures, 10"–30".','60',home_url('/raw-hair/'),'raw-straight.jpg'],
        ['Cambodian Virgin Hair','Pure quality. Minimal shedding. 3–5 year lifespan.','50',home_url('/virgin-hair/'),'raw-body-wave.jpg'],
        ['HD Lace Closures & Frontals','Invisible HD lace. 6 sizes. All textures available.','49',home_url('/closures-frontals/'),'hd-lace-sizes.png'],
      ];
      foreach($products as $i=>$p): ?>
        <div class="ah-reveal ah-reveal--delay-<?php echo $i+1; ?>" style="background:#ffffff;overflow:hidden;">
          <div style="aspect-ratio:4/3;overflow:hidden;">
            <img src="<?php echo esc_url(AH_URI.'/assets/images/'.$p[4]); ?>" alt="<?php echo esc_attr($p[0]); ?>" loading="lazy" width="600" height="450" style="width:100%;height:100%;object-fit:cover;">
          </div>
          <div style="padding:1.5rem;">
            <h3 style="font-family:var(--ah-font-display);font-size:var(--ah-text-2xl);margin-bottom:var(--gap2);"><?php echo esc_html($p[0]); ?></h3>
            <p style="font-size:var(--ah-text-sm);color:var(--g5);margin-bottom:1rem;"><?php echo esc_html($p[1]); ?></p>
            <p style="font-family:var(--ah-font-display);font-size:var(--ah-text-xl);font-weight:600;margin-bottom:1rem;">from &pound;<?php echo esc_html($p[2]); ?></p>
            <a href="<?php echo esc_url($p[3]); ?>" class="btn btn--outline btn--sm">View Collection <?php echo ah_svg('arrow-right'); ?></a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
