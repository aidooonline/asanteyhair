<?php
/**
 * Asantey Hair & Beauty — Homepage
 * All content editable via: WP Admin > Appearance > Customize > Asantey Hair & Beauty
 * For richer editing: use ACF Flexible Content blocks when ACF Pro is active
 */
get_header();

/* ============================================================
   HERO SLIDES — reads from Customizer
   Add up to 3 slides, each can be image or video
   ============================================================ */

$slides = [];
for ( $i = 1; $i <= 3; $i++ ) {
    $type = get_theme_mod( "ah_slide{$i}_type", $i === 1 ? 'image' : '' );
    if ( ! $type ) continue;
    // Video: uploaded file takes priority over URL
    $video_upload = get_theme_mod( "ah_slide{$i}_video_upload", '' );
    $video_url    = get_theme_mod( "ah_slide{$i}_video",        '' );
    $video        = $video_upload ?: $video_url;
    $slides[] = [
        'type'     => $type,
        'image'    => get_theme_mod( "ah_slide{$i}_image",    $i === 1 ? 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=1920&q=88&auto=format&fit=crop' : '' ),
        'video'    => $video,
        'muted'    => get_theme_mod( "ah_slide{$i}_muted",    'muted' ),
        'duration' => intval( get_theme_mod( "ah_slide{$i}_duration", '6' ) ) ?: 6,
        'label'    => get_theme_mod( "ah_slide{$i}_label",    $i === 1 ? 'Premium Cambodian Hair Extensions' : '' ),
        'title'    => get_theme_mod( "ah_slide{$i}_title",    $i === 1 ? 'Luxury Hair.' : '' ),
        'italic'   => get_theme_mod( "ah_slide{$i}_italic",   $i === 1 ? 'Real Results.' : '' ),
        'sub'      => get_theme_mod( "ah_slide{$i}_sub",      $i === 1 ? 'Premium Cambodian Raw and Virgin Hair Extensions -- crafted for women who demand quality that lasts 3-5 years.' : '' ),
        'cta1'     => get_theme_mod( "ah_slide{$i}_cta1",     $i === 1 ? 'Shop Collections' : '' ),
        'cta1_url' => get_theme_mod( "ah_slide{$i}_cta1_url", $i === 1 ? home_url('/shop/') : '' ),
        'cta2'     => get_theme_mod( "ah_slide{$i}_cta2",     $i === 1 ? 'Order on WhatsApp' : '' ),
    ];
}
if ( empty($slides) ) {
    $slides[] = [
        'type'     => 'image',
        'image'    => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=1920&q=88&auto=format&fit=crop',
        'video'    => '',
        'muted'    => 'muted',
        'duration' => 6,
        'label'    => 'Premium Cambodian Hair Extensions',
        'title'    => 'Luxury Hair.',
        'italic'   => 'Real Results.',
        'sub'      => 'Premium Cambodian Raw and Virgin Hair Extensions -- crafted for women who demand quality that lasts 3-5 years.',
        'cta1'     => 'Shop Collections',
        'cta1_url' => home_url('/shop/'),
        'cta2'     => 'Order on WhatsApp',
    ];
}

$slide_count = count($slides);

echo ah_schema_breadcrumb([['name'=>'Home','url'=>home_url('/')]]);
?>

<!-- ============================================================ HERO SLIDER -->
<section class="hero-slider" aria-label="Hero" id="hero-slider">

    <?php foreach ( $slides as $idx => $slide ) :
        $is_video   = $slide['type'] === 'video' && $slide['video'];
        $is_youtube = $is_video && ( strpos($slide['video'], 'youtube') !== false || strpos($slide['video'], 'youtu.be') !== false );
        $is_mp4     = $is_video && ! $is_youtube;
        $muted      = $slide['muted'] === 'muted';
    ?>
    <div class="hs-slide<?php echo $idx === 0 ? ' hs-slide--active' : ''; ?>"
         data-index="<?php echo $idx; ?>"
         data-type="<?php echo $is_video ? 'video' : 'image'; ?>"
         data-duration="<?php echo esc_attr($slide['duration']); ?>"
         data-muted="<?php echo $muted ? 'true' : 'false'; ?>">

        <!-- Background: image or video -->
        <div class="hs-slide__bg">
            <?php if ( $is_youtube ) :
                preg_match('/(?:v=|\/embed\/|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $slide['video'], $yt);
                $yt_id = $yt[1] ?? '';
                ?>
                <?php if ( $slide['image'] ) : ?>
                <img class="hs-slide__fallback"
                     src="<?php echo esc_url($slide['image']); ?>"
                     alt="" aria-hidden="true"
                     loading="<?php echo $idx === 0 ? 'eager' : 'lazy'; ?>"
                     fetchpriority="<?php echo $idx === 0 ? 'high' : 'auto'; ?>"
                     width="1920" height="1080">
                <?php endif; ?>
                <iframe class="hs-slide__video hs-yt"
                    id="hs-yt-<?php echo $idx; ?>"
                    src="https://www.youtube-nocookie.com/embed/<?php echo esc_attr($yt_id); ?>?autoplay=<?php echo $idx === 0 ? '1' : '0'; ?>&mute=<?php echo $muted ? '1' : '0'; ?>&loop=1&playlist=<?php echo esc_attr($yt_id); ?>&controls=0&showinfo=0&modestbranding=1&rel=0&enablejsapi=1"
                    allow="autoplay; encrypted-media" allowfullscreen
                    loading="<?php echo $idx === 0 ? 'eager' : 'lazy'; ?>" frameborder="0">
                </iframe>
            <?php elseif ( $is_mp4 ) : ?>
                <?php if ( $slide['image'] ) : ?>
                <img class="hs-slide__fallback"
                     src="<?php echo esc_url($slide['image']); ?>"
                     alt="" aria-hidden="true"
                     loading="<?php echo $idx === 0 ? 'eager' : 'lazy'; ?>"
                     fetchpriority="<?php echo $idx === 0 ? 'high' : 'auto'; ?>"
                     width="1920" height="1080">
                <?php endif; ?>
                <video class="hs-slide__video hs-mp4"
                       autoplay <?php echo $muted ? 'muted' : ''; ?> loop playsinline preload="auto"
                       <?php if ($slide['image']) echo 'poster="' . esc_url($slide['image']) . '"'; ?>>
                    <source src="<?php echo esc_url($slide['video']); ?>" type="video/mp4">
                </video>
            <?php elseif ( $slide['image'] ) : ?>
                <img src="<?php echo esc_url($slide['image']); ?>"
                     alt="<?php echo esc_attr($slide['title']); ?>"
                     loading="<?php echo $idx === 0 ? 'eager' : 'lazy'; ?>"
                     fetchpriority="<?php echo $idx === 0 ? 'high' : 'auto'; ?>"
                     width="1920" height="1080">
            <?php endif; ?>
        </div>

        <div class="hs-slide__overlay"></div>

        <!-- Content -->
        <div class="hs-slide__content">
            <?php if ( $slide['label'] ) : ?>
                <span class="hs-slide__eyebrow"><?php echo esc_html( wp_specialchars_decode( $slide['label'] ) ); ?></span>
            <?php endif; ?>
            <h1 class="hs-slide__title">
                <?php if ( $slide['title'] ) echo esc_html( wp_specialchars_decode( $slide['title'] ) ); ?>
                <?php if ( $slide['italic'] ) : ?><br><em><?php echo esc_html( wp_specialchars_decode( $slide['italic'] ) ); ?></em><?php endif; ?>
            </h1>
            <?php if ( $slide['sub'] ) : ?>
                <p class="hs-slide__sub"><?php echo esc_html( wp_specialchars_decode( $slide['sub'] ) ); ?></p>
            <?php endif; ?>
            <div class="btns">
                <?php if ( $slide['cta1'] ) : ?>
                    <a href="<?php echo esc_url($slide['cta1_url'] ?: home_url('/shop/')); ?>" class="btn btn--w">
                        <?php echo esc_html($slide['cta1']); ?> <?php echo ah_svg('arrow-right'); ?>
                    </a>
                <?php endif; ?>
                <?php if ( $slide['cta2'] ) : ?>
                    <a href="<?php echo esc_url(ah_whatsapp_url('Hello! I would like to order hair extensions.')); ?>"
                       class="btn btn--ow" target="_blank" rel="noopener noreferrer">
                        <?php echo ah_svg('whatsapp'); ?> <?php echo esc_html($slide['cta2']); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>

    </div>
    <?php endforeach; ?>

    <!-- Mute toggle (shown only when a video slide is active) -->
    <button class="hs-mute" id="hs-mute" aria-label="Toggle sound" data-state="muted" style="display:none;">
        <svg class="hs-mute__on" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>
        <svg class="hs-mute__off" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><line x1="23" y1="9" x2="17" y2="15"/><line x1="17" y1="9" x2="23" y2="15"/></svg>
    </button>

    <!-- Slider navigation dots (only if multiple slides) -->
    <?php if ( $slide_count > 1 ) : ?>
        <div class="hs-dots" aria-label="Slide navigation">
            <?php for ( $d = 0; $d < $slide_count; $d++ ) : ?>
                <button class="hs-dot<?php echo $d === 0 ? ' hs-dot--active' : ''; ?>"
                        data-slide="<?php echo $d; ?>"
                        aria-label="Go to slide <?php echo $d + 1; ?>"></button>
            <?php endfor; ?>
        </div>
        <button class="hs-prev" aria-label="Previous slide">&#8249;</button>
        <button class="hs-next" aria-label="Next slide">&#8250;</button>
    <?php endif; ?>

    <!-- Progress bar -->
    <div class="hs-progress"><div class="hs-progress__bar" id="hs-progress-bar"></div></div>

    <div class="hs-scroll" aria-hidden="true">Scroll</div>

</section>

<!-- ============================================================ MARQUEE -->
<div class="marquee-strip marquee-strip--dark">
    <div class="marquee-track">
        <?php
        // Read from repeater (set via Homepage > Marquee Strip meta box)
        $_marq_rows = ah_opt_repeater('marquee');
        if (!empty($_marq_rows)) {
            $_marq_items = array_filter($_marq_rows, fn($r) => !empty($r['text']));
        } else {
            // Fall back to old textarea format
            $marquee_raw = ah_opt('marquee_items', "sparkle|Premium Cambodian Hair\ngem|HD Lace Specialists\nshield|3-5 Year Lifespan\ncheck|Minimal Shedding\nlocation|UK Based - Nottingham\nheart|Single Donor\nsparkle|Cuticle Aligned\ntruck|Fast UK Dispatch");
            $_marq_items = [];
            foreach (array_filter(array_map('trim', explode("\n", $marquee_raw))) as $line) {
                $parts = explode('|', $line, 2);
                $_marq_items[] = ['icon' => trim($parts[0] ?? 'sparkle'), 'text' => trim($parts[1] ?? '')];
            }
            $_marq_items = array_filter($_marq_items, fn($r) => !empty($r['text']));
        }
        // Double items for seamless infinite scroll
        $_all = array_merge(array_values($_marq_items), array_values($_marq_items));
        foreach ($_all as $item):
            $icon  = $item['icon'] ?? 'sparkle';
            $label = $item['text'] ?? '';
            if (!$label) continue;
        ?>
            <span class="marquee-item"><?php echo ah_svg($icon); ?><?php echo esc_html($label); ?></span>
        <?php endforeach; ?>
    </div>
</div>

<!-- ============================================================ CATEGORIES -->
<?php
$cats_label = ah_opt('cats_label','Our Collections');
$cats_title = ah_opt('cats_title','The Asantey Standard');
$cats_desc  = ah_opt('cats_desc','Every bundle, closure, and frontal is cuticle-aligned, single-donor, and held to exacting quality standards before it reaches your door.');

$cat_defaults = [
    1 => ['label'=>'Raw Hair','title'=>'Cambodian Raw Hair','from'=>'60','tag'=>'Unprocessed. Uncoloured. Unapologetically Premium.','url'=>'/raw-hair/','img'=>'raw-body-wave.jpg'],
    2 => ['label'=>'Virgin Hair','title'=>'Virgin Hair Bundles','from'=>'50','tag'=>'Pure Quality. Lasting Beauty. 3-5 Year Lifespan.','url'=>'/virgin-hair/','img'=>'virgin-body-wave.png'],
    3 => ['label'=>'HD Lace','title'=>'Closures & Frontals','from'=>'49','tag'=>'Invisible HD Lace. The Perfect Finish.','url'=>'/closures-frontals/','img'=>'closures-frontals-pricelist.jpg'],
];
?>
<section class="s s--sm" style="padding-inline:0;background:var(--ink);" aria-labelledby="cat-heading">
    <div class="wrap" style="margin-bottom:3rem;">
        <div class="sh sh--c reveal">
            <span class="t-label"><?php echo esc_html( wp_specialchars_decode( $cats_label, ENT_QUOTES ) ); ?></span>
            <h2 id="cat-heading" class="t-h2"><?php echo esc_html( wp_specialchars_decode( $cats_title, ENT_QUOTES ) ); ?></h2>
            <?php if($cats_desc): ?><p class="t-body" style="margin-top:1rem;"><?php echo esc_html( wp_specialchars_decode( $cats_desc, ENT_QUOTES ) ); ?></p><?php endif; ?>
        </div>
    </div>
    <div class="cat-grid">
        <?php foreach($cat_defaults as $i => $d):
            $title = get_theme_mod("ah_cat{$i}_title", $d['title']);
            $tag   = get_theme_mod("ah_cat{$i}_tag",   $d['tag']);
            $from  = get_theme_mod("ah_cat{$i}_from",  $d['from']);
            $image = ah_opt_img("cat{$i}_image")['url'] ?: AH_URI.'/assets/images/'.$d['img'];
            $url   = get_theme_mod("ah_cat{$i}_url",   $d['url']);
            $url   = ( strpos($url, 'http') === 0 ) ? $url : home_url($url);
        ?>
            <a href="<?php echo esc_url($url); ?>" class="cat-card reveal d<?php echo $i; ?>">
                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>"
                     loading="<?php echo $i===1?'eager':'lazy'; ?>" width="640" height="853">
                <div class="cat-card__ov"></div>
                <div class="cat-card__body">
                    <span class="cat-card__label">from &pound;<?php echo esc_html( wp_specialchars_decode( $from, ENT_QUOTES ) ); ?></span>
                    <h3 class="cat-card__title"><?php echo esc_html( wp_specialchars_decode( $title, ENT_QUOTES ) ); ?></h3>
                    <p class="cat-card__from"><?php echo esc_html( wp_specialchars_decode( $tag, ENT_QUOTES ) ); ?></p>
                    <span class="cat-card__link">Explore <?php echo ah_svg('arrow-right'); ?></span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- ============================================================ WHY ASANTEY -->
<?php
$why_label = ah_opt('why_label','Why Asantey');
$why_title = ah_opt('why_title','Hair That Speaks for Itself');

$feat_defaults = [
    1 => ['icon'=>'gem',     'title'=>'Cambodian Origin',    'body'=>'Single-donor Cambodian hair, ethically sourced, never chemically processed. Full cuticle alignment for unmatched softness.'],
    2 => ['icon'=>'shield',  'title'=>'3-5 Year Lifespan',   'body'=>'Not a claim - it is what our clients experience. Invest once, wear for years. The results speak for themselves.'],
    3 => ['icon'=>'sparkle', 'title'=>'10+ Textures',        'body'=>'Body wave to Burmese curls. Straight to deep wave. Every texture in 10"-30" lengths. Wear it your way.'],
    4 => ['icon'=>'check',   'title'=>'Minimal Shedding',    'body'=>'Double weft, double drawn. Cuticle-aligned root to tip. The science behind hair that stays full.'],
    5 => ['icon'=>'heart',   'title'=>'HD Lace Specialists', 'body'=>'Our HD closures and frontals melt into every skin tone. No bleaching, no tinting. Completely undetectable.'],
    6 => ['icon'=>'truck',   'title'=>'UK Based, Nottingham','body'=>'Salon-based in Nottingham. Orders dispatched 2-3 business days. No import fees. No waiting.'],
];
?>
<section class="s s--white s--slim" aria-labelledby="why-heading">
    <div class="wrap">
        <div class="sh sh--c reveal">
            <span class="t-label"><?php echo esc_html( wp_specialchars_decode( $why_label, ENT_QUOTES ) ); ?></span>
            <h2 id="why-heading" class="t-h2"><?php echo esc_html( wp_specialchars_decode( $why_title, ENT_QUOTES ) ); ?></h2>
        </div>
        <div class="grid-3 why-grid">
            <?php
            $shown = 0;
            foreach($feat_defaults as $i => $d):
                if ( $shown >= 3 ) break;
                $icon  = get_theme_mod("ah_feat{$i}_icon",  $d['icon']);
                $title = get_theme_mod("ah_feat{$i}_title", $d['title']);
                $body  = get_theme_mod("ah_feat{$i}_body",  $d['body']);
                if ( ! $title ) continue;
                $shown++;
            ?>
                <div class="feat-card feat-card--slim reveal d<?php echo $shown; ?>">
                    <div class="feat-card__icon"><?php echo ah_svg($icon); ?></div>
                    <h3 class="feat-card__title"><?php echo esc_html( wp_specialchars_decode( $title, ENT_QUOTES ) ); ?></h3>
                    <p class="feat-card__body"><?php echo esc_html( wp_specialchars_decode( $body, ENT_QUOTES ) ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============================================================ FEATURED PRODUCTS -->
<?php
$prod_label = ah_opt('prod_label','Featured Products');
$prod_title = ah_opt('prod_title','Shop the Collection');

// Query WooCommerce featured products
$wfp_args = [
    'post_type'      => 'product',
    'posts_per_page' => 4,
    'post_status'    => 'publish',
    'tax_query'      => [[
        'taxonomy' => 'product_visibility',
        'field'    => 'name',
        'terms'    => 'featured',
    ]],
    'orderby'        => 'date',
    'order'          => 'DESC',
];
$wfp_query   = class_exists('WooCommerce') ? new WP_Query($wfp_args) : null;
$wfp_has_wc  = $wfp_query && $wfp_query->have_posts();
?>
<section class="s" aria-labelledby="prod-heading">
    <div class="wrap" style="max-width:var(--max);padding-inline:clamp(1rem,3vw,2.5rem);">
        <div class="sh reveal" style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:2.5rem;">
            <div>
                <span class="t-label" style="display:block;margin-bottom:1rem;"><?php echo esc_html( wp_specialchars_decode( $prod_label, ENT_QUOTES ) ); ?></span>
                <h2 id="prod-heading" class="t-h2"><?php echo esc_html( wp_specialchars_decode( $prod_title, ENT_QUOTES ) ); ?></h2>
            </div>
            <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="btn btn--ow btn--sm">View All <?php echo ah_svg('arrow-right'); ?></a>
        </div>

        <?php if ( $wfp_has_wc ) : ?>
        <div class="wfp-grid">
            <?php while ( $wfp_query->have_posts() ) : $wfp_query->the_post();
                global $product;
                $img_id  = $product->get_image_id();
                $img_src = $img_id ? wp_get_attachment_image_url($img_id,'woocommerce_thumbnail') : wc_placeholder_img_src();
                $cats    = strip_tags( wc_get_product_category_list(get_the_ID(),' &middot; ') );
                $price   = $product->get_price_html();
                $link    = get_permalink();
            ?>
            <a href="<?php echo esc_url($link); ?>" class="wfp-card">
                <div class="wfp-card__img">
                    <img src="<?php echo esc_url($img_src); ?>"
                         alt="<?php echo esc_attr(get_the_title()); ?>"
                         loading="lazy" width="600" height="750">
                </div>
                <div class="wfp-card__body">
                    <?php if ($cats) : ?><span class="wfp-card__cat"><?php echo $cats; ?></span><?php endif; ?>
                    <h3 class="wfp-card__name"><?php the_title(); ?></h3>
                    <div class="wfp-card__price"><?php echo $price; ?></div>
                </div>
            </a>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <?php else :
            // Fallback: custom hair_product CPT
            $cpt_products = get_posts(['post_type'=>'hair_product','posts_per_page'=>4,'meta_key'=>'_ah_is_featured','meta_value'=>'1','orderby'=>'date','order'=>'DESC']);
            if (!$cpt_products) $cpt_products = get_posts(['post_type'=>'hair_product','posts_per_page'=>4,'orderby'=>'date','order'=>'DESC']);
            if ($cpt_products) :
        ?>
        <div class="wfp-grid">
            <?php foreach($cpt_products as $p) :
                $img_id  = (int)get_post_meta($p->ID,'_ah_feat_img_id',true) ?: get_post_thumbnail_id($p->ID);
                $img_src = $img_id ? wp_get_attachment_image_url($img_id,'woocommerce_thumbnail') : '';
                $price   = get_post_meta($p->ID,'_ah_price_from',true);
                $link    = get_permalink($p->ID);
                $terms   = get_the_terms($p->ID,'hair_category');
                $cat_str = ($terms && !is_wp_error($terms)) ? $terms[0]->name : '';
            ?>
            <a href="<?php echo esc_url($link); ?>" class="wfp-card">
                <div class="wfp-card__img">
                    <?php if ($img_src) : ?>
                    <img src="<?php echo esc_url($img_src); ?>"
                         alt="<?php echo esc_attr($p->post_title); ?>"
                         loading="lazy" width="600" height="750">
                    <?php else : ?>
                    <div style="width:100%;height:100%;background:var(--mid);display:flex;align-items:center;justify-content:center;color:var(--g5);">No image</div>
                    <?php endif; ?>
                </div>
                <div class="wfp-card__body">
                    <?php if ($cat_str) : ?><span class="wfp-card__cat"><?php echo esc_html($cat_str); ?></span><?php endif; ?>
                    <h3 class="wfp-card__name"><?php echo esc_html($p->post_title); ?></h3>
                    <?php if ($price) : ?><div class="wfp-card__price">from &pound;<?php echo esc_html($price); ?></div><?php endif; ?>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else :
            // Last fallback: static cards if no products at all
            $fb=[
                ['Cambodian Raw Hair — Body Wave','raw-hair','60','feat_prod1_image','raw-body-wave.jpg'],
                ['Cambodian Raw Hair — Deep Wave','raw-hair','60','feat_prod2_image','raw-deep-wave.jpg'],
                ['Virgin Hair — Body Wave','virgin-hair','50','feat_prod3_image','raw-loose-wave.jpg'],
                ['HD Lace Closure — 4x4','closures-frontals','51','feat_prod4_image','hd-lace-sizes.png'],
            ];
        ?>
        <div class="wfp-grid">
        <?php foreach($fb as $f):[$t,$cat,$p,$opt_key,$img]=$f;$_fi=ah_opt_img($opt_key);$_src=$_fi['url']?:AH_URI.'/assets/images/'.$img;?>
            <a href="<?php echo esc_url(home_url('/'.$cat.'/')); ?>" class="wfp-card">
                <div class="wfp-card__img">
                    <img src="<?php echo esc_url($_src); ?>" alt="<?php echo esc_attr($t); ?>" loading="lazy" width="600" height="750">
                </div>
                <div class="wfp-card__body">
                    <span class="wfp-card__cat"><?php echo esc_html(ucwords(str_replace('-',' ',$cat))); ?></span>
                    <h3 class="wfp-card__name"><?php echo esc_html($t); ?></h3>
                    <div class="wfp-card__price">from &pound;<?php echo esc_html($p); ?></div>
                </div>
            </a>
        <?php endforeach; ?>
        </div>
        <?php endif; endif; ?>

    </div>
</section>

<!-- ============================================================ BRAND STORY SPLIT -->

<!-- ============================================================ CLIENT RESULTS -->
<?php
$gal_label = ah_opt('gal_label','Real Women. Real Results.');
$gal_title = ah_opt('gal_title','See It to Believe It');
?>
<section class="s" aria-labelledby="results-heading">
    <div class="wrap">
        <div class="sh sh--c reveal">
            <span class="t-label"><?php echo esc_html( wp_specialchars_decode( $gal_label, ENT_QUOTES ) ); ?></span>
            <h2 id="results-heading" class="t-h2"><?php echo esc_html( wp_specialchars_decode( $gal_title, ENT_QUOTES ) ); ?></h2>
        </div>
        <div class="gallery reveal">
            <?php for($i=1;$i<=6;$i++):
                $img = ah_opt_img("gal_image_{$i}")['url'] ?: AH_URI.'/assets/images/client-result-'.$i.'.jpg';
            ?>
                <div class="gallery-item">
                    <img src="<?php echo esc_url($img); ?>"
                         alt="Asantey Hair and Beauty - Client result <?php echo $i; ?>"
                         loading="lazy" width="480" height="640">
                    <div class="gallery-item__ov"><span class="gallery-item__icon"><?php echo ah_svg('zoom'); ?></span></div>
                </div>
            <?php endfor; ?>
        </div>
        <div style="text-align:center;margin-top:2.5rem;" class="reveal">
            <a href="<?php echo esc_url(home_url('/gallery/')); ?>" class="btn btn--ow">View Full Gallery <?php echo ah_svg('arrow-right'); ?></a>
        </div>
    </div>
</section>

<!-- ============================================================ PRICING BAND -->
<div style="background:var(--mid);border-top:1px solid rgba(255,255,255,.07);border-bottom:1px solid rgba(255,255,255,.07);padding:2.5rem var(--gap);">
    <div class="wrap" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1.5rem;">
        <div>
            <span class="t-label" style="display:block;margin-bottom:.875rem;">Transparent Pricing</span>
            <p style="font-family:var(--serif);font-size:clamp(1rem,2.5vw,1.35rem);color:rgba(255,255,255,.7);line-height:1.6;">
                Raw Hair from <strong style="color:var(--gold);">&pound;<?php echo esc_html(array_values(ah_get_pricing('raw'))[0]); ?></strong>
                &nbsp;&middot;&nbsp; Virgin Hair from <strong style="color:var(--gold);">&pound;<?php echo esc_html(array_values(ah_get_pricing('virgin'))[0]); ?></strong>
                &nbsp;&middot;&nbsp; Closures from <strong style="color:var(--gold);">&pound;<?php echo esc_html(array_values(ah_get_pricing('4x4'))[0]); ?></strong>
                &nbsp;&middot;&nbsp; Frontals from <strong style="color:var(--gold);">&pound;<?php echo esc_html(array_values(ah_get_pricing('13x4'))[0]); ?></strong>
            </p>
        </div>
        <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="btn btn--ow btn--sm">Full Price List <?php echo ah_svg('arrow-right'); ?></a>
    </div>
</div>

<!-- ============================================================ TESTIMONIALS -->
<?php
$test_label = ah_opt('test_label','Client Love');
$test_title = ah_opt('test_title','What Our Clients Say');

// Read testimonials from page-options repeater (Homepage > Testimonials in WP Admin)
// Falls back to hardcoded defaults if none saved yet
$_saved_tests = ah_opt_repeater('testimonials');
if (!empty($_saved_tests)) {
    $tests = array_map(fn($r) => [
        $r['quote']  ?? '',
        $r['author'] ?? '',
        (int)($r['stars'] ?? 5),
    ], array_filter($_saved_tests, fn($r) => !empty($r['quote'])));
} else {
    $tests = [
        [ah_opt('test1_quote','I have been buying hair for over 10 years and Asantey is hands down the best quality I have ever experienced.'), ah_opt('test1_author','Naomi A., London'), 5],
        [ah_opt('test2_quote','My 28 inch raw body wave bundle is still going strong 2 years later. Worth every penny.'), ah_opt('test2_author','Blessing O., Birmingham'), 5],
        [ah_opt('test3_quote','The HD lace frontal is unreal. My stylist could not believe it was not my natural hairline.'), ah_opt('test3_author','Jade K., Manchester'), 5],
    ];
}
?>
<section class="s" aria-labelledby="test-heading">
    <div class="wrap">
        <div class="sh sh--c reveal">
            <span class="t-label"><?php echo esc_html( wp_specialchars_decode( $test_label, ENT_QUOTES ) ); ?></span>
            <h2 id="test-heading" class="t-h2"><?php echo esc_html( wp_specialchars_decode( $test_title, ENT_QUOTES ) ); ?></h2>
        </div>
        <div class="tcard-grid">
            <?php foreach($tests as $i=>$t): ?>
                <div class="tcard reveal d<?php echo ($i%3)+1; ?>">
                    <?php echo ah_stars($t[2]); ?>
                    <p class="tcard__quote">&ldquo;<?php echo esc_html($t[0]); ?>&rdquo;</p>
                    <span class="tcard__author">&mdash; <?php echo esc_html($t[1]); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============================================================ CTA BAND -->
<?php
$cta_title = ah_opt('cta_title', 'Your Best Hair Starts Here');
$cta_body  = ah_opt('cta_body',  'Browse our full collection or order directly on WhatsApp. We guide you through every step.');
$cta_btn1  = ah_opt('cta_btn1',  'Shop Collections');
$cta_btn1u = ah_opt('cta_btn1_url', home_url('/shop/'));
$cta_btn2  = ah_opt('cta_btn2',  'WhatsApp Order');
?>
<div class="cta-band dark">
    <div class="wrap wrap--narrow reveal">
        <span class="t-label"><?php echo esc_html( ah_opt('cta_label','Ready to Elevate Your Look?') ); ?></span>
        <h2><?php echo esc_html( wp_specialchars_decode( $cta_title, ENT_QUOTES ) ); ?></h2>
        <p><?php echo esc_html( wp_specialchars_decode( $cta_body, ENT_QUOTES ) ); ?></p>
        <div class="btns" style="justify-content:center;">
            <a href="<?php echo esc_url($cta_btn1u); ?>" class="btn btn--w">
                <?php echo esc_html( wp_specialchars_decode( $cta_btn1, ENT_QUOTES ) ); ?> <?php echo ah_svg('arrow-right'); ?>
            </a>
            <a href="<?php echo esc_url(ah_whatsapp_url()); ?>" class="btn btn--ow" target="_blank" rel="noopener noreferrer">
                <?php echo ah_svg('whatsapp'); ?> <?php echo esc_html( wp_specialchars_decode( $cta_btn2, ENT_QUOTES ) ); ?>
            </a>
            <a href="<?php echo esc_url( get_theme_mod( 'ah_booking_url', 'https://asanteyhair.as.me/' ) ); ?>" class="btn btn--ow" target="_blank" rel="noopener noreferrer">
                Book Appointment
            </a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
