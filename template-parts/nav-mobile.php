<nav class="mnav" id="mobile-nav" aria-label="Mobile navigation">
  <ul class="mnav__list">
    <li>
      <a href="<?php echo esc_url(home_url('/shop/')); ?>">Shop</a>
      <ul class="mnav__sub">
        <li><a href="<?php echo esc_url(home_url('/raw-hair/')); ?>">Raw Hair</a></li>
        <li><a href="<?php echo esc_url(home_url('/virgin-hair/')); ?>">Virgin Hair</a></li>
        <li><a href="<?php echo esc_url(home_url('/closures-frontals/')); ?>">HD Lace Closures &amp; Frontals</a></li>
      </ul>
    </li>
    <li><a href="<?php echo esc_url(home_url('/salon-services/')); ?>">Salon Services</a></li>
    <li><a href="<?php echo esc_url(home_url('/gallery/')); ?>">Gallery</a></li>
    <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About</a></li>
    <li><a href="<?php echo esc_url(home_url('/hair-care-guide/')); ?>">Hair Care</a></li>
    <li><a href="<?php echo esc_url(home_url('/faq/')); ?>">FAQ</a></li>
    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li>
  </ul>
  <div class="mnav__foot">
    <div class="mnav__btns">
      <a href="<?php echo esc_url( get_theme_mod( 'ah_booking_url', 'https://asanteyhair.as.me/' ) ); ?>"
         class="btn btn--ow btn--sm" target="_blank" rel="noopener noreferrer">
        Book Appointment
      </a>
      <a href="<?php echo esc_url(ah_whatsapp_url()); ?>"
         class="btn btn--wa btn--sm" target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Order Hair
      </a>
    </div>
    <div class="mnav__social">
      <?php
      $s = [
        'instagram'=>get_theme_mod('ah_social_instagram',''),
        'facebook' =>get_theme_mod('ah_social_facebook',''),
        'tiktok'   =>get_theme_mod('ah_social_tiktok',''),
        'youtube'  =>get_theme_mod('ah_social_youtube',''),
      ];
      foreach($s as $k=>$u):
        if(!$u) continue; ?>
        <a href="<?php echo esc_url($u); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr(ucfirst($k)); ?>">
          <?php echo ah_svg($k); ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</nav>
