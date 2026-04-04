<?php
/**
 * Template Name: Raw Hair
 * Asantey Hair & Beauty
 */
get_header();

echo ah_schema_breadcrumb([
  ['name' => 'Home',     'url' => home_url('/')],
  ['name' => 'Shop',     'url' => home_url('/shop/')],
  ['name' => 'Raw Hair', 'url' => get_permalink()],
]);

$raw_faqs = [
  ['question' => 'What is Cambodian raw hair?',
   'answer'   => 'Cambodian raw hair is collected directly from a single donor and has never been chemically treated, coloured, or processed in any way. It retains its natural cuticle alignment, which is why it has virtually no tangling or shedding and can last 3–5 years with proper care.'],
  ['question' => 'Can I colour or bleach raw hair?',
   'answer'   => 'Yes. Because raw hair is 100% unprocessed, it responds to chemical treatments like colouring, bleaching, and perming just as your natural hair would. We recommend doing a strand test first and using a professional colourist.'],
  ['question' => 'How long does raw hair last?',
   'answer'   => 'With proper care — regular washing, conditioning, minimal heat, and gentle handling — Asantey Cambodian raw hair typically lasts 3–5 years. Many of our clients still have their bundles in excellent condition after 4 years.'],
  ['question' => 'How many bundles do I need?',
   'answer'   => 'For a full sew-in, most clients need 2–3 bundles. If you\'re using a closure or frontal, 2 bundles is usually sufficient for 12"–18". For 20" and above, 3 bundles is recommended for a fuller look.'],
  ['question' => 'Do all textures come in the same lengths?',
   'answer'   => 'Yes. All raw hair textures — body wave, deep wave, straight, kinky straight, loose wave, loose deep, waver wave, and Burmese curls — are available from 10" to 30" at the same pricing per length.'],
];

echo ah_schema_faq( $raw_faqs );
?>

<div class="ah-header-offset"></div>

<section class="ah-page-hero">
  <div class="ah-page-hero__bg">
    <img src="<?php echo esc_url( AH_URI . '/assets/images/raw-body-wave.jpg' ); ?>"
         alt="" aria-hidden="true" loading="eager" width="1280" height="500">
  </div>
  <div class="ah-page-hero__content">
    <span class="ah-page-hero__label">Cambodian Hair Collection</span>
    <h1 class="ah-page-hero__title">Cambodian Raw<br>Hair Bundles</h1>
    <p class="ah-page-hero__subtitle">
      Unprocessed. Uncoloured. Unapologetically Premium. From &pound;60 per bundle.
    </p>
  </div>
</section>

<?php ah_breadcrumb(); ?>

<!-- What is Raw Hair -->
<section class="ah-split ah-section--sm" id="what-is-raw-hair">
  <div class="ah-split__image">
    <img src="<?php echo esc_url( AH_URI . '/assets/images/raw-kinky-straight.jpg' ); ?>"
         alt="Cambodian raw kinky straight hair — unprocessed single-donor"
         loading="lazy" width="800" height="1000">
  </div>
  <div class="ah-split__content ah-reveal">
    <span class="ah-subheading">What Makes It Different</span>
    <h2 class="ah-heading-md" style="margin:var(--ah-space-4) 0;">What is Raw Hair?</h2>
    <span class="ah-accent-line"></span>
    <p class="ah-body-lg">
      Raw hair is the purest form of hair extension. Collected from a single Cambodian donor,
      it has never been treated with chemicals, heat-processed at the factory, or blended
      with hair from other sources.
    </p>
    <p class="ah-body">
      Because all cuticles run in the same direction — from root to tip — raw hair has
      virtually no friction between strands. That means no tangling, minimal shedding,
      and a natural shine that no coating or silicone spray can replicate.
    </p>
    <p class="ah-body">
      Raw hair can be coloured, bleached, and heat-styled just like your natural hair.
      It absorbs moisture naturally and maintains its pattern through wash after wash.
      When we say it lasts 3–5 years, that's not a marketing line. It's what our
      clients actually experience.
    </p>
    <div class="ah-btn-group" style="margin-top:var(--ah-space-6);">
      <a href="#pricing" class="ah-btn ah-btn--gold">
        View Pricing <?php echo ah_svg('arrow-right'); ?>
      </a>
      <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I\'d like to order Cambodian Raw Hair.')); ?>"
         class="ah-btn ah-btn--outline" target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Order on WhatsApp
      </a>
    </div>
  </div>
</section>

<!-- Trust bar -->
<div class="ah-trust-bar">
  <div class="ah-trust-bar__inner">
    <?php
    $trust = [
      ['sparkle','Single Donor'],
      ['gem','Cuticle Aligned'],
      ['shield','Never Chemically Treated'],
      ['check','3–5 Year Lifespan'],
      ['heart','Minimal Shedding'],
    ];
    foreach($trust as $i => $t):
      echo '<span class="ah-trust-bar__item">' . ah_svg($t[0]) . esc_html($t[1]) . '</span>';
      if($i < count($trust)-1) echo '<span class="ah-trust-bar__divider"></span>';
    endforeach;
    ?>
  </div>
</div>

<!-- Texture Grid -->
<section class="ah-section" id="textures" aria-labelledby="textures-heading">
  <div class="ah-container">
    <div class="ah-section-header--center ah-reveal">
      <span class="ah-subheading">Available Textures</span>
      <h2 id="textures-heading" class="ah-heading-lg">8 Textures. One Standard.</h2>
      <span class="ah-accent-line ah-accent-line--center"></span>
      <p class="ah-body-lg">Every texture available in all lengths, 10"–30", at the same price point.</p>
    </div>

    <div class="ah-texture-grid">
      <?php
      $textures = [
        ['raw-body-wave.jpg',      'Body Wave',     'Natural bounce and movement. The most versatile raw texture.'],
        ['raw-burmese-curls.jpg',  'Burmese Curls', 'Tight, springy curls with incredible definition and volume.'],
        ['raw-deep-wave.jpg',      'Deep Wave',     'Deep S-wave pattern. Holds curl beautifully, wash after wash.'],
        ['raw-kinky-straight.jpg', 'Kinky Straight','Silky with a natural kink. Blends seamlessly with relaxed or natural hair.'],
        ['raw-loose-deep.jpg',     'Loose Deep',    'Relaxed deep wave. Full, bouncy, and effortlessly glamorous.'],
        ['raw-loose-wave.jpg',     'Loose Wave',    'Soft, flowing wave. The bestselling texture in our Raw collection.'],
        ['raw-straight.jpg',       'Straight',      'Ultra-sleek and pin-straight. Curls and holds a wave when styled.'],
        ['raw-waver-wave.jpg',     'Waver Wave',    'Between a loose wave and a body wave. Unique and full of movement.'],
      ];
      $raw_from = array_values( ah_get_pricing('raw') )[0];
      foreach ( $textures as $i => $t ) :
        [$img, $name, $desc] = $t;
        ?>
        <div class="ah-texture-card ah-reveal ah-reveal--delay-<?php echo ($i % 4) + 1; ?>">
          <div class="ah-texture-card__img">
            <img src="<?php echo esc_url( AH_URI . '/assets/images/' . $img ); ?>"
                 alt="Cambodian raw hair — <?php echo esc_attr($name); ?>"
                 loading="lazy" width="300" height="400">
          </div>
          <h3 class="ah-texture-card__name"><?php echo esc_html($name); ?></h3>
          <p class="ah-texture-card__price">from &pound;<?php echo esc_html($raw_from); ?></p>
          <p class="ah-body-sm" style="margin-top:var(--ah-space-2);"><?php echo esc_html($desc); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Full Pricing Table -->
<section class="ah-section ah-section--grey" id="pricing" aria-labelledby="pricing-heading">
  <div class="ah-container">
    <div class="ah-section-header--center ah-reveal">
      <span class="ah-subheading">Transparent Pricing</span>
      <h2 id="pricing-heading" class="ah-heading-lg">Raw Hair Price Per Bundle</h2>
      <span class="ah-accent-line ah-accent-line--center"></span>
      <p class="ah-body">All textures are priced equally by length. Prices are per bundle.</p>
    </div>
    <div style="max-width:700px;margin:0 auto;" class="ah-reveal">
      <?php ah_pricing_table('raw', 'Cambodian Raw Hair', 'Prices are per bundle. All textures priced equally. Lengths 10"–30" available.'); ?>
    </div>
  </div>
</section>

<!-- Care Teaser -->
<section class="ah-split ah-split--reverse ah-section--sm">
  <div class="ah-split__image">
    <img src="<?php echo esc_url( AH_URI . '/assets/images/raw-loose-wave.jpg' ); ?>"
         alt="Caring for your Cambodian raw hair extensions"
         loading="lazy" width="800" height="1000">
  </div>
  <div class="ah-split__content ah-reveal">
    <span class="ah-subheading">Protect Your Investment</span>
    <h2 class="ah-heading-md" style="margin:var(--ah-space-4) 0;">How to Make It Last 5 Years</h2>
    <span class="ah-accent-line"></span>
    <p class="ah-body">
      Raw hair is durable by nature, but the right care routine makes all the difference
      between 2 years and 5. Gentle washing, deep conditioning, minimal heat, and proper
      storage are the four pillars of long-lasting raw hair.
    </p>
    <a href="<?php echo esc_url(home_url('/hair-care-guide/')); ?>"
       class="ah-btn ah-btn--outline" style="margin-top:var(--ah-space-6);">
      Read the Hair Care Guide <?php echo ah_svg('arrow-right'); ?>
    </a>
  </div>
</section>

<!-- FAQ Accordion -->
<section class="ah-section" id="faq" aria-labelledby="faq-heading">
  <div class="ah-container ah-container--sm">
    <div class="ah-section-header--center ah-reveal">
      <span class="ah-subheading">Common Questions</span>
      <h2 id="faq-heading" class="ah-heading-lg">Raw Hair FAQ</h2>
      <span class="ah-accent-line ah-accent-line--center"></span>
    </div>
    <div class="ah-accordion ah-reveal">
      <?php foreach ( $raw_faqs as $faq ) : ?>
        <div class="ah-accordion__item">
          <button class="ah-accordion__trigger" type="button" aria-expanded="false">
            <span class="ah-accordion__question"><?php echo esc_html($faq['question']); ?></span>
            <span class="ah-accordion__icon" aria-hidden="true"><?php echo ah_svg('plus'); ?></span>
          </button>
          <div class="ah-accordion__content">
            <p class="ah-accordion__answer"><?php echo esc_html($faq['answer']); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA -->
<div class="ah-cta-band">
  <div class="ah-container">
    <div class="ah-reveal">
      <span class="ah-cta-band__label">Ready to Order?</span>
      <h2 class="ah-cta-band__heading">Order Your Raw Hair Bundles</h2>
      <p class="ah-cta-band__body">
        WhatsApp us with your texture, length, and quantity — and we&rsquo;ll confirm
        availability and send you an invoice within hours.
      </p>
      <div class="ah-btn-group" style="justify-content:center;">
        <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I\'d like to order Cambodian Raw Hair bundles.')); ?>"
           class="ah-btn ah-btn--whatsapp ah-btn--lg" target="_blank" rel="noopener noreferrer">
          <?php echo ah_svg('whatsapp'); ?> Order on WhatsApp
        </a>
        <a href="<?php echo esc_url(home_url('/order/')); ?>" class="ah-btn ah-btn--outline-white ah-btn--lg">
          Use Order Form
        </a>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
