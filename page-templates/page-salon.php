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

<div class="header-offset"></div>

<section class="page-hero">
  <div class="page-hero__bg">
    <img src="<?php echo esc_url(AH_URI.'/assets/images/client-result-1.jpg'); ?>"
         alt="" aria-hidden="true" loading="eager" width="1280" height="500">
  </div>
  <div class="page-hero__content">
    <span class="t-label">Nottingham Salon</span>
    <h1 class="t-h1">Hair &amp; Beauty<br>Salon Services</h1>
    <p >
      Expert hair and beauty services in Nottingham. Book your appointment online in minutes.
    </p>
    <div class="btn-group" style="margin-top:var(--ah-space-8);">
      <a href="<?php echo esc_url($booking_url); ?>"
         class="btn btn--black"
         target="_blank" rel="noopener noreferrer">
        Book Appointment <?php echo ah_svg('arrow-right'); ?>
      </a>
      <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I\'d like to book an appointment at AHB Salon.')); ?>"
         class="btn btn--outline-white"
         target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Book via WhatsApp
      </a>
    </div>
  </div>
</section>

<?php ah_breadcrumb(); ?>

<!-- Location strip -->
<div class="trust-bar">
  <div class="trust-bar__inner">
    <?php
    $info = [
      ['location','358 Radford Road, Nottingham NG7 5GQ'],
      ['phone',   '07827 129797'],
      ['clock',   'Mon–Sat: 9am–7pm'],
      ['sparkle', 'Walk-ins Welcome'],
    ];
    foreach($info as $i => $item):
      echo '<span class="trust-bar__item">'.ah_svg($item[0]).esc_html($item[1]).'</span>';
      if($i < count($info)-1) echo '<span class="trust-bar__divider"></span>';
    endforeach;
    ?>
  </div>
</div>

<!-- Hair Services -->
<section class="section" id="hair-services" aria-labelledby="hair-heading">
  <div class="wrap">

    <div class="section-head section-head--center reveal">
      <span class="t-label">Hair Services</span>
      <h2 id="hair-heading" class="t-h2">Expert Hair Services</h2>
      <span class="rule rule--center"></span>
      <p class="t-body--lg">
        Delivered by skilled stylists who understand your hair — and how to make it look its absolute best.
      </p>
    </div>

    <div class="grid-3">
      <?php
      $hair_services = [
        [
          'icon'  => 'sparkle',
          'title' => 'Braids',
          'body'  => 'From knotless box braids to jumbo braids — protective styles that are clean, neat, and built to last. Book online for a consultation.',
        ],
        [
          'icon'  => 'sparkle',
          'title' => 'Cornrows',
          'body'  => 'Classic and intricate cornrow styles including straight backs, curved designs, and feed-in techniques. Natural or with extensions.',
        ],
        [
          'icon'  => 'heart',
          'title' => 'Hair Treatments',
          'body'  => 'Deep conditioning, protein treatments, and scalp care designed to restore moisture, reduce breakage, and promote healthy hair growth.',
        ],
        [
          'icon'  => 'gem',
          'title' => 'Sew-In Installs',
          'body'  => 'Professional sew-in installation for bundles and closures/frontals. Achieve a flawless, long-lasting install every time.',
        ],
        [
          'icon'  => 'gem',
          'title' => 'Closure & Frontal Installs',
          'body'  => 'Expert HD lace closure and frontal installation. Natural hairline, seamless blend, undetectable finish.',
        ],
        [
          'icon'  => 'sparkle',
          'title' => 'Natural Hair Care',
          'body'  => 'Wash, condition, detangle, and style services for natural hair textures. Designed to maintain length and promote healthy growth.',
        ],
      ];
      foreach($hair_services as $i => $s): ?>
        <div class="feature-card ah-reveal ah-reveal--delay-<?php echo ($i%3)+1; ?>">
          <div class="feature-card__icon"><?php echo ah_svg($s['icon']); ?></div>
          <h3 class="feature-card__title"><?php echo esc_html($s['title']); ?></h3>
          <p class="feature-card__body"><?php echo esc_html($s['body']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- Beauty Services -->
<section class="section section--grey" id="beauty-services" aria-labelledby="beauty-heading">
  <div class="wrap">

    <div class="section-head section-head--center reveal">
      <span class="t-label">Beauty Services</span>
      <h2 id="beauty-heading" class="t-h2">Complete Beauty Services</h2>
      <span class="rule rule--center"></span>
      <p class="t-body--lg">
        Finish your look from lash to brow. Our beauty services are designed to complement
        your hair for a complete, polished result.
      </p>
    </div>

    <div class="grid-3">
      <?php
      $beauty_services = [
        [
          'icon'  => 'heart',
          'title' => 'Lash Extensions',
          'body'  => 'Classic, hybrid, and volume lash sets that enhance your natural eye shape. Long-lasting, lightweight, and beautifully finished.',
        ],
        [
          'icon'  => 'sparkle',
          'title' => 'Eyebrow Waxing',
          'body'  => 'Precise eyebrow shaping using wax for a clean, defined arch that frames your face perfectly.',
        ],
        [
          'icon'  => 'gem',
          'title' => 'Eyebrow Threading',
          'body'  => 'Traditional threading technique for precise, pain-managed brow shaping. Ideal for sensitive skin or fine brow hair.',
        ],
      ];
      foreach($beauty_services as $i => $s): ?>
        <div class="feature-card ah-reveal ah-reveal--delay-<?php echo $i+1; ?>">
          <div class="feature-card__icon"><?php echo ah_svg($s['icon']); ?></div>
          <h3 class="feature-card__title"><?php echo esc_html($s['title']); ?></h3>
          <p class="feature-card__body"><?php echo esc_html($s['body']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- Booking + Location -->
<section class="split section--sm" id="visit-us">
  <div class="split__media">
    <img src="<?php echo esc_url(AH_URI.'/assets/images/client-result-3.jpg'); ?>"
         alt="AHB Salon — Nottingham hair and beauty salon"
         loading="lazy" width="800" height="1000">
  </div>
  <div class="split__body ah-reveal">
    <span class="t-label">Visit Us</span>
    <h2 class="t-h3" style="margin:var(--ah-space-4) 0;">
      AHB Salon, Nottingham
    </h2>
    <span class="rule"></span>

    <div class="contact-list" style="margin:var(--ah-space-8) 0;">
      <div class="contact-item">
        <?php echo ah_svg('location'); ?>
        <div>
          <span class="contact-item__label">Address</span>
          <span class="contact-item__val">
            358 Radford Road<br>Nottingham, NG7 5GQ
          </span>
        </div>
      </div>
      <div class="contact-item">
        <?php echo ah_svg('phone'); ?>
        <div>
          <span class="contact-item__label">Phone / WhatsApp</span>
          <span class="contact-item__val">
            <a href="tel:07827129797">07827 129797</a>
          </span>
        </div>
      </div>
      <div class="contact-item">
        <?php echo ah_svg('clock'); ?>
        <div>
          <span class="contact-item__label">Opening Hours</span>
          <span class="contact-item__val">Mon–Sat: 9am–7pm</span>
        </div>
      </div>
    </div>

    <div class="btn-group">
      <a href="<?php echo esc_url($booking_url); ?>"
         class="btn btn--black"
         target="_blank" rel="noopener noreferrer">
        Book Appointment <?php echo ah_svg('arrow-right'); ?>
      </a>
      <a href="https://maps.google.com/?q=358+Radford+Road+Nottingham+NG7+5GQ"
         class="btn btn--outline"
         target="_blank" rel="noopener noreferrer">
        Get Directions
      </a>
    </div>
  </div>
</section>

<!-- Testimonials -->
<section class="section section--grey" aria-labelledby="reviews-heading">
  <div class="wrap">
    <div class="section-head section-head--center reveal">
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
          <p class="testimonial__quote">&ldquo;<?php echo esc_html($r[0]); ?>&rdquo;</p>
          <span class="testimonial__author">&mdash; <?php echo esc_html($r[1]); ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Final CTA -->
<div class="cta-band">
  <div class="wrap"><div class="reveal">
    <span class="t-label t-label--white">Ready to Book?</span>
    <h2 class="t-h1">Book Your Appointment Today</h2>
    <p class="t-body">
      Online booking is open 24/7. Choose your service, pick your time, and we&rsquo;ll take care of the rest.
    </p>
    <div class="btn-group" style="justify-content:center;">
      <a href="<?php echo esc_url($booking_url); ?>"
         class="btn btn--black"
         target="_blank" rel="noopener noreferrer">
        Book Online Now <?php echo ah_svg('arrow-right'); ?>
      </a>
      <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I\'d like to book a salon appointment.')); ?>"
         class="btn btn--wa"
         target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Book via WhatsApp
      </a>
    </div>
  </div></div>
</div>

<?php get_footer(); ?>
