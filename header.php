<?php
/**
 * Asantey Hair & Beauty — header.php
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="sr-only" href="#main">Skip to main content</a>

<header class="hdr" id="site-header" role="banner">
  <div class="hdr__inner">

    <!-- 1. Logo — always first -->
    <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Asantey Hair &amp; Beauty — Home">
      <?php if(has_custom_logo()):
        $logo_id = get_theme_mod('custom_logo');
        echo '<img src="'.esc_url(wp_get_attachment_image_url($logo_id,'full')).'" alt="Asantey Hair &amp; Beauty" width="160" height="40">';
      else: ?>
        <span class="site-logo__name">Asantey</span>
        <span class="site-logo__sub">Hair &amp; Beauty</span>
      <?php endif; ?>
    </a>

    <!-- 2. Navigation -->
    <nav aria-label="Primary">
      <?php wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'site-nav',
        'fallback_cb'    => function() {
          echo '<ul class="site-nav">';
          $links = [
            'Shop'         => '/shop/',
            'Raw Hair'     => '/raw-hair/',
            'Virgin Hair'  => '/virgin-hair/',
            'HD Lace'      => '/closures-frontals/',
            'Salon'        => '/salon-services/',
            'Gallery'      => '/gallery/',
            'FAQ'          => '/faq/',
            'Contact'      => '/contact/',
          ];
          foreach($links as $label => $url)
            echo '<li><a href="'.esc_url(home_url($url)).'">'.$label.'</a></li>';
          echo '</ul>';
        },
      ]); ?>
    </nav>

    <!-- 3. Actions — right side -->
    <div class="hdr__actions">
      <?php if ( class_exists( 'WooCommerce' ) ) : ?>
      <button class="ah-cart-icon" id="ah-cart-icon" aria-label="Open cart">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
          <line x1="3" y1="6" x2="21" y2="6"/>
          <path d="M16 10a4 4 0 01-8 0"/>
        </svg>
        <span class="ah-cart-count<?php echo WC()->cart && WC()->cart->get_cart_contents_count() ? ' has-items' : ''; ?>">
          <?php echo class_exists('WooCommerce') && WC()->cart ? WC()->cart->get_cart_contents_count() : '0'; ?>
        </span>
      </button>
      <?php endif; ?>
      <a href="<?php echo esc_url(ah_whatsapp_url( 'Hello! I would like to order with Asantey Hair and Beauty.' )); ?>"
         class="hdr-order-btn"
         target="_blank" rel="noopener noreferrer">
        Order Now
      </a>
      <button class="hamburger" id="hamburger"
              aria-expanded="false" aria-controls="mobile-nav"
              aria-label="Toggle menu">
        <span></span><span></span><span></span>
      </button>
    </div>

  </div>
</header>

<?php get_template_part('template-parts/nav-mobile'); ?>

<!-- Floating WhatsApp -->
<a href="<?php echo esc_url(ah_whatsapp_url()); ?>"
   class="wa-float" target="_blank" rel="noopener noreferrer"
   aria-label="WhatsApp us">
  <?php echo ah_svg('whatsapp','wa-float__icon'); ?>
  <span>WhatsApp Us</span>
</a>

<main id="main" role="main">
