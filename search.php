<?php
/**
 * Asantey Hair & Beauty — search.php
 */
get_header();
?>
<div class="header-offset"></div>
<section class="page-hero">
  <div class="page-hero__content">
    <span class="t-label">Search Results</span>
    <h1 class="t-h1">
      <?php printf('Results for: "%s"', '<em style="color:var(--gold);">' . esc_html(get_search_query()) . '</em>'); ?>
    </h1>
  </div>
</section>
<section class="section">
  <div class="wrap">
    <?php if(have_posts()): ?>
      <div class="grid-3">
        <?php while(have_posts()): the_post(); ?>
          <article class="product-card">
            <?php if(has_post_thumbnail()): ?>
              <div class="product-card__img"><img src="<?php echo esc_url(get_the_post_thumbnail_url(null,'ah-product')); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" width="600" height="800"></div>
            <?php endif; ?>
            <div class="product-card__body">
              <h2 class="product-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
              <p class="product-card__desc"><?php the_excerpt(); ?></p>
              <a href="<?php the_permalink(); ?>" class="btn btn--outline btn--sm">View <?php echo ah_svg('arrow-right'); ?></a>
            </div>
          </article>
        <?php endwhile; ?>
      </div>
      <?php the_posts_pagination(['mid_size'=>2]); ?>
    <?php else: ?>
      <div style="text-align:center;max-width:600px;margin:0 auto;">
        <p class="t-body--lg">No results found for &ldquo;<?php echo esc_html(get_search_query()); ?>&rdquo;. Try a different search or browse our collections.</p>
        <?php get_search_form(); ?>
        <div class="btn-group" style="justify-content:center;margin-top:var(--gap8);">
          <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="btn btn--black">Browse All Products</a>
          <a href="<?php echo esc_url(home_url('/faq/')); ?>" class="btn btn--outline">View FAQ</a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php get_footer(); ?>
