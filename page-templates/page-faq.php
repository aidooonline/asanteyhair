<?php
/**
 * Template Name: FAQ
 * Asantey Hair & Beauty
 */
get_header();

$all_faqs = [
  'About Our Hair' => [
    ['What is the difference between raw hair and virgin hair?',
     'Raw hair is the most unprocessed form of hair — collected directly from a single donor with zero factory treatment. Virgin hair may undergo light steam processing to set a wave, but is never chemically altered. Both are 100% human hair; raw hair is the purest option available.'],
    ['How long does Asantey hair last?',
     'With proper care, our Cambodian raw and virgin hair lasts 3–5 years. This is based on real client experience — not a marketing claim. The key factors are gentle washing, regular moisturising, heat protection, and protective styling at night.'],
    ['Is the hair 100% human?',
     'Yes. Every bundle, closure, and frontal in our collection is 100% human Cambodian hair. We never blend with synthetic fibres, Yaki fibre, or hair from multiple donors. What you receive is exactly what we say it is.'],
    ['Does the hair shed or tangle?',
     'Minimal shedding and zero tangling is the Asantey standard. Because all cuticles run in the same direction (root to tip), there is no inter-strand friction — which is the primary cause of tangling in lower-quality hair. Some initial light shedding during the first wash is normal for any new hair extension.'],
    ['Can I colour or bleach the hair?',
     'Yes. Our raw hair is particularly well-suited to colouring and bleaching because it has never been chemically altered. We recommend doing a strand test first and working with a professional colourist. Virgin hair can also be coloured, though we advise caution when bleaching.'],
  ],
  'Ordering & Shipping' => [
    ['How do I place an order?',
     'You can order directly via WhatsApp, which is the fastest option, or use our Order Enquiry form on the website. We confirm availability and send an invoice within a few hours. Payment options will be provided at invoice stage.'],
    ['How long does delivery take?',
     'We dispatch orders within 2–3 business days of confirmed payment. Standard UK delivery then takes 1–3 business days. Express delivery options are available on request — WhatsApp us if you need your order urgently.'],
    ['Do you ship internationally?',
     'We currently ship primarily within the UK. For international orders, please WhatsApp us before placing an order so we can confirm availability and shipping costs to your location.'],
    ['What payment methods do you accept?',
     'We accept bank transfer and major debit/credit cards. Payment details are provided with your invoice. We do not accept cash on delivery.'],
    ['Can I track my order?',
     'Yes. Once your order is dispatched, you will receive a tracking number via email or WhatsApp. You can use this to track your delivery in real time.'],
  ],
  'HD Lace & Closures' => [
    ['What is HD lace?',
     'HD (High Definition) lace is an ultra-thin, transparent Swiss lace that virtually disappears against the skin without needing to be tinted or bleached. It adapts to any skin tone naturally, creating the illusion of a completely undetectable hairline.'],
    ['Which closure size is right for me?',
     'The 4x4 is most popular for a natural centre or side parting. The 5x5 and 6x6 offer a wider parting area and more versatility. The 2x6 is ideal for a deep centre part. The 13x4 and 13x6 frontals offer full ear-to-ear coverage for the most natural hairline possible.'],
    ['Do I need to bleach HD lace?',
     'No. That is one of the key advantages of HD lace. Unlike regular lace, HD lace does not need to be bleached to match your skin tone — it becomes virtually invisible against any complexion naturally.'],
    ['What textures are available for closures and frontals?',
     'Our HD lace closures and frontals are available in: Straight, Kinky Straight, Yaki Straight, Deep Wave, Body Wave, Loose Wave, Water Wave, and Burmese Curls. All textures are available in all sizes and lengths (12"–22").'],
    ['How many bundles do I need with my closure?',
     'For 12"–18" installs, 2 bundles. For 20"–24", 2–3 bundles. For 26"–30", 3 bundles. With a frontal, you may be able to use one fewer bundle than with a closure for the same length. Not sure? WhatsApp us for personalised advice.'],
  ],
  'Hair Care' => [
    ['How often should I wash my extensions?',
     'We recommend washing every 1–2 weeks. Over-washing strips natural oils; under-washing leads to product buildup. Always use a sulphate-free shampoo and deep condition after every wash.'],
    ['What products should I use on Cambodian hair?',
     'Use sulphate-free and alcohol-free shampoos and conditioners. Lightweight oils (argan, jojoba, castor) work well on the mid-lengths and ends. Avoid products with heavy silicones, which coat the hair and prevent moisture absorption over time.'],
    ['Can I swim or exercise with my extensions?',
     'Swimming in chlorinated pools or salt water will dry out your hair extensions over time. If you do swim, wear a silicone swim cap and wash your hair immediately after with a moisturising shampoo. Exercise is fine — just ensure you wash and re-moisturise after heavy sweat sessions.'],
    ['How do I keep my hair from tangling?',
     'Keep the hair moisturised, detangle gently from tip to root (never root to tip), sleep on satin or silk, and ensure you are not over-washing. Tangling in Asantey hair is almost always a moisture issue — consistent conditioning resolves it.'],
  ],
  'Returns & Refunds' => [
    ['What is your return policy?',
     'Due to the nature of hair extensions, we are unable to accept returns on opened hair. If your hair arrives damaged, incorrectly described, or defective, please WhatsApp us with photos within 48 hours of delivery and we will resolve the issue promptly.'],
    ['What if my hair arrives damaged?',
     'We take great care in packaging, but if your order arrives damaged, contact us within 48 hours with photos. We will arrange a replacement or refund as appropriate. Your satisfaction is our priority.'],
    ['Can I exchange my order for a different length or texture?',
     'Exchanges for unopened bundles may be possible within 14 days of delivery. Contact us via WhatsApp or email to discuss your situation. Opened hair cannot be exchanged for hygiene reasons.'],
    ['My hair has started tangling — what should I do?',
     'First, assess your care routine. Most tangling issues in high-quality hair are moisture-related. Deep condition, add a leave-in conditioner, and ensure you are sleeping on satin or silk. If the issue persists and you believe it is a quality fault, contact us and we will review the situation.'],
  ],
];

// Flatten for schema
$schema_faqs = [];
foreach($all_faqs as $faqs) {
  foreach($faqs as $faq) {
    $schema_faqs[] = ['question' => $faq[0], 'answer' => $faq[1]];
  }
}

echo ah_schema_faq($schema_faqs);
echo ah_schema_breadcrumb([['name'=>'Home','url'=>home_url('/')],['name'=>'FAQ','url'=>get_permalink()]]);
?>

<section class="page-hero">
  <div class="page-hero__content">
    <span class="t-label">Got Questions?</span>
    <h1 class="t-h1">Frequently Asked<br>Questions</h1>
    <p >Everything you need to know about our hair, ordering, and care. Still unsure? WhatsApp us.</p>
  </div>
</section>
<?php ah_breadcrumb(); ?>

<section class="s">
  <div class="wrap wrap--narrow">
    <?php foreach($all_faqs as $category => $faqs): ?>
      <div style="margin-bottom:4rem;" class="reveal">
        <span class="t-label"><?php echo esc_html($category); ?></span>
        <h2 class="t-h4" style="margin:0.75rem 0 2rem;"><?php echo esc_html($category); ?></h2>
        <div class="accordion">
          <?php foreach($faqs as $faq): ?>
            <div class="accordion__item">
              <button class="acc__trigger" type="button" aria-expanded="false">
                <span class="acc__q"><?php echo esc_html($faq[0]); ?></span>
                <span class="acc__icon"><?php echo ah_svg('plus'); ?></span>
              </button>
              <div class="acc__body"><p class="acc__ans"><?php echo esc_html($faq[1]); ?></p></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>

    <div class="reveal" style="background:#f8f8f8;padding:2.5rem;text-align:center;">
      <h3 class="t-h4" style="margin-bottom:0.75rem;">Still Have Questions?</h3>
      <p class="t-body" style="margin-bottom:1.5rem;">Our team is available on WhatsApp to help you choose the right product, answer care questions, or assist with your order.</p>
      <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I have a question about Asantey Hair & Beauty.')); ?>"
         class="btn btn--wa" target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Chat with Us on WhatsApp
      </a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
