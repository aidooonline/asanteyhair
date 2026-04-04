<?php
/**
 * Asantey Hair & Beauty — archive.php
 */
get_header();
?>
<div class="header-offset"></div>
<section class="page-hero">
  <div class="page-hero__content">
    <h1 class="t-h1"><?php the_archive_title(); ?></h1>
    <?php if(get_the_archive_description()): ?>
      <p ><?php echo wp_kses_post(get_the_archive_description()); ?></p>
    <?php endif; ?>
  </div>
</section>
<?php ah_breadcrumb(); ?>
<section class="section">
  <div class="wrap">
    <div class="grid-3">
      <?php
      if(have_posts()):
        while(have_posts()): the_post();
          if(get_post_type() === 'hair_product') {
            ah_product_card(get_post());
          } else { ?>
            <article class="product-card">
              <?php if(has_post_thumbnail()): ?>
                <div class="product-card__img"><img src="<?php echo esc_url(get_the_post_thumbnail_url(null,'ah-product')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy" width="600" height="800"></div>
              <?php endif; ?>
              <div class="product-card__body">
                <h2 class="product-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <p class="product-card__desc"><?php the_excerpt(); ?></p>
                <a href="<?php the_permalink(); ?>" class="btn btn--outline btn--sm">Read More <?php echo ah_svg('arrow-right'); ?></a>
              </div>
            </article>
          <?php }
        endwhile;
        the_posts_pagination(['mid_size'=>2]);
      endif;
      ?>
    </div>
  </div>
</section>
<?php get_footer(); ?>
