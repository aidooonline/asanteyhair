<?php
/**
 * Asantey Hair & Beauty — page.php (default page template)
 */
get_header();
?>
<div class="header-offset"></div>
<?php while(have_posts()): the_post(); ?>
  <section class="page-hero">
    <div class="page-hero__content">
      <h1 class="t-h1"><?php the_title(); ?></h1>
    </div>
  </section>
  <?php ah_breadcrumb(); ?>
  <section class="section">
    <div class="wrap wrap--narrow prose">
      <?php the_content(); ?>
    </div>
  </section>
<?php endwhile; ?>
<?php get_footer(); ?>
