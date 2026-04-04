<?php /* Template Name: Gallery */ get_header(); echo ah_schema_breadcrumb([['name'=>'Home','url'=>home_url('/')],['name'=>'Gallery','url'=>get_permalink()]]); ?>
<div class="ah-header-offset"></div>
<section class="ah-page-hero"><div class="ah-page-hero__bg"><img src="<?php echo esc_url(AH_URI.'/assets/images/client-result-1.jpg'); ?>" alt="" aria-hidden="true" loading="eager" width="1280" height="500"></div>
<div class="ah-page-hero__content"><span class="ah-page-hero__label">Client Results</span><h1 class="ah-page-hero__title">Real Women.<br>Real Results.</h1><p class="ah-page-hero__subtitle">Every photo is a genuine Asantey client. No filters. No stock images. Just quality you can see.</p></div></section>
<?php ah_breadcrumb(); ?>
<section class="ah-section">
  <div class="ah-container">
    <div class="ah-section-header--center ah-reveal" style="margin-bottom:var(--ah-space-12);">
      <span class="ah-subheading">Client Gallery</span>
      <h2 class="ah-heading-lg">See It to Believe It</h2>
      <span class="ah-accent-line ah-accent-line--center"></span>
      <p class="ah-body-lg" style="max-width:560px;margin:0 auto;">Our clients are our greatest advertisement. Join hundreds of women who trust Asantey Hair &amp; Beauty for their signature look.</p>
    </div>
    <div class="ah-gallery ah-gallery--masonry ah-reveal">
      <?php for($i=1;$i<=7;$i++): ?>
        <div class="ah-gallery__item"><img src="<?php echo esc_url(AH_URI.'/assets/images/client-result-'.$i.'.jpg'); ?>" alt="Asantey Hair &amp; Beauty client result <?php echo $i; ?>" loading="lazy" width="600" height="800"><div class="ah-gallery__overlay"><span class="ah-gallery__caption">Client Result <?php echo $i; ?></span></div></div>
      <?php endfor; ?>
    </div>
    <div style="text-align:center;margin-top:var(--ah-space-16);" class="ah-reveal">
      <p class="ah-body-lg" style="margin-bottom:var(--ah-space-6);">Tag us on Instagram to be featured in our gallery.</p>
      <?php if(get_theme_mod('ah_social_instagram')): ?>
        <a href="<?php echo esc_url(get_theme_mod('ah_social_instagram')); ?>" class="ah-btn ah-btn--primary" target="_blank" rel="noopener noreferrer"><?php echo ah_svg('instagram'); ?> Follow on Instagram</a>
      <?php endif; ?>
    </div>
  </div>
</section>
<div class="ah-cta-band"><div class="ah-container"><div class="ah-reveal">
  <span class="ah-cta-band__label">Ready for Your Transformation?</span>
  <h2 class="ah-cta-band__heading">Your Result Could Be Next</h2>
  <p class="ah-cta-band__body">Browse our collections and order the hair that&rsquo;ll have everyone asking &ldquo;where did you get your hair?&rdquo;</p>
  <div class="ah-btn-group" style="justify-content:center;">
    <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="ah-btn ah-btn--gold ah-btn--lg">Shop Collections <?php echo ah_svg('arrow-right'); ?></a>
    <a href="<?php echo esc_url(ah_whatsapp_url()); ?>" class="ah-btn ah-btn--outline-white ah-btn--lg" target="_blank" rel="noopener noreferrer"><?php echo ah_svg('whatsapp'); ?> WhatsApp Order</a>
  </div>
</div></div></div>
<?php get_footer(); ?>
