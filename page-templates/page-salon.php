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

<div class="ah-header-offset"></div>

<section class="ah-page-hero">
  <div class="ah-page-hero__bg">
    <img src="<?php echo esc_url(AH_URI.'/assets/images/client-result-1.jpg'); ?>"
         alt="" aria-hidden="true" loading="eager" width="1280" height="500">
  </div>
  <div class="ah-page-hero__content">
    <span class="ah-page-hero__label">Nottingham Salon</span>
    <h1 class="ah-page-hero__title">Hair &amp; Beauty<br>Salon Services</h1>
    <p class="ah-page-hero__subtitle">
      Expert hair and beauty services in Nottingham. Book your appointment online in minutes.
    </p>
    <div class="ah-btn-group" style="margin-top:var(--ah-space-8);">
      <a href="<?php echo esc_url($booking_url); ?>"
         class="ah-btn ah-btn--gold ah-btn--lg"
         target="_blank" rel="noopener noreferrer">
        Book Appointment <?php echo ah_svg('arrow-right'); ?>
      </a>
      <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I\'d like to book an appointment at AHB Salon.')); ?>"
         class="ah-btn ah-btn--outline-white ah-btn--lg"
         target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Book via WhatsApp
      </a>
    </div>
  </div>
</section>

<?php ah_breadcrumb(); ?>

<!-- Location strip -->
<div class="ah-trust-bar">
  <div class="ah-trust-bar__inner">
    <?php
    $info = [
      ['location','358 Radford Road, Nottingham NG7 5GQ'],
      ['phone',   '07827 129797'],
      ['clock',   'Mon–Sat: 9am–7pm'],
      ['sparkle', 'Walk-ins Welcome'],
    ];
    foreach($info as $i => $item):
      echo '<span class="ah-trust-bar__item">'.ah_svg($item[0]).esc_html($item[1]).'</span>';
      if($i < count($info)-1) echo '<span class="ah-trust-bar__divider"></span>';
    endforeach;
    ?>
  </div>
</div>

<!-- Hair Services -->
<section class="ah-section" id="hair-services" aria-labelledby="hair-heading">
  <div class="ah-container">

    <div class="ah-section-header--center ah-reveal">
      <span class="ah-subheading">Hair Services</span>
      <h2 id="hair-heading" class="ah-heading-lg">Expert Hair Services</h2>
      <span class="ah-accent-line ah-accent-line--center"></span>
      <p class="ah-body-lg">
        Delivered by skilled stylists who understand your hair — and how to make it look its absolute best.
      </p>
    </div>

    <div class="ah-grid ah-grid--3">
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
        <div class="ah-feature-card ah-reveal ah-reveal--delay-<?php echo ($i%3)+1; ?>">
          <div class="ah-feature-card__icon"><?php echo ah_svg($s['icon']); ?></div>
          <h3 class="ah-feature-card__title"><?php echo esc_html($s['title']); ?></h3>
          <p class="ah-feature-card__body"><?php echo esc_html($s['body']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- Beauty Services -->
<section class="ah-section ah-section--grey" id="beauty-services" aria-labelledby="beauty-heading">
  <div class="ah-container">

    <div class="ah-section-header--center ah-reveal">
      <span class="ah-subheading">Beauty Services</span>
      <h2 id="beauty-heading" class="ah-heading-lg">Complete Beauty Services</h2>
      <span class="ah-accent-line ah-accent-line--center"></span>
      <p class="ah-body-lg">
        Finish your look from lash to brow. Our beauty services are designed to complement
        your hair for a complete, polished result.
      </p>
    </div>

    <div class="ah-grid ah-grid--3">
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
        <div class="ah-feature-card ah-reveal ah-reveal--delay-<?php echo $i+1; ?>">
          <div class="ah-feature-card__icon"><?php echo ah_svg($s['icon']); ?></div>
          <h3 class="ah-feature-card__title"><?php echo esc_html($s['title']); ?></h3>
          <p class="ah-feature-card__body"><?php echo esc_html($s['body']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- Booking + Location -->
<section class="ah-split ah-section--sm" id="visit-us">
  <div class="ah-split__image">
    <img src="<?php echo esc_url(AH_URI.'/assets/images/client-result-3.jpg'); ?>"
         alt="AHB Salon — Nottingham hair and beauty salon"
         loading="lazy" width="800" height="1000">
  </div>
  <div class="ah-split__content ah-reveal">
    <span class="ah-subheading">Visit Us</span>
    <h2 class="ah-heading-md" style="margin:var(--ah-space-4) 0;">
      AHB Salon, Nottingham
    </h2>
    <span class="ah-accent-line"></span>

    <div class="ah-contact-info" style="margin:var(--ah-space-8) 0;">
      <div class="ah-contact-item">
        <?php echo ah_svg('location'); ?>
        <div>
          <span class="ah-contact-item__label">Address</span>
          <span class="ah-contact-item__value">
            358 Radford Road<br>Nottingham, NG7 5GQ
          </span>
        </div>
      </div>
      <div class="ah-contact-item">
        <?php echo ah_svg('phone'); ?>
        <div>
          <span class="ah-contact-item__label">Phone / WhatsApp</span>
          <span class="ah-contact-item__value">
            <a href="tel:07827129797">07827 129797</a>
          </span>
        </div>
      </div>
      <div class="ah-contact-item">
        <?php echo ah_svg('clock'); ?>
        <div>
          <span class="ah-contact-item__label">Opening Hours</span>
          <span class="ah-contact-item__value">Mon–Sat: 9am–7pm</span>
        </div>
      </div>
    </div>

    <div class="ah-btn-group">
      <a href="<?php echo esc_url($booking_url); ?>"
         class="ah-btn ah-btn--gold ah-btn--lg"
         target="_blank" rel="noopener noreferrer">
        Book Appointment <?php echo ah_svg('arrow-right'); ?>
      </a>
      <a href="https://maps.google.com/?q=358+Radford+Road+Nottingham+NG7+5GQ"
         class="ah-btn ah-btn--outline"
         target="_blank" rel="noopener noreferrer">
        Get Directions
      </a>
    </div>
  </div>
</section>

<!-- Testimonials -->
<section class="ah-section ah-section--grey" aria-labelledby="reviews-heading">
  <div class="ah-container">
    <div class="ah-section-header--center ah-reveal">
      <span class="ah-subheading">Client Love</span>
      <h2 id="reviews-heading" class="ah-heading-lg">What Our Clients Say</h2>
      <span class="ah-accent-line ah-accent-line--center"></span>
      <p class="ah-body">Real reviews from real clients. Find us on Google to read more.</p>
    </div>
    <div class="ah-grid ah-grid--3">
      <?php
      $reviews = [
        ['The braids were absolutely perfect. Neat, clean, and lasted for weeks. I\'ll definitely be coming back!', 'Aisha T., Nottingham', 5],
        ['Had my lash extensions done here and they look incredible. The service was professional and the atmosphere is lovely.', 'Kezia M., Nottingham', 5],
        ['I bought raw hair bundles from Asantey and had them installed at the salon. Best decision I\'ve made — no shedding, no tangling.', 'Priscilla O., Leicester', 5],
      ];
      foreach($reviews as $i => $r): ?>
        <div class="ah-testimonial ah-reveal ah-reveal--delay-<?php echo $i+1; ?>">
          <?php echo ah_stars($r[2]); ?>
          <p class="ah-testimonial__quote">&ldquo;<?php echo esc_html($r[0]); ?>&rdquo;</p>
          <span class="ah-testimonial__author">&mdash; <?php echo esc_html($r[1]); ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Final CTA -->
<div class="ah-cta-band">
  <div class="ah-container"><div class="ah-reveal">
    <span class="ah-cta-band__label">Ready to Book?</span>
    <h2 class="ah-cta-band__heading">Book Your Appointment Today</h2>
    <p class="ah-cta-band__body">
      Online booking is open 24/7. Choose your service, pick your time, and we&rsquo;ll take care of the rest.
    </p>
    <div class="ah-btn-group" style="justify-content:center;">
      <a href="<?php echo esc_url($booking_url); ?>"
         class="ah-btn ah-btn--gold ah-btn--lg"
         target="_blank" rel="noopener noreferrer">
        Book Online Now <?php echo ah_svg('arrow-right'); ?>
      </a>
      <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I\'d like to book a salon appointment.')); ?>"
         class="ah-btn ah-btn--whatsapp ah-btn--lg"
         target="_blank" rel="noopener noreferrer">
        <?php echo ah_svg('whatsapp'); ?> Book via WhatsApp
      </a>
    </div>
  </div></div>
</div>

<?php get_footer(); ?>
