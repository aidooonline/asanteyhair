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

<section class="page-hero">
  <div class="page-hero__bg">
    <?php ah_opt_img_tag( 'hero_image', ah_opt_img('vir_intro_image')['url'] ?: AH_URI.'/assets/images/virgin-body-wave.png', '', '', 'eager' ); ?>
  </div>
  <div class="page-hero__content">
    <span class="t-label">Cambodian Hair Collection</span>
    <h1 class="t-h1">Cambodian Virgin<br>Hair Bundles</h1>
    <p >Pure Quality. Lasting Beauty. From &pound;50 per bundle.</p>
  </div>
</section>

<?php ah_breadcrumb(); ?>

<section class="split">
  <div class="split__media">
    <img src="<?php echo esc_url( ah_opt_img('vir_intro_image')['url'] ?: AH_URI.'/assets/images/virgin-body-wave.png' ); ?>"
         alt="Cambodian virgin hair body wave bundles"
         loading="lazy" width="800" height="1000">
  </div>
  <div class="split__body reveal">
    <span class="t-label">Pure. Natural. Versatile.</span>
    <h2 class="t-h3" style="margin:1rem 0;">What is Virgin Hair?</h2>
    <span class="rule"></span>
    <p class="t-body--lg">
      Our Cambodian virgin hair is 100% human, single-donor, and free from any
      chemical processing. It&rsquo;s the ideal choice for women who want
      premium quality without compromise — available in 10+ textures and up to 30 inches.
    </p>
    <p class="t-body">
      The natural cuticle structure means exceptional softness, minimal shedding,
      and a lifespan that outlasts any synthetic or blended alternative.
      Whether you wear it straight, curled, or in its natural wave pattern,
      Asantey virgin hair adapts to your style — not the other way around.
    </p>
    <div class="btns" style="margin-top:1.5rem;">

      <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I would like to order Cambodian Virgin Hair.')); ?>"
         class="btn btn--ob" target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Order Now
      </a>
    </div>
  </div>
</section>

<div class="marquee-strip marquee-strip--dark">
  <div class="wrap" style="display:flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:2rem;">
    <?php
    $t = [['gem','100% Human'],['sparkle','Single Donor'],['shield','3–5 Year Lifespan'],['check','Minimal Shedding'],['heart','10+ Textures']];
    foreach($t as $i=>$item){
      echo '<span class="marquee-item">'.ah_svg($item[0]).esc_html($item[1]).'</span>';
      if($i<count($t)-1) echo '<span ></span>';
    }
    ?>
  </div>
</div>

<section class="s s--white" id="textures">
  <div class="wrap">
    <div class="sh sh--c reveal">
      <span class="t-label">Available Textures</span>
      <h2 class="t-h2">Choose Your Texture</h2>
      <span class="rule rule--center"></span>
      <p class="t-body">All textures available in 10"–30" at the same price per length.</p>
    </div>
    <div class="texture-grid">
      <?php
      $textures = [
        ['raw-body-wave.jpg',     'body-wave',     'Body Wave',      'Natural wave with incredible movement and versatility.'],
        ['raw-deep-wave.jpg',     'deep-wave',     'Deep Wave',      'Rich, defined S-wave. Stays curly even after washing.'],
        ['raw-straight.jpg',      'straight',      'Straight',       'Silky, sleek, and pin-straight. Holds a curl beautifully.'],
        ['raw-kinky-straight.jpg','kinky-straight','Kinky Straight', 'Blends seamlessly with natural and relaxed hair textures.'],
        ['raw-loose-wave.jpg',    'loose-wave',    'Loose Wave',     'Soft and effortless. Our most popular virgin texture.'],
        ['raw-burmese-curls.jpg', 'burmese-curls', 'Burmese Curls',  'Tight, springy curls with amazing definition.'],
        ['raw-loose-deep.jpg',    'loose-deep',    'Loose Deep',     'Relaxed deep wave. Full volume from root to tip.'],
        ['raw-waver-wave.jpg',    'waver-wave',    'Waver Wave',     'Unique texture — between a loose and body wave.'],
      ];
      foreach($textures as $i=>$t):[$img,$img_key,$name,$desc]=$t;
        $opt_img = ah_opt_img('vir_tex_'.$img_key);
        $img_src = $opt_img['url'] ?: AH_URI.'/assets/images/'.$img;
      ?>
        <div class="ah-texture-card ah-reveal ah-reveal--delay-<?php echo ($i%4)+1; ?>">
          <div class="texture-item__img">
            <img src="<?php echo esc_url($img_src); ?>"
                 alt="Cambodian virgin hair — <?php echo esc_attr($name); ?>"
                 loading="lazy" width="300" height="400">
          </div>
          <h3 class="texture-item__name"><?php echo esc_html($name); ?></h3>
          <p class="t-body" style="margin-top:0.5rem;"><?php echo esc_html($desc); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="s s--white" id="faq">
  <div class="wrap wrap--narrow">
    <div class="sh sh--c reveal">
      <span class="t-label">Common Questions</span>
      <h2 class="t-h2">Virgin Hair FAQ</h2>
      <span class="rule rule--center"></span>
    </div>
    <div class="acc reveal">
      <?php foreach($faqs as $faq): ?>
        <div class="accordion__item">
          <button class="acc__trigger" type="button" aria-expanded="false">
            <span class="acc__q"><?php echo esc_html($faq['question']); ?></span>
            <span class="acc__icon"><?php echo ah_svg('plus'); ?></span>
          </button>
          <div class="acc__body">
            <p class="acc__ans"><?php echo esc_html($faq['answer']); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<div class="cta-band dark">
  <div class="wrap"><div class="reveal">
    <span class="t-label t-label--white">Ready to Order?</span>
    <h2 class="t-h1">Order Your Virgin Hair Bundles</h2>
    <p class="t-body">WhatsApp us or use our order form — we confirm within hours and dispatch in 2–3 business days.</p>
    <div class="btns" style="justify-content:center;">
      <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I would like to order Cambodian Virgin Hair.')); ?>"
         class="btn btn--wa" target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Order on WhatsApp
      </a>
      <a href="<?php echo esc_url(home_url('/order/')); ?>" class="btn btn--outline-white">Use Order Form</a>
    </div>
  </div></div>
</div>

<?php get_footer(); ?>
