<?php
/**
 * Template Name: Shop — All Products
 * Asantey Hair & Beauty
 */
get_header();

echo ah_schema_breadcrumb([
  ['name' => 'Home', 'url' => home_url('/')],
  ['name' => 'Shop', 'url' => get_permalink()],
]);
?>

<section class="page-hero">
  <div class="page-hero__bg">
    <img src="<?php echo esc_url( AH_URI . '/assets/images/raw-straight.jpg' ); ?>"
         alt="" aria-hidden="true" loading="eager" width="1280" height="500">
  </div>
  <div class="page-hero__content">
    <span class="t-label">The Asantey Collection</span>
    <h1 class="t-h1">Premium Cambodian<br>Hair Extensions</h1>
    <p >
      Raw Hair &middot; Virgin Hair &middot; HD Lace Closures &middot; HD Lace Frontals
    </p>
  </div>
</section>

<?php ah_breadcrumb(); ?>

<section class="s s--white">
  <div class="wrap">

    <!-- Filter Bar -->
    <div class="filter-bar" role="group" aria-label="Filter products">
      <button class="filter-btn active" data-filter="all">All Products</button>
      <button class="filter-btn" data-filter="raw-hair">Raw Hair</button>
      <button class="filter-btn" data-filter="virgin-hair">Virgin Hair</button>
      <button class="filter-btn" data-filter="closures-frontals">Closures &amp; Frontals</button>
    </div>

    <!-- Product Grid -->
    <div class="grid-4">
      <?php
      $products = get_posts([
        'post_type'      => 'hair_product',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
      ]);

      if ( $products ) :
        foreach ( $products as $product ) {
          ah_product_card( $product );
        }
        wp_reset_postdata();
      else :
        // Fallback static cards if CPT not seeded yet
        $static = [
          ['Cambodian Raw Hair — Body Wave',   'raw-hair', '60', 'raw-body-wave.jpg',   'Unprocessed single-donor Cambodian raw hair. Body wave texture. Lengths 10"–30".'],
          ['Cambodian Raw Hair — Deep Wave',   'raw-hair', '60', 'raw-deep-wave.jpg',   'Deep, S-shaped wave pattern. Never chemically treated. Lengths 10"–30".'],
          ['Cambodian Raw Hair — Straight',    'raw-hair', '60', 'raw-straight.jpg',    'Ultra-sleek, naturally straight. Can be coloured and bleached. Lengths 10"–30".'],
          ['Cambodian Virgin Hair — Body Wave','virgin-hair','50','virgin-body-wave.png','Premium Cambodian virgin body wave. 3–5 year lifespan. Lengths 10"–30".'],
          ['HD Lace Closure — 4x4',           'closures-frontals','51','hd-lace-sizes.png','Invisible HD lace 4x4 closure. All textures, 12"–22".'],
          ['HD Lace Frontal — 13x4',          'closures-frontals','80','hd-lace-sizes.png','Full 13x4 HD lace frontal. Ear-to-ear coverage. 12"–22".'],
        ];
        foreach ( $static as $item ) :
          [$title, $cat, $price, $img, $desc] = $item;
          ?>
          <article class="product-card" data-category="<?php echo esc_attr($cat); ?>">
            <div class="product-card__img">
              <img src="<?php echo esc_url(AH_URI . '/assets/images/' . $img); ?>"
                   alt="<?php echo esc_attr($title); ?>" loading="lazy" width="600" height="800">
              <span class="product-card__badge"><?php echo esc_html(ucwords(str_replace('-', ' ', $cat))); ?></span>
            </div>
            <div class="product-card__body">
              <span class="product-card__cat"><?php echo esc_html(ucwords(str_replace('-', ' ', $cat))); ?></span>
              <h3 class="product-card__title"><?php echo esc_html($title); ?></h3>
              <p class="product-card__desc"><?php echo esc_html($desc); ?></p>
              <p class="product-card__price">from &pound;<?php echo esc_html($price); ?> <span>per bundle</span></p>
              <div class="product-card__actions">
                <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I\'m interested in: ' . $title)); ?>"
                   class="btn btn--bk btn--sm" target="_blank" rel="noopener noreferrer">
                  <?php echo ah_svg('whatsapp'); ?> Order Now
                </a>
              </div>
            </div>
          </article>
        <?php
        endforeach;
      endif;
      ?>
    </div>

  </div>
</section>

<!-- Quality Callout -->
<div class="s s--off">
  <div class="wrap reveal" style="text-align:center;max-width:800px;">
    <span class="t-label">The Asantey Guarantee</span>
    <h2 class="t-h3" style="margin:1rem 0;">
      100% Human. 100% Cuticle-Aligned. Zero Compromise.
    </h2>
    <p class="t-body--lg">
      Every bundle in our collection is 100% human hair — no synthetic blends, no fillers.
      Sourced directly from single Cambodian donors, cuticle-aligned from root to tip.
      The science behind minimal shedding, maximum lifespan, and hair that looks
      just as good in year three as it did on day one.
    </p>
    <div class="btns" style="justify-content:center;margin-top:2rem;">
      <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I need help choosing the right hair for me.')); ?>"
         class="btn btn--bk" target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Need Help Choosing?
      </a>
      <a href="<?php echo esc_url(home_url('/faq/')); ?>" class="btn btn--ob">
        View FAQ
      </a>
    </div>
  </div>
</div>

<?php get_footer(); ?>
