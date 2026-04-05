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

<section class="page-hero">
  <div class="page-hero__content">
    <span class="t-label">We&rsquo;re Here to Help</span>
    <h1 class="t-h1">Get in Touch</h1>
    <p >Questions about your order, product advice, or just want to say hello — we&rsquo;d love to hear from you.</p>
  </div>
</section>

<?php ah_breadcrumb(); ?>

<section class="s">
  <div class="wrap">
    <div class="grid-2" style="gap:4rem;align-items:start;">

      <!-- Contact Info -->
      <div class="reveal">
        <span class="t-label">Contact Details</span>
        <h2 class="t-h3" style="margin:1rem 0;">Reach Us Directly</h2>
        <span class="rule"></span>
        <p class="t-body" style="margin-bottom:2rem;">
          The fastest way to reach us is WhatsApp — we typically respond within a few hours.
          For order enquiries, please use our <a href="<?php echo esc_url(home_url('/order/')); ?>" style="color:var(--gold);text-decoration:underline;">Order Enquiry form</a>
          for a structured response.
        </p>

        <div class="contact-list">

          <?php if($phone): ?>
            <div class="contact-item">
              <div class="contact-item__icon"><?php echo ah_svg('phone'); ?></div>
              <div>
                <span class="contact-item__label">Phone</span>
                <span class="contact-item__val">
                  <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/','',$phone)); ?>"><?php echo esc_html($phone); ?></a>
                </span>
              </div>
            </div>
          <?php endif; ?>

          <?php if($email): ?>
            <div class="contact-item">
              <div class="contact-item__icon"><?php echo ah_svg('mail'); ?></div>
              <div>
                <span class="contact-item__label">Email</span>
                <span class="contact-item__val">
                  <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                </span>
              </div>
            </div>
          <?php endif; ?>

          <?php if(get_theme_mod('ah_whatsapp_number')): ?>
            <div class="contact-item">
              <div class="contact-item__icon" style="background:#e8f8ef;"><?php echo ah_svg('whatsapp'); ?></div>
              <div>
                <span class="contact-item__label">WhatsApp (Preferred)</span>
                <span class="contact-item__val">
                  <a href="<?php echo esc_url(ah_whatsapp_url()); ?>" target="_blank" rel="noopener noreferrer">
                    <?php echo esc_html(get_theme_mod('ah_whatsapp_number')); ?>
                  </a>
                </span>
              </div>
            </div>
          <?php endif; ?>

          <?php if($address): ?>
            <div class="contact-item">
              <div class="contact-item__icon"><?php echo ah_svg('location'); ?></div>
              <div>
                <span class="contact-item__label">Location</span>
                <span class="contact-item__val"><?php echo nl2br(esc_html($address)); ?></span>
              </div>
            </div>
          <?php endif; ?>

          <div class="contact-item">
            <div class="contact-item__icon"><?php echo ah_svg('clock'); ?></div>
            <div>
              <span class="contact-item__label">Business Hours</span>
              <span class="contact-item__val"><?php echo esc_html($hours); ?></span>
            </div>
          </div>

        </div><!-- /.ah-contact-info -->

        <!-- WhatsApp CTA -->
        <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I have an enquiry for Asantey Hair & Beauty.')); ?>"
           class="btn btn--wa"
           style="margin-top:2rem;"
           target="_blank" rel="noopener noreferrer">
          <?php echo ah_svg('whatsapp'); ?> Start a WhatsApp Chat
        </a>

        <!-- Social links -->
        <div style="margin-top:2rem;">
          <span class="t-label" style="display:block;margin-bottom:1rem;">Follow Us</span>
          <style>
          .ah-contact-socials { display:flex; gap:1rem; }
          .ah-contact-socials a { width:40px;height:40px;background:#f8f8f8;display:flex;align-items:center;justify-content:center;color:var(--ink);transition:background .2s ease,color .2s ease;}
          .ah-contact-socials a:hover { background:var(--gold);color:#ffffff;}
          .ah-contact-socials svg { width:18px;height:18px;}
          </style>
          <div class="contact-socials">
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
      <div class="reveal d2">
        <span class="t-label">Send Us a Message</span>
        <h2 class="t-h3" style="margin:1rem 0;">Send a Message</h2>
        <span class="rule"></span>
        <p class="t-body" style="margin-bottom:2rem;">
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
  <div class="map-wrap">
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
  <div style="background:#f8f8f8;height:300px;display:flex;align-items:center;justify-content:center;">
    <div style="text-align:center;color:var(--g9);">
      <p style="font-size:0.875rem;">Add Google Maps Embed URL in Customizer &rarr; Contact Details</p>
    </div>
  </div>
<?php endif; ?>

<!-- Order via WhatsApp Alt -->
<div class="s" style="background:#f8f8f8;" style="padding:4rem 1.5rem;">
  <div class="wrap" style="text-align:center;">
    <div class="reveal">
      <h3 class="t-h3" style="margin-bottom:1rem;">Prefer to Order Directly?</h3>
      <p class="t-body--lg" style="max-width:600px;margin:0 auto 2rem;">
        WhatsApp us with your product, texture, length, and quantity — and we&rsquo;ll
        guide you through every step of the process.
      </p>
      <div class="btns" style="justify-content:center;">
        <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I would like to place an order.')); ?>"
           class="btn btn--wa" target="_blank" rel="noopener noreferrer">
          <?php echo ah_svg('whatsapp'); ?> WhatsApp Order
        </a>
        <a href="<?php echo esc_url(home_url('/order/')); ?>" class="btn btn--ob">
          Use Order Form
        </a>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
