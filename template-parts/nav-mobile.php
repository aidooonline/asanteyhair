<nav class="mnav" id="mobile-nav" aria-label="Mobile navigation">
  <?php wp_nav_menu([
    'theme_location' => 'primary',
    'container'      => false,
    'menu_class'     => 'mnav__list',
    'fallback_cb'    => function() {
      echo '<ul class="mnav__list">';
      $links = [
        'Shop'              => '/shop/',
        'Salon Services'    => '/salon-services/',
        'Gallery'           => '/gallery/',
        'About'             => '/about/',
        'Hair Care'         => '/hair-care-guide/',
        'FAQ'               => '/faq/',
        'Contact'           => '/contact/',
      ];
      foreach($links as $label => $url)
        echo '<li><a href="'.esc_url(home_url($url)).'">'.esc_html($label).'</a></li>';
      echo '</ul>';
    },
  ]); ?>
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
