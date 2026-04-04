<?php
/**
 * Asantey Hair & Beauty — Homepage (front-page.php)
 * Template: Homepage
 */
get_header();

$hero_label    = get_theme_mod('ah_hero_label',    'Premium Cambodian Hair Extensions');
$hero_title    = get_theme_mod('ah_hero_title',    'Luxury Hair. Real Results.');
$hero_subtitle = get_theme_mod('ah_hero_subtitle', 'Cambodian Raw & Virgin Hair Extensions — crafted for women who demand quality that lasts 3–5 years.');
$hero_cta1_text= get_theme_mod('ah_hero_cta1_text','Shop Collections');
$hero_cta1_url = get_theme_mod('ah_hero_cta1_url', home_url('/shop/'));
$hero_cta2_text= get_theme_mod('ah_hero_cta2_text','Order via WhatsApp');
$hero_image    = get_theme_mod('ah_hero_image',    AH_URI . '/assets/images/raw-body-wave.jpg');

// SEO schema
echo ah_schema_breadcrumb([
  [ 'name' => 'Home', 'url' => home_url('/') ],
]);
?>

<!-- ============================================================
     [1] HERO
     ============================================================ -->
<section class="hero" aria-label="Hero">
  <div class="hero__bg">
    <img src="<?php echo esc_url( $hero_image ); ?>"
         alt="Asantey Hair &amp; Beauty — Premium Cambodian Hair Extensions"
         loading="eager" width="1920" height="1080"
         fetchpriority="high">
  </div>
  <div class="hero__overlay"></div>

  <div class="wrap">
    <div class="hero__content">
      <?php if ( $hero_label ) : ?>
        <span class="hero__label"><?php echo esc_html( $hero_label ); ?></span>
      <?php endif; ?>

      <h1 class="hero__title">
        <?php
        // Split title to italicise last word
        $words = explode(' ', $hero_title);
        $last  = array_pop($words);
        echo esc_html( implode(' ', $words) ) . ' <em>' . esc_html($last) . '</em>';
        ?>
      </h1>

      <p class="hero__subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>

      <div class="btn-group">
        <a href="<?php echo esc_url( $hero_cta1_url ); ?>"
           class="btn btn--black">
          <?php echo esc_html( $hero_cta1_text ); ?>
          <?php echo ah_svg('arrow-right'); ?>
        </a>
        <a href="<?php echo esc_url( ah_whatsapp_url('Hello! I\'d like to order hair extensions.') ); ?>"
           class="btn btn--outline-white"
           target="_blank" rel="noopener noreferrer">
          <?php echo ah_svg('whatsapp'); ?>
          <?php echo esc_html( $hero_cta2_text ); ?>
        </a>
      </div>
    </div>
  </div>

  <div class="hero__scroll" aria-hidden="true">
    <span>Scroll</span>
    <?php echo ah_svg('arrow-down'); ?>
  </div>
</section>

<!-- ============================================================
     [2] TRUST BAR
     ============================================================ -->
<div class="trust-bar" role="complementary" aria-label="Trust signals">
  <div class="trust-bar__inner">
    <?php
    $trust = [
      ['sparkle', 'Premium Cambodian Hair'],
      ['gem',     'HD Lace Specialists'],
      ['shield',  '3–5 Year Lifespan'],
      ['check',   'Minimal Shedding'],
      ['location','UK Based'],
    ];
    foreach ( $trust as $i => $item ) :
      echo '<span class="trust-bar__item">';
      echo ah_svg( $item[0] );
      echo esc_html( $item[1] );
      echo '</span>';
      if ( $i < count($trust) - 1 ) echo '<span class="trust-bar__divider" aria-hidden="true"></span>';
    endforeach;
    ?>
  </div>
</div>

<!-- ============================================================
     [3] FEATURED CATEGORIES
     ============================================================ -->
<section class="section" aria-labelledby="categories-heading">
  <div class="wrap">

    <div class="section-head section-head--center reveal">
      <span class="t-label">Our Collections</span>
      <h2 id="categories-heading" class="t-h2">
        The Asantey Standard
      </h2>
      <span class="rule rule--center"></span>
      <p class="t-body--lg">
        Every bundle, closure, and frontal is cuticle-aligned, single-donor,
        and held to exacting quality standards before it reaches your door.
      </p>
    </div>

    <div class="grid-3" style="gap:var(--ah-space-4);">

      <?php
      $categories = [
        [
          'label'   => 'Raw Hair',
          'title'   => 'Cambodian Raw Hair',
          'tagline' => 'Unprocessed. Uncoloured. Unapologetically Premium.',
          'image'   => AH_URI . '/assets/images/raw-straight.jpg',
          'url'     => home_url('/raw-hair/'),
          'from'    => '60',
        ],
        [
          'label'   => 'Virgin Hair',
          'title'   => 'Cambodian Virgin Hair',
          'tagline' => 'Pure Quality. Lasting Beauty. 3–5 Year Lifespan.',
          'image'   => AH_URI . '/assets/images/virgin-body-wave.png',
          'url'     => home_url('/virgin-hair/'),
          'from'    => '50',
        ],
        [
          'label'   => 'Closures & Frontals',
          'title'   => 'HD Lace Closures & Frontals',
          'tagline' => 'Invisible HD Lace. The Perfect Finish to Every Install.',
          'image'   => AH_URI . '/assets/images/raw-body-wave.jpg',
          'url'     => home_url('/closures-frontals/'),
          'from'    => '49',
        ],
      ];
      ?>

      <?php foreach ( $categories as $i => $cat ) : ?>
        <article class="ah-category-card ah-reveal ah-reveal--delay-<?php echo $i + 1; ?>"
                 aria-label="<?php echo esc_attr( $cat['title'] ); ?>">
          <img src="<?php echo esc_url( $cat['image'] ); ?>"
               alt="<?php echo esc_attr( $cat['title'] ); ?>"
               loading="lazy" width="600" height="900">
          <div class="cat-card__overlay"></div>
          <div class="cat-card__body">
            <span class="cat-card__label">from &pound;<?php echo esc_html( $cat['from'] ); ?></span>
            <h3 class="cat-card__title"><?php echo esc_html( $cat['title'] ); ?></h3>
            <p class="cat-card__tag"><?php echo esc_html( $cat['tagline'] ); ?></p>
            <a href="<?php echo esc_url( $cat['url'] ); ?>" class="cat-card__link">
              Explore <?php echo ah_svg('arrow-right'); ?>
            </a>
          </div>
        </article>
      <?php endforeach; ?>

    </div><!-- /.ah-grid -->
  </div>
</section>

<!-- ============================================================
     [4] WHY ASANTEY
     ============================================================ -->
<section class="section" style="background:#ffffff;border-top:1px solid var(--ah-grey-200);" aria-labelledby="why-heading">
  <div class="wrap">
    <div class="section-head section-head--center reveal">
      <span class="t-label">Why Choose Asantey</span>
      <h2 id="why-heading" class="t-h2">
        Hair That Speaks for Itself
      </h2>
      <span class="rule rule--center"></span>
    </div>

    <div class="grid-3">
      <?php
      $features = [
        [
          'icon'  => 'gem',
          'title' => 'Cambodian Origin',
          'body'  => 'Single-donor Cambodian hair, ethically sourced and never chemically processed. Retains full cuticle alignment for unmatched softness and longevity.',
        ],
        [
          'icon'  => 'shield',
          'title' => 'Built to Last',
          'body'  => 'With proper care, our Raw and Virgin hair lasts 3–5 years. That\'s not a claim — it\'s the lived experience of thousands of women who trust Asantey.',
        ],
        [
          'icon'  => 'sparkle',
          'title' => '10+ Textures',
          'body'  => 'From silky straight to Burmese curls, every texture is available in 10"–30" lengths. Wear it straight today, curly tomorrow — it holds up either way.',
        ],
        [
          'icon'  => 'check',
          'title' => 'Minimal Shedding',
          'body'  => 'Each bundle is double weft and double drawn. The result? Virtually no shedding, and a fullness that maintains from root to tip.',
        ],
        [
          'icon'  => 'heart',
          'title' => 'HD Lace Specialists',
          'body'  => 'Our HD lace closures and frontals melt into every skin tone for a hairline so natural, nobody\'ll know it\'s not yours.',
        ],
        [
          'icon'  => 'truck',
          'title' => 'UK Based & Fast',
          'body'  => 'Orders dispatched within 2–3 business days. We\'re based in the UK — no international wait times, no import fees, no surprises.',
        ],
      ];
      foreach ( $features as $i => $feat ) : ?>
        <div class="feature-card ah-reveal ah-reveal--delay-<?php echo ($i % 3) + 1; ?>">
          <div class="feature-card__icon">
            <?php echo ah_svg( $feat['icon'] ); ?>
          </div>
          <h3 class="feature-card__title"><?php echo esc_html( $feat['title'] ); ?></h3>
          <p class="feature-card__body"><?php echo esc_html( $feat['body'] ); ?></p>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- ============================================================
     [5] PRODUCT SPOTLIGHT
     ============================================================ -->
<section class="section" aria-labelledby="products-heading">
  <div class="wrap">

    <div class="section-head" style="display:flex;align-items:flex-end;justify-content:space-between;" style="align-items:flex-end;">
      <div>
        <span class="t-label">Featured Products</span>
        <h2 id="products-heading" class="t-h2">Shop the Collection</h2>
        <span class="rule"></span>
      </div>
      <a href="<?php echo esc_url( home_url('/shop/') ); ?>"
         class="btn btn--outline">
        View All <?php echo ah_svg('arrow-right'); ?>
      </a>
    </div>

    <div class="grid-4">
      <?php
      $products = get_posts([
        'post_type'      => 'hair_product',
        'posts_per_page' => 4,
        'meta_query'     => [
          [
            'key'     => '_ah_is_featured',
            'value'   => '1',
            'compare' => '=',
          ],
        ],
      ]);

      // Fallback to recent products
      if ( empty($products) ) {
        $products = get_posts([
          'post_type'      => 'hair_product',
          'posts_per_page' => 4,
          'orderby'        => 'date',
          'order'          => 'DESC',
        ]);
      }

      foreach ( $products as $product ) :
        ah_product_card( $product );
      endforeach;

      wp_reset_postdata();
      ?>
    </div>

  </div>
</section>

<!-- ============================================================
     [6] CLIENT RESULTS GALLERY
     ============================================================ -->
<section class="section section--black" aria-labelledby="results-heading">
  <div class="wrap">

    <div class="section-head section-head--center reveal" style="margin-bottom:var(--ah-space-12);">
      <span class="t-label" style="color:var(--ah-gold);">Real Women. Real Results.</span>
      <h2 id="results-heading" class="t-h2" style="color:var(--ah-pure-white);">
        See It to Believe It
      </h2>
      <span class="rule rule--center"></span>
      <p class="t-body" style="color:rgba(255,255,255,0.65);max-width:560px;margin:0 auto;">
        Every photo is a real Asantey client. No filters. No stock images.
        Just genuine results from women who chose quality.
      </p>
    </div>

    <div class="ah-gallery ah-reveal">
      <?php
      $results = [];
      for ( $i = 1; $i <= 7; $i++ ) {
        $src = AH_URI . '/assets/images/client-result-' . $i . '.jpg';
        $results[] = $src;
      }
      foreach ( $results as $j => $src ) :
        if ( $j >= 6 ) break;
        ?>
        <div class="gallery-item">
          <img src="<?php echo esc_url( $src ); ?>"
               alt="Asantey Hair &amp; Beauty client result <?php echo $j + 1; ?>"
               loading="lazy" width="400" height="500">
          <div class="gallery-item__ov">
            <span >Client Result</span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div style="text-align:center;margin-top:var(--ah-space-12);" class="reveal">
      <a href="<?php echo esc_url( home_url('/gallery/') ); ?>"
         class="btn btn--outline-white">
        View Full Gallery <?php echo ah_svg('arrow-right'); ?>
      </a>
    </div>

  </div>
</section>

<!-- ============================================================
     [7] PRICING PREVIEW BAND
     ============================================================ -->
<div style="background:var(--ah-black);padding:var(--ah-space-12) var(--ah-space-6);">
  <div class="wrap">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:var(--ah-space-6);">
      <div>
        <span class="t-label" style="display:block;margin-bottom:var(--ah-space-3);">Transparent Pricing</span>
        <p style="font-family:var(--ah-font-display);font-size:clamp(1rem,2.5vw,1.375rem);line-height:1.5;color:rgba(255,255,255,0.85);margin:0;">
          Cambodian Raw Hair from <strong style="color:var(--ah-gold);">&pound;60</strong> &nbsp;&middot;&nbsp;
          Virgin Hair from <strong style="color:var(--ah-gold);">&pound;50</strong> &nbsp;&middot;&nbsp;
          HD Lace Closures from <strong style="color:var(--ah-gold);">&pound;49</strong> &nbsp;&middot;&nbsp;
          Frontals from <strong style="color:var(--ah-gold);">&pound;80</strong>
        </p>
      </div>
      <a href="<?php echo esc_url( home_url('/shop/') ); ?>"
         class="btn btn--outline-white">
        View Full Price List <?php echo ah_svg('arrow-right'); ?>
      </a>
    </div>
  </div>
</div>

<!-- ============================================================
     [8] ABOUT SPLIT
     ============================================================ -->
<section class="split section--sm" aria-labelledby="about-heading">
  <div class="split__media">
    <img src="<?php echo esc_url( AH_URI . '/assets/images/raw-loose-wave.jpg' ); ?>"
         alt="Asantey Hair &amp; Beauty — premium loose wave hair extensions"
         loading="lazy" width="800" height="1000">
  </div>
  <div class="split__body ah-reveal">
    <span class="t-label">Our Story</span>
    <h2 id="about-heading" class="t-h3" style="margin:var(--ah-space-4) 0;">
      The Asantey Standard
    </h2>
    <span class="rule"></span>
    <p class="t-body--lg">
      Founded on the belief that every woman deserves hair she's genuinely proud of,
      Asantey Hair & Beauty was built around one obsession: quality.
    </p>
    <p class="t-body">
      We source our Cambodian hair directly, ensuring each bundle retains its natural
      cuticle alignment — the secret behind our signature softness, longevity, and
      virtually zero shedding. Our raw hair has never been chemically processed.
      Our virgin hair has never been coloured or altered. What you receive is exactly
      as nature intended — just better selected, better prepared, and shipped to your door.
    </p>
    <a href="<?php echo esc_url( home_url('/about/') ); ?>"
       class="btn btn--black" style="margin-top:var(--ah-space-6);">
      Our Story <?php echo ah_svg('arrow-right'); ?>
    </a>
  </div>
</section>

<!-- ============================================================
     [9] TESTIMONIALS
     ============================================================ -->
<section class="section" style="background:#f6f6f6;" aria-labelledby="testimonials-heading">
  <div class="wrap">

    <div class="section-head section-head--center reveal">
      <span class="t-label">Client Love</span>
      <h2 id="testimonials-heading" class="t-h2">What Our Clients Say</h2>
      <span class="rule rule--center"></span>
    </div>

    <div class="grid-3">
      <?php
      $testimonials = [
        [
          'quote'  => 'I have been buying hair for over 10 years and Asantey is hands down the best quality I\'ve ever experienced. No shedding, silky soft, and the colour took perfectly.',
          'author' => 'Naomi A., London',
          'stars'  => 5,
        ],
        [
          'quote'  => 'My 28" raw body wave bundle is still going strong 2 years later. I wash and go every week and it looks brand new every time. Absolutely worth every penny.',
          'author' => 'Blessing O., Birmingham',
          'stars'  => 5,
        ],
        [
          'quote'  => 'The HD lace frontal is unreal. My stylist couldn\'t believe it wasn\'t my natural hairline. Ordered on WhatsApp and received it in 2 days. Will never go anywhere else.',
          'author' => 'Jade K., Manchester',
          'stars'  => 5,
        ],
      ];
      foreach ( $testimonials as $i => $t ) : ?>
        <div class="ah-testimonial ah-reveal ah-reveal--delay-<?php echo $i + 1; ?>">
          <?php echo ah_stars( $t['stars'] ); ?>
          <p class="testimonial__quote">&ldquo;<?php echo esc_html( $t['quote'] ); ?>&rdquo;</p>
          <span class="testimonial__author">&mdash; <?php echo esc_html( $t['author'] ); ?></span>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- ============================================================
     [10] FINAL CTA BAND
     ============================================================ -->
<div class="cta-band">
  <div class="wrap">
    <div class="reveal">
      <span class="t-label t-label--white">Ready to Elevate Your Look?</span>
      <h2 class="t-h1">
        Your Best Hair Starts Here
      </h2>
      <p class="t-body">
        Browse our full collection or order directly on WhatsApp — we'll guide you
        through every step, from texture to length to your perfect install.
      </p>
      <div class="btn-group" style="justify-content:center;">
        <a href="<?php echo esc_url( home_url('/shop/') ); ?>"
           class="btn btn--black">
          Shop Collections <?php echo ah_svg('arrow-right'); ?>
        </a>
        <a href="<?php echo esc_url( ah_whatsapp_url() ); ?>"
           class="btn btn--outline-white"
           target="_blank" rel="noopener noreferrer">
          <?php echo ah_svg('whatsapp'); ?> WhatsApp Order
        </a>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
