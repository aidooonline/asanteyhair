<?php
/**
 * Template Name: Gallery
 *
 * HOW TO UPDATE THE GALLERY:
 * 1. Go to WP Admin > Pages > Gallery > Edit
 * 2. In the page editor, add a Gallery block (Gutenberg) or use Insert > Add Media (Classic)
 * 3. Upload or select your images, insert as a gallery
 * 4. Click Update
 *
 * FALLBACK: If no images are added in the editor, the page shows
 * images attached to this page (uploaded via the page's Featured Image
 * or Media Library while editing this page).
 *
 * FURTHER FALLBACK: Shows the default client-result images from the theme folder.
 */
defined( 'ABSPATH' ) || exit;
get_header();

echo ah_schema_breadcrumb([
    ['name'=>'Home',    'url'=>home_url('/')],
    ['name'=>'Gallery', 'url'=>get_permalink()],
]);

/* ── Gather gallery images ───────────────────────────────────
 * Priority order:
 * 1. Images attached to this page via WP Media (page attachments)
 * 2. Customizer gallery slots (ah_gal_image_1 ... ah_gal_image_12)
 * 3. Hard-coded fallback files from assets/images/
 */

// 1. Page attachment images (uploaded when editing this page)
$page_images = get_attached_media( 'image', get_the_ID() );

// 2. Customizer slots (up to 12)
$customizer_images = [];
for ( $ci = 1; $ci <= 12; $ci++ ) {
    $val = get_theme_mod( "ah_gal_image_{$ci}", '' );
    if ( $val ) $customizer_images[] = [ 'url' => $val, 'alt' => 'Asantey Hair & Beauty client result ' . $ci ];
}

// 3. Hard-coded fallback
$fallback_images = [];
for ( $fi = 1; $fi <= 7; $fi++ ) {
    $path = get_template_directory() . '/assets/images/client-result-' . $fi . '.jpg';
    if ( file_exists( $path ) ) {
        $fallback_images[] = [
            'url' => get_template_directory_uri() . '/assets/images/client-result-' . $fi . '.jpg',
            'alt' => 'Asantey Hair & Beauty client result ' . $fi,
        ];
    }
}

// Build final image list
$gallery_items = [];

if ( ! empty( $page_images ) ) {
    foreach ( $page_images as $att ) {
        $gallery_items[] = [
            'url' => wp_get_attachment_image_url( $att->ID, 'large' ),
            'full'=> wp_get_attachment_image_url( $att->ID, 'full' ),
            'alt' => get_post_meta( $att->ID, '_wp_attachment_image_alt', true ) ?: get_the_title( $att->ID ),
        ];
    }
} elseif ( ! empty( $customizer_images ) ) {
    foreach ( $customizer_images as $img ) {
        $gallery_items[] = [ 'url' => $img['url'], 'full' => $img['url'], 'alt' => $img['alt'] ];
    }
} else {
    foreach ( $fallback_images as $img ) {
        $gallery_items[] = [ 'url' => $img['url'], 'full' => $img['url'], 'alt' => $img['alt'] ];
    }
}
?>

<!-- ── HERO ──────────────────────────────────────────────── -->
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

<!-- ── GALLERY ────────────────────────────────────────────── -->
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

        <?php if ( ! empty( $gallery_items ) ) : ?>
        <div class="gallery gallery--masonry reveal">
            <?php foreach ( $gallery_items as $idx => $item ) : ?>
            <div class="gallery-item">
                <img src="<?php echo esc_url( $item['url'] ); ?>"
                     data-full="<?php echo esc_url( $item['full'] ?? $item['url'] ); ?>"
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
        <div style="text-align:center;padding:4rem 0;color:var(--g5);">
            <p>No gallery images yet. <a href="<?php echo esc_url( admin_url('post.php?post='.get_the_ID().'&action=edit') ); ?>">Add images in the page editor.</a></p>
        </div>
        <?php endif; ?>

        <!-- How to update notice (visible to admins only) -->
        <?php if ( current_user_can('edit_pages') ) : ?>
        <div class="gallery-admin-tip">
            <strong>To update this gallery:</strong>
            Go to <a href="<?php echo esc_url( admin_url('post.php?post='.get_the_ID().'&action=edit') ); ?>">WP Admin &rsaquo; Pages &rsaquo; Gallery &rsaquo; Edit</a>,
            then upload your images using the <strong>Add Media</strong> button or a <strong>Gallery block</strong>, and click Update.
        </div>
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

<!-- ── CTA ───────────────────────────────────────────────── -->
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
