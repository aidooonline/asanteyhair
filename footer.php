<?php
/**
 * Asantey Hair & Beauty — footer.php
 */
?>
</main>

<footer class="foot" role="contentinfo">

  <!-- Newsletter -->
  <div class="foot__news">
    <div class="wrap">
      <div class="foot__news-copy">
        <strong>Join the Community</strong>
        <p>New arrivals, exclusive offers &amp; hair care tips.</p>
      </div>
      <div class="foot__news-form">
        <?php ah_newsletter_form(); ?>
      </div>
    </div>
  </div>

  <!-- Main columns -->
  <div class="foot__main">

    <div>
      <a href="<?php echo esc_url(home_url('/')); ?>" style="text-decoration:none;">
        <span class="foot__logo-name">Asantey</span>
        <span class="foot__logo-sub">Hair &amp; Beauty</span>
      </a>
      <p class="foot__tagline">
        <?php echo esc_html(get_theme_mod('ah_footer_tagline','Premium Hair. Unmatched Quality. Timeless Beauty.')); ?>
      </p>
      <div class="social-links">
        <?php
        $socials = ['instagram','facebook','tiktok','youtube'];
        foreach($socials as $s):
          $url = get_theme_mod('ah_social_'.$s,'');
          if(!$url) continue; ?>
          <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr(ucfirst($s)); ?>">
            <?php echo ah_svg($s); ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <div>
      <span class="t-label">Explore</span>
      <ul class="foot-links" style="margin-top:.25rem;">
        <?php
        $links = ['Shop All'=>'/shop/','About Us'=>'/about/','Gallery'=>'/gallery/',
                  'Hair Care Guide'=>'/hair-care-guide/','FAQ'=>'/faq/',
                  'Order Enquiry'=>'/order/','Contact'=>'/contact/'];
        foreach($links as $l=>$u):
          echo '<li><a href="'.esc_url(home_url($u)).'">'.esc_html($l).'</a></li>';
        endforeach; ?>
      </ul>
    </div>

    <div>
      <span class="t-label">Products</span>
      <ul class="foot-links" style="margin-top:.25rem;">
        <?php
        $pl = ['Cambodian Raw Hair'=>'/raw-hair/','Virgin Hair Bundles'=>'/virgin-hair/',
               'HD Lace Closures'=>'/closures-frontals/','HD Lace Frontals'=>'/closures-frontals/',
               'Salon Services'=>'/salon-services/','Shipping &amp; Returns'=>'/shipping-returns/'];
        foreach($pl as $l=>$u):
          echo '<li><a href="'.esc_url(home_url($u)).'">'.$l.'</a></li>';
        endforeach; ?>
      </ul>
    </div>

    <div class="foot__contact">
      <span class="t-label">Visit &amp; Contact</span>
      <div class="contact-list" style="margin-top:1.25rem;">
        <?php
        $phone   = get_theme_mod('ah_contact_phone','07827 129797');
        $email   = get_theme_mod('ah_contact_email','');
        $wa_num  = get_theme_mod('ah_whatsapp_number','447827129797');
        $address = get_theme_mod('ah_contact_address','358 Radford Road, Nottingham NG7 5GQ');
        $hours   = get_theme_mod('ah_contact_hours','Mon–Sat: 9am–7pm');
        if($phone): ?>
          <div class="contact-item">
            <div class="contact-item__icon"><?php echo ah_svg('phone'); ?></div>
            <div>
              <span class="contact-item__label">Phone</span>
              <span class="contact-item__val"><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/','', $phone)); ?>"><?php echo esc_html($phone); ?></a></span>
            </div>
          </div>
        <?php endif;
        if($address): ?>
          <div class="contact-item">
            <div class="contact-item__icon"><?php echo ah_svg('location'); ?></div>
            <div>
              <span class="contact-item__label">Salon</span>
              <span class="contact-item__val"><?php echo nl2br(esc_html($address)); ?></span>
            </div>
          </div>
        <?php endif; ?>
        <div class="contact-item">
          <div class="contact-item__icon"><?php echo ah_svg('clock'); ?></div>
          <div>
            <span class="contact-item__label">Hours</span>
            <span class="contact-item__val"><?php echo esc_html($hours); ?></span>
          </div>
        </div>
        <a href="https://asanteyhair.as.me/"
           class="btn btn--ow btn--sm" target="_blank" rel="noopener noreferrer"
           style="margin-top:.75rem;">
          Book Appointment <?php echo ah_svg('arrow-right'); ?>
        </a>
      </div>
    </div>

  </div>

  <!-- Bottom bar -->
  <div class="foot__bar">
    <span class="foot__copy">
      <?php echo esc_html(get_theme_mod('ah_footer_copyright','&copy; '.date('Y').' Asantey Hair & Beauty. All Rights Reserved.')); ?>
    </span>
    <ul class="foot__legal">
      <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a></li>
      <li><a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>">Terms</a></li>
      <li><a href="<?php echo esc_url(home_url('/shipping-returns/')); ?>">Shipping</a></li>
    </ul>
  </div>

</footer>
<?php wp_footer(); ?>
</body>
</html>
