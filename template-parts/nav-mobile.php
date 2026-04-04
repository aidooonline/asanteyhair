<style>
/* ── MOBILE NAV ─────────────────────────────────────────────── */
.ah-nav-mobile {
  position: fixed;
  inset: 0;
  background: var(--ah-black);
  z-index: 800;
  display: flex;
  flex-direction: column;
  padding: calc(var(--ah-header-height) + var(--ah-space-8)) var(--ah-space-8) var(--ah-space-12);
  opacity: 0;
  pointer-events: none;
  transform: translateX(100%);
  transition: opacity var(--ah-transition), transform var(--ah-transition);
  overflow-y: auto;
}
.ah-nav-mobile--open {
  opacity: 1;
  pointer-events: all;
  transform: translateX(0);
}
.ah-nav-mobile__list {
  list-style: none;
  flex: 1;
}
.ah-nav-mobile__list li {
  border-bottom: 1px solid rgba(255,255,255,0.08);
}
.ah-nav-mobile__list a {
  display: block;
  padding: var(--ah-space-5) 0;
  font-family: var(--ah-font-display);
  font-size: var(--ah-text-3xl);
  font-weight: 400;
  color: var(--ah-pure-white);
  letter-spacing: -0.01em;
  transition: color var(--ah-transition-fast), padding-left var(--ah-transition-fast);
}
.ah-nav-mobile__list a:hover {
  color: var(--ah-gold);
  padding-left: var(--ah-space-3);
}
.ah-nav-mobile__sub {
  list-style: none;
  padding-left: var(--ah-space-5);
  padding-bottom: var(--ah-space-3);
}
.ah-nav-mobile__sub a {
  font-family: var(--ah-font-body);
  font-size: var(--ah-text-base);
  font-weight: 400;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  padding: var(--ah-space-2) 0;
  color: rgba(255,255,255,0.6);
}
.ah-nav-mobile__sub a:hover { color: var(--ah-gold); padding-left: 0; }
.ah-nav-mobile__footer {
  margin-top: var(--ah-space-10);
  border-top: 1px solid rgba(255,255,255,0.1);
  padding-top: var(--ah-space-8);
  display: flex;
  flex-direction: column;
  gap: var(--ah-space-4);
}
.ah-nav-mobile__cta {
  display: flex;
  gap: var(--ah-space-3);
  flex-wrap: wrap;
}
.ah-nav-mobile .ah-social-links {
  display: flex;
  gap: var(--ah-space-5);
}
.ah-nav-mobile .ah-social-links a {
  color: rgba(255,255,255,0.5);
  width: 24px;
  height: 24px;
  transition: color var(--ah-transition-fast);
}
.ah-nav-mobile .ah-social-links a:hover { color: var(--ah-gold); }
.ah-nav-mobile .ah-social-links svg { width: 100%; height: 100%; }
</style>

<nav class="ah-nav-mobile" id="ah-mobile-nav" aria-label="Mobile navigation" aria-hidden="true">
  <ul class="ah-nav-mobile__list">
    <li>
      <a href="<?php echo esc_url( home_url('/shop/') ); ?>">Shop</a>
      <ul class="ah-nav-mobile__sub">
        <li><a href="<?php echo esc_url( home_url('/raw-hair/') ); ?>">Raw Hair</a></li>
        <li><a href="<?php echo esc_url( home_url('/virgin-hair/') ); ?>">Virgin Hair</a></li>
        <li><a href="<?php echo esc_url( home_url('/closures-frontals/') ); ?>">Closures &amp; Frontals</a></li>
      </ul>
    </li>
    <li><a href="<?php echo esc_url( home_url('/gallery/') ); ?>">Gallery</a></li>
    <li><a href="<?php echo esc_url( home_url('/about/') ); ?>">About</a></li>
    <li><a href="<?php echo esc_url( home_url('/hair-care-guide/') ); ?>">Hair Care</a></li>
    <li><a href="<?php echo esc_url( home_url('/faq/') ); ?>">FAQ</a></li>
    <li><a href="<?php echo esc_url( home_url('/contact/') ); ?>">Contact</a></li>
  </ul>

  <div class="ah-nav-mobile__footer">
    <div class="ah-nav-mobile__cta">
      <a href="<?php echo esc_url( ah_whatsapp_url() ); ?>"
         class="ah-btn ah-btn--gold"
         target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Order on WhatsApp
      </a>
      <a href="<?php echo esc_url( home_url('/order/') ); ?>"
         class="ah-btn ah-btn--outline-white">Order Enquiry</a>
    </div>
    <?php ah_social_links(); ?>
  </div>
</nav>
