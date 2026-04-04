<?php
/**
 * Asantey Hair & Beauty — Homepage (front-page.php)
 */
get_header();

// Unsplash hero images — landscape, African beauty/hair editorial
// These load directly from Unsplash CDN on the live site
define('AH_HERO_1', 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=1920&q=88&auto=format&fit=crop&crop=top');
define('AH_HERO_2', 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=1920&q=88&auto=format&fit=crop&crop=top');

$hero_image = get_theme_mod('ah_hero_image', AH_HERO_1);
$hero_title = get_theme_mod('ah_hero_title', 'Luxury Hair.\nReal Results.');
$hero_sub   = get_theme_mod('ah_hero_subtitle', 'Premium Cambodian Raw &amp; Virgin Hair Extensions — crafted for women who demand quality that lasts 3–5 years.');

echo ah_schema_breadcrumb([['name'=>'Home','url'=>home_url('/')]]);
?>

<!-- ============================================================ HERO -->
<section class="hero" aria-label="Hero">
  <div class="hero__bg">
    <img src="<?php echo esc_url($hero_image); ?>"
         alt="Asantey Hair &amp; Beauty — Premium Cambodian Hair Extensions"
         loading="eager" fetchpriority="high"
         width="1920" height="1080">
  </div>
  <div class="hero__overlay"></div>
  <div class="hero__inner">
    <span class="hero__eyebrow">Premium Cambodian Hair Extensions</span>
    <h1 class="hero__title">
      Luxury Hair.<br><em>Real Results.</em>
    </h1>
    <p class="hero__sub">
      <?php echo wp_kses_post($hero_sub); ?>
    </p>
    <div class="btns">
      <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="btn btn--w">
        Shop Collections <?php echo ah_svg('arrow-right'); ?>
      </a>
      <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I'd like to order hair extensions.')); ?>"
         class="btn btn--ow" target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Order on WhatsApp
      </a>
    </div>
  </div>
  <div class="hero__scroll" aria-hidden="true">Scroll</div>
</section>

<!-- ============================================================ MARQUEE -->
<div class="marquee-strip marquee-strip--dark">
  <div class="marquee-track">
    <?php
    $items = [
      ['sparkle','Premium Cambodian Hair'],
      ['gem',    'HD Lace Specialists'],
      ['shield', '3–5 Year Lifespan'],
      ['check',  'Minimal Shedding'],
      ['location','UK Based · Nottingham'],
      ['heart',  'Single Donor'],
      ['sparkle','Cuticle Aligned'],
      ['truck',  'Fast UK Dispatch'],
      // Duplicate for seamless loop
      ['sparkle','Premium Cambodian Hair'],
      ['gem',    'HD Lace Specialists'],
      ['shield', '3–5 Year Lifespan'],
      ['check',  'Minimal Shedding'],
      ['location','UK Based · Nottingham'],
      ['heart',  'Single Donor'],
      ['sparkle','Cuticle Aligned'],
      ['truck',  'Fast UK Dispatch'],
    ];
    foreach($items as $item):
      echo '<span class="marquee-item">'.ah_svg($item[0]).esc_html($item[1]).'</span>';
    endforeach;
    ?>
  </div>
</div>

<!-- ============================================================ CATEGORIES -->
<section class="s s--sm" style="padding-inline:0;background:var(--ink);" aria-labelledby="cat-heading">
  <div class="wrap" style="margin-bottom:3rem;">
    <div class="sh sh--c reveal">
      <span class="t-label">Our Collections</span>
      <h2 id="cat-heading" class="t-h2">The Asantey Standard</h2>
      <div class="rule rule--center" style="margin-top:1.5rem;opacity:.2;"></div>
    </div>
  </div>
  <div class="cat-grid">
    <?php
    $cats = [
      [
        'label'   => 'Raw Hair',
        'title'   => 'Cambodian Raw Hair',
        'from'    => '£60',
        'tag'     => 'Unprocessed. Uncoloured. Unapologetically Premium.',
        'image'   => AH_URI.'/assets/images/hero-main.jpg',
        'url'     => home_url('/raw-hair/'),
      ],
      [
        'label'   => 'Virgin Hair',
        'title'   => 'Virgin Hair Bundles',
        'from'    => '£50',
        'tag'     => 'Pure Quality. Lasting Beauty. 3–5 Year Lifespan.',
        'image'   => AH_URI.'/assets/images/hero-about.jpg',
        'url'     => home_url('/virgin-hair/'),
      ],
      [
        'label'   => 'HD Lace',
        'title'   => 'Closures & Frontals',
        'from'    => '£49',
        'tag'     => 'Invisible HD Lace. The Perfect Finish.',
        'image'   => AH_URI.'/assets/images/hero-shop.jpg',
        'url'     => home_url('/closures-frontals/'),
      ],
    ];
    foreach($cats as $i => $cat): ?>
      <a href="<?php echo esc_url($cat['url']); ?>"
         class="cat-card reveal d<?php echo $i+1; ?>">
        <img src="<?php echo esc_url($cat['image']); ?>"
             alt="<?php echo esc_attr($cat['title']); ?>"
             loading="<?php echo $i===0?'eager':'lazy'; ?>"
             width="640" height="853">
        <div class="cat-card__ov"></div>
        <div class="cat-card__body">
          <span class="cat-card__label">from <?php echo esc_html($cat['from']); ?></span>
          <h3 class="cat-card__title"><?php echo esc_html($cat['title']); ?></h3>
          <p class="cat-card__from"><?php echo esc_html($cat['tag']); ?></p>
          <span class="cat-card__link">
            Explore <?php echo ah_svg('arrow-right'); ?>
          </span>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- ============================================================ WHY ASANTEY (white section) -->
<section class="s s--white" aria-labelledby="why-heading">
  <div class="wrap">
    <div class="sh sh--c reveal">
      <span class="t-label">Why Asantey</span>
      <h2 id="why-heading" class="t-h2">Hair That Speaks for Itself</h2>
      <div class="rule rule--center rule--ink" style="margin-top:1.5rem;opacity:.15;"></div>
    </div>
    <div class="grid-3">
      <?php
      $feats = [
        ['gem',    'Cambodian Origin',   'Single-donor Cambodian hair, ethically sourced, never chemically processed. Full cuticle alignment for unmatched softness.'],
        ['shield', '3–5 Year Lifespan',  'Not a claim — it's what our clients experience. Invest once, wear for years. The maths speak for themselves.'],
        ['sparkle','10+ Textures',       'Body wave to Burmese curls. Straight to deep wave. Every texture in 10"–30" lengths. Wear it your way.'],
        ['check',  'Minimal Shedding',   'Double weft, double drawn. Cuticle-aligned from root to tip. The science behind hair that stays full.'],
        ['heart',  'HD Lace Specialists','Our HD closures and frontals melt into every skin tone — no bleaching, no tinting. Undetectable.'],
        ['truck',  'UK Based',           'Nottingham-based salon. Orders dispatched in 2–3 business days. No import fees. No waiting.'],
      ];
      foreach($feats as $i => $f): ?>
        <div class="feat-card reveal d<?php echo ($i%3)+1; ?>">
          <div class="feat-card__icon"><?php echo ah_svg($f[0]); ?></div>
          <h3 class="feat-card__title"><?php echo esc_html($f[1]); ?></h3>
          <p class="feat-card__body"><?php echo esc_html($f[2]); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================ FEATURED PRODUCTS -->
<section class="s" aria-labelledby="prod-heading">
  <div class="wrap">
    <div class="sh reveal" style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
      <div>
        <span class="t-label" style="display:block;margin-bottom:1rem;">Featured Products</span>
        <h2 id="prod-heading" class="t-h2">Shop the Collection</h2>
      </div>
      <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="btn btn--ow btn--sm">
        View All <?php echo ah_svg('arrow-right'); ?>
      </a>
    </div>
    <div class="grid-4">
      <?php
      $products = get_posts([
        'post_type'=>'hair_product','posts_per_page'=>4,'orderby'=>'date','order'=>'DESC'
      ]);
      if($products):
        foreach($products as $product) ah_product_card($product);
        wp_reset_postdata();
      else:
        $fallback = [
          ['Cambodian Raw Hair — Body Wave',   'raw-hair','60','raw-body-wave.jpg',   'Unprocessed single-donor. 10"–30".'],
          ['Cambodian Raw Hair — Deep Wave',   'raw-hair','60','raw-deep-wave.jpg',   'Natural S-wave. Never treated. 10"–30".'],
          ['Virgin Hair — Body Wave',          'virgin-hair','50','raw-loose-wave.jpg','Pure quality. 3–5 year lifespan.'],
          ['HD Lace Closure — 4x4',            'closures-frontals','51','hd-lace-sizes.png','Invisible HD lace. All textures.'],
        ];
        foreach($fallback as $f): [$title,$cat,$price,$img,$desc]=$f; ?>
          <article class="product-card" data-category="<?php echo esc_attr($cat); ?>">
            <div class="product-card__img">
              <img src="<?php echo esc_url(AH_URI.'/assets/images/'.$img); ?>"
                   alt="<?php echo esc_attr($title); ?>" loading="lazy" width="600" height="600">
              <span class="product-card__badge"><?php echo esc_html(ucwords(str_replace('-',' ',$cat))); ?></span>
            </div>
            <div class="product-card__body">
              <span class="product-card__cat"><?php echo esc_html(ucwords(str_replace('-',' ',$cat))); ?></span>
              <h3 class="product-card__title"><?php echo esc_html($title); ?></h3>
              <p class="product-card__desc"><?php echo esc_html($desc); ?></p>
              <div class="product-card__price">from &pound;<?php echo esc_html($price); ?> <small>per bundle</small></div>
              <div class="product-card__actions">
                <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I'm interested in: '.$title)); ?>"
                   class="btn btn--w btn--sm" target="_blank" rel="noopener noreferrer">
                   <?php echo ah_svg('whatsapp'); ?> Order
                </a>
              </div>
            </div>
          </article>
        <?php endforeach;
      endif; ?>
    </div>
  </div>
</section>

<!-- ============================================================ SPLIT — BRAND STORY -->
<div class="split split--dark">
  <div class="split__media">
    <img src="<?php echo esc_url(AH_URI.'/assets/images/hero-gallery.jpg'); ?>"
         alt="Asantey Hair &amp; Beauty — Real client results"
         loading="lazy" width="800" height="1000">
  </div>
  <div class="split__body split--dark reveal">
    <span class="t-label">Our Story</span>
    <h2 class="t-h2" style="color:var(--paper);margin-top:1.125rem;">The Asantey Standard</h2>
    <div class="rule rule--gold" style="margin-top:1.5rem;"></div>
    <p class="t-body--lg" style="margin-top:1.5rem;">
      Founded on the belief that every woman deserves hair she&rsquo;s genuinely proud of.
      We source our Cambodian hair directly — single donor, cuticle-aligned, never chemically altered.
    </p>
    <p class="t-body" style="margin-top:1rem;">
      What you receive is exactly as nature intended: just better selected, better prepared,
      and built to last 3–5 years with the right care. That&rsquo;s the Asantey promise.
    </p>
    <div class="btns" style="margin-top:2.5rem;">
      <a href="<?php echo esc_url(home_url('/about/')); ?>" class="btn btn--ow">
        Our Story <?php echo ah_svg('arrow-right'); ?>
      </a>
    </div>
  </div>
</div>

<!-- ============================================================ CLIENT RESULTS -->
<section class="s" aria-labelledby="results-heading">
  <div class="wrap">
    <div class="sh sh--c reveal">
      <span class="t-label">Real Women. Real Results.</span>
      <h2 id="results-heading" class="t-h2">See It to Believe It</h2>
      <div class="rule rule--center" style="margin-top:1.5rem;opacity:.2;"></div>
    </div>
    <div class="gallery reveal">
      <?php for($i=1;$i<=6;$i++): ?>
        <div class="gallery-item">
          <img src="<?php echo esc_url(AH_URI.'/assets/images/client-result-'.$i.'.jpg'); ?>"
               alt="Asantey Hair &amp; Beauty — Client result <?php echo $i; ?>"
               loading="lazy" width="480" height="640">
          <div class="gallery-item__ov">
            <span class="gallery-item__icon"><?php echo ah_svg('zoom'); ?></span>
          </div>
        </div>
      <?php endfor; ?>
    </div>
    <div style="text-align:center;margin-top:2.5rem;" class="reveal">
      <a href="<?php echo esc_url(home_url('/gallery/')); ?>" class="btn btn--ow">
        View Full Gallery <?php echo ah_svg('arrow-right'); ?>
      </a>
    </div>
  </div>
</section>

<!-- ============================================================ PRICING BAND -->
<div style="background:var(--mid);border-top:1px solid rgba(255,255,255,.07);border-bottom:1px solid rgba(255,255,255,.07);padding:2.5rem var(--gap);">
  <div class="wrap" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1.5rem;">
    <div>
      <span class="t-label" style="display:block;margin-bottom:.875rem;">Transparent Pricing</span>
      <p style="font-family:var(--serif);font-size:clamp(1rem,2.5vw,1.35rem);color:rgba(255,255,255,.7);line-height:1.6;">
        Raw Hair from <strong style="color:var(--gold);">&pound;60</strong>
        &nbsp;&middot;&nbsp; Virgin Hair from <strong style="color:var(--gold);">&pound;50</strong>
        &nbsp;&middot;&nbsp; Closures from <strong style="color:var(--gold);">&pound;49</strong>
        &nbsp;&middot;&nbsp; Frontals from <strong style="color:var(--gold);">&pound;80</strong>
      </p>
    </div>
    <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="btn btn--ow btn--sm">
      Full Price List <?php echo ah_svg('arrow-right'); ?>
    </a>
  </div>
</div>

<!-- ============================================================ TESTIMONIALS -->
<section class="s" aria-labelledby="test-heading">
  <div class="wrap">
    <div class="sh sh--c reveal">
      <span class="t-label">Client Love</span>
      <h2 id="test-heading" class="t-h2">What Our Clients Say</h2>
      <div class="rule rule--center" style="margin-top:1.5rem;opacity:.2;"></div>
    </div>
    <div class="grid-3">
      <?php
      $tests = [
        ['I have been buying hair for over 10 years and Asantey is hands down the best quality I've ever experienced. No shedding, silky soft, and took colour perfectly.','Naomi A., London',5],
        ['My 28" raw body wave bundle is still going strong 2 years later. Wash and go every week and it looks brand new every time. Worth every penny.','Blessing O., Birmingham',5],
        ['The HD lace frontal is unreal. My stylist couldn't believe it wasn't my natural hairline. Ordered on WhatsApp and received it in 2 days.','Jade K., Manchester',5],
      ];
      foreach($tests as $i => $t): ?>
        <div class="tcard reveal d<?php echo $i+1; ?>">
          <?php echo ah_stars($t[2]); ?>
          <p class="tcard__quote">&ldquo;<?php echo esc_html($t[0]); ?>&rdquo;</p>
          <span class="tcard__author">&mdash; <?php echo esc_html($t[1]); ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================ FINAL CTA -->
<div class="cta-band dark">
  <div class="wrap wrap--narrow reveal">
    <span class="t-label">Ready to Elevate Your Look?</span>
    <h2>Your Best<br><em style="font-style:italic;color:rgba(255,255,255,.4);">Hair Starts Here</em></h2>
    <p>Browse our full collection or order directly on WhatsApp. We guide you through every step.</p>
    <div class="btns" style="justify-content:center;">
      <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="btn btn--w">
        Shop Collections <?php echo ah_svg('arrow-right'); ?>
      </a>
      <a href="<?php echo esc_url(ah_whatsapp_url()); ?>"
         class="btn btn--ow" target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> WhatsApp Order
      </a>
      <a href="https://asanteyhair.as.me/" class="btn btn--ow" target="_blank" rel="noopener noreferrer">
        Book Appointment
      </a>
    </div>
  </div>
</div>

<?php get_footer(); ?>
