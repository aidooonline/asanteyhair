<?php
/**
 * Asantey Hair & Beauty — footer.php
 */
?>
</main><!-- /#main-content -->

<style>
/* ── FOOTER ─────────────────────────────────────────────────── */
.ah-footer {
  background: var(--ah-black);
  color: rgba(255,255,255,0.75);
  font-size: var(--ah-text-sm);
}
.ah-footer__top {
  padding: var(--ah-space-20) var(--ah-space-6) var(--ah-space-16);
  max-width: var(--ah-container);
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1.4fr 1fr 1fr 1.2fr;
  gap: var(--ah-space-12);
}
/* Brand column */
.ah-footer__brand .ah-header__logo-text {
  color: var(--ah-pure-white);
}
.ah-footer__brand .ah-header__logo-text span {
  color: var(--ah-gold);
}
.ah-footer__tagline {
  color: rgba(255,255,255,0.55);
  line-height: 1.7;
  margin-top: var(--ah-space-5);
  margin-bottom: var(--ah-space-6);
  font-size: var(--ah-text-sm);
  max-width: 260px;
}
.ah-footer .ah-social-links {
  display: flex;
  gap: var(--ah-space-4);
}
.ah-footer .ah-social-links a {
  color: rgba(255,255,255,0.4);
  width: 20px;
  height: 20px;
  flex-shrink: 0;
  transition: color var(--ah-transition-fast);
}
.ah-footer .ah-social-links a:hover { color: var(--ah-gold); }
.ah-footer .ah-social-links svg { width: 100%; height: 100%; }
/* Nav columns */
.ah-footer__nav-title {
  font-family: var(--ah-font-body);
  font-size: var(--ah-text-xs);
  font-weight: 600;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: var(--ah-pure-white);
  margin-bottom: var(--ah-space-5);
  display: block;
}
.ah-footer__nav-list { list-style: none; display: flex; flex-direction: column; gap: var(--ah-space-3); }
.ah-footer__nav-list a {
  color: rgba(255,255,255,0.55);
  font-size: var(--ah-text-sm);
  transition: color var(--ah-transition-fast);
}
.ah-footer__nav-list a:hover { color: var(--ah-gold); }
/* Contact column */
.ah-footer__contact-item {
  display: flex;
  align-items: flex-start;
  gap: var(--ah-space-3);
  margin-bottom: var(--ah-space-4);
}
.ah-footer__contact-item svg {
  width: 16px;
  height: 16px;
  flex-shrink: 0;
  margin-top: 2px;
  color: var(--ah-gold);
}
.ah-footer__contact-item span {
  color: rgba(255,255,255,0.55);
  font-size: var(--ah-text-sm);
  line-height: 1.5;
}
.ah-footer__contact-item a { color: rgba(255,255,255,0.55); }
.ah-footer__contact-item a:hover { color: var(--ah-gold); }
/* Newsletter strip */
.ah-footer__newsletter {
  background: rgba(255,255,255,0.04);
  border-top: 1px solid rgba(255,255,255,0.08);
  border-bottom: 1px solid rgba(255,255,255,0.08);
  padding: var(--ah-space-12) var(--ah-space-6);
}
.ah-footer__newsletter-inner {
  max-width: var(--ah-container);
  margin: 0 auto;
  display: flex;
  align-items: center;
  gap: var(--ah-space-12);
  flex-wrap: wrap;
}
.ah-footer__newsletter-copy {
  flex: 1;
  min-width: 260px;
}
.ah-footer__newsletter-copy strong {
  display: block;
  font-family: var(--ah-font-display);
  font-size: var(--ah-text-2xl);
  font-weight: 400;
  color: var(--ah-pure-white);
  margin-bottom: var(--ah-space-2);
}
.ah-footer__newsletter-copy p {
  font-size: var(--ah-text-sm);
  color: rgba(255,255,255,0.5);
  margin: 0;
}
.ah-footer__newsletter-form { flex: 1; min-width: 300px; }
.ah-footer__newsletter-form .ah-form-control {
  background: rgba(255,255,255,0.08);
  border-color: rgba(255,255,255,0.15);
  color: var(--ah-pure-white);
}
.ah-footer__newsletter-form .ah-form-control::placeholder { color: rgba(255,255,255,0.35); }
.ah-footer__newsletter-form .ah-form-control:focus {
  border-color: var(--ah-gold);
  background: rgba(255,255,255,0.12);
}
/* Bottom bar */
.ah-footer__bottom {
  padding: var(--ah-space-6) var(--ah-space-6);
  max-width: var(--ah-container);
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: var(--ah-space-4);
}
.ah-footer__copyright {
  color: rgba(255,255,255,0.35);
  font-size: var(--ah-text-xs);
}
.ah-footer__legal-links {
  display: flex;
  gap: var(--ah-space-5);
  list-style: none;
}
.ah-footer__legal-links a {
  color: rgba(255,255,255,0.35);
  font-size: var(--ah-text-xs);
  transition: color var(--ah-transition-fast);
}
.ah-footer__legal-links a:hover { color: var(--ah-gold); }

/* Responsive */
@media (max-width: 1024px) {
  .ah-footer__top { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 640px) {
  .ah-footer__top { grid-template-columns: 1fr; gap: var(--ah-space-10); }
  .ah-footer__bottom { flex-direction: column; align-items: flex-start; }
}
</style>

<footer class="site-footer" role="contentinfo" aria-label="Site footer">

  <!-- Newsletter Strip -->
  <div class="site-footer__newsletter">
    <div class="wrap">
      <div class="footer-news-copy">
        <strong>Join the Asantey Community</strong>
        <p>New arrivals, exclusive offers, and hair care tips — delivered to your inbox.</p>
      </div>
      <div class="footer-news-form">
        <?php ah_newsletter_form(); ?>
      </div>
    </div>
  </div>

  <!-- Main Footer -->
  <div class="site-footer__top">

    <!-- Brand Column -->
    <div class="site-footer__brand">
      <a href="<?php echo esc_url( home_url('/') ); ?>" class="ah-header__logo" aria-label="Asantey Hair & Beauty — Home">
        <span class="ah-header__logo-text">
          Asantey
          <span>Hair &amp; Beauty</span>
        </span>
      </a>
      <p class="footer-tagline">
        <?php echo esc_html( get_theme_mod('ah_footer_tagline', 'Premium Hair. Unmatched Quality. Timeless Beauty.') ); ?>
      </p>
      <?php ah_social_links(); ?>
    </div>

    <!-- Quick Links -->
    <div>
      <span class="t-label">Explore</span>
      <ul class="footer-links">
        <?php
        $nav_links = [
          'Shop All'            => '/shop/',
          'About Us'            => '/about/',
          'Client Gallery'      => '/gallery/',
          'Hair Care Guide'     => '/hair-care-guide/',
          'FAQ'                 => '/faq/',
          'Order Enquiry'       => '/order/',
          'Contact'             => '/contact/',
        ];
        foreach ( $nav_links as $label => $url ) :
          echo '<li><a href="' . esc_url( home_url($url) ) . '">' . esc_html($label) . '</a></li>';
        endforeach;
        ?>
      </ul>
    </div>

    <!-- Products -->
    <div>
      <span class="t-label">Products</span>
      <ul class="footer-links">
        <?php
        $product_links = [
          'Cambodian Raw Hair'      => '/raw-hair/',
          'Virgin Hair Bundles'     => '/virgin-hair/',
          'HD Lace Closures'        => '/closures-frontals/',
          'HD Lace Frontals'        => '/closures-frontals/',
          'Shipping & Returns'      => '/shipping-returns/',
          'Privacy Policy'          => '/privacy-policy/',
          'Terms & Conditions'      => '/terms-conditions/',
        ];
        foreach ( $product_links as $label => $url ) :
          echo '<li><a href="' . esc_url( home_url($url) ) . '">' . esc_html($label) . '</a></li>';
        endforeach;
        ?>
      </ul>
    </div>

    <!-- Contact -->
    <div>
      <span class="t-label">Contact Us</span>

      <?php if ( get_theme_mod('ah_contact_phone') ) : ?>
        <div class="contact-item">
          <?php echo ah_svg('phone'); ?>
          <span><a href="tel:<?php echo esc_attr( preg_replace('/[^0-9+]/', '', get_theme_mod('ah_contact_phone')) ); ?>"><?php echo esc_html( get_theme_mod('ah_contact_phone') ); ?></a></span>
        </div>
      <?php endif; ?>

      <?php if ( get_theme_mod('ah_contact_email') ) : ?>
        <div class="contact-item">
          <?php echo ah_svg('mail'); ?>
          <span><a href="mailto:<?php echo esc_attr( get_theme_mod('ah_contact_email') ); ?>"><?php echo esc_html( get_theme_mod('ah_contact_email') ); ?></a></span>
        </div>
      <?php endif; ?>

      <?php if ( get_theme_mod('ah_contact_address') ) : ?>
        <div class="contact-item">
          <?php echo ah_svg('location'); ?>
          <span><?php echo nl2br( esc_html( get_theme_mod('ah_contact_address') ) ); ?></span>
        </div>
      <?php endif; ?>

      <?php if ( get_theme_mod('ah_contact_hours') ) : ?>
        <div class="contact-item">
          <?php echo ah_svg('clock'); ?>
          <span><?php echo esc_html( get_theme_mod('ah_contact_hours') ); ?></span>
        </div>
      <?php endif; ?>

      <a href="<?php echo esc_url( ah_whatsapp_url() ); ?>"
         class="btn btn--wa btn--sm"
         target="_blank" rel="noopener noreferrer"
         style="margin-top:var(--ah-space-5);">
        <?php echo ah_svg('whatsapp'); ?> WhatsApp Order
      </a>
    </div>

  </div><!-- /.ah-footer__top -->

  <!-- Bottom Bar -->
  <div class="site-footer__bottom">
    <span class="footer-copy">
      <?php echo esc_html( get_theme_mod('ah_footer_copyright', '&copy; ' . date('Y') . ' Asantey Hair & Beauty. All Rights Reserved.') ); ?>
    </span>
    <ul class="footer-legal">
      <li><a href="<?php echo esc_url( home_url('/privacy-policy/') ); ?>">Privacy Policy</a></li>
      <li><a href="<?php echo esc_url( home_url('/terms-conditions/') ); ?>">Terms &amp; Conditions</a></li>
      <li><a href="<?php echo esc_url( home_url('/shipping-returns/') ); ?>">Shipping &amp; Returns</a></li>
    </ul>
  </div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
