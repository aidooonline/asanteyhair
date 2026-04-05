<?php
/**
 * Template Name: Privacy Policy
 * Asantey Hair & Beauty
 */
get_header();
echo ah_schema_breadcrumb([['name'=>'Home','url'=>home_url('/')],['name'=>'Privacy Policy','url'=>get_permalink()]]);
$business = get_theme_mod('ah_contact_name','Asantey Hair & Beauty');
$email    = get_theme_mod('ah_contact_email','');
?>
<section class="page-hero"><div class="page-hero__content"><span class="t-label">Legal</span><h1 class="t-h1">Privacy Policy</h1></div></section>
<?php ah_breadcrumb(); ?>

<div class="legal">
  <p class="date">Last Updated: January 2024</p>

  <h2>1. Introduction</h2>
  <p><?php echo esc_html($business); ?> (&ldquo;we&rdquo;, &ldquo;us&rdquo;, or &ldquo;our&rdquo;) is committed to protecting your personal information. This Privacy Policy explains how we collect, use, and protect your data when you use our website or purchase from us.</p>

  <h2>2. Information We Collect</h2>
  <p>We may collect the following personal information:</p>
  <ul>
    <li><strong>Contact Information:</strong> Name, email address, phone number, and WhatsApp number when you submit an enquiry or order form.</li>
    <li><strong>Order Information:</strong> Product selections, delivery preferences, and payment confirmation details.</li>
    <li><strong>Communications:</strong> Messages, enquiries, and correspondence you send to us via the contact form, email, or WhatsApp.</li>
    <li><strong>Website Usage:</strong> Pages visited, time spent on site, and general browsing behaviour through cookies and analytics tools.</li>
    <li><strong>Newsletter Subscription:</strong> Email address if you subscribe to our newsletter.</li>
  </ul>

  <h2>3. How We Use Your Information</h2>
  <p>We use your personal data to:</p>
  <ul>
    <li>Process and fulfil your orders</li>
    <li>Respond to enquiries and provide customer support</li>
    <li>Send order confirmations and shipping updates</li>
    <li>Send newsletter communications (only if you have opted in)</li>
    <li>Improve our website and services</li>
    <li>Comply with legal obligations</li>
  </ul>
  <p>We do not sell, rent, or trade your personal data with third parties for marketing purposes.</p>

  <h2>4. Legal Basis for Processing</h2>
  <p>Under UK GDPR, we process your data on the following lawful bases:</p>
  <ul>
    <li><strong>Contract:</strong> Processing your order requires us to use your contact and delivery information.</li>
    <li><strong>Consent:</strong> For newsletter subscriptions and marketing communications.</li>
    <li><strong>Legitimate Interests:</strong> For responding to enquiries and improving our services.</li>
    <li><strong>Legal Obligation:</strong> For compliance with applicable laws and regulations.</li>
  </ul>

  <h2>5. Cookies</h2>
  <p>Our website uses cookies to improve your experience. These include:</p>
  <ul>
    <li><strong>Essential cookies:</strong> Required for the website to function correctly.</li>
    <li><strong>Analytics cookies:</strong> Help us understand how visitors interact with our site (e.g., Google Analytics).</li>
  </ul>
  <p>You can control or disable cookies through your browser settings at any time.</p>

  <h2>6. Data Retention</h2>
  <p>We retain your personal data for as long as necessary to fulfil the purposes for which it was collected, or as required by law. Order information is typically retained for up to 7 years for tax and legal compliance purposes.</p>

  <h2>7. Your Rights</h2>
  <p>Under UK GDPR, you have the right to:</p>
  <ul>
    <li>Access the personal data we hold about you</li>
    <li>Request correction of inaccurate data</li>
    <li>Request deletion of your data (the &ldquo;right to be forgotten&rdquo;)</li>
    <li>Object to or restrict how we process your data</li>
    <li>Data portability (receive your data in a structured format)</li>
    <li>Withdraw consent at any time (where processing is based on consent)</li>
  </ul>
  <p>To exercise any of these rights, please contact us at: <?php if($email): ?><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a><?php else: ?>the email address on our Contact page<?php endif; ?>.</p>

  <h2>8. Third-Party Services</h2>
  <p>We may use the following third-party services which have their own privacy policies:</p>
  <ul>
    <li><strong>Google Analytics:</strong> Website usage tracking</li>
    <li><strong>WhatsApp Business:</strong> Customer communications (Meta&rsquo;s Privacy Policy applies)</li>
    <li><strong>Payment Processors:</strong> Payment processing (their respective policies apply)</li>
  </ul>

  <h2>9. Security</h2>
  <p>We take reasonable steps to protect your personal data from unauthorised access, loss, or misuse. However, no internet transmission is completely secure, and we cannot guarantee absolute security.</p>

  <h2>10. Children&rsquo;s Privacy</h2>
  <p>Our services are not directed at children under the age of 16. We do not knowingly collect personal data from children.</p>

  <h2>11. Changes to This Policy</h2>
  <p>We may update this Privacy Policy from time to time. Any changes will be posted on this page with an updated &ldquo;Last Updated&rdquo; date. Continued use of our website after any changes constitutes acceptance of the updated policy.</p>

  <h2>12. Contact Us</h2>
  <p>For any questions about this Privacy Policy or to exercise your rights, please contact us at:</p>
  <p><?php echo esc_html($business); ?><?php if($email): ?><br><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a><?php endif; ?></p>
  <p>You also have the right to lodge a complaint with the UK Information Commissioner&rsquo;s Office (ICO) at <a href="https://ico.org.uk" target="_blank" rel="noopener noreferrer">ico.org.uk</a> if you believe your data has been handled unlawfully.</p>
</div>

<?php get_footer(); ?>
