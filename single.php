<?php
/**
 * Asantey Hair & Beauty — single.php
 */
get_header();
while(have_posts()): the_post();
?>
<div class="ah-header-offset"></div>
<section class="ah-page-hero">
  <?php if(has_post_thumbnail()): ?>
    <div class="ah-page-hero__bg">
      <img src="<?php echo esc_url(get_the_post_thumbnail_url(null,'ah-wide')); ?>" alt="" aria-hidden="true" loading="eager" width="1280" height="500">
    </div>
  <?php endif; ?>
  <div class="ah-page-hero__content">
    <span class="ah-page-hero__label"><?php echo esc_html(get_the_date()); ?></span>
    <h1 class="ah-page-hero__title" style="max-width:800px;"><?php the_title(); ?></h1>
  </div>
</section>
<?php ah_breadcrumb(); ?>
<section class="ah-section">
  <div class="ah-container" style="display:grid;grid-template-columns:1fr 320px;gap:var(--ah-space-16);align-items:start;">
    <article class="ah-prose">
      <?php the_content(); ?>
    </article>
    <aside style="position:sticky;top:calc(var(--ah-header-height) + var(--ah-space-8));">
      <div style="background:var(--ah-grey-100);padding:var(--ah-space-8);">
        <h3 style="font-family:var(--ah-font-display);font-size:var(--ah-text-2xl);margin-bottom:var(--ah-space-4);">Shop Our Hair</h3>
        <p style="font-size:var(--ah-text-sm);color:var(--ah-grey-700);margin-bottom:var(--ah-space-5);">Premium Cambodian hair extensions. Raw, virgin, closures, and frontals.</p>
        <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="ah-btn ah-btn--primary" style="width:100%;justify-content:center;">Shop Now</a>
      </div>
    </aside>
  </div>
</section>
<?php endwhile; get_footer(); ?>
