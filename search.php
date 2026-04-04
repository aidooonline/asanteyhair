<?php
/**
 * Asantey Hair & Beauty — search.php
 */
get_header();
?>
<div class="ah-header-offset"></div>
<section class="ah-page-hero">
  <div class="ah-page-hero__content">
    <span class="ah-page-hero__label">Search Results</span>
    <h1 class="ah-page-hero__title">
      <?php printf('Results for: "%s"', '<em style="color:var(--ah-gold);">' . esc_html(get_search_query()) . '</em>'); ?>
    </h1>
  </div>
</section>
<section class="ah-section">
  <div class="ah-container">
    <?php if(have_posts()): ?>
      <div class="ah-grid ah-grid--3">
        <?php while(have_posts()): the_post(); ?>
          <article class="ah-card">
            <?php if(has_post_thumbnail()): ?>
              <div class="ah-card__image"><img src="<?php echo esc_url(get_the_post_thumbnail_url(null,'ah-product')); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" width="600" height="800"></div>
            <?php endif; ?>
            <div class="ah-card__body">
              <h2 class="ah-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
              <p class="ah-card__textures"><?php the_excerpt(); ?></p>
              <a href="<?php the_permalink(); ?>" class="ah-btn ah-btn--outline ah-btn--sm">View <?php echo ah_svg('arrow-right'); ?></a>
            </div>
          </article>
        <?php endwhile; ?>
      </div>
      <?php the_posts_pagination(['mid_size'=>2]); ?>
    <?php else: ?>
      <div style="text-align:center;max-width:600px;margin:0 auto;">
        <p class="ah-body-lg">No results found for &ldquo;<?php echo esc_html(get_search_query()); ?>&rdquo;. Try a different search or browse our collections.</p>
        <?php get_search_form(); ?>
        <div class="ah-btn-group" style="justify-content:center;margin-top:var(--ah-space-8);">
          <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="ah-btn ah-btn--primary">Browse All Products</a>
          <a href="<?php echo esc_url(home_url('/faq/')); ?>" class="ah-btn ah-btn--outline">View FAQ</a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php get_footer(); ?>
