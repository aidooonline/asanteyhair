<?php
/**
 * Asantey Hair & Beauty — single.php
 */
get_header();
while(have_posts()): the_post();
?>
<div class="header-offset"></div>
<section class="page-hero">
  <?php if(has_post_thumbnail()): ?>
    <div class="page-hero__bg">
      <img src="<?php echo esc_url(get_the_post_thumbnail_url(null,'ah-wide')); ?>" alt="" aria-hidden="true" loading="eager" width="1280" height="500">
    </div>
  <?php endif; ?>
  <div class="page-hero__content">
    <span class="t-label"><?php echo esc_html(get_the_date()); ?></span>
    <h1 class="t-h1" style="max-width:800px;"><?php the_title(); ?></h1>
  </div>
</section>
<?php ah_breadcrumb(); ?>
<section class="section">
  <div class="wrap" style="display:grid;grid-template-columns:1fr 320px;gap:var(--gap16);align-items:start;">
    <article class="prose">
      <?php the_content(); ?>
    </article>
    <aside style="position:sticky;top:calc(var(--ah-header-height) + var(--gap8));">
      <div style="background:var(--off);padding:var(--gap8);">
        <h3 style="font-family:var(--ah-font-display);font-size:var(--ah-text-2xl);margin-bottom:var(--gap4);">Shop Our Hair</h3>
        <p style="font-size:var(--ah-text-sm);color:var(--g5);margin-bottom:var(--gap5);">Premium Cambodian hair extensions. Raw, virgin, closures, and frontals.</p>
        <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="btn btn--black" style="width:100%;justify-content:center;">Shop Now</a>
      </div>
    </aside>
  </div>
</section>
<?php endwhile; get_footer(); ?>
