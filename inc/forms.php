<?php
/**
 * Asantey Hair & Beauty — Form Handlers (AJAX, validation, email)
 */

defined( 'ABSPATH' ) || exit;

/* ============================================================
   CONTACT FORM
   ============================================================ */
add_action( 'wp_ajax_ah_contact_form',        'ah_handle_contact_form' );
add_action( 'wp_ajax_nopriv_ah_contact_form', 'ah_handle_contact_form' );

function ah_handle_contact_form(): void {
    check_ajax_referer( 'ah_forms_nonce', 'nonce' );

    // Honeypot check
    if ( ! empty( $_POST['ah_hp'] ) ) {
        wp_send_json_error( [ 'message' => 'Bot detected.' ] );
    }

    $name    = sanitize_text_field( $_POST['name']    ?? '' );
    $email   = sanitize_email(      $_POST['email']   ?? '' );
    $phone   = sanitize_text_field( $_POST['phone']   ?? '' );
    $message = sanitize_textarea_field( $_POST['message'] ?? '' );

    // Validation
    $errors = [];
    if ( strlen( $name ) < 2 )        $errors[] = 'Please enter your full name.';
    if ( ! is_email( $email ) )        $errors[] = 'Please enter a valid email address.';
    if ( strlen( $message ) < 10 )     $errors[] = 'Please enter a message (at least 10 characters).';

    if ( $errors ) {
        wp_send_json_error( [ 'message' => implode( ' ', $errors ) ] );
    }

    $to      = get_theme_mod( 'ah_contact_email', get_option( 'admin_email' ) );
    $subject = 'New Contact Enquiry — ' . $name;
    $body    = "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\n\nMessage:\n{$message}";
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>',
    ];

    $sent = wp_mail( $to, $subject, $body, $headers );

    if ( $sent ) {
        // Auto-reply
        $auto_body = "Hi {$name},\n\nThank you for reaching out to Asantey Hair & Beauty. We've received your message and will get back to you within 24 hours.\n\nFor urgent enquiries, WhatsApp us directly.\n\nWarm regards,\nAsantey Hair & Beauty Team";
        wp_mail( $email, 'Thanks for contacting Asantey Hair & Beauty', $auto_body, [ 'Content-Type: text/plain; charset=UTF-8' ] );
        wp_send_json_success( [ 'message' => 'Thank you! We\'ll be in touch within 24 hours.' ] );
    } else {
        wp_send_json_error( [ 'message' => 'Something went wrong. Please WhatsApp us directly.' ] );
    }
}

/* ============================================================
   ORDER ENQUIRY FORM
   ============================================================ */
add_action( 'wp_ajax_ah_order_form',        'ah_handle_order_form' );
add_action( 'wp_ajax_nopriv_ah_order_form', 'ah_handle_order_form' );

function ah_handle_order_form(): void {
    check_ajax_referer( 'ah_forms_nonce', 'nonce' );

    if ( ! empty( $_POST['ah_hp'] ) ) {
        wp_send_json_error( [ 'message' => 'Bot detected.' ] );
    }

    $name     = sanitize_text_field(      $_POST['name']     ?? '' );
    $email    = sanitize_email(           $_POST['email']    ?? '' );
    $phone    = sanitize_text_field(      $_POST['phone']    ?? '' );
    $product  = sanitize_text_field(      $_POST['product']  ?? '' );
    $texture  = sanitize_text_field(      $_POST['texture']  ?? '' );
    $length   = sanitize_text_field(      $_POST['length']   ?? '' );
    $quantity = absint(                   $_POST['quantity'] ?? 1 );
    $notes    = sanitize_textarea_field(  $_POST['notes']    ?? '' );

    $errors = [];
    if ( strlen( $name ) < 2 )   $errors[] = 'Please enter your full name.';
    if ( ! is_email( $email ) )   $errors[] = 'Please enter a valid email address.';
    if ( ! $product )             $errors[] = 'Please select a product category.';
    if ( ! $texture )             $errors[] = 'Please select a texture.';
    if ( ! $length )              $errors[] = 'Please select a length.';

    if ( $errors ) {
        wp_send_json_error( [ 'message' => implode( ' ', $errors ) ] );
    }

    $to      = get_theme_mod( 'ah_contact_email', get_option( 'admin_email' ) );
    $subject = 'New Order Enquiry — ' . $name . ' (' . $product . ')';
    $body    = "ORDER ENQUIRY\n\n"
             . "Name:     {$name}\n"
             . "Email:    {$email}\n"
             . "Phone:    {$phone}\n\n"
             . "Product:  {$product}\n"
             . "Texture:  {$texture}\n"
             . "Length:   {$length}\"\n"
             . "Quantity: {$quantity} bundle(s)\n\n"
             . "Notes:\n{$notes}";
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>',
    ];

    $sent = wp_mail( $to, $subject, $body, $headers );

    if ( $sent ) {
        $auto_body = "Hi {$name},\n\nThank you for your order enquiry! Here's a summary:\n\n"
                   . "Product:  {$product}\n"
                   . "Texture:  {$texture}\n"
                   . "Length:   {$length}\"\n"
                   . "Quantity: {$quantity} bundle(s)\n\n"
                   . "We'll confirm availability and send you a payment link within 24 hours. Your hair will ship within 2-3 business days of payment.\n\n"
                   . "For faster service, reply to this email or WhatsApp us directly.\n\n"
                   . "Warm regards,\nAsantey Hair & Beauty Team";
        wp_mail( $email, 'Your Order Enquiry — Asantey Hair & Beauty', $auto_body, [ 'Content-Type: text/plain; charset=UTF-8' ] );
        wp_send_json_success( [ 'message' => 'Order received! We\'ll confirm availability within 24 hours and send your invoice.' ] );
    } else {
        wp_send_json_error( [ 'message' => 'Something went wrong. Please WhatsApp us to place your order directly.' ] );
    }
}

/* ============================================================
   NEWSLETTER FORM
   ============================================================ */
add_action( 'wp_ajax_ah_newsletter',        'ah_handle_newsletter' );
add_action( 'wp_ajax_nopriv_ah_newsletter', 'ah_handle_newsletter' );

function ah_handle_newsletter(): void {
    check_ajax_referer( 'ah_forms_nonce', 'nonce' );

    if ( ! empty( $_POST['ah_hp'] ) ) {
        wp_send_json_error( [ 'message' => 'Bot detected.' ] );
    }

    $email = sanitize_email( $_POST['email'] ?? '' );

    if ( ! is_email( $email ) ) {
        wp_send_json_error( [ 'message' => 'Please enter a valid email address.' ] );
    }

    // Store subscriber in WP options (simple — replace with Mailchimp/ConvertKit in production)
    $subscribers = get_option( 'ah_newsletter_subscribers', [] );
    if ( ! in_array( $email, $subscribers, true ) ) {
        $subscribers[] = $email;
        update_option( 'ah_newsletter_subscribers', $subscribers );
    }

    $to      = get_theme_mod( 'ah_contact_email', get_option( 'admin_email' ) );
    wp_mail( $to, 'New Newsletter Subscriber', "New subscriber: {$email}" );

    $auto_body = "Welcome to the Asantey Hair & Beauty community!\n\nYou'll be the first to know about new arrivals, exclusive offers, and hair care tips.\n\nWarm regards,\nAsantey Hair & Beauty Team";
    wp_mail( $email, 'Welcome to Asantey Hair & Beauty', $auto_body, [ 'Content-Type: text/plain; charset=UTF-8' ] );

    wp_send_json_success( [ 'message' => 'You\'re in! Check your inbox for a welcome message.' ] );
}

/* ============================================================
   FORM RENDERER HELPERS
   ============================================================ */
function ah_contact_form( string $action = 'ah_contact_form', string $submit_label = 'Send Message' ): void {
    ?>
    <form class="ah-form ah-contact-form" data-action="<?php echo esc_attr( $action ); ?>" novalidate>
        <div class="ah-hp-field" aria-hidden="true">
            <input type="text" name="ah_hp" tabindex="-1" autocomplete="off" value="">
        </div>
        <div class="ah-form-grid">
            <div class="ah-form-group">
                <label class="ah-form-label" for="ah-name">Full Name *</label>
                <input type="text" id="ah-name" name="name" class="ah-form-control" required placeholder="Your full name">
            </div>
            <div class="ah-form-group">
                <label class="ah-form-label" for="ah-email">Email Address *</label>
                <input type="email" id="ah-email" name="email" class="ah-form-control" required placeholder="your@email.com">
            </div>
        </div>
        <div class="ah-form-group">
            <label class="ah-form-label" for="ah-phone">Phone / WhatsApp</label>
            <input type="tel" id="ah-phone" name="phone" class="ah-form-control" placeholder="+44 7xxx xxxxxx">
        </div>
        <div class="ah-form-group">
            <label class="ah-form-label" for="ah-message">Message *</label>
            <textarea id="ah-message" name="message" class="ah-form-control" required placeholder="How can we help you?"></textarea>
        </div>
        <div class="ah-form-msg ah-form-msg--success" role="alert"></div>
        <div class="ah-form-msg ah-form-msg--error" role="alert"></div>
        <button type="submit" class="ah-btn ah-btn--primary">
            <?php echo esc_html( $submit_label ); ?>
            <?php echo ah_svg( 'arrow-right' ); ?>
        </button>
    </form>
    <?php
}

function ah_order_form(): void {
    $textures = ah_textures_list();
    $lengths  = ['10','12','14','16','18','20','22','24','26','28','30'];
    ?>
    <form class="ah-form ah-order-form" data-action="ah_order_form" novalidate>
        <div class="ah-hp-field" aria-hidden="true">
            <input type="text" name="ah_hp" tabindex="-1" autocomplete="off" value="">
        </div>
        <div class="ah-form-grid">
            <div class="ah-form-group">
                <label class="ah-form-label" for="ord-name">Full Name *</label>
                <input type="text" id="ord-name" name="name" class="ah-form-control" required placeholder="Your full name">
            </div>
            <div class="ah-form-group">
                <label class="ah-form-label" for="ord-email">Email Address *</label>
                <input type="email" id="ord-email" name="email" class="ah-form-control" required placeholder="your@email.com">
            </div>
        </div>
        <div class="ah-form-group">
            <label class="ah-form-label" for="ord-phone">Phone / WhatsApp *</label>
            <input type="tel" id="ord-phone" name="phone" class="ah-form-control" required placeholder="+44 7xxx xxxxxx">
        </div>
        <div class="ah-form-grid">
            <div class="ah-form-group">
                <label class="ah-form-label" for="ord-product">Product Category *</label>
                <select id="ord-product" name="product" class="ah-form-control" required>
                    <option value="">Select category</option>
                    <option value="Cambodian Raw Hair">Cambodian Raw Hair</option>
                    <option value="Cambodian Virgin Hair">Cambodian Virgin Hair</option>
                    <option value="HD Lace Closure">HD Lace Closure</option>
                    <option value="HD Lace Frontal">HD Lace Frontal</option>
                </select>
            </div>
            <div class="ah-form-group">
                <label class="ah-form-label" for="ord-texture">Texture *</label>
                <select id="ord-texture" name="texture" class="ah-form-control" required>
                    <option value="">Select texture</option>
                    <?php foreach ( $textures as $slug => $label ) : ?>
                        <option value="<?php echo esc_attr( $label ); ?>"><?php echo esc_html( $label ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="ah-form-grid">
            <div class="ah-form-group">
                <label class="ah-form-label" for="ord-length">Length *</label>
                <select id="ord-length" name="length" class="ah-form-control" required>
                    <option value="">Select length</option>
                    <?php foreach ( $lengths as $l ) : ?>
                        <option value="<?php echo esc_attr( $l ); ?>"><?php echo esc_html( $l ); ?>"</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="ah-form-group">
                <label class="ah-form-label" for="ord-quantity">Number of Bundles</label>
                <select id="ord-quantity" name="quantity" class="ah-form-control">
                    <?php for ( $i = 1; $i <= 10; $i++ ) : ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        <div class="ah-form-group">
            <label class="ah-form-label" for="ord-notes">Additional Notes</label>
            <textarea id="ord-notes" name="notes" class="ah-form-control" placeholder="Closure size, colour preference, special requests…"></textarea>
        </div>
        <div class="ah-form-msg ah-form-msg--success" role="alert"></div>
        <div class="ah-form-msg ah-form-msg--error" role="alert"></div>
        <button type="submit" class="ah-btn ah-btn--gold ah-btn--lg">
            Submit Order Enquiry <?php echo ah_svg( 'arrow-right' ); ?>
        </button>
    </form>
    <?php
}

function ah_newsletter_form(): void {
    ?>
    <form class="ah-form ah-newsletter-form" data-action="ah_newsletter" novalidate>
        <div class="ah-hp-field" aria-hidden="true">
            <input type="text" name="ah_hp" tabindex="-1" autocomplete="off" value="">
        </div>
        <div style="display:flex;gap:var(--ah-space-3);flex-wrap:wrap;">
            <input type="email" name="email" class="ah-form-control" required
                   placeholder="Your email address"
                   style="flex:1;min-width:220px;">
            <button type="submit" class="ah-btn ah-btn--gold">Subscribe</button>
        </div>
        <div class="ah-form-msg ah-form-msg--success" role="alert" style="margin-top:var(--ah-space-3);"></div>
        <div class="ah-form-msg ah-form-msg--error"   role="alert" style="margin-top:var(--ah-space-3);"></div>
    </form>
    <?php
}
