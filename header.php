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
<style>
/* ── HEADER COMPONENT ───────────────────────────────────────── */
.ah-header {
  position: fixed;
  top: 0; left: 0; right: 0;
  z-index: 900;
  height: var(--ah-header-height);
  background: rgba(250,250,250,0.97);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  border-bottom: 1px solid transparent;
  transition: border-color var(--ah-transition), box-shadow var(--ah-transition), transform var(--ah-transition);
}
.ah-header--scrolled {
  border-bottom-color: var(--ah-grey-200);
  box-shadow: 0 2px 20px rgba(0,0,0,0.06);
}
.ah-header--hidden {
  transform: translateY(-100%);
}
.ah-header__inner {
  max-width: var(--ah-container);
  margin: 0 auto;
  padding: 0 var(--ah-space-6);
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: var(--ah-space-8);
}
/* Logo */
.ah-header__logo {
  flex-shrink: 0;
  display: flex;
  align-items: center;
}
.ah-header__logo img {
  height: 48px;
  width: auto;
  object-fit: contain;
}
.ah-header__logo-text {
  font-family: var(--ah-font-display);
  font-size: var(--ah-text-xl);
  font-weight: 600;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: var(--ah-black);
  line-height: 1;
}
.ah-header__logo-text span {
  display: block;
  font-size: var(--ah-text-xs);
  font-family: var(--ah-font-body);
  font-weight: 400;
  letter-spacing: 0.15em;
  color: var(--ah-gold);
  margin-top: 2px;
}
/* Desktop nav */
.ah-header__nav {
  display: flex;
  align-items: center;
  gap: 0;
  list-style: none;
  flex: 1;
  justify-content: center;
}
.ah-header__nav > li > a {
  display: block;
  padding: var(--ah-space-3) var(--ah-space-4);
  font-size: var(--ah-text-xs);
  font-weight: 500;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--ah-black);
  position: relative;
  transition: color var(--ah-transition-fast);
}
.ah-header__nav > li > a::after {
  content: '';
  position: absolute;
  bottom: 0; left: var(--ah-space-4); right: var(--ah-space-4);
  height: 1px;
  background: var(--ah-gold);
  transform: scaleX(0);
  transition: transform var(--ah-transition-fast);
}
.ah-header__nav > li > a:hover,
.ah-header__nav > li.current_page_item > a,
.ah-header__nav > li.current-menu-item > a {
  color: var(--ah-gold);
}
.ah-header__nav > li > a:hover::after,
.ah-header__nav > li.current-menu-item > a::after { transform: scaleX(1); }
/* Dropdown */
.ah-header__nav .sub-menu {
  position: absolute;
  top: 100%; left: 0;
  background: var(--ah-pure-white);
  min-width: 200px;
  box-shadow: var(--ah-shadow-md);
  border-top: 2px solid var(--ah-gold);
  display: none;
  padding: var(--ah-space-2) 0;
  list-style: none;
}
.ah-header__nav .menu-item-has-children { position: relative; }
.ah-header__nav .sub-menu a {
  display: block;
  padding: var(--ah-space-3) var(--ah-space-5);
  font-size: var(--ah-text-xs);
  font-weight: 400;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: var(--ah-grey-700);
  transition: color var(--ah-transition-fast), background var(--ah-transition-fast);
}
.ah-header__nav .sub-menu a:hover {
  color: var(--ah-gold);
  background: var(--ah-cream-light);
}
/* Actions (right) */
.ah-header__actions {
  display: flex;
  align-items: center;
  gap: var(--ah-space-4);
  flex-shrink: 0;
}
/* Hamburger */
.ah-header__hamburger {
  display: none;
  flex-direction: column;
  gap: 5px;
  background: none;
  border: none;
  cursor: pointer;
  padding: var(--ah-space-2);
  width: 40px;
}
.ah-header__hamburger span {
  display: block;
  height: 1.5px;
  background: var(--ah-black);
  transition: transform var(--ah-transition), opacity var(--ah-transition);
  transform-origin: center;
}
.ah-header__hamburger--open span:nth-child(1) { transform: translateY(6.5px) rotate(45deg); }
.ah-header__hamburger--open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.ah-header__hamburger--open span:nth-child(3) { transform: translateY(-6.5px) rotate(-45deg); }

@media (max-width: 1024px) {
  .ah-header__nav { display: none; }
  .ah-header__hamburger { display: flex; }
  .ah-header__actions .ah-btn { padding: 0.625rem 1rem; font-size: 0.65rem; }
}
@media (max-width: 480px) {
  .ah-header__actions .ah-btn span { display: none; }
}
</style>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="ah-visually-hidden" href="#main-content">Skip to main content</a>

<header class="ah-header" role="banner" aria-label="Site header">
  <div class="ah-header__inner">

    <!-- Logo -->
    <a class="ah-header__logo" href="<?php echo esc_url( home_url('/') ); ?>" aria-label="Asantey Hair & Beauty — Home">
      <?php
      $logo_src = AH_URI . '/assets/images/logo.jpg';
      if ( has_custom_logo() ) {
        $logo_id  = get_theme_mod('custom_logo');
        $logo_src = wp_get_attachment_image_url( $logo_id, 'full' );
        echo '<img src="' . esc_url( $logo_src ) . '" alt="Asantey Hair &amp; Beauty" width="160" height="48">';
      } else {
        ?>
        <span class="ah-header__logo-text">
          Asantey
          <span>Hair &amp; Beauty</span>
        </span>
        <?php
      }
      ?>
    </a>

    <!-- Desktop Navigation -->
    <nav aria-label="Primary navigation">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'ah-header__nav',
        'fallback_cb'    => function() {
          echo '<ul class="ah-header__nav">';
          $nav_items = [
            'Shop'               => '/shop/',
            'Raw Hair'           => '/raw-hair/',
            'Virgin Hair'        => '/virgin-hair/',
            'Closures & Frontals'=> '/closures-frontals/',
            'Salon Services'     => '/salon-services/',
            'Gallery'            => '/gallery/',
            'FAQ'                => '/faq/',
            'Contact'            => '/contact/',
          ];
          foreach ( $nav_items as $label => $url ) {
            echo '<li><a href="' . esc_url( home_url( $url ) ) . '">' . esc_html( $label ) . '</a></li>';
          }
          echo '</ul>';
        },
      ]);
      ?>
    </nav>

    <!-- Right Actions -->
    <div class="ah-header__actions">
      <a href="https://asanteyhair.as.me/"
         class="ah-btn ah-btn--outline ah-btn--sm"
         target="_blank" rel="noopener noreferrer"
         aria-label="Book a salon appointment">
        Book Appointment
      </a>
      <a href="<?php echo esc_url( ah_whatsapp_url( 'Hello! I\'d like to place an order with Asantey Hair & Beauty.' ) ); ?>"
         class="ah-btn ah-btn--gold ah-btn--sm"
         target="_blank" rel="noopener noreferrer"
         aria-label="Order now via WhatsApp">
        <?php echo ah_svg('whatsapp'); ?>
        <span>Order Now</span>
      </a>

      <!-- Mobile hamburger -->
      <button class="ah-header__hamburger"
              aria-expanded="false"
              aria-controls="ah-mobile-nav"
              aria-label="Toggle navigation menu">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>

  </div><!-- /.ah-header__inner -->
</header>

<?php get_template_part('template-parts/nav-mobile'); ?>

<!-- Floating WhatsApp Button -->
<a href="<?php echo esc_url( ah_whatsapp_url() ); ?>"
   class="ah-wa-float"
   target="_blank" rel="noopener noreferrer"
   aria-label="Chat with us on WhatsApp">
  <?php echo ah_svg('whatsapp', 'ah-wa-float__icon'); ?>
  <span class="ah-wa-float__text">WhatsApp Us</span>
</a>

<main id="main-content" role="main">
