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
  background: rgba(255,255,255,0.98);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  border-bottom: 1px solid transparent;
  transition: border-color var(--ah-transition), box-shadow var(--ah-transition), transform var(--ah-transition);
}
.ah-header--scrolled {
  border-bottom-color: #e8e8e8;
  box-shadow: 0 1px 30px rgba(0,0,0,0.07);
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
  gap: var(--ah-space-6);
}
/* Logo */
.ah-header__logo {
  flex-shrink: 0;
  display: flex;
  align-items: center;
}
.ah-header__logo img {
  height: 44px;
  width: auto;
  object-fit: contain;
}
.ah-header__logo-text {
  font-family: var(--ah-font-display);
  font-size: var(--ah-text-xl);
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--ah-black);
  line-height: 1;
}
.ah-header__logo-text span {
  display: block;
  font-size: 0.6rem;
  font-family: var(--ah-font-body);
  font-weight: 400;
  letter-spacing: 0.2em;
  color: var(--ah-gold);
  margin-top: 3px;
  text-transform: uppercase;
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
  padding: var(--ah-space-3) var(--ah-space-3);
  font-size: 0.68rem;
  font-weight: 500;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: var(--ah-black);
  position: relative;
  transition: color var(--ah-transition-fast);
}
.ah-header__nav > li > a::after {
  content: '';
  position: absolute;
  bottom: 2px; left: var(--ah-space-3); right: var(--ah-space-3);
  height: 1px;
  background: var(--ah-gold);
  transform: scaleX(0);
  transform-origin: left;
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
  background: var(--ah-white);
  min-width: 200px;
  box-shadow: 0 8px 40px rgba(0,0,0,0.12);
  border-top: 2px solid var(--ah-gold);
  display: none;
  padding: var(--ah-space-2) 0;
  list-style: none;
}
.ah-header__nav .menu-item-has-children { position: relative; }
.ah-header__nav .sub-menu a {
  display: block;
  padding: var(--ah-space-3) var(--ah-space-5);
  font-size: 0.68rem;
  font-weight: 400;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--ah-grey-700);
  transition: color var(--ah-transition-fast), padding-left var(--ah-transition-fast);
}
.ah-header__nav .sub-menu a:hover {
  color: var(--ah-gold);
  padding-left: calc(var(--ah-space-5) + 4px);
}
/* Actions (right) */
.ah-header__actions {
  display: flex;
  align-items: center;
  gap: var(--ah-space-3);
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
  width: 36px;
}
.ah-header__hamburger span {
  display: block;
  height: 1px;
  background: var(--ah-black);
  transition: transform var(--ah-transition), opacity var(--ah-transition);
  transform-origin: center;
}
.ah-header__hamburger--open span:nth-child(1) { transform: translateY(6px) rotate(45deg); }
.ah-header__hamburger--open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.ah-header__hamburger--open span:nth-child(3) { transform: translateY(-6px) rotate(-45deg); }

@media (max-width: 1024px) {
  .ah-header__nav { display: none; }
  .ah-header__hamburger { display: flex; }
}
@media (max-width: 640px) {
  .ah-header__actions .ah-btn--outline { display: none; }
}
</style>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="sr-only" href="#main-content">Skip to main content</a>

<header class="site-header" role="banner" aria-label="Site header">
  <div class="site-header__inner">

    <!-- Logo -->
    <a class="site-logo" href="<?php echo esc_url( home_url('/') ); ?>" aria-label="Asantey Hair & Beauty — Home">
      <?php
      $logo_src = AH_URI . '/assets/images/logo.jpg';
      if ( has_custom_logo() ) {
        $logo_id  = get_theme_mod('custom_logo');
        $logo_src = wp_get_attachment_image_url( $logo_id, 'full' );
        echo '<img src="' . esc_url( $logo_src ) . '" alt="Asantey Hair &amp; Beauty" width="160" height="48">';
      } else {
        ?>
        <span class="site-logo__name">
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
          echo '<ul class="site-nav">';
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
    <div class="site-header__actions">
      <a href="https://asanteyhair.as.me/"
         class="btn btn--outline btn--sm"
         target="_blank" rel="noopener noreferrer"
         aria-label="Book a salon appointment">
        Book Appointment
      </a>
      <a href="<?php echo esc_url( ah_whatsapp_url( 'Hello! I\'d like to place an order with Asantey Hair & Beauty.' ) ); ?>"
         class="btn btn--black btn--sm"
         target="_blank" rel="noopener noreferrer"
         aria-label="Order now via WhatsApp">
        <?php echo ah_svg('whatsapp'); ?>
        <span>Order Now</span>
      </a>

      <!-- Mobile hamburger -->
      <button class="hamburger"
              aria-expanded="false"
              aria-controls="mobile-nav"
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
   class="wa-float"
   target="_blank" rel="noopener noreferrer"
   aria-label="Chat with us on WhatsApp">
  <?php echo ah_svg('whatsapp', 'ah-wa-float__icon'); ?>
  <span class="wa-float__txt">WhatsApp Us</span>
</a>

<main id="main-content" role="main">
