<?php
/**
 * Asantey Hair & Beauty — page.php (default page template)
 */
get_header();
?>
<div class="ah-header-offset"></div>
<?php while(have_posts()): the_post(); ?>
  <section class="ah-page-hero">
    <div class="ah-page-hero__content">
      <h1 class="ah-page-hero__title"><?php the_title(); ?></h1>
    </div>
  </section>
  <?php ah_breadcrumb(); ?>
  <section class="ah-section">
    <div class="ah-container ah-container--sm ah-prose">
      <?php the_content(); ?>
    </div>
  </section>
<?php endwhile; ?>
<?php get_footer(); ?>
