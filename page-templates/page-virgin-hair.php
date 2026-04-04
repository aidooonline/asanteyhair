<?php
/**
 * Template Name: Virgin Hair
 * Asantey Hair & Beauty
 */
get_header();

echo ah_schema_breadcrumb([
  ['name' => 'Home',        'url' => home_url('/')],
  ['name' => 'Shop',        'url' => home_url('/shop/')],
  ['name' => 'Virgin Hair', 'url' => get_permalink()],
]);

$faqs = [
  ['question' => 'What is virgin hair?',
   'answer'   => 'Virgin hair is human hair collected from a single donor that has never been chemically processed, permed, or altered. Unlike raw hair, virgin hair may undergo light factory cleaning and steam processing to set a wave pattern, but it is never dyed or bleached.'],
  ['question' => 'What is the difference between raw hair and virgin hair?',
   'answer'   => 'Raw hair is the most unprocessed option — collected directly from the donor with no factory processing whatsoever. Virgin hair has undergone minimal steam processing to set its texture, but is otherwise natural. Both are 100% human hair with no chemical treatment.'],
  ['question' => 'How long does Asantey virgin hair last?',
   'answer'   => 'With proper care, our Cambodian virgin hair lasts 3–5 years. Regular moisturising, protective styling at night, and limiting heat exposure are the key factors in extending its lifespan.'],
  ['question' => 'Can I dye virgin hair?',
   'answer'   => 'Yes. Virgin hair can be coloured. However, we recommend going no more than 2 shades lighter without professional help. Bleaching is possible but may slightly reduce lifespan depending on the process used.'],
];

echo ah_schema_faq($faqs);
?>

<div class="ah-header-offset"></div>

<section class="ah-page-hero">
  <div class="ah-page-hero__bg">
    <img src="<?php echo esc_url( AH_URI . '/assets/images/virgin-body-wave.png' ); ?>"
         alt="" aria-hidden="true" loading="eager" width="1280" height="500">
  </div>
  <div class="ah-page-hero__content">
    <span class="ah-page-hero__label">Cambodian Hair Collection</span>
    <h1 class="ah-page-hero__title">Cambodian Virgin<br>Hair Bundles</h1>
    <p class="ah-page-hero__subtitle">Pure Quality. Lasting Beauty. From &pound;50 per bundle.</p>
  </div>
</section>

<?php ah_breadcrumb(); ?>

<section class="ah-split ah-section--sm">
  <div class="ah-split__image">
    <img src="<?php echo esc_url( AH_URI . '/assets/images/virgin-body-wave.png' ); ?>"
         alt="Cambodian virgin hair body wave bundles"
         loading="lazy" width="800" height="1000">
  </div>
  <div class="ah-split__content ah-reveal">
    <span class="ah-subheading">Pure. Natural. Versatile.</span>
    <h2 class="ah-heading-md" style="margin:var(--ah-space-4) 0;">What is Virgin Hair?</h2>
    <span class="ah-accent-line"></span>
    <p class="ah-body-lg">
      Our Cambodian virgin hair is 100% human, single-donor, and free from any
      chemical processing. It&rsquo;s the ideal choice for women who want
      premium quality without compromise — available in 10+ textures and up to 30 inches.
    </p>
    <p class="ah-body">
      The natural cuticle structure means exceptional softness, minimal shedding,
      and a lifespan that outlasts any synthetic or blended alternative.
      Whether you wear it straight, curled, or in its natural wave pattern,
      Asantey virgin hair adapts to your style — not the other way around.
    </p>
    <div class="ah-btn-group" style="margin-top:var(--ah-space-6);">
      <a href="#pricing" class="ah-btn ah-btn--gold">View Pricing <?php echo ah_svg('arrow-right'); ?></a>
      <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I\'d like to order Cambodian Virgin Hair.')); ?>"
         class="ah-btn ah-btn--outline" target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Order Now
      </a>
    </div>
  </div>
</section>

<div class="ah-trust-bar">
  <div class="ah-trust-bar__inner">
    <?php
    $t = [['gem','100% Human'],['sparkle','Single Donor'],['shield','3–5 Year Lifespan'],['check','Minimal Shedding'],['heart','10+ Textures']];
    foreach($t as $i=>$item){
      echo '<span class="ah-trust-bar__item">'.ah_svg($item[0]).esc_html($item[1]).'</span>';
      if($i<count($t)-1) echo '<span class="ah-trust-bar__divider"></span>';
    }
    ?>
  </div>
</div>

<section class="ah-section" id="textures">
  <div class="ah-container">
    <div class="ah-section-header--center ah-reveal">
      <span class="ah-subheading">Available Textures</span>
      <h2 class="ah-heading-lg">Choose Your Texture</h2>
      <span class="ah-accent-line ah-accent-line--center"></span>
      <p class="ah-body">All textures available in 10"–30" at the same price per length.</p>
    </div>
    <div class="ah-texture-grid">
      <?php
      $textures = [
        ['raw-body-wave.jpg','Body Wave','Natural wave with incredible movement and versatility.'],
        ['raw-deep-wave.jpg','Deep Wave','Rich, defined S-wave. Stays curly even after washing.'],
        ['raw-straight.jpg','Straight','Silky, sleek, and pin-straight. Holds a curl beautifully.'],
        ['raw-kinky-straight.jpg','Kinky Straight','Blends seamlessly with natural and relaxed hair textures.'],
        ['raw-loose-wave.jpg','Loose Wave','Soft and effortless. Our most popular virgin texture.'],
        ['raw-burmese-curls.jpg','Burmese Curls','Tight, springy curls with amazing definition.'],
        ['raw-loose-deep.jpg','Loose Deep','Relaxed deep wave. Full volume from root to tip.'],
        ['raw-waver-wave.jpg','Waver Wave','Unique texture — between a loose and body wave.'],
      ];
      $from = array_values(ah_get_pricing('virgin'))[0];
      foreach($textures as $i=>$t):[$img,$name,$desc]=$t;?>
        <div class="ah-texture-card ah-reveal ah-reveal--delay-<?php echo ($i%4)+1; ?>">
          <div class="ah-texture-card__img">
            <img src="<?php echo esc_url(AH_URI.'/assets/images/'.$img); ?>"
                 alt="Cambodian virgin hair — <?php echo esc_attr($name); ?>"
                 loading="lazy" width="300" height="400">
          </div>
          <h3 class="ah-texture-card__name"><?php echo esc_html($name); ?></h3>
          <p class="ah-texture-card__price">from &pound;<?php echo esc_html($from); ?></p>
          <p class="ah-body-sm" style="margin-top:var(--ah-space-2);"><?php echo esc_html($desc); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="ah-section ah-section--cream" id="pricing">
  <div class="ah-container">
    <div class="ah-section-header--center ah-reveal">
      <span class="ah-subheading">Transparent Pricing</span>
      <h2 class="ah-heading-lg">Virgin Hair Price Per Bundle</h2>
      <span class="ah-accent-line ah-accent-line--center"></span>
    </div>
    <div style="max-width:700px;margin:0 auto;" class="ah-reveal">
      <?php ah_pricing_table('virgin','Cambodian Virgin Hair','All textures priced equally per length. Prices are per bundle.'); ?>
    </div>
  </div>
</section>

<section class="ah-section" id="faq">
  <div class="ah-container ah-container--sm">
    <div class="ah-section-header--center ah-reveal">
      <span class="ah-subheading">Common Questions</span>
      <h2 class="ah-heading-lg">Virgin Hair FAQ</h2>
      <span class="ah-accent-line ah-accent-line--center"></span>
    </div>
    <div class="ah-accordion ah-reveal">
      <?php foreach($faqs as $faq): ?>
        <div class="ah-accordion__item">
          <button class="ah-accordion__trigger" type="button" aria-expanded="false">
            <span class="ah-accordion__question"><?php echo esc_html($faq['question']); ?></span>
            <span class="ah-accordion__icon"><?php echo ah_svg('plus'); ?></span>
          </button>
          <div class="ah-accordion__content">
            <p class="ah-accordion__answer"><?php echo esc_html($faq['answer']); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<div class="ah-cta-band">
  <div class="ah-container"><div class="ah-reveal">
    <span class="ah-cta-band__label">Ready to Order?</span>
    <h2 class="ah-cta-band__heading">Order Your Virgin Hair Bundles</h2>
    <p class="ah-cta-band__body">WhatsApp us or use our order form — we confirm within hours and dispatch in 2–3 business days.</p>
    <div class="ah-btn-group" style="justify-content:center;">
      <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I\'d like to order Cambodian Virgin Hair.')); ?>"
         class="ah-btn ah-btn--whatsapp ah-btn--lg" target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Order on WhatsApp
      </a>
      <a href="<?php echo esc_url(home_url('/order/')); ?>" class="ah-btn ah-btn--outline-white ah-btn--lg">Use Order Form</a>
    </div>
  </div></div>
</div>

<?php get_footer(); ?>
