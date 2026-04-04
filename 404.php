<?php
/**
 * Asantey Hair & Beauty — 404.php
 */
get_header();
?>
<div class="ah-header-offset"></div>
<section class="ah-section" style="min-height:70vh;display:flex;align-items:center;">
  <div class="ah-container" style="text-align:center;">
    <span class="ah-subheading">Error 404</span>
    <h1 class="ah-heading-xl" style="margin:var(--ah-space-4) 0;font-family:var(--ah-font-display);font-weight:300;">
      Looks Like This Page<br>Took a Day Off
    </h1>
    <span class="ah-accent-line ah-accent-line--center"></span>
    <p class="ah-body-lg" style="max-width:520px;margin:var(--ah-space-6) auto var(--ah-space-10);">
      The page you&rsquo;re looking for doesn&rsquo;t exist or has been moved.
      Let&rsquo;s get you back to the good stuff.
    </p>
    <div class="ah-btn-group" style="justify-content:center;">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="ah-btn ah-btn--primary ah-btn--lg">Back to Home</a>
      <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="ah-btn ah-btn--gold ah-btn--lg">Shop the Collection</a>
      <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I need help finding something on your website.')); ?>"
         class="ah-btn ah-btn--outline" target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Ask on WhatsApp
      </a>
    </div>
  </div>
</section>
<?php get_footer(); ?>
