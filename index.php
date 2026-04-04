<?php get_header(); ?>
<div class="ah-header-offset"></div>
<section class="ah-section">
  <div class="ah-container">
    <?php if(have_posts()): while(have_posts()): the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h2><?php the_title(); ?></h2>
        <?php the_content(); ?>
      </article>
    <?php endwhile; endif; ?>
  </div>
</section>
<?php get_footer(); ?>
