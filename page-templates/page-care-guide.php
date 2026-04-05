<?php
/**
 * Template Name: Hair Care Guide
 * Asantey Hair & Beauty
 */
get_header();

echo ah_schema_breadcrumb([
  ['name' => 'Home',            'url' => home_url('/')],
  ['name' => 'Hair Care Guide', 'url' => get_permalink()],
]);

echo ah_schema_article(
  'The Asantey Hair Care Guide — How to Make Your Extensions Last 3–5 Years',
  'Complete care guide for Cambodian raw and virgin hair extensions. Learn how to wash, condition, heat-style, and store your hair for maximum lifespan.',
  '2024-01-01'
);

$faqs = [
  ['question' => 'How often should I wash my hair extensions?','answer' => 'For raw and virgin hair extensions, washing every 1–2 weeks is ideal. Over-washing strips natural oils; under-washing leads to product buildup. Use a sulphate-free shampoo and always deep condition after washing.'],
  ['question' => 'Can I use heat on Cambodian raw hair?','answer' => 'Yes. Raw hair responds to heat just like your natural hair. Always use a heat protectant spray and keep your flat iron or curling wand below 230°C. For daily styling, try to let hair air-dry when possible to extend lifespan.'],
  ['question' => 'What shampoo should I use on hair extensions?','answer' => 'Always use a sulphate-free, moisturising shampoo. Sulphates strip natural oils and can cause dryness and tangling over time. Argan oil or keratin shampoos work particularly well with Cambodian hair.'],
  ['question' => 'How do I store hair extensions when not wearing them?','answer' => 'Store your hair in a silk or satin bag, loosely braided or bundled. Keep it away from direct sunlight and extreme heat or cold. Never store it damp — always let it dry fully before putting it away.'],
];

echo ah_schema_faq($faqs);
?>

<div class="header-offset"></div>

<section class="page-hero">
  <div class="page-hero__bg">
    <img src="<?php echo esc_url(AH_URI.'/assets/images/raw-loose-deep.jpg'); ?>" alt="" aria-hidden="true" loading="eager" width="1280" height="500">
  </div>
  <div class="page-hero__content">
    <span class="t-label">Education &amp; Care</span>
    <h1 class="t-h1">The Asantey<br>Hair Care Guide</h1>
    <p >Protect your investment. Keep your hair looking salon-fresh — for years, not months.</p>
  </div>
</section>

<?php ah_breadcrumb(); ?>

<section class="section">
  <div class="wrap wrap--narrow">

    <!-- TOC -->
    <div class="toc reveal">
      <div class="t-label">In This Guide</div>
      <ol>
        <li><a href="#how-to-wash">How to Wash Your Extensions</a></li>
        <li><a href="#heat-styling">Heat Styling Guide</a></li>
        <li><a href="#make-it-last">How to Make Your Hair Last 3–5 Years</a></li>
        <li><a href="#storage">Storage Tips</a></li>
        <li><a href="#dos-donts">Do&rsquo;s and Don&rsquo;ts</a></li>
        <li><a href="#care-faq">Hair Care FAQ</a></li>
      </ol>
    </div>

    <!-- How to Wash -->
    <div id="how-to-wash" class="prose reveal" style="margin-bottom:4rem;">
      <h2>How to Wash Your Extensions</h2>
      <p>Proper washing is the foundation of long-lasting hair extensions. The goal is to cleanse without stripping — removing product buildup and sweat while preserving the hair&rsquo;s natural oils and moisture.</p>
      <h3>Step-by-Step Washing Routine</h3>
      <ol>
        <li><strong>Detangle first.</strong> Using a wide-tooth comb or paddle brush, gently detangle from tip to root before getting the hair wet. Never detangle wet hair aggressively.</li>
        <li><strong>Wet the hair with lukewarm water.</strong> Hot water opens the cuticle and can cause frizz. Run water in a downward direction (root to tip) to keep cuticles smooth.</li>
        <li><strong>Apply sulphate-free shampoo.</strong> Work it through gently with your fingers in a downward motion. Avoid rough circular scrubbing, which causes tangling.</li>
        <li><strong>Rinse thoroughly.</strong> Leftover shampoo is a common cause of dryness and dull hair. Rinse until the water runs completely clear.</li>
        <li><strong>Deep condition every wash.</strong> Apply a moisture-rich conditioner from mid-shaft to tips. Leave for 5–10 minutes (or use a heat cap for deeper penetration), then rinse.</li>
        <li><strong>Air-dry when possible.</strong> Gently squeeze excess water with a microfibre towel — never rub. Air-drying preserves the hair&rsquo;s natural texture and extends lifespan significantly.</li>
      </ol>
    </div>

    <!-- Heat Styling -->
    <div id="heat-styling" class="prose reveal" style="margin-bottom:4rem;">
      <h2>Heat Styling Guide</h2>
      <p>Cambodian raw and virgin hair handles heat beautifully — but like any hair, repeated high heat without protection will cause long-term damage. The key is protection and moderation.</p>
      <h3>Temperature Guidelines</h3>
      <ul>
        <li><strong>Fine or wavy textures:</strong> 150–180°C (300–360°F)</li>
        <li><strong>Standard straight or wave:</strong> 180–200°C (360–390°F)</li>
        <li><strong>Thicker or curly textures:</strong> 200–230°C (390–445°F)</li>
      </ul>
      <h3>Heat Styling Rules</h3>
      <ul>
        <li>Always apply a quality heat protectant before using any heat tool.</li>
        <li>Never apply heat to wet or damp hair — always style on dry hair.</li>
        <li>Use a single pass with your flat iron rather than going over sections repeatedly.</li>
        <li>Allow the hair to cool fully before brushing or styling further.</li>
        <li>Limit heat styling to 2–3 times per week for maximum longevity.</li>
      </ul>
    </div>

    <!-- Make It Last -->
    <div id="make-it-last" class="prose reveal" style="margin-bottom:4rem;">
      <h2>How to Make Your Hair Last 3–5 Years</h2>
      <p>The lifespan of your extensions is directly proportional to how well you care for them. Here are the four pillars of long-lasting Cambodian hair:</p>
      <h3>1. Moisture is Everything</h3>
      <p>Unlike your natural hair, extensions don&rsquo;t receive moisture from your scalp. You must replace this manually. Use a lightweight leave-in conditioner or hair oil (argan, jojoba, or castor oil work well) regularly — especially on the ends, which are the oldest and most vulnerable part of the hair.</p>
      <h3>2. Protect at Night</h3>
      <p>Cotton pillowcases cause friction and moisture loss overnight. Switch to a satin or silk pillowcase, or wrap your hair in a satin bonnet or scarf before sleeping. This one change alone can add months to your hair&rsquo;s lifespan.</p>
      <h3>3. Handle Gently</h3>
      <p>Always detangle from tip to root using a wide-tooth comb or your fingers. Never pull through knots — work them out slowly. Treat your extensions as you would treat your finest clothing.</p>
      <h3>4. Regular Deep Conditioning</h3>
      <p>Monthly deep conditioning treatments using a protein-moisture balance mask will keep your hair strong, elastic, and resistant to breakage. Pay particular attention to the ends — trim any split ends as they appear rather than letting them travel up the shaft.</p>
    </div>

    <!-- Storage Tips -->
    <div id="storage" class="prose reveal" style="margin-bottom:4rem;">
      <h2>Storage Tips</h2>
      <p>How you store your hair when you&rsquo;re not wearing it matters more than most people realise. Poor storage leads to tangling, matting, and premature wear.</p>
      <ul>
        <li><strong>Always store completely dry.</strong> Damp hair stored in a bag or box leads to mildew, odour, and irreversible damage.</li>
        <li><strong>Loosely braid before storing.</strong> A loose single or double braid keeps the hair organised and tangle-free.</li>
        <li><strong>Use a satin or silk bag.</strong> Silk minimises friction and static, keeping the hair smooth and manageable.</li>
        <li><strong>Avoid direct sunlight and heat.</strong> UV rays fade colour and weaken the hair shaft over time. Store in a cool, dry place.</li>
        <li><strong>Keep bundles and closures separate.</strong> Store each bundle individually to prevent them matting together.</li>
      </ul>
    </div>

    <!-- Do / Don't -->
    <div id="dos-donts" class="reveal" style="margin-bottom:4rem;">
      <h3 class="t-h4" style="margin-bottom:1.5rem;">Quick Reference: Do&rsquo;s &amp; Don&rsquo;ts</h3>
      <div class="do-dont">
        <div class="ah-do-dont__col ah-do-dont__col--do">
          <div class="ah-do-dont__heading">Do</div>
          <ul>
            <li>Use sulphate-free shampoo and conditioner</li>
            <li>Deep condition after every wash</li>
            <li>Apply heat protectant before any heat styling</li>
            <li>Sleep on a satin or silk pillowcase</li>
            <li>Detangle gently from tip to root</li>
            <li>Store hair completely dry in a satin bag</li>
            <li>Use lightweight oils on the ends regularly</li>
          </ul>
        </div>
        <div class="ah-do-dont__col ah-do-dont__col--dont">
          <div class="ah-do-dont__heading">Don&rsquo;t</div>
          <ul>
            <li>Use sulphate or alcohol-based products</li>
            <li>Apply heat without a protectant</li>
            <li>Detangle from root to tip</li>
            <li>Sleep with wet or uncovered hair</li>
            <li>Store damp or in direct sunlight</li>
            <li>Over-wash (more than twice per week)</li>
            <li>Pull through knots or tangles forcefully</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- FAQ -->
    <div id="care-faq" class="reveal">
      <h2 class="t-h3" style="margin-bottom:2rem;">Hair Care FAQ</h2>
      <div class="accordion">
        <?php foreach($faqs as $faq): ?>
          <div class="accordion__item">
            <button class="accordion__trigger" type="button" aria-expanded="false">
              <span class="accordion__q"><?php echo esc_html($faq['question']); ?></span>
              <span class="accordion__icon"><?php echo ah_svg('plus'); ?></span>
            </button>
            <div class="accordion__body"><p class="accordion__ans"><?php echo esc_html($faq['answer']); ?></p></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div>
</section>

<div class="cta-band">
  <div class="wrap"><div class="reveal">
    <span class="t-label t-label--white">Ready to Invest in Quality?</span>
    <h2 class="t-h1">Shop the Asantey Collection</h2>
    <p class="t-body">Hair worth caring for. Browse our Raw Hair, Virgin Hair, and HD Lace collections — all in stock and ready to ship.</p>
    <div class="btn-group" style="justify-content:center;">
      <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="btn btn--black">Shop Now <?php echo ah_svg('arrow-right'); ?></a>
      <a href="<?php echo esc_url(home_url('/faq/')); ?>" class="btn btn--outline-white">View FAQ</a>
    </div>
  </div></div>
</div>

<?php get_footer(); ?>
