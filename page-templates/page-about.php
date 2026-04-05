<?php
/**
 * Template Name: About Us
 * Asantey Hair & Beauty — About Page
 */
get_header();

echo ah_schema_breadcrumb([
  ['name' => 'Home',     'url' => home_url('/')],
  ['name' => 'About Us', 'url' => get_permalink()],
]);
?>

<div class="header-offset"></div>

<!-- Page Hero -->
<section class="page-hero">
  <div class="page-hero__bg">
    <img src="<?php echo esc_url( AH_URI . '/assets/images/raw-loose-wave.jpg' ); ?>"
         alt="" aria-hidden="true" loading="eager" width="1280" height="500">
  </div>
  <div class="page-hero__content">
    <span class="t-label">Our Story</span>
    <h1 class="t-h1">About Asantey<br>Hair &amp; Beauty</h1>
    <p >
      Premium hair. Real quality. Built on a belief that every woman deserves to feel extraordinary.
    </p>
  </div>
</section>

<?php ah_breadcrumb(); ?>

<!-- Brand Story -->
<section class="split section--sm" id="our-story" aria-labelledby="story-heading">
  <div class="split__media">
    <img src="<?php echo esc_url( AH_URI . '/assets/images/raw-body-wave.jpg' ); ?>"
         alt="Asantey Hair &amp; Beauty — premium Cambodian hair bundles"
         loading="lazy" width="800" height="1000">
  </div>
  <div class="split__body reveal">
    <span class="t-label">Why We Exist</span>
    <h2 id="story-heading" class="t-h3" style="margin:1rem 0;">
      Founded on a Single Obsession: Quality
    </h2>
    <span class="rule"></span>
    <p class="t-body--lg">
      Asantey Hair &amp; Beauty was founded because we saw too many women paying premium
      prices for hair that tangled after two washes, shed excessively, or simply
      did not perform as promised.
    </p>
    <p class="t-body">
      We went back to the source. Cambodian hair — sourced directly from single donors,
      never chemically processed, never blended with synthetic fibres. The result is
      hair that retains its natural cuticle alignment from root to tip: the
      scientific reason behind our signature softness, minimal shedding, and
      3–5 year lifespan.
    </p>
    <p class="t-body">
      We are UK based, and every product you receive has been hand-selected against
      our strict quality standards before it ships. This is not mass production.
      This is curation — for women who know the difference.
    </p>
  </div>
</section>

<!-- Our Values -->
<section class="section section--grey" aria-labelledby="values-heading">
  <div class="wrap">
    <div class="sh sh--c reveal">
      <span class="t-label">What We Stand For</span>
      <h2 id="values-heading" class="t-h2">Our Values</h2>
      <span class="rule rule--center"></span>
    </div>
    <div class="grid-3">
      <?php
      $values = [
        ['gem',     'Authenticity',   'Every product is exactly what we say it is. No blends, no shortcuts, no compromise. Raw is raw. Virgin is virgin.'],
        ['shield',  'Quality First',  'Our standards are non-negotiable. If a bundle doesn\'t meet the Asantey mark, it doesn\'t leave our hands.'],
        ['heart',   'Client First',   'Your satisfaction is not a KPI — it\'s the reason we do this. We\'re here to guide, advise, and make your hair journey as smooth as our extensions.'],
      ];
      foreach ( $values as $i => $v ) : ?>
        <div class="feat-card reveal ah-reveal--delay-<?php echo $i + 1; ?>">
          <div class="feature-card__icon"><?php echo ah_svg($v[0]); ?></div>
          <h3 class="feature-card__title"><?php echo esc_html($v[1]); ?></h3>
          <p class="feature-card__body"><?php echo esc_html($v[2]); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Why Cambodian Hair — SEO Content -->
<section class="split split--rev section--sm" id="cambodian-hair" aria-labelledby="cambodian-heading">
  <div class="split__media">
    <img src="<?php echo esc_url( AH_URI . '/assets/images/raw-deep-wave.jpg' ); ?>"
         alt="Cambodian raw hair extensions — deep wave texture"
         loading="lazy" width="800" height="1000">
  </div>
  <div class="split__body reveal">
    <span class="t-label">The Science of Quality</span>
    <h2 id="cambodian-heading" class="t-h3" style="margin:1rem 0;">
      Why Cambodian Hair?
    </h2>
    <span class="rule"></span>
    <p class="t-body">
      Cambodian hair is widely regarded as among the finest human hair in the world —
      and for good reason. Donors typically maintain long, healthy, chemically-untouched
      hair through diet and lifestyle, resulting in a hair shaft that is naturally thick,
      strong, and rich in moisture.
    </p>
    <p class="t-body">
      Because our hair is collected from single donors rather than multiple sources,
      the cuticles all run in the same direction. This is what prevents tangling,
      reduces shedding, and gives each bundle its natural lustre that synthetic-blended
      alternatives simply cannot replicate.
    </p>
    <p class="t-body">
      Whether you wear it raw, colour it, bleach it, or heat-style it daily —
      Cambodian hair holds up. That&rsquo;s not a marketing promise. It&rsquo;s simply
      what quality hair does.
    </p>
    <div style="display:flex;gap:1.25rem;flex-wrap:wrap;margin-top:1.5rem;">
      <a href="<?php echo esc_url(home_url('/raw-hair/')); ?>" class="btn btn--black">
        Shop Raw Hair <?php echo ah_svg('arrow-right'); ?>
      </a>
      <a href="<?php echo esc_url(home_url('/virgin-hair/')); ?>" class="btn btn--outline">
        Shop Virgin Hair
      </a>
    </div>
  </div>
</section>

<!-- Stats Strip -->
<div class="trust-bar" style="padding:2.5rem 1.5rem;">
  <div class="trust-bar__inner" style="gap:4rem;">
    <?php
    $stats = [
      ['10+',      'Hair Textures Available'],
      ['10"–30"',  'Length Range'],
      ['3–5 yrs',  'Average Hair Lifespan'],
      ['100%',     'Human, Cuticle-Aligned Hair'],
      ['48hrs',    'UK Dispatch Time'],
    ];
    foreach ( $stats as $stat ) : ?>
      <div style="text-align:center;">
        <div style="font-family:var(--ah-font-display);font-size:var(--ah-text-4xl);font-weight:300;color:var(--gold);line-height:1;">
          <?php echo esc_html($stat[0]); ?>
        </div>
        <div style="font-size:var(--ah-text-xs);letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.5);margin-top:var(--gap2);">
          <?php echo esc_html($stat[1]); ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Our Promise CTA -->
<div class="cta-band">
  <div class="wrap">
    <div class="reveal">
      <span class="t-label t-label--white">The Asantey Promise</span>
      <h2 class="t-h1">
        Every Bundle. Every Closure.<br>Every Frontal.
      </h2>
      <p class="t-body">
        Held to the Asantey standard — or we make it right.
        Your satisfaction is not optional. It&rsquo;s guaranteed.
      </p>
      <div class="btn-group" style="justify-content:center;">
        <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="btn btn--black">
          Explore Our Collections <?php echo ah_svg('arrow-right'); ?>
        </a>
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--outline-white">
          Get in Touch
        </a>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
