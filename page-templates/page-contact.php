<?php
/**
 * Template Name: Contact
 * Asantey Hair & Beauty
 */
get_header();

echo ah_schema_breadcrumb([
  ['name' => 'Home',    'url' => home_url('/')],
  ['name' => 'Contact', 'url' => get_permalink()],
]);

$phone   = get_theme_mod('ah_contact_phone',   '');
$email   = get_theme_mod('ah_contact_email',   '');
$address = get_theme_mod('ah_contact_address', '');
$hours   = get_theme_mod('ah_contact_hours',   'Mon–Sat: 9am–7pm');
$map_url = get_theme_mod('ah_contact_map',     '');
?>

<div class="ah-header-offset"></div>

<section class="ah-page-hero">
  <div class="ah-page-hero__content">
    <span class="ah-page-hero__label">We&rsquo;re Here to Help</span>
    <h1 class="ah-page-hero__title">Get in Touch</h1>
    <p class="ah-page-hero__subtitle">Questions about your order, product advice, or just want to say hello — we&rsquo;d love to hear from you.</p>
  </div>
</section>

<?php ah_breadcrumb(); ?>

<section class="ah-section">
  <div class="ah-container">
    <div class="ah-grid ah-grid--2" style="gap:var(--ah-space-16);align-items:start;">

      <!-- Contact Info -->
      <div class="ah-reveal">
        <span class="ah-subheading">Contact Details</span>
        <h2 class="ah-heading-md" style="margin:var(--ah-space-4) 0;">Reach Us Directly</h2>
        <span class="ah-accent-line"></span>
        <p class="ah-body" style="margin-bottom:var(--ah-space-8);">
          The fastest way to reach us is WhatsApp — we typically respond within a few hours.
          For order enquiries, please use our <a href="<?php echo esc_url(home_url('/order/')); ?>" style="color:var(--ah-gold);text-decoration:underline;">Order Enquiry form</a>
          for a structured response.
        </p>

        <div class="ah-contact-info">

          <?php if($phone): ?>
            <div class="ah-contact-item">
              <div class="ah-contact-item__icon"><?php echo ah_svg('phone'); ?></div>
              <div>
                <span class="ah-contact-item__label">Phone</span>
                <span class="ah-contact-item__value">
                  <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/','',$phone)); ?>"><?php echo esc_html($phone); ?></a>
                </span>
              </div>
            </div>
          <?php endif; ?>

          <?php if($email): ?>
            <div class="ah-contact-item">
              <div class="ah-contact-item__icon"><?php echo ah_svg('mail'); ?></div>
              <div>
                <span class="ah-contact-item__label">Email</span>
                <span class="ah-contact-item__value">
                  <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                </span>
              </div>
            </div>
          <?php endif; ?>

          <?php if(get_theme_mod('ah_whatsapp_number')): ?>
            <div class="ah-contact-item">
              <div class="ah-contact-item__icon" style="background:#e8f8ef;"><?php echo ah_svg('whatsapp'); ?></div>
              <div>
                <span class="ah-contact-item__label">WhatsApp (Preferred)</span>
                <span class="ah-contact-item__value">
                  <a href="<?php echo esc_url(ah_whatsapp_url()); ?>" target="_blank" rel="noopener noreferrer">
                    <?php echo esc_html(get_theme_mod('ah_whatsapp_number')); ?>
                  </a>
                </span>
              </div>
            </div>
          <?php endif; ?>

          <?php if($address): ?>
            <div class="ah-contact-item">
              <div class="ah-contact-item__icon"><?php echo ah_svg('location'); ?></div>
              <div>
                <span class="ah-contact-item__label">Location</span>
                <span class="ah-contact-item__value"><?php echo nl2br(esc_html($address)); ?></span>
              </div>
            </div>
          <?php endif; ?>

          <div class="ah-contact-item">
            <div class="ah-contact-item__icon"><?php echo ah_svg('clock'); ?></div>
            <div>
              <span class="ah-contact-item__label">Business Hours</span>
              <span class="ah-contact-item__value"><?php echo esc_html($hours); ?></span>
            </div>
          </div>

        </div><!-- /.ah-contact-info -->

        <!-- WhatsApp CTA -->
        <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I have an enquiry for Asantey Hair & Beauty.')); ?>"
           class="ah-btn ah-btn--whatsapp ah-btn--lg"
           style="margin-top:var(--ah-space-8);"
           target="_blank" rel="noopener noreferrer">
          <?php echo ah_svg('whatsapp'); ?> Start a WhatsApp Chat
        </a>

        <!-- Social links -->
        <div style="margin-top:var(--ah-space-8);">
          <span class="ah-subheading" style="display:block;margin-bottom:var(--ah-space-4);">Follow Us</span>
          <style>
          .ah-contact-socials { display:flex; gap:var(--ah-space-4); }
          .ah-contact-socials a { width:40px;height:40px;background:var(--ah-grey-100);display:flex;align-items:center;justify-content:center;color:var(--ah-black);transition:background var(--ah-transition-fast),color var(--ah-transition-fast);}
          .ah-contact-socials a:hover { background:var(--ah-gold);color:var(--ah-pure-white);}
          .ah-contact-socials svg { width:18px;height:18px;}
          </style>
          <div class="ah-contact-socials">
            <?php
            $socials = ['instagram','facebook','tiktok','youtube'];
            foreach($socials as $s):
              $url = get_theme_mod('ah_social_'.$s,'');
              if($url): ?>
                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr(ucfirst($s)); ?>">
                  <?php echo ah_svg($s); ?>
                </a>
              <?php endif;
            endforeach; ?>
          </div>
        </div>

      </div><!-- /col -->

      <!-- Contact Form -->
      <div class="ah-reveal ah-reveal--delay-2">
        <span class="ah-subheading">Send Us a Message</span>
        <h2 class="ah-heading-md" style="margin:var(--ah-space-4) 0;">Send a Message</h2>
        <span class="ah-accent-line"></span>
        <p class="ah-body" style="margin-bottom:var(--ah-space-8);">
          Fill in the form below and we&rsquo;ll get back to you within 24 hours.
          For urgent enquiries, please use WhatsApp.
        </p>
        <?php ah_contact_form(); ?>
      </div>

    </div>
  </div>
</section>

<!-- Google Map -->
<?php if($map_url): ?>
  <div class="ah-map-wrap">
    <iframe
      src="<?php echo esc_url($map_url); ?>"
      title="Asantey Hair &amp; Beauty Location"
      allowfullscreen=""
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"
      aria-label="Google Maps showing Asantey Hair &amp; Beauty location">
    </iframe>
  </div>
<?php else: ?>
  <!-- Map placeholder — add Google Maps embed URL in Customizer → Contact Details → Google Maps Embed URL -->
  <div style="background:var(--ah-grey-100);height:300px;display:flex;align-items:center;justify-content:center;">
    <div style="text-align:center;color:var(--ah-grey-500);">
      <p style="font-size:var(--ah-text-sm);">Add Google Maps Embed URL in Customizer &rarr; Contact Details</p>
    </div>
  </div>
<?php endif; ?>

<!-- Order via WhatsApp Alt -->
<div class="ah-section ah-section--grey" style="padding:var(--ah-space-16) var(--ah-space-6);">
  <div class="ah-container" style="text-align:center;">
    <div class="ah-reveal">
      <h3 class="ah-heading-md" style="margin-bottom:var(--ah-space-4);">Prefer to Order Directly?</h3>
      <p class="ah-body-lg" style="max-width:600px;margin:0 auto var(--ah-space-8);">
        WhatsApp us with your product, texture, length, and quantity — and we&rsquo;ll
        guide you through every step of the process.
      </p>
      <div class="ah-btn-group" style="justify-content:center;">
        <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I\'d like to place an order.')); ?>"
           class="ah-btn ah-btn--whatsapp ah-btn--lg" target="_blank" rel="noopener noreferrer">
          <?php echo ah_svg('whatsapp'); ?> WhatsApp Order
        </a>
        <a href="<?php echo esc_url(home_url('/order/')); ?>" class="ah-btn ah-btn--outline ah-btn--lg">
          Use Order Form
        </a>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
