<?php
/**
 * WooCommerce Single Product Page
 * Asantey Hair & Beauty custom template
 */
defined( 'ABSPATH' ) || exit;
get_header(); ?>

<section class="s s--white wc-main">
    <div class="wrap wc-wrap">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php wc_get_template_part( 'content', 'single-product' ); ?>
        <?php endwhile; ?>
    </div>
</section>

<?php get_footer(); ?>
