<?php
/**
 * Asantey Hair & Beauty — Page Options System
 * Adds editable meta boxes to every page in WP Admin.
 * Every image, every text field, every section is editable here.
 * No plugin required.
 */
defined( 'ABSPATH' ) || exit;

/* ============================================================
   HELPER FUNCTIONS — use in templates
   ============================================================ */

/** Get any text/textarea field for the current page */
function ah_opt( string $key, string $fallback = '' ): string {
    return get_post_meta( get_the_ID(), '_ahp_' . $key, true ) ?: $fallback;
}

/** Get an image array for the current page. Returns ['id','url','full','alt'] or [] */
function ah_opt_img( string $key ): array {
    $id = absint( get_post_meta( get_the_ID(), '_ahp_img_' . $key, true ) );
    if ( ! $id ) return [];
    return [
        'id'  => $id,
        'url' => wp_get_attachment_image_url( $id, 'large' )  ?: '',
        'full'=> wp_get_attachment_image_url( $id, 'full' )   ?: '',
        'alt' => get_post_meta( $id, '_wp_attachment_image_alt', true ) ?: '',
    ];
}

/** Print an <img> tag from a page option image, with a fallback src */
function ah_opt_img_tag( string $key, string $fallback_src, string $alt = '', string $class = '', string $loading = 'lazy' ): void {
    $img = ah_opt_img( $key );
    $src = $img['url'] ?: $fallback_src;
    $a   = $img['alt'] ?: $alt;
    echo '<img src="' . esc_url($src) . '" alt="' . esc_attr($a) . '"'
       . ( $class   ? ' class="' . esc_attr($class) . '"' : '' )
       . ' loading="' . esc_attr($loading) . '" width="1280" height="640">';
}

/* ============================================================
   ADMIN STYLES + MEDIA JS — loaded once
   ============================================================ */
add_action( 'admin_enqueue_scripts', function ( $hook ) {
    if ( ! in_array( $hook, ['post.php','post-new.php'] ) ) return;
    wp_enqueue_media();
    ?>
    <style>
    .ahp-box { font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif; }
    .ahp-section { border: 1px solid #e2e4e7; border-radius: 4px; margin-bottom: 16px; overflow: hidden; }
    .ahp-section-head { background: #f6f7f7; padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #50575e; border-bottom: 1px solid #e2e4e7; }
    .ahp-section-body { padding: 16px; display: grid; gap: 14px; }
    .ahp-cols-2 { grid-template-columns: 1fr 1fr; }
    .ahp-cols-3 { grid-template-columns: 1fr 1fr 1fr; }
    .ahp-field { display: flex; flex-direction: column; gap: 5px; }
    .ahp-field label { font-size: 12px; font-weight: 600; color: #1d2327; }
    .ahp-field .ahp-hint { font-size: 11px; color: #8c8f94; font-style: italic; }
    .ahp-field input[type=text], .ahp-field input[type=url], .ahp-field input[type=number], .ahp-field textarea, .ahp-field select { width: 100%; padding: 6px 10px; border: 1px solid #8c8f94; border-radius: 3px; font-size: 13px; color: #2c3338; background: #fff; box-sizing: border-box; }
    .ahp-field textarea { min-height: 72px; resize: vertical; line-height: 1.5; }
    .ahp-field input[type=number] { width: 110px; }
    /* Image picker */
    .ahp-img-row { display: flex; align-items: flex-start; gap: 12px; flex-wrap: wrap; }
    .ahp-img-thumb { width: 96px; height: 96px; object-fit: cover; border: 1px solid #e2e4e7; border-radius: 3px; background: #f0f0f1; display: block; }
    .ahp-img-thumb.empty { opacity: .3; }
    .ahp-img-actions { display: flex; flex-direction: column; gap: 6px; padding-top: 4px; }
    .ahp-img-actions .button { font-size: 12px; padding: 4px 10px; height: auto; line-height: 1.6; }
    /* Repeat items */
    .ahp-repeat-item { background: #f9f9f9; border: 1px solid #e2e4e7; border-radius: 3px; padding: 14px; margin-bottom: 8px; position: relative; }
    .ahp-repeat-item:last-child { margin-bottom: 0; }
    .ahp-del-btn { position: absolute; top: 8px; right: 8px; background: none; border: 1px solid #c3c4c7; color: #8c8f94; border-radius: 3px; padding: 2px 8px; font-size: 11px; cursor: pointer; line-height: 1.6; }
    .ahp-del-btn:hover { background: #cc1818; color: #fff; border-color: #cc1818; }
    .ahp-add-btn { margin-top: 10px; }
    </style>
    <script>
    /* Image picker */
    window.ahpPickImg = function(previewId, inputId) {
        var frame = wp.media({
            title: 'Select Image', multiple: false,
            button: { text: 'Use this image' },
            library: { type: 'image' }
        });
        frame.on('select', function() {
            var att = frame.state().get('selection').first().toJSON();
            var src = (att.sizes && att.sizes.medium) ? att.sizes.medium.url : att.url;
            var prev = document.getElementById(previewId);
            var inp  = document.getElementById(inputId);
            if (prev) { prev.src = src; prev.classList.remove('empty'); }
            if (inp)  inp.value = att.id;
        });
        frame.open();
    };
    window.ahpRemoveImg = function(previewId, inputId, placeholder) {
        var prev = document.getElementById(previewId);
        var inp  = document.getElementById(inputId);
        if (prev) { prev.src = placeholder||''; prev.classList.add('empty'); }
        if (inp)  inp.value = '';
    };
    /* Repeat-item delete */
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('ahp-del-btn')) {
            if (confirm('Remove this item?')) e.target.closest('.ahp-repeat-item').remove();
        }
    });
    </script>
    <?php
} );

/* ============================================================
   RENDER HELPERS
   ============================================================ */
function _ahp_text( string $key, string $label, string $default = '', string $hint = '' ): void {
    global $post;
    $v = get_post_meta( $post->ID, '_ahp_' . $key, true );
    if ( $v === '' || $v === false ) $v = $default;
    echo '<div class="ahp-field">';
    echo '<label>' . esc_html($label) . '</label>';
    echo '<input type="text" name="ahp[' . esc_attr($key) . ']" value="' . esc_attr($v) . '">';
    if ($hint) echo '<span class="ahp-hint">' . esc_html($hint) . '</span>';
    echo '</div>';
}

function _ahp_textarea( string $key, string $label, string $default = '', string $hint = '' ): void {
    global $post;
    $v = get_post_meta( $post->ID, '_ahp_' . $key, true );
    if ( $v === '' || $v === false ) $v = $default;
    echo '<div class="ahp-field">';
    echo '<label>' . esc_html($label) . '</label>';
    echo '<textarea name="ahp[' . esc_attr($key) . ']">' . esc_textarea($v) . '</textarea>';
    if ($hint) echo '<span class="ahp-hint">' . esc_html($hint) . '</span>';
    echo '</div>';
}

function _ahp_number( string $key, string $label, string $default = '' ): void {
    global $post;
    $v = get_post_meta( $post->ID, '_ahp_' . $key, true );
    if ( $v === '' || $v === false ) $v = $default;
    echo '<div class="ahp-field">';
    echo '<label>' . esc_html($label) . '</label>';
    echo '<input type="number" step="0.01" min="0" name="ahp[' . esc_attr($key) . ']" value="' . esc_attr($v) . '">';
    echo '</div>';
}

function _ahp_img( string $key, string $label, string $hint = '' ): void {
    global $post;
    $id   = absint( get_post_meta( $post->ID, '_ahp_img_' . $key, true ) );
    $src  = $id ? wp_get_attachment_image_url( $id, 'medium' ) : '';
    $pid  = 'ahp_prev_' . $key;
    $iid  = 'ahp_inp_'  . $key;
    $ph   = admin_url('images/media-button.png');
    echo '<div class="ahp-field">';
    echo '<label>' . esc_html($label) . '</label>';
    echo '<div class="ahp-img-row">';
    echo '<img id="' . esc_attr($pid) . '" src="' . esc_url($src) . '" class="ahp-img-thumb' . ($src?'':' empty') . '" alt="' . esc_attr($label) . '">';
    echo '<div class="ahp-img-actions">';
    echo '<button type="button" class="button" onclick="ahpPickImg(\'' . esc_js($pid) . '\',\'' . esc_js($iid) . '\')">📁 Choose Image</button>';
    if ($src) echo '<button type="button" class="button" onclick="ahpRemoveImg(\'' . esc_js($pid) . '\',\'' . esc_js($iid) . '\',\'' . esc_js($ph) . '\')">✕ Remove</button>';
    echo '</div>';
    echo '</div>';
    echo '<input type="hidden" name="ahp_img[' . esc_attr($key) . ']" id="' . esc_attr($iid) . '" value="' . esc_attr($id) . '">';
    if ($hint) echo '<span class="ahp-hint">' . esc_html($hint) . '</span>';
    echo '</div>';
}

function _ahp_section( string $title, string ...$classes ): void {
    $cls = implode(' ', array_merge(['ahp-section-body'], $classes));
    echo '<div class="ahp-section"><div class="ahp-section-head">' . esc_html($title) . '</div>';
    echo '<div class="' . esc_attr($cls) . '">';
}

function _ahp_section_end(): void { echo '</div></div>'; }

/* ============================================================
   SAVE
   ============================================================ */
add_action( 'save_post_page', function ( int $post_id ) {
    if ( ! isset($_POST['_ahp_nonce']) ) return;
    if ( ! wp_verify_nonce($_POST['_ahp_nonce'], 'ahp_save_' . $post_id) ) return;
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    if ( ! current_user_can('edit_post', $post_id) ) return;

    // Text / textarea fields
    if ( ! empty($_POST['ahp']) && is_array($_POST['ahp']) ) {
        foreach ( $_POST['ahp'] as $key => $val ) {
            $key = sanitize_key( $key );
            if ( is_array($val) ) {
                update_post_meta( $post_id, '_ahp_' . $key, array_map('sanitize_textarea_field', $val) );
            } else {
                update_post_meta( $post_id, '_ahp_' . $key, sanitize_textarea_field($val) );
            }
        }
    }

    // Image attachment IDs
    if ( ! empty($_POST['ahp_img']) && is_array($_POST['ahp_img']) ) {
        foreach ( $_POST['ahp_img'] as $key => $val ) {
            update_post_meta( $post_id, '_ahp_img_' . sanitize_key($key), absint($val) );
        }
    }
}, 10 );

/* ============================================================
   REGISTER META BOXES
   ============================================================ */
add_action( 'add_meta_boxes_page', function ( WP_Post $post ) {
    $template    = get_post_meta( $post->ID, '_wp_page_template', true );
    $is_front    = (int) get_option('page_on_front') === $post->ID;

    // Nonce box (invisible, at top)
    add_meta_box( '_ahp_nonce_box', '', function( $p ) {
        wp_nonce_field( 'ahp_save_' . $p->ID, '_ahp_nonce' );
    }, 'page', 'normal', 'high' );

    // ── HOMEPAGE ────────────────────────────────────────
    if ( $is_front ) {
        add_meta_box( 'ahp_home_hero',         '🎬 Hero Slides',                          'ahp_cb_home_hero',         'page', 'normal', 'high' );
        add_meta_box( 'ahp_home_cats',         '🗂 Category Cards (Our Collections)',      'ahp_cb_home_cats',         'page', 'normal', 'high' );
        add_meta_box( 'ahp_home_why',          '✅ Why Asantey Features',                  'ahp_cb_home_why',          'page', 'normal', 'high' );
        add_meta_box( 'ahp_home_story',        '📖 Brand Story',                           'ahp_cb_home_story',        'page', 'normal', 'high' );
        add_meta_box( 'ahp_home_gallery',      '🖼 Homepage Gallery Images',               'ahp_cb_home_gallery',      'page', 'normal', 'high' );
        add_meta_box( 'ahp_home_testimonials', '💬 Testimonials',                          'ahp_cb_home_testimonials', 'page', 'normal', 'high' );
        add_meta_box( 'ahp_home_cta',          '📣 CTA Band',                              'ahp_cb_home_cta',          'page', 'normal', 'high' );
        add_meta_box( 'ahp_home_marquee',      '📰 Marquee Trust Strip',                   'ahp_cb_home_marquee',      'page', 'normal', 'high' );
    }

    // ── ALL INNER PAGES — shared hero ───────────────────
    $inner_templates = [
        'page-templates/page-raw-hair.php',
        'page-templates/page-virgin-hair.php',
        'page-templates/page-closures.php',
        'page-templates/page-salon.php',
        'page-templates/page-gallery.php',
        'page-templates/page-about.php',
        'page-templates/page-contact.php',
        'page-templates/page-faq.php',
        'page-templates/page-shop.php',
        'page-templates/page-order.php',
        'page-templates/page-care-guide.php',
        'page-templates/page-shipping.php',
        'page-templates/page-privacy.php',
        'page-templates/page-terms.php',
    ];
    if ( in_array($template, $inner_templates) ) {
        add_meta_box( 'ahp_page_hero', '🖼 Page Hero — Image, Title & Subtitle', 'ahp_cb_page_hero', 'page', 'normal', 'high' );
    }

    // ── PAGE-SPECIFIC ────────────────────────────────────
    switch ( $template ) {
        case 'page-templates/page-raw-hair.php':
            add_meta_box( 'ahp_raw_textures', '🎨 Raw Hair — Texture Grid Images',   'ahp_cb_raw_textures',  'page', 'normal', 'default' );
            add_meta_box( 'ahp_raw_pricing',  '💷 Raw Hair — Pricing Table',         'ahp_cb_raw_pricing',   'page', 'normal', 'default' );
            break;
        case 'page-templates/page-virgin-hair.php':
            add_meta_box( 'ahp_vir_textures', '🎨 Virgin Hair — Texture Grid Images', 'ahp_cb_vir_textures', 'page', 'normal', 'default' );
            add_meta_box( 'ahp_vir_pricing',  '💷 Virgin Hair — Pricing Table',       'ahp_cb_vir_pricing',  'page', 'normal', 'default' );
            break;
        case 'page-templates/page-closures.php':
            add_meta_box( 'ahp_cls_images',   '🎨 Closures — Guide Images',          'ahp_cb_cls_images',    'page', 'normal', 'default' );
            break;
        case 'page-templates/page-salon.php':
            add_meta_box( 'ahp_salon_svcs',   '💇 Salon — Service Cards',            'ahp_cb_salon_svcs',    'page', 'normal', 'default' );
            add_meta_box( 'ahp_salon_split',  '📸 Salon — Story Section Images',     'ahp_cb_salon_split',   'page', 'normal', 'default' );
            break;
        case 'page-templates/page-about.php':
            add_meta_box( 'ahp_about',        '🏢 About — Content & Images',         'ahp_cb_about',         'page', 'normal', 'default' );
            break;
        case 'page-templates/page-contact.php':
            add_meta_box( 'ahp_contact',      '📞 Contact — Details & Map',          'ahp_cb_contact',       'page', 'normal', 'default' );
            break;
        case 'page-templates/page-faq.php':
            add_meta_box( 'ahp_faq',          '❓ FAQ — Questions & Answers',         'ahp_cb_faq',           'page', 'normal', 'default' );
            break;
        case 'page-templates/page-shop.php':
            add_meta_box( 'ahp_shop_intro',   '🛍 Shop — Intro Text',                'ahp_cb_shop_intro',    'page', 'normal', 'default' );
            break;
    }
} );

/* ============================================================
   BOX CALLBACKS
   ============================================================ */

/* ── HOMEPAGE: HERO ──────────────────────────────────────── */
function ahp_cb_home_hero(): void {
    echo '<div class="ahp-box">';
    for ( $i = 1; $i <= 3; $i++ ) {
        _ahp_section( "Slide {$i}", 'ahp-cols-2' );
        _ahp_img( "slide{$i}_image", "Slide {$i} Background Image" );
        _ahp_text( "slide{$i}_title",    "Main Title",        $i===1 ? 'Luxury Hair.'      : '' );
        _ahp_text( "slide{$i}_italic",   "Italic Line",       $i===1 ? 'Real Results.'     : '' );
        _ahp_textarea( "slide{$i}_sub",  "Subtitle",          $i===1 ? 'Premium Cambodian Raw and Virgin Hair Extensions.' : '' );
        _ahp_text( "slide{$i}_label",    "Eyebrow Label",     $i===1 ? 'Premium Cambodian Hair Extensions' : '' );
        _ahp_text( "slide{$i}_cta1",     "Button 1 Text",     $i===1 ? 'Shop Collections'  : '' );
        _ahp_text( "slide{$i}_cta1_url", "Button 1 URL",      $i===1 ? '/shop/'             : '' );
        _ahp_text( "slide{$i}_cta2",     "Button 2 Text",     $i===1 ? 'Order on WhatsApp'  : '' );
        _ahp_section_end();
    }
    echo '</div>';
}

/* ── HOMEPAGE: CATEGORY CARDS ────────────────────────────── */
function ahp_cb_home_cats(): void {
    $d = [
        1 => ['label'=>'Raw Hair',   'title'=>'Cambodian Raw Hair',  'tag'=>'Unprocessed. Uncoloured. Unapologetically Premium.', 'from'=>'60','url'=>'/raw-hair/'],
        2 => ['label'=>'Virgin Hair','title'=>'Virgin Hair Bundles', 'tag'=>'Pure Quality. Lasting Beauty. 3-5 Year Lifespan.',   'from'=>'50','url'=>'/virgin-hair/'],
        3 => ['label'=>'HD Lace',    'title'=>'Closures & Frontals', 'tag'=>'Invisible HD Lace. The Perfect Finish.',             'from'=>'49','url'=>'/closures-frontals/'],
    ];
    echo '<div class="ahp-box">';
    _ahp_section( 'Section Heading', 'ahp-cols-2' );
    _ahp_text('cats_label', 'Label',       'Our Collections');
    _ahp_text('cats_title', 'Title',       'The Asantey Standard');
    _ahp_textarea('cats_desc', 'Description', 'Every bundle, closure, and frontal is cuticle-aligned, single-donor, and held to exacting quality standards before it reaches your door.');
    _ahp_section_end();
    foreach ( $d as $i => $c ) {
        _ahp_section( "Card {$i} — {$c['title']}", 'ahp-cols-2' );
        _ahp_img( "cat{$i}_image", "Card {$i} Image" );
        _ahp_text( "cat{$i}_label", "Badge Label",          $c['label'] );
        _ahp_text( "cat{$i}_title", "Card Title",           $c['title'] );
        _ahp_text( "cat{$i}_tag",   "Tagline",              $c['tag']   );
        _ahp_text( "cat{$i}_from",  "From Price (no £)",    $c['from']  );
        _ahp_text( "cat{$i}_url",   "Link URL",             $c['url']   );
        _ahp_section_end();
    }
    echo '</div>';
}

/* ── HOMEPAGE: WHY ───────────────────────────────────────── */
function ahp_cb_home_why(): void {
    $d = [
        1 => ['icon'=>'gem',    'title'=>'Cambodian Origin',    'body'=>'Single-donor Cambodian hair, ethically sourced, never chemically processed.'],
        2 => ['icon'=>'shield', 'title'=>'3-5 Year Lifespan',   'body'=>'Invest once, wear for years. The results speak for themselves.'],
        3 => ['icon'=>'sparkle','title'=>'10+ Textures',         'body'=>'Every texture in 10"-30" lengths. Wear it your way.'],
    ];
    echo '<div class="ahp-box">';
    _ahp_section('Section Heading', 'ahp-cols-2');
    _ahp_text('why_label','Section Label','Why Asantey');
    _ahp_text('why_title','Section Title','Hair That Speaks for Itself');
    _ahp_section_end();
    foreach ( $d as $i => $c ) {
        _ahp_section("Feature {$i}", 'ahp-cols-2');
        _ahp_text("feat{$i}_title","Title",  $c['title']);
        _ahp_text("feat{$i}_icon","Icon (gem/shield/sparkle/check/heart/truck/star)",$c['icon'],'');
        _ahp_textarea("feat{$i}_body","Description",$c['body']);
        _ahp_section_end();
    }
    echo '</div>';
}

/* ── HOMEPAGE: STORY ─────────────────────────────────────── */
function ahp_cb_home_story(): void {
    echo '<div class="ahp-box">';
    _ahp_section('Brand Story Section', 'ahp-cols-2');
    _ahp_text('story_label','Label','Our Story');
    _ahp_text('story_title','Title','The Asantey Standard');
    _ahp_textarea('story_body1','Paragraph 1','Founded on the belief that every woman deserves hair she is genuinely proud of.');
    _ahp_textarea('story_body2','Paragraph 2','What you receive is exactly as nature intended: just better selected, better prepared, and built to last 3-5 years with the right care.');
    _ahp_section_end();
    echo '</div>';
}

/* ── HOMEPAGE: GALLERY ───────────────────────────────────── */
function ahp_cb_home_gallery(): void {
    echo '<div class="ahp-box">';
    _ahp_section('Homepage Gallery — Up to 6 images shown on the homepage', 'ahp-cols-3');
    for ( $i = 1; $i <= 6; $i++ ) {
        _ahp_img("gal_image_{$i}","Gallery Image {$i}");
    }
    _ahp_section_end();
    echo '</div>';
}

/* ── HOMEPAGE: TESTIMONIALS ──────────────────────────────── */
function ahp_cb_home_testimonials(): void {
    $d = [
        1 => ['q'=>'I have been buying hair for over 10 years and Asantey is hands down the best quality I have ever experienced.','a'=>'Naomi A., London'],
        2 => ['q'=>'My 28 inch raw body wave bundle is still going strong 2 years later. Worth every penny.','a'=>'Blessing O., Birmingham'],
        3 => ['q'=>'The HD lace frontal is unreal. My stylist could not believe it was not my natural hairline.','a'=>'Jade K., Manchester'],
    ];
    echo '<div class="ahp-box">';
    _ahp_section('Section Heading', 'ahp-cols-2');
    _ahp_text('test_label','Label','Client Love');
    _ahp_text('test_title','Title','What Our Clients Say');
    _ahp_section_end();
    foreach ( $d as $i => $c ) {
        _ahp_section("Testimonial {$i}", 'ahp-cols-2');
        _ahp_textarea("test{$i}_quote","Quote",$c['q']);
        _ahp_text("test{$i}_author","Author",$c['a']);
        _ahp_section_end();
    }
    echo '</div>';
}

/* ── HOMEPAGE: CTA ───────────────────────────────────────── */
function ahp_cb_home_cta(): void {
    echo '<div class="ahp-box">';
    _ahp_section('CTA Band', 'ahp-cols-2');
    _ahp_text('cta_label','Label','Ready to Elevate Your Look?');
    _ahp_text('cta_title','Title','Your Best Hair Starts Here');
    _ahp_textarea('cta_body','Body Text','Browse our full collection or order directly on WhatsApp.');
    _ahp_text('cta_btn1','Button 1 Text','Shop Collections');
    _ahp_text('cta_btn1_url','Button 1 URL','/shop/');
    _ahp_text('cta_btn2','Button 2 Text (WhatsApp)','WhatsApp Order');
    _ahp_section_end();
    echo '</div>';
}

/* ── HOMEPAGE: MARQUEE ───────────────────────────────────── */
function ahp_cb_home_marquee(): void {
    echo '<div class="ahp-box">';
    _ahp_section('Scrolling Trust Strip');
    _ahp_textarea('marquee_items','One item per line. Format: icon|Text',"sparkle|Premium Cambodian Hair\ngem|HD Lace Specialists\nshield|3-5 Year Lifespan\ncheck|Minimal Shedding\nlocation|UK Based - Nottingham\nheart|Single Donor\nsparkle|Cuticle Aligned\ntruck|Fast UK Dispatch",'Icons: sparkle, gem, shield, check, location, heart, truck, star');
    _ahp_section_end();
    echo '</div>';
}

/* ── SHARED: PAGE HERO ───────────────────────────────────── */
function ahp_cb_page_hero(): void {
    echo '<div class="ahp-box">';
    _ahp_section('Hero Section — appears at the top of this page', 'ahp-cols-2');
    _ahp_img('hero_image','Hero Background Image','Upload a wide landscape photo (recommended: 1920×700px)');
    _ahp_text('hero_label','Small Label (above title)','');
    _ahp_text('hero_title','Hero Title','');
    _ahp_text('hero_subtitle','Subtitle / Tagline','');
    _ahp_section_end();
    echo '</div>';
}

/* ── RAW HAIR: TEXTURE IMAGES ────────────────────────────── */
function ahp_cb_raw_textures(): void {
    $textures = ['straight'=>'Straight','body-wave'=>'Body Wave','loose-wave'=>'Loose Wave','deep-wave'=>'Deep Wave','kinky-straight'=>'Kinky Straight','loose-deep'=>'Loose Deep Wave','burmese-curls'=>'Burmese Curls','waver-wave'=>'Water Wave'];
    echo '<div class="ahp-box">';
    _ahp_section('Texture Grid Images — one image per texture', 'ahp-cols-3');
    foreach ( $textures as $key => $label ) {
        _ahp_img("raw_tex_{$key}", $label);
    }
    _ahp_section_end();
    echo '</div>';
}

/* ── RAW HAIR: PRICING ───────────────────────────────────── */
function ahp_cb_raw_pricing(): void {
    $l = ['10in'=>'60','12in'=>'63','14in'=>'69','16in'=>'75','18in'=>'80','20in'=>'88','22in'=>'95','24in'=>'100','26in'=>'105','28in'=>'110','30in'=>'120'];
    echo '<div class="ahp-box">';
    _ahp_section('Price per length — shown in the pricing table on this page', 'ahp-cols-3');
    foreach ( $l as $len => $def ) {
        _ahp_number("raw_price_{$len}", str_replace('in','"',$len), $def);
    }
    _ahp_section_end();
    echo '</div>';
}

/* ── VIRGIN HAIR: TEXTURE IMAGES ─────────────────────────── */
function ahp_cb_vir_textures(): void {
    $textures = ['straight'=>'Straight','body-wave'=>'Body Wave','loose-wave'=>'Loose Wave','deep-wave'=>'Deep Wave','kinky-straight'=>'Kinky Straight','loose-deep'=>'Loose Deep Wave','burmese-curls'=>'Burmese Curls','waver-wave'=>'Water Wave'];
    echo '<div class="ahp-box">';
    _ahp_section('Texture Grid Images — one image per texture', 'ahp-cols-3');
    foreach ( $textures as $key => $label ) {
        _ahp_img("vir_tex_{$key}", $label);
    }
    _ahp_section_end();
    echo '</div>';
}

/* ── VIRGIN HAIR: PRICING ────────────────────────────────── */
function ahp_cb_vir_pricing(): void {
    $l = ['10in'=>'50','12in'=>'53','14in'=>'59','16in'=>'65','18in'=>'70','20in'=>'78','22in'=>'85','24in'=>'90','26in'=>'95','28in'=>'100','30in'=>'110'];
    echo '<div class="ahp-box">';
    _ahp_section('Price per length — shown in the pricing table on this page', 'ahp-cols-3');
    foreach ( $l as $len => $def ) {
        _ahp_number("vir_price_{$len}", str_replace('in','"',$len), $def);
    }
    _ahp_section_end();
    echo '</div>';
}

/* ── CLOSURES: IMAGES ────────────────────────────────────── */
function ahp_cb_cls_images(): void {
    echo '<div class="ahp-box">';
    _ahp_section('Closures & Frontals Images', 'ahp-cols-2');
    _ahp_img('cls_pricelist',  'Price List / Header Image');
    _ahp_img('cls_size_guide', 'HD Lace Size Guide Image');
    _ahp_section_end();
    echo '</div>';
}

/* ── SALON: SERVICE CARDS ────────────────────────────────── */
function ahp_cb_salon_svcs(): void {
    $svcs = ['braids'=>'Braids','cornrows'=>'Cornrows','hair-treatment'=>'Hair Treatment','sew-in'=>'Sew-In','closure'=>'Closure Install','natural-hair'=>'Natural Hair','lash-extensions'=>'Lash Extensions','eyebrow-wax'=>'Eyebrow Waxing','eyebrow-thread'=>'Eyebrow Threading','knotless-braids'=>'Knotless Braids','goddess-braids'=>'Goddess Braids','wig-install'=>'Wig Install'];
    echo '<div class="ahp-box">';
    foreach ( $svcs as $key => $name ) {
        _ahp_section("Service — {$name}", 'ahp-cols-2');
        _ahp_img("svc_{$key}_image","Service Image");
        _ahp_text("svc_{$key}_title","Title",$name);
        _ahp_text("svc_{$key}_price","Price (e.g. From £45)",'');
        _ahp_textarea("svc_{$key}_desc","Short Description",'');
        _ahp_section_end();
    }
    echo '</div>';
}

/* ── SALON: SPLIT SECTION IMAGES ────────────────────────── */
function ahp_cb_salon_split(): void {
    echo '<div class="ahp-box">';
    _ahp_section('Story / Split Section Images', 'ahp-cols-2');
    _ahp_img('salon_split_img1','Left / Top Image');
    _ahp_img('salon_split_img2','Right / Bottom Image');
    _ahp_section_end();
    echo '</div>';
}

/* ── ABOUT ───────────────────────────────────────────────── */
function ahp_cb_about(): void {
    echo '<div class="ahp-box">';
    _ahp_section('Our Story Section', 'ahp-cols-2');
    _ahp_img('about_image','Story Image');
    _ahp_text('about_label','Label','Our Story');
    _ahp_text('about_title','Title','');
    _ahp_textarea('about_body1','Paragraph 1','');
    _ahp_textarea('about_body2','Paragraph 2','');
    _ahp_section_end();

    _ahp_section('Values / Stats Strip', 'ahp-cols-2');
    for ( $i = 1; $i <= 4; $i++ ) {
        _ahp_text("stat{$i}_num",  "Stat {$i} Number (e.g. 500+)",'');
        _ahp_text("stat{$i}_label","Stat {$i} Label (e.g. Happy Clients)",'');
    }
    _ahp_section_end();
    echo '</div>';
}

/* ── CONTACT ─────────────────────────────────────────────── */
function ahp_cb_contact(): void {
    echo '<div class="ahp-box">';
    _ahp_section('Contact Details', 'ahp-cols-2');
    _ahp_text('phone',   'Phone Number',   '07827 129797');
    _ahp_text('email',   'Email Address',  '');
    _ahp_text('address', 'Address',        '358 Radford Road, Nottingham NG7 5GQ');
    _ahp_text('hours',   'Opening Hours',  'Mon-Sat: 9am – 6pm');
    _ahp_text('wa',      'WhatsApp Number (international format, no +)','447827129797');
    _ahp_text('booking', 'Booking URL',    'https://asanteyhair.as.me/');
    _ahp_section_end();

    _ahp_section('Google Maps Embed');
    _ahp_textarea('map_embed','Paste the src="" URL from Google Maps embed code','','Google Maps > Share > Embed a map > copy only the src URL (starts with https://www.google.com/maps/embed...)');
    _ahp_section_end();
    echo '</div>';
}

/* ── FAQ ─────────────────────────────────────────────────── */
function ahp_cb_faq(): void {
    global $post;
    $items = get_post_meta( $post->ID, '_ahp_faq_items', true );
    $items = is_array($items) ? $items : [['q'=>'','a'=>''],['q'=>'','a'=>''],['q'=>'','a'=>'']];
    echo '<div class="ahp-box">';
    _ahp_section('FAQ Items — add, edit or remove questions');
    echo '</div>'; // close section body early, custom markup below

    echo '<div style="padding:0 0 12px;">';
    echo '<div id="ahp-faq-list">';
    foreach ( $items as $i => $item ) {
        $q = esc_attr($item['q'] ?? '');
        $a = esc_textarea($item['a'] ?? '');
        echo "<div class='ahp-repeat-item'><button type='button' class='ahp-del-btn'>✕ Remove</button>"
           . "<div class='ahp-field'><label>Question</label><input type='text' name='ahp_faq_q[]' value='{$q}'></div>"
           . "<div class='ahp-field'><label>Answer</label><textarea name='ahp_faq_a[]'>{$a}</textarea></div>"
           . "</div>";
    }
    echo '</div>';
    echo '<button type="button" class="button ahp-add-btn" id="ahp-add-faq">+ Add Question</button>';
    echo '<script>document.getElementById("ahp-add-faq").addEventListener("click",function(){
        var d=document.createElement("div"); d.className="ahp-repeat-item";
        d.innerHTML="<button type=\'button\' class=\'ahp-del-btn\'>✕ Remove</button>"
            +"<div class=\'ahp-field\'><label>Question</label><input type=\'text\' name=\'ahp_faq_q[]\'></div>"
            +"<div class=\'ahp-field\'><label>Answer</label><textarea name=\'ahp_faq_a[]\'></textarea></div>";
        document.getElementById("ahp-faq-list").appendChild(d);
    });</script>';
    echo '</div></div>';
}

/* Save FAQ specially */
add_action( 'save_post_page', function ( int $post_id ) {
    if ( ! isset($_POST['_ahp_nonce']) ) return;
    if ( ! wp_verify_nonce($_POST['_ahp_nonce'], 'ahp_save_' . $post_id) ) return;
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    if ( ! current_user_can('edit_post',$post_id) ) return;

    if ( isset($_POST['ahp_faq_q']) ) {
        $qs    = array_map('sanitize_textarea_field', (array)$_POST['ahp_faq_q']);
        $as    = array_map('sanitize_textarea_field', (array)($_POST['ahp_faq_a'] ?? []));
        $items = [];
        foreach ( $qs as $i => $q ) {
            if ( $q === '' && ($as[$i]??'') === '' ) continue;
            $items[] = ['q'=>$q,'a'=>$as[$i]??''];
        }
        update_post_meta( $post_id, '_ahp_faq_items', $items );
    }
}, 20 );

/* ── SHOP: INTRO ─────────────────────────────────────────── */
function ahp_cb_shop_intro(): void {
    echo '<div class="ahp-box">';
    _ahp_section('Shop Page Intro', 'ahp-cols-2');
    _ahp_text('shop_title','Shop Page Title','Shop All Hair');
    _ahp_text('shop_subtitle','Subtitle','Cambodian Raw · Virgin Hair · HD Lace Closures & Frontals');
    _ahp_section_end();
    echo '</div>';
}
