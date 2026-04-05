<?php
/**
 * Template Name: Terms & Conditions
 * Asantey Hair & Beauty
 */
get_header();
echo ah_schema_breadcrumb([['name'=>'Home','url'=>home_url('/')],['name'=>'Terms &amp; Conditions','url'=>get_permalink()]]);
$business = get_theme_mod('ah_contact_name','Asantey Hair & Beauty');
$email    = get_theme_mod('ah_contact_email','');
$url      = home_url('/');
?>
<section class="page-hero"><div class="page-hero__content"><span class="t-label">Legal</span><h1 class="t-h1">Terms &amp; Conditions</h1></div></section>
<?php ah_breadcrumb(); ?>

<div class="legal">
  <p class="date">Last Updated: January 2024</p>

  <h2>1. Introduction</h2>
  <p>These Terms and Conditions govern your use of the <?php echo esc_html($business); ?> website at <?php echo esc_url($url); ?> and your purchase of products from us. By using our website or placing an order, you agree to be bound by these terms. Please read them carefully.</p>

  <h2>2. About Us</h2>
  <p><?php echo esc_html($business); ?> is a UK-based business specialising in premium Cambodian hair extensions, HD lace closures, and frontals. We operate online and take orders via our website and WhatsApp.</p>

  <h2>3. Products</h2>
  <p>All product descriptions, images, and pricing on our website are as accurate as possible. However, we reserve the right to correct any errors and to update product information at any time. Product images are for illustrative purposes; natural hair products may have slight variations in shade, texture, or appearance.</p>

  <h2>4. Ordering</h2>
  <p>Orders can be placed via our Order Enquiry form or directly via WhatsApp. Your order is not confirmed until you have received a written confirmation from us and payment has been received. We reserve the right to decline any order at our discretion.</p>

  <h2>5. Pricing</h2>
  <p>All prices are listed in pounds sterling (GBP) and are correct at the time of publication. We reserve the right to change prices at any time. If a pricing error is discovered after your order is placed, we will contact you before processing your order.</p>

  <h2>6. Payment</h2>
  <p>Full payment is required before orders are dispatched. Payment details are provided with your invoice. We accept bank transfer and major debit/credit cards. All payments must clear before the order is processed.</p>

  <h2>7. Delivery</h2>
  <p>We aim to dispatch all orders within 2–3 business days of confirmed payment. Delivery timeframes are estimates and are not guaranteed. We are not liable for delays caused by the courier, customs, or circumstances beyond our control. Please refer to our <a href="<?php echo esc_url(home_url('/shipping-returns/')); ?>">Shipping &amp; Returns page</a> for full details.</p>

  <h2>8. Returns &amp; Refunds</h2>
  <p>Due to hygiene reasons, we cannot accept returns on opened hair products. Defective or incorrectly described items must be reported within 48 hours of delivery with photographic evidence. Please refer to our <a href="<?php echo esc_url(home_url('/shipping-returns/')); ?>">Shipping &amp; Returns page</a> for the full policy.</p>

  <h2>9. Intellectual Property</h2>
  <p>All content on this website — including text, images, logos, and design — is the intellectual property of <?php echo esc_html($business); ?> or its licensors. You may not reproduce, distribute, or use any content without our prior written permission.</p>

  <h2>10. Disclaimer</h2>
  <p>Our website and products are provided &ldquo;as is&rdquo; without warranties of any kind, express or implied. We do not guarantee uninterrupted, error-free access to our website. We are not responsible for any indirect, consequential, or incidental damages arising from your use of our products or website.</p>

  <h2>11. Limitation of Liability</h2>
  <p>To the maximum extent permitted by law, our total liability to you for any claim arising from your use of our products or services shall not exceed the amount you paid for the specific product or service that is the subject of the claim.</p>

  <h2>12. Privacy</h2>
  <p>Your use of this website is also governed by our <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a>, which is incorporated into these Terms by reference.</p>

  <h2>13. Governing Law</h2>
  <p>These Terms and Conditions are governed by the laws of England and Wales. Any disputes arising from these terms shall be subject to the exclusive jurisdiction of the English courts.</p>

  <h2>14. Changes to Terms</h2>
  <p>We may update these Terms and Conditions at any time. Continued use of our website after any changes constitutes acceptance of the updated terms.</p>

  <h2>15. Contact</h2>
  <p>For any questions regarding these Terms, please contact us at:</p>
  <p><?php echo esc_html($business); ?><?php if($email): ?><br><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a><?php endif; ?></p>
</div>

<?php get_footer(); ?>
