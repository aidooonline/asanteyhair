<?php
/**
 * Template Name: Closures & Frontals
 * Asantey Hair & Beauty
 */
get_header();

echo ah_schema_breadcrumb([
  ['name' => 'Home',                'url' => home_url('/')],
  ['name' => 'Shop',                'url' => home_url('/shop/')],
  ['name' => 'Closures & Frontals', 'url' => get_permalink()],
]);

$faqs = [
  ['question' => 'What is HD lace?',
   'answer'   => 'HD (High Definition) lace is an ultra-thin, transparent Swiss lace that virtually disappears against the skin. Unlike regular lace closures, HD lace doesn\'t need to be bleached to match your scalp — it naturally adapts to your skin tone for a completely invisible hairline.'],
  ['question' => 'What is the difference between a closure and a frontal?',
   'answer'   => 'A closure covers a smaller area — typically 4x4, 5x5, or 6x6 inches — at the crown or parting area. A frontal covers the full hairline ear-to-ear, measuring 13x4 or 13x6 inches. Frontals offer more styling versatility; closures are easier to install and maintain.'],
  ['question' => 'Which closure size should I choose?',
   'answer'   => 'The 4x4 closure is the most popular for a centre or side parting. The 5x5 and 6x6 are ideal for a wider parting or a more natural-looking install. The 2x6 is best for a deep centre part. All our closures come in HD lace for an invisible finish.'],
  ['question' => 'How many bundles do I need with my closure?',
   'answer'   => 'For 12"–18", 2 bundles are typically sufficient. For 20"–24", 2–3 bundles. For 26"–30", 3 bundles are recommended for a full, voluminous look. With a frontal (which covers more area), you may need one fewer bundle than with a closure.'],
  ['question' => 'What textures are available for closures and frontals?',
   'answer'   => 'Our HD lace closures and frontals are available in: Straight, Kinky Straight, Yaki Straight, Deep Wave, Body Wave, Loose Wave, Water Wave, and Burmese Curls.'],
];

echo ah_schema_faq($faqs);
?>

<div class="header-offset"></div>

<section class="page-hero">
  <div class="page-hero__bg">
    <img src="<?php echo esc_url(AH_URI.'/assets/images/closures-frontals-pricelist.jpg'); ?>"
         alt="" aria-hidden="true" loading="eager" width="1280" height="500">
  </div>
  <div class="page-hero__content">
    <span class="t-label">The Perfect Finish</span>
    <h1 class="t-h1">HD Lace Closures<br>&amp; Frontals</h1>
    <p >Invisible lace that melts into every skin tone. The final touch that makes every install flawless.</p>
  </div>
</section>

<?php ah_breadcrumb(); ?>

<!-- What is HD Lace -->
<section class="split section--sm">
  <div class="split__media">
    <img src="<?php echo esc_url(AH_URI.'/assets/images/hd-lace-sizes.png'); ?>"
         alt="HD lace closure and frontal sizes guide"
         loading="lazy" width="800" height="800">
  </div>
  <div class="split__body reveal">
    <span class="t-label">Why HD Lace?</span>
    <h2 class="t-h3" style="margin:var(--gap4) 0;">The Invisible Lace Standard</h2>
    <span class="rule"></span>
    <p class="t-body--lg">
      HD lace is the most advanced lace technology available in the hair industry.
      Ultra-thin Swiss lace that adapts to your skin tone without bleaching —
      so your hairline looks undetectable from every angle.
    </p>
    <p class="t-body">
      Regular lace often requires tinting or bleaching to match the scalp. HD lace doesn&rsquo;t.
      It virtually disappears, creating the illusion that the hair is growing directly
      from your scalp. The result is an install so natural, even your stylist
      will do a double-take.
    </p>
    <ul style="margin:var(--gap5) 0;list-style:none;display:flex;flex-direction:column;gap:var(--gap3);">
      <?php
      $benefits = ['Ultra-thin Swiss lace — zero bulge','Matches every skin tone naturally','No bleaching required','Available in 6 sizes — closures and frontals','All textures available'];
      foreach($benefits as $b):?>
        <li style="display:flex;align-items:center;gap:var(--gap3);font-size:var(--ah-text-sm);color:var(--g5);">
          <span style="display:inline-flex;align-items:center;justify-content:center;width:18px;height:18px;background:var(--gold);border-radius:50%;flex-shrink:0;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="width:10px;height:10px;display:block;">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
          </span>
          <span><?php echo esc_html($b);?></span>
        </li>
      <?php endforeach;?>
    </ul>
  </div>
</section>

<!-- Size Guide -->
<section class="section section--grey" id="sizes">
  <div class="wrap">
    <div class="section-head section-head--center reveal">
      <span class="t-label">Choose Your Size</span>
      <h2 class="t-h2">Available Sizes &amp; Textures</h2>
      <span class="rule rule--center"></span>
    </div>

    <div class="grid-2" style="gap:var(--gap8);">
      <!-- Closures -->
      <div class="reveal">
        <h3 class="t-h4" style="margin-bottom:var(--gap4);">HD Lace Closures</h3>
        <?php
        $closure_sizes = [
          '2x6'  => '2x6 Closure — Deep Centre Part',
          '4x4'  => '4x4 Closure — Most Popular',
          '5x5'  => '5x5 Closure — Wider Parting',
          '6x6'  => '6x6 Closure — Maximum Coverage',
        ];
        foreach($closure_sizes as $type => $label):
          $rows = ah_get_pricing($type);
          $from = min(array_map('floatval', array_values($rows)));
          ?>
          <div style="border:1px solid #e0e0e0;padding:var(--gap4) var(--gap5);margin-bottom:var(--gap3);display:flex;justify-content:space-between;align-items:center;">
            <div>
              <strong style="font-family:var(--ah-font-display);font-size:var(--ah-text-xl);"><?php echo esc_html($label);?></strong>
              <div style="font-size:var(--ah-text-xs);color:var(--g9);margin-top:2px;">12"–22" &middot; All textures available</div>
            </div>
            <div style="font-family:var(--ah-font-display);font-size:var(--ah-text-2xl);font-weight:600;">from &pound;<?php echo esc_html($from);?></div>
          </div>
        <?php endforeach;?>
      </div>
      <!-- Frontals -->
      <div class="reveal d2">
        <h3 class="t-h4" style="margin-bottom:var(--gap4);">HD Lace Frontals</h3>
        <?php
        $frontal_sizes = [
          '13x4' => '13x4 Frontal — Ear to Ear',
          '13x6' => '13x6 Frontal — Deeper Part',
        ];
        foreach($frontal_sizes as $type => $label):
          $rows = ah_get_pricing($type);
          $from = min(array_map('floatval', array_values($rows)));
          ?>
          <div style="border:1px solid #e0e0e0;padding:var(--gap4) var(--gap5);margin-bottom:var(--gap3);display:flex;justify-content:space-between;align-items:center;">
            <div>
              <strong style="font-family:var(--ah-font-display);font-size:var(--ah-text-xl);"><?php echo esc_html($label);?></strong>
              <div style="font-size:var(--ah-text-xs);color:var(--g9);margin-top:2px;">12"–22" &middot; All textures available</div>
            </div>
            <div style="font-family:var(--ah-font-display);font-size:var(--ah-text-2xl);font-weight:600;">from &pound;<?php echo esc_html($from);?></div>
          </div>
        <?php endforeach;?>

        <div style="background:var(--off);padding:var(--gap5);margin-top:var(--gap4);">
          <h4 style="font-family:var(--ah-font-display);font-size:var(--ah-text-xl);margin-bottom:var(--gap2);">Textures Available</h4>
          <p style="font-size:var(--ah-text-sm);color:var(--g5);">
            Straight &middot; Kinky Straight &middot; Yaki Straight &middot; Deep Wave &middot;
            Body Wave &middot; Loose Wave &middot; Water Wave &middot; Burmese Curls
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Full Pricing Tables -->
<section class="section" id="pricing">
  <div class="wrap">
    <div class="section-head section-head--center reveal">
      <span class="t-label">Full Pricing</span>
      <h2 class="t-h2">Closures &amp; Frontals — Price Lists</h2>
      <span class="rule rule--center"></span>
    </div>
    <div class="grid-2 reveal">
      <?php ah_pricing_table('2x6',  '2x6 HD Lace Closure',  '12"–22" available'); ?>
      <?php ah_pricing_table('4x4',  '4x4 HD Lace Closure',  '12"–22" available'); ?>
      <?php ah_pricing_table('5x5',  '5x5 HD Lace Closure',  '12"–22" available'); ?>
      <?php ah_pricing_table('6x6',  '6x6 HD Lace Closure',  '12"–22" available'); ?>
      <?php ah_pricing_table('13x4', '13x4 HD Lace Frontal', '12"–22" available'); ?>
      <?php ah_pricing_table('13x6', '13x6 HD Lace Frontal', '12"–22" available'); ?>
    </div>
  </div>
</section>

<!-- How Many Bundles Guide -->
<section class="section section--grey">
  <div class="wrap wrap--narrow reveal">
    <div class="section-head section-head--center">
      <span class="t-label">Bundle Guide</span>
      <h2 class="t-h2">How Many Bundles Do I Need?</h2>
      <span class="rule rule--center"></span>
    </div>
    <div class="prose">
      <table>
        <thead><tr><th>Length</th><th>With Closure</th><th>With Frontal</th></tr></thead>
        <tbody>
          <tr><td>12"–18"</td><td>2 Bundles</td><td>1–2 Bundles</td></tr>
          <tr><td>20"–24"</td><td>2–3 Bundles</td><td>2 Bundles</td></tr>
          <tr><td>26"–30"</td><td>3 Bundles</td><td>2–3 Bundles</td></tr>
        </tbody>
      </table>
      <p style="font-size:var(--ah-text-sm);color:var(--g9);font-style:italic;">
        Bundle counts are approximate and may vary based on desired fullness, head size, and install method.
        Not sure? WhatsApp us — we will help you choose the perfect combination.
      </p>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="section" id="faq">
  <div class="wrap wrap--narrow">
    <div class="section-head section-head--center reveal">
      <span class="t-label">Common Questions</span>
      <h2 class="t-h2">HD Lace FAQ</h2>
      <span class="rule rule--center"></span>
    </div>
    <div class="ah-accordion ah-reveal">
      <?php foreach($faqs as $faq): ?>
        <div class="accordion__item">
          <button class="accordion__trigger" type="button" aria-expanded="false">
            <span class="accordion__q"><?php echo esc_html($faq['question']); ?></span>
            <span class="accordion__icon"><?php echo ah_svg('plus'); ?></span>
          </button>
          <div class="accordion__body">
            <p class="accordion__ans"><?php echo esc_html($faq['answer']); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<div class="cta-band">
  <div class="wrap"><div class="reveal">
    <span class="t-label t-label--white">Ready for Your Perfect Hairline?</span>
    <h2 class="t-h1">Order Your HD Lace Today</h2>
    <p class="t-body">Tell us your closure size, texture, and length — we will send your invoice within hours.</p>
    <div class="btn-group" style="justify-content:center;">
      <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I\'d like to order an HD Lace Closure or Frontal.')); ?>"
         class="btn btn--wa" target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Order on WhatsApp
      </a>
      <a href="<?php echo esc_url(home_url('/order/')); ?>" class="btn btn--outline-white">Use Order Form</a>
    </div>
  </div></div>
</div>

<?php get_footer(); ?>
