<?php
/**
 * Asantey Hair & Beauty — 404.php
 */
get_header();
?>
<div class="header-offset"></div>
<section class="section" style="min-height:70vh;display:flex;align-items:center;">
  <div class="wrap" style="text-align:center;">
    <span class="t-label">Error 404</span>
    <h1 class="t-h1" style="margin:var(--gap4) 0;font-family:var(--ah-font-display);font-weight:300;">
      Looks Like This Page<br>Took a Day Off
    </h1>
    <span class="rule rule--center"></span>
    <p class="t-body--lg" style="max-width:520px;margin:var(--gap6) auto var(--gap10);">
      The page you&rsquo;re looking for doesn&rsquo;t exist or has been moved.
      Let&rsquo;s get you back to the good stuff.
    </p>
    <div class="btn-group" style="justify-content:center;">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--black">Back to Home</a>
      <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="btn btn--black">Shop the Collection</a>
      <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I need help finding something on your website.')); ?>"
         class="btn btn--outline" target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Ask on WhatsApp
      </a>
    </div>
  </div>
</section>
<?php get_footer(); ?>
