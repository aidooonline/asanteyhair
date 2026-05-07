<?php
/**
 * Template Name: Gallery
 *
 * HOW TO UPDATE THE GALLERY:
 * 1. WP Admin > Pages > Gallery > Edit
 * 2. In the "Gallery Images" meta box, click "+ Add / Select Images"
 * 3. Pick any images from the Media Library (select multiple at once)
 * 4. Drag thumbnails to reorder them
 * 5. Click Update — done. No code needed.
 */
defined( 'ABSPATH' ) || exit;
get_header();

echo ah_schema_breadcrumb([
    ['name' => 'Home',    'url' => home_url('/')],
    ['name' => 'Gallery', 'url' => get_permalink()],
]);

/* ── Build image list from meta box ──────────────────────────
 * Priority:
 * 1. _ah_gallery_ids meta (set via the Gallery Images meta box)
 * 2. Customizer slots ah_gal_image_1..12
 * 3. Hard-coded fallback files from assets/images/
 */
$gallery_items = [];

// 1. Meta box IDs (comma-separated attachment IDs)
$meta_ids = get_post_meta( get_the_ID(), '_ah_gallery_ids', true );
if ( $meta_ids ) {
    foreach ( array_filter( array_map( 'absint', explode( ',', $meta_ids ) ) ) as $att_id ) {
        $src = wp_get_attachment_image_url( $att_id, 'large' );
        if ( ! $src ) continue;
        $gallery_items[] = [
            'url'  => $src,
            'full' => wp_get_attachment_image_url( $att_id, 'full' ),
            'alt'  => get_post_meta( $att_id, '_wp_attachment_image_alt', true )
                      ?: get_the_title( $att_id ),
        ];
    }
}

// 2. Customizer slots
if ( empty( $gallery_items ) ) {
    for ( $ci = 1; $ci <= 12; $ci++ ) {
        $url = get_theme_mod( "ah_gal_image_{$ci}", '' );
        if ( $url ) {
            $gallery_items[] = [ 'url' => $url, 'full' => $url, 'alt' => 'Client result ' . $ci ];
        }
    }
}

// 3. Hard-coded fallback
if ( empty( $gallery_items ) ) {
    for ( $fi = 1; $fi <= 7; $fi++ ) {
        $path = get_template_directory() . '/assets/images/client-result-' . $fi . '.jpg';
        if ( file_exists( $path ) ) {
            $gallery_items[] = [
                'url'  => get_template_directory_uri() . '/assets/images/client-result-' . $fi . '.jpg',
                'full' => get_template_directory_uri() . '/assets/images/client-result-' . $fi . '.jpg',
                'alt'  => 'Asantey Hair & Beauty client result ' . $fi,
            ];
        }
    }
}
?>

<section class="page-hero">
    <div class="page-hero__bg">
        <img src="<?php echo esc_url( AH_URI . '/assets/images/hero-gallery.jpg' ); ?>"
             alt="" aria-hidden="true" loading="eager" width="1280" height="500">
    </div>
    <div class="page-hero__content">
        <span class="t-label">Client Results</span>
        <h1 class="t-h1">Real Women.<br>Real Results.</h1>
        <p>Every photo is a genuine Asantey client. No filters. No stock images. Just quality you can see.</p>
    </div>
</section>

<?php ah_breadcrumb(); ?>

<section class="s s--white">
    <div class="wrap">

        <div class="sh sh--c reveal" style="margin-bottom:3rem;">
            <span class="t-label">Client Gallery</span>
            <h2 class="t-h2">See It to Believe It</h2>
            <span class="rule rule--center"></span>
            <p class="t-body--lg" style="max-width:560px;margin:0 auto;">
                Our clients are our greatest advertisement. Join hundreds of women
                who trust Asantey Hair &amp; Beauty for their signature look.
            </p>
        </div>

        <!-- Admin tip — only visible when logged in as editor -->
        <?php if ( current_user_can('edit_pages') ) : ?>
        <div class="gallery-admin-tip">
            <strong>To update this gallery:</strong>
            <a href="<?php echo esc_url( get_edit_post_link( get_the_ID() ) ); ?>">
                Edit this page
            </a>
            and use the <strong>Gallery Images</strong> meta box to add, remove or reorder photos from your Media Library.
        </div>
        <?php endif; ?>

        <?php if ( ! empty( $gallery_items ) ) : ?>
        <div class="gallery gallery--masonry reveal">
            <?php foreach ( $gallery_items as $idx => $item ) : ?>
            <div class="gallery-item">
                <img src="<?php echo esc_url( $item['url'] ); ?>"
                     data-full="<?php echo esc_url( $item['full'] ); ?>"
                     alt="<?php echo esc_attr( $item['alt'] ); ?>"
                     loading="<?php echo $idx < 4 ? 'eager' : 'lazy'; ?>"
                     width="600" height="800">
                <div class="gallery-item__ov">
                    <span class="gallery-item__label"><?php echo esc_html( $item['alt'] ); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else : ?>
        <p style="text-align:center;color:var(--g5);padding:4rem 0;">
            No gallery images yet.
            <?php if ( current_user_can('edit_pages') ) : ?>
            <a href="<?php echo esc_url( get_edit_post_link( get_the_ID() ) ); ?>">Add images now.</a>
            <?php endif; ?>
        </p>
        <?php endif; ?>

        <div style="text-align:center;margin-top:4rem;" class="reveal">
            <p class="t-body--lg" style="margin-bottom:1.5rem;">Tag us on Instagram to be featured in our gallery.</p>
            <?php if ( get_theme_mod('ah_social_instagram') ) : ?>
            <a href="<?php echo esc_url( get_theme_mod('ah_social_instagram') ); ?>"
               class="btn btn--bk" target="_blank" rel="noopener noreferrer">
                <?php echo ah_svg('instagram'); ?> Follow on Instagram
            </a>
            <?php endif; ?>
        </div>

    </div>
</section>

<div class="cta-band dark">
    <div class="wrap"><div class="reveal">
        <span class="t-label t-label--white">Ready for Your Transformation?</span>
        <h2 class="t-h1">Your Result Could Be Next</h2>
        <p class="t-body">Browse our collections and order the hair that&rsquo;ll have everyone asking &ldquo;where did you get your hair?&rdquo;</p>
        <div class="btns" style="justify-content:center;">
            <a href="<?php echo esc_url( home_url('/shop/') ); ?>" class="btn btn--bk">
                Shop Collections <?php echo ah_svg('arrow-right'); ?>
            </a>
            <a href="<?php echo esc_url( ah_whatsapp_url() ); ?>"
               class="btn btn--outline-white" target="_blank" rel="noopener noreferrer">
                <?php echo ah_svg('whatsapp'); ?> WhatsApp Order
            </a>
        </div>
    </div></div>
</div>

<?php get_footer(); ?>
