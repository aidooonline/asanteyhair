<?php
/**
 * Asantey Hair & Beauty — archive.php
 */
get_header();
?>
<div class="ah-header-offset"></div>
<section class="ah-page-hero">
  <div class="ah-page-hero__content">
    <h1 class="ah-page-hero__title"><?php the_archive_title(); ?></h1>
    <?php if(get_the_archive_description()): ?>
      <p class="ah-page-hero__subtitle"><?php echo wp_kses_post(get_the_archive_description()); ?></p>
    <?php endif; ?>
  </div>
</section>
<?php ah_breadcrumb(); ?>
<section class="ah-section">
  <div class="ah-container">
    <div class="ah-grid ah-grid--3">
      <?php
      if(have_posts()):
        while(have_posts()): the_post();
          if(get_post_type() === 'hair_product') {
            ah_product_card(get_post());
          } else { ?>
            <article class="ah-card">
              <?php if(has_post_thumbnail()): ?>
                <div class="ah-card__image"><img src="<?php echo esc_url(get_the_post_thumbnail_url(null,'ah-product')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy" width="600" height="800"></div>
              <?php endif; ?>
              <div class="ah-card__body">
                <h2 class="ah-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <p class="ah-card__textures"><?php the_excerpt(); ?></p>
                <a href="<?php the_permalink(); ?>" class="ah-btn ah-btn--outline ah-btn--sm">Read More <?php echo ah_svg('arrow-right'); ?></a>
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
