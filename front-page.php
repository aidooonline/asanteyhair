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
    $slides[] = [
        'type'     => $type,
        'image'    => get_theme_mod( "ah_slide{$i}_image",    $i === 1 ? 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=1920&q=88&auto=format&fit=crop' : '' ),
        'video'    => get_theme_mod( "ah_slide{$i}_video",    '' ),
        'label'    => get_theme_mod( "ah_slide{$i}_label",    $i === 1 ? 'Premium Cambodian Hair Extensions' : '' ),
        'title'    => get_theme_mod( "ah_slide{$i}_title",    $i === 1 ? 'Luxury Hair.' : '' ),
        'italic'   => get_theme_mod( "ah_slide{$i}_italic",   $i === 1 ? 'Real Results.' : '' ),
        'sub'      => get_theme_mod( "ah_slide{$i}_sub",      $i === 1 ? 'Premium Cambodian Raw and Virgin Hair Extensions — crafted for women who demand quality that lasts 3–5 years.' : '' ),
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
        'label'    => 'Premium Cambodian Hair Extensions',
        'title'    => 'Luxury Hair.',
        'italic'   => 'Real Results.',
        'sub'      => 'Premium Cambodian Raw and Virgin Hair Extensions — crafted for women who demand quality that lasts 3–5 years.',
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
        $is_video = $slide['type'] === 'video' && $slide['video'];
        $is_youtube = $is_video && ( strpos($slide['video'], 'youtube') !== false || strpos($slide['video'], 'youtu.be') !== false );
        $is_mp4    = $is_video && ! $is_youtube;
    ?>
    <div class="hs-slide<?php echo $idx === 0 ? ' hs-slide--active' : ''; ?>"
         data-index="<?php echo $idx; ?>">

        <!-- Background: image or video -->
        <div class="hs-slide__bg">
            <?php if ( $is_youtube ) :
                // Extract YouTube ID
                preg_match('/(?:v=|\/embed\/|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $slide['video'], $yt);
                $yt_id = $yt[1] ?? '';
                ?>
                <iframe class="hs-slide__video"
                    src="https://www.youtube.com/embed/<?php echo esc_attr($yt_id); ?>?autoplay=1&mute=1&loop=1&playlist=<?php echo esc_attr($yt_id); ?>&controls=0&showinfo=0&modestbranding=1&rel=0&enablejsapi=1"
                    allow="autoplay; encrypted-media" allowfullscreen
                    loading="lazy" frameborder="0">
                </iframe>
            <?php elseif ( $is_mp4 ) : ?>
                <video class="hs-slide__video" autoplay muted loop playsinline preload="auto">
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
                <span class="hs-slide__eyebrow"><?php echo esc_html($slide['label']); ?></span>
            <?php endif; ?>
            <h1 class="hs-slide__title">
                <?php if ( $slide['title'] ) echo esc_html($slide['title']); ?>
                <?php if ( $slide['italic'] ) : ?><br><em><?php echo esc_html($slide['italic']); ?></em><?php endif; ?>
            </h1>
            <?php if ( $slide['sub'] ) : ?>
                <p class="hs-slide__sub"><?php echo esc_html($slide['sub']); ?></p>
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

    <div class="hs-scroll" aria-hidden="true">Scroll</div>

</section>

<!-- ============================================================ MARQUEE -->
<div class="marquee-strip marquee-strip--dark">
    <div class="marquee-track">
        <?php
        $items = [
            ['sparkle','Premium Cambodian Hair'],['gem','HD Lace Specialists'],
            ['shield','3–5 Year Lifespan'],['check','Minimal Shedding'],
            ['location','UK Based · Nottingham'],['heart','Single Donor'],
            ['sparkle','Cuticle Aligned'],['truck','Fast UK Dispatch'],
            ['sparkle','Premium Cambodian Hair'],['gem','HD Lace Specialists'],
            ['shield','3–5 Year Lifespan'],['check','Minimal Shedding'],
            ['location','UK Based · Nottingham'],['heart','Single Donor'],
            ['sparkle','Cuticle Aligned'],['truck','Fast UK Dispatch'],
        ];
        foreach($items as $item)
            echo '<span class="marquee-item">'.ah_svg($item[0]).esc_html($item[1]).'</span>';
        ?>
    </div>
</div>

<!-- ============================================================ CATEGORIES -->
<?php
$cats_label = get_theme_mod('ah_cats_label', 'Our Collections');
$cats_title = get_theme_mod('ah_cats_title', 'The Asantey Standard');
$cats_desc  = get_theme_mod('ah_cats_desc',  'Every bundle, closure, and frontal is cuticle-aligned, single-donor, and held to exacting quality standards before it reaches your door.');
?>
<section class="s s--sm" style="padding-inline:0;background:var(--ink);" aria-labelledby="cat-heading">
    <div class="wrap" style="margin-bottom:3rem;">
        <div class="sh sh--c reveal">
            <span class="t-label"><?php echo esc_html($cats_label); ?></span>
            <h2 id="cat-heading" class="t-h2"><?php echo esc_html($cats_title); ?></h2>
            <?php if($cats_desc): ?><p class="t-body" style="margin-top:1rem;"><?php echo esc_html($cats_desc); ?></p><?php endif; ?>
        </div>
    </div>
    <div class="cat-grid">
        <?php
        $cats = [
            ['label'=>'Raw Hair','title'=>'Cambodian Raw Hair','from'=>'£60','tag'=>'Unprocessed. Uncoloured. Unapologetically Premium.','image'=>AH_URI.'/assets/images/raw-body-wave.jpg','url'=>home_url('/raw-hair/')],
            ['label'=>'Virgin Hair','title'=>'Virgin Hair Bundles','from'=>'£50','tag'=>'Pure Quality. Lasting Beauty. 3–5 Year Lifespan.','image'=>AH_URI.'/assets/images/virgin-body-wave.png','url'=>home_url('/virgin-hair/')],
            ['label'=>'HD Lace','title'=>'Closures & Frontals','from'=>'£49','tag'=>'Invisible HD Lace. The Perfect Finish.','image'=>AH_URI.'/assets/images/closures-frontals-pricelist.jpg','url'=>home_url('/closures-frontals/')],
        ];
        foreach($cats as $i=>$cat): ?>
            <a href="<?php echo esc_url($cat['url']); ?>" class="cat-card reveal d<?php echo $i+1; ?>">
                <img src="<?php echo esc_url($cat['image']); ?>" alt="<?php echo esc_attr($cat['title']); ?>"
                     loading="<?php echo $i===0?'eager':'lazy'; ?>" width="640" height="853">
                <div class="cat-card__ov"></div>
                <div class="cat-card__body">
                    <span class="cat-card__label">from <?php echo esc_html($cat['from']); ?></span>
                    <h3 class="cat-card__title"><?php echo esc_html($cat['title']); ?></h3>
                    <p class="cat-card__from"><?php echo esc_html($cat['tag']); ?></p>
                    <span class="cat-card__link">Explore <?php echo ah_svg('arrow-right'); ?></span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- ============================================================ WHY ASANTEY -->
<?php
$why_label = get_theme_mod('ah_why_label', 'Why Asantey');
$why_title = get_theme_mod('ah_why_title', 'Hair That Speaks for Itself');
?>
<section class="s s--white" aria-labelledby="why-heading">
    <div class="wrap">
        <div class="sh sh--c reveal">
            <span class="t-label"><?php echo esc_html($why_label); ?></span>
            <h2 id="why-heading" class="t-h2"><?php echo esc_html($why_title); ?></h2>
        </div>
        <div class="grid-3">
            <?php
            $feats = [
                ['gem','Cambodian Origin','Single-donor Cambodian hair, ethically sourced, never chemically processed. Full cuticle alignment for unmatched softness.'],
                ['shield','3–5 Year Lifespan','Not a claim — it is what our clients experience. Invest once, wear for years. The results speak for themselves.'],
                ['sparkle','10+ Textures','Body wave to Burmese curls. Straight to deep wave. Every texture in 10"–30" lengths. Wear it your way.'],
                ['check','Minimal Shedding','Double weft, double drawn. Cuticle-aligned root to tip. The science behind hair that stays full.'],
                ['heart','HD Lace Specialists','Our HD closures and frontals melt into every skin tone. No bleaching, no tinting. Completely undetectable.'],
                ['truck','UK Based, Nottingham','Salon-based in Nottingham. Orders dispatched 2–3 business days. No import fees. No waiting.'],
            ];
            foreach($feats as $i=>$f): ?>
                <div class="feat-card reveal d<?php echo ($i%3)+1; ?>">
                    <div class="feat-card__icon"><?php echo ah_svg($f[0]); ?></div>
                    <h3 class="feat-card__title"><?php echo esc_html($f[1]); ?></h3>
                    <p class="feat-card__body"><?php echo esc_html($f[2]); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============================================================ FEATURED PRODUCTS -->
<?php
$prod_label = get_theme_mod('ah_prod_label', 'Featured Products');
$prod_title = get_theme_mod('ah_prod_title', 'Shop the Collection');
?>
<section class="s" aria-labelledby="prod-heading">
    <div class="wrap" style="max-width:var(--max);padding-inline:clamp(1rem,3vw,2.5rem);">
        <div class="sh reveal" style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
            <div>
                <span class="t-label" style="display:block;margin-bottom:1rem;"><?php echo esc_html($prod_label); ?></span>
                <h2 id="prod-heading" class="t-h2"><?php echo esc_html($prod_title); ?></h2>
            </div>
            <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="btn btn--ow btn--sm">View All <?php echo ah_svg('arrow-right'); ?></a>
        </div>
        <div class="grid-4">
            <?php
            $products = get_posts(['post_type'=>'hair_product','posts_per_page'=>4,'orderby'=>'date','order'=>'DESC']);
            if($products): foreach($products as $p) ah_product_card($p); wp_reset_postdata();
            else:
                $fb=[
                    ['Cambodian Raw Hair — Body Wave','raw-hair','60','raw-body-wave.jpg','Unprocessed single-donor. 10"–30".'],
                    ['Cambodian Raw Hair — Deep Wave','raw-hair','60','raw-deep-wave.jpg','Natural S-wave. Never treated. 10"–30".'],
                    ['Virgin Hair — Body Wave','virgin-hair','50','raw-loose-wave.jpg','Pure quality. 3–5 year lifespan.'],
                    ['HD Lace Closure — 4x4','closures-frontals','51','hd-lace-sizes.png','Invisible HD lace. All textures.'],
                ];
                foreach($fb as $f): [$t,$c,$p,$img,$d]=$f; ?>
                    <article class="product-card" data-category="<?php echo esc_attr($c); ?>">
                        <div class="product-card__img"><img src="<?php echo esc_url(AH_URI.'/assets/images/'.$img); ?>" alt="<?php echo esc_attr($t); ?>" loading="lazy" width="600" height="800"><span class="product-card__badge"><?php echo esc_html(ucwords(str_replace('-',' ',$c))); ?></span></div>
                        <div class="product-card__body">
                            <span class="product-card__cat"><?php echo esc_html(ucwords(str_replace('-',' ',$c))); ?></span>
                            <h3 class="product-card__title"><?php echo esc_html($t); ?></h3>
                            <p class="product-card__desc"><?php echo esc_html($d); ?></p>
                            <div class="product-card__price">from &pound;<?php echo esc_html($p); ?> <small>per bundle</small></div>
                            <div class="product-card__actions"><a href="<?php echo esc_url(ah_whatsapp_url('Hello! I am interested in: '.$t)); ?>" class="btn btn--w btn--sm" target="_blank" rel="noopener noreferrer"><?php echo ah_svg('whatsapp'); ?> Order</a></div>
                        </div>
                    </article>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>

<!-- ============================================================ BRAND STORY SPLIT -->
<?php
$story_label  = get_theme_mod('ah_story_label', 'Our Story');
$story_title  = get_theme_mod('ah_story_title', 'The Asantey Standard');
$story_body1  = get_theme_mod('ah_story_body1', 'Founded on the belief that every woman deserves hair she is genuinely proud of. We source our Cambodian hair directly — single donor, cuticle-aligned, never chemically altered.');
$story_body2  = get_theme_mod('ah_story_body2', 'What you receive is exactly as nature intended: just better selected, better prepared, and built to last 3-5 years with the right care.');
$story_image  = get_theme_mod('ah_story_image') ?: AH_URI.'/assets/images/client-result-1.jpg';
?>
<div class="split split--dark">
    <div class="split__media">
        <img src="<?php echo esc_url($story_image); ?>" alt="<?php echo esc_attr($story_title); ?>" loading="lazy" width="800" height="1000">
    </div>
    <div class="split__body split--dark reveal">
        <span class="t-label"><?php echo esc_html($story_label); ?></span>
        <h2 class="t-h2" style="color:var(--paper);margin-top:1.125rem;"><?php echo esc_html($story_title); ?></h2>
        <div class="rule rule--gold" style="margin-top:1.5rem;"></div>
        <?php if($story_body1): ?><p class="t-body--lg" style="margin-top:1.5rem;"><?php echo esc_html($story_body1); ?></p><?php endif; ?>
        <?php if($story_body2): ?><p class="t-body" style="margin-top:1rem;"><?php echo esc_html($story_body2); ?></p><?php endif; ?>
        <div class="btns" style="margin-top:2.5rem;">
            <a href="<?php echo esc_url(home_url('/about/')); ?>" class="btn btn--ow">Our Story <?php echo ah_svg('arrow-right'); ?></a>
        </div>
    </div>
</div>

<!-- ============================================================ CLIENT RESULTS -->
<?php
$gal_label = get_theme_mod('ah_gal_label', 'Real Women. Real Results.');
$gal_title = get_theme_mod('ah_gal_title', 'See It to Believe It');
?>
<section class="s" aria-labelledby="results-heading">
    <div class="wrap">
        <div class="sh sh--c reveal">
            <span class="t-label"><?php echo esc_html($gal_label); ?></span>
            <h2 id="results-heading" class="t-h2"><?php echo esc_html($gal_title); ?></h2>
        </div>
        <div class="gallery reveal">
            <?php for($i=1;$i<=6;$i++): ?>
                <div class="gallery-item">
                    <img src="<?php echo esc_url(AH_URI.'/assets/images/client-result-'.$i.'.jpg'); ?>"
                         alt="Asantey Hair and Beauty — Client result <?php echo $i; ?>"
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
$test_label = get_theme_mod('ah_test_label', 'Client Love');
$test_title = get_theme_mod('ah_test_title', 'What Our Clients Say');
$tests = [
    [get_theme_mod('ah_test1_quote','I have been buying hair for over 10 years and Asantey is hands down the best quality I have ever experienced. No shedding, silky soft, and took colour perfectly.'), get_theme_mod('ah_test1_author','Naomi A., London'), 5],
    [get_theme_mod('ah_test2_quote','My 28 inch raw body wave bundle is still going strong 2 years later. Worth every penny.'), get_theme_mod('ah_test2_author','Blessing O., Birmingham'), 5],
    [get_theme_mod('ah_test3_quote','The HD lace frontal is unreal. My stylist could not believe it was not my natural hairline. Ordered on WhatsApp and received it in 2 days.'), get_theme_mod('ah_test3_author','Jade K., Manchester'), 5],
];
?>
<section class="s" aria-labelledby="test-heading">
    <div class="wrap">
        <div class="sh sh--c reveal">
            <span class="t-label"><?php echo esc_html($test_label); ?></span>
            <h2 id="test-heading" class="t-h2"><?php echo esc_html($test_title); ?></h2>
        </div>
        <div class="grid-3">
            <?php foreach($tests as $i=>$t): ?>
                <div class="tcard reveal d<?php echo $i+1; ?>">
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
$cta_title = get_theme_mod('ah_cta_title', 'Your Best Hair Starts Here');
$cta_body  = get_theme_mod('ah_cta_body',  'Browse our full collection or order directly on WhatsApp. We guide you through every step.');
$cta_btn1  = get_theme_mod('ah_cta_btn1',  'Shop Collections');
$cta_btn1u = get_theme_mod('ah_cta_btn1_url', home_url('/shop/'));
$cta_btn2  = get_theme_mod('ah_cta_btn2',  'WhatsApp Order');
?>
<div class="cta-band dark">
    <div class="wrap wrap--narrow reveal">
        <span class="t-label">Ready to Elevate Your Look?</span>
        <h2><?php echo esc_html($cta_title); ?></h2>
        <p><?php echo esc_html($cta_body); ?></p>
        <div class="btns" style="justify-content:center;">
            <a href="<?php echo esc_url($cta_btn1u); ?>" class="btn btn--w">
                <?php echo esc_html($cta_btn1); ?> <?php echo ah_svg('arrow-right'); ?>
            </a>
            <a href="<?php echo esc_url(ah_whatsapp_url()); ?>" class="btn btn--ow" target="_blank" rel="noopener noreferrer">
                <?php echo ah_svg('whatsapp'); ?> <?php echo esc_html($cta_btn2); ?>
            </a>
            <a href="https://asanteyhair.as.me/" class="btn btn--ow" target="_blank" rel="noopener noreferrer">
                Book Appointment
            </a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
