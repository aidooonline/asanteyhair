<?php
/**
 * Template Name: Salon Services
 * Asantey Hair & Beauty — Nottingham Salon
 */
get_header();

echo ah_schema_breadcrumb([
  ['name' => 'Home',           'url' => home_url('/')],
  ['name' => 'Salon Services', 'url' => get_permalink()],
]);

$booking_url = get_theme_mod('ah_booking_url', 'https://asanteyhair.as.me/');
?>

<section class="page-hero">
  <div class="page-hero__bg">
    <?php ah_opt_img_tag( 'hero_image', '', '', '', 'eager' ); ?>
  </div>
  <div class="page-hero__content">
    <span class="t-label">Nottingham Salon</span>
    <h1 class="t-h1">Hair &amp; Beauty<br>Salon Services</h1>
    <p >
      Expert hair and beauty services in Nottingham. Book your appointment online in minutes.
    </p>
    <div class="btns" style="margin-top:2rem;">
      <a href="<?php echo esc_url($booking_url); ?>"
         class="btn btn--bk"
         target="_blank" rel="noopener noreferrer">
        Book Appointment <?php echo ah_svg('arrow-right'); ?>
      </a>
      <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I would like to book an appointment at AHB Salon.')); ?>"
         class="btn btn--outline-white"
         target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Book via WhatsApp
      </a>
    </div>
  </div>
</section>

<?php ah_breadcrumb(); ?>

<!-- Location strip -->
<div class="marquee-strip marquee-strip--dark">
  <div class="wrap" style="display:flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:2rem;">
    <?php
    $info = [
      ['location','358 Radford Road, Nottingham NG7 5GQ'],
      ['phone',   '07827 129797'],
      ['clock',   'Mon–Sat: 9am–7pm'],
      ['sparkle', 'Walk-ins Welcome'],
    ];
    foreach($info as $i => $item):
      echo '<span class="marquee-item">'.ah_svg($item[0]).esc_html($item[1]).'</span>';
      if($i < count($info)-1) echo '<span ></span>';
    endforeach;
    ?>
  </div>
</div>

<!-- Hair Services -->
<section class="s" id="hair-services" aria-labelledby="hair-heading">
  <div class="wrap">

    <div class="sh sh--c reveal">
      <span class="t-label">Hair Services</span>
      <h2 id="hair-heading" class="t-h2">Expert Hair Services</h2>
      <span class="rule rule--center"></span>
      <p class="t-body--lg">
        Delivered by skilled stylists who understand your hair — and how to make it look its absolute best.
      </p>
    </div>

    <div class="grid-3" style="gap:1.5rem;">
      <?php
      // Read hair services from repeater (WP Admin > Salon Services > Hair Service Cards)
      $rep_hair = ah_opt_repeater('hair_services');
      if (!empty($rep_hair)) {
          $hair_services = $rep_hair;
      } else {
          // Migrate old individual image meta keys so existing images still show
          $hair_keys = [
              ['key'=>'braids',        'title'=>'Braids',                  'price'=>'','desc'=>'From knotless box braids to jumbo braids — protective styles built to last.'],
              ['key'=>'cornrows',      'title'=>'Cornrows',                'price'=>'','desc'=>'Classic and intricate cornrow styles including straight backs and feed-in techniques.'],
              ['key'=>'hair-treatment','title'=>'Hair Treatments',         'price'=>'','desc'=>'Deep conditioning and scalp care to restore moisture and promote healthy growth.'],
              ['key'=>'sew-in',        'title'=>'Sew-In Installs',         'price'=>'','desc'=>'Professional sew-in installation for bundles and closures/frontals.'],
              ['key'=>'closure',       'title'=>'Closure & Frontal Install','price'=>'','desc'=>'Expert HD lace closure and frontal installation. Natural hairline, seamless blend.'],
              ['key'=>'natural-hair',  'title'=>'Natural Hair Care',        'price'=>'','desc'=>'Wash, condition, detangle, and style services for natural hair textures.'],
          ];
          $hair_services = array_map(function($s) {
              $img = ah_opt_img("svc_{$s['key']}_image");
              return [
                  'title'    => $s['title'],
                  'price'    => $s['price'],
                  'desc'     => $s['desc'],
                  'link'     => ah_opt("svc_{$s['key']}_link",''),
                  'image_id' => $img['id'] ?? 0,
                  '_img_url' => $img['url'] ?? '', // direct URL fallback
              ];
          }, $hair_keys);
      }
      foreach($hair_services as $i => $s):
          $svc_link  = $s['link'] ?? '';
          $svc_title = $s['title'] ?? '';
          $svc_desc  = $s['desc']  ?? '';
          $svc_price = $s['price'] ?? '';
          $svc_imgid = (int)($s['image_id'] ?? 0);
          $svc_img   = $svc_imgid ? wp_get_attachment_image_url($svc_imgid,'large') : ($s['_img_url'] ?? '');
      ?>
        <?php if ($svc_link): ?>
        <a href="<?php echo esc_url($svc_link); ?>" class="service-card service-card--linked reveal d<?php echo ($i%3)+1; ?>">
        <?php else: ?>
        <div class="service-card reveal d<?php echo ($i%3)+1; ?>">
        <?php endif; ?>
          <div class="service-card__img">
            <?php if ($svc_img): ?>
            <img src="<?php echo esc_url($svc_img); ?>" alt="<?php echo esc_attr($svc_title); ?>" loading="lazy">
            <?php endif; ?>
          </div>
          <div class="service-card__body">
            <h3 class="service-card__title"><?php echo esc_html($svc_title); ?></h3>
            <?php if ($svc_price): ?><p class="service-card__price"><?php echo esc_html($svc_price); ?></p><?php endif; ?>
            <p class="service-card__desc"><?php echo esc_html($svc_desc); ?></p>
            <?php if ($svc_link): ?>
            <span class="service-card__cta">Book Now <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
            <?php endif; ?>
          </div>
        <?php echo $svc_link ? '</a>' : '</div>'; ?>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- Beauty Services -->
<section class="s s--off" id="beauty-services" aria-labelledby="beauty-heading">
  <div class="wrap">

    <div class="sh sh--c reveal">
      <span class="t-label">Beauty Services</span>
      <h2 id="beauty-heading" class="t-h2">Complete Beauty Services</h2>
      <span class="rule rule--center"></span>
      <p class="t-body--lg">
        Finish your look from lash to brow. Our beauty services are designed to complement
        your hair for a complete, polished result.
      </p>
    </div>

    <div class="grid-3" style="gap:1.5rem;">
      <?php
      // Read beauty services from repeater (WP Admin > Salon Services > Beauty Service Cards)
      $rep_beauty = ah_opt_repeater('beauty_services');
      if (!empty($rep_beauty)) {
          $beauty_services = $rep_beauty;
      } else {
          $beauty_keys = [
              ['key'=>'lash-extensions', 'title'=>'Lash Extensions',  'price'=>'','desc'=>'Semi-permanent lash extensions for a fuller, longer lash look without mascara.'],
              ['key'=>'eyebrow-wax',     'title'=>'Eyebrow Waxing',   'price'=>'','desc'=>'Precise eyebrow shaping using wax for a clean, defined arch.'],
              ['key'=>'eyebrow-thread',  'title'=>'Eyebrow Threading', 'price'=>'','desc'=>'Traditional threading technique for precise brow shaping. Ideal for sensitive skin.'],
          ];
          $beauty_services = array_map(function($s) {
              $img = ah_opt_img("svc_{$s['key']}_image");
              return [
                  'title'    => $s['title'],
                  'price'    => $s['price'],
                  'desc'     => $s['desc'],
                  'link'     => ah_opt("svc_{$s['key']}_link",''),
                  'image_id' => $img['id'] ?? 0,
                  '_img_url' => $img['url'] ?? '',
              ];
          }, $beauty_keys);
      }
      foreach($beauty_services as $i => $s):
          $svc_link  = $s['link'] ?? '';
          $svc_title = $s['title'] ?? '';
          $svc_desc  = $s['desc']  ?? '';
          $svc_price = $s['price'] ?? '';
          $svc_imgid = (int)($s['image_id'] ?? 0);
          $svc_img   = $svc_imgid ? wp_get_attachment_image_url($svc_imgid,'large') : ($s['_img_url'] ?? '');
      ?>
        <?php if ($svc_link): ?>
        <a href="<?php echo esc_url($svc_link); ?>" class="service-card service-card--linked reveal d<?php echo $i+1; ?>">
        <?php else: ?>
        <div class="service-card reveal d<?php echo $i+1; ?>">
        <?php endif; ?>
          <div class="service-card__img">
            <?php if ($svc_img): ?>
            <img src="<?php echo esc_url($svc_img); ?>" alt="<?php echo esc_attr($svc_title); ?>" loading="lazy">
            <?php endif; ?>
          </div>
          <div class="service-card__body">
            <h3 class="service-card__title"><?php echo esc_html($svc_title); ?></h3>
            <?php if ($svc_price): ?><p class="service-card__price"><?php echo esc_html($svc_price); ?></p><?php endif; ?>
            <p class="service-card__desc"><?php echo esc_html($svc_desc); ?></p>
            <?php if ($svc_link): ?>
            <span class="service-card__cta">Book Now <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
            <?php endif; ?>
          </div>
        <?php echo $svc_link ? '</a>' : '</div>'; ?>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- Booking + Location -->
<section class="split" id="visit-us">
  <div class="split__media">
    <img src="<?php echo esc_url((ah_opt_img('salon_split_img2')['url'] ?? '')); ?>"
         alt="AHB Salon — Nottingham hair and beauty salon"
         loading="lazy" width="800" height="1000">
  </div>
  <div class="split__body reveal">
    <span class="t-label">Visit Us</span>
    <h2 class="t-h3" style="margin:1rem 0;">
      AHB Salon, Nottingham
    </h2>
    <span class="rule"></span>

    <div class="contact-list" style="margin:2rem 0;">
      <div class="contact-item">
        <div class="contact-item__icon"><?php echo ah_svg('location'); ?></div>
        <div>
          <span class="contact-item__label">Address</span>
          <span class="contact-item__val">
            358 Radford Road<br>Nottingham, NG7 5GQ
          </span>
        </div>
      </div>
      <div class="contact-item">
        <div class="contact-item__icon"><?php echo ah_svg('phone'); ?></div>
        <div>
          <span class="contact-item__label">Phone / WhatsApp</span>
          <span class="contact-item__val">
            <a href="tel:07827129797">07827 129797</a>
          </span>
        </div>
      </div>
      <div class="contact-item">
        <div class="contact-item__icon"><?php echo ah_svg('clock'); ?></div>
        <div>
          <span class="contact-item__label">Opening Hours</span>
          <span class="contact-item__val">Mon–Sat: 9am–7pm</span>
        </div>
      </div>
    </div>

    <div class="btns">
      <a href="<?php echo esc_url($booking_url); ?>"
         class="btn btn--bk"
         target="_blank" rel="noopener noreferrer">
        Book Appointment <?php echo ah_svg('arrow-right'); ?>
      </a>
      <a href="https://maps.google.com/?q=358+Radford+Road+Nottingham+NG7+5GQ"
         class="btn btn--ob"
         target="_blank" rel="noopener noreferrer">
        Get Directions
      </a>
    </div>
  </div>
</section>

<!-- Testimonials -->
<section class="s s--off" aria-labelledby="reviews-heading">
  <div class="wrap">
    <div class="sh sh--c reveal">
      <span class="t-label">Client Love</span>
      <h2 id="reviews-heading" class="t-h2">What Our Clients Say</h2>
      <span class="rule rule--center"></span>
      <p class="t-body">Real reviews from real clients. Find us on Google to read more.</p>
    </div>
    <div class="grid-3">
      <?php
      $reviews = [
        ['The braids were absolutely perfect. Neat, clean, and lasted for weeks. I\'ll definitely be coming back!', 'Aisha T., Nottingham', 5],
        ['Had my lash extensions done here and they look incredible. The service was professional and the atmosphere is lovely.', 'Kezia M., Nottingham', 5],
        ['I bought raw hair bundles from Asantey and had them installed at the salon. Best decision I\'ve made — no shedding, no tangling.', 'Priscilla O., Leicester', 5],
      ];
      foreach($reviews as $i => $r): ?>
        <div class="ah-testimonial ah-reveal ah-reveal--delay-<?php echo $i+1; ?>">
          <?php echo ah_stars($r[2]); ?>
          <p class="tcard__quote">&ldquo;<?php echo esc_html($r[0]); ?>&rdquo;</p>
          <span class="tcard__author">&mdash; <?php echo esc_html($r[1]); ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Final CTA -->
<div class="cta-band dark">
  <div class="wrap"><div class="reveal">
    <span class="t-label t-label--white">Ready to Book?</span>
    <h2 class="t-h1">Book Your Appointment Today</h2>
    <p class="t-body">
      Online booking is open 24/7. Choose your service, pick your time, and we&rsquo;ll take care of the rest.
    </p>
    <div class="btns" style="justify-content:center;">
      <a href="<?php echo esc_url($booking_url); ?>"
         class="btn btn--bk"
         target="_blank" rel="noopener noreferrer">
        Book Online Now <?php echo ah_svg('arrow-right'); ?>
      </a>
      <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I would like to book a salon appointment.')); ?>"
         class="btn btn--wa"
         target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Book via WhatsApp
      </a>
    </div>
  </div></div>
</div>

<?php get_footer(); ?>
