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

?>

<section class="page-hero">
  <div class="page-hero__bg">
    <?php ah_opt_img_tag( 'hero_image', AH_URI . '/assets/images/raw-body-wave.jpg', '', '', 'eager' ); ?>
  </div>
  <div class="page-hero__content">
    <span class="t-label"><?php echo esc_html(ah_opt('hero_label','Cambodian Hair Collection')); ?></span>
    <h1 class="t-h1"><?php echo wp_kses(ah_opt('hero_title','Cambodian Raw<br>Hair Bundles'),['br'=>[]]); ?></h1>
    <p >
      <?php echo esc_html(ah_opt('hero_subtitle','Unprocessed. Uncoloured. Unapologetically Premium. From Â£60 per bundle.')); ?>
    </p>
  </div>
</section>

<?php ah_breadcrumb(); ?>

<!-- What is Raw Hair -->
<section class="split" id="what-is-raw-hair">
  <div class="split__media">
    <img src="<?php echo esc_url( (ah_opt_img('raw_intro_image')['url'] ?? '') ?: AH_URI.'/assets/images/raw-kinky-straight.jpg' ); ?>"
         alt="Cambodian raw kinky straight hair — unprocessed single-donor"
         loading="lazy" width="800" height="1000">
  </div>
  <div class="split__body reveal">
    <span class="t-label"><?php echo esc_html(ah_opt('raw_intro_label','What Makes It Different')); ?></span>
    <h2 class="t-h3" style="margin:1rem 0;"><?php echo esc_html(ah_opt('raw_intro_title','What is Raw Hair?')); ?></h2>
    <span class="rule"></span>
    <p class="t-body--lg">
      Raw hair is the purest form of hair extension. Collected from a single Cambodian donor,
      it has never been treated with chemicals, heat-processed at the factory, or blended
      with hair from other sources.
    </p>
    <p class="t-body">
      Because all cuticles run in the same direction — from root to tip — raw hair has
      virtually no friction between strands. That means no tangling, minimal shedding,
      and a natural shine that no coating or silicone spray can replicate.
    </p>
    <p class="t-body">
      Raw hair can be coloured, bleached, and heat-styled just like your natural hair.
      It absorbs moisture naturally and maintains its pattern through wash after wash.
      When we say it lasts 3–5 years, that is not a marketing line. It is what our
      clients actually experience.
    </p>
    <div class="btns" style="margin-top:1.5rem;">

      <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I would like to order Cambodian Raw Hair.')); ?>"
         class="btn btn--ob" target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Order on WhatsApp
      </a>
    </div>
  </div>
</section>

<!-- Trust bar -->
<div class="marquee-strip marquee-strip--dark">
  <div class="wrap" style="display:flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:2rem;">
    <?php
    $trust = [
      ['sparkle','Single Donor'],
      ['gem','Cuticle Aligned'],
      ['shield','Never Chemically Treated'],
      ['check','3–5 Year Lifespan'],
      ['heart','Minimal Shedding'],
    ];
    foreach($trust as $i => $t):
      echo '<span class="marquee-item">' . ah_svg($t[0]) . esc_html($t[1]) . '</span>';
      if($i < count($trust)-1) echo '<span ></span>';
    endforeach;
    ?>
  </div>
</div>

<!-- Texture Grid -->
<section class="s s--white" id="textures" aria-labelledby="textures-heading">
  <div class="wrap">
    <div class="sh sh--c reveal">
      <span class="t-label"><?php echo esc_html(ah_opt('raw_tex_label','Available Textures')); ?></span>
      <h2 id="textures-heading" class="t-h2"><?php echo esc_html(ah_opt('raw_tex_title','8 Textures. One Standard.')); ?></h2>
      <span class="rule rule--center"></span>
      <p class="t-body--lg"><?php echo esc_html(ah_opt('raw_tex_desc','Every texture available in all lengths, 10"–30", at the same price point.')); ?></p>
    </div>

    <div class="texture-grid">
      <?php
      // Each entry: [ fallback_img, opt_key (matches meta box), display_name, description ]
      $textures = [
        ['raw-straight.jpg',       'straight',       'Straight',       'Ultra-sleek and pin-straight. Curls and holds a wave when styled.'],
        ['raw-body-wave.jpg',      'body-wave',      'Body Wave',      'Natural S-wave. Our most popular raw texture — versatile, full, and effortlessly glamorous.'],
        ['raw-loose-wave.jpg',     'loose-wave',     'Loose Wave',     'Soft, flowing wave. The bestselling texture in our Raw collection.'],
        ['raw-deep-wave.jpg',      'deep-wave',      'Deep Wave',      'Deep S-wave pattern. Holds curl beautifully, wash after wash.'],
        ['raw-kinky-straight.jpg', 'kinky-straight', 'Kinky Straight', 'Silky with a natural kink. Blends seamlessly with relaxed or natural hair.'],
        ['raw-loose-deep.jpg',     'loose-deep',     'Loose Deep',     'Relaxed deep wave. Full, bouncy, and effortlessly glamorous.'],
        ['raw-burmese-curls.jpg',  'burmese-curls',  'Burmese Curls',  'Tight, springy curls with incredible definition and volume.'],
        ['raw-waver-wave.jpg',     'waver-wave',     'Water Wave',     'Free-flowing beachy wave. Easy wash-and-go style.'],
      ];
      foreach ( $textures as $i => $t ) :
        [$img, $img_key, $name, $desc] = $t;
        $opt_key = 'raw_tex_' . $img_key;
        $opt_img = ah_opt_img( $opt_key );
        $img_src = $opt_img['url'] ?: AH_URI . '/assets/images/' . $img;
        ?>
        <div class="ah-texture-card ah-reveal ah-reveal--delay-<?php echo ($i % 4) + 1; ?>">
          <div class="texture-item__img">
            <img src="<?php echo esc_url( $img_src ); ?>"
                 alt="Cambodian raw hair — <?php echo esc_attr($name); ?>"
                 loading="lazy" width="300" height="400">
          </div>
          <h3 class="texture-item__name"><?php echo esc_html($name); ?></h3>
          <p class="t-body" style="margin-top:0.5rem;"><?php echo esc_html($desc); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Care Teaser -->
<section class="split split--rev">
  <div class="split__media">
    <img src="<?php echo esc_url( (ah_opt_img('raw_care_image')['url'] ?? '') ?: AH_URI.'/assets/images/raw-loose-wave.jpg' ); ?>"
         alt="Caring for your Cambodian raw hair extensions"
         loading="lazy" width="800" height="1000">
  </div>
  <div class="split__body reveal">
    <span class="t-label"><?php echo esc_html(ah_opt('raw_care_label','Protect Your Investment')); ?></span>
    <h2 class="t-h3" style="margin:1rem 0;"><?php echo esc_html(ah_opt('raw_care_title','How to Make It Last 5 Years')); ?></h2>
    <span class="rule"></span>
    <p class="t-body"><?php echo esc_html(ah_opt('raw_care_body','Raw hair is durable by nature, but the right care routine makes all the difference between 2 years and 5.')); ?></p>
    <a href="<?php echo esc_url(home_url('/hair-care-guide/')); ?>"
       class="btn btn--ob" style="margin-top:1.5rem;">
      Read the Hair Care Guide <?php echo ah_svg('arrow-right'); ?>
    </a>
  </div>
</section>

<!-- CTA -->
<div class="cta-band dark">
  <div class="wrap">
    <div class="reveal">
      <span class="t-label t-label--white">Ready to Order?</span>
      <h2 class="t-h1">Order Your Raw Hair Bundles</h2>
      <p class="t-body">
        WhatsApp us with your texture, length, and quantity — and we&rsquo;ll confirm
        availability and send you an invoice within hours.
      </p>
      <div class="btns" style="justify-content:center;">
        <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I would like to order Cambodian Raw Hair bundles.')); ?>"
           class="btn btn--wa" target="_blank" rel="noopener noreferrer">
          <?php echo ah_svg('whatsapp'); ?> Order on WhatsApp
        </a>
        <a href="<?php echo esc_url(home_url('/order/')); ?>" class="btn btn--outline-white">
          Use Order Form
        </a>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
