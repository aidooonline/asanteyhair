<?php
/**
 * Asantey Hair & Beauty — Page Options (WYSIWYG Admin Panels)
 * ============================================================
 * One file. Every page. Every section. Every field editable.
 *
 * USAGE IN TEMPLATES:
 *   ah_opt('key','fallback')          — get text/textarea value
 *   ah_opt_img('key')                 — get image array [id,url,full,alt]
 *   ah_opt_img_tag('key','fallback')  — print <img> tag
 *   ah_opt_repeater('key')            — get array of repeater rows
 */
defined('ABSPATH') || exit;

/* ============================================================
   TEMPLATE HELPERS
   ============================================================ */
function ah_opt(string $key, string $fallback = ''): string {
    static $cache = [];
    $pid = get_the_ID();
    $ck  = $pid . '_' . $key;
    if (!isset($cache[$ck])) {
        $v = get_post_meta($pid, '_ahp_' . $key, true);
        $cache[$ck] = ($v !== '' && $v !== false) ? $v : $fallback;
    }
    return $cache[$ck];
}

function ah_opt_img(string $key): array {
    $id = absint(get_post_meta(get_the_ID(), '_ahp_img_' . $key, true));
    if (!$id) return [];
    return [
        'id'   => $id,
        'url'  => wp_get_attachment_image_url($id, 'large') ?: '',
        'full' => wp_get_attachment_image_url($id, 'full')  ?: '',
        'alt'  => get_post_meta($id, '_wp_attachment_image_alt', true) ?: '',
    ];
}

function ah_opt_img_tag(string $key, string $fallback, string $alt = '', string $class = '', string $loading = 'lazy'): void {
    $img = ah_opt_img($key);
    $src = $img['url'] ?: $fallback;
    $a   = $img['alt'] ?: $alt;
    echo '<img src="' . esc_url($src) . '" alt="' . esc_attr($a) . '"'
       . ($class ? ' class="' . esc_attr($class) . '"' : '')
       . ' loading="' . esc_attr($loading) . '">';
}

function ah_opt_repeater(string $key): array {
    $v = get_post_meta(get_the_ID(), '_ahp_rep_' . $key, true);
    return is_array($v) ? $v : [];
}

/* ============================================================
   ADMIN ASSETS
   ============================================================ */
add_action('admin_enqueue_scripts', function(string $hook): void {
    if (!in_array($hook, ['post.php', 'post-new.php'])) return;
    wp_enqueue_media();
    ?>
    <style>
    /* ── Layout ── */
    .ahp { font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;color:#1d2327; }
    .ahp-section { border:1px solid #e2e4e7;border-radius:4px;margin-bottom:14px;overflow:hidden; }
    .ahp-section-head { background:#f6f7f7;padding:9px 14px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#50575e;border-bottom:1px solid #e2e4e7;display:flex;align-items:center;gap:6px; }
    .ahp-body { padding:14px;display:grid;gap:12px; }
    .ahp-col2 { grid-template-columns:1fr 1fr; }
    .ahp-col3 { grid-template-columns:1fr 1fr 1fr; }
    .ahp-col4 { grid-template-columns:1fr 1fr 1fr 1fr; }
    .ahp-full { grid-column:1/-1; }
    /* ── Fields ── */
    .ahp-field { display:flex;flex-direction:column;gap:4px; }
    .ahp-field label { font-size:12px;font-weight:600;color:#1d2327; }
    .ahp-field input[type=text],
    .ahp-field input[type=url],
    .ahp-field input[type=number],
    .ahp-field select,
    .ahp-field textarea { width:100%;padding:6px 9px;border:1px solid #8c8f94;border-radius:3px;font-size:13px;color:#2c3338;background:#fff;box-sizing:border-box; }
    .ahp-field textarea { min-height:72px;resize:vertical;line-height:1.55; }
    .ahp-field input[type=number] { width:110px; }
    .ahp-hint { font-size:11px;color:#8c8f94;line-height:1.4; }
    /* ── Image picker ── */
    .ahp-img-row { display:flex;align-items:flex-start;gap:10px;flex-wrap:wrap; }
    .ahp-img-preview { width:88px;height:88px;object-fit:cover;border:1px solid #e2e4e7;border-radius:3px;background:#f0f0f1;display:block;flex-shrink:0; }
    .ahp-img-preview.ahp-empty { opacity:.25; }
    .ahp-img-btns { display:flex;flex-direction:column;gap:5px;padding-top:2px; }
    .ahp-img-btns .button { font-size:12px;padding:4px 10px;height:auto;line-height:1.5; }
    /* ── Repeater ── */
    .ahp-rep-item { background:#fff;border:1px solid #e2e4e7;border-radius:3px;padding:12px;margin-bottom:8px;position:relative; }
    .ahp-rep-del { position:absolute;top:7px;right:7px;background:none;border:1px solid #c3c4c7;color:#8c8f94;border-radius:3px;padding:2px 8px;font-size:11px;cursor:pointer;line-height:1.6; }
    .ahp-rep-del:hover { background:#cc1818;color:#fff;border-color:#cc1818; }
    .ahp-rep-add { margin-top:8px;font-size:12px; }
    </style>
    <script>
    /* Image picker */
    window.ahpPickSvc = function(prevId, inputId) {
        var frame = wp.media({title:'Select Image',multiple:false,button:{text:'Use this image'},library:{type:'image'}});
        frame.on('select', function(){
            var att = frame.state().get('selection').first().toJSON();
            var url = (att.sizes && att.sizes.thumbnail) ? att.sizes.thumbnail.url : att.url;
            var inp = document.getElementById(inputId);
            if (inp) inp.value = att.id;
            var prev = document.getElementById(prevId);
            if (prev) {
                if (prev.tagName === 'IMG') { prev.src = url; prev.style.display='block'; }
                else { prev.outerHTML = '<img id="'+prevId+'" src="'+url+'" style="width:70px;height:70px;object-fit:cover;">'; }
            }
        });
        frame.open();
    };
    window.ahpRemoveSvc = function(prevId, inputId) {
        var inp = document.getElementById(inputId); if(inp) inp.value = '';
        var prev = document.getElementById(prevId);
        if (prev) {
            if (prev.tagName === 'IMG') { prev.src=''; prev.style.display='none'; }
            else { prev.innerHTML = ''; }
        }
    };
    window.ahpPick = function(pId, iId) {
        var f = wp.media({title:'Select Image',multiple:false,button:{text:'Use this image'},library:{type:'image'}});
        f.on('select', function(){
            var a = f.state().get('selection').first().toJSON();
            var s = (a.sizes && a.sizes.medium) ? a.sizes.medium.url : a.url;
            var p = document.getElementById(pId); if(p){p.src=s;p.classList.remove('ahp-empty');}
            var i = document.getElementById(iId); if(i) i.value = a.id;
        });
        f.open();
    };
    window.ahpRemove = function(pId, iId) {
        var p = document.getElementById(pId); if(p){p.src='';p.classList.add('ahp-empty');}
        var i = document.getElementById(iId); if(i) i.value='';
    };
    /* Repeater delete */
    document.addEventListener('click', function(e){
        if(e.target.classList.contains('ahp-rep-del')){
            if(confirm('Remove this item?')) e.target.closest('.ahp-rep-item').remove();
        }
    });
    /* Image pick — delegated handler for all .ahp-pick-img buttons */
    document.addEventListener('click', function(e){
        var btn = e.target.closest('.ahp-pick-img');
        if (!btn) return;
        e.preventDefault();
        var inputId = btn.getAttribute('data-target');
        if (!inputId) return;
        var frame = wp.media({
            title: 'Select Image',
            multiple: false,
            button: { text: 'Use this image' },
            library: { type: 'image' }
        });
        frame.on('select', function(){
            var att = frame.state().get('selection').first().toJSON();
            var url = (att.sizes && att.sizes.medium) ? att.sizes.medium.url : att.url;
            var inp = document.getElementById(inputId);
            if (inp) inp.value = att.id;
            /* Update preview — find closest img or placeholder div in same field */
            var field = btn.closest('.ahp-field');
            if (field) {
                var img = field.querySelector('img');
                if (img) {
                    img.src = url;
                    img.style.display = 'block';
                } else {
                    var placeholder = field.querySelector('div[style*="70px"]');
                    if (placeholder) {
                        placeholder.innerHTML = '<img src="' + url + '" style="width:70px;height:70px;object-fit:cover;display:block;">';
                    }
                }
            }
        });
        frame.open();
    });
    /* Image remove */
    document.addEventListener('click', function(e){
        var btn = e.target.closest('.ahp-remove-img');
        if (!btn) return;
        e.preventDefault();
        var inputId = btn.getAttribute('data-target');
        var inp = document.getElementById(inputId);
        if (inp) inp.value = '';
        var field = btn.closest('.ahp-field');
        if (field) {
            var img = field.querySelector('img');
            if (img) img.src = '';
            var placeholder = field.querySelector('div[style*="70px"]');
            if (placeholder) placeholder.innerHTML = '';
        }
    });    </script>
    <?php
});

/* ============================================================
   RENDER HELPERS
   ============================================================ */
function _f(string $key, string $label, string $def='', string $hint='', string $type='text'): void {
    global $post;
    $v = get_post_meta($post->ID, '_ahp_'.$key, true);
    if ($v===''||$v===false) $v=$def;
    echo '<div class="ahp-field">';
    echo '<label>'.esc_html($label).'</label>';
    if ($type==='textarea') {
        echo '<textarea name="ahp['.esc_attr($key).']">'.esc_textarea($v).'</textarea>';
    } else {
        echo '<input type="'.esc_attr($type).'" name="ahp['.esc_attr($key).']" value="'.esc_attr($v).'">';
    }
    if ($hint) echo '<span class="ahp-hint">'.esc_html($hint).'</span>';
    echo '</div>';
}
function _ft(string $key, string $label, string $def='', string $hint=''): void { _f($key,$label,$def,$hint,'textarea'); }
function _fn(string $key, string $label, string $def=''): void { _f($key,$label,$def,'','number'); }

function _fi(string $key, string $label, string $hint=''): void {
    global $post;
    $id  = absint(get_post_meta($post->ID, '_ahp_img_'.$key, true));
    $src = $id ? wp_get_attachment_image_url($id,'medium') : '';
    $pid = 'ahp_p_'.str_replace([' ','.','-'],'_',$key);
    $iid = 'ahp_i_'.str_replace([' ','.','-'],'_',$key);
    echo '<div class="ahp-field">';
    echo '<label>'.esc_html($label).'</label>';
    echo '<div class="ahp-img-row">';
    echo '<img id="'.esc_attr($pid).'" src="'.esc_url($src).'" class="ahp-img-preview'.($src?'':' ahp-empty').'" alt="">';
    echo '<div class="ahp-img-btns">';
    echo '<button type="button" class="button button-primary" onclick="ahpPick(\''.esc_js($pid).'\',\''.esc_js($iid).'\')">📁 Choose Image</button>';
    if ($src) echo '<button type="button" class="button" onclick="ahpRemove(\''.esc_js($pid).'\',\''.esc_js($iid).'\')">✕ Remove</button>';
    echo '</div></div>';
    echo '<input type="hidden" name="ahp_img['.esc_attr($key).']" id="'.esc_attr($iid).'" value="'.esc_attr($id).'">';
    if ($hint) echo '<span class="ahp-hint">'.esc_html($hint).'</span>';
    echo '</div>';
}

function _sec(string $title, string ...$cols): void {
    $cls = implode(' ', array_map(fn($c)=>'ahp-'.$c, $cols));
    echo '<div class="ahp-section"><div class="ahp-section-head">'.esc_html($title).'</div><div class="ahp-body'.($cls?' '.$cls:'').'">';
}
function _end(): void { echo '</div></div>'; }
function _full(string $cb): void { echo '<div class="ahp-full">'; $cb(); echo '</div>'; }

/* ============================================================
   SAVE
   ============================================================ */
function _ahp_save(int $post_id): void {
    if (!isset($_POST['_ahp_nonce'])) return;
    if (!wp_verify_nonce($_POST['_ahp_nonce'], 'ahp_'.$post_id)) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    // Text fields
    if (!empty($_POST['ahp']) && is_array($_POST['ahp'])) {
        foreach ($_POST['ahp'] as $k => $v) {
            $k = sanitize_key($k);
            if (is_array($v)) {
                update_post_meta($post_id, '_ahp_'.$k, array_map('sanitize_textarea_field', $v));
            } else {
                update_post_meta($post_id, '_ahp_'.$k, sanitize_textarea_field($v));
            }
        }
    }
    // Image IDs
    if (!empty($_POST['ahp_img']) && is_array($_POST['ahp_img'])) {
        foreach ($_POST['ahp_img'] as $k => $v) {
            update_post_meta($post_id, '_ahp_img_'.sanitize_key($k), absint($v));
        }
    }
    // Repeaters — stored under _ahp_rep_*
    if (!empty($_POST['ahp_rep']) && is_array($_POST['ahp_rep'])) {
        foreach ($_POST['ahp_rep'] as $rep_key => $rows) {
            $clean = [];
            if (is_array($rows)) {
                foreach ($rows as $row) {
                    if (is_array($row)) {
                        $clean[] = array_map('sanitize_textarea_field', $row);
                    }
                }
            }
            update_post_meta($post_id, '_ahp_rep_'.sanitize_key($rep_key), $clean);
        }
    }
}
add_action('save_post_page',         '_ahp_save', 10);


/* Nonce injected once */
add_action('edit_form_after_title', function(): void {
    global $post;
    if (!$post) return;
    wp_nonce_field('ahp_'.$post->ID, '_ahp_nonce');
});

/* ============================================================
   REGISTER META BOXES
   ============================================================ */
add_action('add_meta_boxes', function(): void {
    global $post;
    if (!$post || $post->post_type === 'hair_product') return;
    $tpl      = get_post_meta($post->ID, '_wp_page_template', true);
    $is_front = (int)get_option('page_on_front') === $post->ID;

    // ── HOMEPAGE ──────────────────────────────────────────
    if ($is_front) {
        _reg('ahp_home_hero',    '🎬 Hero Slides (up to 3)',          'ahp_home_hero_cb');
        _reg('ahp_home_cats',    '🗂 Category Cards',                  'ahp_home_cats_cb');
        _reg('ahp_home_why',     '✅ Why Asantey',                     'ahp_home_why_cb');
        _reg('ahp_home_prods',   '🛍 Featured Products (fallback)',    'ahp_home_prods_cb');
        _reg('ahp_home_gallery', '🖼 Homepage Gallery',               'ahp_home_gallery_cb');
        _reg('ahp_home_testi',   '💬 Testimonials / Reviews',         'ahp_home_testi_cb');
        _reg('ahp_home_cta',     '📣 CTA Band',                       'ahp_home_cta_cb');
        _reg('ahp_home_marq',    '📰 Marquee Strip',                  'ahp_home_marq_cb');
    }

    // ── SHARED HERO (all inner pages) ─────────────────────
    $inner = [
        'page-templates/page-raw-hair.php','page-templates/page-virgin-hair.php',
        'page-templates/page-closures.php','page-templates/page-salon.php',
        'page-templates/page-gallery.php', 'page-templates/page-about.php',
        'page-templates/page-contact.php', 'page-templates/page-faq.php',
        'page-templates/page-shop.php',    'page-templates/page-order.php',
        'page-templates/page-care-guide.php','page-templates/page-shipping.php',
        'page-templates/page-privacy.php', 'page-templates/page-terms.php',
    ];
    if (in_array($tpl, $inner)) {
        _reg('ahp_page_hero', '🖼 Page Hero — Image, Title & Subtitle', 'ahp_page_hero_cb');
    }

    // ── PAGE-SPECIFIC ──────────────────────────────────────
    switch ($tpl) {
        case 'page-templates/page-raw-hair.php':
            _reg('ahp_raw_intro',   '📝 Intro Section',             'ahp_raw_intro_cb');
            _reg('ahp_raw_tex',     '🎨 Texture Grid',              'ahp_raw_tex_cb');
            _reg('ahp_raw_pricing', '💷 Pricing Table',             'ahp_raw_pricing_cb');
            _reg('ahp_raw_care',    '💆 Care Split Section',        'ahp_raw_care_cb');
            _reg('ahp_raw_faq',     '❓ FAQ',                       'ahp_faq_cb');
            break;
        case 'page-templates/page-virgin-hair.php':
            _reg('ahp_vir_intro',   '📝 Intro Section',             'ahp_vir_intro_cb');
            _reg('ahp_vir_tex',     '🎨 Texture Grid',              'ahp_vir_tex_cb');
            _reg('ahp_vir_pricing', '💷 Pricing Table',             'ahp_vir_pricing_cb');
            _reg('ahp_vir_faq',     '❓ FAQ',                       'ahp_faq_cb');
            break;
        case 'page-templates/page-closures.php':
            _reg('ahp_cls_intro',   '📝 Intro Section',             'ahp_cls_intro_cb');
            _reg('ahp_cls_sizes',   '📐 Sizes & Pricing',           'ahp_cls_sizes_cb');
            _reg('ahp_cls_imgs',    '🖼 Guide Images',              'ahp_cls_imgs_cb');
            _reg('ahp_cls_faq',     '❓ FAQ',                       'ahp_faq_cb');
            break;
        case 'page-templates/page-salon.php':
            _reg('ahp_salon_svcs',  '💇 Hair Service Cards',        'ahp_salon_svcs_cb');
            _reg('ahp_salon_bsvc',  '💅 Beauty Service Cards',      'ahp_salon_bsvc_cb');
            _reg('ahp_salon_split', '📸 Story Section',             'ahp_salon_split_cb');
            _reg('ahp_salon_cta',   '📣 Booking CTA',               'ahp_salon_cta_cb');
            break;
        case 'page-templates/page-about.php':
            _reg('ahp_about_story', '📖 Our Story Section',         'ahp_about_story_cb');
            _reg('ahp_about_stats', '📊 Stats Strip',               'ahp_about_stats_cb');
            _reg('ahp_about_sec2',  '🖼 Second Section',            'ahp_about_sec2_cb');
            _reg('ahp_about_vals',  '🏆 Values',                    'ahp_about_vals_cb');
            break;
        case 'page-templates/page-contact.php':
            _reg('ahp_contact',     '📞 Contact Details & Map',     'ahp_contact_cb');
            _reg('ahp_contact_soc', '📱 Social Media Links',        'ahp_contact_soc_cb');
            break;
        case 'page-templates/page-faq.php':
            _reg('ahp_faq_pg',      '❓ FAQ Items',                  'ahp_faq_cb');
            break;
        case 'page-templates/page-order.php':
            _reg('ahp_order_intro', '📝 Page Intro',                'ahp_order_intro_cb');
            _reg('ahp_order_prods', '🛍 Product Cards',             'ahp_order_prods_cb');
            break;
        case 'page-templates/page-care-guide.php':
            _reg('ahp_care_intro',  '📝 Page Intro Text',           'ahp_care_intro_cb');
            break;
        case 'page-templates/page-shop.php':
            _reg('ahp_shop_intro',  '🛍 Shop Intro',                'ahp_shop_intro_cb');
            break;
        case 'page-templates/page-gallery.php':
            _reg('ahp_gallery',     '🖼 Gallery Images',            'ahp_gallery_cb');
            break;
        case 'page-templates/page-shipping.php':
        case 'page-templates/page-privacy.php':
        case 'page-templates/page-terms.php':
            _reg('ahp_legal',       '📄 Page Content',              'ahp_legal_cb');
            break;
    }
});

function _reg(string $id, string $title, string $cb): void {
    add_meta_box($id, $title, $cb, 'page', 'normal', 'high');
}

/* ============================================================
   SPRINT 2 — HOMEPAGE CALLBACKS
   ============================================================ */
function ahp_home_hero_cb(): void {
    echo '<div class="ahp">';
    for ($i=1; $i<=3; $i++) {
        _sec("Slide {$i}", 'col2');
        _fi("slide{$i}_image", "Background Image", "Recommended: 1920×1080px landscape photo");
        _f("slide{$i}_label",    "Eyebrow Label",      $i===1?"Premium Cambodian Hair Extensions":"");
        _f("slide{$i}_title",    "Main Title",         $i===1?"Luxury Hair.":"");
        _f("slide{$i}_italic",   "Italic Second Line", $i===1?"Real Results.":"");
        _ft("slide{$i}_sub",     "Subtitle",           $i===1?"Premium Cambodian Raw and Virgin Hair Extensions.":"");
        _f("slide{$i}_cta1",     "Button 1 Text",      $i===1?"Shop Collections":"");
        _f("slide{$i}_cta1_url", "Button 1 URL",       $i===1?"/shop/":"");
        _f("slide{$i}_cta2",     "Button 2 Text",      $i===1?"Buy Now":"");
        _end();
    }
    echo '</div>';
}

function ahp_home_cats_cb(): void {
    $d=[1=>['Raw Hair','Cambodian Raw Hair','Unprocessed. Uncoloured. Unapologetically Premium.','60','/raw-hair/'],
        2=>['Virgin Hair','Virgin Hair Bundles','Pure Quality. Lasting Beauty. 3-5 Year Lifespan.','50','/virgin-hair/'],
        3=>['HD Lace','Closures & Frontals','Invisible HD Lace. The Perfect Finish.','49','/closures-frontals/']];
    echo '<div class="ahp">';
    _sec('Section Heading','col2');
    _f('cats_label','Label','Our Collections'); _f('cats_title','Title','The Asantey Standard');
    _ft('cats_desc','Description','Every bundle, closure, and frontal is cuticle-aligned, single-donor...');
    _end();
    foreach ($d as $i=>$c) {
        _sec("Card {$i} — {$c[1]}",'col2');
        _fi("cat{$i}_image","Card Image","Recommended portrait ratio 3:4");
        _f("cat{$i}_label","Badge Label",$c[0]); _f("cat{$i}_title","Title",$c[1]);
        _f("cat{$i}_tag","Tagline",$c[2]); _f("cat{$i}_from","From Price (number only)",$c[3]);
        _f("cat{$i}_url","Link URL",$c[4]);
        _end();
    }
    echo '</div>';
}

function ahp_home_why_cb(): void {
    $d=[1=>['gem','Cambodian Origin','Single-donor Cambodian hair, ethically sourced, never chemically processed.'],
        2=>['shield','3-5 Year Lifespan','Invest once, wear for years. The results speak for themselves.'],
        3=>['sparkle','10+ Textures','Every texture in 10"-30" lengths. Wear it your way.']];
    echo '<div class="ahp">';
    _sec('Section Heading','col2');
    _f('why_label','Label','Why Asantey'); _f('why_title','Title','Hair That Speaks for Itself');
    _end();
    foreach ($d as $i=>$c) {
        _sec("Feature {$i}",'col2');
        _f("feat{$i}_title","Title",$c[1]);
        _f("feat{$i}_icon","Icon (gem/shield/sparkle/check/heart/truck/star)",$c[0]);
        _ft("feat{$i}_body","Description",$c[2]);
        _end();
    }
    echo '</div>';
}

function ahp_home_prods_cb(): void {
    echo '<div class="ahp">';
    _sec('Section Heading','col2');
    _f('prod_label','Label','Featured Products'); _f('prod_title','Title','Shop the Collection');
    _end();
    $d=[1=>['Raw Hair — Body Wave','raw-body-wave.jpg'],2=>['Raw Hair — Deep Wave','raw-deep-wave.jpg'],
        3=>['Virgin Hair — Body Wave','raw-loose-wave.jpg'],4=>['HD Lace Closure','hd-lace-sizes.png']];
    foreach ($d as $i=>$c) {
        _sec("Product {$i} — {$c[0]}",'col2');
        _fi("feat_prod{$i}_image","Product Image","Shown when no WooCommerce products exist");
        _f("feat_prod{$i}_title","Title",$c[0]); _f("feat_prod{$i}_price","From Price (no £)","");
        _ft("feat_prod{$i}_desc","Short Description","");
        _end();
    }
    echo '</div>';
}

function ahp_home_gallery_cb(): void {
    echo '<div class="ahp">';
    _sec('Section Heading','col2');
    _f('gal_label','Label','Real Women. Real Results.'); _f('gal_title','Title','See It to Believe It');
    _end();
    _sec('Gallery Images (up to 6 shown on homepage)','col3');
    for ($i=1;$i<=6;$i++) _fi("gal_image_{$i}","Image {$i}");
    _end();
    echo '</div>';
}

function ahp_home_testi_cb(): void {
    global $post;
    // Read saved repeater rows
    $rows = get_post_meta($post->ID, '_ahp_rep_testimonials', true);
    if (!is_array($rows) || empty($rows)) {
        $rows = [
            ['quote'=>'I have been buying hair for over 10 years and Asantey is hands down the best quality I have ever experienced.','author'=>'Naomi A., London','stars'=>'5'],
            ['quote'=>'My 28 inch raw body wave bundle is still going strong 2 years later. Worth every penny.','author'=>'Blessing O., Birmingham','stars'=>'5'],
            ['quote'=>'The HD lace frontal is unreal. My stylist could not believe it was not my natural hairline.','author'=>'Jade K., Manchester','stars'=>'5'],
        ];
    }
    echo '<div class="ahp">';
    _sec('Section Heading','col2');
    _f('test_label','Label','Client Love');
    _f('test_title','Title','What Our Clients Say');
    _end();
    _sec('Reviews — add as many as you like. Click + Add Review to grow the list.');
    echo '<div id="ahp-testi-list">';
    foreach ($rows as $i => $row) {
        $q = esc_textarea($row['quote']  ?? '');
        $a = esc_attr($row['author']     ?? '');
        $s = esc_attr($row['stars']      ?? '5');
        echo "<div class='ahp-rep-item'>"
           . "<button type='button' class='ahp-rep-del'>✕ Remove</button>"
           . "<div class='ahp-body ahp-col2' style='padding:0;border:none;gap:8px;'>"
           . "<div class='ahp-field ahp-full'><label>Review Text</label><textarea name='ahp_rep[testimonials][{$i}][quote]'>{$q}</textarea></div>"
           . "<div class='ahp-field'><label>Reviewer Name</label><input type='text' name='ahp_rep[testimonials][{$i}][author]' value='{$a}'></div>"
           . "<div class='ahp-field'><label>Stars (1–5)</label><input type='number' name='ahp_rep[testimonials][{$i}][stars]' value='{$s}' min='1' max='5' style='width:70px'></div>"
           . "</div></div>";
    }
    echo '</div>';
    echo '<button type="button" class="button button-primary ahp-rep-add" id="ahp-testi-add">+ Add Review</button>';
    echo '<script>
    (function(){
        var idx = ' . count($rows) . ';
        document.getElementById("ahp-testi-add").addEventListener("click", function(){
            var d = document.createElement("div");
            d.className = "ahp-rep-item";
            d.innerHTML = "<button type=\'button\' class=\'ahp-rep-del\'>✕ Remove</button>"
                + "<div class=\'ahp-body ahp-col2\' style=\'padding:0;border:none;gap:8px;\'>"
                + "<div class=\'ahp-field ahp-full\'><label>Review Text</label>"
                + "<textarea name=\'ahp_rep[testimonials][" + idx + "][quote]\'></textarea></div>"
                + "<div class=\'ahp-field\'><label>Reviewer Name</label>"
                + "<input type=\'text\' name=\'ahp_rep[testimonials][" + idx + "][author]\'></div>"
                + "<div class=\'ahp-field\'><label>Stars (1–5)</label>"
                + "<input type=\'number\' name=\'ahp_rep[testimonials][" + idx + "][stars]\' value=\'5\' min=\'1\' max=\'5\' style=\'width:70px\'></div>"
                + "</div>";
            document.getElementById("ahp-testi-list").appendChild(d);
            idx++;
        });
    })();
    </script>';
    _end();
    echo '</div>';
}

function ahp_home_story_cb(): void {
    echo '<div class="ahp">';
    _sec('Brand Story','col2');
    _f('story_label','Label','Our Story'); _f('story_title','Title','The Asantey Standard');
    _ft('story_body1','Paragraph 1','Founded on the belief that every woman deserves hair she is genuinely proud of.');
    _ft('story_body2','Paragraph 2','What you receive is exactly as nature intended: just better selected and built to last 3-5 years.');
    _end();
    echo '</div>';
}

function ahp_home_cta_cb(): void {
    echo '<div class="ahp">';
    _sec('CTA Band','col2');
    _f('cta_label','Label','Ready to Elevate Your Look?'); _f('cta_title','Title','Your Best Hair Starts Here');
    _ft('cta_body','Body','Browse our full collection or order directly.');
    _f('cta_btn1','Button 1 Text','Shop Collections'); _f('cta_btn1_url','Button 1 URL','/shop/');
    _f('cta_btn2','Button 2 Text','Buy Now');
    _end();
    echo '</div>';
}

function ahp_home_marq_cb(): void {
    global $post;

    // Read saved repeater rows
    $rows = get_post_meta($post->ID, '_ahp_rep_marquee', true);

    // Migrate from old textarea format if needed
    if (!is_array($rows) || empty($rows)) {
        $old_raw = get_post_meta($post->ID, '_ahp_marquee_items', true);
        if ($old_raw) {
            $rows = [];
            foreach (array_filter(array_map('trim', explode("\n", $old_raw))) as $line) {
                $parts  = explode('|', $line, 2);
                $rows[] = ['icon' => trim($parts[0] ?? ''), 'text' => trim($parts[1] ?? '')];
            }
        }
    }

    // Defaults
    if (empty($rows)) {
        $rows = [
            ['icon'=>'sparkle', 'text'=>'Premium Cambodian Hair'],
            ['icon'=>'gem',     'text'=>'HD Lace Specialists'],
            ['icon'=>'shield',  'text'=>'3-5 Year Lifespan'],
            ['icon'=>'check',   'text'=>'Minimal Shedding'],
            ['icon'=>'location','text'=>'UK Based - Nottingham'],
            ['icon'=>'heart',   'text'=>'Single Donor'],
            ['icon'=>'sparkle', 'text'=>'Cuticle Aligned'],
            ['icon'=>'truck',   'text'=>'Fast UK Dispatch'],
        ];
    }

    $icons = ['sparkle','gem','shield','check','location','heart','truck','star','fire','crown'];

    echo '<div class="ahp">';
    echo '<p class="ahp-hint" style="margin:0 0 10px;">Each item scrolls in the marquee strip below the hero. Add, edit or remove items then click Update.</p>';
    echo '<div id="ahp-marq-list" style="margin-bottom:10px;">';

    foreach ($rows as $i => $row):
        $ic = esc_attr($row['icon'] ?? 'sparkle');
        $tx = esc_attr($row['text'] ?? '');
        echo "<div class='ahp-rep-item' style='display:flex;align-items:center;gap:10px;padding:8px 12px;'>"
           . "<div class='ahp-field' style='flex:0 0 150px;'>"
           . "<label style='font-size:11px;'>Icon</label>"
           . "<select name='ahp_rep[marquee][{$i}][icon]' style='font-size:13px;padding:5px 8px;'>";
        foreach ($icons as $opt) {
            $sel = $ic === $opt ? ' selected' : '';
            echo "<option value='{$opt}'{$sel}>" . esc_html(ucfirst($opt)) . "</option>";
        }
        echo   "</select></div>"
           . "<div class='ahp-field' style='flex:1;'>"
           . "<label style='font-size:11px;'>Text</label>"
           . "<input type='text' name='ahp_rep[marquee][{$i}][text]' value='{$tx}'>"
           . "</div>"
           . "<button type='button' class='ahp-rep-del' style='flex-shrink:0;margin-top:16px;'>✕ Remove</button>"
           . "</div>";
    endforeach;

    echo '</div>';
    echo '<button type="button" class="button button-primary" id="ahp-marq-add">+ Add Item</button>';
    echo '<p class="ahp-hint" style="margin-top:8px;">Available icons: sparkle, gem, shield, check, location, heart, truck, star, fire, crown</p>';

    $idx  = count($rows);
    $opts = '';
    foreach ($icons as $opt) $opts .= "<option value='{$opt}'>" . ucfirst($opt) . "</option>";

    echo "<script>
    (function(){
        var idx = {$idx};
        document.getElementById('ahp-marq-add').addEventListener('click', function(){
            var d = document.createElement('div');
            d.className = 'ahp-rep-item';
            d.style.cssText = 'display:flex;align-items:center;gap:10px;padding:8px 12px;';
            d.innerHTML = '<div class=\"ahp-field\" style=\"flex:0 0 150px;\"><label style=\"font-size:11px;\">Icon</label>'
                + '<select name=\"ahp_rep[marquee][' + idx + '][icon]\" style=\"font-size:13px;padding:5px 8px;\">{$opts}</select></div>'
                + '<div class=\"ahp-field\" style=\"flex:1;\"><label style=\"font-size:11px;\">Text</label>'
                + '<input type=\"text\" name=\"ahp_rep[marquee][' + idx + '][text]\"></div>'
                + '<button type=\"button\" class=\"ahp-rep-del\" style=\"flex-shrink:0;margin-top:16px;\">✕ Remove</button>';
            document.getElementById('ahp-marq-list').appendChild(d);
            idx++;
        });
    })();
    </script>";

    echo '</div>';
}

/* ============================================================
   SHARED — PAGE HERO
   ============================================================ */
function ahp_page_hero_cb(): void {
    echo '<div class="ahp">';
    _sec('Hero Section','col2');
    _fi('hero_image','Background Image','Wide landscape photo — recommended 1920×700px');
    _f('hero_label','Small Label (above title)','');
    _f('hero_title','Hero Title','');
    _f('hero_subtitle','Subtitle / Tagline','');
    _end();
    echo '</div>';
}

/* ============================================================
   SPRINT 3 — RAW HAIR
   ============================================================ */
function ahp_raw_intro_cb(): void {
    echo '<div class="ahp">';
    _sec('Intro Split Section','col2');
    _fi('raw_intro_image','Section Image','The image shown beside the intro text');
    _f('raw_intro_label','Label','What Makes It Different');
    _f('raw_intro_title','Title','What is Raw Hair?');
    _ft('raw_intro_p1','Paragraph 1','Raw hair is the purest form of hair extension. Collected from a single Cambodian donor, it has never been treated with chemicals, heat-processed at the factory, or blended with hair from other sources.');
    _ft('raw_intro_p2','Paragraph 2','Because all cuticles run in the same direction — from root to tip — raw hair has virtually no friction between strands. That means no tangling, minimal shedding, and a natural shine.');
    _ft('raw_intro_p3','Paragraph 3','Raw hair can be coloured, bleached, and heat-styled just like your natural hair. When we say it lasts 3–5 years, that is not a marketing line. It is what our clients actually experience.');
    _end();
    _sec('Textures Section Heading','col2');
    _f('raw_tex_label','Label','Available Textures'); _f('raw_tex_title','Title','8 Textures. One Standard.');
    _ft('raw_tex_desc','Description','Every texture available in all lengths, 10"–30", at the same price point.');
    _end();
    echo '</div>';
}

function ahp_raw_tex_cb(): void {
    $textures=[
        ['straight','Straight'],['body-wave','Body Wave'],['loose-wave','Loose Wave'],
        ['deep-wave','Deep Wave'],['kinky-straight','Kinky Straight'],['loose-deep','Loose Deep Wave'],
        ['burmese-curls','Burmese Curls'],['waver-wave','Water Wave'],
    ];
    echo '<div class="ahp">';
    _sec('Texture Images & Names','col2');
    echo '<p class="ahp-hint ahp-full" style="margin:0 0 4px;">Upload a photo for each texture. Name and description can also be edited.</p>';
    foreach ($textures as [$key,$name]) {
        _fi("raw_tex_{$key}","Image: {$name}");
    }
    _end();
    _sec('Texture Names & Descriptions (optional override)','col2');
    foreach ($textures as [$key,$name]) {
        _f("raw_tex_{$key}_name","Name",$name);
        _ft("raw_tex_{$key}_desc","Description","");
    }
    _end();
    echo '</div>';
}

function ahp_raw_pricing_cb(): void {
    $lengths=['10in'=>'60','12in'=>'63','14in'=>'69','16in'=>'75','18in'=>'80',
              '20in'=>'88','22in'=>'95','24in'=>'100','26in'=>'105','28in'=>'110','30in'=>'120'];
    echo '<div class="ahp">';
    _sec('Pricing Section Heading','col2');
    _f('raw_price_label','Label','Transparent Pricing');
    _f('raw_price_title','Title','Raw Hair Price Per Bundle');
    _ft('raw_price_desc','Description','All textures are priced equally by length. Prices are per bundle.');
    _end();
    _sec('Price Per Length (£)','col4');
    foreach ($lengths as $len=>$def) _fn("raw_price_{$len}",str_replace('in','"',$len),$def);
    _end();
    echo '</div>';
}

function ahp_raw_care_cb(): void {
    echo '<div class="ahp">';
    _sec('Care Split Section','col2');
    _fi('raw_care_image','Section Image','Image shown beside the care tips');
    _f('raw_care_label','Label','Protect Your Investment');
    _f('raw_care_title','Title','How to Make It Last 5 Years');
    _ft('raw_care_body','Body Text','Raw hair is durable by nature, but the right care routine makes all the difference between 2 years and 5. Gentle washing, deep conditioning, minimal heat, and proper storage are the four pillars of long-lasting raw hair.');
    _end();
    echo '</div>';
}

/* ============================================================
   SPRINT 4 — VIRGIN HAIR
   ============================================================ */
function ahp_vir_intro_cb(): void {
    echo '<div class="ahp">';
    _sec('Intro Split Section','col2');
    _fi('vir_intro_image','Section Image');
    _f('vir_intro_label','Label','Pure. Natural. Versatile.');
    _f('vir_intro_title','Title','What is Virgin Hair?');
    _ft('vir_intro_p1','Paragraph 1','Virgin hair is premium single-donor Cambodian hair that has never been chemically processed. It is harvested from a healthy single donor, ensuring all cuticles run in the same direction for maximum smoothness and longevity.');
    _ft('vir_intro_p2','Paragraph 2','Compared to raw hair, our virgin collection has a slightly more refined finish and higher lustre. Both share the same 3-5 year lifespan with proper care — virgin hair is the ideal starting point for women new to premium extensions.');
    _end();
    _sec('Textures Section Heading','col2');
    _f('vir_tex_label','Label','Available Textures'); _f('vir_tex_title','Title','Choose Your Texture');
    _ft('vir_tex_desc','Description','All textures available in 10"–30" at the same price per length.');
    _end();
    _sec('Pricing Section Heading','col2');
    _f('vir_price_label','Label','Transparent Pricing'); _f('vir_price_title','Title','Virgin Hair Price Per Bundle');
    _ft('vir_price_desc','Description','All textures priced equally by length. Per bundle pricing.');
    _end();
    echo '</div>';
}

function ahp_vir_tex_cb(): void {
    $textures=[
        ['straight','Straight'],['body-wave','Body Wave'],['loose-wave','Loose Wave'],
        ['deep-wave','Deep Wave'],['kinky-straight','Kinky Straight'],['loose-deep','Loose Deep Wave'],
        ['burmese-curls','Burmese Curls'],['waver-wave','Water Wave'],
    ];
    echo '<div class="ahp">';
    _sec('Texture Images','col2');
    foreach ($textures as [$key,$name]) _fi("vir_tex_{$key}","Image: {$name}");
    _end();
    _sec('Texture Names & Descriptions','col2');
    foreach ($textures as [$key,$name]) {
        _f("vir_tex_{$key}_name","Name",$name);
        _ft("vir_tex_{$key}_desc","Description","");
    }
    _end();
    echo '</div>';
}

function ahp_vir_pricing_cb(): void {
    $lengths=['10in'=>'50','12in'=>'53','14in'=>'59','16in'=>'65','18in'=>'70',
              '20in'=>'78','22in'=>'85','24in'=>'90','26in'=>'95','28in'=>'100','30in'=>'110'];
    echo '<div class="ahp">';
    _sec('Price Per Length (£)','col4');
    foreach ($lengths as $len=>$def) _fn("vir_price_{$len}",str_replace('in','"',$len),$def);
    _end();
    echo '</div>';
}

/* ============================================================
   SPRINT 5 — CLOSURES & FRONTALS
   ============================================================ */
function ahp_cls_intro_cb(): void {
    echo '<div class="ahp">';
    _sec('Intro Split Section','col2');
    _fi('cls_intro_image','Section Image');
    _f('cls_intro_label','Label','Why HD Lace?');
    _f('cls_intro_title','Title','The Invisible Lace Standard');
    _ft('cls_intro_p1','Paragraph 1','HD lace is the thinnest, most transparent lace available. When applied to the scalp, it becomes virtually invisible — creating a hairline that looks like your own natural hair.');
    _ft('cls_intro_p2','Paragraph 2','No bleaching required. No heavy foundation. No obvious lace line. Our HD closures and frontals are pre-plucked with baby hairs, so the natural look is built in from day one.');
    _end();
    _sec('Sizes Section Heading','col2');
    _f('cls_sizes_label','Label','Choose Your Size');
    _f('cls_sizes_title','Title','Available Sizes & Textures');
    _ft('cls_sizes_desc','Description','All sizes available in every texture. Match to your Asantey bundles for a flawless install.');
    _end();
    echo '</div>';
}

function ahp_cls_sizes_cb(): void {
    echo '<div class="ahp">';
    _sec('Pricing Section Heading','col2');
    _f('cls_price_label','Label','Full Pricing');
    _f('cls_price_title','Title','Closures & Frontals — Price Lists');
    _end();
    _sec('Closure Prices','col3');
    $cls=[['2x6','49','61','—','—','—','—'],['4x4','51','53','56','62','68','72'],
          ['5x5','61','65','68','75','80','90'],['6x6','72','77','83','90','97','107']];
    $lens=['12in','14in','16in','18in','20in','22in'];
    foreach ($cls as [$size,&$prices]) {
        _f("cls_price_{$size}_label","Size Label",$size.' Closure');
        foreach ($lens as $k=>$len) _fn("cls_price_{$size}_{$len}",str_replace('in','"',$len),$prices[$k]);
    }
    _end();
    _sec('Frontal Prices','col3');
    $frt=[['13x4','80','85','90','99','107','117'],['13x6','81','85','94','103','112','124']];
    foreach ($frt as [$size,&$prices]) {
        _f("frt_price_{$size}_label","Size Label",$size.' Frontal');
        foreach ($lens as $k=>$len) _fn("frt_price_{$size}_{$len}",str_replace('in','"',$len),$prices[$k]);
    }
    _end();
    echo '</div>';
}

function ahp_cls_imgs_cb(): void {
    echo '<div class="ahp">';
    _sec('Section Images','col2');
    _fi('cls_intro_image','Left Section Image','Image shown in the split section beside the HD lace intro text');
    _fi('cls_size_guide', 'Size Guide Image',  'Diagram showing closure/frontal sizes (fallback if no intro image set)');
    _end();
    echo '</div>';
}

/* ============================================================
   SPRINT 6 — SALON SERVICES
   ============================================================ */
function ahp_salon_svcs_cb(): void {
    global $post;
    $rows = get_post_meta($post->ID, '_ahp_rep_hair_services', true);
    if (!is_array($rows) || empty($rows)) {
        $rows = [
            ['title'=>'Braids',                'price'=>'','desc'=>'From knotless box braids to jumbo braids — protective styles that are clean, neat, and built to last.','link'=>''],
            ['title'=>'Cornrows',              'price'=>'','desc'=>'Classic and intricate cornrow styles including straight backs, curved designs, and feed-in techniques.','link'=>''],
            ['title'=>'Hair Treatments',       'price'=>'','desc'=>'Deep conditioning, protein treatments, and scalp care to restore moisture and promote healthy growth.','link'=>''],
            ['title'=>'Sew-In Installs',       'price'=>'','desc'=>'Professional sew-in installation for bundles and closures/frontals. Flawless, long-lasting install.','link'=>''],
            ['title'=>'Closure & Frontal Install','price'=>'','desc'=>'Expert HD lace closure and frontal installation. Natural hairline, seamless blend.','link'=>''],
            ['title'=>'Natural Hair Care',     'price'=>'','desc'=>'Wash, condition, detangle, and style services for natural hair textures.','link'=>''],
        ];
    }
    echo '<div class="ahp">';
    _sec('Section Heading','col2');
    _f('salon_hair_label','Label','Hair Services');
    _f('salon_hair_title','Title','Expert Hair Services');
    _ft('salon_hair_desc','Description','');
    _end();
    echo '<p class="ahp-hint" style="margin:0 0 10px;">Add, edit or remove services. Click <strong>+ Add Service</strong> to grow the list.</p>';
    echo '<div id="ahp-hair-svc-list">';
    foreach ($rows as $i => $row):
        $t = esc_attr($row['title'] ?? '');
        $p = esc_attr($row['price'] ?? '');
        $d = esc_textarea($row['desc']  ?? '');
        $l = esc_attr($row['link']  ?? '');
        $img_id  = (int)($row['image_id'] ?? 0);
        $img_src = $img_id ? wp_get_attachment_image_url($img_id,'thumbnail') : '';
        echo "<div class='ahp-rep-item'>"
           . "<button type='button' class='ahp-rep-del'>✕ Remove</button>"
           . "<div class='ahp-body ahp-col2' style='padding:0;border:none;gap:8px;'>"
           . "<div class='ahp-field ahp-full'><label>Service Title</label><input type='text' name='ahp_rep[hair_services][{$i}][title]' value='{$t}'></div>"
           . "<div class='ahp-field'><label>Price (e.g. From £45)</label><input type='text' name='ahp_rep[hair_services][{$i}][price]' value='{$p}'></div>"
           . "<div class='ahp-field'><label>Link URL (optional)</label><input type='text' name='ahp_rep[hair_services][{$i}][link]' value='{$l}' placeholder='https://asanteyhair.as.me/'></div>"
           . "<div class='ahp-field ahp-full'><label>Description</label><textarea name='ahp_rep[hair_services][{$i}][desc]'>{$d}</textarea></div>"
           . "<div class='ahp-field ahp-full'><label>Service Image</label>"
           . "<div style='display:flex;align-items:center;gap:10px;'>"
           . ($img_src ? "<img src='{$img_src}' style='width:70px;height:70px;object-fit:cover;'>" : "<div style='width:70px;height:70px;background:#f0f0f0;border:1px dashed #ccc;'></div>")
           . "<div style='display:flex;flex-direction:column;gap:4px;'>"
           . "<button type='button' class='button button-primary' onclick=\"ahpPickSvc('hair_svc_prev_{$i}','hair_svc_img_{$i}')\">📁 Choose Image</button>"
           . "<button type='button' class='button' onclick=\"ahpRemoveSvc('hair_svc_prev_{$i}','hair_svc_img_{$i}')\">✕ Remove</button></div></div>"
           . "<input type='hidden' name='ahp_rep[hair_services][{$i}][image_id]' id='hair_svc_img_{$i}' value='{$img_id}'>"
           . "</div></div></div>";
    endforeach;
    echo '</div>';
    $idx = count($rows);
    echo "<button type='button' class='button button-primary ahp-rep-add' id='ahp-hair-svc-add'>+ Add Service</button>";
    echo "<script>
    (function(){
        var idx={$idx};
        document.getElementById('ahp-hair-svc-add').addEventListener('click',function(){
            var d=document.createElement('div');d.className='ahp-rep-item';
            d.innerHTML='<button type=\"button\" class=\"ahp-rep-del\">✕ Remove</button>'
                +'<div class=\"ahp-body ahp-col2\" style=\"padding:0;border:none;gap:8px;\">'
                +'<div class=\"ahp-field ahp-full\"><label>Service Title</label><input type=\"text\" name=\"ahp_rep[hair_services]['+idx+'][title]\"></div>'
                +'<div class=\"ahp-field\"><label>Price</label><input type=\"text\" name=\"ahp_rep[hair_services]['+idx+'][price]\"></div>'
                +'<div class=\"ahp-field\"><label>Link URL</label><input type=\"text\" name=\"ahp_rep[hair_services]['+idx+'][link]\" placeholder=\"https://asanteyhair.as.me/\"></div>'
                +'<div class=\"ahp-field ahp-full\"><label>Description</label><textarea name=\"ahp_rep[hair_services]['+idx+'][desc]\"></textarea></div>'
                +'<div class=\"ahp-field ahp-full\"><label>Service Image</label>'
                +'<div style=\"display:flex;align-items:center;gap:10px;\">'
                +'<div style=\"width:70px;height:70px;background:#f0f0f0;border:1px dashed #ccc;\" id=\"hair_svc_prev_'+idx+'\"></div>'
                +'<div><button type=\"button\" class=\"button ahp-pick-img\" data-target=\"hair_svc_img_'+idx+'\">Choose Image</button></div></div>'
                +'<input type=\"hidden\" name=\"ahp_rep[hair_services]['+idx+'][image_id]\" id=\"hair_svc_img_'+idx+'\" value=\"\"></div>'
                +'</div></div>';
            document.getElementById('ahp-hair-svc-list').appendChild(d);
            idx++;
        });
    })();
    </script>";
    echo '</div>';
}

function ahp_salon_bsvc_cb(): void {
    global $post;
    $rows = get_post_meta($post->ID, '_ahp_rep_beauty_services', true);
    if (!is_array($rows) || empty($rows)) {
        $rows = [
            ['title'=>'Lash Extensions',  'price'=>'','desc'=>'Semi-permanent lash extensions for a fuller, longer lash look without mascara.','link'=>''],
            ['title'=>'Eyebrow Waxing',   'price'=>'','desc'=>'Precise eyebrow shaping using wax for a clean, defined arch.','link'=>''],
            ['title'=>'Eyebrow Threading','price'=>'','desc'=>'Traditional threading technique for precise brow shaping. Ideal for sensitive skin.','link'=>''],
        ];
    }
    echo '<div class="ahp">';
    _sec('Section Heading','col2');
    _f('salon_beauty_label','Label','Beauty Services');
    _f('salon_beauty_title','Title','Complete Beauty Services');
    _ft('salon_beauty_desc','Description','Finish your look from lash to brow.');
    _end();
    echo '<p class="ahp-hint" style="margin:0 0 10px;">Add, edit or remove beauty services. Click <strong>+ Add Service</strong> to grow the list.</p>';
    echo '<div id="ahp-beauty-svc-list">';
    foreach ($rows as $i => $row):
        $t = esc_attr($row['title'] ?? '');
        $p = esc_attr($row['price'] ?? '');
        $d = esc_textarea($row['desc']  ?? '');
        $l = esc_attr($row['link']  ?? '');
        $img_id  = (int)($row['image_id'] ?? 0);
        $img_src = $img_id ? wp_get_attachment_image_url($img_id,'thumbnail') : '';
        echo "<div class='ahp-rep-item'>"
           . "<button type='button' class='ahp-rep-del'>✕ Remove</button>"
           . "<div class='ahp-body ahp-col2' style='padding:0;border:none;gap:8px;'>"
           . "<div class='ahp-field ahp-full'><label>Service Title</label><input type='text' name='ahp_rep[beauty_services][{$i}][title]' value='{$t}'></div>"
           . "<div class='ahp-field'><label>Price</label><input type='text' name='ahp_rep[beauty_services][{$i}][price]' value='{$p}'></div>"
           . "<div class='ahp-field'><label>Link URL (optional)</label><input type='text' name='ahp_rep[beauty_services][{$i}][link]' value='{$l}' placeholder='https://asanteyhair.as.me/'></div>"
           . "<div class='ahp-field ahp-full'><label>Description</label><textarea name='ahp_rep[beauty_services][{$i}][desc]'>{$d}</textarea></div>"
           . "<div class='ahp-field ahp-full'><label>Service Image</label>"
           . "<div style='display:flex;align-items:center;gap:10px;'>"
           . ($img_src ? "<img src='{$img_src}' style='width:70px;height:70px;object-fit:cover;'>" : "<div style='width:70px;height:70px;background:#f0f0f0;border:1px dashed #ccc;'></div>")
           . "<div style='display:flex;flex-direction:column;gap:4px;'>"
           . "<button type='button' class='button button-primary' onclick=\"ahpPickSvc('beauty_svc_prev_{$i}','beauty_svc_img_{$i}')\">📁 Choose Image</button>"
           . "<button type='button' class='button' onclick=\"ahpRemoveSvc('beauty_svc_prev_{$i}','beauty_svc_img_{$i}')\">✕ Remove</button></div></div>"
           . "<input type='hidden' name='ahp_rep[beauty_services][{$i}][image_id]' id='beauty_svc_img_{$i}' value='{$img_id}'>"
           . "</div></div></div>";
    endforeach;
    echo '</div>';
    $idx = count($rows);
    echo "<button type='button' class='button button-primary ahp-rep-add' id='ahp-beauty-svc-add'>+ Add Service</button>";
    echo "<script>
    (function(){
        var idx={$idx};
        document.getElementById('ahp-beauty-svc-add').addEventListener('click',function(){
            var d=document.createElement('div');d.className='ahp-rep-item';
            d.innerHTML='<button type=\"button\" class=\"ahp-rep-del\">✕ Remove</button>'
                +'<div class=\"ahp-body ahp-col2\" style=\"padding:0;border:none;gap:8px;\">'
                +'<div class=\"ahp-field ahp-full\"><label>Service Title</label><input type=\"text\" name=\"ahp_rep[beauty_services]['+idx+'][title]\"></div>'
                +'<div class=\"ahp-field\"><label>Price</label><input type=\"text\" name=\"ahp_rep[beauty_services]['+idx+'][price]\"></div>'
                +'<div class=\"ahp-field\"><label>Link URL</label><input type=\"text\" name=\"ahp_rep[beauty_services]['+idx+'][link]\" placeholder=\"https://asanteyhair.as.me/\"></div>'
                +'<div class=\"ahp-field ahp-full\"><label>Description</label><textarea name=\"ahp_rep[beauty_services]['+idx+'][desc]\"></textarea></div>'
                +'<div class=\"ahp-field ahp-full\"><label>Service Image</label>'
                +'<input type=\"hidden\" name=\"ahp_rep[beauty_services]['+idx+'][image_id]\" id=\"beauty_svc_img_'+idx+'\" value=\"\">'
                +'<button type=\"button\" class=\"button ahp-pick-img\" data-target=\"beauty_svc_img_'+idx+'\">Choose Image</button>'
                +'</div></div></div>';
            document.getElementById('ahp-beauty-svc-list').appendChild(d);
            idx++;
        });
    })();
    </script>";
    echo '</div>';
}

function ahp_salon_split_cb(): void {
    echo '<div class="ahp">';
    _sec('Story / Split Section','col2');
    _fi('salon_split_img1','Left Image');
    _fi('salon_split_img2','Right Image');
    _f('salon_split_label','Label','About Our Salon');
    _f('salon_split_title','Title','');
    _ft('salon_split_body','Body Text','');
    _end();
    echo '</div>';
}

function ahp_salon_cta_cb(): void {
    echo '<div class="ahp">';
    _sec('Booking CTA Section','col2');
    _f('salon_cta_title','Title','Ready to Book?');
    _ft('salon_cta_body','Body','');
    _f('salon_cta_btn','Button Text','Book Now');
    _f('salon_cta_url','Booking URL','https://asanteyhair.as.me/');
    _end();
    echo '</div>';
}

/* ============================================================
   SPRINT 7 — ABOUT
   ============================================================ */
function ahp_about_story_cb(): void {
    echo '<div class="ahp">';
    _sec('Our Story Section','col2');
    _fi('about_img1','Story Image (left side)');
    _f('about_label','Label','Our Story'); _f('about_title','Title','');
    _ft('about_p1','Paragraph 1','');
    _ft('about_p2','Paragraph 2','');
    _f('about_btn','Button Text','Learn More'); _f('about_btn_url','Button URL','/shop/');
    _end();
    echo '</div>';
}

function ahp_about_stats_cb(): void {
    echo '<div class="ahp">';
    _sec('Stats Strip (4 numbers)','col4');
    for ($i=1;$i<=4;$i++) {
        _f("stat{$i}_num","Stat {$i} Number",""); _f("stat{$i}_label","Stat {$i} Label","");
    }
    _end();
    echo '</div>';
}

function ahp_about_sec2_cb(): void {
    echo '<div class="ahp">';
    _sec('Second Split Section','col2');
    _fi('about_img2','Section Image (right side)');
    _f('about2_label','Label',''); _f('about2_title','Title','');
    _ft('about2_body','Body Text','');
    _end();
    echo '</div>';
}

function ahp_about_vals_cb(): void {
    echo '<div class="ahp">';
    _sec('Values Section Heading','col2');
    _f('vals_label','Label','Our Values'); _f('vals_title','Title','');
    _end();
    for ($i=1;$i<=3;$i++) {
        _sec("Value {$i}",'col2');
        _f("val{$i}_icon","Icon",'gem'); _f("val{$i}_title","Title","");
        _ft("val{$i}_body","Description","");
        _end();
    }
    echo '</div>';
}

/* ============================================================
   SPRINT 8a — CONTACT
   ============================================================ */
function ahp_contact_cb(): void {
    echo '<div class="ahp">';
    _sec('Contact Details','col2');
    _f('phone',  'Phone Number',  '07827 129797');
    _f('email',  'Email Address', '');
    _f('address','Address',       '358 Radford Road, Nottingham NG7 5GQ');
    _f('hours',  'Opening Hours', 'Mon–Sat: 9am–7pm');
    _f('wa',     'WhatsApp Number (no + or spaces)','447827129797');
    _f('booking','Booking URL',   'https://asanteyhair.as.me/');
    _end();
    _sec('Google Maps Embed');
    _ft('map_embed','Embed src URL','','From Google Maps → Share → Embed a map → copy only the src="..." value');
    _end();
    echo '</div>';
}

function ahp_contact_soc_cb(): void {
    echo '<div class="ahp">';
    _sec('Social Media Links','col2');
    _f('soc_instagram','Instagram URL',''); _f('soc_facebook','Facebook URL','');
    _f('soc_tiktok','TikTok URL','');       _f('soc_youtube','YouTube URL','');
    _end();
    echo '</div>';
}

/* ============================================================
   SPRINT 8b — FAQ (shared between raw/virgin/closures/faq page)
   ============================================================ */
function ahp_faq_cb(): void {
    global $post;
    $items = get_post_meta($post->ID, '_ahp_rep_faq', true);
    if (!is_array($items)) $items=[['q'=>'','a'=>''],['q'=>'','a'=>''],['q'=>'','a'=>'']];
    echo '<div class="ahp">';
    _sec('FAQ Items — add, edit or remove questions & answers');
    echo '<div id="ahp-faq-list">';
    foreach ($items as $row) {
        $q = esc_attr($row['q']??'');
        $a = esc_textarea($row['a']??'');
        echo "<div class='ahp-rep-item'><button type='button' class='ahp-rep-del'>✕ Remove</button>"
           . "<div class='ahp-field'><label>Question</label><input type='text' name='ahp_rep[faq][][q]' value='{$q}'></div>"
           . "<div class='ahp-field'><label>Answer</label><textarea name='ahp_rep[faq][][a]'>{$a}</textarea></div>"
           . "</div>";
    }
    echo '</div>';
    echo '<button type="button" class="button ahp-rep-add" id="ahp-faq-add">+ Add Question</button>';
    echo '<script>document.getElementById("ahp-faq-add").addEventListener("click",function(){'
        .'var d=document.createElement("div");d.className="ahp-rep-item";'
        .'d.innerHTML="<button type=\'button\' class=\'ahp-rep-del\'>✕ Remove</button>"'
        .'+"<div class=\'ahp-field\'><label>Question</label><input type=\'text\' name=\'ahp_rep[faq][][q]\'></div>"'
        .'+"<div class=\'ahp-field\'><label>Answer</label><textarea name=\'ahp_rep[faq][][a]\'></textarea></div>";'
        .'document.getElementById("ahp-faq-list").appendChild(d);'
        .'});</script>';
    _end();
    echo '</div>';
}

/* ============================================================
   SPRINT 8c — ORDER PAGE
   ============================================================ */
function ahp_order_intro_cb(): void {
    echo '<div class="ahp">';
    _sec('Page Intro','col2');
    _f('order_intro_label','Label','Order Direct');
    _f('order_intro_title','Title','Place Your Order');
    _ft('order_intro_desc','Description','');
    _end();
    echo '</div>';
}

function ahp_order_prods_cb(): void {
    $d=[1=>['Cambodian Raw Hair','60','/raw-hair/'],
        2=>['Cambodian Virgin Hair','50','/virgin-hair/'],
        3=>['HD Lace Closures & Frontals','49','/closures-frontals/']];
    echo '<div class="ahp">';
    _sec('Section Heading','col2');
    _f('order_prods_label','Label','Our Collections'); _f('order_prods_title','Title','What Would You Like to Order?');
    _end();
    foreach ($d as $i=>$c) {
        _sec("Product Card {$i}",'col2');
        _fi("order_img{$i}","Image");
        _f("order_prod{$i}_title","Title",$c[0]);
        _ft("order_prod{$i}_desc","Short Description","");
        _f("order_prod{$i}_price","From Price (no £)",$c[1]);
        _f("order_prod{$i}_url","Link URL",$c[2]);
        _end();
    }
    echo '</div>';
}

/* ============================================================
   SPRINT 8d — CARE GUIDE
   ============================================================ */
function ahp_care_intro_cb(): void {
    echo '<div class="ahp">';
    _sec('Page Intro','col2');
    _f('care_label','Label','Education & Care'); _f('care_title','Title','The Complete Hair Care Guide');
    _ft('care_desc','Intro paragraph','Everything you need to know to keep your Asantey hair looking perfect for 3–5 years.');
    _end();
    echo '<p class="ahp-hint" style="padding:0 14px 12px;">The full care guide content is edited using the main WordPress editor above (classic or block editor).</p>';
    echo '</div>';
}

/* ============================================================
   SPRINT 8e — SHOP
   ============================================================ */
function ahp_shop_intro_cb(): void {
    echo '<div class="ahp">';
    _sec('Shop Page Intro','col2');
    _f('shop_title','Page Title','Shop All Hair');
    _ft('shop_subtitle','Subtitle','Cambodian Raw · Virgin Hair · HD Lace Closures & Frontals');
    _end();
    echo '</div>';
}

/* ============================================================
   SPRINT 8f — GALLERY
   ============================================================ */
function ahp_gallery_cb(): void {
    global $post;
    $saved = get_post_meta($post->ID, '_ah_gallery_ids', true) ?: '';
    $ids   = array_filter(array_map('absint', explode(',', $saved)));
    echo '<div class="ahp">';
    _sec('Gallery Images — select, upload, drag to reorder');
    echo '<p class="ahp-hint" style="margin-bottom:10px;">Click <strong>+ Add Images</strong> to open the Media Library. Select multiple at once. Drag thumbnails to reorder them.</p>';
    echo '<div id="ahp-gal-row" style="display:flex;flex-wrap:wrap;gap:8px;padding:10px;border:2px dashed #ddd;min-height:70px;background:#fafafa;margin-bottom:10px;">';
    foreach ($ids as $id) {
        $t = wp_get_attachment_image_url($id,'thumbnail'); if(!$t) continue;
        echo "<div data-id='{$id}' style='position:relative;width:80px;height:80px;cursor:grab;'>"
           . "<img src='".esc_url($t)."' style='width:80px;height:80px;object-fit:cover;display:block;'>"
           . "<button type='button' onclick=\"this.parentNode.remove();ahpGalSync()\" style='position:absolute;top:-6px;right:-6px;width:20px;height:20px;background:#cc1818;color:#fff;border:none;border-radius:50%;font-size:13px;cursor:pointer;padding:0;line-height:20px;text-align:center;'>&times;</button>"
           . "</div>";
    }
    echo '</div>';
    echo '<button type="button" class="button button-primary" onclick="ahpGalPick()">+ Add Images</button>';
    echo '<input type="hidden" name="ahp_gallery_ids_field" id="ahp-gal-ids" value="'.esc_attr($saved).'">';
    echo '<script>
    function ahpGalPick(){
        var f=wp.media({title:"Add Gallery Images",button:{text:"Add to Gallery"},multiple:true,library:{type:"image"}});
        f.on("select",function(){
            var atts=f.state().get("selection").toJSON();
            atts.forEach(function(a){
                var t=(a.sizes&&a.sizes.thumbnail)?a.sizes.thumbnail.url:a.url;
                var d=document.createElement("div");d.dataset.id=a.id;
                d.style.cssText="position:relative;width:80px;height:80px;cursor:grab;";
                d.innerHTML="<img src=\""+t+"\" style=\"width:80px;height:80px;object-fit:cover;display:block;\">"
                    +"<button type=\"button\" onclick=\"this.parentNode.remove();ahpGalSync()\" style=\"position:absolute;top:-6px;right:-6px;width:20px;height:20px;background:#cc1818;color:#fff;border:none;border-radius:50%;font-size:13px;cursor:pointer;padding:0;line-height:20px;text-align:center;\">&times;</button>";
                document.getElementById("ahp-gal-row").appendChild(d);
            });
            ahpGalSync();
        });
        f.open();
    }
    function ahpGalSync(){
        var ids=[];
        document.querySelectorAll("#ahp-gal-row [data-id]").forEach(function(el){ids.push(el.dataset.id);});
        document.getElementById("ahp-gal-ids").value=ids.join(",");
    }
    </script>';
    if (class_exists('jQuery')) { /* sortable via WP jQuery UI */ }
    _end();
    echo '</div>';
}

/* Save gallery IDs separately */
add_action('save_post_page', function(int $pid): void {
    if (!isset($_POST['_ahp_nonce'])) return;
    if (!wp_verify_nonce($_POST['_ahp_nonce'],'ahp_'.$pid)) return;
    if (defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post',$pid)) return;
    if (isset($_POST['ahp_gallery_ids_field'])) {
        $ids = implode(',',array_filter(array_map('absint',explode(',',$_POST['ahp_gallery_ids_field']))));
        update_post_meta($pid,'_ah_gallery_ids',$ids);
    }
},15);

/* ============================================================
   SPRINT 8g — LEGAL PAGES (Shipping, Privacy, Terms)
   ============================================================ */
function ahp_legal_cb(): void {
    echo '<div class="ahp">';
    _sec('Page Details','col2');
    _f('legal_business','Business Name','Asantey Hair & Beauty');
    _f('legal_email','Contact Email','');
    _end();
    echo '<p class="ahp-hint" style="padding:0 14px 12px;">The full page content is edited using the main WordPress editor above. These fields supply the business name and email that appear in the policy text.</p>';
    echo '</div>';
}

